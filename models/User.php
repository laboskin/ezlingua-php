<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property int $status
 * @property string $restore_key
 * @property int $course_id
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'name'], 'required'],
            [['status', 'course_id'], 'integer'],
            [['status'], 'in', 'range'=>[self::STATUS_USER, self::STATUS_AUTHOR, self::STATUS_ADMIN]],
            [['restore_key'], 'string', 'max' => 255],
            ['restore_key', 'unique'],
            [['password'], 'string', 'min' => 8, 'max'=>255],
            [['name'], 'string', 'min' => 2, 'max'=>50],
            [['email'], 'string', 'min' => 5, 'max'=>50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'name' => 'Name',
            'status' => 'status',
            'restore_key' => 'Restore Key',
        ];
    }

    const STATUS_USER = 1;
    const STATUS_AUTHOR = 2;
    const STATUS_ADMIN = 3;

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {

    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {

    }

    public function validateAuthKey($authKey)
    {

    }

    public static function findByRestoreKey($key)
    {
        if (!static::isRestoreKeyExpire($key))
        {
            return null;
        }
        return static::findOne([
            'restore_key' => $key,
        ]);
    }

    public function generateRestoreKey()
    {
        $this->restore_key = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removeRestoreKey()
    {
        $this->restore_key = null;
    }

    public static function isRestoreKeyExpire($key)
    {
        if (empty($key)) {
            return false;
        }
        $expire = Yii::$app->params['restoreKeyExpire'];
        $parts = explode('_', $key);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }

    public function setPassword($newPassword){
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($newPassword);
    }

    public function getCourse()
    {
        return $this->hasOne(Course::class, ['id' => 'course_id'])->one();
    }

    public function getUserWords()
    {
        return $this->hasMany(UserWord::class, ['user_id' => 'id'])->all();
    }

    public function getWords()
    {
        return Word::find()
            ->where(['course_id'=>$this->course_id])
            ->andWhere(['in', 'id', ArrayHelper::getColumn($this->getUserWords(), 'word_id')])
            ->all();
    }



    public function getOtherCourses()
    {
        $userwords = ArrayHelper::getColumn(UserWord::find()->where(['user_id' => $this->id])->all(), 'word_id');
        $userCoursesIds = array_unique(ArrayHelper::getColumn(Word::find()->where(['in', 'id', $userwords])->all(), 'course_id'));
        return Course::find()->where(['!=', 'id', $this->course_id])->andWhere(['in', 'id', $userCoursesIds])->all();
    }


}
