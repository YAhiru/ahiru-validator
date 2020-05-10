<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Validator
{
    /** @var array<string, Rules> */
    private array $rules;

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @param mixed[] $data
     */
    public function validate(array $data) : Result
    {
        $errors = [];

        /** @var Rules $rules */
        foreach ($this->rules as $key => $rules) {
            $willValidateValue = $data[$key] ?? null;

            /** @var RuleInterface $rule */
            foreach ($rules as $rule) {
                if (! $rule->isValid($willValidateValue)) {
                    $errors[] = new Error($rule->getMessage($rules->getAttributeName()));
                }
            }
        }

        return new Result($errors);
    }

    public function define(string $attributeKey, string $attributeName) : Rules
    {
        return $this->rules[$attributeKey] = new Rules($attributeName);
    }
}
