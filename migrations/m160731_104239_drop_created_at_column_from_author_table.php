<?php

use yii\db\Migration;

/**
 * Handles dropping created_at from table `author`.
 */
class m160731_104239_drop_created_at_column_from_author_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('author', 'created_at');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('author', 'created_at', $this->dateTime());
    }
}
