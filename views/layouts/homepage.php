<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

\app\assets\HomepageLayoutAsset::register($this)?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="shortcut icon" href="/web/favicon.ico" type="image/x-icon" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,400;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrapper">
    <header>
        <div class="header-container">
            <a class="header-logo" href="<?= \yii\helpers\Url::home() ?>">
                <img class="" src="../../web/source/images/static/homepage-logo.png" alt="">
            </a>
            <div class="header-language">
                <div class="header-language-button">
                    <div class="header-language-button-text">
                        <?= Yii::t('homepage', 'Website language').': ' ?>
                        <?= \app\models\Language::findOne(['yii_code'=>Yii::$app->language])->name ?>
                    </div>
                    <div class="header-language-button-icon">
                        <svg viewBox="0 0 491.996 491.996">
                            <path d="M484.132,124.986l-16.116-16.228c-5.072-5.068-11.82-7.86-19.032-7.86c-7.208,0-13.964,2.792-19.036,7.86l-183.84,183.848
			L62.056,108.554c-5.064-5.068-11.82-7.856-19.028-7.856s-13.968,2.788-19.036,7.856l-16.12,16.128
			c-10.496,10.488-10.496,27.572,0,38.06l219.136,219.924c5.064,5.064,11.812,8.632,19.084,8.632h0.084
			c7.212,0,13.96-3.572,19.024-8.632l218.932-219.328c5.072-5.064,7.856-12.016,7.864-19.224
			C491.996,136.902,489.204,130.046,484.132,124.986z"/></svg>
                    </div>
                    <div class="header-language-popup">
                        <?php
                        $languages = \app\models\Language::find()
                            ->where(['in', 'id',  \yii\helpers\ArrayHelper::getColumn(\app\models\Course::find()->select(['original_language_id'])->all(), 'original_language_id')])
                            ->all();
                        ?>
                        <div class="header-language-popup-container">
                            <?php foreach ($languages as $language): ?>
                            <div data-language-id="<?= $language->id ?>" class="language-popup-item">
                                <div class="language-popup-item-icon">
                                    <img class="" src="../../web/source/images/flags/<?= $language->translation_code?>.png" alt="">
                                </div>
                                <span class="language-popup-item-text">
                                    <?= $language->name ?>
                                    </span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="header-language-popup-triangle">
                            <div class="header-language-popup-diamond"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-buttons">
                <a class="header-button header-signup" href="<?= \yii\helpers\Url::to(['home/register']) ?>"><?= Yii::t('homepage', 'Start') ?></a>
                <a class="header-button header-login" href="<?= \yii\helpers\Url::to(['home/login']) ?>"><?= Yii::t('homepage', 'Sign in') ?></a>

            </div>
        </div>
    </header>

    <main>
        <?= $content ?>
    </main>
    <footer>
    </footer>
</div>
<?php $this->endBody() ?>

</body>

</html>
<?php $this->endPage() ?>

<script>
    $(document).ready(function() {
        $('body').on('click', '.language-popup-item', function (e) {
            $.ajax({
                url: '<?= \yii\helpers\Url::to(['home/ajax-change-language']) ?>',
                datatype: 'json',
                data: {
                    id: $(this).attr('data-language-id')
                },
                success: function (data) {
                    location.reload();
                }
            });

        });
    });
</script>

