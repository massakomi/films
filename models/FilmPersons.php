<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "film_persons".
 *
 * @property int $id
 * @property int $film_id
 * @property int $person_id
 *
 * @property Films $film
 * @property Persons $person
 */
class FilmPersons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'film_persons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['film_id', 'person_id'], 'required'],
            [['film_id', 'person_id'], 'integer'],
            [['film_id'], 'exist', 'skipOnError' => true, 'targetClass' => Films::class, 'targetAttribute' => ['film_id' => 'id']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Persons::class, 'targetAttribute' => ['person_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'film_id' => 'Film ID',
            'person_id' => 'Person ID',
        ];
    }

    /**
     * Gets query for [[Film]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFilm()
    {
        return $this->hasOne(Films::class, ['id' => 'film_id']);
    }

    /**
     * Gets query for [[Person]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Persons::class, ['id' => 'person_id']);
    }
}
