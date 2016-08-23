<?php

use yii\db\Migration;

class m160731_105531_rename_updated_ad_column_from_author_table extends Migration
{
    public function up()
    {
    	$this->renameColumn('author', 'updated_ad', 'updated_at');
    }

    public function down()
    {
        echo "m160731_105531_rename_updated_ad_column_from_author_table cannot be reverted.\n";

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
