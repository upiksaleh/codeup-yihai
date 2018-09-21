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
class DeleteAction extends BaseCrudAction
{
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
}