<?php
declare(strict_types=1);

namespace Yahiru\Validator;

final class Result
{
    public function hasErrors(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return ['名前を入力してください。'];
    }
}
