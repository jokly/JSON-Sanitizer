<?php
    namespace ErrorPOST;

    function send_errors(array $errors) {
        $json_errors = [
            'errors' => [ ]
        ];

        foreach ($errors as $error) {
            $json_errors['errors'][] = ['msg' => $error];
        }

        header('Content-Type: application/json');
        echo json_encode($json_errors);
    }
?>