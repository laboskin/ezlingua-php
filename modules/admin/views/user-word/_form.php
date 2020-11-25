<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserWord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-word-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'word_id')->textInput() ?>

    <?= $form->field($model, 'vocabulary_id')->textInput() ?>

    <?= $form->field($model, 'training_word_translation')->textInput() ?>

    <?= $form->field($model, 'training_translation_word')->textInput() ?>

    <?= $form->field($model, 'training_cards')->textInput() ?>

    <?= $form->field($model, 'training_audio')->textInput() ?>

    <?= $form->field($model, 'training_constructor')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
