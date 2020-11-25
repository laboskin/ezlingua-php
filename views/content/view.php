<?php

/* @var $this yii\web\View */
/* @var $content array */
/* @var $contentSpans array */
/* @var $contentSpansBySentences array */
/* @var $selectedSpanOriginals array */
/* @var $selectedSpanTranslations array */


$this->title = Yii::t('contentView', 'Content');
\app\assets\ContentViewAsset::register($this);
?>

<div class="main-container">
    <?php \yii\widgets\Pjax::begin([
        'id' => 'cPjaxContainer',
        'enablePushState' => false,
        'enableReplaceState' => false,
        'linkSelector' => false,
        'options' => [
            'async' => false,
        ]
    ]) ?>
    <?php
    echo \yii\bootstrap\Html::hiddenInput('contentValue', json_encode($content), ['id'=>'contentValue']);
    echo \yii\bootstrap\Html::hiddenInput('contentSpansValue', json_encode($contentSpans), ['id'=>'contentSpansValue']);
    echo \yii\bootstrap\Html::hiddenInput('contentSpansBySentencesValue', json_encode($contentSpansBySentences), ['id'=>'contentSpansBySentencesValue']);
    echo \yii\bootstrap\Html::hiddenInput('selectedSpanOriginalsValue', json_encode($selectedSpanOriginals), ['id'=>'selectedSpanOriginalsValue']);
    echo \yii\bootstrap\Html::hiddenInput('selectedSpanTranslationsValue', json_encode($selectedSpanTranslations), ['id'=>'selectedSpanTranslationsValue']);


    ?>

    <div class="content">
        <div class="content-text">
            <div class="page-title">
                <div class="page-name">
                    <div class="page-name-text"><?= $content['name'] ?></div>
                </div>
                <?php if(in_array(Yii::$app->user->getIdentity()->status, [\app\models\User::STATUS_AUTHOR, \app\models\User::STATUS_ADMIN])): ?>
                    <a class="page-content-edit" href="<?= \yii\helpers\Url::to(['content/edit', 'c'=>$content['id']]) ?>">
                        <div class="page-content-edit-icon">
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
                        <div class="page-content-edit-text">
                            <?= Yii::t('contentView', 'Edit') ?>
                        </div>
                    </a>
                    <div data-content-id="<?= $content['id'] ?>" class="page-content-delete">
                        <div class="page-content-delete-icon">
                            <svg viewBox="0 0 384 384">
                                <path d="M64,341.333C64,364.907,83.093,384,106.667,384h170.667C300.907,384,320,364.907,320,341.333v-256H64V341.333z"/>
                                <polygon points="266.667,21.333 245.333,0 138.667,0 117.333,21.333 42.667,21.333 42.667,64 341.333,64 341.333,21.333"/></svg>
                        </div>
                        <div class="page-content-delete-text">
                            <?= Yii::t('contentView', 'Delete') ?>
                        </div>
                    </div>


                <?php endif; ?>
            </div>
            <div class="content-text-text">
                <?php foreach ($contentSpansBySentences as $sentence_position=>$sentence): ?>
                    <?php if($sentence == 'empty')
                    {
                        echo '<br>';
                        continue;
                    }?>
                    <?php foreach ($sentence as $position=>$span)
                    {
                        $wordCssClass = $span['translation']?' content-span-word':'';
                        if (in_array($span['original'], $selectedSpanOriginals))
                            $wordCssClass .= ' content-span-word-added';
                        echo '<span data-sentence-position="'.$sentence_position.'" data-position="'.$position.'"class="content-text-span'.$wordCssClass.'">';
                        echo $span['original'];
                        echo '</span>';
                        if ($span['space_after']==true)
                            echo ' ';
                    }
                    ?>
                <?php endforeach; ?>
            </div>
            <div class="content-complete">
                <div class="content-complete-button">
                    <?= Yii::t('contentView', 'Complete') ?>
                </div>
            </div>

            <div class="text-popover">
                <div class="text-popover-diamond"></div>
                <div class="text-popover-translations">
                    <div class="text-popover-translation">
                        <div class="text-popover-translation-icon">
                            <div class="text-popover-translation-icon-filled">
                            </div>
                        </div>
                        <div class="text-popover-translation-text">
                        </div>
                        <div class="text-popover-translation-delete">
                            <svg viewBox="0 0 384 384">
                                <path d="M64,341.333C64,364.907,83.093,384,106.667,384h170.667C300.907,384,320,364.907,320,341.333v-256H64V341.333z"/>
                                <polygon points="266.667,21.333 245.333,0 138.667,0 117.333,21.333 42.667,21.333 42.667,64 341.333,64 341.333,21.333"/></svg>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="content-words">

                <div class="content-words-title">
                    <?= Yii::t('contentView', 'Words') ?>
                </div>
                <div class="content-words-list">
                    <?php foreach ($selectedSpanOriginals as $index=>$value): ?>
                        <div class="content-words-list-item">
                            <div class="content-words-list-item-text">
                        <span class="content-words-list-item-original">
                        <?= $selectedSpanOriginals[$index] ?>
                    </span>
                                <span class="content-words-list-item-das">
                        —
                    </span>
                                <span class="content-words-list-item-translation">
                        <?= $selectedSpanTranslations[$index] ?>
                    </span>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
        </div>
    </div>

    <?php \yii\widgets\Pjax::end() ?>
