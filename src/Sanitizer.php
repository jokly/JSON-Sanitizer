<?php
    namespace Sanitizer;

    require_once 'RuleType.php';
    require_once 'SanitizerException.php';
    
    use SanitizerException\{ InvalidJsonException };

    class Sanitizer {
        private $sanitizers = [
            'int' => 'RuleType\int_rule',
            'float' => 'RuleType\float_rule',
            'string' => 'RuleType\string_rule',
            'phone' => 'RuleType\phone_rule',
        ];

        function add(string $name, $callback) {
            $this->sanitizers[$name] = $callback;
        }

        function sanitize(string $json_str) {
            $data = json_decode($json_str, true);

            if (is_null($data)) {
                throw new InvalidJsonException();
            }
        }
    }
?>