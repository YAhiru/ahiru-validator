<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class InputTest extends TestCase
{
    public function testMatch() : void
    {
        $data = [
            'key1' => 'value',
            'key2' => [1, 2, 3],
            'key3' => [
                [
                    'name' => 'foo',
                    'age' => 20,
                    'websites' => ['https://foo.com']
                ],
                [
                    'name' => 'bar',
                    'age' => 21,
                    'websites' => ['https://bar.com', 'https://baz.com']
                ],
            ]
        ];

        $input = new Input($data);
        $this->assertSame([$data['key1']], $input->match('key1'));
        $this->assertSame([$data['key2']], $input->match('key2'));
        $this->assertSame([$data['key2'][0]], $input->match('key2.0'));
        $this->assertSame([$data['key3'][1]], $input->match('key3.1'));
        $this->assertSame(
            [$data['key3'][0]['name'], $data['key3'][1]['name']],
            $input->match('key3.*.name')
        );
        $this->assertSame(
            [null, $data['key2'][0], $data['key3'][0]],
            $input->match('*.0')
        );
        $this->assertSame($data['key2'], $input->match('key2.*'));
        $this->assertSame(
            [
                $data['key3'][0]['name'], $data['key3'][0]['age'], $data['key3'][0]['websites'],
                $data['key3'][1]['name'], $data['key3'][1]['age'], $data['key3'][1]['websites']
            ],
            $input->match('key3.*.*')
        );
        $this->assertSame(
            [$data['key3'][0]['websites'][0], $data['key3'][1]['websites'][0], $data['key3'][1]['websites'][1]],
            $input->match('key3.*.websites.*')
        );
        $this->assertSame(
            [null, null, $data['key3'][0]['websites'][0], null, null, $data['key3'][1]['websites'][0]],
            $input->match('key3.*.*.0')
        );
    }
}
