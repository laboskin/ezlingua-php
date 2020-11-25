<?php


namespace app\models\forms;


use app\models\Content;
use Yii;
use yii\base\Model;

class DictionaryNewWordForm extends Model
{
    public $original;
    public $translation;

    public function rules()
    {
        return [
            [['original'], 'required', 'when'=>function($model){
                return !empty($model->translation);
            }, 'whenClient' => "function (attribute, value) {
        return $('#'+attribute.id).parent('.form-group').siblings('.form-group').find('input').val() != '';
    }"],
            [['translation'], 'required', 'when'=>function($model){
                return !empty($model->original);
            }, 'whenClient' => "function (attribute, value) {
        return $('#'+attribute.id).parent('.form-group').siblings('.form-group').find('input').val() != '';
    }"],
        [['original', 'translation'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'original' => Yii::t('modelDictionaryNewWordForm', 'Word'),
            'translation' => Yii::t('modelDictionaryNewWordForm', 'Translation'),
        ];
    }

}