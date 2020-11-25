<?php

namespace app\assets;

use yii\web\AssetBundle;

class ContentNewAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/contentNew.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
