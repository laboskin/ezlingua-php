<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "language".
 *
 * @property int $id
 * @property string $yii_code
 * @property string $translation_code
 * @property string $name
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['yii_code', 'translation_code', 'name'], 'required'],
            [['yii_code', 'translation_code'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'yii_code' => 'Yii Code',
            'translation_code' => 'Translation Code',
            'name' => 'Name',
        ];
    }
}
