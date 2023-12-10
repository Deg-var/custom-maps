<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bot_users_ideas}}`.
 */
class m231210_074801_create_bot_users_ideas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bot_users_ideas}}', [
            'id' => $this->primaryKey(),
            'chat_id'=>$this->integer(11),
            'name'=>$this->text(),
            'idea'=> $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bot_users_ideas}}');
    }
}
