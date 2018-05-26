<?php
    require_once __DIR__ . '/../src/Sanitizer.php';
    require_once __DIR__ . '/../src/ErrorPOST.php';
    require_once __DIR__ . '/../src/SanitizerException.php';

    use Sanitizer\Sanitizer;
    use SanitizerException\InvalidJsonException;

    $sanitizer = new Sanitizer();

    $res = $sanitizer->sanitize(file_get_contents('php://input'));

    if ($res) {
        echo 'OK';
    }
    else {
        ErrorPOST\send_errors($sanitizer->get_errors());
    }
?>