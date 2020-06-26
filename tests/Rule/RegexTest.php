<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\TestCase;

final class RegexTest extends TestCase
{
    private Regex $rule;

    protected function setUp() : void
    {
        $this->rule = new Regex('/\A\d+\z/');
    }

    public function testGetMessage() : void
    {
        $this->assertSame('foo is invalid format.', $this->rule->getMessage('foo'));
    }

    public function testIsValid() : void
    {
        $this->assertTrue($this->rule->isValid('1234'));
        $this->assertTrue($this->rule->isValid(1234));
        $this->assertFalse($this->rule->isValid('abc'));
        $this->assertFalse($this->rule->isValid(''));
    }
}
