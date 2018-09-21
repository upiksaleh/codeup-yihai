<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

namespace codeup\theming;


class DetailView extends \yii\widgets\DetailView
{
    /**
     * @var array the HTML attributes for the container tag of this widget. The `tag` option specifies
     * what container tag should be used. It defaults to `table` if not set.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    //public $options = ['class' => 'table table-condensed table-striped table-hover table-bordered detail-view'];
    /**
     * @var string|callable the template used to render a single attribute. If a string, the token `{label}`
     * and `{value}` will be replaced with the label and the value of the corresponding attribute.
     * If a callback (e.g. an anonymous function), the signature must be as follows:
     *
     * ```php
     * function ($attribute, $index, $widget)
     * ```
     *
     * where `$attribute` refer to the specification of the attribute being rendered, `$index` is the zero-based
     * index of the attribute in the [[attributes]] array, and `$widget` refers to this widget instance.
     *
     * Since Version 2.0.10, the tokens `{captionOptions}` and `{contentOptions}` are available, which will represent
     * HTML attributes of HTML container elements for the label and value.
     */
    public $template = '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>';

    public function init()
    {

        $i = 0;
        foreach($this->attributes as $attribute){
            if(is_string($attribute) && $attribute == '_codeup_created_updated'){
                $captionOptions = [];
                $this->attributes[$i] = [
                    'attribute'=>'created_by',
                    'format'=>'html',
                    'captionOptions'=>['style'=>'border-top: 5px solid #ecf0f5'],
                    'contentOptions'=>['style'=>'border-top: 5px solid #ecf0f5']
                ];
                $this->attributes[$i+1] = [
                    'attribute'=>'created_at',
                    'format'=>'datetime',
                    'captionOptions'=>$captionOptions
                ];
                $this->attributes[$i+2] = [
                    'attribute'=>'updated_by',
                    'format'=>'html',
                    'captionOptions'=>$captionOptions
                ];
                $this->attributes[$i+3] = [
                    'attribute'=>'updated_at',
                    'format'=>'datetime',
                    'captionOptions'=>$captionOptions
                ];
                $i = $i+4;
            }else{
                $this->attributes[$i] = $attribute;
                $i++;
            }

        }
        parent::init();
    }
}