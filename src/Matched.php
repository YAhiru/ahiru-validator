<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Matched
{
    /** @var mixed */
    private $value;
    /** @var string[] */
    private array $keys;

    /**
     * @param mixed    $value
     * @param string[] $keys
     */
    public function __construct($value, array $keys)
    {
        $this->value = $value;
        $this->keys = $keys;
    }

    public function getKeys() : array
    {
        return $this->keys;
    }

    public function getValue()
    {
        return $this->value;
    }
}
