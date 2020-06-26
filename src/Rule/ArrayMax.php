<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;

final class ArrayMax implements RuleInterface
{
    private int $max;

    public function __construct(int $max)
    {
        $this->max = $max;
    }

    public function isValid($value) : bool
    {
        return is_array($value) && count($value) <= $this->max;
    }

    public function getMessage(string $attributeName) : string
    {
        return sprintf('size of %1$s must be smaller than %2$s.', $attributeName, $this->max);
    }
}
