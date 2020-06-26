<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;

final class Regex implements RuleInterface
{
    private string $regex;

    public function __construct(string $regex)
    {
        $this->regex = $regex;
    }

    public function isValid($value) : bool
    {
        if (! Helper::isStringable($value)) {
            return false;
        }

        return preg_match($this->regex, (string) $value) === 1;
    }

    public function getMessage(string $attributeName) : string
    {
        return sprintf('%1$s is invalid format.', $attributeName);
    }
}
