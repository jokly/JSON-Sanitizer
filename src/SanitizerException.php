<?php
    namespace SanitizerException;

    class SanitizerException extends \Exception {
        function __construct($message, $code = 0, \Exception $previous = null) {
            parent::__construct($message, $code, $previous);
        }
    }

    class InvalidJsonException extends SanitizerException {
        function __construct($code = 0, \Exception $previous = null) {
            parent::__construct('Invalid json object', $code, $previous);
        }
    }

    class UndefinedIndexException extends SanitizerException {
        function __construct($index, $code = 0, \Exception $previous = null) {
            parent::__construct("Undefinde index: $index", $code, $previous);
        }
    }

    class UnknownTypeException extends SanitizerException {
        function __construct($type, $code = 0, \Exception $previous = null) {
            parent::__construct("Unknown type: $type", $code, $previous);
        }
    }

    class InvalidIntException extends SanitizerException {
        function __construct($data, $code = 0, \Exception $previous = null) {
            parent::__construct("Invalid integer: $data", $code, $previous);
        }
    }
?>