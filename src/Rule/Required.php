<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;

final class Required implements RuleInterface
{
    public function isValid($value) : bool
    {
        return $value !== null && $value !== '';
    }

    public function getMessage(string $attributeName) : string
    {
        return sprintf('%1$s is required.', $attributeName);
    }
}
