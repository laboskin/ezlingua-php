<?php


namespace app\models\forms;


use Yii;
use yii\base\Model;
use app\models\User;

class HomeRestoreForm extends Model
{
    public $email;

    public function rules(){
        return[
            ['email', 'filter', 'filter'=>'trim'],
            ['email', 'required'],
            ['email', 'exist', 'targetClass'=>User::className(), 'message'=>Yii::t('homeRestoreForm', 'Wrong email')],
        ];
    }
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('modelHomeRestoreForm', 'Email'),
        ];
    }

    public function sendMail(){
        $user = User::findOne(['email'=>$this->email]);
        if ($user){
            $user->generateRestoreKey();
            if($user->save()){
                return Yii::$app->mailer->compose('restorePassword', ['user'=>$user])
                    ->setFrom([Yii::$app->params['senderEmail']=>Yii::$app->name.'(отправлено роботом'])
                    ->setTo($this->email)
                    ->setSubject('Сброс пароля')
                    ->send();
            }
        }
        return false;
    }
}