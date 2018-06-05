<?php
    namespace SanitizerException;

    class SanitizerException extends \Exception {
        function __construct($message, $code = 0, \Exception $previous = null) {
            parent::__construct($message, $code, $previous);
        }
    }

    class InvalidJsonException extends SanitizerException {
        function __construct($code = 1, \Exception $previous = null) {
            parent::__construct('Invalid json object', $code, $previous);
        }
    }

    class UndefinedIndexException extends SanitizerException {
        function __construct($index, $code = 2, \Exception $previous = null) {
            parent::__construct("Undefinde index: '$index'", $code, $previous);
        }
    }

    class UnknownTypeException extends SanitizerException {
        function __construct($type, $code = 3, \Exception $previous = null) {
            parent::__construct("Unknown type: '$type'", $code, $previous);
        }
    }

    class RequiredTypeException extends SanitizerException {
        function __construct($type, $required_type, $code = 4, $previous = null) {
            parent::__construct("Element must be of the type '$required_type', '$type' given", $code, $previous);
        }
    }

    class UnexpectedTypeException extends SanitizerException {
        function __construct($type, $code = 5, $previous = null) {
            parent::__construct("Unexpected type: '$type'", $code, $previous);
        }
    }

    class InvalidTypeException extends SanitizerException {
        function __construct($type_string, $data, $code = 6, \Exception $previous = null) {
            parent::__construct("Invalid $type_string: '$data'", $code, $previous);
        }
    }

    class InvalidIntException extends InvalidTypeException {
        function __construct($data, $code = 7, \Exception $previous = null) {
            parent::__construct('integer', $data, $code, $previous);
        }
    }

    class InvalidFloatException extends InvalidTypeException {
        function __construct($data, $code = 8, \Exception $previous = null) {
            parent::__construct('float', $data, $code, $previous);
        }
    }

    class InvalidPhoneException extends InvalidTypeException {
        function __construct($data, $code = 9, \Exception $previous = null) {
            parent::__construct('phone', $data, $code, $previous);
        }
    }
?>