<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "word".
 *
 * @property int $id
 * @property string $original
 * @property string $translation
 * @property int|null $course_id
 */
class Word extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'word';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['original', 'translation'], 'required'],
            [['course_id'], 'integer'],
            [['original', 'translation'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'original' => 'Original',
            'translation' => 'Translation',
            'course_id' => 'Course ID',
        ];
    }
    public function beforeDelete()
    {
        $userWords = UserWord::findAll(['word_id'=>$this->id]);
        foreach ($userWords as $userWord)
            $userWord->delete();
        $vocabularyWords = VocabularyWord::findAll(['word_id'=>$this->id]);
        foreach ($vocabularyWords as  $vocabularyWord)
            $vocabularyWord->delete();
        return parent::beforeDelete();
    }
}
