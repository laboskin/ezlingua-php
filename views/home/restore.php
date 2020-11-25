<?php

/* @var $this yii\web\View */
/* @var $model app\models\forms\HomeRestoreForm */
$this->title = Yii::t('homeRestore', 'Restore password');
\app\assets\HomeRestoreAsset::register($this);

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html; ?>

<div class="main-register">
    <div class="register-block">
        <div class="close-button"></div>
        <?php $form = ActiveForm::begin(['class'=>'form-horizontal register-form']); ?>
        <div class="form-title"><?= Yii::t('homeRestore', 'Restore password') ?></div>
        <?= $form->field($model, 'email')->input('email', ['placeholder'=>'']) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('homeRestore', 'Restore'), ['class' => 'submit-button']) ?>
        </div>
        <div class="have-account"><span><?= Yii::t('homeRestore', 'Don\'t have an account?') ?></span><a href="<?= \yii\helpers\Url::to(['home/register']) ?>"><?= Yii::t('homeRestore','Sign up') ?></a></div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
