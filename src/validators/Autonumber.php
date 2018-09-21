<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

namespace codeup\validators;

/**
 * This is the model class for table "auto_number".
 *
 * @property string $group
 * @property string $template
 * @property integer $number
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Autonumber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sys_auto_number}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['optimistic_lock', 'number'], 'default', 'value' => 1],
            [['group'], 'required'],
            [['number'], 'integer'],
            [['group'], 'string']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'template' => 'Template Num',
            'number' => 'Number',
        ];
    }
    /**
     * @inheritdoc
     */
    public function optimisticLock()
    {
        return 'optimistic_lock';
    }
}