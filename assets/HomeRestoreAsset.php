<?php

namespace app\assets;

use yii\web\AssetBundle;

class HomeRestoreAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/homeRestore.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
