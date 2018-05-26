<?php

use yii\db\Migration;

/**
 * Handles the creation of table `book`.
 */
class m180526_062500_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('book', [
            'id'        => $this->primaryKey(),
            'title'     => $this->string()->notNull(),
            'author'    => $this->string(),
            'desc'      => $this->string(),
            'issueYear' => $this->integer(),
            'point_id'  => $this->integer()->notNull(),
            'user_id'   => $this->integer(),
            'status'    => $this->smallInteger()->defaultValue(0),
            'rating'    => $this->integer()->defaultValue(0),
            'imagePath' => $this->string(),
        ]);

        $this->addForeignKey('fk_book_point_id', 'book', 'point_id', 'point', 'id', 'CASCADE');
        $this->addForeignKey('fk_book_user_id', 'book', 'user_id', 'user', 'id', 'CASCADE');

        for ($i = 1; $i <= 20; $i++) {
            $this->insert('book', [
                'title'     => 'Незнайка на луне',
                'author'    => 'В. Носов',
                'issueYear' => 2000,
                'point_id'  => $i,
            ]);
            $this->insert('book', [
                'title'     => 'Денискины рассказы',
                'author'    => 'Драгунский',
                'issueYear' => 2005,
                'point_id'  => $i,
            ]);
            $this->insert('book', [
                'title'     => 'Война и мир',
                'author'    => 'Л. Н. Толстой',
                'issueYear' => 1956,
                'point_id'  => $i,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_book_point_id', 'book');
        $this->dropForeignKey('fk_book_user_id', 'book');
        $this->dropTable('book');
    }
}
