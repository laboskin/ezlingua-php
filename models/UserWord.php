<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_word".
 *
 * @property int $id
 * @property int $user_id
 * @property int $word_id
 * @property int|null $vocabulary_id
 * @property int $training_word_translation
 * @property int $training_translation_word
 * @property int $training_cards
 * @property int $training_audio
 * @property int $training_constructor
 */
class UserWord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_word';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'word_id'], 'required'],
            [['user_id', 'word_id', 'vocabulary_id', 'training_word_translation', 'training_translation_word', 'training_cards', 'training_audio', 'training_constructor'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'word_id' => 'Word ID',
            'vocabulary_id' => 'Vocabulary ID',
            'training_word_translation' => 'Training Word Translation',
            'training_translation_word' => 'Training Translation Word',
            'training_cards' => 'Training Cards',
            'training_audio' => 'Training Audio',
            'training_constructor' => 'Training Constructor',
        ];
    }

    const TRAINING_STATUS_NEW = 1;
    const TRAINING_STATUS_LEARNING = 2;
    const TRAINING_STATUS_LEARNED = 3;

    const REQUIRED_TRAININGS_NUMBER = 4;

    public function getTrainingsCompleted()
    {
        return $this->training_word_translation
            + $this->training_translation_word
            + $this->training_audio
            + $this->training_cards
            + $this->training_constructor;
    }

    public function getTrainingStatus()
    {
        $trainingsCompleted = $this->getTrainingsCompleted();
        if ($trainingsCompleted == 0)
            return self::TRAINING_STATUS_NEW;
        elseif ($trainingsCompleted < self::REQUIRED_TRAININGS_NUMBER)
            return self::TRAINING_STATUS_LEARNING;
        else
            return self::TRAINING_STATUS_LEARNED;
    }


}
