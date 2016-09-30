<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "chatwork_api_key".
 *
 * @property integer $id
 * @property string $api_key
 * @property string $created
 * @property string $updated
 */
class ChatworkApiKey extends ActiveRecord
{
    const DEFAULT_API_KEY_ID = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chatwork_api_key';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'updated'], 'safe'],
            [['api_key'], 'string', 'max' => 255],
            [['api_key'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'api_key' => Yii::t('app', 'api_key'),
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
     * IDからレコード検索
     * @param $id
     * @return array|null|ChatworkApiKey
     */
    public static function findByID($id) {
        return ChatworkApiKey::find()->andWhere(['id' => $id])->one();
    }
}
