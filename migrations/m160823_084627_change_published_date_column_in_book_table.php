<?php

use yii\db\Migration;

class m160823_084627_change_published_date_column_in_book_table extends Migration
{
    public function up()
    {
        $this->alterColumn('book', 'published_date', ' YEAR ');
    }

    public function down()
    {
        echo "m160801_000743_change_column_position_in_author_table cannot be reverted.\n";
        return false;
    }
}
