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

echo Html::beginTag('div', ['class' => '{ctheme}row']);
echo Html::beginTag('div', ['class' => '{ctheme}col-xs-12']);

$btnInsertOptions = ['class' => $this->ctheme(['btn', 'btn-primary', 'btn-sm']), 'title' => Cii::t('codeup', 'Tambah Item')];
if ($useModal) {
    $btnInsertOptions['data-toggle'] = 'modal';
    $btnInsertOptions['data-target'] = '#codeup-basemodal';
}

$btnInsert = Html::a(Html::faicon('plus') . ' ' . Cii::t('codeup', 'Tambah'), ['create'], $btnInsertOptions);
$boxTitle = '{insert}';
if (isset($boxCard['title'])) {
    $boxTitle = $boxCard['title'];
    unset($boxCard['title']);
} else {
    $boxTitle = '{insert}';
}
$boxTitle = strtr($boxTitle, ['{insert}' => $btnInsert]);
BoxCard::begin(ArrayHelper::merge([
    'type' => 'primary',
    'title' => $boxTitle,
    'headerBorder' => true,
    'tools_order' => ['collapse'],
], $boxCard));
if($filtering !== false) {
    $filtering->renderForm();
}
Pjax::begin([
    'enablePushState' => false,
    'timeout' => false,
    'clientOptions' => [
        'method' => 'GET',
    ]
]);

echo Html::beginTag('div',['class' => '{ctheme}table-responsive']);
echo GridView::widget(ArrayHelper::merge([
    'behaviors' => [
        [
            'class' => '\dosamigos\grid\behaviors\LoadingBehavior',
            'type' => 'bars'
        ],
        [
            'class' => '\dosamigos\grid\behaviors\ResizableColumnsBehavior',
        ]
    ],
    'tableOptions' => ['class' => $this->ctheme(['table', 'table-striped', 'table-bordered', 'table-condensed', 'table-hover'])],
    'dataProvider' => $dataProvider,
    'filterModel' => $model->getFilterModel()
], $gridView));
echo Html::endTag('div');
Pjax::end();
BoxCard::end();
Html::endTag('div'); // end .xs-12
echo Html::endTag('div'); // end .row
