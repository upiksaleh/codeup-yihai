<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

use Cii;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;

/**
 * Class DeleteAction
 * @package codeup\actions
 */
class DeleteAction extends \codeup\base\Action
{

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
    public function init()
    {
        parent::init();

        if (isset($this->controller->modelClass) && ($this->controller->modelClass !== null) && $this->modelClass === null) {
            $this->modelClass = $this->controller->modelClass;
        }

        if (isset($this->controller->model) && ($this->controller->model !== null) && $this->model === null) {
            $this->model = $this->controller->model;
        }
    }

    /**
     * @return bool
     * @throws MethodNotAllowedHttpException
     */
    protected function beforeRun()
    {
        $verb = Cii::$app->getRequest()->getMethod();
        $allowed = array_map('strtoupper', ['POST']);
        if (!in_array($verb, $allowed)) {
            // https://tools.ietf.org/html/rfc2616#section-14.7
            Cii::$app->getResponse()->getHeaders()->set('Allow', implode(', ', $allowed));
            throw new MethodNotAllowedHttpException('Method Not Allowed. This URL can only handle the following request methods: ' . implode(', ', $allowed) . '.');
        }
        return parent::beforeRun();
    }
    public function run(){
        $id = Cii::$app->request->getQueryParams();
        if ($this->findModel($id)->delete()) {
            Cii::$app->session->setFlash('success', Cii::t('app', 'Berhasil Hapus.!'));
        }
        return $this->controller->redirect(['index']);
    }

    private function findModel($params)
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