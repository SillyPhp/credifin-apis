<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class QuizAssets4 extends AssetBundle {

    public $basePath = '@rootDirectory/assets/themes/quiz4';
    public $baseUrl = '@root/assets/themes/quiz4';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css',
        'css/style.css',
    ];
    public $js = [
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
