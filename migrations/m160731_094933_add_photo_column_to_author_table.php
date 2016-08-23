<?php

use yii\db\Migration;

/**
 * Handles adding photo to table `author`.
 */
class m160731_094933_add_photo_column_to_author_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('author', 'photo', 'VARCHAR(100) AFTER `biography` ');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('author', 'photo');
    }
}
