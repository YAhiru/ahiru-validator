<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;
use Yahiru\Validator\Value;

final class Distinct implements RuleInterface
{
    public function isValid(Value $value) : bool
    {
        $value = $value->getValue();
        if (! is_array($value)) {
            return true;
        }

        return count($value) === count(array_unique($value));
    }

    public function getAttributes() : array
    {
        return [];
    }
}
