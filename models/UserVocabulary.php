<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_vocabulary".
 *
 * @property int $id
 * @property int $user_id
 * @property int $vocabulary_id
 */
class UserVocabulary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_vocabulary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'vocabulary_id'], 'required'],
            [['user_id', 'vocabulary_id'], 'integer'],
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
            'vocabulary_id' => 'Vocabulary ID',
        ];
    }

    public static function getUserVocabularySelect()
    {
        $result = [];
        $userVocabularies = self::findAll(['user_id'=>Yii::$app->user->getId()]);
        $vocabularies = Vocabulary::find()
            ->where(['in', 'id', ArrayHelper::getColumn($userVocabularies, 'vocabulary_id')])
            ->andWhere(['course_id'=>Yii::$app->user->getIdentity()->course_id])
            ->all();
        foreach ($vocabularies as $vocabulary)
            $result[$vocabulary->id] = $vocabulary->name;
        return $result;
    }
}
