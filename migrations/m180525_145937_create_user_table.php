<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180525_145937_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id'           => $this->primaryKey(),
            'email'        => $this->string()->notNull()->unique(),
            'passwordHash' => $this->string()->notNull(),
            'authKey'      => $this->string()->notNull(),
            'accessToken'  => $this->string()->unique(),
            'firstName'    => $this->string()->notNull(),
            'surname'      => $this->string(),
            'status'       => $this->smallInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
