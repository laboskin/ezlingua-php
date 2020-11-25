<?php

/* @var $this yii\web\View */
/* @var $qWords array */
/* @var $qStep int */
/* @var $qAnswers array */
/* @var $qResults array */
/* @var $qCorrect int */
/* @var $qWrong int */


$this->title = Yii::t('trainingCards', 'Training');
\app\assets\TrainingCardsAsset::register($this);
use yii\helpers\Url; ?>



<div class="main-container">
    <?php \yii\widgets\Pjax::begin([
        'id' => 'qPjaxContainer',
        'enablePushState' => false,
        'enableReplaceState' => false,
        'linkSelector' => false,
        'options' => [
            'async' => false,
        ]
    ]) ?>
    <?= \yii\helpers\Html::hiddenInput('qWordsValue', json_encode($qWords), ['id' => 'qWordsValue'])?>
    <?= \yii\helpers\Html::hiddenInput('qAnswersValue', json_encode($qAnswers), ['id' => 'qAnswersValue'])?>
    <?= \yii\helpers\Html::hiddenInput('qStepValue', $qStep, ['id' => 'qStepValue'])?>

    <?php
    if($qStep <= count($qWords))
    {
        $currentUserWord = \app\models\UserWord::find()->where(['id'=>$qWords[$qStep-1]])->one();
        $currentWord = \app\models\Word::find()->where(['id'=>$currentUserWord->word_id])->one();
    }

    ?>
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text"><?= Yii::t('trainingCards', 'Cards') ?></div>
        </div>
        <?php if($qStep <= count($qWords)): ?>
            <div class="page-progress">
                <div class="page-progress-text">
                    <?= $qStep ?>/<?= count($qWords) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="training-card">
        <div class="training-word">
            <?php if($qStep <= count($qWords)): ?>
                <div class="training-word-text <?php if($qStep <= count($qWords)) echo ($qStep == count($qAnswers))?'has-translation':'no-translation' ?>">
                    <?= $currentWord->original ?>
                </div>
            <?php endif; ?>
            <?php if($qStep == count($qAnswers)): ?>
                <div class="training-word-translation">
                    <?= $currentWord->translation ?>
                </div>
            <?php endif; ?>

            <?php if($qStep > count($qWords)): ?>
                <div class="training-word-text">
                    <?= Yii::t('trainingCards', 'Results') ?>
                </div>
            <?php endif; ?>
        </div>


        <?php if($qStep > count($qWords)): ?>
            <div class="training-results">
                <?php foreach ($qResults as $qResult): ?>

                    <div class="training-result <?= $qResult['correct']?'correct':'wrong' ?>">
                        <div class="training-result-text">
                        <span class="training-result-word">
                            <?= $qResult['word'] ?>
                        </span>
                            <span class="training-result-dash">
                            —
                        </span>
                            <span class="training-result-translation">
                            <?= $qResult['translation'] ?>
                        </span>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        <?php endif; ?>



        <div class="training-buttons">
            <?php if($qStep > count($qWords)): ?>
                <a class="training-button exit" href="<?= Url::to(['training/', 'v'=>Yii::$app->request->get('v')])?>">
                    <div class="training-button-text exit">
                        <?= Yii::t('trainingCards', 'Exit') ?>
                    </div>
                </a>
                <a class="training-button continue" href="<?= Url::to(['training/cards', 'v'=>Yii::$app->request->get('v')])?>">
                    <div class="training-button-text continue">
                        <?= Yii::t('trainingCards', 'Continue') ?>
                    </div>
                    <div class="training-button-icon continue">
                        <svg viewBox="0 0 268.832 268.832">
                            <path d="M265.171,125.577l-80-80c-4.881-4.881-12.797-4.881-17.678,0c-4.882,4.882-4.882,12.796,0,17.678l58.661,58.661H12.5
                        c-6.903,0-12.5,5.597-12.5,12.5c0,6.902,5.597,12.5,12.5,12.5h213.654l-58.659,58.661c-4.882,4.882-4.882,12.796,0,17.678
                        c2.44,2.439,5.64,3.661,8.839,3.661s6.398-1.222,8.839-3.661l79.998-80C270.053,138.373,270.053,130.459,265.171,125.577z"/></svg>
                    </div>
                </a>
            <?php endif; ?>

            <?php if(count($qAnswers) < $qStep and $qStep <= count($qWords)): ?>
                <div data-option="0" class="training-button wrong">
                    <div class="training-button-text  wrong">
                        <?= Yii::t('trainingCards', 'I don\'t know') ?>
                    </div>
                </div>
                <div data-option="1" class="training-button correct">
                    <div class="training-button-text correct">
                        <?= Yii::t('trainingCards', 'I know') ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(count($qAnswers) == $qStep and $qStep <= count($qWords)): ?>
                <?php if($qAnswers[count($qAnswers)-1] == 1): ?>
                    <div data-option="0" class="training-button repeat">
                        <div class="training-button-text  repeat">
                            <?= Yii::t('trainingCards', 'Repeat') ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($qAnswers[count($qAnswers)-1] == 0): ?>
                    <div class="training-button forget">
                        <div class="training-button-text  forget">
                            <?= Yii::t('trainingCards', 'On repeat') ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div data-option="<?= $qAnswers[count($qAnswers)-1] ?>" class="training-button next">
                    <div class="training-button-text next">
                        <?= Yii::t('trainingCards', 'Next') ?>
                    </div>
                    <div class="training-button-icon next">
                        <svg viewBox="0 0 268.832 268.832">
                            <path d="M265.171,125.577l-80-80c-4.881-4.881-12.797-4.881-17.678,0c-4.882,4.882-4.882,12.796,0,17.678l58.661,58.661H12.5
                        c-6.903,0-12.5,5.597-12.5,12.5c0,6.902,5.597,12.5,12.5,12.5h213.654l-58.659,58.661c-4.882,4.882-4.882,12.796,0,17.678
                        c2.44,2.439,5.64,3.661,8.839,3.661s6.398-1.222,8.839-3.661l79.998-80C270.053,138.373,270.053,130.459,265.171,125.577z"/></svg>
                    </div>
                </div>
            <?php endif; ?>


            <?php if($qStep <= count($qWords)): ?>
                <a class="training-button exit" href="<?= Url::to(['training/', 'v'=>Yii::$app->request->get('v')])?>">
                    <div class="training-button-text exit">
                        <?= Yii::t('trainingCards', 'Exit') ?>
                    </div>
                </a>
            <?php endif; ?>

        </div>
    </div>


    <?php \yii\widgets\Pjax::end() ?>
    <script>
        $(document).ready(function() {
            $('body').on('click' , '[data-option]', function(){
                $.pjax({
                    type       : 'POST',
                    container  : '#qPjaxContainer',
                    data       : {qWords: $('#qWordsValue').val(),
                        qStep: $('#qStepValue').val(),
                        qAnswers: $('#qAnswersValue').val(),
                        qSelected:$(this).attr('data-option')},
                    push       : false,
                    scrollTo : false,
                    async: false,
                });
            });
        });
    </script>

</div>


