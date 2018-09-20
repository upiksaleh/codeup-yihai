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

echo Html::beginTag('div', ['class' => '{ctheme}row']);
echo Html::beginTag('div', ['class' => '{ctheme}col-xs-12']);
$mainGrid = GridView::widget(ArrayHelper::merge([
    'tableOptions' => ['class' => $this->ctheme(['table','table-striped','table-bordered','table-condensed','table-hover'])],
    'dataProvider' => $filtering->getDataProvider(),
], $gridView));
$btnInsert = Html::a(Html::faicon('plus').' '.Cii::t('codeup','Tambah'), ['create'], ['class'=> $this->ctheme(['btn','btn-primary','btn-sm']), 'title' => Cii::t('codeup', 'Tambah Item')]);
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
Pjax::begin([]);
    echo Html::tag('div',$mainGrid, ['class'=>'{ctheme}table-responsive']);
Pjax::end();
BoxCard::end();
Html::endTag('div'); // end .xs-12
echo Html::endTag('div'); // end .row
