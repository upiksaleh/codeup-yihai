<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\commands;

use Yii;
use codeup\base\ConsoleController;
use yii\console\ExitCode;

class SecurityController extends ConsoleController
{
    public function actionPasswordHash($password){
        echo Yii::$app->security->generatePasswordHash($password) . "\n";
        return ExitCode::OK;
    }
}