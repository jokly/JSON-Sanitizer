<?php
    require_once __DIR__ . '/../src/Sanitizer.php';
    require_once __DIR__ . '/../src/SanitizerException.php';

    use PHPUnit\Framework\TestCase;
    use Sanitizer\Sanitizer;
    use Sanitizer\InvalidTypeException;

    class SanitizerCustomFunctionsTest extends TestCase {
        private $sanitizer;

        function setUp() {
            $this->sanitizer = new Sanitizer();
        }

        /**
         * @dataProvider custom_data_provider
         */
        function test_custom_rules(string $type, Closure $rule, $data, $res_data) {
            $obj = [
                [
                    'data' => $data,
                    'type' => $type
                ]
            ];

            $this->sanitizer->add($type, $rule);
            $res = $this->sanitizer->sanitize(json_encode($obj));
            $this->assertTrue($res);

            $res_arr = $this->sanitizer->get_sanitized_object();
            $this->assertEquals($res_arr[0], $res_data);
        }

        function custom_data_provider() {
            return [
                ['hey', function(string $data) {
                    if (\strpos($data, '!') === false)
                        throw new InvalidTypeException('hey', $data);

                    return $data;
                }, 'Hello World!', 'Hello World!'],
                ['arr_len', function(array $data) {
                    if (\count($data) > 2)
                        throw new InvalidTypeException('array len < 2', $data);
                    
                    return $data;
                }, [1, 2], [1, 2]],
                ['dict_key', function(array $data) {
                    if (!\array_key_exists('value', $data))
                        throw new InvalidTypeException('dict don\'t contains "value"', $dat);
                    
                    return $data;
                }, ['value' => 5, 'type' => 'int'], ['value' => 5, 'type' => 'int']]
            ];
        }
    }
?>