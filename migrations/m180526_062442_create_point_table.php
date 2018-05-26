<?php

use yii\db\Migration;

/**
 * Handles the creation of table `point`.
 */
class m180526_062442_create_point_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('point', [
            'id'      => $this->primaryKey(),
            'title'   => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
            'desc'    => $this->string(),
        ]);

        for ($i = 1; $i <= 20; $i++) {
            $this->insert('point', [
                'id'      => $i,
                'title'   => "Точка обмена $i",
                'address' => "{$i}-я улица строителей",
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('point');
    }
}
