<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Course */

$this->title = 'Admin panel';
\app\assets\AdminAsset::register($this);
?>
<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                Create Course
            </div>
        </div>
    </div>
    <div class="section">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>