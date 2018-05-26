<?php
    namespace Sanitizer;

    require_once 'RuleType.php';
    require_once 'SanitizerException.php';
    
    use SanitizerException\{ SanitizerException, InvalidJsonException };

    class Sanitizer {
        private $sanitizers = [
            'int' => 'RuleType\int_rule',
            'float' => 'RuleType\float_rule',
            'string' => 'RuleType\string_rule',
            'phone' => 'RuleType\phone_rule',
        ];

        private $errors = [];

        public function add(string $name, $callback) {
            $this->sanitizers[$name] = $callback;
        }

        public function sanitize(string $json_str) : bool {
            $data = json_decode($json_str, true);

            if (is_null($data)) {
                $this->add_error(new InvalidJsonException());
                return false;
            }

            return true;
        }

        public function get_errors() : array {
            return $this->errors;
        }

        private function add_error(SanitizerException $e) {
            $this->errors[] = $e->getMessage();
        }
    }
?>