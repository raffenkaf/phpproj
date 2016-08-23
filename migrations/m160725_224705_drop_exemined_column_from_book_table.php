<?php

use yii\db\Migration;

/**
 * Handles dropping exemined from table `book`.
 */
class m160725_224705_drop_exemined_column_from_book_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('book', 'exemined');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('book', 'exemined', $this->boolean());
    }
}
