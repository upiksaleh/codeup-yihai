<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\grid\column;

use Cii;
use codeup\theming\Html;
use codeup\theming\Modal;
use yii\helpers\ArrayHelper;

class ActionColumn extends \yii\grid\ActionColumn
{
    /** @var bool jika false maka tidak akan menggunakan modal untuk form */
    public $useModal = true;
    /** @var array query params pada url */
    public $queryParams = [];

    public function init()
    {
        if(!$this->header)
            $this->header = Cii::t('codeup', 'Aksi');
        if($this->headerOptions)
            $this->headerOptions = ['class'=> '{ctheme}text-center'];
        if(!$this->contentOptions)
            $this->contentOptions = ['class'=> '{ctheme}text-center'];
        parent::init();

    }
    public function createUrl($action, $model, $key, $index)
    {
        if(!empty($this->queryParams)){
            $key = [];
            foreach($this->queryParams as $k){
                $key[$k] = $model->{$k};
            }
        }else{
            $key = $model->getPrimaryKey(true);
        }
        return parent::createUrl($action, $model, $key, $index);
    }

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye-open', ($this->useModal ? ['data-toggle'=>'modal','data-target'=>'#codeup-basemodal', 'data-modal-type'=>'view'] : []));
        $this->initDefaultButton('update', 'pencil', ($this->useModal ? ['data-toggle'=>'modal','data-target'=>'#codeup-basemodal', 'data-modal-type'=>'update'] : []));
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Cii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
            'data-modal-type'=>'delete'
        ]);
    }
}