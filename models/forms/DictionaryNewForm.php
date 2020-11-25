<?php


namespace app\models\forms;


use app\models\Content;
use app\models\Vocabulary;
use app\models\VocabularyGroup;
use Yii;
use yii\base\Model;

class DictionaryNewForm extends Model
{
    public $name;
    public $group_id;
    public $image;

    public function rules()
    {
        return [
            [['name' ,'group_id'], 'required'],
            [['group_id'], 'integer'],
            [['group_id'], 'exist', 'targetClass'=>'app\models\VocabularyGroup', 'targetAttribute'=>'id'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('modelDictionaryNewForm', 'Title'),
            'group_id' => Yii::t('modelDictionaryNewForm', 'Group'),
            'image' => Yii::t('modelDictionaryNewForm', 'Image'),
        ];
    }

    public static function getGroupSelect()
    {
        $vocabularyGroups = VocabularyGroup::findAll(['course_id'=>Yii::$app->user->getIdentity()->course_id]);
        $result = [];
        foreach ($vocabularyGroups as $vocabularyGroup)
            $result[$vocabularyGroup->id] = $vocabularyGroup->name;
        ksort($result);
        return $result;
    }

}