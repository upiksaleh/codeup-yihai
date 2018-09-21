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

class ActionColumn extends \yii\grid\ActionColumn
{
    public $useModal = true;
    public function init()
    {
        if(!$this->header)
            $this->header = Cii::t('codeup', 'Aksi');
        if($this->headerOptions)
            $this->headerOptions = ['class'=> '{ctheme}text-center'];
        if(!$this->contentOptions)
            $this->contentOptions = ['class'=> '{ctheme}text-center'];
        parent::init();
        $overlay = Html::tag('div', Html::faicon(['refresh','spin']), ['class'=>'overlay']);
        Modal::begin([
            'id' => 'codeup-modal-baseform',
            'header' => '<div class="text-bold"><i class="fa fa-pencil-square-o"></i> <span class="modal-title"></span></div>',
            'size' => Modal::SIZE_LARGE,
            'clientOptions' => ['backdrop' => 'static'],
            'clientEvents' => [
                'shown.bs.modal' => 'function(event){var href=$(event.relatedTarget).attr("href");$(this).find(".modal-body").load(href);$(this).find(".modal-title").text($(event.relatedTarget).attr("title"))}',
                'hidden.bs.modal' => 'function(event){$(this).find(".modal-body").html(\''.$overlay.'\');$(this).find(".modal-title").text("")}'
            ],
        ]);
        echo $overlay;
        Modal::end();

    }

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $modalOpt = ($this->useModal ? ['data-toggle'=>'modal','data-target'=>'#codeup-modal-baseform'] : []);
        $this->initDefaultButton('view', 'eye-open', $modalOpt);
        $this->initDefaultButton('update', 'pencil', $modalOpt);
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Cii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }
}