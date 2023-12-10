<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%bot_users}}`.
 */
class m231210_094557_add_username_column_to_bot_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'bot_users',
            'username',
            $this->text(1)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('bot_users', 'username');
    }
}
