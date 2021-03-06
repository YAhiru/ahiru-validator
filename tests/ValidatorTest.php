<?php
declare(strict_types=1);
namespace Yahiru\Validator;

use Yahiru\Validator\Rule\ArrayMax;
use Yahiru\Validator\Rule\DateTimeAfter;
use Yahiru\Validator\Rule\Nullable;
use Yahiru\Validator\Rule\Regex;
use Yahiru\Validator\Rule\Required;
use Yahiru\Validator\Rule\StringRange;

final class ValidatorTest extends TestCase
{
    public function testValidate() : void
    {
        $validator = new Validator();
        $validator
            ->define(new Keys('name'), '名前')
            ->add(new Required())
        ;
        $validator
            ->define(new Keys('email'), 'メールアドレス')
            ->add(new Required(), 'overwrite')
        ;
        $validator
            ->define(new Keys('profile'), 'プロフィール')
            ->add(new Required())
        ;

        $result = $validator->validate(['profile' => 'hello']);

        $this->assertTrue($result->hasErrors());
        $this->assertCount(2, $result->getAllErrors());

        $this->assertSame('名前 is required.', $result->getErrors(new Keys('name'))[0]);
        $this->assertSame('overwrite', $result->getErrors(new Keys('email'))[0]);
    }

    public function testNullable() : void
    {
        $validator = new Validator();

        $validator
            ->define(new Keys('name'), '名前')
            ->add(new Nullable())
            ->add(new StringRange(10, 100))
        ;

        $result = $validator->validate(['name' => null]);

        $this->assertFalse($result->hasErrors());
    }

    public function testValidateArray() : void
    {
        $validator = new Validator();
        $validator
            ->define(new Keys('tags'), 'タグ')
            ->add(new ArrayMax(3))
        ;
        $validator->define(new Keys('tags', '*'), 'タグ')
            ->add(new Regex('/\A[a-z]+\z/'))
            ->add(new StringRange(1, 3))
        ;

        $result = $validator->validate(['tags' => ['a', 'bbbb', '3', 'd']]);

        $this->assertTrue($result->hasErrors());
        $this->assertSame(
            [
                'size of タグ must be smaller than 3.',
            ],
            $result->getErrors(new Keys('tags'))
        );
        $this->assertSame(
            [
                'タグ must be between 1 and 3 characters.',
                'タグ is invalid format.',
            ],
            $result->getErrors(Keys::create('tags.*'))
        );
        $this->assertSame(
            [
                'タグ must be between 1 and 3 characters.',
            ],
            $result->getErrors(Keys::create('tags.1'))
        );
    }

    public function testValidateDependsOtherValueRule() : void
    {
        $validator = new Validator();

        $validator->define(new Keys('start_date'), '開始日');
        $validator
            ->define(new Keys('end_date'), '終了日')
            ->add(new DateTimeAfter(new Keys('start_date')))
        ;

        $result = $validator->validate([
            'start_date' => '1970-01-01',
            'end_date' => '1970-01-02',
        ]);
        $this->assertFalse($result->hasErrors());

        $result = $validator->validate([
            'start_date' => '1970-01-01',
            'end_date' => '1970-01-01',
        ]);
        $this->assertTrue($result->hasErrors());
        $this->assertSame(
            [
                '終了日 must be a date after 開始日.'
            ],
            $result->getErrors(new Keys('end_date'))
        );
    }
}
