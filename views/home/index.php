<?php

/* @var $this yii\web\View */

$this->title = Yii::t('homepage', 'Learn foreign languages online.');
\app\assets\HomeIndexAsset::register($this);
?>

<div class="main-banner">
    <div class="banner-text">
        <div class="banner-description">
            <span class="banner-description-large"><?= Yii::t('homepage', 'Learn foreign languages online.') ?></span><br>
            <span class="banner-description-small"><?= Yii::t('homepage', 'Easy, efficient, free.') ?></span>
        </div>
        <a class="banner-button banner-signup" href="<?= \yii\helpers\Url::to(['home/register']) ?>"><?= Yii::t('homepage', 'Start') ?></a>
        <a class="banner-button banner-login" href="<?= \yii\helpers\Url::to(['home/login']) ?>"><?= Yii::t('homepage', 'Sign in to account') ?></a>

    </div>
    <div class="banner-image">
        <img class="" src="../../web/source/images/static/homepage-banner.png" alt="">
    </div>
</div>
<div class="main-features">
    <div class="features-container">
        <div class="features-block features-block-small">
            <div class="features-block-small-image">
                <img class="" src="../../web/source/images/static/homepage-notebook.png" alt="">
            </div>
            <div class="features-block-small-text">
                <div class="features-block-small-title">
                    <?= Yii::t('homepage', 'The best way to learn foreign languages') ?>
                </div>
                <div class="features-block-small-description">
                    <?= Yii::t('homepage', 'Forget about boring textbooks, thick dictionaries and trips to tutors. Learn foreign languages online with ezlingua! Anywhere in the world, from any device and at any time convenient for you.') ?>
                </div>
            </div>
        </div>
        <div class="features-block features-block-small">
            <div class="features-block-small-text">
                <div class="features-block-small-title">
                    <?= Yii::t('homepage', 'From quotes to literary masterpieces') ?>
                </div>
                <div class="features-block-small-description">
                    <?= Yii::t('homepage', 'Here you will find many texts in foreign languages, by studying which you can not only learn new words, but also learn a lot for yourself. The site contains materials of varying complexity - suitable for both beginners and polyglot.') ?>
                </div>
            </div>
            <div class="features-block-small-image">
                <img class="" src="../../web/source/images/static/homepage-certificate.png" alt="">
            </div>
        </div>
        <div class="features-block features-block-small">
            <div class="features-block-small-image">
                <img class="" src="../../web/source/images/static/homepage-books.png" alt="">
            </div>
            <div class="features-block-small-text">
                <div class="features-block-small-title">
                    <?= Yii::t('homepage', 'Get ready for an interview or an international travel') ?>
                </div>
                <div class="features-block-small-description">
                    <?= Yii::t('homepage', 'No more hours of searching for translations of words and copying them into a notebook. Using thematic sets of foreign words, you can prepare for an important event - from going to a restaurant to an important interview. Choose the appropriate set of words and add the necessary words to your personal dictionary.') ?>
                </div>
            </div>
        </div>
        <div class="features-block features-block-small">
            <div class="features-block-small-text">
                <div class="features-block-small-title">
                    <?= Yii::t('homepage', 'Speed up your progress') ?>
                </div>
                <div class="features-block-small-description">
                    <?= Yii::t('homepage', 'Learn foreign words with training. A wide selection of vocabulary workouts is available on the site - from classic vocabulary cards to word constructor. Take training, track progress and improve your language skills.') ?>
                </div>
            </div>
            <div class="features-block-small-image">
                <img class="" src="../../web/source/images/static/homepage-phone.png" alt="">
            </div>
        </div>
    </div>
</div>





<script>
    window.onscroll = function () {
        if($(window).scrollTop() - ($(window).height()) >= -70)
            $('.header-buttons').addClass('header-buttons-visible');
        else
            $('.header-buttons').removeClass('header-buttons-visible');
    };
</script>