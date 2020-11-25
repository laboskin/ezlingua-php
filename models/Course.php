<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "course".
 *
 * @property int $id
 * @property int $goal_language_id
 * @property int $original_language_id
 * @property string $name
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['goal_language_id', 'original_language_id', 'name'], 'required'],
            [['goal_language_id', 'original_language_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goal_language_id' => 'Goal Language ID',
            'original_language_id' => 'Original Language ID',
            'name' => 'Name',
        ];
    }

    public function getGoalLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'goal_language_id'])->one();
    }

    public static function coursesForSelect()
    {
        $courses = self::find()->where(['original_language_id' => Language::findOne(['yii_code' => Yii::$app->language])->id])->all();
        $result = [];
        foreach ($courses as $course)
            $result[$course->id] = $course->name;
        return $result;
    }
}
