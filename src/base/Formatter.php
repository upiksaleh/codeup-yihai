<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\base;

use Cii;

class Formatter extends \yii\i18n\Formatter
{
    /**
     * @param $status
     * @return string
     */
    public function asActivestatus($status){
        if($status == 1)
            return Cii::t('codeup', 'Aktif');
        elseif($status == -1)
            return Cii::t('codeup', 'Deleted');
        elseif($status == 0)
            return Cii::t('codeup', 'Tidak Aktif');
        return $status;
    }
}