<?php
    namespace RuleType;

    require_once 'SanitizerException.php';

    use SanitizerException\{ InvalidIntException, InvalidFloatException };

    // integer: ^[+-]?\d+$
    // float: ^[+-]?\d+\.?\d*$
    // string: -
    // phone: TODO

    function int_rule(string $data) : int {
        if (!\preg_match('/^[+-]?\d+$/', $data))
            throw new InvalidIntException($data);

        return \intval($data);
    }

    function float_rule(string $data) : float {
        if (!\preg_match('/^[+-]?\d+\.?\d*$/', $data))
            throw new InvalidFloatException($data);

        return \floatval($data);
    }

    function string_rule(string $data) : string {
        return \strval($data);
    }

    function phone_rule(string $data) : string {
        return '';
    }
?>