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
        if ($key === '*' && in_array('*', $keys, true)) {
            $result = [];
            foreach ($input as $item) {
                $found = self::recursiveFetch($keys, $item);
                $result = array_merge(
                    $result,
                    is_array($found) ? $found : [$found]
                );
            }

            return $result;
        }
        if ($key === '*') {
            $result = [];
            foreach ($input as $item) {
                $result[] = self::recursiveFetch($keys, $item);
            }

            return $result;
        }

        return self::recursiveFetch($keys, $input[$key] ?? null);
    }
}
