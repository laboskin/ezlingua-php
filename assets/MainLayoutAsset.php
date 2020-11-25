<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class MainLayoutAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/mainLayout.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
