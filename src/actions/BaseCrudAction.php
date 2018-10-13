<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

use Cii;
use yii\web\NotFoundHttpException;

/**
 * Class BaseCrudAction
 * @package codeup\actions
 * @property \codeup\base\BaseCrudController $controller
 */
class BaseCrudAction extends \codeup\base\Action
{
    public $baseId;
    /**
     * @var string nama model class
     */
    public $modelClass = null;
    /**
     * @var \codeup\base\Model|\codeup\base\ActiveRecord class objek model
     */
    public $model = null;
    /**
     * @var array merge query find model
     */
    public $mergeFindParams = [];
    /**
     * @var string type form. eg: create|update|etc
     */
    public $scenario = 'default';

    /** @var string type form. default adalah create */
    public $type = "create";
    /**
     * @var array attribute scenario yang akan dipakai. jika kosong maka attributnya diambil dari default
     */
    public $scenarioAttributes = [];
    /**
     * @var string path view file base form
     */
    public $baseFormView = '@codeup/views/_pages/base-form';

    /**
     * @var string path layout content
     */
    public $baseLayoutView;

    /**
     * @var string form file, jika null maka default adalah views/namacontroller/_form.php
     */
    public $formView = null;

    public $defaultDirUploads = 'uploads';

    /** @var array upload config */
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

    /**
     * @var array params yang akan ditambahkan pada view
     */
    public $params = [];
    public $formLayout = 'horizontal';
    public function init()
    {
        //set baseCrudAction in controller
        $this->controller->beforeInitBaseCrudAction($this);

        parent::init();

        if (isset($this->controller->modelClass) && ($this->controller->modelClass !== null) && $this->modelClass === null) {
            $this->modelClass = $this->controller->modelClass;
        }

        if (isset($this->controller->model) && ($this->controller->model !== null) && $this->model === null) {
            $this->model = $this->controller->model;
        }
        if($this->model === null && $this->modelClass !== null){
            if ($this->type === 'create') {
                $this->model = new $this->modelClass();
                $this->model->loadDefaultValues();
            } elseif ($this->type === 'update') {
                $queryParams = Cii::$app->request->getQueryParams();
                $this->model = $this->findModel($queryParams);
            }else{
                $this->model = new $this->modelClass();
            }
            // menambah scenario
            $this->model->addScenario($this->scenario, $this->scenarioAttributes);
            // set scenario
            $this->model->scenario = $this->scenario;
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
        if (strrchr($this->formView, ".") !== '.php') {
            $this->formView .= '.php';
        }

    }

    protected function findModel($params)
    {
        if(!empty($this->mergeFindParams))
            $params = array_merge($params, $this->mergeFindParams);
        $model = $this->modelClass;
        if (($model = $model::findOne($params)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}