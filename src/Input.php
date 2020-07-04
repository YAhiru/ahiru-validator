<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Input
{
    /** @var array<string, mixed> */
    private array $data = [];

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function fetch(string $key)
    {
        return $this->data[$key] ?? null;
    }
}
