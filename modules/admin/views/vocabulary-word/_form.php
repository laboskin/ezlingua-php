<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VocabularyWord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vocabulary-word-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vocabulary_id')->textInput() ?>

    <?= $form->field($model, 'word_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
