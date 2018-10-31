<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\actions;

use Cii;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use yii\base\DynamicModel;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;
use yii\web\UploadedFile;

class ImportAction extends BaseCrudAction
{
    public $baseFormView = '@codeup/views/_pages/base-import';
    public $baseColumns = [];

    public function buatContoh($dynModel)
    {
        $filename = str_replace('\\', '-', StringHelper::basename($this->modelClass)) . '-import.xlsx';
        if(file_exists(Cii::getAlias('@files/import-template/'.$filename))){

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0'); //no cache
            echo file_get_contents(Cii::getAlias('@files/import-template/'.$filename));
            exit;
        }
        $spreadsheet = new Spreadsheet();
        $i = 1;
        $columns = $dynModel->columns;
        if (!empty($this->baseColumns))
            $columns = $this->baseColumns;
        foreach ($columns as $c => $v) {
            $c = new RichText();
            $c->createText($v);
            $spreadsheet->getActiveSheet()
                ->setCellValueByColumnAndRow($i, 1, $this->model->getAttributeLabel($v))
                ->getStyle('A1:ZZ1')->getFont()->setBold(true)->setName('Times New Roman')
                ->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getCommentByColumnAndRow($i, 1)
                ->setAuthor('codeup_system')
                ->setText($c);
            $i++;
        }
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0'); //no cache
        $writer->save('php://output');
        exit;
    }

    private function handleImport($dynModelImport)
    {
        $uploadedFile = UploadedFile::getInstances($dynModelImport, 'file')[0];
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = IOFactory::load($uploadedFile->tempName);
        $comments = $spreadsheet->getActiveSheet()->getComments();
        $columns = [];
        foreach ($comments as $cell => $comment) {
            $columns[$comment->getText()->getPlainText()] = $spreadsheet->getActiveSheet()->getCell($cell)->getColumn();
        }
        $success = $gagal = 0;
        for ($i = 2; $i <= $spreadsheet->getActiveSheet()->getHighestRow(); $i++) {
            /** @var \codeup\base\ActiveRecord $model */
            $model = new $this->modelClass();
            foreach ($columns as $field => $column) {
                if($model->hasMethod('onImport')){
                    $model->{$field} = $model->onImport($field,  $spreadsheet->getActiveSheet()->getCell($column . $i)->getValue());
                }else {
                    $model->{$field} = $spreadsheet->getActiveSheet()->getCell($column . $i)->getFormattedValue();
                }
//                echo  $field.'==='.$model->{$field};
            }
//            exit;
            if ($model->save()) {
                $success += 1;
            } else {
                $gagal += 1;
            }

        }
        @unlink($uploadedFile->tempName);
        Cii::$app->session->setFlash('success', "Sukses: {$success}, Gagal: {$gagal}");
        return $this->controller->redirect($this->redirect);
    }

    public function run()
    {
        $dynModel = new DynamicModel(['columns']);
        $dynModel->addRule('columns', 'safe');
        $dynModelImport = new DynamicModel(['columns', 'file']);
        $dynModelImport->addRule('columns', 'safe');
        $dynModelImport->addRule('file', 'required');
        $dynModelImport->addRule('file', 'file', ['extensions' => ['xlsx', 'xls']]);

        if ($dynModelImport->load(Cii::$app->request->post())) {
            return $this->handleImport($dynModelImport);
        }
        if ($dynModel->load(Cii::$app->request->post(), 'dynContoh')) {
            $this->buatContoh($dynModel);
        }
        $modelColumn = [];

        if (!empty($this->baseColumns)) {
            $modelColumn = $this->baseColumns;
        } else {
            foreach ($this->model->attributes() as $i => $value) {
                $modelColumn[$value] = $this->model->getAttributeLabel($value);
            }
        }
        $dynModel->columns = array_keys($modelColumn);
        $params = [
            'model' => $this->model,
            'modelClass' => $this->modelClass,
            'dynModel' => $dynModel,
            'dynModelImport' => $dynModelImport,
            'modelColumn' => $modelColumn,
        ];
        if (Cii::$app->request->isAjax) {
            return $this->controller->renderAjax($this->baseFormView, $params);
        } else {
            return $this->controller->render($this->baseFormView, $params);
        }
    }
}