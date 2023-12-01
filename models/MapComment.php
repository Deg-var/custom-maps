<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property int $map_id
 * @property User $user
 * @property MapCommentLike[] $likes
 */
class MapComment extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{map_comments}}';
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
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getLikes(){
        return $this->hasMany(MapCommentLike::class,['comment_id'=>'id']);
    }

}
