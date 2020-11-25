<?php

/* @var $this yii\web\View */
/* @var $words array  */
/* @var $vocabulary array  */
/* @var $languageCode string  */


$this->title = Yii::t('dictionaryVocabulary', 'Dictionary');
\app\assets\DictionaryVocabularyAsset::register($this);
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
            <a href="<?= Yii::$app->request->referrer?Yii::$app->request->referrer:Yii::$app->homeUrl ?>" class="page-back-icon">
                <svg viewBox="0 0 447.243 447.243">
                    <path d="M420.361,192.229c-1.83-0.297-3.682-0.434-5.535-0.41H99.305l6.88-3.2c6.725-3.183,12.843-7.515,18.08-12.8l88.48-88.48
                    c11.653-11.124,13.611-29.019,4.64-42.4c-10.441-14.259-30.464-17.355-44.724-6.914c-1.152,0.844-2.247,1.764-3.276,2.754
                    l-160,160C-3.119,213.269-3.13,233.53,9.36,246.034c0.008,0.008,0.017,0.017,0.025,0.025l160,160
                    c12.514,12.479,32.775,12.451,45.255-0.063c0.982-0.985,1.899-2.033,2.745-3.137c8.971-13.381,7.013-31.276-4.64-42.4
                    l-88.32-88.64c-4.695-4.7-10.093-8.641-16-11.68l-9.6-4.32h314.24c16.347,0.607,30.689-10.812,33.76-26.88
                    C449.654,211.494,437.806,195.059,420.361,192.229z"/></svg>

            </a>
        </div>
        <div class="page-image">
            <img src="<?= $vocabulary['imageLink'] ?>" alt="">
        </div>
        <div class="page-name">
            <div class="page-name-text">
                <?= mb_strtoupper(Yii::t('dictionaryVocabulary', 'Vocabulary').': '.$vocabulary['name']) ?>
                -
                <?= Yii::t(
                    'dictionaryVocabulary',
                    '{n, plural, =0{# words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                    ['n' => count($words)])
                ?>
            </div>
        </div>
        <?php if(!$vocabulary['isUserVocabulary']): ?>
            <div data-vocabulary-id="<?= $vocabulary['id'] ?>" class="page-vocabulary-add">
                <div class="page-vocabulary-add-icon">
                    <svg viewBox="0 0 448 448">
                        <path d="m408 184h-136c-4.417969 0-8-3.582031-8-8v-136c0-22.089844-17.910156-40-40-40s-40
                                        17.910156-40 40v136c0 4.417969-3.582031 8-8 8h-136c-22.089844
                                        0-40 17.910156-40 40s17.910156 40 40 40h136c4.417969 0 8 3.582031
                                        8 8v136c0 22.089844 17.910156 40 40 40s40-17.910156 40-40v-136c0-4.417969
                                        3.582031-8 8-8h136c22.089844 0 40-17.910156 40-40s-17.910156-40-40-40zm0 0"/></svg>
                </div>
                <div class="page-vocabulary-add-text">
                    <?= Yii::t('dictionaryVocabulary', 'Learn vocabulary') ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if(in_array(Yii::$app->user->getIdentity()->status, [\app\models\User::STATUS_AUTHOR, \app\models\User::STATUS_ADMIN])): ?>
            <a class="dictionary-edit" href="<?= \yii\helpers\Url::to(['dictionary/edit', 'v'=>$vocabulary['id']]) ?>">
                <div class="dictionary-edit-icon">
                    <svg viewBox="0 0 492.49284 492">
                        <path d="m304.140625 82.472656-270.976563 270.996094c-1.363281 1.367188-2.347656
                                3.09375-2.816406 4.949219l-30.035156 120.554687c-.898438 3.628906.167969 7.488282
                                2.816406 10.136719 2.003906 2.003906 4.734375 3.113281 7.527344 3.113281.855469
                                0 1.730469-.105468 2.582031-.320312l120.554688-30.039063c1.878906-.46875
                                3.585937-1.449219 4.949219-2.8125l271-270.976562zm0 0"/>
                        <path d="m476.875 45.523438-30.164062-30.164063c-20.160157-20.160156-55.296876-20.140625-75.433594
                                0l-36.949219 36.949219 105.597656 105.597656 36.949219-36.949219c10.070312-10.066406
                                15.617188-23.464843 15.617188-37.714843s-5.546876-27.648438-15.617188-37.71875zm0 0"/></svg>
                </div>
                <div class="dictionary-edit-text">
                    <?= Yii::t('dictionaryVocabulary', 'Edit') ?>
                </div>
            </a>
            <div data-vocabulary-id="<?= $vocabulary['id'] ?>" class="dictionary-delete">
                <div class="dictionary-delete-icon">
                    <svg viewBox="0 0 384 384">
                        <path d="M64,341.333C64,364.907,83.093,384,106.667,384h170.667C300.907,384,320,364.907,320,341.333v-256H64V341.333z"/>
                        <polygon points="266.667,21.333 245.333,0 138.667,0 117.333,21.333 42.667,21.333 42.667,64 341.333,64 341.333,21.333"/></svg>
                </div>
                <div class="dictionary-delete-text">
                    <?= Yii::t('dictionaryVocabulary', 'Delete') ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if($vocabulary['isUserVocabulary']): ?>
            <a href="<?= \yii\helpers\Url::to(['dictionary/my', 'v'=>$vocabulary['id']]) ?>" data-vocabulary-id="<?= $vocabulary['id'] ?>" class="page-vocabulary-my">
                <div class="page-vocabulary-my-icon"    >
                    <svg viewBox="0 0 417.065 417.065">
                        <path d="M401.56,47.087c-17.452-14.176-42.561-12.128-56.095,4.536L167.042,271.598L73.913,150.58
                        c-13.892-18.037-39.781-21.411-57.819-7.535c-18.054,13.884-21.427,39.781-7.535,57.843l125.001,162.433
                        c13.892,18.037,39.789,21.419,57.835,7.535c5.145-3.959,8.95-8.958,11.648-14.42l205.645-253.514
                        C422.215,86.234,419.02,61.247,401.56,47.087z"/></svg>
                </div>
                <div class="page-vocabulary-my-text">
                    <?= Yii::t('dictionaryVocabulary', 'My vocabulary') ?>
                </div>
            </a>

        <?php endif; ?>
    </div>
    <div class="words-table">
        <?php foreach ($words as $word): ?>
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
                <?php if(!$word['isUserWord']): ?>
                    <div data-word-id="<?= $word['id'] ?>" class="word-actions-add">
                        <svg viewBox="0 0 448 448">
                            <path d="m408 184h-136c-4.417969 0-8-3.582031-8-8v-136c0-22.089844-17.910156-40-40-40s-40
                                        17.910156-40 40v136c0 4.417969-3.582031 8-8 8h-136c-22.089844
                                        0-40 17.910156-40 40s17.910156 40 40 40h136c4.417969 0 8 3.582031
                                        8 8v136c0 22.089844 17.910156 40 40 40s40-17.910156 40-40v-136c0-4.417969
                                        3.582031-8 8-8h136c22.089844 0 40-17.910156 40-40s-17.910156-40-40-40zm0 0"/></svg>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
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
        $('body').on('click' , '.dictionary-delete', function(e){
            $.ajax({
                url: '<?= \yii\helpers\Url::to(['dictionary/ajax-delete-vocabulary']) ?>',
                datatype: 'json',
                data: {
                    id: $(this).attr('data-vocabulary-id')
                },
                success: function(){
                    location.href='<?= \yii\helpers\Url::to(['dictionary/']) ?>';
                },
            });
        });
        $('body').on('click touchstart' , '.cursor-loading', function(event){
            event.stopPropagation();
            event.preventDefault();
        });
        $('body').on('click' , '.page-vocabulary-add', function(e){
            if (!$('.main-container').hasClass('cursor-loading'))
            {
                $('.main-container').addClass('cursor-loading');
                $.ajax({
                    url: '<?= \yii\helpers\Url::to(['dictionary/ajax-add-vocabulary']) ?>',
                    datatype: 'json',
                    data: {
                        id: $(this).attr('data-vocabulary-id')
                    },
                    success: function(){
                        location.href='<?= \yii\helpers\Url::to(['dictionary/my', 'v'=>$vocabulary['id']]) ?>';
                    },
                });
            }

        });
        $('body').on('click' , '.word-actions-add', function(e){
            if (!$('.main-container').hasClass('cursor-loading'))
            {
                $('.main-container').addClass('cursor-loading');
                $.pjax({
                    type       : 'POST',
                    container  : '#dPjaxContainer',
                    data       : {
                        addWord: true,
                        id: $(this).attr('data-word-id'),
                        words: $('#wordsValue').val(),
                        vocabulary: $('#vocabularyValue').val(),
                        languageCode: $('#languageCodeValue').val()
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