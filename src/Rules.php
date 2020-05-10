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
     * @param mixed $rule
     *
     * @return $this
     */
    public function addRule($rule) : self
    {
        unset($rule);

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
