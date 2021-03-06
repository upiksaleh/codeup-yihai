<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

/** @var \codeup\web\View $this*/

use codeup\theming\Html;
use yii\widgets\Pjax;
use codeup\theming\BoxCard;
use yii\helpers\ArrayHelper;
use codeup\grid\GridView;

$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Data';

echo Html::beginTag('div', ['class' => '{ctheme}row']);
echo Html::beginTag('div', ['class' => '{ctheme}col-xs-12']);

$btnInsertOptions = ['class' => $this->ctheme(['btn', 'btn-primary', 'btn-sm']), 'title' => Cii::t('codeup', 'Tambah Item'), 'data-modal-type' => 'insert'];
$btnImportOptions = ['class' => $this->ctheme(['btn', 'btn-default', 'btn-sm']), 'title' => Cii::t('codeup', 'Import Data'), 'data-modal-type' => 'import'];
$btnExportOptions = ['class' => $this->ctheme(['btn', 'btn-default', 'btn-sm']), 'title' => Cii::t('codeup', 'Export Data'), 'data-modal-type' => 'export'];
if ($useModal) {
    $btnInsertOptions['data-toggle'] = 'modal';
    $btnInsertOptions['data-target'] = '#codeup-basemodal';
    $btnImportOptions['data-toggle'] = 'modal';
    $btnImportOptions['data-target'] = '#codeup-basemodal';
    $btnExportOptions['data-toggle'] = 'modal';
    $btnExportOptions['data-target'] = '#codeup-basemodal';
}

$btnInsert = "";
$btnImport = "";
$btnExport = "";
try {
    if ($this->context instanceof \codeup\base\BaseCrudController && $this->context->haveAccessAction('create')) {
        $btnInsert = Html::a(Html::faicon('plus') . ' ' . Cii::t('codeup', 'Tambah'), [$this->context->getUniqueId() . '/create'], $btnInsertOptions);
    }
} catch (\yii\base\InvalidConfigException $e) {
}
try {
    if ($this->context instanceof \codeup\base\BaseCrudController && $this->context->haveAccessAction('import')) {
        $btnImport = Html::a(Html::faicon('upload') . ' ' . Cii::t('codeup', 'Import'), [$this->context->getUniqueId() . '/import'], $btnImportOptions);
    }
} catch (\yii\base\InvalidConfigException $e) {
}
try {
    if ($this->context instanceof \codeup\base\BaseCrudController && $this->context->haveAccessAction('export')) {
        $btnExport = Html::a(Html::faicon('download') . ' ' . Cii::t('codeup', 'Export'), [$this->context->getUniqueId() . '/export'], $btnExportOptions);
    }
} catch (\yii\base\InvalidConfigException $e) {
}
$boxTitle = '{insert}';
if (isset($boxCard['title'])) {
    $boxTitle = $boxCard['title'];
    unset($boxCard['title']);
}
if ($btnImport || $btnExport) {
    $boxTitle .= ' <span class="btn-group">';
    if ($btnImport)
        $boxTitle .= '{import}';
    if ($btnExport)
        $boxTitle .= '{export}';
    $boxTitle .= '</span>';
}
$boxTitle = strtr($boxTitle, [
    '{insert}' => $btnInsert,
    '{import}' => $btnImport,
    '{export}' => $btnExport,
]);
BoxCard::begin(ArrayHelper::merge([
    'type' => 'primary',
    'title' => $boxTitle,
    'headerBorder' => true,
    'tools_order' => ['collapse'],
], $boxCard));
if ($showFiltering !== false) {
    $filtering->renderForm();
}
Pjax::begin([
    'enablePushState' => false,
    'timeout' => false,
    'clientOptions' => [
        'method' => 'GET',
    ]
]);

echo Html::beginTag('div', ['class' => '{ctheme}table-responsive']);
echo GridView::widget(ArrayHelper::merge([
    'behaviors' => [
        [
            'class' => '\dosamigos\grid\behaviors\LoadingBehavior',
            'type' => 'bars'
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
