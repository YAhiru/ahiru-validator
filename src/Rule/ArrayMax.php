<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;
use Yahiru\Validator\Value;

final class ArrayMax implements RuleInterface
{
    private int $max;

    public function __construct(int $max)
    {
        $this->max = $max;
    }

    public function isValid(Value $value) : bool
    {
        $value = $value->getValue();

        return is_array($value) && count($value) <= $this->max;
    }

    public function getReplacements() : array
    {
        return ['max' => "{$this->max}"];
    }
}
