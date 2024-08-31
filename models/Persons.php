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

    /**
     * Gets query for [[Films]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFilms()
    {
        return $this->hasMany(Films::class, ['id' => 'person_id'])->via('filmPersons');
    }

    /**
     * Top person's by films count
     * @param array $where
     * @param int $limit
     * @return array
     */
    public static function getTop(array $where, int $limit): array
    {
        return self::find()
            ->select([
                'persons.id',
                'persons.fio',
                'COUNT(films.id) AS `cnt`'
            ])
            ->joinWith('films')
            ->where($where)
            ->groupBy('persons.id')
            ->orderBy(['cnt' => 'desc'])
            ->limit($limit)
            ->asArray()
            ->all();
    }


}
