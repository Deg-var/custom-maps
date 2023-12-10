<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $chat_id
 * @property string $name
 * @property string $idea
 */
class BotUsersIdeas extends ActiveRecord
{

    public static function tableName(): string
    {
        return '{{bot_users_ideas}}';
    }

    public function getLikes()
    {
        return $this->hasMany(MapLike::class, ['map_id' => 'id']);
    }

    public function getComments()
    {
        return $this->hasMany(MapComment::class, ['map_id' => 'id']);
    }

    public function getGame()
    {
        return $this->hasOne(Game::class, ['id' => 'game_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class,['id'=>'user_id']);
    }
}
