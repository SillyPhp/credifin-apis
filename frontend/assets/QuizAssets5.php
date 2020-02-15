<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class QuizAssets5 extends AssetBundle {

    public $basePath = '@rootDirectory/assets/themes/quiz4';
    public $baseUrl = '@root/assets/themes/quiz4';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css',
//        'css/style.css',
    ];
    public $js = [
        [
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js',
            'position' => \yii\web\View::POS_HEAD
        ],
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
//        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
