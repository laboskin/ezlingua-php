<?php

/* @var $this yii\web\View */
/* @var $model app\models\forms\RegisterForm */
$this->title = Yii::t('homeRegister', 'Sign up');
\app\assets\HomeRegisterAsset::register($this);

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html; ?>

<div class="main-register">
    <div class="register-block">
        <?php $form = ActiveForm::begin(['class'=>'form-horizontal register-form', 'enableAjaxValidation' => true, 'enableClientValidation' => false, ]); ?>
        <div class="form-title"><?= Yii::t('homeRegister', 'Sign up') ?></div>
        <?= $form->field($model, 'course_id')->dropDownList(\app\models\Course::coursesForSelect(), [
                'prompt' => Yii::t('homeRegister', 'I want to learn...'),
        ]) ?>
        <?= $form->field($model, 'name')->textInput(['placeholder'=>'']) ?>
        <?= $form->field($model, 'email')->input('email', ['placeholder'=>'']) ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'']) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('homeRegister', 'Sign me up'), ['class' => 'submit-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <div class="have-account"><span><?= Yii::t('homeRegister', 'Already have an account?') ?></span><a href="<?= \yii\helpers\Url::to(['home/login']) ?>"><?= Yii::t('homeRegister', 'Sign in') ?></a></div>
    </div>
</div>
