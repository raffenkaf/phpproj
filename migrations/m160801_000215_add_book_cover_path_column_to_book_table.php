<?php

use yii\db\Migration;

/**
 * Handles adding book_cover_path to table `book`.
 */
class m160801_000215_add_book_cover_path_column_to_book_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('book', 'book_cover_path', $this->string(100));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('book', 'book_cover_path');
    }
}
