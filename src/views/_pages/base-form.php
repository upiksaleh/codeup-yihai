<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

/** @var $this \codeup\web\View */
/** @var $model \codeup\base\Model */
/** @var $formView string nama form */
/** @var $formLayout string layout type untuk ActiveForm */
/** @var $baseLayoutView string nama layout form*/

use codeup\theming\Html;
use codeup\theming\BoxCard;
use codeup\theming\ActiveForm;
use yii\helpers\ArrayHelper;

$this->beginContent($baseLayoutView, $_params);

$typeForm = ($model->getIsNewRecord() ?
    Yii::t('codeup', 'Tambah') :
    Yii::t('codeup', 'Update')
);
$saveBtn = Html::submitButton(Html::faicon('save') . ' ' . $typeForm,
    ['class' => $this->ctheme(['btn', 'btn-success'])]
);
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

$form = ActiveForm::begin(ArrayHelper::merge([
    'id' => 'form-'.str_replace('/','-',$this->context->getUniqueId()).'-'.$this->context->action->id,
    'layout' => $formLayout,
    'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-4',
            'offset' => 'col-sm-offset-4',
            'wrapper' => 'col-sm-8',
            'error' => '',
            'hint' => '',
        ],
    ],
], $formConfig));
if(Cii::$app->request->getIsAjax()){
    echo $this->renderFile($formView, ['model' => $model, 'form' => $form]);
    echo $saveBtn . ' ' . $cancelBtn;
}else {
    BoxCard::begin([
        'type' => 'primary',
        'footer' => true,
        'tools_order' => ['collapse'],
        'title' => $typeForm,
        'footerContent' => $saveBtn . ' ' . $cancelBtn
    ]);
    $_params['form'] = $form;
    echo $this->renderFile($formView, $_params);
    BoxCard::end();
}
ActiveForm::end();
$this->endContent();