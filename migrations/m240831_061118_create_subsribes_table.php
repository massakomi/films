<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subsribes}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%persons}}`
 */
class m240831_061118_create_subsribes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subsribes}}', [
            'id' => $this->primaryKey(),
            'person_id' => $this->integer()->notNull(),
            'phone' => $this->string()->notNull(),
            'date_added' => $this->datetime(),
        ]);

        // creates index for column `person_id`
        $this->createIndex(
            '{{%idx-subsribes-person_id}}',
            '{{%subsribes}}',
            'person_id'
        );

        // add foreign key for table `{{%persons}}`
        $this->addForeignKey(
            '{{%fk-subsribes-person_id}}',
            '{{%subsribes}}',
            'person_id',
            '{{%persons}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%persons}}`
        $this->dropForeignKey(
            '{{%fk-subsribes-person_id}}',
            '{{%subsribes}}'
        );

        // drops index for column `person_id`
        $this->dropIndex(
            '{{%idx-subsribes-person_id}}',
            '{{%subsribes}}'
        );

        $this->dropTable('{{%subsribes}}');
    }
}
