<?php

use yii\db\Migration;

class m160801_000743_change_column_position_in_author_table extends Migration
{
    public function up()
    {
        $this->alterColumn('book', 'book_cover_path', 'VARCHAR(100) AFTER `genre` ');
    }

    public function down()
    {
        echo "m160801_000743_change_column_position_in_author_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
