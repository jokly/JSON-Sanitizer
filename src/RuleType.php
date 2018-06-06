<?php
    namespace RuleType;

    require_once 'SanitizerException.php';

    use Sanitizer\{ InvalidIntException, InvalidFloatException, InvalidPhoneException };

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
        if (!\preg_match('/^8\((\d{3})\)(\d{3})(\-(\d{2})){2}$/', $data))
            throw new InvalidPhoneException($data);

        $data = \str_replace(['(', ')', '-'], '', $data);
        $data[0] = '7';

        return $data;
    }

    function array_rule(array $data) : array {
        return $data;
    }

    function dict_rule(array $data) : array {
        return $data;
    }
?>