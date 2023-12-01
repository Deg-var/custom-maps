<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m231109_161739_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->text(),
            'description' => $this->text(),
            'email' => $this->text(),
            'password' => $this->text(),
            'access_token' => $this->text(),
            'auth_key' => $this->text(),
            'img_url' => $this->text(),
            'ad_window_viewed' => $this->boolean(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
