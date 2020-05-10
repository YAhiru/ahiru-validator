<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;

final class OverwriteMessage implements RuleInterface
{
    private RuleInterface $rule;
    private string $message;

    public function __construct(RuleInterface $rule, string $message)
    {
        $this->rule = $rule;
        $this->message = $message;
    }

    public function isValid($value) : bool
    {
        return $this->rule->isValid($value);
    }

    public function getMessage(string $attributeName) : string
    {
        return $this->message;
    }
}
