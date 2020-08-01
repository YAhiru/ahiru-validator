<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\TestCase;
use Yahiru\Validator\Value;

final class DistinctTest extends TestCase
{
    public function testIsValid() : void
    {
        $rule = new Distinct();

        $this->assertTrue($rule->isValid(new Value([0, 1])));
        $this->assertTrue($rule->isValid(new Value([null, 1])));
        $this->assertFalse($rule->isValid(new Value([1, 1])));
        $this->assertFalse($rule->isValid(new Value([null, 1, null])));
    }

    public function testGetAttributes() : void
    {
        $rule = new Distinct();

        $this->assertSame([], $rule->getAttributes());
    }
}
