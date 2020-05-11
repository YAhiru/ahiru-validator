<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Validator
{
    /** @var array<string, RuleCollection> */
    private array $rules;

    /**
     * @phpstan-param array<string, mixed> $values
     *
     * @param mixed[] $values
     */
    public function validate(array $values) : Result
    {
        $errors = [];
        $validKeys = [];

        /** @var RuleCollection $rules */
        foreach ($this->rules as $key => $rules) {
            $willValidateValue = $values[$key] ?? null;
            $valid = true;

            if (! $rules->isNovalidate($willValidateValue)) {

                /** @var RuleInterface $rule */
                foreach ($rules as $rule) {
                    if (! $rule->isValid($willValidateValue)) {
                        $errors[$key][] = $rule->getMessage($rules->getAttributeName());
                        $valid = false;
                    }
                }
            }

            if ($valid) {
                $validKeys[] = $key;
            }
        }

        return new Result($values, $errors, $validKeys);
    }

    public function define(string $attributeKey, string $attributeName) : RuleCollection
    {
        return $this->rules[$attributeKey] = new RuleCollection($attributeName);
    }
}
