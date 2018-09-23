<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\base;

use Cii;
use codeup\filters\AccessControl;

/**
 * Class Action
 * @package codeup\base
 */
class Action extends \yii\base\Action
{
    /**
     * @var array access rules
     * ```php
     *  'access_rules' => [
     *      ['allow'=>true, 'groups'=>['su']
     *  ]
     * ```
     */
    public $access_rules;

    /**
     * @var array grup yang bisa mengakses
     * ```php
     *  'groupsCanAccess' => ['su','admin','operator','etc']
     * ```
     */
    public $groupsCanAccess;

    public function init()
    {
        if (!empty($this->access_rules)) {
            $this->controller->attachBehavior('codeup_access_action', [
                'class' => 'codeup\filters\AccessControl',
                'rules' => $this->access_rules
            ]);
        }
        if (!empty($this->groupsCanAccess) && !Cii::$app->user->isGuest) {
            $this->controller->attachBehavior('codeup_access_action_groups', [
                'class' => 'codeup\filters\AccessControl',
                'rules' => [
                    ['allow' => true, 'groups' => $this->groupsCanAccess],
                ]
            ]);
        }
        parent::init();
    }

}