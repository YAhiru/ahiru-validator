<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;
use Yahiru\Validator\TestCase;

final class OverwriteMessageTest extends TestCase
{
    public function testGetMessage() : void
    {
        $orgRule = new class implements RuleInterface {
            public function isValid($value) : bool
            {
                return (bool) $value;
            }

            public function getMessage(string $attributeName) : string
            {
                return $attributeName;
            }
        };
        $rule = new OverwriteMessage($orgRule, 'overwrite');

        $this->assertSame('overwrite', $rule->getMessage('foo'));
    }

    public function testIsValid() : void
    {
        $orgRule = new class implements RuleInterface {
            public function isValid($value) : bool
            {
                return (bool) $value;
            }

            public function getMessage(string $attributeName) : string
            {
                return $attributeName;
            }
        };
        $rule = new OverwriteMessage($orgRule, 'overwrite');

        $this->assertTrue($rule->isValid('foo'));
        $this->assertFalse($rule->isValid(null));
    }
}
