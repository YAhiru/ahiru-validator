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
     * @return array<int, Matched>
     */
    public function get(Keys $keys) : array
    {
        return self::recursiveGet($keys->toArray(), $this->data, [], false);
    }

    /**
     * @return array<int, Matched>
     */
    public function getWithVoid(Keys $keys) : array
    {
        return self::recursiveGet($keys->toArray(), $this->data, [], true);
    }

    /**
     * @param string[] $keys
     * @param mixed    $input
     * @param string[] $stack
     *
     * @return array<int, mixed>
     */
    private static function recursiveGet(array $keys, $input, array $stack, bool $withVoid) : array
    {
        $key = array_shift($keys);
        if ($key === null) {
            return [new Matched($input, new Keys(...$stack))];
        }
        if (! is_array($input)) {
            return $withVoid
                ? [Matched::void(new Keys(...array_merge($stack, [$key])))]
                : [];
        }
        if ($key === '*') {
            $result = [];
            foreach ($input as $index => $item) {
                $result = array_merge(
                    $result,
                    self::recursiveGet($keys, $item, array_merge($stack, [(string) $index]), $withVoid)
                );
            }

            return $result;
        }

        $stack[] = $key;

        if (! isset($input[$key])) {
            return $withVoid
                ? [Matched::void(new Keys(...$stack))]
                : [];
        }

        return self::recursiveGet($keys, $input[$key], $stack, $withVoid);
    }
}
