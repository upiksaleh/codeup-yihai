<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

/**
 * Class CreateAction
 * @package codeup\actions
 */
class CreateAction extends BaseFormAction
{

    public $baseLayoutView = '@codeup/views/_pages/base-create';

    public function init()
    {
        $this->scenario = 'create';
        $this->type = 'create';
        $this->messageSuccess = 'Berhasil Tambah.!';
        $this->messageError = 'Gagal Tambah.!';
        parent::init();
    }

}
