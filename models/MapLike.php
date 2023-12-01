<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $user_id
 * @property int $map_id
 */
class MapLike extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{map_likes}}';
    }

//    public function attributeLabels(): array
//    {
//        return [
//            'username' => 'Имя',
//            'email' => 'Мыло',
//            'password' => 'Пороль',
//        ];
//    }

    public function getUser()
    {
        return $this->hasOne(User::class,['id'=>'user_id']);
    }

}
