<?php

use yii\db\Migration;

/**
 * Handles the creation for table `chatwork_auth`.
 */
class m160923_053053_create_chatwork_auth_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('chatwork_auth', [
            'id' => $this->bigPrimaryKey(),
            'bitbucket_url' => $this->string(255)->notNull(),
            'repo_name' => $this->string(255)->notNull(),
            'room_id' => $this->string(255)->notNull(),
            'api_key' => $this->string(255)->notNull(),
            'created' => $this->dateTime(),
            'updated' => $this->dateTime()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('chatwork_auth');
    }
}
