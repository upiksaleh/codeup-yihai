<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\base;


class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>'codeup\filters\AccessControl',
                'rules' => [
                    ['allow'=>true, 'roles'=>['@']]
                ]
            ]
        ];
    }
}