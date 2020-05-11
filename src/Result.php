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
     * @var string[][]
     */
    private array $errors;
    /** @var string[] */
    private array $validKeys;

    /**
     * @phpstan-param array<string, mixed> $rawValues
     * @phpstan-param array<string, array<string>> $errors
     *
     * @param mixed[]  $rawValues
     * @param array[]  $errors
     * @param string[] $validKeys
     */
    public function __construct(array $rawValues, array $errors, array $validKeys)
    {
        $this->rawValues = $rawValues;
        $this->errors = $errors;
        $this->validKeys = $validKeys;
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
        return $this->errors[$key] ?? [];
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

    /**
     * @phpstan-return array<string, mixed>
     *
     * @return mixed[]
     */
    public function getValidatedValues() : array
    {
        $validated = [];
        foreach ($this->validKeys as $key) {
            $validated[$key] = $this->rawValues[$key] ?? null;
        }

        return $validated;
    }
}
