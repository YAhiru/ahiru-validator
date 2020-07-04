<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\Input;
use Yahiru\Validator\ResolvedDependsValue;
use Yahiru\Validator\TestCase;

final class DateTimeAfterTest extends TestCase
{
    public function testValidate() : void
    {
        $rule = new DateTimeAfter('');
        $this->assertFalse($rule->isValid(new ResolvedDependsValue('1970-01-01', '1970-01-01')));
        $this->assertTrue($rule->isValid(new ResolvedDependsValue('1970-01-02', '1970-01-01')));
        $this->assertTrue($rule->isValid(new ResolvedDependsValue('1970-01-01 00:00:01', '1970-01-01')));
        $this->assertTrue($rule->isValid(new ResolvedDependsValue('tomorrow', 'today')));
    }

    public function testGetDependsValue() : void
    {
        $rule = new DateTimeAfter('start_date');
        $this->assertSame(
            '1970-01-01',
            $rule->getDependsValue(new Input(['start_date' => '1970-01-01']))
        );

        $rule = new DateTimeAfter('1970-02-02');
        $this->assertSame(
            '1970-02-02',
            $rule->getDependsValue(new Input([]))
        );
    }

    public function testGetMessage() : void
    {
        $rule = new DateTimeAfter('start_date');
        $this->assertSame(
            'end_date must be a date after start_date.',
            $rule->getMessage('end_date')
        );
    }
}
