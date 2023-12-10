<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bot_users}}`.
 */
class m231210_081414_create_bot_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bot_user_ideas}}', [
            'id' => $this->primaryKey(),
            'bot_user_id'=>$this->integer(11),
            'idea'=> $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bot_user_ideas}}');
    }
}
