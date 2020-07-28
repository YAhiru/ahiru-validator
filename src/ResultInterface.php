<?php
declare(strict_types=1);
namespace Yahiru\Validator;

interface ResultInterface
{
    public function hasErrors() : bool;

    /**
     * @return string[]
     */
    public function getErrors(Keys $keys) : array;

    /**
     * @phpstan-return array<string, array<string>>
     *
     * @return string[][]
     */
    public function getAllErrors() : array;
}
