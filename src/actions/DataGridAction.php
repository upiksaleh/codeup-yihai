<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

use Cii;
use codeup\grid\Filtering;
use codeup\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class DataGridAction
 * @package codeup\actions
 * @property array $setGridViewFile
 */
class DataGridAction extends \codeup\base\Action
{
    public $baseView = '@codeup/views/_pages/base-datagrid';
    public $modelClass;
    /** @var null|\codeup\base\Model */
    public $model = null;
    /** @var ActiveDataProvider */
    public $dataProvider;
    /** @var Filtering */
    public $filtering = [];
    /** @var GridView */
    public $gridView = [];
    /** @var \codeup\theming\BoxCard */
    public $boxCard = [];
    /** @var string */
    public $boxButton = '{insert}';

    public $useModal = true;
    private $_settings = [];

    public function init()
    {
        parent::init();
        if (isset($this->controller->modelClass) && ($this->controller->modelClass !== null) && $this->modelClass === null) {
            $this->modelClass = $this->controller->modelClass;
        }

        if (isset($this->controller->model) && ($this->controller->model !== null) && $this->model === null) {
            $this->model = $this->controller->model;
        }
        if($this->model === null){
            $this->model = new $this->modelClass();
        }
        $this->initFiltering();
        $this->initGridView();
    }

    public function run()
    {
        $this->dataProvider = $this->filtering->getDataProvider();
        if($this->model->hasMethod('searchDataProvider')){
            $this->model->searchDataProvider($this->dataProvider);
        }

        $params = array_merge([
            'modelClass' => $this->modelClass,
            'model' => $this->model,
            'boxButton' => $this->boxButton,
            'boxCard' => $this->boxCard,
            'filtering' => $this->filtering,
            'dataProvider' => $this->dataProvider,
            'gridView' => $this->gridView,
            'useModal' => $this->useModal
        ], $this->_settings);

        return $this->controller->render($this->baseView, $params);
    }

    private function initGridView()
    {

    }

    private function initFiltering()
    {
        $this->filtering = Cii::createObject(ArrayHelper::merge([
            'class' => 'codeup\grid\Filtering',
            'modelClass' => $this->modelClass,
        ], $this->filtering));
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