<?php

use yii\db\Migration;

/**
 * Handles the creation for table `authors_books`.
 * Has foreign keys to the tables:
 *
 * - `author`
 * - `book`
 */
class m160725_155208_create_authors_books_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('authors_books', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'book_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx-authors_books-author_id',
            'authors_books',
            'author_id'
        );

        // add foreign key for table `author`
        $this->addForeignKey(
            'fk-authors_books-author_id',
            'authors_books',
            'author_id',
            'author',
            'id',
            'CASCADE'
        );

        // creates index for column `book_id`
        $this->createIndex(
            'idx-authors_books-book_id',
            'authors_books',
            'book_id'
        );

        // add foreign key for table `book`
        $this->addForeignKey(
            'fk-authors_books-book_id',
            'authors_books',
            'book_id',
            'book',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `author`
        $this->dropForeignKey(
            'fk-authors_books-author_id',
            'authors_books'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            'idx-authors_books-author_id',
            'authors_books'
        );

        // drops foreign key for table `book`
        $this->dropForeignKey(
            'fk-authors_books-book_id',
            'authors_books'
        );

        // drops index for column `book_id`
        $this->dropIndex(
            'idx-authors_books-book_id',
            'authors_books'
        );

        $this->dropTable('authors_books');
    }
}
