<?php


namespace app\models\forms;


use app\models\User;
use Yii;
use yii\base\Model;

class UserContactsChangeForm extends Model
{
    public $email;
    public $name;


    public function rules()
    {
        return [
            [['email'], 'string', 'min' => 5, 'max'=>50],
            [['name'], 'string', 'min' => 2, 'max'=>50],
            [['email'], 'unique', 'targetClass'=>'app\models\User', 'filter'=>['!=', 'email', Yii::$app->user->getIdentity()->email]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('modelContactsChangeForm', 'Name'),
            'email' => 'Email'
        ];
    }

    public function changeContacts()
    {
        $user = Yii::$app->user->getIdentity();
        $user->name = $this->name;
        $user->email = $this->email;
        return $user->save();
    }
}