<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persons".
 *
 * @property int $id
 * @property string $fio
 *
 * @property FilmPersons[] $filmPersons
 */
class Persons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'persons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio'], 'required'],
            [['fio'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
        ];
    }

    /**
     * Gets query for [[FilmPersons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFilmPersons()
    {
        return $this->hasMany(FilmPersons::class, ['person_id' => 'id']);
    }
}
