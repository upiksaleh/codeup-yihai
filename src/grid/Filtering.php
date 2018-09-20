<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\grid;

use Cii;
use codeup\theming\BoxCard;
use yii\base\BaseObject;
use codeup\theming\ActiveForm;
use yii\base\DynamicModel;
use codeup\theming\Html;

/**
 * advanced filtering
 * Class Filtering
 * @package codeup\grid
 */
class Filtering extends BaseObject
{

    public $id;
    public $modelClass;
    /** @var \codeup\base\ActiveRecord|\codeup\base\Model */
    public $model;
    /** @var FilteringModel */
    public $formModel;
    /** @var \codeup\theming\ActiveForm */
    private $_form;
    private $_dataProvider;
    /** @var \yii\db\ActiveQuery */
    private $_query;
    /** @var \yii\db\TableSchema */
    public $tableSchema;
    /** @var array list attribut */
    private $_attributes = [];
    /** @var string nama form yang akan dipakai pada form */
    public $formModelName;
    /** @var array default order */
    public $defaultOrder = [];
    /** @var array base where, akan ditambahkan pada akhir query */
    public $baseWhere = [];

    public function init()
    {
        parent::init();
        if (!$this->model) {
            $this->model = new $this->modelClass();
        }
        $this->tableSchema = $this->model::getTableSchema();
        $this->initAttributes();
        if (!$this->id) {
            $this->id = $this->model::getTableSchema()->name;
        }
        if (!$this->formModelName) {
            $this->formModelName = 'FilteringModel-' . $this->id;
        }
        $this->_query = $this->model::find();
        $this->createFormModel();
        $this->initDataProvider();

    }

    public function initAttributes()
    {
        foreach ($this->tableSchema->columnNames as $column) {
            $this->_attributes[$column] = $this->model->getAttributeLabel($column);
        }
    }

