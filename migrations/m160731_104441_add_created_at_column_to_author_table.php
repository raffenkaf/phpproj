<?php

use yii\db\Migration;

/**
 * Handles adding created_at to table `author`.
 */
class m160731_104441_add_created_at_column_to_author_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('author', 'created_ad', $this->timestamp());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('author', 'created_ad');
    }
}
