<?php

use yii\db\Migration;

/**
 * Class m231210_100248_add_last_massage_id_to_bot_users_table
 */
class m231210_100248_add_last_massage_id_to_bot_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'bot_users',
            'last_massage_id',
            $this->bigInteger()
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
