<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $chat_id
 * @property string $name
 */
class BotUser extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{bot_users}}';
    }

    public function getIdeas(): ActiveQuery
    {
        return $this->hasMany(BotUserIdea::class, ['bot_user_id' => 'id']);
    }
}
