<?php

namespace app\models;

use app\models\forms\UploadForm;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

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
            [['year'], 'integer'],
            [['isbn'], 'string', 'max' => 17],
            [['description'], 'string'],
            [['date_added'], 'safe'],
            [['name'], 'string', 'max' => 255],
            ['poster_id', 'file', 'extensions' => 'png, jpg, gif, webp', 'maxSize' => 1024 * 1024 * 10],
            [['poster'], 'exist', 'skipOnError' => true, 'targetClass' => Files::class, 'targetAttribute' => ['poster_id' => 'id']],

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
     * Gets query for [[Poster]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoster()
    {
        return $this->hasOne(Files::class, ['id' => 'poster_id']);
    }

    /**
     * @param $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->date_added = date('Y-m-d H:i:s');
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return void
     * @throws \yii\base\Exception
     */
    public function uploadPoster()
    {
        $uploadForm = new UploadForm();
        $uploadForm->image = UploadedFile::getInstance($this, 'poster_id');
        if (!$uploadForm->image) {
            return;
        }
        $path = $uploadForm->upload('posters', $id=1);
        if (!$path) {
            return;
        }
        $file = new Files();
        if ($this->poster_id) {
            $file = Files::findOne($this->poster_id);
        }
        $file->path = $path;
        $file->save();
        $this->link('poster', $file);
    }
}
