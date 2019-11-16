<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAssets extends AssetBundle {

    public $basePath = '@eyAssetsDirectory';
    public $baseUrl = '@eyAssets';
    public $css = [
        'css/jquery-ui.min.css',
        'css/animate.css',
        'css/css-plugin-collections.css',
//        'css/menuzord-skins/menuzord-rounded-boxed.css',
        'css/style-main.css',
//        'css/custom-bootstrap-margin-padding.css',
        'css/custom.css',
        'css/responsive.css',
        'fonts/fontawesome-5/css/all.css',
        'https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap',
    ];
    public $js = [
        'js/jquery-touch-pounch.js',
        'js/jquery-plugin-collection_new.js',
        'js/custom.js',
        'js/lazyload.min.js',
//        'js/functions.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
