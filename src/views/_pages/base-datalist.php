<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

/** @var $this \codeup\web\View */
use codeup\theming\Html;
use codeup\theming\BoxCard;
use yii\widgets\Pjax;

BoxCard::begin([
    'type' => 'primary',
    'title' => Html::a(Html::faicon('plus').' Tambah', ['create'], ['class'=> $this->ctheme(['btn','btn-primary','btn-sm']), 'title' => Yii::t('codeup', 'Tambah Item'), 'data-modal-type'=>'insert']),
    'headerBorder' => false,
    'tools_order' => ['collapse'],
]);
echo Html::tag('table','',['class'=>'{ctheme}table-condensed']);
Pjax::begin([
]);
echo Html::beginTag('div', ['class'=>'{ctheme}table-responsive']);
echo \codeup\grid\GridView::widget([

    'tableOptions' => ['class' => $this->ctheme(['table','table-striped','table-bordered','table-condensed'])],
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\CheckboxColumn'],
        'kode',
        'nama',
        'created_at:datetime',
        'updated_at:datetime',
        [
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['class'=> '{ctheme}text-center'],
            'contentOptions' => ['class'=> '{ctheme}text-center'],
            'header' => Yii::t('codeup','Aksi'),
            'template' => '{view} {update} {delete}',
        ]
    ]
]);
echo Html::endTag('div'); // end table-responsive
Pjax::end();
BoxCard::end();