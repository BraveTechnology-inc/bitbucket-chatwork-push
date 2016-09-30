<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "chatwork_auth".
 *
 * @property integer $id
 * @property string $bitbucket_url
 * @property string $repo_name
 * @property string $room_id
 * @property integer $chatwork_api_key_id
 * @property string $created
 * @property string $updated
 */
class ChatworkAuth extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chatwork_auth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bitbucket_url', 'repo_name', 'room_id', 'chatwork_api_key_id'], 'required'],
            [['created', 'updated'], 'safe'],
            [['bitbucket_url', 'repo_name', 'room_id'], 'string', 'max' => 255],
            ['bitbucket_url', 'url'],
            [['chatwork_api_key_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bitbucket_url' => Yii::t('app', 'bitbucket_url'),
            'repo_name' => Yii::t('app', 'repo_name'),
            'room_id' => Yii::t('app', 'room_id'),
            'created' => Yii::t('app', 'created'),
            'updated' => Yii::t('app', 'updated'),
        ];
    }

    public function beforeSave($insert)
    {
        $this->updated = date('Y/m/d H:i:s');
        if($this->isNewRecord){
            $this->created = $this->updated;
        }

        if (parent::beforeSave($this->isNewRecord)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 保持しているチャットワークAPIキーIDからAPIキーの実態を取得
     * @return string
     */
    public function getChatworkApiKey() {
        $apiKeyRecord = ChatworkApiKey::findByID($this->chatwork_api_key_id);
        return $apiKeyRecord->api_key;
    }

    /**
     * IDで指定された設定を読み込む
     * @param $id
     * @return array|null|ChatworkAuth
     */
    public static function findById($id)
    {
        return ChatworkAuth::find()->andWhere(['id' => $id])->one();
    }

}
