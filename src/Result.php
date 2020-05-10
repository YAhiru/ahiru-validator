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
    /** @var Error[] */
    private array $errors;
    /** @var string[] */
    private array $validKeys;

    /**
     * @phpstan-param array<string, mixed> $rawValues
     *
     * @param mixed[]  $rawValues
     * @param Error[]  $errors
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
     * @return Error[]
     */
    public function getErrors() : array
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
