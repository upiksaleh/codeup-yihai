<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\models;

use Cii;

/**
 * Class UsersModel
 * @package codeup\models
 * @property string $username
 * @property string $fullname
 * @property int $status
 * @property string $group
 * @property string $passwordHash
 * @property string $password_hash
 */
class UsersModel extends \codeup\base\ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(){
        return '{{%sys_users}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'fullname','status','group'], 'required'],
            ['password_hash', 'required', 'on' => 'create'],
            ['password_hash', 'string', 'max'=>64],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            '\codeup\activitylog\LoggableBehavior',
            '\codeup\behaviors\BlameableGroupBehavior',
            '\yii\behaviors\TimestampBehavior',
        ];
    }
    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setPasswordHash($this->password_hash);
        } else {
            if (!empty($this->password_hash)) {
                $this->setPasswordHash($this->password_hash);
            } else {
                $this->password_hash = (string) $this->getOldAttribute('password_hash');
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param string $password_hash
     * @throws \yii\base\Exception
     */
    public function setPasswordHash($password_hash)
    {
        $this->password_hash = Cii::$app->security->generatePasswordHash($password_hash);
    }
}