<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Map;

/**
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $auth_key
 * @property string $access_token
 * @property string $img_url
 * @property string $description
 * @property int $ad_window_viewed
 * @property int $aoe_intro_text_for_map_creator_viewed
 * @property Map[] $maps
 * @property Map[] $someMaps
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    public static function tableName(): string
    {
        return '{{users}}';
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Имя',
            'email' => 'Мыло',
            'password' => 'Пороль',
            'img_url' => 'Ссылка на аву',
            'description' => 'О себе',
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return User the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return User the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null): User
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int current user ID
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findByUsername($username)
    {
        return self::find()->where(['username' => $username])->one();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function getMaps()
    {
        return $this->hasMany(Map::class, ['user_id' => 'id']);
    }


    public function getSomeMaps()
    {

    }
}
