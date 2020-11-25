<?php

namespace app\assets;

use yii\web\AssetBundle;

class ContentViewAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/contentView.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
