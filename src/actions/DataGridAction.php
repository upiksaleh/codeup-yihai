<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

/**
 * Class DataGridAction
 * @package codeup\actions
 * @property array $setGridViewFile
 */
class DataGridAction extends \codeup\base\Action
{
    public $baseView = '@codeup/views/_pages/base-datagrid';
    public $modelClass;
    public $model;
    public $dataProvider;
    public $filterModel;
    private $_settings;

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
            'query' => $this->modelClass::find(),
            'pagination' => [
                'pageSize'=> 10
            ],
            //'sort' => [
//        'attributes' => ['kode', 'nama', 'updatedAt', 'createdAt']
            //  ],
        ]);
    }

    public function run(){
        $params = array_merge([
            'modelClass' => $this->modelClass,
            'model' => $this->model,
            'dataProvider' => $this->dataProvider
        ], $this->_settings);

        return $this->controller->render($this->baseView,$params);
    }

    public function __set($name, $value)
    {
        return $this->_settings[$name] = $value;
    }
    public function __get($name)
    {
        return isset($this->_settings[$name]) ? $this->_settings[$name] : null;
    }
}