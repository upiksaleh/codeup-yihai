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
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\imagine\Image;
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

        $params = ArrayHelper::merge($params, $this->params);
        $params['_params'] = $params;
        if (Cii::$app->request->isAjax) {
            return $this->controller->renderAjax($this->baseFormView, $params);
        } else {
            return $this->controller->render($this->baseFormView, $params);
        }
    }

    private function handleUpload()
    {
        if (!empty($this->uploadFields)) {
            foreach ($this->uploadFields as $field => $field_options) {
                foreach (UploadedFile::getInstances($this->model, $field . '_upload') as $file) {
                    $dir = $this->defaultDirUploads . (isset($field_options['dir']) ? '/' . $field_options['dir'] : '');
                    $preFilename = (isset($field_options['preFilename']) ? strtr($field_options['preFilename'], $this->model->getAttributes()) : '');
                    $deleteOnUpdate = (isset($field_options['deleteOnUpdate']) ? $field_options['deleteOnUpdate'] : true);
                    $fileName = $preFilename . time() . '.' . $file->extension;
                    $filePath = $dir . '/' . $fileName;
                    if ($file->saveAs($filePath)) {
                        // delete old
                        if ($deleteOnUpdate && !$this->model->getIsNewRecord() && $this->model->getOldAttribute($field)) {
                            $field_old_value = $this->model->getOldAttribute($field);
                            $field_old_value_ext = substr(strrchr($field_old_value, "."), 0);
                            $onlySearch = substr($field_old_value, 0, strrpos($field_old_value, $field_old_value_ext)) . '*';
                            $oldFiles = FileHelper::findFiles($dir, ['only' => [$onlySearch]]);
                            foreach ($oldFiles as $oldFile) {
                                FileHelper::unlink($oldFile);
                            }
                        }
                        // create thumb
                        if (isset($field_options['createThumb']) && $field_options['createThumb'] === true) {
                            $fileNameThumb = $preFilename . time() . '-thumb.' . $file->extension;
                            Image::thumbnail($filePath, 200, 200)->save($dir . '/' . $fileNameThumb);
                        }
                        $this->model->{$field} = $fileName;
                    }
                }
            }
        }
    }
}