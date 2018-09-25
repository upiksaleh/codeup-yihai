<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

use Cii;
use yii\db\IntegrityException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Class BaseFormAction
 * @package codeup\actions
 */
class BaseFormAction extends BaseCrudAction
{
    /** @var \codeup\theming\ActiveForm */
    public $formConfig = [];
    public function init()
    {
        parent::init();
        if ($this->model === null) {
            if($this->type === 'create') {
                $this->model = new $this->modelClass();
                $this->model->loadDefaultValues();
            }
            elseif($this->type === 'update') {
                $queryParams = Cii::$app->request->getQueryParams();
                $this->model = $this->findModel($queryParams);
            }
            // menambah scenario
            $this->model->addScenario($this->scenario, $this->scenarioAttributes);
            // set scenario
            $this->model->scenario = $this->scenario;
        }
    }

    public function run()
    {
        if ($this->model->load(Cii::$app->request->post()) && $this->model->validate()) {

            // upload handle
            $this->handleUpload();
            if ($this->model->save(false)) {
                Cii::$app->session->setFlash('success', Cii::t('app', $this->messageSuccess));
                return $this->controller->redirect($this->redirect);
            }
        }
        if ($this->enableAlertDanger) {
            $messageDangers = [Cii::t('app', $this->messageError)];
            foreach ($this->model->getErrors() as $attribute => $err) {
                $messageDangers[] = implode('<br/>', $err);
            }
            Cii::$app->session->setFlash('danger', implode('<br/>', $messageDangers));
        }
        $params = [
            'model' => $this->model,
            'formView' => $this->formView,
            'baseLayoutView' => $this->baseLayoutView,
            'formLayout' => $this->formLayout,
            'formConfig' => $this->formConfig,
        ];

        if (Cii::$app->request->isAjax) {
            return $this->controller->renderAjax($this->baseFormView, $params);
        } else {
            return $this->controller->render($this->baseFormView, $params);
        }
    }

    private function handleUpload()
    {
        if(!empty($this->field_upload)){
            $field_db_value = [];
            foreach($this->field_upload as $field => $field_options) {
                foreach(UploadedFile::getInstances($model, $field) as $file){
                    $format_date = Yii::$app->formatter->asDate('now','php:Y-m-d_His');
                    $file_path = $field_options['dir'] . $format_date . '.' . $file->extension;
                    if($file->saveAs($file_path)){
                        $field_db_value[$field_options['field_db']][] = $file_path;
                    }
                }
            }
            foreach($field_db_value as $field => $value){
                $model->{$field} = json_encode($value);
            }
        }
    }
}