<?php

use yii\db\Migration;

/**
 * Handles the creation for table `book`.
 */
class m160725_154431_create_book_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('book', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'published_date' => $this->date()->notNull(),
            'genre' => $this->string(100)->null(),
            'description' => $this->text()->notNull(),
            'examined' => $this->boolean()->defaultValue(0)->notNull(),
            'blocked' => $this->boolean()->defaultValue(0)->notNull(),
            'created_at' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('book');
    }
}
