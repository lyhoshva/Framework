<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 20.11.16
 * Time: 21:48
 */

namespace Framework\Validation\Filter;

use Framework\Validation\ValidatorRuleInterface;

class Number implements ValidatorRuleInterface
{
    /**
     * Validate data
     *
     * @param $var
     * @return bool|string
     */
    public function validate($var)
    {
        return is_numeric($var) ? true : 'Not a number';
    }
}
