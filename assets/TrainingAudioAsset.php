<?php

namespace app\assets;

use yii\web\AssetBundle;

class TrainingAudioAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/trainingAudio.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
