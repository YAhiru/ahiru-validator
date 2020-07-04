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
        return self::recursiveFetch(explode('.', $key), $this->data);
    }

    /**
     * @param string[] $keys
     * @param mixed    $input
     *
     * @return null|mixed
     */
    private static function recursiveFetch(array $keys, $input)
    {
        $key = array_shift($keys);
        if ($key === null) {
            return $input;
        }
        if (! is_array($input)) {
            return;
        }

        return self::recursiveFetch($keys, $input[$key] ?? null);
    }
}
