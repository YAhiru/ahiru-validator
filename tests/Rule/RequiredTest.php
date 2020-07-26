<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\TestCase;
use Yahiru\Validator\Value;

final class RequiredTest extends TestCase
{
    private Required $rule;

    protected function setUp() : void
    {
        $this->rule = new Required();
    }

    public function testGetMessage() : void
    {
        $this->assertSame([], $this->rule->getReplacements());
    }

    public function testIsValid() : void
    {
        $this->assertTrue($this->rule->isValid(new Value('foo')));
        $this->assertFalse($this->rule->isValid(new Value(null)));
        $this->assertFalse($this->rule->isValid(new Value('')));
    }
}
