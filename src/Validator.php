<?php
declare(strict_types=1);
namespace Yahiru\Validator;

use Yahiru\Validator\MessageRepository\EnglishMessageRepository;

final class Validator
{
    /** @var array<int, Definition> */
    private array $definitions = [];
    private MessageBuilder $builder;

    public function __construct()
    {
        $this->builder = new MessageBuilder(new EnglishMessageRepository());
    }

    /**
     * @phpstan-param array<string, mixed> $values
     *
     * @param mixed[] $values
     */
    public function validate(array $values) : ResultInterface
    {
        $input = new Input($values);
        $result = new Result();

        /** @var Definition $rules */
        foreach ($this->definitions as $rules) {
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

                    if (! $rule->isValid($value)) {
                        $result->addError(
                            $match->getKeys(),
                            $this->builder->build($this->definitions, $rules->getAttributeName(), $rule)
                        );
                    }
                }
            }
        }

        return $result;
    }

    public function define(Keys $attributeKey, string $attributeName) : Definition
    {
        return $this->definitions[] = new Definition($attributeKey, $attributeName);
    }
}
