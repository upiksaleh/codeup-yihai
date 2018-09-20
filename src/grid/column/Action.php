<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\grid\column;

use Cii;
use yii\grid\ActionColumn;

class Action extends ActionColumn
{
    public function init()
    {
        if(!$this->header)
            $this->header = Cii::t('codeup','Aksi');
        if($this->headerOptions)
            $this->headerOptions = ['class'=> '{ctheme}text-center'];
        if(!$this->contentOptions)
            $this->contentOptions = ['class'=> '{ctheme}text-center'];
        parent::init();
    }
}