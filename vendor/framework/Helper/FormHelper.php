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

    public static function begin(array $options = [])
    {
        $form_tag = '<form';
        $form_tag = self::addOptions($form_tag, $options);
        $form_tag .= '>';
        echo $form_tag;
        echo self::getCsrfInput();

        return new self();
    }

    public static function end()
    {
        echo '</form>';
    }

    protected static function getCsrfInput()
    {
        return '<input type="hidden" name="_csrf" value="' .  Service::get('security')->getToken() . '">';
    }

    public function textInput(ActiveRecord $model, $field, array $options = [])
    {
        $method_name = 'get' . ucfirst($field);

        $input_tag = '<input type="text" name="' . $field . '" value="' . $model->$method_name() . '"';
        $input_tag = self::addOptions($input_tag, $options);
        $input_tag .= '>';

        return $input_tag;
    }

    public function getError(ActiveRecord $model, $field)
    {
        $error = $model->getErrors($field);
        if (!empty($error)){
            return '<span class="glyphicon glyphicon-remove form-control-feedback"></span><span class="pull-right small form-error">'.$errors[$field].'</span>';
        }
        return '';
    }

    public function submitButton($text, array $options = [])
    {
        $tag = '<button type="submit"';
        $tag = self::addOptions($tag, $options);
        $tag .= '>' . $text . '</button>';

        return $tag;
    }

    private static function addOptions($tag, array $options)
    {
        foreach ($options as $key => $value) {
            $tag .= " $key=\"$value\"";
        }

        return $tag;
    }
}
