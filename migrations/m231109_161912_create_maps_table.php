<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%maps}}`.
 */
class m231109_161912_create_maps_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%maps}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'description' => $this->text(),
            'img_link' => $this->text(),
            'video_link' => $this->text(),
            'mod_link' => $this->text(),
            'user_id' => $this->integer(),
            'game_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%maps}}');
    }
}
