<?php

use yii\db\Migration;

/**
 * Handles dropping exemined from table `author`.
 */
class m160725_224648_drop_exemined_column_from_author_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->dropColumn('author', 'exemined');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->addColumn('author', 'exemined', $this->boolean());
    }
}
