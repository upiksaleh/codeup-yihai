<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\controllers;

use codeup\models\UsersModel;
use Cii;

class UsersController extends \codeup\base\UserController
{
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>'codeup\filters\AccessControl',
                'rules' => [
                    ['allow'=>true, 'groups'=>['su']]
                ]
            ]
        ];
    }

    public function actionIndex(){

        return $this->render('index');
    }
}