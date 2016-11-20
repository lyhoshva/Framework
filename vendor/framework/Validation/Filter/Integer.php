<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 20.11.16
 * Time: 21:42
 */

namespace Framework\Validation\Filter;

use Framework\Validation\ValidatorRuleInterface;

class Integer implements ValidatorRuleInterface
{
    /**
     * Validate data
     *
     * @param $var
     * @return bool|string
     */
    public function validate($var)
    {
        return is_int($var) ? true : 'Not an integer';
    }
}
