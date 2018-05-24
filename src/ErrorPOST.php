<?php
    namespace ErrorPOST;

    function send_error(string $msg) {
        $json_error = [
            'error' => [
                'msg' => $msg
            ]
        ];

        header('Content-Type: application/json');
        echo json_encode($json_error);
    }
?>