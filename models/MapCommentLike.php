<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $comment_id
 * @property int $user_id
 * @property string $text
 * @property User $user
 */
class MapCommentLike extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{map_comment_likes}}';
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
