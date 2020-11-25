<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\VocabularySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin panel';
\app\assets\AdminAsset::register($this);
?>
<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                Vocabulary
            </div>
        </div>
    </div>
    <div class="section">
        <p>
            <?= Html::a('Create Vocabulary', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                'course_id',
                'group_id',
                'image',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
