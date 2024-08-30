<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%film_persons}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%films}}`
 * - `{{%persons}}`
 */
class m240830_104942_create_film_persons_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%film_persons}}', [
            'id' => $this->primaryKey(),
            'film_id' => $this->integer()->notNull(),
            'person_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `film_id`
        $this->createIndex(
            '{{%idx-film_persons-film_id}}',
            '{{%film_persons}}',
            'film_id'
        );

        // add foreign key for table `{{%films}}`
        $this->addForeignKey(
            '{{%fk-film_persons-film_id}}',
            '{{%film_persons}}',
            'film_id',
            '{{%films}}',
            'id',
            'CASCADE'
        );

        // creates index for column `person_id`
        $this->createIndex(
            '{{%idx-film_persons-person_id}}',
            '{{%film_persons}}',
            'person_id'
        );

        // add foreign key for table `{{%persons}}`
        $this->addForeignKey(
            '{{%fk-film_persons-person_id}}',
            '{{%film_persons}}',
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
        // drops foreign key for table `{{%films}}`
        $this->dropForeignKey(
            '{{%fk-film_persons-film_id}}',
            '{{%film_persons}}'
        );

        // drops index for column `film_id`
        $this->dropIndex(
            '{{%idx-film_persons-film_id}}',
            '{{%film_persons}}'
        );

        // drops foreign key for table `{{%persons}}`
        $this->dropForeignKey(
            '{{%fk-film_persons-person_id}}',
            '{{%film_persons}}'
        );

        // drops index for column `person_id`
        $this->dropIndex(
            '{{%idx-film_persons-person_id}}',
            '{{%film_persons}}'
        );

        $this->dropTable('{{%film_persons}}');
    }
}
