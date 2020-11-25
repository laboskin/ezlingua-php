<?php


namespace app\models\forms;


use app\models\User;
use yii\base\Model;
use Yii;

class RegisterForm extends Model
{
    public $email;
    public $password;
    public $name;
    public $course_id;

    public function rules()
    {
        return [
            [['email', 'password', 'name', 'course_id'], 'required'],
            [['course_id'], 'integer'],
            [['email'], 'unique', 'targetClass'=>'app\models\User'],
            [['email'], 'string', 'min' => 5, 'max'=>50],
            [['password'], 'string', 'min' => 8, 'max'=>255],
            [['name'], 'string', 'min' => 2, 'max'=>50],
        ];
    }
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('modelRegisterForm', 'Email'),
            'password' => Yii::t('modelRegisterForm', 'Password'),
            'name' => Yii::t('modelRegisterForm', 'Name'),
            'course_id' => Yii::t('modelRegisterForm', 'Language'),
        ];
    }
    public function register(){
        $user = new User();
        $user->email = $this->email;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->name = $this->name;
        $user->course_id = $this->course_id;
        $user->status = User::STATUS_USER;
        if($user->save())
            return Yii::$app->user->login($user, 3600*24*30);
    }

}