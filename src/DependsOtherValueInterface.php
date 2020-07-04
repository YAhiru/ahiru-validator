<?php
declare(strict_types=1);
namespace Yahiru\Validator;

interface DependsOtherValueInterface
{
    /**
     * @return mixed
     */
    public function getDependsValue(Input $input);
}
