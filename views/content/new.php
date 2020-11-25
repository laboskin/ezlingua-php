<?php

/* @var $this yii\web\View */
/* @var $contentNewForm app\models\forms\ContentNewForm */

$this->title = Yii::t('contentNew', 'New content');
\app\assets\ContentNewAsset::register($this);

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                <?= Yii::t('contentNew', 'New content') ?>
            </div>
        </div>
    </div>
    <div class="settings">
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($contentNewForm, 'name')->textInput() ?>
        <?= $form->field($contentNewForm, 'complexity')->dropDownList(\app\models\forms\ContentNewForm::getComplexitySelect()) ?>
        <?= $form->field($contentNewForm, 'text')->textarea() ?>

        <?= $form->field($contentNewForm, 'image')->widget(\kartik\file\FileInput::class, [
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
            <?= Html::submitButton(Yii::t('contentNew', 'Create'), ['class' => 'applyButton']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    </div>





</div>