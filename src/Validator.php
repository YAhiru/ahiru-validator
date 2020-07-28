<?php
declare(strict_types=1);
namespace Yahiru\Validator;

use Yahiru\Validator\MessageRepository\EnglishMessageRepository;

final class Validator
{
    /** @var array<int, RuleCollection> */
    private array $rules;
    private MessageBuilder $builder;

    /** @var array<string, string> */
    private array $aliases = [];

    public function __construct()
    {
        $this->builder = new MessageBuilder(new EnglishMessageRepository());
    }

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
            $matches = $input->getWithVoid($rules->getKeys());

            /** @var Matched $match */
            foreach ($matches as $match) {
                $willValidateValue = $match->getValue();
                if ($rules->canSkip($willValidateValue)) {
                    continue;
                }

                /** @var RuleInterface $rule */
                foreach ($rules as $rule) {
                    $value = new Value($willValidateValue);

                    if ($rule instanceof DependsOtherValueInterface) {
                        $value->setDepends($rule->getDependsValue($input));
                    }

                    $ruleIsValid = $rule->isValid($value);

                    if (! $ruleIsValid) {
                        $errors = self::addError(
                            $errors,
                            $match->getKeys(),
                            $this->builder->build($this->aliases, $rules->getAttributeName(), $rule)
                        );
                    }
                }
            }
        }

        return new Result($values, $errors);
    }

    public function define(Keys $attributeKey, string $attributeName) : RuleCollection
    {
        $this->aliases[$attributeKey->toString()] = $attributeName;

        return $this->rules[] = new RuleCollection($attributeKey, $attributeName);
    }

    /**
     * @param array<string, ErrorCollection> $errors
     *
     * @return array<string, mixed>
     */
    private static function addError(array $errors, Keys $keys, string $message) : array
    {
        $key = $keys->implode('__separate__');
        if (! isset($errors[$key])) {
            $errors[$key] = new ErrorCollection([], $keys);
        }

        /** @var ErrorCollection $errorCollection */
        $errorCollection = $errors[$key];
        $errorCollection->addError($message);

        return $errors;
    }
}
