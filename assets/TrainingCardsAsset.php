<?php

namespace app\assets;

use yii\web\AssetBundle;

class TrainingCardsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/trainingCards.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
