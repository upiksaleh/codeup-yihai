<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\components;

use Cii;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class Menu extends Component
{
    public function getAllMenu()
    {
        return Cii::getParams('menuItems', []);
    }

    public function add($menu)
    {
        Cii::setParams('menuItems', ArrayHelper::merge($menu, Cii::getParams('menuItems', [])));
    }
}