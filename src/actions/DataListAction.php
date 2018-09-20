<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

use yii\helpers\ArrayHelper;

/**
 * Class DataListAction
 * @package codeup\actions
 * @property \codeup\base\Controller $controller
 */
class DataListAction extends \codeup\base\Action
{

    public $baseView = '@codeup/views/_pages/base-datalist';
    public $modelClass;
    public $model;
    public $dataProvider;
    public $filterModel;

    public function init()
    {
        parent::init();
        if (isset($this->controller->modelClass) && ($this->controller->modelClass !== null) && $this->modelClass === null) {
            $this->modelClass = $this->controller->modelClass;
        }

        if (isset($this->controller->model) && ($this->controller->model !== null) && $this->model === null) {
            $this->model = $this->controller->model;
        }
        $this->dataProvider = new \yii\data\ActiveDataProvider([
            'query' =>$this->modelClass::find(),
            'pagination' => [
                'pageSize'=>10
            ],
            //'sort' => [
//        'attributes' => ['kode', 'nama', 'updatedAt', 'createdAt']
            //  ],
        ]);
    }

    public function run(){
        return $this->controller->render($this->baseView,[
            'modelClass' => $this->modelClass,
            'model' => $this->model,
            'dataProvider' => $this->dataProvider
        ]);
    }
}