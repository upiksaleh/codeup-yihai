<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\filters;


/**
 * Class AccessControl
 * @package codeup\filters
 */
class AccessControl extends \yii\filters\AccessControl
{
    /**
     * @var array
     */
    public $ruleConfig = ['class' => 'codeup\filters\AccessRule'];
}