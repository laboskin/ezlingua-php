<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "content".
 *
 * @property int $id
 * @property string $name
 * @property int $complexity
 * @property int $course_id
 * @property string|null $image
 */
class Content extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'complexity', 'course_id'], 'required'],
            [['complexity', 'course_id'], 'integer'],
            [['complexity'], 'in', 'range'=>[self::COMPLEXITY_LOW, self::COMPLEXITY_MEDIUM, self::COMPLEXITY_HIGH]],
            [['name'], 'string', 'max' => 50],
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
            'complexity' => 'Complexity',
            'course_id' => 'Course ID',
            'image' => 'Image',
        ];
    }

    const COMPLEXITY_LOW = 1;
    const COMPLEXITY_MEDIUM = 2;
    const COMPLEXITY_HIGH = 3;

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
        if ($imageFile->saveAs(Yii::getAlias('@images').'/content/'.$newImageName))
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
        return Yii::getAlias('@images').'/content/'.$this->image;
    }

    public function getImageLink()
    {
        if ($this->image and file_exists($this->getImagePath()))
            return Url::home(true).'web/source/images/content/'.$this->image;
        else
            return Url::home(true).'web/source/images/content/nophoto.svg';
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        $contentSpans = ContentSpan::find()->where(['content_id'=>$this->id])->all();
        foreach ($contentSpans as $contentSpan)
            $contentSpan->delete();
        return parent::beforeDelete();
    }


}
