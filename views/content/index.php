<?php

/* @var $this yii\web\View */
/* @var $contents array */
/* @var $userContentIds array */
/* @var $q string */



$this->title = Yii::t('contentIndex', 'Content');
\app\assets\ContentIndexAsset::register($this);


use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
echo \yii\bootstrap\Html::hiddenInput('contentsValue', json_encode($contents), ['id'=>'contentsValue']);
echo \yii\bootstrap\Html::hiddenInput('userContentIdsValue', json_encode($userContentIds), ['id'=>'userContentIdsValue']);
?>

<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                <?= Yii::t('contentIndex', 'Content') ?>
            </div>
        </div>
        <?php if(in_array(Yii::$app->user->getIdentity()->status, [\app\models\User::STATUS_AUTHOR, \app\models\User::STATUS_ADMIN])): ?>
            <a class="page-content-new" href="<?= \yii\helpers\Url::to(['content/new']) ?>">
                <div class="page-content-new-icon">
                    <svg viewBox="0 0 448 448">
                        <path d="m408 184h-136c-4.417969 0-8-3.582031-8-8v-136c0-22.089844-17.910156-40-40-40s-40
                                        17.910156-40 40v136c0 4.417969-3.582031 8-8 8h-136c-22.089844
                                        0-40 17.910156-40 40s17.910156 40 40 40h136c4.417969 0 8 3.582031
                                        8 8v136c0 22.089844 17.910156 40 40 40s40-17.910156 40-40v-136c0-4.417969
                                        3.582031-8 8-8h136c22.089844 0 40-17.910156 40-40s-17.910156-40-40-40zm0 0"/></svg>
                </div>
                <div class="page-content-new-text">
                    <?= Yii::t('contentIndex', 'New') ?>
                </div>
            </a>
        <?php endif; ?>
        <div class="page-filter">
            <?= Html::dropDownList('complexitySelect', $q, \app\models\forms\ContentNewForm::getComplexitySelect(), [
                    'id' => 'complexitySelect',
                    'class' => 'form-control',
                    'prompt' => Yii::t('modelContentNewForm', 'Complexity')
            ]) ?>
        </div>
    </div>
    <?php \yii\widgets\Pjax::begin([
        'id' => 'dPjaxContainer',
        'enablePushState' => false,
        'enableReplaceState' => false,
        'linkSelector' => false,
        'options' => [
        ]
    ]) ?>
    <div class="content-list">
        <div class="items-grid">
            <?php foreach ($contents as $content): ?>
            <?php if (!empty($q) and $q!=$content['complexity']) continue ?>
            <a href="<?= \yii\helpers\Url::to(['content/view', 'c'=>$content['id']]) ?>" class="content">
                <div class="content-image">
                    <img src="<?= $content['imageLink'] ?>" alt="">
                </div>
                <div class="content-text">
                    <?php if(in_array($content['id'], $userContentIds)): ?>
                    <div class="content-icon">
                        <svg viewBox="0 0 47 47">
                            <path d="M37.6,0H9.4C4.209,0,0,4.209,0,9.4v28.2C0,42.791,4.209,47,9.4,47h28.2c5.191,0,9.4-4.209,9.4-9.4V9.4
                            C47,4.209,42.791,0,37.6,0z M38.143,19.139L23.602,33.678c-0.803,0.805-1.854,1.205-2.906,1.205c-1.051,0-2.104-0.4-2.907-1.205
                            l-8.933-8.932c-1.604-1.604-1.604-4.208,0-5.814c1.607-1.606,4.209-1.606,5.816,0l6.023,6.023l11.633-11.633
                            c1.605-1.605,4.209-1.605,5.814,0C39.75,14.928,39.75,17.532,38.143,19.139z"/></svg>
                    </div>
                    <?php endif; ?>
                    <?= $content['name'] ?>
                </div>
            </a>
            <?php endforeach; ?>
            <div class="hidden-content"></div>
            <div class="hidden-content"></div>
            <div class="hidden-content"></div>
            <div class="hidden-content"></div>
            <div class="hidden-content"></div>
            <div class="hidden-content"></div>
            <div class="hidden-content"></div>
            <div class="hidden-content"></div>
            <div class="hidden-content"></div>
            <div class="hidden-content"></div>


        </div>
    </div>
    <?php \yii\widgets\Pjax::end() ?>

</div>


<script>
    $(document).ready(function() {
        $('body').on('change' , '.page-filter select', function(event){
            if (!$('.main-container').hasClass('cursor-loading'))
            {
                $('.main-container').addClass('cursor-loading');
                $.pjax({
                    type       : 'POST',
                    container  : '#dPjaxContainer',
                    data       : {
                        q: $(this).val(),
                        contents: $('#contentsValue').val(),
                        userContentIds: $('#userContentIdsValue').val(),
                    },
                    push       : false,
                    scrollTo : false,
                });
            }
        });
        $('body').on('click touchstart' , '.cursor-loading', function(event){
            event.stopPropagation();
            event.preventDefault();
        });
        $(document).on('ready pjax:success', function() {
            $('.cursor-loading').removeClass('cursor-loading');
        })
    });
</script>