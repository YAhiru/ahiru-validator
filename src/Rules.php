<?php
declare(strict_types=1);
namespace Yahiru\Validator;

/**
 * @implements \IteratorAggregate<RuleInterface>
 */
final class Rules implements \IteratorAggregate
{
    /**
     * @phpstan-var RuleInterface[]
     */
    private array $rules;

    /**
     * @return $this
     */
    public function addRule(RuleInterface $rule) : self
    {
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
}
