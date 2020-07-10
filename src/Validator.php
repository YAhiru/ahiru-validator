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
        $input = new Input($values);
        $errors = [];

        /** @var RuleCollection $rules */
        foreach ($this->rules as $key => $rules) {
            $willValidateValues = $input->match($key);

            foreach ($willValidateValues as $willValidateValue) {
                if (! $rules->isNovalidate($willValidateValue)) {

                    /** @var RuleInterface $rule */
                    foreach ($rules as $rule) {
                        $ruleIsValid = $rule instanceof DependsOtherValueInterface
                            ? $rule->isValid(new ResolvedDependsValue($willValidateValue, $rule->getDependsValue($input)))
                            : $rule->isValid($willValidateValue)
                        ;

                        if (! $ruleIsValid) {
                            $errors[$key][] = $rule->getMessage($rules->getAttributeName());
                        }
                    }
                }
            }
        }

        return new Result($values, $errors);
    }

    public function define(string $attributeKey, string $attributeName) : RuleCollection
    {
        return $this->rules[$attributeKey] = new RuleCollection($attributeName);
    }
}
