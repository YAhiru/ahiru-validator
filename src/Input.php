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
     * @param string[] $keys
     * @return array<int, Matched>
     */
    public function match(array $keys) : array
    {
        return self::recursiveMatch($keys, $this->data, []);
    }

    /**
     * @param string[] $keys
     * @param mixed    $input
     * @param string[] $stack
     *
     * @return array<int, mixed>
     */
    private static function recursiveMatch(array $keys, $input, array $stack) : array
    {
        $key = array_shift($keys);
        if ($key === null) {
            return [new Matched($input, $stack)];
        }
        if (! is_array($input)) {
            return [new Matched(null, array_merge($stack, [$key]))];
        }
        if ($key === '*') {
            $result = [];
            foreach ($input as $index => $item) {
                $result = array_merge(
                    $result,
                    self::recursiveMatch($keys, $item, array_merge($stack, [(string) $index]))
                );
            }

            return $result;
        }

        $stack[] = $key;

        return self::recursiveMatch($keys, $input[$key] ?? null, $stack);
    }
}
