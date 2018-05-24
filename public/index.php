<?php
    include __DIR__ . '/../src/ErrorPOST.php';

    $data = json_decode(file_get_contents('php://input'), true);

    if (is_null($data)) {
        ErrorPOST\send_error('Invalid json object');
    }
?>