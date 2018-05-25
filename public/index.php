<?php
    require_once __DIR__ . '/../src/Sanitizer.php';
    require_once __DIR__ . '/../src/ErrorPOST.php';
    require_once __DIR__ . '/../src/SanitizerException.php';

    use Sanitizer\Sanitizer;
    use SanitizerException\InvalidJsonException;

    $sanitizer = new Sanitizer();

    try {
        $sanitizer->sanitize(file_get_contents('php://input'));
    }
    catch (InvalidJsonException $e) {
        ErrorPOST\send_error($e->getMessage());
    }
?>