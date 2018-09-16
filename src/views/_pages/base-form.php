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

$this->beginContent($baseLayoutView);

$typeForm = ($model->getIsNewRecord() ?
    Yii::t('codeup', 'Tambah') :
    Yii::t('codeup', 'Update')
);
$saveBtn = Html::submitButton(Html::faicon('save') . ' ' . $typeForm,
    ['class' => $this->ctheme(['btn', 'btn-success'])]
);
$cancelBtn = Html::a(Html::faicon('refresh') . ' ' . Yii::t('codeup', 'Batal'),
    ['index'],
    ['class' => $this->ctheme(['btn', 'btn-default'])]
);
$form = ActiveForm::begin([
    'id' => 'form-'.$this->context->getUniqueId().'-'.$this->context->action->id,
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
]);
BoxCard::begin([
    'type' => 'primary',
    'footer' => true,
    'tools_order' => ['collapse'],
    'title'=> $typeForm,
    'footerContent' => $saveBtn . ' ' . $cancelBtn
]);

echo $this->renderFile($formView, ['model' => $model, 'form' => $form]);

BoxCard::end();
ActiveForm::end();
$this->endContent();