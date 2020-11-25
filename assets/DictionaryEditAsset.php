<?php

namespace app\assets;

use yii\web\AssetBundle;

class DictionaryEditAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/dictionaryEdit.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
