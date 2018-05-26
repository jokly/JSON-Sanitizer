<?php
    namespace RuleType;

    require_once 'SanitizerException.php';

    use SanitizerException\{ InvalidIntException };

    // integer: ^[+-]?\d+$
    // float: ^[+-]?\d+\.?\d*$
    // string: -
    // phone: TODO

    function int_rule(string $data) : int {
        if (!\preg_match('/^[+-]?\d+$/', $data))
            throw new InvalidIntException($data);

        return intval($data);
    }

    function float_rule(string $data) : float {
        return 5.1;
    }

    function string_rule(string $data) : string {
        return '';
    }

    function phone_rule(string $data) : string {
        return '';
    }
?>