<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Word */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="word-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'translation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'course_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
