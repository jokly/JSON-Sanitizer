<?php
    require_once __DIR__ . '/../src/Sanitizer.php';

    use PHPUnit\Framework\TestCase;
    use Sanitizer\Sanitizer;

    class SanitizerTest extends TestCase {
        private $sanitizer;

        public function setUp() {
            $this->sanitizer = new Sanitizer();
        }

        /**
         * @dataProvider int_provider
         * @dataProvider float_provider
         */
        public function test_simple_object(string $type, string $data, $res_data) {
            $obj = [
                [
                    'data' => "$data",
                    'type' => "$type"
                ]
            ];

            $res = $this->sanitizer->sanitize(json_encode($obj));
            $this->assertTrue($res);

            $res_arr = $this->sanitizer->get_sanitized_object();
            $this->assertEquals($res_arr[0], $res_data);
        }

        public function int_provider() {
            return [
                ['int', '5', 5],
                ['int', '+35345', 35345],
                ['int', '-90', -90],
                ['int', '0032', 32],
                ['int', '+0050', 50],
                ['int', '-0830', -830],
            ];
        }

        public function float_provider() {
            return [
                ['float', '-5', -5],
                ['float', '3.01000', 3.01],
                ['float', '+2.0031', 2.0031],
                ['float', '-9.78', -9.78],
                ['float', '-0005.9', -5.9],
                ['float', '-32.', -32],
            ];
        }
    }
?>