<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ContentSpanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-span-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sentence_position') ?>

    <?= $form->field($model, 'position') ?>

    <?= $form->field($model, 'original') ?>

    <?= $form->field($model, 'translation') ?>

    <?php // echo $form->field($model, 'space_after') ?>

    <?php // echo $form->field($model, 'content_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
