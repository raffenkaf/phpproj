<?php

use yii\db\Migration;

/**
 * Handles adding updated_at to table `author`.
 */
class m160731_105321_add_updated_at_column_to_author_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('author', 'updated_ad', 'TIMESTAMP AFTER `blocked`');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('author', 'updated_ad');
    }
}
