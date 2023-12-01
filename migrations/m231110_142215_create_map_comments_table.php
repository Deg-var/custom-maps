<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%map_comment}}`.
 */
class m231110_142215_create_map_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%map_comments}}', [
            'id' => $this->primaryKey(),
            'text' => $this->text(),
            'user_id' => $this->integer(),
            'map_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%map_comments}}');
    }
}
