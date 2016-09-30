<?php

use yii\db\Migration;

/**
 * Handles the creation for table `chatwork_api_key`.
 */
class m160926_014402_create_chatwork_api_key_table extends Migration
{

    /**
     * チャットワークで取得したAPIキーをここに記載
     */
    const DEFAULT_API_KEY = '';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('chatwork_api_key', [
            'id' => $this->bigPrimaryKey(),
            'api_key' => $this->string(255)->notNull(),
            'created' => $this->dateTime(),
            'updated' => $this->dateTime()
        ]);

        $this->insert('chatwork_api_key',[
            'api_key' => self::DEFAULT_API_KEY,
            'created' => date('Y-m-d H:i:s'),
            'updated' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('chatwork_api_key');
    }
}
