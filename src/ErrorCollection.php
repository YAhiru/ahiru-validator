<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class ErrorCollection
{
    private Keys $keys;
    /** @var string[] */
    private array $errors;

    /**
     * @param string[] $errors
     */
    public function __construct(array $errors, Keys $keys)
    {
        $this->errors = $errors;
        $this->keys = $keys;
    }

    public function getKeys() : Keys
    {
        return $this->keys;
    }

    /**
     * @return string[]
     */
    public function getErrors() : array
    {
        return $this->errors;
    }

    public function addError(string $message) : void
    {
        $this->errors[] = $message;
    }
}
