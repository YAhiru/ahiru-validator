<?php
declare(strict_types=1);
namespace Yahiru\Validator;

use Yahiru\Validator\Rule\ArrayMax;
use Yahiru\Validator\Rule\Nullable;
use Yahiru\Validator\Rule\Regex;
use Yahiru\Validator\Rule\StringRange;

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
        $this->assertCount(2, $result->getAllErrors());

        $this->assertSame('名前を入力してください。', $result->getErrors('name')[0]);
        $this->assertSame('overwrite', $result->getErrors('email')[0]);

        $this->assertSame(['profile' => 'hello'], $result->getValidatedValues());
    }

    public function testNullable() : void
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
            ->add(new Nullable())
            ->add($rule)
        ;

        $result = $validator->validate(['name' => null]);

        $this->assertFalse($result->hasErrors());
        $this->assertSame(['name' => null], $result->getValidatedValues());
    }

    public function testValidateArray() : void
    {
        $validator = new Validator();
        $validator
            ->define('tags', 'タグ')
            ->add(new ArrayMax(3))
        ;
        $validator->define('tags.*', 'タグ')
            ->add(new Regex('/\A[a-z]+\z/'))
            ->add(new StringRange(1, 3))
        ;

        $result = $validator->validate(['tags' => ['a', 'bbbb', '3', 'd']]);

        $this->assertTrue($result->hasErrors());
        $this->assertSame(
            [
                'size of タグ must be smaller than 3.',
            ],
            $result->getErrors('tags')
        );
        $this->assertSame(
            [
                'タグ must be between 1 and 3 characters.',
                'タグ is invalid format.',
            ],
            $result->getErrors('tags.*')
        );
    }
}
