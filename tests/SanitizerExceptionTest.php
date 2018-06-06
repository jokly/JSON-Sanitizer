<?php
    require_once __DIR__ . '/../src/Sanitizer.php';
    require_once __DIR__ . '/../src/SanitizerException.php';

    use PHPUnit\Framework\TestCase;
    use Sanitizer\Sanitizer;
    use Sanitizer\{ InvalidJsonException, UndefinedIndexException, RequiredTypeException,
        UnknownTypeException, UnexpectedTypeException, InvalidIntException, InvalidFloatException,
        InvalidPhoneException };

    class SanitizerExceptionTest extends TestCase {
        private $sanitizer;

        function setUp() {
            $this->sanitizer = new Sanitizer();
        }

        function test_invalid_json() {
            $res = $this->sanitizer->sanitize('hello');

            $this->assertFalse($res);
            $this->assertTrue($this->sanitizer->get_errors()[0] instanceof InvalidJsonException);
        }
        

        /**
         * @dataProvider undefined_index_provider
         */
        function test_undefined_index(array $data) {
            $res = $this->sanitizer->sanitize(json_encode([$data]));

            $this->assertFalse($res);
            $this->assertTrue($this->sanitizer->get_errors()[0] instanceof UndefinedIndexException);
        }

        function undefined_index_provider() {
            return [
                [['type' => 'int', 'v' => 32]],
                [['data' => '5', 0 => 'hello']],
            ];
        }

        function test_required_type() {
            $obj = [[
                'data' => [
                    ['data' => 'world', 'type' => 'string'],
                    ['data' => '5', 'type' => 'int']
                ],
                'type' => 'array:string'
            ]];
            $res = $this->sanitizer->sanitize(json_encode($obj));

            $this->assertFalse($res);
            $this->assertTrue($this->sanitizer->get_errors()[0] instanceof RequiredTypeException);
        }

        function test_unknown_type() {
            $obj = [[
                'data' => '5',
                'type' => 'hello'
            ]];
            $res = $this->sanitizer->sanitize(json_encode($obj));

            $this->assertFalse($res);
            $this->assertTrue($this->sanitizer->get_errors()[0] instanceof UnknownTypeException);
        }

        /**
         * @dataProvider invalid_type_provider
         */
        function test_invalid_type(array $data, $exception_class) {
            $res = $this->sanitizer->sanitize(json_encode([$data]));

            $this->assertFalse($res);
            $this->assertTrue($this->sanitizer->get_errors()[0] instanceof $exception_class);
        }

        function invalid_type_provider() {
            return [
                [['data' => '5.1', 'type' => 'int'], InvalidIntException::class],
                [['data' => '--3.1', 'type' => 'float'], InvalidFloatException::class],
                [['data' => '2348762', 'type' => 'phone'], InvalidPhoneException::class],
                [['data' => ['2348762'], 'type' => 'string'], UnexpectedTypeException::class],
            ];
        }
    }

?>