<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\base;
use Cii;

/**
 * Trait BaseModelTrait
 * @package codeup\base
 */
trait BaseModelTrait
{
    private $_codeup_scenarios = [];
    /** @var FilterModel */
    private $_filterModel;
    public function init()
    {
        parent::init();
        if(!empty($this->filterRules())){
            $rule_keys = [];
            foreach($this->filterRules() as $i => $rules){
                $rule_keys[] = $rules[0];
            }
            $filterModel = new FilterModel($rule_keys);
            foreach($this->filterRules() as $i => $rules){
                $filterModel->addRule($rules[0], $rules[1]);
            }

            $this->_filterModel = $filterModel;
        }
    }

    public function scenarios()
    {
        return array_merge($this->_codeup_scenarios, parent::scenarios());
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

    public function filterRules(){
        return [];
    }

    public function filterSort(){
        return [];
    }

    /**
     * @param $dataProvider \yii\data\ActiveDataProvider
     */
    public function searchDataProvider(&$dataProvider){
        if($this->_filterModel === null)
            return;
        $params = Cii::$app->request->getBodyParams();
        if(empty($params))
            $params = Cii::$app->request->getQueryParams();
        if($this->_filterModel->load($params) && $this->_filterModel->validate()){
            $this->onSearch($dataProvider->query, $this->_filterModel);
        }
    }

    /**
     * @param $query \yii\db\ActiveQuery
     * @param $filterModel FilterModel
     * @return \yii\db\ActiveQuery
     */
    public function onSearch(&$query, $filterModel){

    }
    public function getFilterModel(){
        return $this->_filterModel;
    }
    public function getDataProvider(){

    }
}