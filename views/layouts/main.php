<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

\app\assets\MainLayoutAsset::register($this)?>
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
                <img class="" src="../../web/source/images/static/main-logo.png" alt="">
            </a>
            <div class="header-nav">
                <a class="header-nav-button" href="<?= \yii\helpers\Url::to(['/content/']) ?>"><?= Yii::t('mainLayout', 'Content') ?></a>
                <a class="header-nav-button" href="<?= \yii\helpers\Url::to(['/dictionary/']) ?>"><?= Yii::t('mainLayout', 'Dictionary') ?></a>
                <a class="header-nav-button" href="<?= \yii\helpers\Url::to(['/training/']) ?>"><?= Yii::t('mainLayout', 'Training') ?></a>
            </div>
            <div class="header-user">
                <div class="header-user-language">
                    <?php
                    $user = Yii::$app->user->getIdentity();
                    $currentCourse = $user->getCourse();
                    ?>
                    <img class="" src="../../web/source/images/flags/<?= $currentCourse->goalLanguage->translation_code?>.png" alt="">
                    <div class="language-popup">
                        <div class="language-popup-container">
                            <div class="language-popup-item language-popup-item-current">
                                <div class="language-popup-item-icon">
                                    <img class="" src="../../web/source/images/flags/<?= $currentCourse->goalLanguage->translation_code?>.png" alt="">
                                </div>
                                <span class="language-popup-item-text">
                                    <?= $currentCourse->name ?>
                                </span>
                            </div>
                            <div class="language-popup-delimeter"></div>
                            <?php foreach ($user->getOtherCourses() as $course): ?>
                                <a class="language-popup-item language-popup-item-new" href="<?= \yii\helpers\Url::to(['/user/change-course', 'course_id'=>$course->id]) ?>">
                                    <div class="language-popup-item-icon">
                                        <img class="" src="../../web/source/images/flags/<?= $course->goalLanguage->translation_code?>.png" alt="">
                                    </div>
                                    <span class="language-popup-item-text">
                                    <?= $course->name ?>
                                    </span>
                                </a>
                            <?php endforeach; ?>
                            <a class="language-popup-item language-popup-item-add" href="<?= \yii\helpers\Url::to(['/user/add-course']) ?>">
                                <div class="language-popup-item-icon">
                                    <svg viewBox="0 0 448 448">
                                        <path d="m408 184h-136c-4.417969 0-8-3.582031-8-8v-136c0-22.089844-17.910156-40-40-40s-40
                                        17.910156-40 40v136c0 4.417969-3.582031 8-8 8h-136c-22.089844
                                        0-40 17.910156-40 40s17.910156 40 40 40h136c4.417969 0 8 3.582031
                                        8 8v136c0 22.089844 17.910156 40 40 40s40-17.910156 40-40v-136c0-4.417969
                                        3.582031-8 8-8h136c22.089844 0 40-17.910156 40-40s-17.910156-40-40-40zm0 0"/></svg>
                                </div>
                                <span class="language-popup-item-text">
                                    <?= Yii::t('mainLayout', 'Add') ?>
                                </span>
                            </a>
                        </div>
                        <div class="language-popup-triangle">
                            <div class="language-popup-diamond"></div>
                        </div>
                    </div>
                </div>
                <div class="header-user-profile">
                    <img class="" src="../../web/source/images/static/avatar.jpg" alt="">
                    <div class="profile-popup">
                        <div class="profile-popup-container">
                            <?php if ($user->status == \app\models\User::STATUS_ADMIN): ?>
                                <a class="profile-popup-item" href="<?= \yii\helpers\Url::to(['/admin/']) ?>">
                                    <div class="profile-popup-item-icon">
                                        <svg viewBox="0 0 64 64">
                                            <path d="m42 17c0-5.514-4.486-10-10-10s-10 4.486-10 10 4.486 10 10 10 10-4.486 10-10zm-18 0c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8-8-3.589-8-8z"/>
                                            <path d="m49.99 36.273-8.849-1.264-5.141-.856v-2.153-1.382l2.641-1.32 1.138 1.137c.391.391 1.023.391 1.414 0l4.242-4.243c.391-.391.391-1.023
                                            0-1.414l-1.137-1.137 1.32-2.641h1.382c.553 0 1-.448 1-1v-6c0-.552-.447-1-1-1h-1.382l-1.32-2.641
                                            1.137-1.137c.391-.391.391-1.023 0-1.414l-4.242-4.243c-.391-.391-1.023-.391-1.414 0l-1.138 1.137-2.641-1.32v-1.382c0-.552-.447-1-1-1h-6c-.553
                                            0-1 .448-1 1v1.382l-2.641 1.32-1.138-1.137c-.391-.391-1.023-.391-1.414 0l-4.242 4.243c-.391.391-.391 1.023 0 1.414l1.137 1.137-1.32 2.641h-1.382c-.553
                                            0-1 .448-1 1v6c0 .552.447 1 1 1h1.382l1.32 2.641-1.137 1.137c-.391.391-.391 1.023 0 1.414l4.242 4.243c.391.391 1.023.391 1.414 0l1.138-1.137 2.641
                                            1.32v1.382 2.153l-5.142.857-8.849 1.264c-3.425.49-6.009 3.469-6.009 6.93v18.796c0 .553.447 1 1 1h46c.553 0 1-.447 1-1v-18.796c0-3.461-2.584-6.44-6.01-6.931zm-14.439
                                            13.404-.516-7.229 1.859 1.859zm-1.568 6.121-1.983 3.966-1.983-3.966.789-11.049c.366.16.769.251 1.194.251s.828-.091
                                            1.194-.251zm-6.876-11.491 1.859-1.859-.516 7.229zm2.893-11.307h4v1.586l-2 2-2-2zm1 7.414 1-1 1 1v1.586c0 .552-.448 1-1 1s-1-.448-1-1zm6.609 1.78-4.195-4.194
                                            1.929-1.929 4.294.716zm-12-15.007c-.385-.192-.849-.118-1.154.188l-.94.94-2.828-2.829.939-.94c.305-.304.38-.769.188-1.154l-1.919-3.838c-.17-.34-.516-.554-.895-.554h-1v-4h1c.379
                                            0 .725-.214.895-.553l1.919-3.838c.192-.385.117-.85-.188-1.154l-.939-.94 2.828-2.829.94.94c.306.305.771.38 1.154.188l3.838-1.919c.339-.17.553-.516.553-.895v-1h4v1c0
                                            .379.214.725.553.895l3.838 1.919c.384.191.849.117 1.154-.188l.94-.94 2.828 2.829-.939.94c-.305.304-.38.769-.188 1.154l1.919 3.838c.17.339.516.553.895.553h1v4h-1c-.379
                                            0-.725.214-.895.553l-1.919 3.838c-.192.385-.117.85.188 1.154l.939.94-2.828 2.829-.94-.94c-.305-.304-.769-.378-1.154-.188l-3.838 1.919c-.339.17-.553.516-.553.895v1h-4v-1c0-.379-.214-.725-.553-.895zm3.048
                                            8.884 1.929 1.929-4.195 4.194-2.027-5.407zm-18.657 7.133c0-2.472 1.846-4.601 4.293-4.95l8.053-1.15 2.7 7.201 2.984 11.938.005-.001c.018.071.038.141.07.206l2.277
                                            4.552h-12.382v-15h-2v15h-6zm44 17.796h-7v-15h-2v15h-11.382l2.276-4.553c.033-.065.053-.136.07-.206l.005.001
                                            2.984-11.938 2.7-7.201 8.053 1.15c2.447.35 4.293 2.479 4.293 4.95v17.797z"/></svg>
                                    </div>
                                    <span class="profile-popup-item-text">
                                    <?= Yii::t('mainLayout', 'Admin panel') ?>
                                </span>
                                </a>
                            <?php endif; ?>
                            <a class="profile-popup-item" href="<?= \yii\helpers\Url::to(['/user/settings']) ?>">
                                <div class="profile-popup-item-icon">
                                    <svg id="Layer_1" enable-background="new 0 0 512 512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m272.066 512h-32.133c-25.989 0-47.134-21.144-47.134-47.133v-10.871c-11.049-3.53-21.784-7.986-32.097-13.323l-7.704 7.704c-18.659
                                        18.682-48.548 18.134-66.665-.007l-22.711-22.71c-18.149-18.129-18.671-48.008.006-66.665l7.698-7.698c-5.337-10.313-9.792-21.046-13.323-32.097h-10.87c-25.988
                                        0-47.133-21.144-47.133-47.133v-32.134c0-25.989 21.145-47.133 47.134-47.133h10.87c3.531-11.05 7.986-21.784 13.323-32.097l-7.704-7.703c-18.666-18.646-18.151-48.528.006-66.665l22.713-22.712c18.159-18.184
                                        48.041-18.638 66.664.006l7.697 7.697c10.313-5.336 21.048-9.792 32.097-13.323v-10.87c0-25.989 21.144-47.133 47.134-47.133h32.133c25.989 0
                                        47.133 21.144 47.133 47.133v10.871c11.049 3.53 21.784 7.986 32.097 13.323l7.704-7.704c18.659-18.682 48.548-18.134 66.665.007l22.711
                                        22.71c18.149 18.129 18.671 48.008-.006 66.665l-7.698 7.698c5.337 10.313 9.792 21.046 13.323 32.097h10.87c25.989 0 47.134 21.144 47.134
                                        47.133v32.134c0 25.989-21.145 47.133-47.134 47.133h-10.87c-3.531 11.05-7.986 21.784-13.323 32.097l7.704 7.704c18.666 18.646 18.151
                                        48.528-.006 66.665l-22.713 22.712c-18.159 18.184-48.041 18.638-66.664-.006l-7.697-7.697c-10.313 5.336-21.048 9.792-32.097 13.323v10.871c0
                                        25.987-21.144 47.131-47.134 47.131zm-106.349-102.83c14.327 8.473 29.747 14.874 45.831 19.025 6.624 1.709 11.252 7.683 11.252 14.524v22.148c0
                                        9.447 7.687 17.133 17.134 17.133h32.133c9.447 0 17.134-7.686 17.134-17.133v-22.148c0-6.841 4.628-12.815 11.252-14.524 16.084-4.151
                                        31.504-10.552 45.831-19.025 5.895-3.486 13.4-2.538 18.243 2.305l15.688 15.689c6.764 6.772 17.626 6.615 24.224.007l22.727-22.726c6.582-6.574
                                        6.802-17.438.006-24.225l-15.695-15.695c-4.842-4.842-5.79-12.348-2.305-18.242 8.473-14.326 14.873-29.746 19.024-45.831 1.71-6.624 7.684-11.251
                                        14.524-11.251h22.147c9.447 0 17.134-7.686 17.134-17.133v-32.134c0-9.447-7.687-17.133-17.134-17.133h-22.147c-6.841 0-12.814-4.628-14.524-11.251-4.151-16.085-10.552-31.505-19.024-45.831-3.485-5.894-2.537-13.4
                                        2.305-18.242l15.689-15.689c6.782-6.774 6.605-17.634.006-24.225l-22.725-22.725c-6.587-6.596-17.451-6.789-24.225-.006l-15.694 15.695c-4.842 4.843-12.35 5.791-18.243 2.305-14.327-8.473-29.747-14.874-45.831-19.025-6.624-1.709-11.252-7.683-11.252-14.524v-22.15c0-9.447-7.687-17.133-17.134-17.133h-32.133c-9.447 0-17.134 7.686-17.134 17.133v22.148c0 6.841-4.628 12.815-11.252 14.524-16.084 4.151-31.504 10.552-45.831 19.025-5.896 3.485-13.401 2.537-18.243-2.305l-15.688-15.689c-6.764-6.772-17.627-6.615-24.224-.007l-22.727 22.726c-6.582 6.574-6.802 17.437-.006 24.225l15.695 15.695c4.842 4.842 5.79 12.348 2.305 18.242-8.473 14.326-14.873 29.746-19.024 45.831-1.71 6.624-7.684 11.251-14.524 11.251h-22.148c-9.447.001-17.134 7.687-17.134 17.134v32.134c0 9.447 7.687 17.133 17.134 17.133h22.147c6.841 0 12.814 4.628 14.524 11.251 4.151 16.085 10.552 31.505 19.024 45.831 3.485 5.894 2.537 13.4-2.305 18.242l-15.689 15.689c-6.782 6.774-6.605 17.634-.006 24.225l22.725 22.725c6.587 6.596 17.451 6.789 24.225.006l15.694-15.695c3.568-3.567 10.991-6.594 18.244-2.304z"/><path d="m256 367.4c-61.427 0-111.4-49.974-111.4-111.4s49.973-111.4 111.4-111.4 111.4 49.974 111.4
                                        111.4-49.973 111.4-111.4 111.4zm0-192.8c-44.885 0-81.4 36.516-81.4 81.4s36.516 81.4 81.4 81.4 81.4-36.516 81.4-81.4-36.515-81.4-81.4-81.4z"/></svg>
                                </div>
                                <span class="profile-popup-item-text">
                                    <?= Yii::t('mainLayout', 'Settings') ?>
                                </span>
                            </a>
                            <a class="profile-popup-item" href="<?= \yii\helpers\Url::to(['/user/logout']) ?>">
                                <div class="profile-popup-item-icon">
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         viewBox="0 0 512 512" xml:space="preserve">
                                    <path d="M360.507,171c8.284,0,15-6.716,15-15V45c0-24.813-20.187-45-45-45h-240c-24.813,0-45,20.187-45,45v422
                                        c0,24.813,20.187,45,45,45h240c24.813,0,45-20.187,45-45V356c0-8.284-6.715-15-15-15c-8.284,0-15,6.716-15,15v111
                                        c0,8.271-6.729,15-15,15h-240c-8.271,0-15-6.729-15-15V45c0-8.271,6.729-15,15-15h240c8.271,0,15,6.729,15,15v111
                                        C345.507,164.284,352.223,171,360.507,171z"/>
                                        <path d="M460.15,243.74l-61.421-43.301c-6.771-4.774-16.128-3.153-20.902,3.617c-4.773,6.771-3.154,16.129,3.617,20.903
                                        L404.198,241h-231.19c-8.284,0-15,6.716-15,15s6.716,15,15,15h231.19l-22.754,16.042c-6.771,4.773-8.391,14.132-3.617,20.903
                                        c4.776,6.774,14.135,8.389,20.902,3.617l61.421-43.301C468.685,262.244,468.529,249.646,460.15,243.74z"/></svg>
                                </div>
                                <span class="profile-popup-item-text">
                                    <?= Yii::t('mainLayout', 'Logout') ?>
                                </span>
                            </a>
                        </div>

                        <div class="profile-popup-triangle">
                            <div class="profile-popup-diamond"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <main>
            <?= $content ?>
    </main>
    <footer>
        <a href="<?= \yii\helpers\Url::to(['/content/']) ?>" class="footer-item <?= (Yii::$app->controller->id == 'content')?'footer-item-current':'' ?>">
            <div class="footer-item-icon">
                <svg viewBox="0 0 512 512">
                    <path d="m345.22 306.21c-4.237 0-8.107-2.785-9.47-6.79-1.324-3.891-.067-8.299 3.099-10.919 3.125-2.585
                    7.625-3.001 11.179-1.055 3.614 1.979 5.701 6.149 5.076 10.23-.739 4.829-4.977 8.534-9.884 8.534z"/>
                                        <path d="m281.623 129.086h-188.163c-5.523 0-10-4.478-10-10s4.477-10 10-10h188.163c5.522 0 10 4.478
                    10 10s-4.478 10-10 10z"/><path d="m281.623 241.349h-188.163c-5.523 0-10-4.478-10-10s4.477-10
                    10-10h188.163c5.522 0 10 4.478 10 10s-4.478 10-10 10z"/><path d="m281.623 305.362h-188.163c-5.523
                    0-10-4.478-10-10s4.477-10 10-10h188.163c5.522 0 10 4.478 10 10s-4.478 10-10 10z"/>
                                        <path d="m220.354 369.377h-126.894c-5.523 0-10-4.478-10-10 0-5.523 4.477-10 10-10h126.894c5.523
                    0 10 4.477 10 10 0 5.522-4.477 10-10 10z"/><path d="m319.023 20.012h-25.222v-10.012c0-5.523-4.478-10-10-10s-10
                    4.477-10 10v10.012h-43.447v-10.012c0-5.523-4.477-10-10-10s-10 4.477-10
                    10v10.012h-43.447v-10.012c0-5.523-4.477-10-10-10s-10 4.477-10 10v10.012h-43.447v-10.012c0-5.523-4.477-10-10-10s-10
                    4.477-10 10v10.012h-25.222c-19.957 0-36.193 16.236-36.193 36.193v419.602c0 19.957 16.236 36.193 36.193 36.193h260.784c19.958
                    0 36.194-16.236 36.194-36.193v-134.577c0-5.522-4.477-10-10-10-5.522 0-10 4.478-10 10v134.576c0 8.929-7.265 16.193-16.194
                    16.193h-260.784c-8.929 0-16.193-7.265-16.193-16.193v-419.601c0-8.929 7.264-16.193 16.193-16.193h25.222v11.977c0 5.522 4.477
                    10 10 10s10-4.478 10-10v-11.977h43.447v11.977c0 5.522 4.477 10 10 10s10-4.478 10-10v-11.977h43.447v11.977c0 5.522 4.477
                    10 10 10s10-4.478 10-10v-11.977h43.447v11.977c0 5.522 4.478 10 10 10s10-4.478 10-10v-11.977h25.222c8.93 0 16.194 7.265
                    16.194 16.193v194.612c0 5.522 4.478 10 10 10 5.523 0 10-4.478 10-10v-194.612c0-19.957-16.237-36.193-36.194-36.193z"/>
                                        <path d="m489.955 449.351-.087-395.572c-.006-18.061-14.704-32.759-32.761-32.765l-28.397-.02h-.01c-8.754 0-16.984
                    3.409-23.175 9.6-6.193 6.193-9.603 14.427-9.6 23.185l.087 395.542v.531c0 2.072.645 4.094 1.843 5.785l36.983 52.148c1.875
                    2.644 4.916 4.215 8.157 4.215s6.282-1.571 8.157-4.215l36.959-52.114c1.199-1.691 1.843-3.713 1.843-5.785v-.535zm-20.073-346.675.008
                    32.849h-53.942l-.008-32.874 26.644.012zm-53.931 52.849h53.942l.056 267.716-4.508-5.021c-1.962-2.186-4.758-3.397-7.724-3.315-2.936.083-5.689
                    1.454-7.524 3.747l-7.212 9.011-7.227-9.027c-1.836-2.293-4.588-3.663-7.524-3.746-.094-.003-.188-.004-.282-.004-2.835 0-5.542
                    1.204-7.441 3.319l-4.5 5.012zm3.716-110.79c2.413-2.412 5.621-3.741 9.029-3.741h.004l28.398.02c7.039.002 12.768 5.731 12.77
                    12.771l.009 28.892-26.597-.012-27.345-.013-.009-28.879c-.001-3.415 1.328-6.624 3.741-9.038zm23.329 439.979-24.415-34.426
                    8.93-9.947 7.664 9.574c1.898 2.37 4.771 3.75 7.807 3.75 3.037 0 5.909-1.38 7.808-3.751l7.648-9.557 8.948 9.965z"/></svg>
            </div>
        </a>
        <a href="<?= \yii\helpers\Url::to(['/dictionary/']) ?>" class="footer-item <?= (Yii::$app->controller->id == 'dictionary')?'footer-item-current':'' ?>">
            <div class="footer-item-icon">
                <svg viewBox="0 0 512 512">
                    <path d="m419.151 103.09v-73.09h11.661c8.284 0 15-6.716
                    15-15s-6.716-15-15-15h-306.02c-32.314 0-58.604 26.25-58.604 58.517v413.701c0
                    21.936 17.869 39.782 39.832 39.782h302.453c20.588 0 37.338-16.73
                    37.338-37.294v-338.658c.001-16.16-11.444-29.695-26.66-32.958zm-322.963-44.573c0-15.725
                    12.832-28.517 28.604-28.517h264.359v72.335h-264.359c-15.772 0-28.604-12.792-28.604-28.517zm319.624
                    416.189c0 4.022-3.292 7.294-7.338 7.294h-302.454c-5.421 0-9.832-4.388-9.832-9.782v-347.338c8.465
                    4.747 18.224 7.456 28.604 7.456h287.27c2.067 0 3.75 1.666 3.75 3.712z"/>
                    <path id="XMLID_213_" d="m171.618 233.532c-.809-2.521-5.335-7.87-15.438-7.87-11.433 0-14.63
                    5.349-15.437 7.87l-28.15 92.32c-.821 3.443 1.336 6.56 4.616 8.475 3.278 1.918 6.683 2.876
                    10.216 2.876 4.337 0 6.91-1.461 7.719-4.389l5.146-18.918h31.934l5.146 18.918c.807 2.928 3.379
                    4.389 7.719 4.389 3.53 0 6.936-.958 10.216-2.876 3.277-1.915 5.321-5.514 4.616-8.475zm-26.485
                    62.202 11.048-40.561 11.048 40.561z"/>
                    <path d="m278.314 277.27c8.575-3.731 12.864-11.653 12.864-23.761
                    0-17.958-10.09-26.939-30.269-26.939h-31.026c-7.634 0-10.291 4.944-10.291
                    7.265v96.255c0 1.918 2.907 7.113 10.291 7.113h33.599c9.282 0 16.672-2.597 22.172-7.794 5.499-5.195
                    8.249-13.444 8.249-24.745v-3.179c0-7.061-1.313-12.384-3.935-15.967-2.625-3.58-6.508-6.33-11.654-8.248zm-35.263-30.117h15.892c8.058
                    0 8.626 7.771 8.626 10.594 0 2.826-.944 10.442-8.626 10.442h-15.892zm27.242 55.543c0 9.284-4.037
                    13.924-12.107 13.924h-15.135v-30.269h15.135c8.071 0 12.107 4.642 12.107 13.924z"/>
                    <path d="m352.775 247.153c8.676 0 13.167 4.54 13.469 13.621.303 4.743 4.238 7.113 11.805 7.113 7.076
                    0 11.805-2.762 11.805-11.2 0-9.383-3.557-16.747-10.669-22.096-7.113-5.347-16.22-8.021-27.318-8.021-10.797
                    0-19.549 2.875-26.258 8.626-6.711 5.752-10.064 14.782-10.064 27.091v40.106c0 12.312 3.353 21.34 10.064
                    27.091 6.709 5.751 15.461 8.627 26.258 8.627 11.098 0 20.205-2.823 27.318-8.476 7.113-5.649 10.669-13.368
                    10.669-23.155 0-5.855-2.479-11.2-11.956-11.2-7.366 0-11.251 2.372-11.654 7.113-.569 5.951-3.744 15.135-13.318
                    15.135-9.183 0-13.772-5.044-13.772-15.135v-40.106c0-10.088 4.54-15.134 13.621-15.134z"/></svg>
            </div>
        </a>
        <a href="<?= \yii\helpers\Url::to(['/training/']) ?>" class="footer-item <?= (Yii::$app->controller->id == 'training')?'footer-item-current':'' ?>">
            <div class="footer-item-icon">
                <svg viewBox="0 0 512.001 512.001">
                    <path d="M317.648,194.353c-3.91-3.9-10.24-3.9-14.14,0c-3.91,3.91-3.91,10.24,0,14.139c3.9,3.91,10.23,3.91,14.14,0
			C321.548,204.592,321.548,198.263,317.648,194.353z"/>
                    <path d="M500.274,195.562l-14.14-14.139c0.521-0.762,15.859-13.252,15.859-36.564c0-13.358-5.204-25.914-14.651-35.355
			l-7.071-7.071l7.066-7.072c19.541-19.513,19.561-51.174,0.007-70.701c-19.533-19.546-51.16-19.558-70.698-0.006l-7.079,7.074
			l-7.069-7.069c-19.535-19.549-51.171-19.556-70.713-0.002l-1.209,1.209l-14.138-14.138c-15.631-15.63-40.929-15.641-56.567-0.003
			c-15.635,15.623-15.643,40.935-0.003,56.563l56.567,56.567l-191.581,191.58l-56.561-56.561
			c-15.605-15.63-40.945-15.653-56.563-0.009C-3.909,275.492-3.911,300.8,11.728,316.44l14.138,14.138l-1.206,1.206
			c-19.549,19.535-19.556,51.171-0.002,70.713l7.071,7.071l-7.066,7.072c-19.541,19.513-19.561,51.174-0.007,70.702
			c19.533,19.544,51.158,19.559,70.7,0.005l7.079-7.074l7.069,7.069c19.535,19.549,51.171,19.557,70.713,0.002l1.208-1.208
			l14.138,14.139c15.632,15.631,40.931,15.64,56.568,0.003c15.635-15.623,15.643-40.935,0.003-56.563l-56.567-56.567l191.58-191.58
			l56.561,56.561c15.605,15.63,40.945,15.653,56.563,0.009C515.91,236.509,515.912,211.201,500.274,195.562z M430.788,38.797
			c11.691-11.7,30.658-11.763,42.418,0.007c11.72,11.703,11.733,30.689-0.007,42.414l-7.068,7.074L423.709,45.87L430.788,38.797z
			 M345.93,38.797c11.72-11.728,30.697-11.735,42.424,0.002l84.849,84.849c11.728,11.72,11.735,30.697-0.002,42.424l-1.208,1.209
			L344.719,40.008L345.93,38.797z M81.212,473.204c-11.691,11.7-30.658,11.763-42.418-0.007
			c-11.72-11.703-11.733-30.689,0.007-42.414l7.068-7.074l42.422,42.422L81.212,473.204z M166.07,473.204
			c-11.72,11.728-30.697,11.735-42.424-0.002l-84.849-84.849c-11.728-11.72-11.735-30.697,0.002-42.424l1.208-1.209L167.28,471.993
			L166.07,473.204z M237.992,457.858c7.816,7.807,7.822,20.457-0.002,28.274c-7.836,7.836-20.481,7.805-28.287,0
			c-8.36-8.36-174.684-174.684-183.834-183.834c-7.753-7.753-7.886-20.407,0.006-28.293c7.779-7.792,20.443-7.835,28.27,0.006
			L237.992,457.858z M181.423,373.003l-42.425-42.425l191.58-191.58l42.425,42.426L181.423,373.003z M486.125,237.996
			c-7.779,7.792-20.443,7.835-28.27-0.006L274.008,54.144c-7.815-7.807-7.821-20.457,0.003-28.274c7.836-7.836,20.48-7.805,28.287,0
			c9.151,9.151,175.607,175.607,183.833,183.834C493.884,217.456,494.017,230.111,486.125,237.996z"/>
                    <path d="M289.361,222.641c-3.906-3.906-10.238-3.906-14.143,0l-80.867,80.867c-3.905,3.905-3.905,10.237,0,14.143
			c3.905,3.905,10.237,3.905,14.142,0l80.867-80.867C293.266,232.878,293.266,226.547,289.361,222.641z"/></svg>

            </div>
        </a>
    </footer>
</div>
<?php $this->endBody() ?>

</body>

</html>
<?php $this->endPage() ?>
