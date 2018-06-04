<?php
    namespace Sanitizer;

    require_once 'RuleType.php';
    require_once 'SanitizerException.php';
    
    use SanitizerException\{ SanitizerException, InvalidJsonException, UndefinedIndexException,
        UnknownTypeException, RequiredTypeException, InvalidTypeException };

    class Sanitizer {
        private $sanitizers = [
            'int' => 'RuleType\int_rule',
            'float' => 'RuleType\float_rule',
            'string' => 'RuleType\string_rule',
            'phone' => 'RuleType\phone_rule',
            'array' => 'RuleType\array_rule',
            'dict' => 'RuleType\dict_rule',
        ];

        private $iterable_types = [
            'array', 'dict',
        ];

        private $sanitized_object = [];
        private $errors = [];

        public function add(string $name, $callback) {
            $this->sanitizers[$name] = $callback;
        }

        public function sanitize(string $json_str) : bool {
            $json_obj = json_decode($json_str, true);

            if (\is_null($json_obj)) {
                $this->add_error(new InvalidJsonException());
                return false;
            }

            $this->sanitized_object = $this->iterate_json_object($json_obj);

            return \count($this->errors) == 0;
        }

        public function get_errors() : array {
            return $this->errors;
        }

        public function get_sanitized_object() : array {
            return $this->sanitized_object;
        }

        private function iterate_json_object($json_object, $required_type = null) : array {
            $sanitized_object = [];

            foreach ($json_object as $key => $elem) {
                if ($is_valid_type = $this->validate_index('type', $elem))
                {
                    $type = $this->parse_type($elem['type'])[0];
                    if (!\is_null($required_type) && $type !== $required_type) {
                        $this->add_error(new RequiredTypeException($type, $required_type));
                        $is_valid_type = false;
                    }

                    try {
                        list($function_name, $inner_required_type) = $this->get_rule_func($elem['type']);
                    }
                    catch (UnknownTypeException $e) {
                        $is_valid_type = false;
                        $this->add_error($e);
                    }
                }

                if ($this->validate_index('data', $elem) && $is_valid_type) {
                    try {
                        $data = $function_name($elem['data']);

                        if (\in_array($type, $this->iterable_types)) {
                            $data = $this->iterate_json_object($data, $inner_required_type);
                        }

                        $sanitized_object[$key] = $data;
                    }
                    catch (InvalidTypeException $e) {
                        $this->add_error($e);
                    }
                }
            }

            return $sanitized_object;
        }

        private function validate_index($index, $element) : bool {
            if (\array_key_exists($index, $element))
                return true;

            $this->add_error(new UndefinedIndexException($index));
            
            return false;
        }

        private function parse_type(string $type) : array {
            $composite_type = \explode(':', $type);
            
            $type = $composite_type[0];
            $required_type = \count($composite_type) == 2 ? $composite_type[1] : null;

            return [
                $type,
                $required_type
            ];
        }

        private function get_rule_func(string $type) : array {
            list($type, $required_type) = $this->parse_type($type);

            if (\array_key_exists($type, $this->sanitizers))
                return [
                    $this->sanitizers[$type],
                    $required_type
                ];

            throw new UnknownTypeException($type);
        }

        private function add_error(SanitizerException $e) {
            $this->errors[] = $e;
        }
    }
?>