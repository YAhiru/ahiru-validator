<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Result
{
    /**
     * @phpstan-var array<string, mixed>
     *
     * @var mixed[]
     */
    private array $rawValues;
    /**
     * @var ErrorCollection[]
     */
    private array $errors;

    /**
     * @phpstan-param array<string, mixed> $rawValues
     *
     * @param mixed[]           $rawValues
     * @param ErrorCollection[] $errors
     */
    public function __construct(array $rawValues, array $errors)
    {
        $this->rawValues = $rawValues;
        $this->errors = $errors;
    }

    public function hasErrors() : bool
    {
        return count($this->errors) > 0;
    }

    /**
     * @param string|string[] $key
     *
     * @return string[]
     */
    public function getErrors($key) : array
    {
        $keys = is_array($key)
            ? $key
            : explode('.', $key)
        ;

        $errors = [];

        /** @var ErrorCollection $error */
        foreach ($this->errors as $error) {
            if ($error->isMatch($keys)) {
                $errors = array_merge($errors, $error->getErrors());
            }
        }

        return $errors;
    }

    /**
     * @phpstan-return array<string, array<string>>
     *
     * @return string[][]
     */
    public function getAllErrors() : array
    {
        $errors = [];
        foreach ($this->errors as $error) {
            $errors[implode('.', $error->getKeys())] = $error->getErrors();
        }

        return $errors;
    }
}
