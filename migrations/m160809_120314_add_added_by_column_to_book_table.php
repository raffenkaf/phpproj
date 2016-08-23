<?php

use yii\db\Migration;

/**
 * Handles adding added_by to table `book`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m160809_120314_add_added_by_column_to_book_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('book', 'added_by', $this->integer());

        // creates index for column `added_by`
        $this->createIndex(
            'idx-book-added_by',
            'book',
            'added_by'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-book-added_by',
            'book',
            'added_by',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-book-added_by',
            'book'
        );

        // drops index for column `added_by`
        $this->dropIndex(
            'idx-book-added_by',
            'book'
        );

        $this->dropColumn('book', 'added_by');
    }
}
