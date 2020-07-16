<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class BlankAssets extends AssetBundle
{

    public $basePath = '@root';
    public $baseUrl = '@root';
    public $css = [

    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}