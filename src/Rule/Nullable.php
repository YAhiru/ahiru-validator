<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;

final class Nullable implements RuleInterface
{
    public function isValid($value) : bool
    {
        unset($value);

        return true;
    }

    public function getMessage(string $attributeName) : string
    {
        unset($attributeName);

        return '';
    }
}
