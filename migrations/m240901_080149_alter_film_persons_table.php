<?php

use yii\db\Migration;

/**
 * Class m240901_080149_alter_film_persons_table
 */
class m240901_080149_alter_film_persons_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('{{%idx_unique_film_id_film_persons}}',
            '{{%film_persons}}',
            ['film_id', 'person_id'],
            true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            '{{%idx_unique_film_id_film_persons}}',
            '{{%film_persons}}'
        );
    }
}
