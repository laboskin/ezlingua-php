<?php

/* @var $this yii\web\View */
/* @var $courses array */
/* @var $userCoursesIds array */
/* @var $userLanguage string */

$this->title = Yii::t('userAddCourse', 'Available languages');
\app\assets\UserAddCourseAsset::register($this);

use yii\bootstrap\ActiveForm;
use yii\helpers\Html; ?>

<div class="main-container">
    <div class="page-title">
        <div class="page-name">
            <div class="page-name-text">
                <?= Yii::t('userAddCourse', 'Available languages for those who know ') ?> <?= mb_strtolower($userLanguage) ?>
            </div>
        </div>
    </div>
    <div class="user-add-course">
        <div class="items-grid">
            <?php foreach ($courses as $course): ?>
            <a href="<?= \yii\helpers\Url::to(['user/change-course', 'course_id'=>$course['id']]) ?>" class="course">
                <div class="course-added">
                    <?php if(in_array($course['id'], $userCoursesIds)): ?>
                    <div class="course-added-icon">
                        <svg viewBox="0 0 47 47">
                            <path d="M37.6,0H9.4C4.209,0,0,4.209,0,9.4v28.2C0,42.791,4.209,47,9.4,47h28.2c5.191,0,9.4-4.209,9.4-9.4V9.4
		C47,4.209,42.791,0,37.6,0z M38.143,19.139L23.602,33.678c-0.803,0.805-1.854,1.205-2.906,1.205c-1.051,0-2.104-0.4-2.907-1.205
		l-8.933-8.932c-1.604-1.604-1.604-4.208,0-5.814c1.607-1.606,4.209-1.606,5.816,0l6.023,6.023l11.633-11.633
		c1.605-1.605,4.209-1.605,5.814,0C39.75,14.928,39.75,17.532,38.143,19.139z"/></svg>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="course-image">
                    <img src="../../web/source/images/flags/<?= $course['image'] ?>" alt="">
                </div>
                <div class="course-name">
                    <?= $course['name'] ?>
                </div>
            </a>

            <?php endforeach; ?>
            <div class="hidden-course"></div>
            <div class="hidden-course"></div>
            <div class="hidden-course"></div>
            <div class="hidden-course"></div>
            <div class="hidden-course"></div>
            <div class="hidden-course"></div>
            <div class="hidden-course"></div>
            <div class="hidden-course"></div>
            <div class="hidden-course"></div>
            <div class="hidden-course"></div>
        </div>
    </div>
</div>





</div>