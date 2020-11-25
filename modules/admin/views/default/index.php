<?php
/* @var $this yii\web\View */
$this->title = 'Admin panel';
\app\assets\AdminDefaultAsset::register($this);
?>
<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                Admin panel
            </div>
        </div>
    </div>
    <div class="section">
        <div class="section-grid">
            <a class="route" href="<?= \yii\helpers\Url::to(['/admin/content/']) ?>">
                <div class="route-text">
                    <div class="route-title">
                        Content
                    </div>
                    <div class="route-count">
                        <?= \app\models\Content::find()->count().' rows' ?>
                    </div>
                </div>
            </a>
            <a class="route" href="<?= \yii\helpers\Url::to(['/admin/content-span/']) ?>">
                <div class="route-text">
                    <div class="route-title">
                        ContentSpan
                    </div>
                    <div class="route-count">
                        <?= \app\models\ContentSpan::find()->count().' rows' ?>
                    </div>
                </div>
            </a>
            <a class="route" href="<?= \yii\helpers\Url::to(['/admin/course/']) ?>">
                <div class="route-text">
                    <div class="route-title">
                        Course
                    </div>
                    <div class="route-count">
                        <?= \app\models\Course::find()->count().' rows' ?>
                    </div>
                </div>
            </a>
            <a class="route" href="<?= \yii\helpers\Url::to(['/admin/language/']) ?>">
                <div class="route-text">
                    <div class="route-title">
                        Language
                    </div>
                    <div class="route-count">
                        <?= \app\models\Language::find()->count().' rows' ?>
                    </div>
                </div>
            </a>
            <a class="route" href="<?= \yii\helpers\Url::to(['/admin/user/']) ?>">
                <div class="route-text">
                    <div class="route-title">
                        User
                    </div>
                    <div class="route-count">
                        <?= \app\models\User::find()->count().' rows' ?>
                    </div>
                </div>
            </a>
            <a class="route" href="<?= \yii\helpers\Url::to(['/admin/user-vocabulary/']) ?>">
                <div class="route-text">
                    <div class="route-title">
                        UserVocabulary
                    </div>
                    <div class="route-count">
                        <?= \app\models\UserVocabulary::find()->count().' rows' ?>
                    </div>
                </div>
            </a>
            <a class="route" href="<?= \yii\helpers\Url::to(['/admin/user-word/']) ?>">
                <div class="route-text">
                    <div class="route-title">
                        UserWord
                    </div>
                    <div class="route-count">
                        <?= \app\models\UserWord::find()->count().' rows' ?>
                    </div>
                </div>
            </a>
            <a class="route" href="<?= \yii\helpers\Url::to(['/admin/vocabulary/']) ?>">
                <div class="route-text">
                    <div class="route-title">
                        Vocabulary
                    </div>
                    <div class="route-count">
                        <?= \app\models\Vocabulary::find()->count().' rows' ?>
                    </div>
                </div>
            </a>
            <a class="route" href="<?= \yii\helpers\Url::to(['/admin/vocabulary-group/']) ?>">
                <div class="route-text">
                    <div class="route-title">
                        VocabularyGroup
                    </div>
                    <div class="route-count">
                        <?= \app\models\VocabularyGroup::find()->count().' rows' ?>
                    </div>
                </div>
            </a>
            <a class="route" href="<?= \yii\helpers\Url::to(['/admin/vocabulary-word/']) ?>">
                <div class="route-text">
                    <div class="route-title">
                        VocabularyWord
                    </div>
                    <div class="route-count">
                        <?= \app\models\VocabularyWord::find()->count().' rows' ?>
                    </div>
                </div>
            </a>
            <a class="route" href="<?= \yii\helpers\Url::to(['/admin/word/']) ?>">
                <div class="route-text">
                    <div class="route-title">
                        Word
                    </div>
                    <div class="route-count">
                        <?= \app\models\Word::find()->count().' rows' ?>
                    </div>
                </div>
            </a>
            <div class="hidden-route"></div>
            <div class="hidden-route"></div>
            <div class="hidden-route"></div>
            <div class="hidden-route"></div>
        </div>
    </div>
</div>


