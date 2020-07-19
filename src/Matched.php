<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Matched
{
    /** @var mixed */
    private $value;
    /** @var string[] */
    private array $keys;
    private bool $void = false;

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

    public static function void(array $keys) : self
    {
        $self = new self(null, $keys);
        $self->void = true;

        return $self;
    }

    public function isVoid() : bool
    {
        return $this->void;
    }
}
