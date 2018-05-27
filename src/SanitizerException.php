<?php
    namespace SanitizerException;

    class SanitizerException extends \Exception {
        function __construct($message, $code = 0, \Exception $previous = null) {
            parent::__construct($message, $code, $previous);
        }
    }

    class InvalidJsonException extends SanitizerException {
        function __construct($code = 0, \Exception $previous = null) {
            parent::__construct('Invalid json object', 1, $previous);
        }
    }

    class UndefinedIndexException extends SanitizerException {
        function __construct($index, $code = 0, \Exception $previous = null) {
            parent::__construct("Undefinde index: '$index'", 2, $previous);
        }
    }

    class UnknownTypeException extends SanitizerException {
        function __construct($type, $code = 0, \Exception $previous = null) {
            parent::__construct("Unknown type: '$type'", 3, $previous);
        }
    }

    class InvalidIntException extends SanitizerException {
        function __construct($data, $code = 0, \Exception $previous = null) {
            parent::__construct("Invalid integer: '$data'", 4, $previous);
        }
    }
?>