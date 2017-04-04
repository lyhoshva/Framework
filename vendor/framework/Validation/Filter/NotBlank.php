<?php

namespace Framework\Validation\Filter;

use Framework\Validation\ValidatorRuleInterface;

/**
 * Class NotBlank
 * @package Framework\Validation\Filter
 */
class NotBlank implements ValidatorRuleInterface
{
    /**
     * Validate data
     *
     * @param $var
     * @return bool|string
     */
    public function validate($var)
    {
        return !empty($var) ? true : 'Is blank';
    }
}
