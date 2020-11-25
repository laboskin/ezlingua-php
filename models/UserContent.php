<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_content".
 *
 * @property int $id
 * @property int $user_id
 * @property int $content_id
 */
class UserContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'content_id'], 'required'],
            [['user_id', 'content_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'content_id' => 'Content ID',
        ];
    }
}
