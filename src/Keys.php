<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Keys
{
    /** @var string */
    private const DELIMITER = '.';

    /** @var array<int, string> */
    private array $keys;

    public function __construct(string ...$keys)
    {
        $this->keys = $keys;
    }

    public function implode(string $delimiter) : string
    {
        return implode($delimiter, $this->keys);
    }

    public static function create(string $keys) : self
    {
        return new self(...explode(self::DELIMITER, $keys));
    }

    public function toString() : string
    {
        return $this->implode(self::DELIMITER);
    }

    /**
     * @return array<int, string>
     */
    public function toArray() : array
    {
        return $this->keys;
    }

    public function equals(self $keys) : bool
    {
        $keys = $keys->keys;
        if (count($keys) !== count($this->keys)) {
            return false;
        }

        foreach ($keys as $idx => $first) {
            $second = $this->keys[$idx] ?? null;
            if ($second === null || ($first !== $second && $first !== '*')) {
                return false;
            }
        }

        return true;
    }
}
