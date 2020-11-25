<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Content */

$this->title = 'Admin panel';
\app\assets\AdminAsset::register($this);
?>
<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                Update Content: <?= $model->id ?>
            </div>
        </div>
    </div>
    <div class="section">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>