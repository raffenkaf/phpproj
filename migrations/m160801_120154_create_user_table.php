<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m160801_120154_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'login' => $this->string(100)->notNull(),
            'password' => $this->string()->notNull(),
            'role' => $this->integer(1)->defaultValue(10),
            'name' => $this->string(100)->notNull(),
            'last_name' => $this->string(100),
            'patronymic' => $this->string(100),
            'FIO_visibility' => $this->boolean()->defaultValue(0),
            'birth_date' => $this->dateTime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
