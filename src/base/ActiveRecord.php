<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\base;


class ActiveRecord extends \yii\db\ActiveRecord
{
    private $_codeup_scenarios = [];
    public function init()
    {
        parent::init();
    }

    public function scenarios()
    {
        return array_merge(parent::scenarios(), $this->_codeup_scenarios);
    }

    public function addScenario($name, $attributes = [])
    {
        if(empty($attributes)) {
            $scenarios = parent::scenarios();
            if(isset($scenarios[self::SCENARIO_DEFAULT])){
                $attributes = $scenarios[self::SCENARIO_DEFAULT];
            }
        }
        $this->_codeup_scenarios[$name] = $attributes;
    }
}