<?php
declare(strict_types=1);

namespace Yahiru\Validator;

final class ValidatorTest extends TestCase
{
    public function testValidate()
    {
        $validator = new Validator();
        $rule = new class implements RuleInterface {
            public function isValid($value): bool
            {
                return false;
            }

            public function getMessage(string $attributeName): string
            {
                return $attributeName . 'を入力してください。';
            }
        };

        $validator
            ->define('name', '名前')
            ->addRule($rule)
        ;

        $result = $validator->validate([]);

        $this->assertTrue($result->hasErrors());
        $this->assertSame('名前を入力してください。', $result->getErrors()[0]);
    }
}
