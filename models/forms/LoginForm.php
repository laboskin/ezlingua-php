<?php


namespace app\models\forms;


use app\models\User;
use yii\base\Model;
use Yii;

class LoginForm extends Model
{
    public $email;
    public $password;

    public function rules()
{
    return [
        [['email', 'password'], 'required'],
        [['email'], 'string', 'min' => 5, 'max'=>50],
        [['email'], 'email'],
        [['password'], 'string', 'min' => 8, 'max'=>255],
        [['password'], 'validatePassword'],

    ];
}
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('modelLoginForm', 'Email'),
            'password' => Yii::t('modelLoginForm', 'Password'),
        ];
    }
public function validatePassword($attribute, $params){
    $user = User::findOne(['email'=>$this->email]);
    if (!$user || !Yii::$app->getSecurity()->validatePassword($this->password, $user->password)){
        $this->addError($attribute, 'Логин или пароль введены неверно');
    }
}
public function getUser(){
    return User::findOne(['email'=>$this->email]);
}
}