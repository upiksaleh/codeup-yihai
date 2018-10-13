<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

use Cii;
use yii\base\DynamicModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;

/**
 * Class ExportAction
 * @package codeup\actions
 */
class ExportAction extends BaseCrudAction
{
    public $baseFormView = '@codeup/views/_pages/base-export';

    private function getExport($dynModel){
        set_time_limit(0);
        if(empty($dynModel->columns)){
            return $this->controller->redirect($this->redirect);
        }
        $spreadsheet = new \yii2tech\spreadsheet\Spreadsheet([
            'dataProvider' => new ActiveDataProvider([
                'query' => $this->model::find(),
            ]),
            'columns' => $dynModel->columns
        ]);
        $filename = str_replace('\\', '-', StringHelper::basename($this->modelClass)) . '-export.xlsx';
        $spreadsheet->save(Cii::getAlias('@runtime/exportData/'.$filename));
        return Cii::$app->response->sendFile(Cii::getAlias('@runtime/exportData/'.$filename));
    }
    public function run(){
        $dynModel = new DynamicModel(['columns']);
        $dynModel->addRule('columns', 'safe');
        if($dynModel->load(Cii::$app->request->post())){
            return $this->getExport($dynModel);
        }

        $modelColumn = [];
        foreach($this->model->attributes() as $i => $value) {
            $modelColumn[$value] = $this->model->getAttributeLabel($value);
        }
        $dynModel->columns = array_keys($modelColumn);
        $params = [
            'model' => $this->model,
            'modelClass'=>$this->modelClass,
            'dynModel' => $dynModel,
            'modelColumn' => $modelColumn,
        ];

        if (Cii::$app->request->isAjax) {
            return $this->controller->renderAjax($this->baseFormView, $params);
        }else{
            return $this->controller->render($this->baseFormView, $params);
        }
    }
}