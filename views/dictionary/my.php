<?php

/* @var $this yii\web\View */
/* @var $words array  */
/* @var $vocabulary array  */
/* @var $languageCode string  */
/* @var $q string  */
/* @var $qProgress string  */
/* @var $qTraining string  */


$this->title = Yii::t('dictionaryMy', 'Dictionary');
\app\assets\DictionaryMyAsset::register($this);

?>

<div class="main-container">
    <?php \yii\widgets\Pjax::begin([
        'id' => 'dPjaxContainer',
        'enablePushState' => false,
        'enableReplaceState' => false,
        'linkSelector' => false,
        'options' => [
        ]
    ]) ?>
    <?php
    echo \yii\bootstrap\Html::hiddenInput('wordsValue', json_encode($words), ['id'=>'wordsValue']);
    echo \yii\bootstrap\Html::hiddenInput('vocabularyValue', json_encode($vocabulary), ['id'=>'vocabularyValue']);
    echo \yii\bootstrap\Html::hiddenInput('languageCodeValue', $languageCode, ['id'=>'languageCodeValue']);
    ?>
    <div class="page-title">
        <div class="page-back">
            <a href="<?= \yii\helpers\Url::to([isset($vocabulary)?'dictionary/my':'dictionary/']) ?>" class="page-back-icon">
                <svg viewBox="0 0 447.243 447.243">
                    <path d="M420.361,192.229c-1.83-0.297-3.682-0.434-5.535-0.41H99.305l6.88-3.2c6.725-3.183,12.843-7.515,18.08-12.8l88.48-88.48
                    c11.653-11.124,13.611-29.019,4.64-42.4c-10.441-14.259-30.464-17.355-44.724-6.914c-1.152,0.844-2.247,1.764-3.276,2.754
                    l-160,160C-3.119,213.269-3.13,233.53,9.36,246.034c0.008,0.008,0.017,0.017,0.025,0.025l160,160
                    c12.514,12.479,32.775,12.451,45.255-0.063c0.982-0.985,1.899-2.033,2.745-3.137c8.971-13.381,7.013-31.276-4.64-42.4
                    l-88.32-88.64c-4.695-4.7-10.093-8.641-16-11.68l-9.6-4.32h314.24c16.347,0.607,30.689-10.812,33.76-26.88
                    C449.654,211.494,437.806,195.059,420.361,192.229z"/></svg>
            </a>
        </div>
        <?php if(isset($vocabulary)): ?>
            <div class="page-image">
                <img src="<?= $vocabulary['imageLink'] ?>" alt="">
            </div>
        <?php endif; ?>
        <div class="page-name">
            <div class="page-name-text">
                <?php
                echo mb_strtoupper(Yii::t('dictionaryMy', 'My vocabulary'));
                echo (isset($vocabulary))?': '.mb_strtoupper($vocabulary['name']):'' ?>
                -
                <?= Yii::t(
                    'dictionaryMy',
                    '{n, plural, =0{# words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                    ['n' => count($words)])
                ?>
            </div>
        </div>
        <?php if(isset($vocabulary) and $vocabulary['count'] > count($words)): ?>
            <a href="<?= \yii\helpers\Url::to(['dictionary/vocabulary', 'v'=>$vocabulary['id']]) ?>" class="page-vocabulary-add">
                <div class="page-vocabulary-add-text">
                    <?php
                    echo Yii::t('dictionaryMy', 'Show all').' ';
                    echo Yii::t(
                        'dictionaryMy',
                        '{n, plural, =0{# words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                        ['n' => $vocabulary['count']]);
                    ?>
                </div>
            </a>
        <?php endif; ?>
    </div>
    <div class="page-filter">
        <div class="words-search">
            <?= \yii\helpers\Html::textInput('words-search-input', $q, ['placeholder'=>Yii::t('dictionaryMy', 'Search')])?>
        </div>
        <div class="words-filters">
            <div class="training-filter <?= !empty($qTraining)?'training-filter-active':'' ?>">
                <?= empty($qTraining)?Yii::t('dictionaryMy', 'All trainings'):Yii::t('trainingIndex', $qTraining) ?>
                <div class="training-filter-popup">
                    <div class="training-filter-popup-container">
                        <div data-training class="<?= empty($qTraining)?'training-filter-popup-item-current':'training-filter-popup-item' ?>">
                            <div><?= Yii::t('dictionaryMy', 'All') ?></div>
                        </div>
                        <div data-training="Word-translation" class="<?= ($qTraining=='Word-translation')?'training-filter-popup-item-current':'training-filter-popup-item' ?>">
                            <div><?= Yii::t('trainingIndex', 'Word-translation') ?></div>
                        </div>
                        <div data-training="Translation-word" class="<?= ($qTraining=='Translation-word')?'training-filter-popup-item-current':'training-filter-popup-item' ?>">
                            <div><?= Yii::t('trainingIndex', 'Translation-word') ?></div>
                        </div>
                        <div data-training="Cards" class="<?= ($qTraining=='Cards')?'training-filter-popup-item-current':'training-filter-popup-item' ?>">
                            <div><?= Yii::t('trainingIndex', 'Cards') ?></div>
                        </div>
                        <div data-training="Constructor" class="<?= ($qTraining=='Constructor')?'training-filter-popup-item-current':'training-filter-popup-item' ?>">
                            <div><?= Yii::t('trainingIndex', 'Constructor') ?></div>
                        </div>
                        <div data-training="Listening" class="<?= ($qTraining=='Listening')?'training-filter-popup-item-current':'training-filter-popup-item' ?>">
                            <div><?= Yii::t('trainingIndex', 'Listening') ?></div>
                        </div>
                    </div>
                    <div class="training-filter-popup-triangle">
                        <div class="training-filter-popup-diamond"></div>
                    </div>
                </div>

            </div>
            <div class="progress-filter">
                <div data-progress class="progress-filter-item <?= (empty($qProgress))?'progress-filter-item-active':''?> <?= ($qProgress == \app\models\UserWord::TRAINING_STATUS_NEW)?'progress-filter-item-before-active':''?>">
                    <?= Yii::t('dictionaryMy', 'All') ?>
                </div>
                <div data-progress="<?= \app\models\UserWord::TRAINING_STATUS_NEW ?>" class="progress-filter-item <?= ($qProgress == \app\models\UserWord::TRAINING_STATUS_NEW)?'progress-filter-item-active':''?> <?= ($qProgress == \app\models\UserWord::TRAINING_STATUS_LEARNING)?'progress-filter-item-before-active':''?>">
                    <div class="progress-filter-item-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58 30">
                            <rect style="fill:#c8cbc8;" class="cls-1" x="54" y="10" width="4" height="10"/>
                            <path style="fill:#e7eced;" class="cls-2" d="M1.06,28.62V3.54A2.46,2.46,0,0,1,3.52,1.08H52.59a2.46,2.46,0,0,1,2.47,2.46V28.62a2.46,2.46,0,0,1-2.47,2.46H3.52A2.46,2.46,0,0,1,1.06,28.62Z" transform="translate(-1.06 -1.08)"/>
                            <path style="fill:#ff3e00;" class="cls-3" d="M14.06,1.08H3.52A2.46,2.46,0,0,0,1.06,3.54V28.62a2.46,2.46,0,0,0,2.46,2.46H14.06Z" transform="translate(-1.06 -1.08)"/></svg>
                    </div>
                </div>
                <div data-progress="<?= \app\models\UserWord::TRAINING_STATUS_LEARNING ?>" class="progress-filter-item <?= ($qProgress == \app\models\UserWord::TRAINING_STATUS_LEARNING)?'progress-filter-item-active':''?> <?= ($qProgress == \app\models\UserWord::TRAINING_STATUS_LEARNED)?'progress-filter-item-before-active':''?>">
                    <div class="progress-filter-item-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58 30">
                            <rect style="fill:#c8cbc8;" class="cls-1" x="54" y="10" width="4" height="10"/>
                            <path style="fill:#e7eced;" class="cls-2" d="M1.06,28.62V3.54A2.46,2.46,0,0,1,3.52,1.08H52.59a2.46,2.46,0,0,1,2.47,2.46V28.62a2.46,2.46,0,0,1-2.47,2.46H3.52A2.46,2.46,0,0,1,1.06,28.62Z" transform="translate(-1.06 -1.08)"/>
                            <path style="fill:#ffc900;" class="cls-3" d="M40.06,1.08H3.52A2.46,2.46,0,0,0,1.06,3.54V28.62a2.46,2.46,0,0,0,2.46,2.46H40.06Z" transform="translate(-1.06 -1.08)"/></svg>
                    </div>
                </div>
                <div data-progress="<?= \app\models\UserWord::TRAINING_STATUS_LEARNED ?>" class="progress-filter-item <?= ($qProgress == \app\models\UserWord::TRAINING_STATUS_LEARNED)?'progress-filter-item-active':''?>">
                    <div class="progress-filter-item-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58 30">
                            <path style="fill:#28c38a;" class="cls-1" d="M1.06,28.62V3.54A2.46,2.46,0,0,1,3.52,1.08H52.59a2.46,2.46,0,0,1,2.47,2.46V28.62a2.46,2.46,0,0,1-2.47,2.46H3.52A2.46,2.46,0,0,1,1.06,28.62Z" transform="translate(-1.06 -1.08)"/>
                            <rect style="fill:#c8cbc8;" class="cls-2" x="54" y="10" width="4" height="10"/></svg>
                    </div>
                </div>
            </div>
        </div>
        <a href="<?= \yii\helpers\Url::to(['/training/', 'v'=>$vocabulary['id']]) ?>" class="words-training">
            <div class="words-training-text">
                <?= Yii::t('dictionaryMy', 'Training') ?>

            </div>
            <div class="words-training-icon">
                <svg viewBox="0 0 268.832 268.832">
                    <path d="M265.171,125.577l-80-80c-4.881-4.881-12.797-4.881-17.678,0c-4.882,4.882-4.882,12.796,0,17.678l58.661,58.661H12.5
                        c-6.903,0-12.5,5.597-12.5,12.5c0,6.902,5.597,12.5,12.5,12.5h213.654l-58.659,58.661c-4.882,4.882-4.882,12.796,0,17.678
                        c2.44,2.439,5.64,3.661,8.839,3.661s6.398-1.222,8.839-3.661l79.998-80C270.053,138.373,270.053,130.459,265.171,125.577z"/></svg>
            </div>
        </a>
    </div>
    <?php \yii\widgets\Pjax::begin([
        'id' => 'dSmallPjaxContainer',
        'enablePushState' => false,
        'enableReplaceState' => false,
        'linkSelector' => false,
        'options' => [
        ]
    ]) ?>
    <div class="words-table">
        <?php foreach ($words as $word): ?>
            <?php if (!empty($q) and strpos($word['original'], $q) === false and strpos($word['translation'], $q) === false) continue ?>
            <?php if (!empty($qProgress) and $qProgress != $word['trainingStatus']) continue ?>
            <?php if (!empty($qTraining))
            {
                if ($qTraining == 'Word-translation' and $word['training_word_translation'] == 1) continue;
                elseif ($qTraining == 'Translation-word' and $word['training_translation_word'] == 1) continue;
                elseif ($qTraining == 'Cards' and $word['training_cards'] == 1) continue;
                elseif ($qTraining == 'Constructor' and $word['training_constructor'] == 1) continue;
                elseif ($qTraining == 'Listening' and $word['training_audio'] == 1) continue;
            }
            ?>
            <div class="words-row">
                <div class="word-audio" onclick="say('<?= $word['original'] ?>', '<?= $languageCode ?>')">
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
                <div class="word-text">
                    <div class="word-original">
                        <?= $word['original'] ?>
                    </div>
                    <div class="word-translation">
                        <?= $word['translation'] ?>
                    </div>
                </div>
                <a class="word-vocabulary" href="<?= \yii\helpers\Url::to(['', 'v'=>$word['vocabulary_id']]) ?>">
                    <?= $word['vocabulary_name'] ?>
                </a>
                <div class="word-progress">
                    <div class="word-progress-icon">
                    <?php if ($word['trainingStatus'] == \app\models\UserWord::TRAINING_STATUS_NEW): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58 30">
                            <rect style="fill:#c8cbc8;" class="cls-1" x="54" y="10" width="4" height="10"/>
                            <path style="fill:#e7eced;" class="cls-2" d="M1.06,28.62V3.54A2.46,2.46,0,0,1,3.52,1.08H52.59a2.46,2.46,0,0,1,2.47,2.46V28.62a2.46,2.46,0,0,1-2.47,2.46H3.52A2.46,2.46,0,0,1,1.06,28.62Z" transform="translate(-1.06 -1.08)"/>
                            <path style="fill:#ff3e00;" class="cls-3" d="M14.06,1.08H3.52A2.46,2.46,0,0,0,1.06,3.54V28.62a2.46,2.46,0,0,0,2.46,2.46H14.06Z" transform="translate(-1.06 -1.08)"/></svg>
                    <?php endif; ?>
                    <?php if ($word['trainingStatus'] == \app\models\UserWord::TRAINING_STATUS_LEARNING): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58 30">
                            <rect style="fill:#c8cbc8;" class="cls-1" x="54" y="10" width="4" height="10"/>
                            <path style="fill:#e7eced;" class="cls-2" d="M1.06,28.62V3.54A2.46,2.46,0,0,1,3.52,1.08H52.59a2.46,2.46,0,0,1,2.47,2.46V28.62a2.46,2.46,0,0,1-2.47,2.46H3.52A2.46,2.46,0,0,1,1.06,28.62Z" transform="translate(-1.06 -1.08)"/>
                            <path style="fill:#ffc900;" class="cls-3" d="M40.06,1.08H3.52A2.46,2.46,0,0,0,1.06,3.54V28.62a2.46,2.46,0,0,0,2.46,2.46H40.06Z" transform="translate(-1.06 -1.08)"/></svg>
                    <?php endif; ?>
                    <?php if ($word['trainingStatus'] == \app\models\UserWord::TRAINING_STATUS_LEARNED): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58 30">
                            <path style="fill:#28c38a;" class="cls-1" d="M1.06,28.62V3.54A2.46,2.46,0,0,1,3.52,1.08H52.59a2.46,2.46,0,0,1,2.47,2.46V28.62a2.46,2.46,0,0,1-2.47,2.46H3.52A2.46,2.46,0,0,1,1.06,28.62Z" transform="translate(-1.06 -1.08)"/>
                            <rect style="fill:#c8cbc8;" class="cls-2" x="54" y="10" width="4" height="10"/></svg>
                    <?php endif; ?>
                    </div>
                </div>
                <div data-userword-id="<?= $word['userword_id'] ?>" class="word-actions-delete">
                    <svg viewBox="0 0 384 384">
                        <path d="M64,341.333C64,364.907,83.093,384,106.667,384h170.667C300.907,384,320,364.907,320,341.333v-256H64V341.333z"/>
                        <polygon points="266.667,21.333 245.333,0 138.667,0 117.333,21.333 42.667,21.333 42.667,64 341.333,64 341.333,21.333"/></svg>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php \yii\widgets\Pjax::end() ?>
    <?php \yii\widgets\Pjax::end() ?>
</div>


<script>
    $lastPronounced = "";
    function say($msg, $lang){
        var msg = new SpeechSynthesisUtterance();
        var voices = window.speechSynthesis.getVoices();
        msg.voiceURI = 'native';
        msg.volume = 1; // 0 to 1
        if ($msg == $lastPronounced)
        {
            msg.rate = 0.3; // 0.1 to 10
            $lastPronounced = "";
        }
        else
        {
            msg.rate = 0.6; // 0.1 to 10
            $lastPronounced = $msg;
        }
        msg.pitch = 1; //0 to 2
        msg.text = $msg;
        msg.lang = $lang;
        speechSynthesis.speak(msg);
    }
    $(document).ready(function() {
        $('body').on('click' , '.training-filter-popup-item', function(event){
            if (!$('.main-container').hasClass('cursor-loading'))
            {
                $('.main-container').addClass('cursor-loading');
                $.pjax({
                    type       : 'POST',
                    container  : '#dPjaxContainer',
                    data       : {
                        q: $.trim($('.words-search input').val()),
                        qProgress: $('.progress-filter-item-active').attr('data-progress'),
                        qTraining: $(this).attr('data-training'),
                        words: $('#wordsValue').val(),
                        vocabulary: $('#vocabularyValue').val(),
                        languageCode: $('#languageCodeValue').val()
                    },
                    push       : false,
                    scrollTo : false,
                });
            }
        });
        $('body').on('click' , '.progress-filter-item', function(event){
            if (!$('.main-container').hasClass('cursor-loading'))
            {
                $('.main-container').addClass('cursor-loading');
                $.pjax({
                    type       : 'POST',
                    container  : '#dPjaxContainer',
                    data       : {
                        q: $.trim($('.words-search input').val()),
                        qProgress: $(this).attr('data-progress'),
                        qTraining: $('.training-filter-popup-item-current').attr('data-training'),
                        words: $('#wordsValue').val(),
                        vocabulary: $('#vocabularyValue').val(),
                        languageCode: $('#languageCodeValue').val()
                    },
                    push       : false,
                    scrollTo : false,
                });
            }

        });
        $('body').on('keyup' , '.words-search input', function(event){
            if (!$('.main-container').hasClass('cursor-loading'))
            {
                $('.main-container').addClass('cursor-loading');
                $.pjax({
                    type       : 'POST',
                    container  : '#dSmallPjaxContainer',
                    data       : {
                        q: $.trim($('.words-search input').val()),
                        words: $('#wordsValue').val(),
                        vocabulary: $('#vocabularyValue').val(),
                        languageCode: $('#languageCodeValue').val()
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
        $('body').on('click' , '.word-actions-delete', function(e){
            if (!$('.main-container').hasClass('cursor-loading'))
            {
                $('.main-container').addClass('cursor-loading');
                $.pjax({
                    type       : 'POST',
                    container  : '#dPjaxContainer',
                    data       : {
                        removeWord: true,
                        id: $(this).attr('data-userword-id'),
                        words: $('#wordsValue').val(),
                        vocabulary: $('#vocabularyValue').val(),
                        languageCode: $('#languageCodeValue').val(),
                        q: $('.words-search input').val()
                    },
                    push       : false,
                    scrollTo : false,
                });
            }
        });
        $(document).on('ready pjax:success', function() {
            $('.cursor-loading').removeClass('cursor-loading');
        })
    });
</script>