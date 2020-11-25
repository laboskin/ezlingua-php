<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\UserWordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-word-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'word_id') ?>

    <?= $form->field($model, 'vocabulary_id') ?>

    <?= $form->field($model, 'training_word_translation') ?>

    <?php // echo $form->field($model, 'training_translation_word') ?>

    <?php // echo $form->field($model, 'training_cards') ?>

    <?php // echo $form->field($model, 'training_audio') ?>

    <?php // echo $form->field($model, 'training_constructor') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
