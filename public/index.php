<?php
    require_once __DIR__ . '/../src/Sanitizer.php';
    require_once __DIR__ . '/../src/SanitizerResponse.php';

    use Sanitizer\Sanitizer;
    use SanitizerResponse\SanitizerResponse;

    $sanitizer = new Sanitizer();

    $res = $sanitizer->sanitize(file_get_contents('php://input'));

    if ($res) {
        SanitizerResponse::send_sanitized_object($sanitizer->get_sanitized_object());
    }
    else {
        SanitizerResponse::send_errors($sanitizer->get_errors());
    }
?>