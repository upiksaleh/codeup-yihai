<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\components;

use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class Menu extends Component
{
    public function getAllMenu(){
        return Yii::$app->params['menuItems'];
    }
    public function add($menu){
        Yii::$app->params['menuItems'] = ArrayHelper::merge($menu, Yii::$app->params['menuItems']);
    }
}