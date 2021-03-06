<?php

/* @var $this yii\web\View */
/* @var $dictionaryNewForm app\models\forms\DictionaryNewForm */
/* @var $words \app\models\forms\DictionaryNewWordForm[] */

$this->title = Yii::t('dictionaryNew', 'Dictionary');
\app\assets\DictionaryNewAsset::register($this);

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                <?= Yii::t('dictionaryNew', 'New vocabulary') ?>
            </div>
        </div>
    </div>
    <div class="settings">
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($dictionaryNewForm, 'name')->textInput() ?>
        <?= $form->field($dictionaryNewForm, 'group_id')->dropDownList(\app\models\forms\DictionaryNewForm::getGroupSelect()) ?>
        <?= $form->field($dictionaryNewForm, 'image')->widget(\kartik\file\FileInput::class, [
            'name' => 'Image[attachment]',
            'options' => [
                'accept'=>'image/*'
            ],
            'pluginOptions'=> [
                //'initialPreview'=> $contentNewForm->imageLink,
                //'initialPreviewAsData'=>true,
                //'overwriteInitial'=>false,
                'showUpload'=>false,
                'showRemove'=>false,
                'showCaption' => false,
                'showBrowse' => false,
                'showClose'=>false,
                'browseOnZoneClick' => true,
                'fileActionSettings' => [
                    'showZoom' => false,
                ],
            ],
        ]) ?>
        <div class="form-group">
            <?= Html::label(Yii::t('dictionaryNew', 'Words'), '', ['class'=>'control-label']); ?>
            <div class="word-form">
            <?php foreach ($words as $index=>$word): ?>

                    <?= $form->field($word, "[$index]original")->textInput([
                        'placeholder' => $word->attributeLabels()['original']
                    ])->label(false) ?>
                    <?= $form->field($word, "[$index]translation")->textInput([
                        'placeholder' => $word->attributeLabels()['translation']
                    ])->label(false) ?>
            <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('dictionaryNew', 'Create'), ['class' => 'applyButton']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    </div>
</div>