<?php

use yii\db\Migration;

/**
 * Handles adding examined to table `book`.
 */
class m160725_224938_add_examined_column_to_book_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('book', 'examined', $this->boolean()->defaultValue(0)->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('book', 'examined');
    }
}
