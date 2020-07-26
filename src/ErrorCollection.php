<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class ErrorCollection
{
    /** @var string[] */
    private array $keys;
    /** @var string[] */
    private array $errors;

    /**
     * @param string[] $keys
     * @param string[] $errors
     */
    public function __construct($keys, $errors)
    {
        $this->keys = $keys;
        $this->errors = $errors;
    }

    /**
     * @return string[]
     */
    public function getKeys() : array
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

    /**
     * @param string[] $keys
     */
    public function isMatch(array $keys) : bool
    {
        if (count($keys) !== count($this->keys)) {
            return false;
        }

        foreach ($keys as $idx => $first) {
            $second = $this->keys[$idx] ?? null;
            if ($second === null || ($first !== $second && $first !== '*')) {
                return false;
            }
        }

        return true;
    }
}
