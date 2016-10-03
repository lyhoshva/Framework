<?php

namespace Framework\Validation;

/**
 * Class Validator
 * @package Framework\Validation
 */
class Validator
{
    /**
     * Object container
     *
     * @var
     */
    protected $obj;
    /**
     * Array with errors
     *
     * @var array
     */
    protected $errors = array();

    /**
     * Validator constructor.
     * @param $obj
     */
    public function __construct($obj)
    {
        $this->obj = $obj;
    }

    /**
     * Check validation for all rules
     *
     * @return bool
     */
    public function isValid()
    {
        foreach ($this->obj->getRules() as $name => $rules) {
            foreach ($rules as $rule) {
                $result = $rule->validate($this->obj->$name);

                if ($result !== true) {
                    $this->errors[$name] = $result;
                    break;
                }
            }
        }

        return empty($this->errors) ? true : false;
    }

    /**
     * Returns error array
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
