<?php

use yii\db\Migration;

/**
 * Class m231202_051833_add_aoe_intro_text_for_map_creator_viewed
 */
class m231202_051833_add_aoe_intro_text_for_map_creator_viewed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'users',
            'aoe_intro_text_for_map_creator_viewed',
            $this->tinyInteger(1)->defaultValue(false)->comment('Показана ли простыня текста про UserPatch')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'aoe_intro_text_for_map_creator_viewed');
    }
}
