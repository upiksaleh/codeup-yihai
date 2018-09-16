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
use yii\web\UploadedFile;

/**
 * Class BaseFormAction
 * @package codeup\actions
 * @property \codeup\base\Controller $controller
 */
abstract class BaseFormAction extends \codeup\base\Action
{
    /**
     * @var string type form. eg: create|update|etc
     */
    public $scenario = 'default';

    /**
     * @var array attribute scenario yang akan dipakai. jika kosong maka attributnya diambil dari default
     */
    public $scenarioAttributes = [];
    /**
     * @var string nama model class
     */
    public $modelClass = null;
    /**
     * @var \codeup\base\Model|\codeup\base\ActiveRecord class objek model
     */
    public $model = null;

    /**
     * @var string path view file base form
     */
    public $baseFormView = '@codeup/views/_pages/base-form';

    /**
     * @var string path layout content
     */
    public $baseLayoutView = '@codeup/views/_pages/base-create';

    /**
     * @var string form file, jika null maka default adalah views/namacontroller/_form.php
     */
    public $formView = null;


    public $uploadFields = [];
    /**
     * @var string alert pesan ketika sukses menyimpan
     */
    public $messageSuccess = 'Berhasil';

    /**
     * @var string alert pesan ketika gagal
     */
    public $messageError = 'Gagal';
    /**
     * @var array redirect url ketika sukses
     */
    public $redirect = ['index'];
    /**
     * @var bool jika true, maka ketika form error akan menampilkan alert danger.
     */
    public $enableAlertDanger = false;

    public $formLayout = 'horizontal';

    public function init()
    {
        parent::init();
        if (isset($this->controller->modelClass) && ($this->controller->modelClass !== null) && $this->modelClass === null) {
            $this->modelClass = $this->controller->modelClass;
        }

        if (isset($this->controller->model) && ($this->controller->model !== null) && $this->model === null) {
            $this->model = $this->controller->model;
        }
        if ($this->model === null) {
            $this->model = new $this->modelClass();
        }
        if ($this->formView === null) {
            $this->formView = $this->controller->getViewPath() . '/_form.php';
        }
        if (strrchr($this->baseFormView, ".") !== '.php') {
            $this->baseFormView .= '.php';
        }
        if (strrchr($this->baseLayoutView, ".") !== '.php') {
            $this->baseLayoutView .= '.php';
        }
    }

    public function run()
    {
        // menambah scenario
        $this->model->addScenario($this->scenario, $this->scenarioAttributes);
        // set scenario
        $this->model->setScenario($this->scenario);
        // load default value dari model atau record
        $this->model->loadDefaultValues();
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
            'formLayout' => $this->formLayout
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