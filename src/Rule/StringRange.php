<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;

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

    public function isValid($value) : bool
    {
        if (! Helper::isStringable($value)) {
            return false;
        }
        $strlen = mb_strlen((string) $value);

        return $this->min <= $strlen && $strlen <= $this->max;
    }

    public function getMessage(string $attributeName) : string
    {
        return sprintf('%1$s must be between %2$s and %3$s characters.', $attributeName, $this->max, $this->min);
    }
}
