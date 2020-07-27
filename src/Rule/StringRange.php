<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;
use Yahiru\Validator\Value;

final class StringRange implements RuleInterface
{
    private int $min;
    private int $max;

    public function __construct(int $min, int $max)
    {
        if ($min < 0) {
            throw new \LogicException('$min must be greater than 0.');
        }

        $this->min = $min;
        $this->max = $max;
    }

    public function isValid(Value $value) : bool
    {
        $value = $value->getValue();
        if (! Helper::isStringable($value)) {
            return false;
        }
        $strlen = mb_strlen((string) $value);

        return $this->min <= $strlen && $strlen <= $this->max;
    }

    public function getAttributes() : array
    {
        return [
            'min' => "{$this->min}",
            'max' => "{$this->max}",
        ];
    }
}
