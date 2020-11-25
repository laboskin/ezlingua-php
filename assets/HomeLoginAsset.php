<?php

namespace app\assets;

use yii\web\AssetBundle;

class HomeLoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/homeLogin.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
