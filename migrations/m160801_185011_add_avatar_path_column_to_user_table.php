<?php

use yii\db\Migration;

/**
 * Handles adding avatar_path to table `user`.
 */
class m160801_185011_add_avatar_path_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'avatar_path', $this->string(100));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'avatar_path');
    }
}
