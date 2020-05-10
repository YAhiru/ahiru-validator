<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Validator
{
    /** @var array<string, RuleCollection> */
    private array $rules;

    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @param mixed[] $data
     */
    public function validate(array $data) : Result
    {
        $errors = [];
        $validKeys = [];

        /** @var RuleCollection $rules */
        foreach ($this->rules as $key => $rules) {
            $willValidateValue = $data[$key] ?? null;
            $valid = true;

            /** @var RuleInterface $rule */
            foreach ($rules as $rule) {
                if (! $rule->isValid($willValidateValue)) {
                    $errors[] = new Error($key, $rule->getMessage($rules->getAttributeName()));
                    $valid = false;
                }
            }

            if ($valid) {
                $validKeys[] = $key;
            }
        }

        return new Result($data, $errors, $validKeys);
    }

    public function define(string $attributeKey, string $attributeName) : RuleCollection
    {
        return $this->rules[$attributeKey] = new RuleCollection($attributeName);
    }
}
