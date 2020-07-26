<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\DependsOtherValueInterface;
use Yahiru\Validator\Input;
use Yahiru\Validator\RuleInterface;
use Yahiru\Validator\Value;

final class OverwriteMessage implements RuleInterface, DependsOtherValueInterface
{
    private RuleInterface $rule;
    private string $message;

    public function __construct(RuleInterface $rule, string $message)
    {
        $this->rule = $rule;
        $this->message = $message;
    }

    public function getDependsValue(Input $input)
    {
        return $this->rule instanceof DependsOtherValueInterface
            ? $this->rule->getDependsValue($input)
            : null;
    }

    public function isValid(Value $value) : bool
    {
        return $this->rule->isValid($value);
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function getReplacements() : array
    {
        return $this->rule->getReplacements();
    }
}
