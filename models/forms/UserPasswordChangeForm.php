<?php


namespace app\models\forms;


use Yii;
use yii\base\Model;

class UserPasswordChangeForm extends Model
{
    public $oldPassword;
    public $newPassword;
    public $newPasswordRepeat;

    public function rules()
    {
        return [
            [['oldPassword', 'newPassword', 'newPasswordRepeat'], 'required'],
            [['oldPassword', 'newPassword', 'newPasswordRepeat'], 'string', 'min' => 8, 'max'=>255],
            [['oldPassword'], 'validateOldPassword'],
            ['newPasswordRepeat', 'compare', 'compareAttribute'=>'newPassword'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'oldPassword' => Yii::t('modelPasswordChangeForm', 'Current password'),
            'newPassword' => Yii::t('modelPasswordChangeForm', 'New password'),
            'newPasswordRepeat' => Yii::t('modelPasswordChangeForm', 'Repeat new password')
        ];
    }

    public function validateOldPassword($attribute, $params){
        $user = $this->getUser();
        if (!$user || !Yii::$app->getSecurity()->validatePassword($this->oldPassword, $user->password)){
            $this->addError($attribute, Yii::t('modelPasswordChangeForm', 'Please check you current password'));
        }
    }



    public function changePassword(){
        $user = $this->getUser();
        $user->setPassword($this->newPassword);
        return $user->save();

    }
    public function getUser(){
        return User::findIdentity(Yii::$app->user->id);
    }

}