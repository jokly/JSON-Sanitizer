<?php
    require_once __DIR__ . '/../src/Sanitizer.php';
    require_once __DIR__ . '/../src/SanitizerResponse.php';

    use PHPUnit\Framework\TestCase;
    use Sanitizer\Sanitizer;
    use SanitizerResponse\SanitizerResponse;

    class SanitizerResponseTest extends TestCase {
        private $sanitizer;

        function setUp() {
            $this->sanitizer = new Sanitizer();
        }

        /**
         * @runInSeparateProcess
         * @dataProvider simple_object_provider
         */
        function test_simple_object(string $type, $data, $res_data) {
            $obj = [[
                'data' => $data,
                'type' => $type
            ]];

            $res = $this->sanitizer->sanitize(json_encode($obj));
            $this->assertTrue($res);

            $output = SanitizerResponse::send_sanitized_object($this->sanitizer->get_sanitized_object());
            $this->expectOutputString("{\"result\":[$res_data]}");
        }

        function simple_object_provider() {
            return [
                ['int', '5', 5],
                ['int', 111, 111],
                ['float', '3.11', 3.11],
                ['phone', '8(914)000-22-11', '"79140002211"'],
            ];
        }

        /**
         * @runInSeparateProcess
         * @dataProvider object_errors_provider
         */
        function test_object_errors(string $type, $data, $error) {
            $obj = [[
                'data' => $data,
                'type' => $type
            ]];

            $res = $this->sanitizer->sanitize(json_encode($obj));
            $this->assertFalse($res);

            $output = SanitizerResponse::send_errors($this->sanitizer->get_errors());
            $this->expectOutputString("{\"errors\":[{\"msg\":$error}]}");
        }

        function object_errors_provider() {
            return [
                ['int', '3.1', '"Invalid integer: \'3.1\'"'],
                ['hello', 'hello', '"Unknown type: \'hello\'"'],
            ];
        }
    }

?>