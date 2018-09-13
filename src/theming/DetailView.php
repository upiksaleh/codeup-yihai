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