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

    public function define(string $attributeKey, string $attributeName) : RuleCollection
    {
        $this->aliases[$attributeKey] = $attributeName;

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
