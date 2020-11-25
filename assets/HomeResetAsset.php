<?php

namespace app\assets;

use yii\web\AssetBundle;

class HomeResetAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/homeReset.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
