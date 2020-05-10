<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Validator
{
    /**
     * @phpstan-param array<string, mixed> $data
     *
     * @param mixed[] $data
     */
    public function validate(array $data) : Result
    {
        unset($data);

        return new Result(['名前を入力してください。']);
    }

    public function define(string $attributeKey, string $attributeName) : Rules
    {
        unset($attributeKey, $attributeName);

        return new Rules();
    }
}
