<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

use Yii;
use yii\filters\VerbFilter;
use yii\web\MethodNotAllowedHttpException;

class LogoutAction extends \yii\base\Action
{
    public $method_allowed = ['POST'];

    protected function beforeRun()
    {
        $verb = Yii::$app->getRequest()->getMethod();
        $allowed = array_map('strtoupper', $this->method_allowed);
        if (!in_array($verb, $allowed)) {
            // https://tools.ietf.org/html/rfc2616#section-14.7
            Yii::$app->getResponse()->getHeaders()->set('Allow', implode(', ', $allowed));
            throw new MethodNotAllowedHttpException('Method Not Allowed. This URL can only handle the following request methods: ' . implode(', ', $allowed) . '.');
        }
        return parent::beforeRun();
    }

    public function run(){
        Yii::$app->user->logout();
        return $this->controller->goHome();
    }
}