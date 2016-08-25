<?php

use yii\db\Migration;

class m160823_083357_change_file_path_position_in_book_table extends Migration
{
    public function up()
    {
        $this->alterColumn('book', 'file_path', 'VARCHAR(100) AFTER `book_cover_path` ');
    }

    public function down()
    {
        echo "m160801_000743_change_column_position_in_author_table cannot be reverted.\n";
        return false;
    }
}
