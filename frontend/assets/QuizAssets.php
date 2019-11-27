<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class QuizAssets extends AssetBundle {

    public $basePath = '@rootDirectory/assets/themes/quiz';
    public $baseUrl = '@root/assets/themes/quiz';
    public $css = [
        'https://fonts.googleapis.com/css?family=Permanent+Marker',
        'https://fonts.googleapis.com/css?family=Audiowide',
        'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css',
        'css/style.css',
    ];
    public $js = [
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
        'js/index.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
