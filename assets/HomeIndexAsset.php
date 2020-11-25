<?php

namespace app\assets;

use yii\web\AssetBundle;

class HomeIndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/homeIndex.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
