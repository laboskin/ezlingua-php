<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminDefaultAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/adminDefault.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
