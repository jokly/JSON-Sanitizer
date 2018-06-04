<?php
    require_once __DIR__ . '/../src/Sanitizer.php';

    use PHPUnit\Framework\TestCase;
    use Sanitizer\Sanitizer;

    class SanitizerTest extends TestCase {
        private $sanitizer;

        public function setUp() {
            $this->sanitizer = new Sanitizer();
        }

        private function check_object($obj, $res_data) {
            $res = $this->sanitizer->sanitize(json_encode($obj));
            $this->assertTrue($res);

            $res_arr = $this->sanitizer->get_sanitized_object();
            $this->assertEquals($res_arr[0], $res_data);
        }

        /**
         * @dataProvider int_provider
         * @dataProvider float_provider
         * @dataProvider string_provider
         * @dataProvider phone_provider
         */
        public function test_simple_object(string $type, string $data, $res_data) {
            $obj = [
                [
                    'data' => $data,
                    'type' => $type
                ]
            ];

            $this->check_object($obj, $res_data);
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

        public function string_provider() {
            $strings = [
                'Hello',
                '\ntest\n',
                '   ',
                '  here   !',
                '!@#$%^&*(())',
            ];

            $data_set = [];
            foreach($strings as $str) {
                $data_set[] = ['string', $str, $str];
            }

            return $data_set;
        }

        public function phone_provider() {
            return [
                ['phone', '8(914)432-76-00', '79144327600'],
                ['phone', '8(000)000-00-00', '70000000000'],
                ['phone', '8(999)111-55-10', '79991115510'],
            ];
        }

        /** 
         * @dataProvider array_provider
         * @dataProvider dict_provider
        */
        public function test_array_object(string $type, array $data, array $res_data) {
            $obj = [
                [
                    'data' => [],
                    'type' => $type
                ]
            ];

            foreach($data as $key => $value) {
                $obj[0]['data'][$key] = [
                    'data' => $value[0],
                    'type' => $value[1]
                ];
            }

            $this->check_object($obj, $res_data);
        }

        public function array_provider() {
            return [
                ['array:int', [], []],
                ['array:int', [['5', 'int'], ['3', 'int'], ['-1', 'int']], [5, 3, -1]],
                ['array', [], []],
                ['array', [['5', 'int'], ['5.1', 'float'], ['Hello', 'string']], [5, 5.1, 'Hello']],
                ['array', [['8(914)222-92-09', 'phone'], ['-123', 'int']], ['79142229209', -123]],
            ];
        }

        public function dict_provider() {
            return [
                ['dict', [], []],
                ['dict', ['hello' => ['Hello', 'string']], ['hello' => 'Hello']],
                ['dict', ['first' => ['5', 'int'], 'second' => ['Hello', 'string']], ['first' => 5, 'second' => 'Hello']],
                ['dict', ['float' => ['0.32', 'float'], 'phone' => ['8(914)222-92-09', 'phone']], ['float' => 0.32, 'phone' => '79142229209']],
                ['dict', [555 => ['test', 'string'], -1 => ['12', 'int'], 0 => ['1.5', 'float']], [555 => 'test', -1 => 12, 0 => 1.5]],
            ];
        }
    }
?>