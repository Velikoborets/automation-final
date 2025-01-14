<?php

namespace app\modules\user\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public $username;

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['username'], 'required'],
            [['username'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
        ];
    }

    /**
     * Finds customer object by the given ID.
     *
     * @param int|string $id
     * @return User|null object by id
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Returns the unique ID of the customer.
     *
     * @return int|string еhe unique identifier of the customer.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Given auth key
     *
     * @return string a key that is used to check validity
     */
    public function getAuthKey()
    {
        return '';
    }

    /**
     * Validates the given auth key
     *
     * @param  string $authKey for validation
     * @return bool (valid auth key or not)
     */
    public function validateAuthKey($authKey)
    {
        return true;
    }

    /**
     * Finds a user by access token.
     *
     * @param string $token
     * @param mixed $type
     * @return object|null The user identity if found, or null if not found.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }
}