<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

use codeup\models\form\LoginForm;
use Yii;

class LoginAction extends \yii\base\Action
{
    public function init()
    {
        parent::init();
        $this->controller->layout = 'guest';
    }

    /**
     * @return string|\yii\web\Response
     */
    public function run(){
        // jika bukan guest atau telah menjadi user
        if(!Yii::$app->user->isGuest)
            return $this->controller->goHome();     // redirect ke home

        // model form login
        $modelForm = new LoginForm();
        if ($modelForm->load(Yii::$app->request->post()) && $modelForm->login()) {
            return $this->controller->goBack();
        }
        $modelForm->password = '';

        // render login page
        return $this->controller->render('@codeup/views/_pages/login-page',[
            'model' => $modelForm
        ]);
    }
}