<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user_book_interactions`.
 * Has foreign keys to the tables:
 *
 * - `book`
 */
class m160809_122055_create_user_book_interactions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_book_interactions', [
            'id' => $this->primaryKey(),
            'ip' => $this->string(20),
            'book_id' => $this->integer(),
            'view' => $this->boolean(),
            'download' => $this->boolean()->defaultValue(0),
        ]);

        // creates index for column `book_id`
        $this->createIndex(
            'idx-user_book_interactions-book_id',
            'user_book_interactions',
            'book_id'
        );

        // add foreign key for table `book`
        $this->addForeignKey(
            'fk-user_book_interactions-book_id',
            'user_book_interactions',
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
        // drops foreign key for table `book`
        $this->dropForeignKey(
            'fk-user_book_interactions-book_id',
            'user_book_interactions'
        );

        // drops index for column `book_id`
        $this->dropIndex(
            'idx-user_book_interactions-book_id',
            'user_book_interactions'
        );

        $this->dropTable('user_book_interactions');
    }
}
