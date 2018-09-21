<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

use Cii;
use codeup\theming\DetailView;
use codeup\widgets\ListView;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Class ViewAction
 * @package codeup\actions
 */
class ViewAction extends BaseCrudAction
{
    public $baseLayoutView = '@codeup/views/_pages/base-view';
    /** @var ListView */
    public $listView = [];
    /** @var array */
    private $detailView = [];
    /** @var DetailView */
    public $detailViewOptions = [];

    public $attributes;
    public function init(){
        if(!$this->attributes){
            throw new InvalidConfigException(Cii::t('codeup', 'Definisikan terlebih dahulu attribut pada action.'));
        }
        parent::init();
    }
    public function run(){
        $this->model = $this->getModel();
        $this->initListView();
        $this->initDetailView();
        $params = [
            'model' => $this->model,
            'listView' => $this->listView,
            'detailView' => $this->detailView,
        ];
        if(Cii::$app->request->getIsAjax()) {
            return $this->controller->renderAjax($this->baseLayoutView, $params);
        }else{
            return $this->controller->render($this->baseLayoutView, $params);
        }
    }
    private function getModel(){
        $id = Cii::$app->request->getQueryParams();
        return $this->findModel($id);
    }
    private function initDetailView(){
        foreach($this->attributes as $i => $attribute) {
            $this->detailView[Cii::t('codeup',ucfirst($i))] = DetailView::widget(ArrayHelper::merge([
                'id' => 'codeup-detailview-'.$i,
                'model' => $this->model,
                'attributes' => $attribute
            ], $this->detailViewOptions));
        }
    }
    private function initListView(){

    }
}