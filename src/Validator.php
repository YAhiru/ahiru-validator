<?php
declare(strict_types=1);

namespace Yahiru\Validator;

final class Validator
{
    public function validate(array $data): Result
    {
        return new Result();
    }

    public function define(string $attributeKey, string $attributeName): self
    {
        return $this;
    }

    public function addRule($rule): self
    {
        return $this;
    }
}
