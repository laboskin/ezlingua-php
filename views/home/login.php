<?php

/* @var $this yii\web\View */
/* @var $model app\models\forms\LoginForm */
$this->title = Yii::t('homeLogin', 'Sign in');
\app\assets\HomeLoginAsset::register($this);

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html; ?>

<div class="main-register">
    <div class="register-block">
        <div class="close-button"></div>
        <?php $form = ActiveForm::begin(['class'=>'form-horizontal register-form']); ?>
        <div class="form-title"><?= Yii::t('homeLogin', 'Sign in') ?></div>
        <?= $form->field($model, 'email')->input('email', ['placeholder'=>'']) ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'']) ?>
        <div class="restore-password">
            <a href="<?= \yii\helpers\Url::to(['home/restore']) ?>"><?= Yii::t('homeLogin','Forgot password?') ?></a>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('homeLogin', 'Sign me in'), ['class' => 'submit-button']) ?>
    </div>
        <div class="have-account"><span><?= Yii::t('homeLogin', 'Don\'t have an account?') ?></span><a href="<?= \yii\helpers\Url::to(['home/register']) ?>"><?= Yii::t('homeLogin','Sign up') ?></a></div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
