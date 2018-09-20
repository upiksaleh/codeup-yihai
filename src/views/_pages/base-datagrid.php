<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */
/** @var $this \codeup\web\View */
use \codeup\theming\BoxCard;
BoxCard::begin([
    'type' => 'primary',
    'tools_order' => ['collapse'],
    'bodyOptions' => ['class'=>'asa']
]);
//echo $this->render('setGridViewFile');
BoxCard::end();
