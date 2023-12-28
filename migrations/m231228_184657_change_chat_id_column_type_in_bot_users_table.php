<?php

use yii\db\Migration;

/**
 * Class m231228_184657_change_chat_id_column_type_in_bot_users_table
 */
class m231228_184657_change_chat_id_column_type_in_bot_users_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn(
            'bot_users',
            'chat_id',
            $this->bigInteger()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(
            'bot_users',
            'chat_id',
            $this->integer()
        );
    }
}
