<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vocabulary_group".
 *
 * @property int $id
 * @property int $course_id
 * @property string $name
 */
class VocabularyGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vocabulary_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id', 'name'], 'required'],
            [['course_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Course ID',
            'name' => 'Name',
        ];
    }
    public function beforeDelete()
    {
        $vocabularies = Vocabulary::findAll(['group_id'=>$this->id]);
        foreach ($vocabularies as $vocabulary)
            $vocabulary->delete();
        return parent::beforeDelete();
    }
}
