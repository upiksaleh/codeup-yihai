<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;

class Bootstrap implements BootstrapInterface
{
    /**
     * @param \yii\base\Application $app
     * @throws \yii\base\InvalidConfigException
     */
    public function bootstrap($app)
    {
        if(YII_ENV_DEV){
            defined('CODEUP_DEV') or define('CODEUP_DEV', true);
        }
        Yii::$container->set('yii\web\JqueryAsset', 'codeup\assets\JqueryAsset');
        Yii::$container->set('yii\helpers\Html', 'codeup\theming\Html');
        Yii::$container->set('yii\helpers\BaseHtml', 'codeup\theming\BaseHtml');

        Yii::$classMap['yii\helpers\Html'] = '@codeup/classmap/Html.php';

        //bootstrap theme
        if(!Yii::$app->view instanceof \codeup\web\View)
            throw new InvalidConfigException(Yii::t('codeup', 'Komponen view harus menggunakan class {class}',['class'=>'codeup\web\view']));

        Yii::$app->view->theme->bootstrap($app);

        if ($app->modules) {
            foreach ($app->modules as $name => $config) {
                $module = $app->getModule($name);
                if($module instanceof \codeup\base\Module){
                    $module->codeup_bootstrap($app);
                }
            }
        }
    }
}