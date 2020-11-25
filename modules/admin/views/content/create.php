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
                Create Content
            </div>
        </div>
    </div>
    <div class="section">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>