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
    /**
     * @param $status
     * @return string
     */
    public function asYesno($status){
        if($status == 1)
            return Cii::t('codeup', 'Ya');
        elseif($status == 0)
            return Cii::t('codeup', 'Tidak');
        return $status;
    }
    /**
     * @param $sex
     * @return string
     */
    public function asSex($sex){
        if($sex == 'L')
            return Cii::t('codeup', 'Pria');
        elseif($sex == 'P')
            return Cii::t('codeup', 'Wanita');
        return $status;
    }
}