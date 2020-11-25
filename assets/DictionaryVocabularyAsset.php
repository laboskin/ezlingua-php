<?php

namespace app\assets;

use yii\web\AssetBundle;

class DictionaryVocabularyAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/dictionaryVocabulary.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
