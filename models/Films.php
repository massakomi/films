<?php

namespace app\models;

use app\models\forms\UploadForm;
use Biblys\Isbn\Isbn;
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
            [['year'], 'number', 'min' => 1888, 'max' => 1 + (int)date('Y')],
            [['isbn'], 'isbnCheck'],
            [['description'], 'string'],
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

    public function isbnCheck($attribute, $params)
    {
        if (!$this->$attribute) {
            return;
        }
        try {
            Isbn::validateAsIsbn13($this->$attribute);
        } catch (\Exception $e) {
            $this->addError($attribute, $e->getMessage());
        }
    }

    /**
     * Gets query for [[Persons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersons()
    {
        return $this->hasMany(Persons::class, ['id' => 'person_id'])->via('filmPersons');
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
     * @param $insert
     * @param array $changedAttributes
     * @return bool
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

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

    /**
     * @param array $persons
     * @return void
     * @throws \yii\db\Exception
     */
    public function savePersons(array $personsIds)
    {
        $persons = Persons::findAll(['id' => $personsIds]);
        $currentPersons = $this->selectedPersons();
        foreach ($persons as $person) {
            if (in_array($person->id, $currentPersons)) {
                unset($currentPersons[array_search($person->id, $currentPersons)]);
                continue;
            }
            $this->link('persons', $person);
        }
        foreach ($currentPersons as $person) {
            $this->unlink('persons', Persons::findOne($person), delete: true);
        }
    }

    /**
     * @param array $persons
     * @return void
     * @throws \yii\db\Exception
     */
    public function notifyUsers(array $newPersons)
    {
        $diffPersons = array_diff($newPersons, $this->selectedPersons());
        foreach ($diffPersons as $personId) {
            $person = Persons::findOne($personId);
            if (!$person->id) {
                continue;
            }
            $subscribers = Subsribes::findAll(['person_id' => $personId]);
            foreach ($subscribers as $subscriber) {
                $message = "У актера $person->fio в базе опубликован новый фильм $this->name";
                try {
                    SmsPilot::send($subscriber->phone, $message);
                    Yii::info($message);
                } catch (\Exception $e) {
                    Yii::warning($e->getMessage());
                }
            }
        }
    }

    /**
     * @return array
     */
    public function selectedPersons()
    {
        $selected = [];
        foreach ($this->filmPersons as $item) {
            $selected []= $item->person_id;
        }
        return $selected;
    }
}
