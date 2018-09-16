<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\base;


class WebController extends \yii\web\Controller
{
    /**
     * @var string nama class base model
     */
    public $modelClass = null;
    /**
     * @var object class model
     */
    public $model = null;
    /**
     * @var string main title untuk controller
     */
    public $title;
    public function init()
    {
        parent::init();

    }
}