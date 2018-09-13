<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\filters;


class AccessRule extends \yii\filters\AccessRule
{
    public $groups   = [];

    /**
     * Checks whether the Web user is allowed to perform the specified action.
     * @param Action $action the action to be performed
     * @param \yii\web\User|false $user the user object or `false` in case of detached User component
     * @param Request $request
     * @return bool|null `true` if the user is allowed, `false` if the user is denied, `null` if the rule does not apply to the user
     */
    public function allows($action, $user, $request)
    {
        if ($this->matchAction($action)
            && $this->matchRole($user)
            && $this->matchGroup($user)
            && $this->matchIP($request->getUserIP())
            && $this->matchVerb($request->getMethod())
            && $this->matchController($action->controller)
            && $this->matchCustom($action)
        ) {
            return $this->allow ? true : false;
        }

        return null;
    }

    /**
     * untuk menggunakan match group, user identityClass harus menggunakan class \codeup\models\UserIdent
     * @param \yii\web\User $user
     */
    public function matchGroup($user){
        return empty($this->groups) || in_array($user->identity->getGroup(), $this->groups, true);
    }
}