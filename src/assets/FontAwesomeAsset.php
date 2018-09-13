<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\assets;


class FontAwesomeAsset extends \yii\web\AssetBundle
{
    public $sourcePath = __DIR__ . '/dist/fontawesome';
    public $css = [
        'css/font-awesome.min.css'
    ];
}