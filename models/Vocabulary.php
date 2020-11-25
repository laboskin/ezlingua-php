<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "vocabulary".
 *
 * @property int $id
 * @property string $name
 * @property int $course_id
 * @property int|null $group_id
 * @property string|null $image
 */
class Vocabulary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vocabulary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'course_id'], 'required'],
            [['course_id', 'group_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['image'], 'string', 'max' => 255],
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
            'course_id' => 'Course ID',
            'group_id' => 'Group ID',
            'image' => 'Image',
        ];
    }

    public function deleteImage()
    {
        if ($this->image)
        {
            if (file_exists($this->getImagePath()))
                unlink($this->getImagePath());
            $this->image = null;
            $this->save();
        }
    }
    public function setImage(UploadedFile $imageFile)
    {
        $newImageName = time().'_'.Yii::$app->getSecurity()->generateRandomString(4).'.'.$imageFile->extension;
        if ($imageFile->saveAs(Yii::getAlias('@images').'/vocabulary/'.$newImageName))
        {
            if ($this->image and file_exists($this->getImagePath()))
                unlink($this->getImagePath());
            $this->image = $newImageName;
            return $this->save();
        }
        else
            return false;
    }

    public function getImagePath()
    {
        return Yii::getAlias('@images').'/vocabulary/'.$this->image;
    }

    public function getImageLink()
    {
        if ($this->image and file_exists($this->getImagePath()))
            return Url::home(true).'web/source/images/vocabulary/'.$this->image;
        else
            return Url::home(true).'web/source/images/vocabulary/nophoto.svg';
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        $vocabularyWords = VocabularyWord::findAll(['vocabulary_id'=>$this->id]);
        foreach ($vocabularyWords as $vocabularyWord)
            $vocabularyWord->delete();
        $userVocabularies = UserVocabulary::findAll(['vocabulary_id'=>$this->id]);
        foreach ($userVocabularies as $userVocabulary)
            $userVocabulary->delete();
        $userWords = UserWord::findAll(['vocabulary_id'=>$this->id]);
        foreach ($userWords as $index=>$userWord)
        {
            $userWords[$index]->vocabulary_id = 0;
            $userWords[$index]->save();
        }
        return parent::beforeDelete();
    }
}
