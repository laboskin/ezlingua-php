<?php

namespace app\assets;

use yii\web\AssetBundle;

class DictionaryMyAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/dictionaryMy.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
