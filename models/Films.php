<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "films".
 *
 * @property int $id
 * @property string $name
 * @property int $year
 * @property string|null $description
 * @property int|null $isbn
 * @property int|null $poster
 * @property string|null $date_added
 *
 * @property FilmPersons[] $filmPersons
 * @property Files $poster0
 */
class Films extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'films';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'year'], 'required'],
            [['year', 'isbn', 'poster'], 'integer'],
            [['description'], 'string'],
            [['date_added'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['poster'], 'exist', 'skipOnError' => true, 'targetClass' => Files::class, 'targetAttribute' => ['poster' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'year' => 'Year',
            'description' => 'Description',
            'isbn' => 'Isbn',
            'poster' => 'Poster',
            'date_added' => 'Date Added',
        ];
    }

    /**
     * Gets query for [[FilmPersons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFilmPersons()
    {
        return $this->hasMany(FilmPersons::class, ['film_id' => 'id']);
    }

    /**
     * Gets query for [[Poster0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoster0()
    {
        return $this->hasOne(Files::class, ['id' => 'poster']);
    }
}
