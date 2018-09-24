<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

use Cii;
use yii\db\ActiveQuery;
use yii\rest\ActiveController;

/**
 * Class ApiDataAction
 * @package codeup\actions
 */
class ApiDataAction extends \codeup\base\Action
{
    /** @var string|\codeup\base\ActiveRecord */
    public $modelClass;
    /** @var \codeup\base\ActiveRecord */
    public $model;

    public function init()
    {
        parent::init();
        if (isset($this->controller->modelClass) && ($this->controller->modelClass !== null) && $this->modelClass === null) {
            $this->modelClass = $this->controller->modelClass;
        }

        if (isset($this->controller->model) && ($this->controller->model !== null) && $this->model === null) {
            $this->model = $this->controller->model;
        }
    }

    public function run(){
        Cii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $queryParams = Cii::$app->request->getQueryParams();
        $query = new ActiveQuery($this->modelClass);
        return [
            'results' =>  $query
                ->filterWhere($queryParams)
                ->asArray()
                ->all(),
        ];
    }
}