<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\theming;

use Yii;
use yii\helpers\ArrayHelper;

trait HtmlTrait
{

    /**
     * {@inheritdoc}
     */
    public static function renderTagAttributes($attributes)
    {
        $html = parent::renderTagAttributes($attributes);
        if(isset(Yii::$app->view->theme->attributes_replace))
            return strtr($html, Yii::$app->view->theme->attributes_replace);

        return $html;
    }

    /**
     * @param string|array $str
     * @return string
     */
    public static function ctheme($str){
        if(is_string($str))
            $str = [$str];
        $str = array_map(function($s){
            return '{ctheme}'.$s;
        },$str);
        return implode(' ',$str);
    }

    /**
     * Composes icon HTML for bootstrap Glyphicons.
     * @param string $name icon short name, for example: 'star'
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. There are also a special options:
     *
     * - tag: string, tag to be rendered, by default 'span' is used.
     * - prefix: string, prefix which should be used to compose tag class, by default 'glyphicon glyphicon-' is used.
     *
     * @return string icon HTML.
     * @see http://getbootstrap.com/components/#glyphicons
     */
    public static function icon($name, $options = [])
    {
        $tag = ArrayHelper::remove($options, 'tag', 'span');
        $classPrefix = ArrayHelper::remove($options, 'prefix', 'glyphicon glyphicon-');
        static::addCssClass($options, $classPrefix . $name);
        return static::tag($tag, '', $options);
    }

    /**
     * @param string|array $name
     * @param array $options
     * @param string $contents
     * @return string tag i
     */
    public static function faicon($name, $options = [], $contents = ''){
        $prefix = 'fa';
        $class= [$prefix];
        if(!is_array($name))
            $name = [$name];
        foreach($name as $icon){
            $class[] = $prefix.'-'.$icon;
        }
        static::addCssClass($options, $class);
        return static::tag('i',$contents, $options);
    }
    /**
     * Renders Bootstrap static form control.
     *
     * By default value will be HTML-encoded using [[encode()]], you may control this behavior
     * via 'encode' option.
     * @param string $value static control value.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. There are also a special options:
     *
     * - encode: bool, whether value should be HTML-encoded or not.
     *
     * @return string generated HTML
     * @see http://getbootstrap.com/css/#forms-controls-static
     */
    public static function staticControl($value, $options = [])
    {
        static::addCssClass($options, 'form-control-static');
        $value = (string) $value;
        if (isset($options['encode'])) {
            $encode = $options['encode'];
            unset($options['encode']);
        } else {
            $encode = true;
        }
        return static::tag('p', $encode ? static::encode($value) : $value, $options);
    }

    /**
     * Generates a Bootstrap static form control for the given model attribute.
     * @param \yii\base\Model $model the model object.
     * @param string $attribute the attribute name or expression. See [[getAttributeName()]] for the format
     * about attribute expression.
     * @param array $options the tag options in terms of name-value pairs. See [[staticControl()]] for details.
     * @return string generated HTML
     * @see staticControl()
     */
    public static function activeStaticControl($model, $attribute, $options = [])
    {
        if (isset($options['value'])) {
            $value = $options['value'];
            unset($options['value']);
        } else {
            $value = static::getAttributeValue($model, $attribute);
        }
        return static::staticControl($value, $options);
    }

    /**
     * {@inheritdoc}
     * @since 2.0.8
     */
    public static function radioList($name, $selection = null, $items = [], $options = [])
    {
        if (!isset($options['item'])) {
            $itemOptions = ArrayHelper::remove($options, 'itemOptions', []);
            $encode = ArrayHelper::getValue($options, 'encode', true);
            $options['item'] = function ($index, $label, $name, $checked, $value) use ($itemOptions, $encode) {
                $options = array_merge([
                    'label' => $encode ? static::encode($label) : $label,
                    'value' => $value
                ], $itemOptions);
                return '<div class="radio">' . static::radio($name, $checked, $options) . '</div>';
            };
        }

        return parent::radioList($name, $selection, $items, $options);
    }

    /**
     * {@inheritdoc}
     * @since 2.0.8
     */
    public static function checkboxList($name, $selection = null, $items = [], $options = [])
    {
        if (!isset($options['item'])) {
            $itemOptions = ArrayHelper::remove($options, 'itemOptions', []);
            $encode = ArrayHelper::getValue($options, 'encode', true);
            $options['item'] = function ($index, $label, $name, $checked, $value) use ($itemOptions, $encode) {
                $options = array_merge([
                    'label' => $encode ? static::encode($label) : $label,
                    'value' => $value
                ], $itemOptions);
                return '<div class="checkbox">' . Html::checkbox($name, $checked, $options) . '</div>';
            };
        }

        return parent::checkboxList($name, $selection, $items, $options);
    }

    /**
     * {@inheritdoc}
     * @since 2.0.8
     */
    public static function error($model, $attribute, $options = [])
    {
        if (!array_key_exists('tag', $options)) {
            $options['tag'] = 'p';
        }
        if (!array_key_exists('class', $options)) {
            $options['class'] = 'help-block help-block-error';
        }
        return parent::error($model, $attribute, $options);
    }
}