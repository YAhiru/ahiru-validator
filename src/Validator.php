<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Validator
{
    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @param mixed[] $data
     */
    public function validate(array $data) : Result
    {
        unset($data);

        return new Result();
    }

    /**
     * @return $this
     */
    public function define(string $attributeKey, string $attributeName) : self
    {
        unset($attributeKey, $attributeName);

        return $this;
    }

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
}
