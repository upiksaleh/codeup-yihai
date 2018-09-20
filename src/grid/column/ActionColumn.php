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
use yii\grid\ActionColumn;

class Action extends ActionColumn
{
    public function init()
    {
        if(!$this->header)
            $this->header = Cii::t('codeup','Aksi');
        if($this->headerOptions)
            $this->headerOptions = ['class'=> '{ctheme}text-center'];
        if(!$this->contentOptions)
            $this->contentOptions = ['class'=> '{ctheme}text-center'];
        parent::init();
        Modal::begin([
            'id' => 'modal-gridcolumn-action',
            'header' => '<div class="text-bold"><i class="fa fa-pencil-square-o"></i> <span class="modal-title"></span></div>',
            'size' => Modal::SIZE_LARGE,
            'clientOptions' => ['backdrop' => 'static'],
            'clientEvents' => [
                'shown.bs.modal' => 'function(event){var href=$(event.relatedTarget).attr("href");$(this).find(".modal-body").load(href);$(this).find(".modal-title").text($(event.relatedTarget).attr("title"))}',
                'hidden.bs.modal' => 'function(event){$(this).find(".modal-body").html(\'<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>\');$(this).find(".modal-title").text("")}'
            ],
        ]);
        echo Html::tag('div', Html::faicon(['refresh','spin']), ['overlay']);
        Modal::end();
    }
}