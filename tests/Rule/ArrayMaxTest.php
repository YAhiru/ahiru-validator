<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\TestCase;
use Yahiru\Validator\Value;

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
        $this->assertTrue($this->rule->isValid(new Value(['foo', 'bar', 'baz'])));
        $this->assertTrue($this->rule->isValid(new Value([])));
        $this->assertFalse($this->rule->isValid(new Value(null)));
        $this->assertFalse($this->rule->isValid(new Value('')));
    }
}
