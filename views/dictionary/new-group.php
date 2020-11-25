<?php

/* @var $this yii\web\View */
/* @var $newGroupForm app\models\forms\DictionaryNewGroupForm */

$this->title = Yii::t('dictionaryNewGroup', 'Dictionary');
\app\assets\ContentNewAsset::register($this);

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                <?= Yii::t('dictionaryNewGroup', 'New vocabulary group') ?>
            </div>
        </div>
    </div>
    <div class="settings">
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($newGroupForm, 'name')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('dictionaryNewGroup', 'Create'), ['class' => 'applyButton']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    </div>





</div>