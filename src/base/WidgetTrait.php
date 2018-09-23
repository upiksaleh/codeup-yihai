<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\base;

use yii\helpers\Json;

/**
 * Class WidgetTrait
 * @package codeup\base
 */
trait WidgetTrait
{

    public $clientOptions = [];

    /**
     * @return \codeup\base\Theme
     */
    public function getViewTheme(){
        return $this->getView()->theme;
    }

    protected function getJsonClientOptions(){
        $clientOptions = ($this->clientOptions !== false ? $this->clientOptions : '{}');
        return Json::encode($this->clientOptions);
    }

    /**
     * @return \codeup\web\View objek view yang dapat dipakai untuk melakukan render dan register asset
     * @see \yii\base\Widget::getView()
     */
    abstract function getView();


}