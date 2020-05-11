<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class QuizAssets3 extends AssetBundle {

    public $basePath = '@rootDirectory/assets/themes/quiz3';
    public $baseUrl = '@root/assets/themes/quiz3';
    public $css = [
        'http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic',
        'http://fonts.googleapis.com/css?family=Lato:300,400',
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
        'css/quiz.css',
    ];
    public $js = [
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js',
        'js/quiz.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
