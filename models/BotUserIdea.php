<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $bot_user_id
 * @property string $idea
 */
class BotUserIdea extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{bot_user_ideas}}';
    }

    public function getBotUser(): ActiveQuery
    {
        return $this->hasOne(BotUser::class, ['id' => 'bot_user_id']);
    }
}
