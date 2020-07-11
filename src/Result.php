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
     * @phpstan-var array<string, array<string>>
     *
     * @var ErrorCollection[]
     */
    private array $errors;

    /**
     * @phpstan-param array<string, mixed> $rawValues
     * @phpstan-param array<string, array<string>> $errors
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
     * @return string[]
     */
    public function getErrors(string $key) : array
    {
        $keys = explode('.', $key);
        $errors = [];

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
        return $this->errors;
    }
}
