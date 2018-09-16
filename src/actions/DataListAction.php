<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

/**
 * Class DataListAction
 * @package codeup\actions
 * @property \codeup\base\Controller $controller
 */
class DataListAction extends \codeup\base\Action
{

    public $baseView = '@codeup/views/_pages/base-datalist';

    public function init()
    {
        parent::init();
    }

    public function run(){
        return $this->controller->render($this->baseView);
    }
}