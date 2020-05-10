<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Result
{
    /** @var Error[] */
    private array $errors;

    /**
     * @param Error[] $errors
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function hasErrors() : bool
    {
        return count($this->errors) > 0;
    }

    /**
     * @return Error[]
     */
    public function getErrors() : array
    {
        return $this->errors;
    }
}
