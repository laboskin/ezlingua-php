<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\VocabularyGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin panel';
\app\assets\AdminAsset::register($this);
?>
<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                VocabularyGroup
            </div>
        </div>
    </div>
    <div class="section">
        <p>
            <?= Html::a('Create Vocabulary Group', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'course_id',
                'name',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>