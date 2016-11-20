<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 20.11.16
 * Time: 22:08
 */

namespace Framework\Validation\Filter;

use Framework\Validation\ValidatorRuleInterface;

class Match implements ValidatorRuleInterface
{
    protected $pattern;
    protected $message = 'Not match pattern';

    public function __construct($pattern, $message = null)
    {
        $this->pattern = $pattern;
        if (!empty($message)) {
            $this->message = $message;
        }
    }

    /**
     * Validate data
     *
     * @param $var
     * @return bool|string
     */
    public function validate($var)
    {
        return preg_match($this->pattern, $var) ? true : $this->message;
    }
}
