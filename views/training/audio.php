<?php

/* @var $this yii\web\View */
/* @var $qWords array */
/* @var $qOptions array */
/* @var $qStep int */
/* @var $qAnswers array */
/* @var $qResults array */
/* @var $qCorrect int */
/* @var $qWrong int */
/* @var $languageCode string  */


$this->title = Yii::t('trainingAudio', 'Training');
\app\assets\TrainingAudioAsset::register($this);
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
    <?= \yii\helpers\Html::hiddenInput('qOptionsValue', json_encode($qOptions), ['id' => 'qOptionsValue'])?>
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
            <div class="page-name-text"><?= Yii::t('trainingAudio', 'Listening') ?></div>
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
            <?php if($qStep <= count($qWords) and $qStep > count($qAnswers)): ?>
                <div class="training-audio">
                    <div class="training-audio-icon" onclick="say('<?= $currentWord->original ?>', '<?= $languageCode ?>');">
                        <svg viewBox="0 0 480 480">
                            <path d="M278.944,17.577c-5.568-2.656-12.128-1.952-16.928,1.92L106.368,144.009H32c-17.632,0-32,14.368-32,32v128
                        c0,17.664,14.368,32,32,32h74.368l155.616,124.512c2.912,2.304,6.464,3.488,10.016,3.488c2.368,0,4.736-0.544,6.944-1.6
                        c5.536-2.656,9.056-8.256,9.056-14.4v-416C288,25.865,284.48,20.265,278.944,17.577z"/>
                            <path d="M368.992,126.857c-6.304-6.208-16.416-6.112-22.624,0.128c-6.208,6.304-6.144,16.416,0.128,22.656
                        C370.688,173.513,384,205.609,384,240.009s-13.312,66.496-37.504,90.368c-6.272,6.176-6.336,16.32-0.128,22.624
                        c3.136,3.168,7.264,4.736,11.36,4.736c4.064,0,8.128-1.536,11.264-4.64C399.328,323.241,416,283.049,416,240.009
                        S399.328,156.777,368.992,126.857z"/>
                            <path d="M414.144,81.769c-6.304-6.24-16.416-6.176-22.656,0.096c-6.208,6.272-6.144,16.416,0.096,22.624
                        C427.968,140.553,448,188.681,448,240.009s-20.032,99.424-56.416,135.488c-6.24,6.24-6.304,16.384-0.096,22.656
                        c3.168,3.136,7.264,4.704,11.36,4.704c4.064,0,8.16-1.536,11.296-4.64C456.64,356.137,480,299.945,480,240.009
                        S456.64,123.881,414.144,81.769z"/></svg>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($qStep <= count($qWords) and $qStep == count($qAnswers)): ?>
                <div class="training-word-text"  onclick="say('<?= $currentWord->original ?>', '<?= $languageCode ?>');">
                    <?= $currentWord->original ?>
                </div>
            <?php endif; ?>
            <?php if($qStep > count($qWords)): ?>
                <div class="training-word-text">
                    <?= Yii::t('trainingAudio', 'Results') ?>
                </div>
            <?php endif; ?>
        </div>
        <?php if($qStep <= count($qWords)): ?>
            <div class="training-options">
                <?php foreach ($qOptions[$qStep-1] as $index => $qOption): ?>
                    <?php if(count($qAnswers) < $qStep): ?>
                        <div data-option="<?= $index+1 ?>" class="training-option active">
                            <div class="training-option-text">
                                <?= $qOption ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(count($qAnswers) == $qStep and $qOption == $currentWord->translation): ?>
                        <div class="training-option correct">
                            <div class="training-option-text">
                                <?= $qOption ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(count($qAnswers) == $qStep and $qOption != $currentWord->translation
                        and $qAnswers[count($qAnswers)-1] == $index+1): ?>
                        <div class="training-option wrong">
                            <div class="training-option-text">
                                <?= $qOption ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(count($qAnswers) == $qStep and $qOption != $currentWord->translation
                        and $qAnswers[count($qAnswers)-1] != $index+1): ?>
                        <div class="training-option">
                            <div class="training-option-text">
                                <?= $qOption ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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
                    <?= Yii::t('trainingAudio', 'Exit') ?>
                </div>
            </a>
            <?php if(count($qAnswers) < $qStep and $qStep <= count($qWords)): ?>
                <div data-option class="training-button skip">
                    <div class="training-button-text  skip">
                        <?= Yii::t('trainingAudio', 'skip') ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(count($qAnswers) == $qStep and $qStep <= count($qWords)): ?>
                <div data-option class="training-button next">
                    <div class="training-button-text next">
                        <?= Yii::t('trainingAudio', 'Next') ?>
                    </div>
                    <div class="training-button-icon next">
                        <svg viewBox="0 0 268.832 268.832">
                            <path d="M265.171,125.577l-80-80c-4.881-4.881-12.797-4.881-17.678,0c-4.882,4.882-4.882,12.796,0,17.678l58.661,58.661H12.5
                        c-6.903,0-12.5,5.597-12.5,12.5c0,6.902,5.597,12.5,12.5,12.5h213.654l-58.659,58.661c-4.882,4.882-4.882,12.796,0,17.678
                        c2.44,2.439,5.64,3.661,8.839,3.661s6.398-1.222,8.839-3.661l79.998-80C270.053,138.373,270.053,130.459,265.171,125.577z"/></svg>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($qStep > count($qWords)): ?>
                <a class="training-button continue" href="<?= Url::to(['training/audio', 'v'=>Yii::$app->request->get('v')])?>">
                    <div class="training-button-text continue">
                        <?= Yii::t('trainingAudio', 'Continue') ?>
                    </div>
                    <div class="training-button-icon continue">
                        <svg viewBox="0 0 268.832 268.832">
                            <path d="M265.171,125.577l-80-80c-4.881-4.881-12.797-4.881-17.678,0c-4.882,4.882-4.882,12.796,0,17.678l58.661,58.661H12.5
                        c-6.903,0-12.5,5.597-12.5,12.5c0,6.902,5.597,12.5,12.5,12.5h213.654l-58.659,58.661c-4.882,4.882-4.882,12.796,0,17.678
                        c2.44,2.439,5.64,3.661,8.839,3.661s6.398-1.222,8.839-3.661l79.998-80C270.053,138.373,270.053,130.459,265.171,125.577z"/></svg>
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <input class="pageloadtrigger" type="button" style="display: none">


    <?php \yii\widgets\Pjax::end() ?>
    <script>
        var synth = window.speechSynthesis;
        function say($msg, $lang){
            var msg = new SpeechSynthesisUtterance($msg);
            synth.cancel();
            //msg.volume = 1; // 0 to 1
            msg.rate = 0.7; // 0.1 to 10
          msg.pitch = 1; //0 to 2
            msg.lang = $lang;
            synth.speak(msg);
        }
        $(document).ready(function() {
            $('.training-audio-icon').trigger('click');
            $('body').on('click' , '[data-option]', function() {
                $('.training-audio-icon').trigger('click');
                $.pjax({
                    type: 'POST',
                    container: '#qPjaxContainer',
                    data: {
                        qWords: $('#qWordsValue').val(),
                        qOptions: $('#qOptionsValue').val(),
                        qStep: $('#qStepValue').val(),
                        qAnswers: $('#qAnswersValue').val(),
                        qSelected: $(this).attr('data-option'),
                        languageCode: '<?= $languageCode ?>'
                    },
                    push: false,
                    scrollTo: false,
                });
            });

        });
        $(document).on('pjax:success', function() {
            $('.training-audio-icon').trigger('click');
        });


    </script>

</div>


