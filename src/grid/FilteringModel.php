<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\grid;

use Cii;

class FilteringModel extends \codeup\base\Model
{
    public $resetall = 0;
    public $limit = 10;
    public $order = ['base0' => ''];
    public $op = [];
    public $column = ['base0' => ''];
    public $andor = ['base0' => 'AND'];
    public $value = [];

    public function rules()
    {
        return [
            [['resetall', 'op', 'column', 'andor', 'value', 'order'], 'safe'],
            ['limit', 'number'],
            ['order', 'checkValOrder', 'params' => ['ASC', 'DESC']],
            ['andor', 'checkValIn', 'params' => ['AND', 'OR']],
            ['op', 'checkValIn', 'params' => ['=', '<>', '!=', '<=>', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'IS', 'IS NULL', 'IS NOT NULL', 'BETWEEN']]
        ];
    }

    public function checkValOrder($attribute, $params)
    {
        foreach ($this->{$attribute} as $i => $val) {
            if (!isset($val['column']) || !isset($val['val'])) {
                return $this->addError($attribute, Cii::t('codeup', 'Value tidak valid.'));
            }
            if (!in_array($val['val'], $params)) {
                return $this->addError($attribute, Cii::t('codeup', 'Value tidak valid.'));
            }
        }

    }

    public function checkValIn($attribute, $params)
    {
        foreach ($this->{$attribute} as $i => $val) {
            if (!in_array($val, $params)) {
                $this->addError($attribute, Cii::t('codeup', 'Value tidak valid.'));
            }
        }
    }
}
