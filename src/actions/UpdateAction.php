<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;


/**
 * Class UpdateAction
 * @package codeup\actions
 */
class UpdateAction extends BaseFormAction
{

    public $baseLayoutView = '@codeup/views/_pages/base-update';
    public function init()
    {
        $this->scenario = 'update';
        $this->type = 'update';
        $this->messageSuccess = 'Berhasil Update.!';
        $this->messageError = 'Gagal Update.!';
        parent::init();
    }
}
