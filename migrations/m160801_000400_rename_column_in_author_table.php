<?php

use yii\db\Migration;

class m160801_000400_rename_column_in_author_table extends Migration
{
    public function up()
    {
        $this->renameColumn('author', 'photoPath', 'photo_path');
    }

    public function down()
    {
        echo "m160801_000400_rename_column_in_author_table cannot be reverted.\n";

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
