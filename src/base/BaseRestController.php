<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\base;


use yii\helpers\ArrayHelper;

class BaseRestController extends \yii\rest\ActiveController
{
    public $actions = [];
    public function actions(){
        $actions = ArrayHelper::merge(parent::actions(), $this->actions);
        return $actions;
    }
}