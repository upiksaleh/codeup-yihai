<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */


$config = [
    'id' => 'codeup-yihai',
    'basePath' => dirname(__DIR__),
    'name' => 'CodeUP Yihai',
    'language' => 'id',
    //'sourceLanguage' => 'id',
    'bootstrap'=>[
        'codeup\Bootstrap'
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@codeup' => dirname(__DIR__),
        '@oit' => '@vendor/oit',
    ],
    'layoutPath' => '@codeup/views/_layouts',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-codeup',
            'cookieValidationKey' => 'CodeUP-yihai-0ksain29912samk',
        ],
        'session'=>[
            'name' => 'codeup-yihai',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [

            'identityClass' => 'codeup\models\UserIdent',

        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ],
        'menu' => [
            'class' => 'codeup\components\Menu',
        ],
        'view' => [
            'class' => 'codeup\web\View',
        ],
        'i18n' => [
            'translations' => [
                'codeup*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@codeup/messages',
                ]
            ]
        ],
        'assetManager' => [
            'bundles' => [
            ],
        ],
    ],
    'modules'   => require 'modules.php',
    'params'    => require 'params.php',
];
return $config;