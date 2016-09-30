<?php

use yii\db\Migration;

class m160923_023709_add_column_touser_table extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'authKey', $this->string(255));
    }

    public function down()
    {
        echo "m160923_023709_add_column_touser_table cannot be reverted.\n";

        return false;
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
