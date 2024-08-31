<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subsribes".
 *
 * @property int $id
 * @property int $person_id
 * @property string $phone
 * @property string|null $date_added
 *
 * @property Persons $person
 */
class Subsribes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subsribes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id', 'phone'], 'required'],
            [['person_id'], 'integer'],
            [['date_added'], 'safe'],
            [['phone'], 'string', 'max' => 20],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Persons::class, 'targetAttribute' => ['person_id' => 'id']],
            [['person_id', 'phone'], 'unique', 'targetAttribute' => ['person_id', 'phone'], 'message' => 'You already subscribed'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'person_id' => 'Person ID',
            'phone' => 'Phone',
            'date_added' => 'Date Added',
        ];
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
}
