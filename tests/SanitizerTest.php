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
         */
        public function test_simple_object(string $type, string $data, int $res_data) {
            $obj = [
                [
                    'data' => "$data",
                    'type' => "$type"
                ]
            ];

            $res = $this->sanitizer->sanitize(json_encode($obj));
            $this->assertTrue($res);

            $res_arr = $this->sanitizer->get_sanitized_object();
            $this->assertSame($res_arr[0], $res_data);
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
    }
?>