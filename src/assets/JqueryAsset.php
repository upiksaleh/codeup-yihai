<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\assets;


use yii\web\AssetBundle;

class JqueryAsset extends AssetBundle
{

    public $sourcePath = '@bower/jquery/dist';
    public $js = [
        'jquery.min.js',
    ];
}