    public function initDataProvider()
    {

        $this->_dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $this->_query,
            'pagination' => [
                'pageSize' => $this->formModel->limit
            ],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuery()
    {
        return $this->_query;
    }

    /**
     * membuat formModel dan menyeleksi query jika model di load dari post atau session
     */
    public function createFormModel()
    {
        $this->formModel = new FilteringModel();
        if ($this->formModel->load(Cii::$app->request->post(), $this->formModelName) || $this->formModel->load(Cii::$app->getSession()->get($this->formModelName), '')) {
            if(!$this->formModel->validate()){
                return;
            }
            if ($this->formModel->resetall == '1') {
                Cii::$app->getSession()->remove($this->formModelName);
                $this->formModel = new FilteringModel();
                return;
            }
            Cii::$app->getSession()->set($this->formModelName, $this->formModel->getAttributes());
            foreach ($this->formModel->column as $i => $column) {
                $condition = false;
                if (in_array($i, ['{baseindex}'])) continue;
                $op = $this->formModel->op[$i];
                $value = $this->formModel->value[$i];
                if (strtoupper($value) === 'NULL') {
                    $value = NULL;
                }

                if($op === 'IN'){
                    $value = explode(',',$value);

                    if($this->tableSchema->columns[$column]->type === 'integer'){
                        $value=array_map('intval',$value);
                    }
                }
                elseif($op === 'BETWEEN'){
                    $this->formModel->value[$i] = Cii::t('codeup', '(dev)');
                    continue;
                }
                elseif($op === 'IS NULL'){
                    $op = 'IS';
                    $value = NULL;
                }
                elseif($op === 'IS NOT NULL'){
                    $op = 'IS NOT';
                    $value = NULL;
                }
                if(!$condition) {
                    $condition = [$op, $column, $value];
                }
                if (!isset($this->formModel->andor[$i])) {
                    $this->_query->andWhere($condition);
                } else {
                    $andor = $this->formModel->andor[$i];
                    if ($andor == 'and') {
                        $this->_query->andWhere($condition);
                    } elseif ($andor == 'or') {
                        $this->_query->orWhere($condition);
                    }
                }
            }

            $this->_query->andWhere($this->baseWhere);

            foreach ($this->formModel->order as $i => $order) {
                if (in_array($i, ['{baseindex}'])) continue;
                $this->_query->addOrderBy($order['column'] . ' ' . $order['val']);
            }
        }
        echo $this->_query->createCommand()->rawSql;
    }


    private function formFieldAttributes($i)
    {
        return $this->_form->field($this->formModel, 'column[' . $i . ']')->dropDownList(
            $this->_attributes,
            ['name' => $this->formModelName . '[column][' . $i . ']']
        );
    }

    private function formFieldAndOr($i, $disable = false)
    {
        return $this->_form->field($this->formModel, 'andor[' . $i . ']')->dropDownList(
            [
                'AND' => 'AND',
                'OR' => 'OR'
            ],
            ['codeup-gridfilter-andor' => true, 'name' => $this->formModelName . '[andor][' . $i . ']', 'disabled' => $disable]
        );
    }

    private function formFieldCodeupOp($i)
    {
        return $this->_form->field($this->formModel, 'op[' . $i . ']')->dropDownList(
            [
                'LIKE' => 'LIKE',
                '=' => '=',
                '<>' => '<>',
                '!=' => '!=',
                '<=>' => '<=>',
                '>' => '>',
                '>=' => '>=',
                '<' => '<',
                '<=' => '<=',
                'NOT LIKE' => 'NOT LIKE',
                'IN' => 'IN',
                'IS' => 'IS',
                'IS NULL' => 'IS NULL',
                'IS NOT NULL' => 'IS NOT NULL',
                'BETWEEN'=>'BETWEEN'
            ],
            ['name' => $this->formModelName . '[op][' . $i . ']']
        );
    }

    private function formFieldDataItem($i, $is_first = true)
    {
        $andor = $this->formFieldAndOr($i, $is_first);
        $op = $this->formFieldCodeupOp($i);
        $column = $this->formFieldAttributes($i);
        $remove = Html::button(Html::icon('minus'), ['class' => '{ctheme}btn {ctheme}btn-default {ctheme}btn-xs codeup-filter-remove']);
        return $this->_form->field(
            $this->formModel,
            'value[' . $i . ']',
            [
                'inputTemplate' => Html::tag('div',
                    Html::tag('span', $andor, ['class' => '{ctheme}input-group-btn'])
                    . Html::tag('span', $column, ['class' => '{ctheme}input-group-btn'])
                    . Html::tag('span', $op, ['class' => '{ctheme}input-group-btn'])

                    . '{input}'
                    . Html::tag('span', $remove, ['class' => '{ctheme}input-group-btn'])
                    , ['class' => '{ctheme}input-group {ctheme}input-group-sm']
                )
            ]
        )->textInput(['name' => $this->formModelName . '[value][' . $i . ']']);
    }

    private function formFieldOrderItem($i)
    {
        $itemval = $this->_form->field($this->formModel, 'order[' . $i . '][val]')->dropDownList(
            [
                'ASC' => 'ASC',
                'DESC' => 'DESC',
            ],
            ['name' => $this->formModelName . '[order][' . $i . '][val]']
        );
        $removeval = Html::button(Html::icon('minus'), ['class' => '{ctheme}btn {ctheme}btn-default {ctheme}btn-xs codeup-filter-order-remove']);
        return $this->_form->field($this->formModel, 'order[' . $i . '][column]', [
            'inputTemplate' => Html::tag('div',
                '{input}'
                . Html::tag('span', $itemval, ['class' => '{ctheme}input-group-btn'])
                . Html::tag('div', $removeval, ['class' => '{ctheme}input-group-btn'])
                , ['class' => '{ctheme}input-group {ctheme}input-group-sm']
            )
        ])->dropDownList(
            $this->_attributes,
            ['name' => $this->formModelName . '[order][' . $i . '][column]']
        );
    }

    public function renderForm()
    {
        $this->_form = ActiveForm::begin([
            'id' => 'form-grid-filtering-' . $this->id,
            'layout' => 'inline',
        ]);

        BoxCard::begin([
            'type' => 'primary',
            'title' => Html::icon('filter') . 'Filtering '
                . Html::beginTag('span', ['class' => '{ctheme}btn-group'])
                . Html::tag('span', Html::icon('plus')
                    . ' query', ['id' => 'codeup-filter-add', 'class' => '{ctheme}btn {ctheme}btn-default {ctheme}btn-xs'])
                . Html::tag('span', Html::icon('plus')
                    . ' Order', ['id' => 'codeup-filter-order-add', 'class' => '{ctheme}btn {ctheme}btn-default {ctheme}btn-xs'])
                . Html::endTag('span')
            ,
            'headerBorder' => false,
            'tools_order' => ['collapse'],
            'footer' => true,
            'footerContent' =>
                Html::tag('div',
                    Html::submitButton(Html::icon('filter') . ' FILTER', ['class' => '{ctheme}btn {ctheme}btn-primary  {ctheme}btn-xs'])
                    . Html::submitButton(Html::icon('refresh') . ' RESET', ['class' => '{ctheme}btn {ctheme}btn-default {ctheme}btn-xs', 'value' => '1', 'name' => $this->formModelName . '[resetall]'])
                    , ['class' => '{ctheme}btn-group'])
        ]);
        echo Html::beginTag('div', ['class' => '{ctheme}row']);

        echo Html::beginTag('div', ['class' => '{ctheme}col-lg-4']);
        echo Html::beginTag('table', ['class' => '{ctheme}table {ctheme}table-bordered']);
        echo Html::tag('tr',
            Html::tag('td', 'LIMIT') .
            Html::tag('td', ':') .
            Html::tag('td',
                $this->_form->field($this->formModel, 'limit', [
                ])->textInput(['type' => 'number', 'name' => $this->formModelName . '[limit]'])
            )
        );
        echo Html::beginTag('tr');
        echo Html::tag('td', 'ORDER');
        echo Html::tag('td', ':');
        echo Html::beginTag('td');

        echo Html::beginTag('div', ['class' => 'codeup-order-filter-' . $this->id]);
        foreach ($this->formModel->order as $i => $orders) {
            if (in_array($i, ['{baseindex}'])) continue;
            echo '<div codeup-order-filtering="' . $i . '">';
            echo $this->formFieldOrderItem($i);
            echo '</div>';
        }
        echo Html::endTag('div');
        echo Html::endTag('td');
        echo Html::endTag('tr');
        echo Html::endTag('table');
        echo Html::endTag('div');
        echo Html::beginTag('div', ['class' => '{ctheme}col-lg-8']);
        echo Html::beginTag('div', ['class' => 'codeup-grid-filter-' . $this->id]);
        $is_first = true;
        foreach ($this->formModel->column as $i => $values) {
            if (in_array($i, ['{baseindex}'])) continue;
            echo '<div codeup-data-filtering="' . $i . '">';
            echo $this->formFieldDataItem($i, $is_first);
            if ($is_first) {
                $is_first = false;
            } else {
            }
            echo '</div>';
        }
        echo Html::endTag('div');
        echo Html::endTag('div');
        echo Html::endTag('div');

        echo '<div codeup-data-filtering-template style="display:none">';
        echo $this->formFieldDataItem('{baseindex}', $is_first);
        echo '</div>';


        echo '<div codeup-order-filtering-template style="display:none">';
        echo $this->formFieldOrderItem('{baseindex}');
        echo '</div>';

        BoxCard::end();
        $this->_form = ActiveForm::end();
        Cii::$app->getView()->registerJs("
        $('#filteringmodel-column-*').click(function(){alert(111)}); 
        $('#form-grid-filtering-{$this->id} #codeup-filter-add').click(function(){
            var length_data = ($('[codeup-data-filtering]').length)
            var template = '<div codeup-data-filtering=\"base'+length_data+'\">'
                + $('[codeup-data-filtering-template]').html().replace(/{baseindex}/g,'base'+length_data)
                + '</div>';
            $(template).appendTo('.codeup-grid-filter-{$this->id}');
        })
        $('#form-grid-filtering-{$this->id} #codeup-filter-order-add').click(function(){
            var length_data = ($('[codeup-order-filtering]').length)
            var template = '<div codeup-order-filtering=\"base'+length_data+'\">'
                + $('[codeup-order-filtering-template]').html().replace(/{baseindex}/g,'base'+length_data)
                + '</div>';
            $(template).appendTo('.codeup-order-filter-{$this->id}');
        })
        $('#form-grid-filtering-{$this->id}').on('click','.codeup-filter-remove', function(){
            $(this).closest('div[codeup-data-filtering]').remove()
        })
        $('#form-grid-filtering-{$this->id}').on('click','.codeup-filter-order-remove', function(){
            $(this).closest('div[codeup-order-filtering]').remove()
        })
        $('[codeup-gridfilter-andor]').change(function(){
            if($(this).val()){
                $('.codeup-grid-filter-template-" . $this->id . "').clone().show().insertAfter('.codeup-grid-filter-" . $this->id . "');
            }
        })
        ");
    }
    /**
     * @return ActiveForm
     */
    public function getForm()
    {
        return $this->_form;
    }

    /**
     * @return \yii\data\ActiveDataProvider
     */
    public function getDataProvider()
    {
        return $this->_dataProvider;
    }
}