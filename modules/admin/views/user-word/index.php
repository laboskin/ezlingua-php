<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UserWordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin panel';
\app\assets\AdminAsset::register($this);
?>
<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                UserWord
            </div>
        </div>
    </div>
    <div class="section">
        <p>
            <?= Html::a('Create User Word', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'user_id',
                'word_id',
                'vocabulary_id',
                'training_word_translation',
                //'training_translation_word',
                //'training_cards',
                //'training_audio',
                //'training_constructor',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>

