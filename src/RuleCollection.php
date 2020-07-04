<?php
declare(strict_types=1);
namespace Yahiru\Validator;

use Yahiru\Validator\Rule\Nullable;
use Yahiru\Validator\Rule\OverwriteMessage;

/**
 * @implements \IteratorAggregate<RuleInterface>
 */
final class RuleCollection implements \IteratorAggregate
{
    /**
     * @phpstan-var RuleInterface[]
     */
    private array $rules = [];
    private string $attributeName;

    public function __construct(string $attributeName)
    {
        $this->attributeName = $attributeName;
    }

    public function getAttributeName() : string
    {
        return $this->attributeName;
    }

    /**
     * @return $this
     */
    public function add(RuleInterface $rule, string $overwriteMessage = null) : self
    {
        if ($overwriteMessage !== null) {
            $rule = new OverwriteMessage($rule, $overwriteMessage);
        }

        $this->rules[] = $rule;

        return $this;
    }

    /**
     * @return \Traversable<RuleInterface>
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->rules);
    }

    public function isNullable() : bool
    {
        foreach ($this->rules as $rule) {
            if ($rule instanceof Nullable) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param mixed $value
     */
    public function isNovalidate($value) : bool
    {
        return $value === null && $this->isNullable();
    }
}
