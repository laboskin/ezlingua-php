<?php

/* @var $this yii\web\View */
/* @var $qWords array */
/* @var $qStep int */
/* @var $qResults array */
/* @var $qCorrect int */
/* @var $qWrong int */


$this->title = Yii::t('trainingConstructor', 'Training');
\app\assets\TrainingConstructorAsset::register($this);
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
    <?= \yii\helpers\Html::hiddenInput('qStepValue', $qStep, ['id' => 'qStepValue'])?>

    <?php
    //echo '<pre>'.print_r($qWords, true).'</pre>';
    ?>
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text"><?= Yii::t('trainingConstructor', 'Constructor') ?></div>
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
                <div class="training-word-text">
                    <?= $qWords[$qStep-1]['translation'] ?>
                </div>

            <div class="training-word-letters">
                <?php foreach ($qWords[$qStep-1]['letters'] as $index => $letter): ?>
                    <?php if($index < $qWords[$qStep-1]['guessed_letters']): ?>
                        <div class="training-word-letter completed">
                            <?= $letter ?>
                        </div>
                    <?php endif; ?>

                    <?php if($index == $qWords[$qStep-1]['guessed_letters']): ?>
                        <div class="training-word-letter next">
                        </div>
                    <?php endif; ?>
                    <?php if($index > $qWords[$qStep-1]['guessed_letters']): ?>
                        <div class="training-word-letter empty">
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>
            </div>

            <div class="training-word-options">
                <?php foreach ($qWords[$qStep-1]['letter_symbols'] as $index=>$letter): ?>

                <?php if ($qWords[$qStep-1]['letter_count'][$index] == 0): ?>
                        <div class="training-word-option empty">
                        </div>
                <?php endif; ?>
                    <?php if ($qWords[$qStep-1]['letter_count'][$index] == 1): ?>
                        <div data-option="<?= $index ?>" class="training-word-option">
                            <?= $letter ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($qWords[$qStep-1]['letter_count'][$index] > 1): ?>
                        <div data-option="<?= $index ?>" class="training-word-option">
                            <?= $letter ?>
                            <div class="training-word-option-count">
                                x<?= $qWords[$qStep-1]['letter_count'][$index] ?>
                            </div>
                        </div>
                    <?php endif; ?>


                <?php endforeach; ?>
            </div>

            <?php endif; ?>
            <?php if($qStep > count($qWords)): ?>
                <div class="training-word-text">
                    <?= Yii::t('trainingConstructor', 'Results') ?>
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
            <a class="training-button exit" href="<?= Url::to(['training/', 'v'=>Yii::$app->request->get('v')])?>">
                <div class="training-button-text exit">
                    <?= Yii::t('trainingConstructor', 'Exit') ?>
                </div>
            </a>

            <?php if($qStep > count($qWords)): ?>
                <a class="training-button continue" href="<?= Url::to(['training/constructor', 'v'=>Yii::$app->request->get('v')])?>">
                    <div class="training-button-text continue">
                        <?= Yii::t('trainingConstructor', 'Continue') ?>
                    </div>
                    <div class="training-button-icon continue">
                        <svg viewBox="0 0 268.832 268.832">
                            <path d="M265.171,125.577l-80-80c-4.881-4.881-12.797-4.881-17.678,0c-4.882,4.882-4.882,12.796,0,17.678l58.661,58.661H12.5
                        c-6.903,0-12.5,5.597-12.5,12.5c0,6.902,5.597,12.5,12.5,12.5h213.654l-58.659,58.661c-4.882,4.882-4.882,12.796,0,17.678
                        c2.44,2.439,5.64,3.661,8.839,3.661s6.398-1.222,8.839-3.661l79.998-80C270.053,138.373,270.053,130.459,265.171,125.577z"/></svg>
                    </div>
                </a>
            <?php endif; ?>
            <?php if($qStep <= count($qWords)): ?>
            <?php if($qWords[$qStep-1]['guessed_letters'] < count($qWords[$qStep-1]['letters'])): ?>
                    <div data-option="0" class="training-button repeat">
                        <div class="training-button-text  repeat">
                            <?= Yii::t('trainingConstructor', 'skip') ?>
                        </div>
                    </div>
            <?php endif; ?>
                <?php if($qWords[$qStep-1]['guessed_letters'] == count($qWords[$qStep-1]['letters'])): ?>
                    <div data-option="0" class="training-button next">
                        <div class="training-button-text next">
                            <?= Yii::t('trainingConstructor', 'Continue') ?>
                        </div>
                        <div class="training-button-icon next">
                            <svg viewBox="0 0 268.832 268.832">
                                <path d="M265.171,125.577l-80-80c-4.881-4.881-12.797-4.881-17.678,0c-4.882,4.882-4.882,12.796,0,17.678l58.661,58.661H12.5
                        c-6.903,0-12.5,5.597-12.5,12.5c0,6.902,5.597,12.5,12.5,12.5h213.654l-58.659,58.661c-4.882,4.882-4.882,12.796,0,17.678
                        c2.44,2.439,5.64,3.661,8.839,3.661s6.398-1.222,8.839-3.661l79.998-80C270.053,138.373,270.053,130.459,265.171,125.577z"/></svg>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>


    <?php \yii\widgets\Pjax::end() ?>
    <script>
        $(document).ready(function() {
            $('body').on('click' , '[data-option]', function(){
                $mistaken = false;
                $word = JSON.parse($('#qWordsValue').val())[$('#qStepValue').val()-1];
                if ($word['letters'][$word['guessed_letters']] != $word['letter_symbols'][$(this).attr('data-option')])
                    $mistaken = true;
                $.pjax({
                    type       : 'POST',
                    container  : '#qPjaxContainer',
                    data       : {qWords: $('#qWordsValue').val(),
                        qStep: $('#qStepValue').val(),

                        qSelected:$(this).attr('data-option')},
                    push       : false,
                    scrollTo : false,
                    async: false,
                });
                if ($mistaken)
                {
                    $('[data-option='+$(this).attr('data-option')+']').addClass('wrong');
                    setTimeout(function(){$('.training-word-option.wrong').removeClass('wrong')}, 500);
                }

            });
        });


    </script>

</div>


