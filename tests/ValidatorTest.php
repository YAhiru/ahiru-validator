<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class ValidatorTest extends TestCase
{
    public function testValidate() : void
    {
        $validator = new Validator();
        $rule = new class implements RuleInterface {
            /**
             * @param mixed $value
             */
            public function isValid($value) : bool
            {
                return (bool) $value;
            }

            public function getMessage(string $attributeName) : string
            {
                return $attributeName . 'を入力してください。';
            }
        };

        $validator
            ->define('name', '名前')
            ->add($rule)
        ;
        $validator
            ->define('email', 'メールアドレス')
            ->add($rule, 'overwrite')
        ;
        $validator
            ->define('profile', 'プロフィール')
            ->add($rule)
        ;

        $result = $validator->validate(['profile' => 'hello']);

        $this->assertTrue($result->hasErrors());
        $this->assertCount(2, $result->getErrors());

        $this->assertSame('name', $result->getErrors()[0]->getKey());
        $this->assertSame('名前を入力してください。', $result->getErrors()[0]->getMessage());

        $this->assertSame('email', $result->getErrors()[1]->getKey());
        $this->assertSame('overwrite', $result->getErrors()[1]->getMessage());

        $this->assertSame(['profile' => 'hello'], $result->getValidatedValues());
    }
}
