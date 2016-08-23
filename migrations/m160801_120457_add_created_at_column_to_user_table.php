<?php

use yii\db\Migration;

/**
 * Handles adding created_at to table `user`.
 */
class m160801_120457_add_created_at_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'created_at', 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'created_at');
    }
}
