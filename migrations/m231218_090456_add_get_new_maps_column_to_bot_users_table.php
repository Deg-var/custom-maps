<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%bot_users}}`.
 */
class m231218_090456_add_get_new_maps_column_to_bot_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'bot_users',
            'get_new_maps',
            $this->boolean()->defaultValue(false)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('bot_users', 'get_new_maps');
    }
}
