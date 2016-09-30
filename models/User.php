<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package app\models
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $created
 * @property string $modified
 * @property string $access_token
 * @property string $authKey
 */
class User extends ActiveRecord implements IdentityInterface
{
    public function rules()
    {
        return [
            [['username', 'password', 'access_token', 'authKey'], 'string', 'max' => 255],
            [['username', 'password'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return User::find()->andWhere(['id' => $id])->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return User::find()->andWhere(['access_token' => $token])->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return array|ActiveRecord|User
     */
    public static function findByUsername($username)
    {
        return User::find()->andWhere(['username' => $username])->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === sha1($password);
    }

    public function beforeSave($insert)
    {
        $this->modified = date('Y/m/d H:i:s');
        if($this->isNewRecord){
            $this->created = $this->modified;
            $this->password = sha1($this->password);
        }

        if (parent::beforeSave($this->isNewRecord)) {
            return true;
        } else {
            return false;
        }
    }
}
