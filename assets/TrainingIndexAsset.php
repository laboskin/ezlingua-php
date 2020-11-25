<?php

namespace app\assets;

use yii\web\AssetBundle;

class TrainingIndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/trainingIndex.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
