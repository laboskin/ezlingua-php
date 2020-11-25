<?php


namespace app\models\forms;


use app\models\Content;
use Yii;
use yii\base\Model;

class ContentNewForm extends Model
{
    public $name;
    public $complexity;
    public $text;
    public $image;

    public function rules()
    {
        return [
            [['name' ,'text', 'complexity'], 'required'],
            [['complexity'], 'integer'],
            [['name'], 'string', 'min' => 2, 'max'=>50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('modelContentNewForm', 'Title'),
            'complexity' => Yii::t('modelContentNewForm', 'Complexity'),
            'text' => Yii::t('modelContentNewForm', 'Text'),
            'image' => Yii::t('modelContentNewForm', 'Image'),
        ];
    }

    public static function getComplexitySelect()
    {
        return [
            Content::COMPLEXITY_LOW => Yii::t('modelContentNewForm', 'Low'),
            Content::COMPLEXITY_MEDIUM => Yii::t('modelContentNewForm', 'Medium'),
            Content::COMPLEXITY_HIGH => Yii::t('modelContentNewForm', 'High'),
        ];
    }

}