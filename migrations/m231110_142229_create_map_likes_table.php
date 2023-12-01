<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%map_like}}`.
 */
class m231110_142229_create_map_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%map_likes}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'map_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%map_likes}}');
    }
}
