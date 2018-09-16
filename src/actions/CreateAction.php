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
 * @property \codeup\base\Controller $controller
 */
class CreateAction extends BaseFormAction
{

   public function init()
   {
       $this->scenario = 'create';
       $this->type = 'create';
       $this->messageSuccess = 'Berhasil Tambah.!';
       $this->messageError = 'Gagal Tambah.!';
       parent::init();
   }

}
