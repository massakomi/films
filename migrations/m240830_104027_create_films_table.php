<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%films}}`.
 */
class m240830_104027_create_films_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%films}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'year' => $this->smallInteger()->notNull(),
            'description' => $this->text()->null(),
            'isbn' => $this->string(17)->null(),
            'poster_id' => $this->integer(),
            'date_added' => $this->datetime()
        ]);

        $this->createIndex('idx-films-poster', 'films', 'poster');
        $this->addForeignKey('fk-films-poster', 'films', 'poster', 'files', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-films-poster','films');
        $this->dropIndex('idx-films-poster','films');

        $this->dropTable('{{%films}}');
    }
}
