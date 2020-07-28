<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class InputTest extends TestCase
{
    public function testGet() : void
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

        $this->assertMatch([new Matched($data['key1'], new Keys('key1'))], $input->get(new Keys('key1')));
        $this->assertMatch([new Matched($data['key2'], new Keys('key2'))], $input->get(new Keys('key2')));
        $this->assertMatch([new Matched($data['key2'][0], new Keys('key2', '0'))], $input->get(new Keys('key2', '0')));
        $this->assertMatch([new Matched($data['key3'][1], new Keys('key3', '1'))], $input->get(new Keys('key3', '1')));
        $this->assertMatch(
            [
                new Matched($data['key3'][0]['name'], new Keys('key3', '0', 'name')),
                new Matched($data['key3'][1]['name'], new Keys('key3', '1', 'name'))
            ],
            $input->get(new Keys('key3', '*', 'name'))
        );
        $this->assertMatch(
            [
                new Matched($data['key2'][0], new Keys('key2', '0')),
                new Matched($data['key3'][0], new Keys('key3', '0')),
            ],
            $input->get(new Keys('*', '0'))
        );
        $this->assertMatch(
            [
                new Matched($data['key2'][0], new Keys('key2', '0')),
                new Matched($data['key2'][1], new Keys('key2', '1')),
                new Matched($data['key2'][2], new Keys('key2', '2')),
            ],
            $input->get(new Keys('key2', '*'))
        );
        $this->assertMatch(
            [
                new Matched($data['key3'][0]['name'], new Keys('key3', '0', 'name')),
                new Matched($data['key3'][0]['age'], new Keys('key3', '0', 'age')),
                new Matched($data['key3'][0]['websites'], new Keys('key3', '0', 'websites')),
                new Matched($data['key3'][1]['name'], new Keys('key3', '1', 'name')),
                new Matched($data['key3'][1]['age'], new Keys('key3', '1', 'age')),
                new Matched($data['key3'][1]['websites'], new Keys('key3', '1', 'websites')),
            ],
            $input->get(new Keys('key3', '*', '*'))
        );
        $this->assertMatch(
            [
                new Matched($data['key3'][0]['websites'][0], new Keys('key3', '0', 'websites', '0')),
                new Matched($data['key3'][1]['websites'][0], new Keys('key3', '1', 'websites', '0')),
                new Matched($data['key3'][1]['websites'][1], new Keys('key3', '1', 'websites', '1')),
            ],
            $input->get(new Keys('key3', '*', 'websites', '*'))
        );
        $this->assertMatch(
            [
                new Matched($data['key3'][0]['websites'][0], new Keys('key3', '0', 'websites', '0')),
                new Matched($data['key3'][1]['websites'][0], new Keys('key3', '1', 'websites', '0')),
            ],
            $input->get(new Keys('key3', '*', '*', '0'))
        );

        $this->assertSame([], $input->get(new Keys('does not exists')));
    }

    public function testGetWithVoid() : void
    {
        $data = [
            'key1' => 'value',
            'key2' => [1, 2, 3],
        ];

        $input = new Input($data);

        $this->assertMatch([Matched::void(new Keys('key1', '0'))], $input->getWithVoid(new Keys('key1', '0')));
        $this->assertMatch(
            [
                Matched::void(new Keys('key1', '0')),
                new Matched(1, new Keys('key2', '0'))
            ],
            $input->getWithVoid(new Keys('*', '0'))
        );
    }

    /**
     * @param Matched[] $expected
     * @param Matched[] $actual
     */
    private function assertMatch(array $expected, array $actual) : void
    {
        $this->assertCount(count($expected), $actual);
        foreach ($expected as $idx => $item) {
            $this->assertSame($item->isVoid(), $actual[$idx]->isVoid());
            $this->assertSame($item->getValue(), $actual[$idx]->getValue());
            $this->assertSame($item->getKeys()->toArray(), $actual[$idx]->getKeys()->toArray());
        }
    }
}
