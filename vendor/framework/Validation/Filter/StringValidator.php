<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 20.11.16
 * Time: 21:59
 */

namespace Framework\Validation\Filter;

use Framework\Validation\ValidatorRuleInterface;

class StringValidator implements ValidatorRuleInterface
{
    /**
     * Validate data
     *
     * @param $var
     * @return bool|string
     */
    public function validate($var)
    {
        return is_string($var) ? true : 'Not a string';
    }
}
