<?php

use yii\db\Migration;

/**
 * Class m231204_061802_add_default_img_url_to_games_table
 */
class m231204_061802_add_default_img_url_to_games_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'games',
            'default_img_url_to_games',
            $this->text()->defaultValue(null)->comment('стоковое изображение для игры')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('games', 'default_img_url_to_games');
    }
}
