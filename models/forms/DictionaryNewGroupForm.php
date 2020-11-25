<?php


namespace app\models\forms;


use app\models\Content;
use Yii;
use yii\base\Model;

class DictionaryNewGroupForm extends Model
{
    public $name;

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'min' => 2, 'max'=>50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('modelDictionaryNewGroupForm', 'Title'),
        ];
    }


}