</div>

<script>
    $(document).ready(function() {
        $('body').on('click' , '.page-content-delete', function(e){
            $.ajax({
                url: '<?= \yii\helpers\Url::to(['content/ajax-delete-content']) ?>',
                datatype: 'json',
                data: {
                    id: $(this).attr('data-content-id')
                },
                success: function(){
                    location.href='<?= \yii\helpers\Url::to(['content/']) ?>';
                },
            });
        });
        $('body').on('click' , '.content-span-word', function(e){
            if (e.clientX < 120)
            {
                $('.text-popover').addClass('left-border');
                $('.text-popover').removeClass('right-border');
            }
            else
            {
                $('.text-popover').removeClass('left-border');
                if ($(window).width() - e.clientX < 120)
                    $('.text-popover').addClass('right-border');
                else
                    $('.text-popover').removeClass('right-border');

            }

            $('.content-span-word-selected').removeClass('content-span-word-selected');
            $(this).addClass('content-span-word-selected');
            var dataSentencePosition = $(this).attr('data-sentence-position');
            var dataPosition = $(this).attr('data-position');
            var spanTranslations = [];
            for (var i = 0; i < JSON.parse($('#selectedSpanOriginalsValue').val()).length; i++)
            {
                if ($(this).text().toString() == JSON.parse($('#selectedSpanOriginalsValue').val())[i])
                    spanTranslations.push(JSON.parse($('#selectedSpanTranslationsValue').val())[i]);
            }
            $('.text-popover').hide();
            $('.text-popover').css('opacity', 0);
            var original_text = $(this).text();
            var words = $(this).text().toString().split(' ');
            if (words.length > 1)
            {
                $(this).addClass('splitted');
                $(this).text(words[0]);
                for (var i = words.length-1; i > 0; i--)
                {
                    $(this).clone(true).text(words[i]).insertAfter($(this));
                    $(this).clone(true).text(' ').insertAfter($(this));
                }
                var x = e.clientX;
                var y = e.clientY;
                var span_index = 0;
                var left = $('.splitted').each(function(index, value){
                    var elemleft = $(this).offset()['left'];
                    var elemtop = $(this).offset()['top'];
                    var elemright = elemleft + $(this).width();
                    var elembottom = elemtop + $(this).height();
                    if (x > elemleft && x<elemright && y>elemtop && y<elembottom)
                        span_index = index;
                });
                $('.text-popover').css('top', $('.splitted:eq('+span_index+')').position()['top'] + $('.splitted:eq('+span_index+')').height());
                $('.text-popover').css('left', ($('.splitted:eq('+span_index+')').position()['left'] + $('.splitted:eq('+span_index+')').width()*0.5));
                $('.splitted:first').text(original_text);
                $('.splitted:first').removeClass('splitted');
                $('.splitted').remove();
            }
            else
            {
                $('.text-popover').css('top', $(this).position()['top'] + $(this).height());
                $('.text-popover').css('left', ($(this).position()['left'] + $(this).width()*0.5));
            }
            $('.text-popover-translation:not(:first)').remove();
            $('.text-popover-translation').removeClass('text-popover-translation-added');
            $('.text-popover-translation').attr('data-sentence-position', dataSentencePosition);
            $('.text-popover-translation').attr('data-position', dataPosition);
            $('.text-popover').show();
            $.ajax({
                url: '<?= \yii\helpers\Url::to(['content/ajax-get-translations']) ?>',
                datatype: 'json',
                data: {
                    from: '<?= $content['goal_language'] ?>',
                    to: '<?= $content['original_language'] ?>',
                    text: original_text.toString(),
                },
                success: function(data){
                    data = JSON.parse(data);
                    if (data[0]['translations'].length > 0)
                    {
                        var translations = [];
                        var confidences = [];
                        for (var i = 0; i < data[0]['translations'].length; i++)
                        {
                            if (i>3) break;
                            translations.push(data[0]['translations'][i]['displayTarget']);
                            confidences.push(data[0]['translations'][i]['confidence']);
                        }
                        $('.text-popover-translation-text').text(translations[0]);
                        $('.text-popover-translation-icon-filled').width((confidences[0]*100).toString()+'%');
                        if (jQuery.inArray(translations[0], spanTranslations) != -1)
                            $('.text-popover-translation').addClass('text-popover-translation-added');
                        for (var i = 1; i < translations.length; i++)
                        {
                            $('.text-popover-translation:last').clone().insertAfter($('.text-popover-translation:last'));
                            $('.text-popover-translation:last').children('.text-popover-translation-icon-filled').width((confidences[i]*100).toString()+'%');
                            $('.text-popover-translation:last').children('.text-popover-translation-text').text(translations[i]);
                            if (jQuery.inArray(translations[i], spanTranslations) != -1)
                                $('.text-popover-translation:last').addClass('text-popover-translation-added');
                            else
                                $('.text-popover-translation:last').removeClass('text-popover-translation-added');
                        }
                        $('.text-popover').css('opacity', 1);
                    }
                    else
                    {
                        $.ajax({
                            url: '<?= \yii\helpers\Url::to(['content/ajax-translate']) ?>',
                            datatype: 'json',
                            data: {
                                from: '<?= $content['goal_language'] ?>',
                                to: '<?= $content['original_language'] ?>',
                                text: original_text.toString(),
                            },
                            success: function(data) {
                                data = JSON.parse(data);
                                $('.text-popover-translation-text').text(data[0]['translations'][0]['text']);
                                $('.text-popover').css('opacity', 1);
                                if (jQuery.inArray(data[0]['translations'][0]['text'], spanTranslations) != -1)
                                    $('.text-popover-translation').addClass('text-popover-translation-added');
                                else
                                    $('.text-popover-translation').removeClass('text-popover-translation-added');
                            }
                    });

                    }
                }
            });
            e.stopPropagation();
        });

        $('body').on('click' , '.text-popover-translation:not(.text-popover-translation-added)', function(e){
            $.pjax({
                type       : 'POST',
                container  : '#cPjaxContainer',
                data       : {
                    addWord: true,
                    original: $('.content-span-word-selected').text().toString(),
                    translation: $(this).children('.text-popover-translation-text').text().toString(),
                    content: $('#contentValue').val(),
                    contentSpans: $('#contentSpansValue').val(),
                    contentSpansBySentences: $('#contentSpansBySentencesValue').val(),
                    selectedSpanOriginals: $('#selectedSpanOriginalsValue').val(),
                    selectedSpanTranslations: $('#selectedSpanTranslationsValue').val(),
                },
                push       : false,
                scrollTo : false,
            });
        });

        $('body').on('click' , '.text-popover-translation-added .text-popover-translation-delete', function(e) {
            $.pjax({
                type       : 'POST',
                container  : '#cPjaxContainer',
                data       : {
                    deleteWord: true,
                    original: $('.content-span-word-selected').text().toString(),
                    translation: $(this).siblings('.text-popover-translation-text').text().toString(),
                    content: $('#contentValue').val(),
                    contentSpans: $('#contentSpansValue').val(),
                    contentSpansBySentences: $('#contentSpansBySentencesValue').val(),
                    selectedSpanOriginals: $('#selectedSpanOriginalsValue').val(),
                    selectedSpanTranslations: $('#selectedSpanTranslationsValue').val(),
                },
                push       : false,
                scrollTo : false,
            });
        });

        $('body').on('click' , '.content-complete-button', function(e){
            $.pjax({
                type       : 'POST',
                container  : '#cPjaxContainer',
                data       : {
                    complete: true,
                    content: $('#contentValue').val(),
                    contentSpans: $('#contentSpansValue').val(),
                    contentSpansBySentences: $('#contentSpansBySentencesValue').val(),
                    selectedSpanOriginals: $('#selectedSpanOriginalsValue').val(),
                    selectedSpanTranslations: $('#selectedSpanTranslationsValue').val(),
                },
                push       : false,
                scrollTo : false,
            });
        });

        $(document).click(function(e) {
            if ( $(e.target).closest('.popover').length)
                return;
            $('.text-popover').css('opacity', 0);
            $('.text-popover').css('left', '-5000px');
            $('.text-popover').css('top', '-5000px');
            $('.content-span-word-selected').removeClass('content-span-word-selected');
            e.stopPropagation();
        });
    });
</script>


