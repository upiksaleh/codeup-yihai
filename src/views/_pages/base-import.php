<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

/** @var $this \codeup\web\View */
/** @var $model \codeup\base\Model|\codeup\base\ActiveRecord */
/** @var $dynModel \yii\base\DynamicModel */
/** @var $formView string nama form */
/** @var $formLayout string layout type untuk ActiveForm */

/** @var $baseLayoutView string nama layout form */

use codeup\theming\Html;
use codeup\theming\BoxCard;
use codeup\theming\ActiveForm;

$this->params['breadcrumbs'][] = ['label'=> $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Import';

if(Cii::$app->request->getIsAjax()) {
    $cancelBtn = Html::button(Html::faicon('undo') . ' ' . Yii::t('codeup', 'Batal'),
        ['class' => $this->ctheme(['btn', 'btn-default']), 'data-dismiss' => 'modal']
    );
}else{
    $cancelBtn = Html::a(Html::faicon('undo') . ' ' . Yii::t('codeup', 'Batal'),
        ['index'],
        ['class' => $this->ctheme(['btn', 'btn-default'])]
    );
}

echo Html::beginTag('div', ['class' => '{ctheme}row']);
echo Html::beginTag('div', ['class' => '{ctheme}col-sm-8']);

$form = ActiveForm::begin([
    'layout' => 'horizontal',
    'id'=>'importgo'
]);
BoxCard::begin([
    'title' => 'Upload Import File',
    'tools_order' => []
]);
echo $form->field($dynModelImport, 'file')->fileInput();
echo Html::submitButton(Html::faicon('upload') . ' Import Data', ['class' => '{ctheme}btn {ctheme}btn-success']);
BoxCard::end();
ActiveForm::end();
echo Html::endTag('div');
echo Html::beginTag('div', ['class' => '{ctheme}col-sm-4']);
$form = ActiveForm::begin([
    'layout' => 'default',
    'attributes' => ['a'],
    'id'=>'importcontoh'
]);

BoxCard::begin([
    'title' => Yii::t('codeup', 'Contoh Import'),
    'tools_order' => []
]);
echo $form->field($dynModel, 'columns')->checkboxList($modelColumn,['name'=>'dynContoh[columns]'])->label(Yii::t('codeup', 'Kolom Data'));
echo Html::submitButton(Html::faicon('download').' Download Contoh', ['class' => '{ctheme}btn {ctheme}btn-success']);
BoxCard::end();
ActiveForm::end();
echo Html::endTag('div');
echo Html::beginTag('div', ['class' => '{ctheme}col-sm-12']);
echo $cancelBtn;
echo Html::endTag('div');
echo Html::endTag('div');
