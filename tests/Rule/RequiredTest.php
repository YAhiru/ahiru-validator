<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\TestCase;

final class RequiredTest extends TestCase
{
    private Required $rule;

    protected function setUp() : void
    {
        $this->rule = new Required();
    }

    public function testGetMessage() : void
    {
        $this->assertSame('foo is required.', $this->rule->getMessage('foo'));
    }

    public function testIsValid() : void
    {
        $this->assertTrue($this->rule->isValid('foo'));
        $this->assertFalse($this->rule->isValid(null));
        $this->assertFalse($this->rule->isValid(''));
    }
}
