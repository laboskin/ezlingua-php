<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ContentSpan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-span-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sentence_position')->textInput() ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <?= $form->field($model, 'original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'translation')->textInput() ?>

    <?= $form->field($model, 'space_after')->textInput() ?>

    <?= $form->field($model, 'content_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
