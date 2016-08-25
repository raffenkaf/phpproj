<?php

use yii\db\Migration;

class m160823_084418_change_birth_date_column_in_user_table extends Migration
{
    public function up()
    {
        $this->alterColumn('user', 'birth_date', ' DATE ');
    }

    public function down()
    {
        echo "m160801_000743_change_column_position_in_author_table cannot be reverted.\n";
        return false;
    }
}
