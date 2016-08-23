<?php

use yii\db\Migration;

/**
 * Handles adding examined to table `author`.
 */
class m160725_224918_add_examined_column_to_author_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('author', 'examined', $this->boolean()->defaultValue(0)->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('author', 'examined');
    }
}
