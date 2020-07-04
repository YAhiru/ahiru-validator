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

    public function match(string $key) : array
    {
        return self::recursiveMatch(explode('.', $key), $this->data);
    }

    /**
     * @param string[] $keys
     * @param mixed    $input
     *
     * @return array<int, mixed>
     */
    private static function recursiveMatch(array $keys, $input) : array
    {
        $key = array_shift($keys);
        if ($key === null) {
            return [$input];
        }
        if (! is_array($input)) {
            return [null];
        }
        if ($key === '*') {
            $result = [];
            foreach ($input as $item) {
                $result = array_merge($result, self::recursiveMatch($keys, $item));
            }

            return $result;
        }

        return self::recursiveMatch($keys, $input[$key] ?? null);
    }
}
