<?php

use yii\db\Migration;

/**
 * Handles the creation for table `author`.
 */
class m160725_154634_create_author_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('author', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'birth_date' => $this->date()->notNull(),
            'biography' => $this->text()->notNull(),
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
        $this->dropTable('author');
    }
}
