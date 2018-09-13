<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\assets;


use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle
{
    public $sourcePath = __DIR__.'/dist';
    public $css = [

    ];
    public $depends = [
        'codeup\assets\AdminLTEAsset'
    ];
}