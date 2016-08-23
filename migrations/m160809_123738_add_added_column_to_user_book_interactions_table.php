<?php

use yii\db\Migration;

/**
 * Handles adding added to table `user_book_interactions`.
 */
class m160809_123738_add_added_column_to_user_book_interactions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user_book_interactions', 'added', $this->timestamp());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user_book_interactions', 'added');
    }
}
