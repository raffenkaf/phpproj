<?php

use yii\db\Migration;

class m160731_171857_rename_photo_column_in_author_table extends Migration
{
    public function up()
    {
    	$this->renameColumn('author', 'photo', 'photoPath');
    }

    public function down()
    {
        echo "m160731_171857_rename_photo_column_in_author_table cannot be reverted.\n";

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
