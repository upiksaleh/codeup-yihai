<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\models;


use yii\db\ActiveRecord;

class UsersModel extends ActiveRecord
{
    public static function tableName(){
        return '{{%sys_users}}';
    }
    public function rules()
    {
        return [
            [['username', 'fullname', 'password_hash'], 'required'],

        ];
    }
    public function behaviors()
    {
        return [
            '\codeup\behaviors\BlameableGroupBehavior'
        ];
    }
}