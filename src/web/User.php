<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\web;

use Cii;

class User extends \yii\web\User
{
    public $groups = [];

    public $userGroupParam = '__user_group';

    public function init()
    {
        // memuat user group dari session untuk menentukan class identity
        $user_group = Cii::$app->getSession()->get($this->userGroupParam);
        if($user_group && isset($this->groups[$user_group])){
            $this->identityClass = $this->groups[$user_group];
        }
        parent::init();
    }

    /**
     * mengambil class identity group.
     * @param string $groupName
     * @return string nama class identity group
     */
    public function getIdentityGroupClass($groupName){
        if(isset($this->groups[$groupName]))
            return $this->groups[$groupName];

        return $this->identityClass;
    }

    /**
     * @param null|\yii\web\IdentityInterface $identity
     * @param int $duration
     */
    public function switchIdentity($identity, $duration = 0)
    {
        $this->setIdentity($identity);

        if (!$this->enableSession) {
            return;
        }

        /* Ensure any existing identity cookies are removed. */
        if ($this->enableAutoLogin && ($this->autoRenewCookie || $identity === null)) {
            $this->removeIdentityCookie();
        }

        $session = Cii::$app->getSession();
        if (!YII_ENV_TEST) {
            $session->regenerateID(true);
        }
        $session->remove($this->idParam);
        $session->remove($this->userGroupParam);
        $session->remove($this->authTimeoutParam);

        if ($identity) {
            $session->set($this->idParam, $identity->getId());
            // mengatur session group user
            $session->set($this->userGroupParam, $identity->getGroup());
            if ($this->authTimeout !== null) {
                $session->set($this->authTimeoutParam, time() + $this->authTimeout);
            }
            if ($this->absoluteAuthTimeout !== null) {
                $session->set($this->absoluteAuthTimeoutParam, time() + $this->absoluteAuthTimeout);
            }
            if ($this->enableAutoLogin && $duration > 0) {
                $this->sendIdentityCookie($identity, $duration);
            }
        }
    }

}