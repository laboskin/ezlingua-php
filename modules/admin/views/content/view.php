<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Content */

\yii\web\YiiAsset::register($this);
$this->title = 'Admin panel';
\app\assets\AdminAsset::register($this);
?>
<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                <?= $model->id ?>
            </div>
        </div>
    </div>
    <div class="section">
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'complexity',
                'course_id',
                'image',
            ],
        ]) ?>
    </div>
</div>