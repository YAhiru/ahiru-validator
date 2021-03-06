<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;
use Yahiru\Validator\Value;

final class Regex implements RuleInterface
{
    private string $regex;

    public function __construct(string $regex)
    {
        $this->regex = $regex;
    }

    public function isValid(Value $value) : bool
    {
        $value = $value->getValue();
        if (! Helper::isStringable($value)) {
            return false;
        }

        return preg_match($this->regex, (string) $value) === 1;
    }

    public function getAttributes() : array
    {
        return [];
    }
}
