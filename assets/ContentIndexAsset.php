<?php

namespace app\assets;

use yii\web\AssetBundle;

class ContentIndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/contentIndex.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
