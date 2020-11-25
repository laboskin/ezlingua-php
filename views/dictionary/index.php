<?php

/* @var $this yii\web\View */
/* @var $userwords array */
/* @var $vocabularyGroups array */
/* @var $vocabularies array */
/* @var $userVocabularyIds array */

$this->title = Yii::t('dictionaryIndex', 'Dictionary');
\app\assets\DictionaryIndexAsset::register($this);

use app\models\UserWord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii2mod\query\ArrayQuery;
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
    echo \yii\bootstrap\Html::hiddenInput('userwordsValue', json_encode($userwords), ['id'=>'userwordsValue']);
    echo \yii\bootstrap\Html::hiddenInput('vocabularyGroupsValue', json_encode($vocabularyGroups), ['id'=>'vocabularyGroupsValue']);
    echo \yii\bootstrap\Html::hiddenInput('vocabulariesValue', json_encode($vocabularies), ['id'=>'vocabulariesValue']);
    echo \yii\bootstrap\Html::hiddenInput('userVocabularyIdsValue', json_encode($userVocabularyIds), ['id'=>'userVocabularyIdsValue']);

    $userwordsQuery = new ArrayQuery();
    ?>
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                <?= Yii::t('dictionaryIndex', 'My dictionary') ?>
            </div>
        </div>
        <?php if(in_array(Yii::$app->user->getIdentity()->status, [\app\models\User::STATUS_AUTHOR, \app\models\User::STATUS_ADMIN])): ?>
            <a class="page-dictionary-new" href="<?= \yii\helpers\Url::to(['dictionary/new']) ?>">
                <div class="page-dictionary-new-icon">
                    <svg viewBox="0 0 448 448">
                        <path d="m408 184h-136c-4.417969 0-8-3.582031-8-8v-136c0-22.089844-17.910156-40-40-40s-40
                                        17.910156-40 40v136c0 4.417969-3.582031 8-8 8h-136c-22.089844
                                        0-40 17.910156-40 40s17.910156 40 40 40h136c4.417969 0 8 3.582031
                                        8 8v136c0 22.089844 17.910156 40 40 40s40-17.910156 40-40v-136c0-4.417969
                                        3.582031-8 8-8h136c22.089844 0 40-17.910156 40-40s-17.910156-40-40-40zm0 0"/></svg>
                </div>
                <div class="page-dictionary-new-text">
                    <?= Yii::t('dictionaryIndex', 'New vocabulary') ?>
                </div>
            </a>
            <a class="page-dictionary-new-group" href="<?= \yii\helpers\Url::to(['dictionary/new-group']) ?>">
                <div class="page-dictionary-new-group-icon">
                    <svg viewBox="0 0 512 512">
                        <path d="m458 80h-202v-26c0-29.776-24.225-54-54-54h-148c-29.775 0-54 24.224-54 54v50
                        306c0 29.776 24.225 54 54 54h234c13.255 0 24-10.745 24-24s-10.745-24-24-24h-234c-3.309
                        0-6-2.691-6-6v-282h410c3.309 0 6 2.691 6 6v226c0 13.255 10.745 24 24 24s24-10.745
                        24-24v-226c0-29.776-24.225-54-54-54zm-404-32h148c3.309 0 6 2.691 6 6v26h-160v-26c0-3.309
                        2.691-6 6-6z"/><path d="m408 368c-13.255 0-24 10.745-24 24v24h-24c-13.255 0-24 10.745-24
                        24s10.745 24 24 24h24v24c0 13.255 10.745 24 24 24s24-10.745 24-24v-24h24c13.255 0
                        24-10.745 24-24s-10.745-24-24-24h-24v-24c0-13.255-10.745-24-24-24z"/></svg>
                </div>
                <div class="page-dictionary-new-group-text">
                    <?= Yii::t('dictionaryIndex', 'New group') ?>
                </div>
            </a>
        <?php endif; ?>
    </div>
    <div class="section section-my-words">
        <div class="section-grid">
            <a class="my-words card" href="<?= \yii\helpers\Url::to(['dictionary/my'])?>">
                <div class="my-words-icon">
                    <svg viewBox="0 0 512 512">
                        <path d="M448,64h-48V16c0-8.832-7.168-16-16-16H96C69.536,0,48,21.536,48,48v400c0,35.296,28.704,64,64,64h336
                        c8.832,0,16-7.168,16-16V80C464,71.168,456.832,64,448,64z M368,400c0,8.832-7.168,16-16,16H160c-8.832,0-16-7.168-16-16v-32
                        c0-44.128,35.904-80,80-80h64c44.128,0,80,35.872,80,80V400z M192,192c0-35.296,28.704-64,64-64s64,28.704,64,64s-28.704,64-64,64
                        C220.704,256,192,227.296,192,192z M368,64H96c-8.832,0-16-7.168-16-16c0-8.832,7.168-16,16-16h272V64z"/></svg>
                </div>
                <div class="my-words-text">
                    <div class="my-words-count">
                        <?= Yii::t(
                            'dictionaryIndex',
                            '{n, plural, =0{# words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                            ['n' => count($userwords)])
                        ?>
                    </div>
                    <div class="my-words-link">
                        <?= Yii::t('dictionaryIndex', 'Show') ?>
                    </div>
                </div>
            </a>
            <div class="my-progress card">
                <div class="my-progress-words">
                    <div class="my-progress-words-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 58">
                            <rect style="fill:#c8cbc8;" class="cls-1" x="10" width="10" height="4"/>
                            <path style="fill:#e7eced;" class="cls-2" d="M28.25,59H3.18A2.46,2.46,0,0,1,.72,56.51V7.43A2.46,2.46,0,0,1,3.18,5H28.25a2.47,2.47,0,0,1,2.47,2.46V56.51A2.47,2.47,0,0,1,28.25,59Z" transform="translate(-0.72 -0.97)"/>
                            <path style="fill:#ff3e00;" class="cls-3" d="M.72,46V56.51A2.46,2.46,0,0,0,3.18,59H28.25a2.47,2.47,0,0,0,2.47-2.46V46Z" transform="translate(-0.72 -0.97)"/></svg>
                    </div>
                    <div class="my-progress-words-icon my-progress-words-icon-mobile">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58 30">
                            <rect style="fill:#c8cbc8;" class="cls-1" x="54" y="10" width="4" height="10"/>
                            <path style="fill:#e7eced;" class="cls-2" d="M1.06,28.62V3.54A2.46,2.46,0,0,1,3.52,1.08H52.59a2.46,2.46,0,0,1,2.47,2.46V28.62a2.46,2.46,0,0,1-2.47,2.46H3.52A2.46,2.46,0,0,1,1.06,28.62Z" transform="translate(-1.06 -1.08)"/>
                            <path style="fill:#ff3e00;" class="cls-3" d="M14.06,1.08H3.52A2.46,2.46,0,0,0,1.06,3.54V28.62a2.46,2.46,0,0,0,2.46,2.46H14.06Z" transform="translate(-1.06 -1.08)"/></svg>
                    </div>
                    <div class="my-progress-words-text">
                        <div class="my-progress-words-title">
                            <?= Yii::t('dictionaryIndex', 'New') ?>
                        </div>
                        <div class="my-progress-words-count">
                            <?= Yii::t(
                                'dictionaryIndex',
                                '{n, plural, =0{# words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                                ['n' => $userwordsQuery->from($userwords)->where(['trainingStatus' => UserWord::TRAINING_STATUS_NEW])->count()])
                            ?>
                        </div>
                    </div>
                </div>
                <div class="my-progress-words">
                    <div class="my-progress-words-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 58">
                            <rect style="fill:#c8cbc8;" class="cls-1" x="10" width="10" height="4"/>
                            <path style="fill:#e7eced;" class="cls-2" d="M28.25,59H3.18A2.46,2.46,0,0,1,.72,56.51V7.43A2.46,2.46,0,0,1,3.18,5H28.25a2.47,2.47,0,0,1,2.47,2.46V56.51A2.47,2.47,0,0,1,28.25,59Z" transform="translate(-0.72 -0.97)"/>
                            <path style="fill:#ffc900;" class="cls-3" d="M.72,20V56.51A2.46,2.46,0,0,0,3.18,59H28.25a2.47,2.47,0,0,0,2.47-2.46V20Z" transform="translate(-0.72 -0.97)"/></svg>
                    </div>
                    <div class="my-progress-words-icon my-progress-words-icon-mobile">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58 30">
                            <rect style="fill:#c8cbc8;" class="cls-1" x="54" y="10" width="4" height="10"/>
                            <path style="fill:#e7eced;" class="cls-2" d="M1.06,28.62V3.54A2.46,2.46,0,0,1,3.52,1.08H52.59a2.46,2.46,0,0,1,2.47,2.46V28.62a2.46,2.46,0,0,1-2.47,2.46H3.52A2.46,2.46,0,0,1,1.06,28.62Z" transform="translate(-1.06 -1.08)"/>
                            <path style="fill:#ffc900;" class="cls-3" d="M40.06,1.08H3.52A2.46,2.46,0,0,0,1.06,3.54V28.62a2.46,2.46,0,0,0,2.46,2.46H40.06Z" transform="translate(-1.06 -1.08)"/></svg>
                    </div>
                    <div class="my-progress-words-text">
                        <div class="my-progress-words-title">
                            <?= Yii::t('dictionaryIndex', 'Learning') ?>
                        </div>
                        <div class="my-progress-words-count">
                            <?= Yii::t(
                                'dictionaryIndex',
                                '{n, plural, =0{# words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                                ['n' => $userwordsQuery->from($userwords)->where(['trainingStatus' => UserWord::TRAINING_STATUS_LEARNING])->count()])
                            ?>
                        </div>
                    </div>
                </div>
                <div class="my-progress-words">
                    <div class="my-progress-words-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 58">
                            <path style="fill:#28c38a;" class="cls-1" d="M28.25,59H3.18A2.46,2.46,0,0,1,.72,56.51V7.43A2.46,2.46,0,0,1,3.18,5H28.25a2.47,2.47,0,0,1,2.47,2.46V56.51A2.47,2.47,0,0,1,28.25,59Z" transform="translate(-0.72 -0.97)"/>
                            <rect style="fill:#c8cbc8;" class="cls-2" x="10" width="10" height="4"/></svg>
                    </div>
                    <div class="my-progress-words-icon my-progress-words-icon-mobile">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 58 30">
                            <path style="fill:#28c38a;" class="cls-1" d="M1.06,28.62V3.54A2.46,2.46,0,0,1,3.52,1.08H52.59a2.46,2.46,0,0,1,2.47,2.46V28.62a2.46,2.46,0,0,1-2.47,2.46H3.52A2.46,2.46,0,0,1,1.06,28.62Z" transform="translate(-1.06 -1.08)"/>
                            <rect style="fill:#c8cbc8;" class="cls-2" x="54" y="10" width="4" height="10"/></svg>
                    </div>
                    <div class="my-progress-words-text">
                        <div class="my-progress-words-title">
                            <?= Yii::t('dictionaryIndex', 'Learned') ?>
                        </div>
                        <div class="my-progress-words-count">
                            <?= Yii::t(
                                'dictionaryIndex',
                                '{n, plural, =0{# words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                                ['n' => $userwordsQuery->from($userwords)->where(['trainingStatus' => UserWord::TRAINING_STATUS_LEARNED])->count()])
                            ?>
                        </div>
                    </div>
                </div>
                <a class="my-progress-training" href="<?= \yii\helpers\Url::to(['training/']) ?>">
                    <div class="my-progress-training-text">
                        <?= Yii::t('dictionaryIndex', 'Training') ?>
                    </div>
                    <div class="my-progress-training-icon">
                        <svg viewBox="0 0 268.832 268.832">
                        <path d="M265.171,125.577l-80-80c-4.881-4.881-12.797-4.881-17.678,0c-4.882,4.882-4.882,12.796,0,17.678l58.661,58.661H12.5
                        c-6.903,0-12.5,5.597-12.5,12.5c0,6.902,5.597,12.5,12.5,12.5h213.654l-58.659,58.661c-4.882,4.882-4.882,12.796,0,17.678
                        c2.44,2.439,5.64,3.661,8.839,3.661s6.398-1.222,8.839-3.661l79.998-80C270.053,138.373,270.053,130.459,265.171,125.577z"/></svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="section section-my-vocabularies">
        <div class="section-title">
            <div class="section-name">
                <?= Yii::t('dictionaryIndex', 'My vocabularies') ?>
            </div>
        </div>
        <div class="section-grid">
            <div class="vocabulary card">
                <a href="<?= \yii\helpers\Url::to(['dictionary/my', 'v'=>-1]) ?>" class="vocabulary-image">
                    <img src="<?= Url::home(true).'web/source/images/vocabulary/content.png' ?>" alt="">
                </a>
                <a href="<?= \yii\helpers\Url::to(['dictionary/my', 'v'=>-1]) ?>" class="vocabulary-text">
                    <div class="vocabulary-title">
                        <?= Yii::t('dictionaryIndex', 'Words from content') ?>
                    </div>
                    <div class="vocabulary-count">
                        <?= Yii::t(
                            'dictionaryIndex',
                            '{n, plural, =0{# words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                            ['n' => $userwordsQuery->from($userwords)->where(['vocabulary_id' => -1])->count()])
                        ?>
                    </div>
                </a>
            </div>
            <?php foreach ($vocabularies as $vocabulary): ?>
            <?php if(in_array($vocabulary['id'], $userVocabularyIds)): ?>
                    <div class="vocabulary card">
                        <a href="<?= \yii\helpers\Url::to(['dictionary/my', 'v'=>$vocabulary['id']]) ?>" class="vocabulary-image">
                            <img src="<?= $vocabulary['imageLink'] ?>" alt="">
                        </a>
                        <a href="<?= \yii\helpers\Url::to(['dictionary/my', 'v'=>$vocabulary['id']]) ?>" class="vocabulary-text">
                            <div class="vocabulary-title">
                                <?= $vocabulary['name'] ?>
                            </div>
                            <div class="vocabulary-count">
                                <?= Yii::t(
                                    'dictionaryIndex',
                                    '{n, plural, =0{# words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                                    ['n' => $userwordsQuery->from($userwords)->where(['vocabulary_id' => $vocabulary['id']])->count()])
                                ?>
                            </div>
                        </a>
                        <div data-vocabulary-id="<?= $vocabulary['id'] ?>" class="vocabulary-button vocabulary-remove">
                            <div class="vocabulary-button-icon">
                                <svg viewBox="0 0 448 448">
                                    <path d="m408 184h-136c-4.417969 0-8-3.582031-8-8v-136c0-22.089844-17.910156-40-40-40s-40
                                        17.910156-40 40v136c0 4.417969-3.582031 8-8 8h-136c-22.089844
                                        0-40 17.910156-40 40s17.910156 40 40 40h136c4.417969 0 8 3.582031
                                        8 8v136c0 22.089844 17.910156 40 40 40s40-17.910156 40-40v-136c0-4.417969
                                        3.582031-8 8-8h136c22.089844 0 40-17.910156 40-40s-17.910156-40-40-40zm0 0"/></svg>
                            </div>
                            <div class="vocabulary-button-text">
                                <?= Yii::t('dictionaryIndex', 'Remove') ?>
                            </div>
                        </div>
                    </div>
            <?php endif; ?>
            <?php endforeach; ?>
            <div class="hidden-vocabulary"></div>
            <div class="hidden-vocabulary"></div>
            <div class="hidden-vocabulary"></div>
            <div class="hidden-vocabulary"></div>
            <div class="hidden-vocabulary"></div>
            <div class="hidden-vocabulary"></div>
            <div class="hidden-vocabulary"></div>
            <div class="hidden-vocabulary"></div>
        </div>
    </div>
    <?php foreach ($vocabularyGroups as $vg): ?>
        <?php $emptyGroup = true; ?>
        <?php if(in_array(Yii::$app->user->getIdentity()->status, [\app\models\User::STATUS_AUTHOR, \app\models\User::STATUS_ADMIN])): ?>
    <?php $emptyGroup = false; ?>
    <div class="section">
        <div class="section-title">
            <div class="section-name">
                <?= $vg['name'] ?>
            </div>
            <a class="dictionary-edit-group" href="<?= \yii\helpers\Url::to(['dictionary/edit-group', 'vg'=>$vg['id']]) ?>">
                <div class="dictionary-edit-group-icon">
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
                <div class="dictionary-edit-group-text">
                    <?= Yii::t('dictionaryIndex', 'Edit') ?>
                </div>
            </a>
            <div data-vocabulary-group-id="<?= $vg['id'] ?>" class="dictionary-delete-group">
                <div class="dictionary-delete-group-icon">
                    <svg viewBox="0 0 384 384">
                        <path d="M64,341.333C64,364.907,83.093,384,106.667,384h170.667C300.907,384,320,364.907,320,341.333v-256H64V341.333z"/>
                        <polygon points="266.667,21.333 245.333,0 138.667,0 117.333,21.333 42.667,21.333 42.667,64 341.333,64 341.333,21.333"/></svg>
                </div>
                <div class="dictionary-delete-group-text">
                    <?= Yii::t('dictionaryIndex', 'Delete') ?>
                </div>
            </div>
        </div>
        <div class="section-grid">
        <?php endif; ?>
        <?php foreach ($vocabularies as $vocabulary): ?>
            <?php if($vocabulary['group_id'] == $vg['id'] and !in_array($vocabulary['id'], $userVocabularyIds)): ?>
                <?php if($emptyGroup): ?>
                    <?php $emptyGroup = false; ?>
                    <div class="section">
                <div class="section-title">
                    <div class="section-name">
                        <?= $vg['name'] ?>
                    </div>

                </div>
                    <div class="section-grid">
                <?php endif; ?>
                <div class="vocabulary card">
                    <a href="<?= \yii\helpers\Url::to(['dictionary/vocabulary', 'v'=>$vocabulary['id']]) ?>" class="vocabulary-image">
                        <img src="<?= $vocabulary['imageLink'] ?>" alt="">
                    </a>
                    <a href="<?= \yii\helpers\Url::to(['dictionary/vocabulary', 'v'=>$vocabulary['id']]) ?>" class="vocabulary-text">
                        <div class="vocabulary-title">
                            <?= $vocabulary['name'] ?>
                        </div>
                        <div class="vocabulary-count">
                            <?= Yii::t(
                                'dictionaryIndex',
                                '{n, plural, =0{# words} =1{# word} one{# words} few{# words} many{# words} other{# words}}',
                                ['n' => $vocabulary['count']])
                            ?>
                        </div>
                    </a>
                    <div data-vocabulary-id="<?= $vocabulary['id'] ?>" class="vocabulary-button vocabulary-add">
                        <div class="vocabulary-button-icon">
                            <svg viewBox="0 0 448 448">
                                <path d="m408 184h-136c-4.417969 0-8-3.582031-8-8v-136c0-22.089844-17.910156-40-40-40s-40
                                        17.910156-40 40v136c0 4.417969-3.582031 8-8 8h-136c-22.089844
                                        0-40 17.910156-40 40s17.910156 40 40 40h136c4.417969 0 8 3.582031
                                        8 8v136c0 22.089844 17.910156 40 40 40s40-17.910156 40-40v-136c0-4.417969
                                        3.582031-8 8-8h136c22.089844 0 40-17.910156 40-40s-17.910156-40-40-40zm0 0"/></svg>
                        </div>
                        <div class="vocabulary-button-text">
                            <?= Yii::t('dictionaryIndex', 'Learn') ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if(!$emptyGroup): ?>
            <div class="hidden-vocabulary"></div>
            <div class="hidden-vocabulary"></div>
            <div class="hidden-vocabulary"></div>
            <div class="hidden-vocabulary"></div>
            <div class="hidden-vocabulary"></div>
            <div class="hidden-vocabulary"></div>
            <div class="hidden-vocabulary"></div>
            <div class="hidden-vocabulary"></div>
            </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php \yii\widgets\Pjax::end() ?>
</div>


<script>
    $(document).ready(function() {
        $('body').on('click' , '.dictionary-delete-group', function(e){
            $.ajax({
                url: '<?= \yii\helpers\Url::to(['dictionary/ajax-delete-vocabulary-group']) ?>',
                datatype: 'json',
                data: {
                    id: $(this).attr('data-vocabulary-group-id')
                },
                success: function(){
                    location.href='<?= \yii\helpers\Url::to(['dictionary/']) ?>';
                },
            });
        });
        $('body').on('click' , '.vocabulary-add', function(e){
            if (!$('.main-container').hasClass('cursor-loading'))
            {
                $('.main-container').addClass('cursor-loading');
                $.pjax({
                    type       : 'POST',
                    container  : '#dPjaxContainer',
                    data       : {
                        addVocabulary: true,
                        vocabularyId: $(this).attr('data-vocabulary-id'),
                        userwords: $('#userwordsValue').val(),
                        vocabularyGroups: $('#vocabularyGroupsValue').val(),
                        vocabularies: $('#vocabulariesValue').val(),
                        userVocabularyIds: $('#userVocabularyIdsValue').val()
                    },
                    push       : false,
                    scrollTo : false,
                });
                $.ajax({
                    url: '<?= \yii\helpers\Url::to(['dictionary/ajax-add-vocabulary']) ?>',
                    datatype: 'json',
                    data: {
                        id: $(this).attr('data-vocabulary-id')
                    },
                });
            }

        });
        $('body').on('click' , '.vocabulary-remove', function(e){
            if (!$('.main-container').hasClass('cursor-loading'))
            {
                $('.main-container').addClass('cursor-loading');
                $.pjax({
                    type       : 'POST',
                    container  : '#dPjaxContainer',
                    data       : {
                        removeVocabulary: true,
                        vocabularyId: $(this).attr('data-vocabulary-id'),
                        userwords: $('#userwordsValue').val(),
                        vocabularyGroups: $('#vocabularyGroupsValue').val(),
                        vocabularies: $('#vocabulariesValue').val(),
                        userVocabularyIds: $('#userVocabularyIdsValue').val()
                    },
                    push       : false,
                    scrollTo : false,
                });
                $.ajax({
                    url: '<?= \yii\helpers\Url::to(['dictionary/ajax-remove-vocabulary']) ?>',
                    datatype: 'json',
                    data: {
                        id: $(this).attr('data-vocabulary-id')
                    },
                });
            }
        });
        $(document).on('ready pjax:success', function() {
            $('.cursor-loading').removeClass('cursor-loading');
        })

    });
</script>
