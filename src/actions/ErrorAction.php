<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;


use yii\base\Action;

class ErrorAction extends \yii\web\ErrorAction
{
    public $view = '@codeup/views/_pages/error-page';
    public $layout = 'blank';
}