<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class InputTest extends TestCase
{
    public function testFetch()
    {
        $data = [
            'key1' => 'value',
            'key2' => [1, 2, 3],
            'key3' => [
                [
                    'name' => 'foo',
                    'age' => 20
                ],
                [
                    'name' => 'bar',
                    'age' => 21
                ],
            ]
        ];

        $input = new Input($data);
        $this->assertSame($data['key1'], $input->fetch('key1'));
        $this->assertSame($data['key2'], $input->fetch('key2'));
        $this->assertSame($data['key2'][0], $input->fetch('key2.0'));
        $this->assertSame($data['key3'][1], $input->fetch('key3.1'));
        $this->assertSame(
            [$data['key3'][0]['name'], $data['key3'][1]['name']],
            $input->fetch('key3.*.name')
        );
        $this->assertSame(
            [null, $data['key2'][0], $data['key3'][0]],
            $input->fetch('*.0')
        );
        $this->assertSame($data['key2'], $input->fetch('key2.*'));
    }
}
