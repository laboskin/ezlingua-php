<?php

namespace app\assets;

use yii\web\AssetBundle;

class UserIndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/userIndex.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
