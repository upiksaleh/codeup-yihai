<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

/** @var $this \codeup\web\View */

use codeup\theming\Html;
use yii\widgets\Pjax;
use codeup\theming\BoxCard;
use codeup\theming\ActiveForm;
use yii\helpers\ArrayHelper;
use codeup\grid\GridView;
use codeup\theming\Modal;

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
echo Html::beginTag('div', ['class' => '{ctheme}row']);
echo Html::beginTag('div', ['class' => '{ctheme}col-xs-12']);
$mainGrid = GridView::widget(ArrayHelper::merge([
    'tableOptions' => ['class' => $this->ctheme(['table','table-striped','table-bordered','table-condensed','table-hover'])],
    'dataProvider' => $filtering->getDataProvider(),
], $gridView));
$btnInsertOptions = ['class'=> $this->ctheme(['btn','btn-primary','btn-sm']), 'title' => Cii::t('codeup', 'Tambah Item')];
if($useModal){
    $btnInsertOptions['data-toggle']='modal';
    $btnInsertOptions['data-target']='#codeup-modal-baseform';
}

$btnInsert = Html::a(Html::faicon('plus').' '.Cii::t('codeup','Tambah'), ['create'], $btnInsertOptions);
$boxTitle = '{insert}';
if(isset($boxCard['title'])){
    $boxTitle = $boxCard['title'];
    unset($boxCard['title']);
}else{
    $boxTitle = '{insert}';
}
$boxTitle = strtr($boxTitle, ['{insert}' => $btnInsert]);
BoxCard::begin(ArrayHelper::merge([
    'type' => 'primary',
    'title' => $boxTitle,
    'headerBorder' => true,
    'tools_order' => ['collapse'],
],$boxCard));
$filtering->renderForm();
Pjax::begin([
    'enablePushState' => false,
]);
    echo Html::tag('div',$mainGrid, ['class'=>'{ctheme}table-responsive']);
Pjax::end();
BoxCard::end();
Html::endTag('div'); // end .xs-12
echo Html::endTag('div'); // end .row
