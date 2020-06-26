<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\TestCase;

final class ArrayMaxTest extends TestCase
{
    private ArrayMax $rule;

    protected function setUp() : void
    {
        $this->rule = new ArrayMax(3);
    }

    public function testGetMessage() : void
    {
        $this->assertSame('size of foo must be smaller than 3.', $this->rule->getMessage('foo'));
    }

    public function testIsValid() : void
    {
        $this->assertTrue($this->rule->isValid(['foo', 'bar', 'baz']));
        $this->assertTrue($this->rule->isValid([]));
        $this->assertFalse($this->rule->isValid(null));
        $this->assertFalse($this->rule->isValid(''));
    }
}
