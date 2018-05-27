<?php
    namespace SanitizerResponse;

    class SanitizerResponse {
        public static function send_sanitized_object(array $sanitized_object) {
            $json_object = [
                "result" => $sanitized_object
            ];

            self::send_object($json_object);
        }

        public static function send_errors(array $errors) {
            $json_errors = [
                'errors' => []
            ];

            foreach ($errors as $error) {
                $json_errors['errors'][] = ['msg' => $error->getMessage()];
            }

            self::send_object($json_errors);
        }

        private static function send_object($object) {
            header('Content-Type: application/json');
            echo json_encode($object);
        }
    }
?>