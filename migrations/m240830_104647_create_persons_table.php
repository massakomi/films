<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%persons}}`.
 */
class m240830_104647_create_persons_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%persons}}', [
            'id' => $this->primaryKey(),
            'fio' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%persons}}');
    }
}
