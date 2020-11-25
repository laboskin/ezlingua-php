<?php

namespace app\assets;

use yii\web\AssetBundle;

class DictionaryIndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/dictionaryIndex.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
