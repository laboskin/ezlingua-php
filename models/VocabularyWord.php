<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vocabulary_word".
 *
 * @property int $id
 * @property int $vocabulary_id
 * @property int $word_id
 */
class VocabularyWord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vocabulary_word';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vocabulary_id', 'word_id'], 'integer'],
            [['word_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vocabulary_id' => 'Vocabulary ID',
            'word_id' => 'Word ID',
        ];
    }
}
