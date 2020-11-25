<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content_span".
 *
 * @property int $id
 * @property int $sentence_position
 * @property int $position
 * @property string $original
 * @property int|null $translation
 * @property int $space_after
 * @property int $content_id
 */
class ContentSpan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content_span';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sentence_position', 'position', 'original', 'space_after', 'content_id'], 'required'],
            [['sentence_position', 'position', 'translation', 'space_after', 'content_id'], 'integer'],
            [['original'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sentence_position' => 'Sentence Position',
            'position' => 'Position',
            'original' => 'Original',
            'translation' => 'Translation',
            'space_after' => 'Space After',
            'content_id' => 'Content ID',
        ];
    }
}
