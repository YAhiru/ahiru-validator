<?php
declare(strict_types=1);
namespace Yahiru\Validator;

interface RuleInterface
{
    /**
     * @param mixed $value
     */
    public function isValid($value) : bool;

    public function getMessage(string $attributeName) : string;
}
