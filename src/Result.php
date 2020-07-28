<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Result implements ResultInterface
{
    /**
     * @var array<string, ErrorCollection>
     */
    private array $errors = [];

    public function hasErrors() : bool
    {
        return count($this->errors) > 0;
    }

    public function getErrors(Keys $keys) : array
    {
        $errors = [];

        /** @var ErrorCollection $error */
        foreach ($this->errors as $error) {
            if ($error->getKeys()->equals($keys)) {
                $errors = array_merge($errors, $error->getErrors());
            }
        }

        return $errors;
    }

    public function getAllErrors() : array
    {
        $errors = [];
        foreach ($this->errors as $error) {
            $errors[$error->getKeys()->toString()] = $error->getErrors();
        }

        return $errors;
    }

    public function addError(Keys $keys, string $message) : void
    {
        $key = $keys->implode('__separate__');
        if (! isset($this->errors[$key])) {
            $this->errors[$key] = new ErrorCollection([], $keys);
        }

        /** @var ErrorCollection $errorCollection */
        $errorCollection = $this->errors[$key];
        $errorCollection->addError($message);
    }
}
