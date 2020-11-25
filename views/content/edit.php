<?php

/* @var $this yii\web\View */
/* @var $contentNewForm app\models\forms\ContentNewForm */
/* @var $text string */
/* @var $image string */

$this->title = Yii::t('contentEdit', 'Edit content');
\app\assets\ContentEditAsset::register($this);

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                <?= Yii::t('contentEdit', 'Edit content') ?>
            </div>
        </div>
    </div>
    <div class="settings">
        <?php $form = ActiveForm::begin() ?>
        <?= Html::hiddenInput('text', $text) ?>
        <?= $form->field($contentNewForm, 'name')->textInput() ?>
        <?= $form->field($contentNewForm, 'complexity')->dropDownList(\app\models\forms\ContentNewForm::getComplexitySelect()) ?>
        <?= $form->field($contentNewForm, 'text')->textarea() ?>

        <?= $form->field($contentNewForm, 'image')->widget(\kartik\file\FileInput::class, [
            'name' => 'Image[attachment]',
            'options' => [
                'accept'=>'image/*'
            ],
            'pluginOptions'=> [
                'initialPreview'=> $image?'../web/source/images/content/'.$image:'',
                'initialPreviewAsData'=>true,
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
            <?= Html::submitButton(Yii::t('contentEdit', 'Save'), ['class' => 'applyButton']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
</div>