<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\grid;


class GridView extends \yii\grid\GridView
{
    public $setColumns = [];
    public function init()
    {
        parent::init();
    }
    protected function guessColumns()
    {
        parent::guessColumns();
        if(!empty($this->setColumns) && is_array($this->setColumns)){
            $this->initSetColumns();
        }
    }

    private function initSetColumns(){
        foreach($this->columns as $i => $name){
            if(isset($this->setColumns[$name])){
                $setColumn = $this->setColumns[$name];
                if(!isset($setColumn['attribute']))
                    $setColumn['attribute'] = $name;
                $this->columns[$i] = $setColumn;
            }
        }
    }
}