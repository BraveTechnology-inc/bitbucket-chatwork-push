<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m160916_005826_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->bigPrimaryKey(),
            'username' => $this->string(255)->notNull(),
            'password' => $this->string(255)->notNull(),
            'created' => $this->dateTime(),
            'modified' => $this->dateTime()
        ]);

        /*
         *  デフォルトユーザーのユーザーID/パスワードを入力する　
         *  パスワードはsha1ハッシュしたものを入力
        */
        $this->insert('user', [
            'username' => '',
            'password' => '',
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
