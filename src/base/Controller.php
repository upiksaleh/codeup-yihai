<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\base;

/**
 * Class Controller
 * @package codeup\base
 */
class Controller extends \yii\web\Controller
{
    /**
     * @param $name
     * @return mixed
     */
    public function getActionByName($name){
        if(in_array($name, array_keys($this->actions()))){
            return $this->actions()[$name];
        }
        return false;
    }

}