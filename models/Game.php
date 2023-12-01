<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Map[] $maps
 */
class Game extends ActiveRecord
{

    const AOE2DE = 1;
    const WARCRAFT3 = 1;

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
        ];
    }

    public static function tableName(): string
    {
        return '{{games}}';
    }

    public function getMaps()
    {
        return $this->hasMany(Map::class, ['game_id' => 'id']);
    }
}