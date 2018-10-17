<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\base;


use Cii;
use yii\web\NotFoundHttpException;

class BaseCrudController extends UserController
{
    /**
     * @var string|\codeup\base\ActiveRecord nama class base model
     */
    public $modelClass = null;
    /**
     * @var object class model
     */
    public $model = null;
    /**
     * @var string main title untuk controller
     */
    public $title;

    public $groupsCanAccess = ['su'];

    public function init()
    {
        parent::init();
        //set main title
        $this->getView()->title = $this->title;
        // attach behavior
        $this->attachBehavior('codeup_access_action_groups', [
            'class' => 'codeup\filters\AccessControl',
            'rules' => [
                ['allow' => true, 'groups' => $this->groupsCanAccess],
            ]
        ]);
    }

    /**
     * mendefinisikan config pada BaseCrudAction sebelum init BaseCrudAction
     * @param $baseCrudAction \codeup\actions\BaseCrudAction
     */
    public function beforeInitBaseCrudAction($baseCrudAction)
    {
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function haveAccessAction($action){
        if(!in_array($action, array_keys($this->actions())))
            return false;
        if(isset($this->actions()[$action]['groupsCanAccess'])){
            if(in_array(Cii::getUserIdentity()->getGroup(), $this->actions()[$action]['groupsCanAccess']))
                return true;
        }else{
            if(in_array(Cii::getUserIdentity()->getGroup(), $this->groupsCanAccess))
                return true;
        }
    }
    /**
     * @param $params
     * @return ActiveRecord|null|string
     * @throws NotFoundHttpException
     */
    protected function findModel($params)
    {
        $model = $this->modelClass;
        if (($model = $model::findOne($params)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}