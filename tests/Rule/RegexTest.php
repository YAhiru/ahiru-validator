<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\TestCase;
use Yahiru\Validator\Value;

final class RegexTest extends TestCase
{
    private Regex $rule;

    protected function setUp() : void
    {
        $this->rule = new Regex('/\A\d+\z/');
    }

    public function testGetMessage() : void
    {
        $this->assertSame([], $this->rule->getReplacements());
    }

    public function testIsValid() : void
    {
        $this->assertTrue($this->rule->isValid(new Value('1234')));
        $this->assertTrue($this->rule->isValid(new Value(1234)));
        $this->assertFalse($this->rule->isValid(new Value('abc')));
        $this->assertFalse($this->rule->isValid(new Value('')));
    }
}
