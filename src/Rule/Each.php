<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

use Yahiru\Validator\RuleInterface;

final class Each implements RuleInterface
{
    private RuleInterface $rule;

    public function __construct(RuleInterface $rule)
    {
        $this->rule = $rule;
    }

    public function isValid($value) : bool
    {
        if (! is_array($value)) {
            return false;
        }

        foreach ($value as $v) {
            if (! $this->rule->isValid($v)) {
                return false;
            }
        }

        return true;
    }

    public function getMessage(string $attributeName) : string
    {
        return $this->rule->getMessage($attributeName);
    }
}
