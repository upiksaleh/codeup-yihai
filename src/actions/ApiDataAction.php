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

    public $queryParams = [];

    public $fields;
    /**
     * @var \Closure
     * ```php
     *  [
     *      "dataCallback" => function($data){ return $data; }
     *  ]
     * ```
     */
    public $dataCallback = null;

    /**
     *
     */
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

    public function run()
    {
        Cii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!empty($this->queryParams))
            $queryParams = $this->queryParams;
        else
            $queryParams = Cii::$app->request->getQueryParams();
        $query = new ActiveQuery($this->modelClass);
        if($this->fields){
            $query->select($this->fields);
        }
        $data = $query
            ->filterWhere($queryParams)
            ->asArray()
            ->all();
        if($this->dataCallback !== null){
            return call_user_func($this->dataCallback, $data);
        }
        return $data;
    }
}