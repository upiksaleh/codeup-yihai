<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */


$config = [
    'id' => 'codeup-yihai-console',
    'basePath' => dirname(__DIR__),
    'name' => 'CodeUP Yihai Console',
    'language' => 'id',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@codeup' => dirname(__DIR__),
        '@oit' => '@vendor/oit',
    ],
    'controllerMap' => [
        'security' => 'codeup\commands\SecurityController',
    ],
    'params' => [
        'codeup' => require 'params.php',
    ]
];
return $config;