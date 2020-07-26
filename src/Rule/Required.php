<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;
use Yahiru\Validator\Value;

final class Required implements RuleInterface
{
    public function isValid(Value $value) : bool
    {
        $value = $value->getValue();

        return $value !== null && $value !== '';
    }

    public function getMessage(string $attributeName) : string
    {
        return sprintf('%1$s is required.', $attributeName);
    }
}
