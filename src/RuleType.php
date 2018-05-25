<?php
    namespace RuleType;

    // integer: ^[+-]?\d+$
    // float: ^[+-]?\d+\.?\d*$
    // string: -
    // phone: TODO

    function int_rule(string $data) : int {
        return 5;
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