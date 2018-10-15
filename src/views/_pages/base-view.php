<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */
/** @var $this \codeup\web\View */
use codeup\theming\BoxCard;
use codeup\theming\Html;
$this->params['breadcrumbs'][] = ['label'=> $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View';
echo Html::beginTag('div',['class'=>$this->ctheme('row')]);
foreach($detailView as $i => $detail) {
    echo Html::beginTag('div', ['class' => $this->ctheme('col-md-6')]);
    BoxCard::begin([
        'type' => 'info',
        'tools_order' => [],
        'header' => false,
        'afterBody' => $detail,

    ]);
    echo Html::tag('div', Html::faicon('th-list'). ' '. $i,['class'=>$this->ctheme('text-bold')]);
    BoxCard::end();
    echo Html::endTag('div');
}
echo Html::endTag('div');