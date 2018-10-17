<?php
/**
 * CodeUP yihai using Yii Framework
 * @link http://codeup.orangeit.id/yihai
 * @copyright Copyright (c) 2018 OrangeIT.ID
 * @author Upik Saleh <upxsal@gmail.com>
 */

/**
 * Migration table auto_number
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class m000000_000101_auto_number extends \codeup\base\Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%sys_auto_number}}', [
            'group' => $this->string(32)->notNull(),
            'number' => $this->integer(),
            'optimistic_lock' => $this->integer(),
            'update_time' => $this->integer(),
            'PRIMARY KEY ([[group]])'
        ], $this->getTableOptions());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%sys_auto_number}}');
    }
}
