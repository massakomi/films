<?php

namespace app\models\forms;

use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $image;

    public function rules()
    {
        return [
            [['image'], 'file', 'extensions' => 'png, jpg, gif, webp', 'maxSize' => 1024 * 1024 * 10],
        ];
    }

    public function upload($directory, $id)
    {
        if ($this->image && $this->validate()) {
            $directory = 'upload/'.$directory;
            if (!file_exists($directory)) {
                FileHelper::createDirectory($directory);
            }
            $path = $directory . '/' . $id . '.' . $this->image->extension;
            if (!$this->image->saveAs($path)) {
                return false;
            }
            return $path;
        } else {
            return false;
        }
    }
}