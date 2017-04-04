<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 27.11.16
 * Time: 20:29
 */

namespace Framework\Helper;

use Framework\Model\ActiveRecord;

abstract class ArrayHelper
{
    /**
     * Return array map
     *
     * @param array $data
     * @param $key
     * @param $value
     * @return array
     */
    public static function map(array $data, $key, $value)
    {
        $return_array = [];

        foreach ($data as $item) {
            if ($item instanceof ActiveRecord) {
                $method_key = 'get' . ucfirst($key);
                $method_value = 'get' . ucfirst($value);
                $return_array[$item->$method_key()] = $item->$method_value();
            } elseif (is_array($item)) {
                $item_key = $item[$key];
                $item_value = $item[$value];
                $return_array[$item_key] = $item_value;
            }
            continue;
        }

        return $return_array;
    }
}
