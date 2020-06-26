<?php
declare(strict_types=1);
namespace Yahiru\Validator\Rule;

final class Helper
{
    /**
     * @param mixed $value
     */
    public static function isStringable($value) : bool
    {
        return is_string($value) || is_int($value) || is_float($value);
    }
}
