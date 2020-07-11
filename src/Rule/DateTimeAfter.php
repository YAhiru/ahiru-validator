<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\DependsOtherValueInterface;
use Yahiru\Validator\Input;
use Yahiru\Validator\ResolvedDependsValue;
use Yahiru\Validator\RuleInterface;

final class DateTimeAfter implements RuleInterface, DependsOtherValueInterface
{
    private string $keyOrDateTime;

    public function __construct(string $keyOrDateTime)
    {
        $this->keyOrDateTime = $keyOrDateTime;
    }

    public function getDependsValue(Input $input)
    {
        $target = $input->match([$this->keyOrDateTime]);
        if (! isset($target[0]) || $target[0]->getValue() === null) {
            return $this->keyOrDateTime;
        }

        return $target[0]->getValue();
    }

    public function isValid($value) : bool
    {
        assert($value instanceof ResolvedDependsValue);
        if (! is_string($first = $value->getValue())
            || ! is_string($second = $value->getDepends())
            || ! ($first = $this->createDateTime($first))
            || ! ($second = $this->createDateTime($second))
        ) {
            return false;
        }

        return $first > $second;
    }

    public function getMessage(string $attributeName) : string
    {
        return sprintf('%s must be a date after %s.', $attributeName, $this->keyOrDateTime);
    }

    private function createDateTime(string $value) : ?\DateTimeImmutable
    {
        return date_create_immutable($value) ?: null;
    }
}
