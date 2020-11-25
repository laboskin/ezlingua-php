<?php

namespace app\assets;

use yii\web\AssetBundle;

class ContentEditAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/contentEdit.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
