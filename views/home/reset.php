<?php

/* @var $this yii\web\View */
/* @var $model app\models\forms\LoginForm */
$this->title = Yii::t('homeReset', 'Restore password');
\app\assets\HomeResetAsset::register($this);

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html; ?>

<div class="main-register">
    <div class="register-block">
        <div class="close-button"></div>
        <?php $form = ActiveForm::begin(['class'=>'form-horizontal register-form']); ?>
        <div class="form-title"><?= Yii::t('homeReset', 'Restore password') ?></div>
        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'']) ?>
        <?= $form->field($model, 'passwordRepeat')->passwordInput(['placeholder'=>'']) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('homeReset', 'Save'), ['class' => 'submit-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
