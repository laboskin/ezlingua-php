<?php
/**
 * @var $user \app\models\User
 */
use yii\helpers\Html;
echo Yii::t('homeRestore', 'Hello').', '.Html::encode($user->name).'. ';
echo '<br>';
echo Html::a(Yii::t('homeRestore', 'Click here to change you password.'),
    Yii::$app->urlManager->createAbsoluteUrl(
        [
            '/home/reset',
            'key' => $user->restore_key
        ]
    ));