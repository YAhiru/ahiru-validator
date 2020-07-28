<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Matched
{
    /** @var mixed */
    private $value;
    private Keys $keys;
    private bool $void = false;

    /**
     * @param mixed $value
     */
    public function __construct($value, Keys $keys)
    {
        $this->value = $value;
        $this->keys = $keys;
    }

    public function getKeys() : Keys
    {
        return $this->keys;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public static function void(Keys $keys) : self
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
