<?php
declare(strict_types=1);
namespace Yahiru\Validator;

final class Value
{
    /** @var mixed */
    private $value;
    /** @var mixed */
    private $depends;

    /**
     * @param mixed $value
     * @param mixed $depends
     */
    public function __construct($value, $depends = null)
    {
        $this->value = $value;
        $this->depends = $depends;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getDepends()
    {
        return $this->depends;
    }
}
