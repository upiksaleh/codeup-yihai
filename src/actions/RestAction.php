<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

use Cii;
use codeup\base\BaseRestController;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

/**
 * Class RestAction
 * @package codeup\actions
 */
class RestAction extends \yii\base\Action
{
    /** @var \codeup\base\ActiveRecord */
    public $modelClass;
    public $model;

    public $restConfig = [];

    public $searchModel = [];
    public function init()
    {
        parent::init();
        if (isset($this->controller->modelClass) && ($this->controller->modelClass !== null) && $this->modelClass === null) {
            $this->modelClass = $this->controller->modelClass;
        }

        if (isset($this->controller->model) && ($this->controller->model !== null) && $this->model === null) {
            $this->model = $this->controller->model;
        }
        if(empty($this->searchModel)){
            $this->searchModel = new \yii\base\DynamicModel();
        }
    }

    public function run($action = 'index')
    {

        $restConfig = ArrayHelper::merge([
            'modelClass' => $this->modelClass,
            'serializer' => [
                'class' => 'yii\rest\Serializer',
                'collectionEnvelope' => 'items',
            ],
            'actions' => [
                'index' => [
                    'dataFilter' => [
                        'class' => 'yii\data\ActiveDataFilter',
                        'searchModel' => $this->searchModel,
                    ]
                ]
            ]
        ], $this->restConfig);
        $activeController = new BaseRestController('rest', $this->controller, $restConfig);
        return $activeController->runAction($action);
    }
}