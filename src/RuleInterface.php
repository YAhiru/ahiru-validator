<?php
declare(strict_types=1);
namespace Yahiru\Validator;

interface RuleInterface
{
    public function isValid(Value $value) : bool;

    /**
     * @return array<string, Keys|string>
     */
    public function getAttributes() : array;
}
