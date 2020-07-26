<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;
use Yahiru\Validator\TestCase;
use Yahiru\Validator\Value;

final class OverwriteMessageTest extends TestCase
{
    public function testGetMessage() : void
    {
        $orgRule = new class implements RuleInterface {
            public function isValid(Value $value) : bool
            {
                return (bool) $value->getValue();
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
            public function isValid(Value $value) : bool
            {
                return (bool) $value->getValue();
            }

            public function getMessage(string $attributeName) : string
            {
                return $attributeName;
            }
        };
        $rule = new OverwriteMessage($orgRule, 'overwrite');

        $this->assertTrue($rule->isValid(new Value('foo')));
        $this->assertFalse($rule->isValid(new Value(null)));
    }
}
