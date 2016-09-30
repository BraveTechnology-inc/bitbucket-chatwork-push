<?php

use yii\db\Migration;

class m160927_063814_alter_column_chatwork_auth extends Migration
{
    public function up()
    {
        $this->dropColumn('chatwork_auth', 'api_key');
        $this->addColumn('chatwork_auth', 'chatwork_api_key_id', $this->bigInteger()->notNull());
    }

    public function down()
    {
        $this->dropColumn('chatwork_auth', 'chatwork_api_key_id');
        $this->addColumn('chatwork_auth', 'api_key', $this->string(255));
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
