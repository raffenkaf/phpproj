<?php

use yii\db\Migration;

/**
 * Handles adding updated_at to table `book`.
 */
class m160801_001926_add_updated_at_column_to_book_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('book', 'updated_at', $this->timestamp());
        $this->alterColumn('book', 'created_at', $this->timestamp());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('book', 'updated_at');
    }
}
