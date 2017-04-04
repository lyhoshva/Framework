<?php

namespace Framework\Validation\Filter;

use Framework\Validation\ValidatorRuleInterface;

/**
 * Class Length
 * @package Framework\Validation\Filter
 */
class Length implements ValidatorRuleInterface
{
    protected $min;
    protected $max;

    /**
     * Length constructor.
     * @param $min
     * @param $max
     */
    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Validate data
     *
     * @param $var string
     * @return bool|string
     */
    public function validate($var)
    {
        $length = strlen($var);
        if ($length > $this->min) {
            if ($length < $this->max) {
                return true;
            } else {
                return 'Too long';
            }
        } else {
            return 'Too short';
        }
    }
}
