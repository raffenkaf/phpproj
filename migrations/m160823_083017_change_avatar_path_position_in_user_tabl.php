<?php

use yii\db\Migration;

class m160823_083017_change_avatar_path_position_in_user_tabl extends Migration
{
    public function up()
    {
        $this->alterColumn('user', 'avatar_path', 'VARCHAR(100) AFTER `birth_date` ');
    }

    public function down()
    {
        echo "m160801_000743_change_column_position_in_author_table cannot be reverted.\n";
        return false;
    }

}
