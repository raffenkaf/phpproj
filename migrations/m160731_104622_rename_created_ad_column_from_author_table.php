<?php

use yii\db\Migration;

class m160731_104622_rename_created_ad_column_from_author_table extends Migration
{
    public function up()
    {
    	$this->renameColumn('author', 'created_ad', 'created_at');
    }

    public function down()
    {
        echo "m160731_104622_rename_created_ad_column_from_author_table cannot be reverted.\n";

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
