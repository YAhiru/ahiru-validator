<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Result
{
    /** @var string[] */
    private array $errors;

    /**
     * @param string[] $errors
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
     * @return string[]
     */
    public function getErrors() : array
    {
        return $this->errors;
    }
}
