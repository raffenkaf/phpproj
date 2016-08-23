<?php

use yii\db\Migration;

/**
 * Handles adding file_path to table `book`.
 */
class m160815_190811_add_file_path_column_to_book_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('book', 'file_path', $this->string(100));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('book', 'file_path');
    }
}
