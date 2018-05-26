<?php
    namespace Sanitizer;

    require_once 'RuleType.php';
    require_once 'SanitizerException.php';
    
    use SanitizerException\{ SanitizerException, InvalidJsonException, UndefinedIndexException,
        UnknownTypeException };

    class Sanitizer {
        private $sanitizers = [
            'int' => 'RuleType\int_rule',
            'float' => 'RuleType\float_rule',
            'string' => 'RuleType\string_rule',
            'phone' => 'RuleType\phone_rule',
        ];

        private $sanitized_object = [];
        private $errors = [];

        public function add(string $name, $callback) {
            $this->sanitizers[$name] = $callback;
        }

        public function sanitize(string $json_str) : bool {
            $json_obj = json_decode($json_str, true);

            if (is_null($json_obj)) {
                $this->add_error(new InvalidJsonException());
                return false;
            }

            foreach ($json_obj as $elem) {
                if ($is_set_type = $this->validate_index('type', $elem)) {
                    try {
                        $function_name = $this->get_rule_func($elem['type']);
                    }
                    catch (UnknownTypeException $e) {
                        $is_set_type = false;
                        $this->add_error($e);
                    }
                }

                if ($this->validate_index('data', $elem) && $is_set_type) {
                    try {
                        $this->sanitized_object[] = $function_name($elem['data']);
                    }
                    catch (SanitizerException $e) {
                        $this->add_error($e);
                    }
                }
            }

            return count($this->errors) == 0;
        }

        public function get_errors() : array {
            return $this->errors;
        }

        public function get_sanitized_object() : array {
            return $this->sanitized_object;
        }

        private function validate_index(string $index, $element) : bool {
            if (\array_key_exists($index, $element))
                return true;

            $this->add_error(new UndefinedIndexException($index));
            return false;
        }

        private function get_rule_func(string $type) : string {
            if (\array_key_exists($type, $this->sanitizers))
                return $this->sanitizers[$type];

            throw new UnknownTypeException($type);
        }

        private function add_error(SanitizerException $e) {
            $this->errors[] = $e->getMessage();
        }
    }
?>