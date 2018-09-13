<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\assets;


class BootstrapAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/bootstrap/dist';
    public $css = [
        'css/bootstrap.min.css',
    ];

    public $js = [
        'js/bootstrap.min.js',
    ];

    public $depends = [
        'codeup\assets\JqueryAsset'
    ];
}