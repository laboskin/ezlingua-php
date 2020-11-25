<?php


namespace app\models\forms;


use app\models\User;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;

class HomeResetForm extends Model
{
    public $password;
    public $passwordRepeat;
    public $error;
    private $user;
    public function rules()
    {
        return [
            [['password', 'passwordRepeat'], 'required'],
            [['password', 'passwordRepeat'], 'string', 'min' => 8, 'max'=>255],
            ['passwordRepeat', 'compare', 'compareAttribute'=>'password'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('modelHomeResetForm', 'Password'),
            'passwordRepeat' => Yii::t('modelHomeResetForm', 'Confirm password')
        ];
    }
    public function __construct($key, $config = [])
    {
        $this->error = false;
        if(empty($key) || !is_string($key))
            $this->error = true;
        $this->user = User::findByRestoreKey($key);
        if(!$this->user)
            $this->error = true;
        parent::__construct($config);
    }

    public function resetPassword()
    {
        $user = $this->user;
        $user->setPassword($this->password);
        $user->removeRestoreKey();
        Yii::$app->user->login($user, 3600*24*30*12);
        return $user->save();
    }


}