<?php

/* @var $this yii\web\View */
/* @var $userPasswordChange app\models\forms\UserPasswordChangeForm */
/* @var $userContactsChange app\models\forms\UserContactsChangeForm */

$this->title = Yii::t('userSettings', 'Settings');
\app\assets\UserSettingsAsset::register($this);

use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>

<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                <?= Yii::t('userSettings', 'Settings') ?>
            </div>
        </div>
    </div>
    <div class="settings">
        <div class="user-email">
            <span><?= \app\models\User::findOne(Yii::$app->user->id)->email ?></span>
        </div>
        <div class="settings-block">
            <h4><?= Yii::t('userSettings', 'Contacts') ?></h4>
            <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'enableClientValidation' => false]); ?>
            <?= $form->field($userContactsChange, 'email')->textInput(['value'=>\app\models\User::findOne(Yii::$app->user->id)->email]) ?>
            <?= $form->field($userContactsChange, 'name')->textInput(['value'=>\app\models\User::findOne(Yii::$app->user->id)->name]) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('userSettings', 'Save'), ['class' => 'applyButton']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>



        <div class="settings-block">
            <h4><?= Yii::t('userSettings', 'Change password') ?></h4>
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($userPasswordChange, 'oldPassword')->passwordInput()  ?>
            <?= $form->field($userPasswordChange, 'newPassword')->passwordInput()  ?>
            <?= $form->field($userPasswordChange, 'newPasswordRepeat')->passwordInput()  ?>


            <div class="form-group">
                <?= Html::submitButton(Yii::t('userSettings', 'Save'), ['class' => 'applyButton']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>

    </div>

    </div>





</div>