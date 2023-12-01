<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%map_comment_likes}}`.
 */
class m231110_152738_create_map_comment_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%map_comment_likes}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'comment_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%map_comment_likes}}');
    }
}
