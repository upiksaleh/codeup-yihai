<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\web;

use codeup\theming\Html;
class View extends \yii\web\View
{
    public $theme = 'codeup\base\Theme';
    public function afterRender($viewFile, $params, &$output)
    {
        parent::afterRender($viewFile, $params, $output);
    }

    /**
     * @param string|array $str
     * @return string
     */
    public function ctheme($str){
        return Html::ctheme($str);
    }
}