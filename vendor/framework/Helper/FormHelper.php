<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 20.11.16
 * Time: 13:01
 */

namespace Framework\Helper;

use Framework\DI\Service;
use Framework\Model\ActiveRecord;

class FormHelper
{
    protected function __construct()
    {
        //lock
    }

    /**
     * Print form tag with csrf token
     * Return FormHelper
     *
     * @param array $options
     * @return FormHelper
     */
    public static function begin(array $options = [])
    {
        $form_tag = '<form';
        $form_tag = self::addOptions($form_tag, $options);
        $form_tag .= '>';
        echo $form_tag;
        echo self::getCsrfInput();

        return new self();
    }

    /**
     * Print end form tag
     */
    public static function end()
    {
        echo '</form>';
    }

    /**
     * Return hidden input with csrf token
     *
     * @return string
     */
    protected static function getCsrfInput()
    {
        return '<input type="hidden" name="_csrf" value="' .  Service::get('security')->getToken() . '">';
    }

    /**
     * Return text input
     *
     * @param ActiveRecord $model
     * @param $field
     * @param array $options
     * @return string
     */
    public function textInput(ActiveRecord $model, $field, array $options = [])
    {
        $method_name = 'get' . ucfirst($field);

        $tag = '<input type="text" name="' . $field . '" value="' . $model->$method_name() . '"';
        $tag = self::addOptions($tag, $options);
        $tag .= '>';

        return $tag;
    }

    /**
     * Return text input
     *
     * @param ActiveRecord $model
     * @param $field
     * @param array $options
     * @return string
     */
    public function passwordInput(ActiveRecord $model, $field, array $options = [])
    {
        $method_name = 'get' . ucfirst($field);

        $tag = '<input type="password" name="' . $field . '" value="' . $model->$method_name() . '"';
        $tag = self::addOptions($tag, $options);
        $tag .= '>';

        return $tag;
    }

    /**
     * Return hidden input
     *
     * @param ActiveRecord $model
     * @param $field
     * @param array $options
     * @return string
     */
    public function hiddenInput(ActiveRecord $model, $field, array $options = [])
    {
        $method_name = 'get' . ucfirst($field);

        $tag = '<input type="hidden" name="' . $field . '" value="' . $model->$method_name() . '"';
        $tag = self::addOptions($tag, $options);
        $tag .= '>';

        return $tag;
    }

    /**
     * Return dropDown input
     *
     * @param string $name field name
     * @param string|array $selected options which have to be selected
     * @param array $data data for select options
     * @param null|string $prompt empty value name
     * @param array $options additional html options
     * @return string
     */
    public function dropDown($name, $selected, array $data, $prompt = null, array $options = [])
    {
        $tag = '<select name="' . $name . '"';
        $tag = self::addOptions($tag, $options);
        $tag .= '>';
        if (!empty($prompt)) {
            $tag .= '<option value="">' . $prompt . '</option>';
        }
        if (is_array($selected)) {
            foreach ($data as $key => $value) {
                $tag .= '<option value="' . $key . '"';
                if (in_array($key, $selected)) {
                    $tag .= ' selected="selected"';
                }
                $tag .= '>' . $value . '</option>';
            }
        } else {
            foreach ($data as $key => $value) {
                $tag .= '<option value="' . $key . '"';
                if ($selected == $key) {
                    $tag .= ' selected="selected"';
                }
                $tag .= '>' . $value . '</option>';
            }
        }
        $tag .= '</select>';
        return $tag;
    }

    /**
     * Return error string
     *
     * @param ActiveRecord $model
     * @param $field
     * @param array $options
     * @return string
     */
    public function getError(ActiveRecord $model, $field, array $options = [])
    {
        $error = $model->getErrors($field);
        if (!empty($error)) {
            $tag = '<span';
            $tag = self::addOptions($tag, $options);
            $tag .= '>' . $error . '</span>';
            return $tag;
        }
        return '';
    }

    /**
     * Return submit button
     *
     * @param $text
     * @param array $options
     * @return string
     */
    public function submitButton($text, array $options = [])
    {
        $tag = '<button type="submit"';
        $tag = self::addOptions($tag, $options);
        $tag .= '>' . $text . '</button>';

        return $tag;
    }

    /**
     * Add options to tag
     *
     * @param $tag
     * @param array $options
     * @return string
     */
    private static function addOptions($tag, array $options)
    {
        foreach ($options as $key => $value) {
            $tag .= " $key=\"$value\"";
        }

        return $tag;
    }
}
