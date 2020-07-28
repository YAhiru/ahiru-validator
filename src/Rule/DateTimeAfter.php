<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\DependsOtherValueInterface;
use Yahiru\Validator\Input;
use Yahiru\Validator\Keys;
use Yahiru\Validator\RuleInterface;
use Yahiru\Validator\Value;

final class DateTimeAfter implements RuleInterface, DependsOtherValueInterface
{
    private string $keyOrDateTime;

    public function __construct($keyOrDateTime)
    {
        $this->keyOrDateTime = $keyOrDateTime;
    }

    public function getDependsValue(Input $input)
    {
        $target = $input->get(new Keys($this->keyOrDateTime));
        if (count($target) === 0) {
            return $this->keyOrDateTime;
        }

        return $target[0]->getValue();
    }

    public function isValid(Value $value) : bool
    {
        if (! is_string($first = $value->getValue())
            || ! is_string($second = $value->getDepends())
            || ! ($first = $this->createDateTime($first))
            || ! ($second = $this->createDateTime($second))
        ) {
            return false;
        }

        return $first > $second;
    }

    public function getAttributes() : array
    {
        return ['after' => $this->keyOrDateTime];
    }

    private function createDateTime(string $value) : ?\DateTimeImmutable
    {
        return date_create_immutable($value) ?: null;
    }
}
