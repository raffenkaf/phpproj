<?php

use yii\db\Migration;

/**
 * Handles adding nickname to table `user`.
 */
class m160823_083718_add_nickname_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'nickname', 'VARCHAR(100) AFTER `patronymic` ');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'nickname');
    }
}
