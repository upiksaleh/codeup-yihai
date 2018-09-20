<?php

/**
 * Class m180908_064554_table_sys_users
 * @author Upik Saleh <upxsal@gmail.com>
 */
class m180908_064554_table_sys_users extends \codeup\base\Migration
{
    protected $tableSysUsers = '{{%sys_users}}';

    public function up()
    {
        $this->mySQL_UTF8_unicode_InnoDB();

        $this->createTable(
            $this->tableSysUsers,
            [
                'id' => $this->primaryKey(),
                'username' => $this->string(100)->notNull()->unique(),
                'password_hash' => $this->string(100)->notNull(),
                'fullname' => $this->string(100)->notNull(),
                'status' => $this->tinyInteger(1)->defaultValue(1),
                'auth_key' => $this->string(32),
                'password_reset_token' => $this->string()->unique(),
                'group' => $this->string(32)->defaultValue('user'),
                'last_login_at' => $this->integer(),
                'created_by' => $this->columnCreatedBy(),
                'created_at' => $this->columnCreatedAt(),
                'updated_by' => $this->columnUpdatedBy(),
                'updated_at' => $this->columnUpdatedAt()
            ],
            $this->getTableOptions()
        );
        $this->insert($this->tableSysUsers, [
            'username' => 'superuser',
            'password_hash' => '$2y$13$ykEAwdHZYaPWX3/145JTx.lqM9dlszXwuMPQ8oduuVkYgqgMrFPXe',
            'fullname'=>'Super User',
            'group' => 'su',
        ]);
        $this->insert($this->tableSysUsers, [
            'username' => '_codeup',
            'password_hash' => '$2y$13$PztB252A2pnQxCVq5MN9U.gUgv4e9vrzdYJ8PMRdIs5TQezCO53om',
            'fullname'=>'CodeUP Dev',
            'group' => 'su',
        ]);
    }

    public function down()
    {
        $this->dropTable($this->tableSysUsers);
    }
}
