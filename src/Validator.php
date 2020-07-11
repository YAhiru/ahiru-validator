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
        foreach ($this->rules as $rules) {
            $matches = $input->match($rules->getKeys());

            /** @var Matched $match */
            foreach ($matches as $match) {
                $willValidateValue = $match->getValue();
                if ($rules->canSkip($willValidateValue)) {
                    continue;
                }

                /** @var RuleInterface $rule */
                foreach ($rules as $rule) {
                    $ruleIsValid = $rule instanceof DependsOtherValueInterface
                        ? $rule->isValid(new ResolvedDependsValue($willValidateValue, $rule->getDependsValue($input)))
                        : $rule->isValid($willValidateValue);

                    if (! $ruleIsValid) {
                        $errors = self::addError($errors, $match->getKeys(), $rule->getMessage($rules->getAttributeName()));
                    }
                }
            }
        }

        return new Result($values, $errors);
    }

    public function define($attributeKey, string $attributeName) : RuleCollection
    {
        return $this->rules[] = new RuleCollection(explode('.', $attributeKey), $attributeName);
    }

    /**
     * @param array<string, ErrorCollection> $errors
     * @param string[]                       $keys
     *
     * @return array<string, mixed>
     */
    private static function addError(array $errors, array $keys, string $message) : array
    {
        $key = implode('__separate__', $keys);
        if (! isset($errors[$key])) {
            $errors[$key] = new ErrorCollection($keys, []);
        }

        /** @var ErrorCollection $errorCollection */
        $errorCollection = $errors[$key];
        $errorCollection->addError($message);

        return $errors;
    }
}
