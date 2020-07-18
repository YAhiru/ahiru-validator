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

        $this->assertMatch([new Matched($data['key1'], ['key1'])], $input->get(['key1']));
        $this->assertMatch([new Matched($data['key2'], ['key2'])], $input->get(['key2']));
        $this->assertMatch([new Matched($data['key2'][0], ['key2', '0'])], $input->get(['key2', '0']));
        $this->assertMatch([new Matched($data['key3'][1], ['key3', '1'])], $input->get(['key3', '1']));
        $this->assertMatch(
            [
                new Matched($data['key3'][0]['name'], ['key3', '0', 'name']),
                new Matched($data['key3'][1]['name'], ['key3', '1', 'name'])
            ],
            $input->get(['key3', '*', 'name'])
        );
        $this->assertMatch(
            [
                new Matched(null, ['key1', '0']),
                new Matched($data['key2'][0], ['key2', '0']),
                new Matched($data['key3'][0], ['key3', '0']),
            ],
            $input->get(['*', '0'])
        );
        $this->assertMatch(
            [
                new Matched($data['key2'][0], ['key2', '0']),
                new Matched($data['key2'][1], ['key2', '1']),
                new Matched($data['key2'][2], ['key2', '2']),
            ],
            $input->get(['key2', '*'])
        );
        $this->assertMatch(
            [
                new Matched($data['key3'][0]['name'], ['key3', '0', 'name']),
                new Matched($data['key3'][0]['age'], ['key3', '0', 'age']),
                new Matched($data['key3'][0]['websites'], ['key3', '0', 'websites']),
                new Matched($data['key3'][1]['name'], ['key3', '1', 'name']),
                new Matched($data['key3'][1]['age'], ['key3', '1', 'age']),
                new Matched($data['key3'][1]['websites'], ['key3', '1', 'websites']),
            ],
            $input->get(['key3', '*', '*'])
        );
        $this->assertMatch(
            [
                new Matched($data['key3'][0]['websites'][0], ['key3', '0', 'websites', '0']),
                new Matched($data['key3'][1]['websites'][0], ['key3', '1', 'websites', '0']),
                new Matched($data['key3'][1]['websites'][1], ['key3', '1', 'websites', '1']),
            ],
            $input->get(['key3', '*', 'websites', '*'])
        );
        $this->assertMatch(
            [
                new Matched(null, ['key3', '0', 'name', '0']),
                new Matched(null, ['key3', '0', 'age', '0']),
                new Matched($data['key3'][0]['websites'][0], ['key3', '0', 'websites', '0']),
                new Matched(null, ['key3', '1', 'name', '0']),
                new Matched(null, ['key3', '1', 'age', '0']),
                new Matched($data['key3'][1]['websites'][0], ['key3', '1', 'websites', '0']),
            ],
            $input->get(['key3', '*', '*', '0'])
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
            $this->assertSame($item->getValue(), $actual[$idx]->getValue());
            $this->assertSame($item->getKeys(), $actual[$idx]->getKeys());
        }
    }
}
