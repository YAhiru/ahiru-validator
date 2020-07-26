<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;
use Yahiru\Validator\Value;

final class OverwriteMessage implements RuleInterface
{
    private RuleInterface $rule;
    private string $message;

    public function __construct(RuleInterface $rule, string $message)
    {
        $this->rule = $rule;
        $this->message = $message;
    }

    public function isValid(Value $value) : bool
    {
        return $this->rule->isValid($value);
    }

    public function getMessage(string $attributeName) : string
    {
        unset($attributeName);

        return $this->message;
    }
}
