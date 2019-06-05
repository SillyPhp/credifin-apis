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
        'css/menuzord-skins/menuzord-rounded-boxed.css',
        'css/style-main.css',
//        'css/preloader.css',
        'css/custom-bootstrap-margin-padding.css',
        'css/custom.css',
        'css/responsive.css',
//        'css/colors/theme-skin-color-set-1.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css',
    ];
    public $js = [
        'js/jquery-touch-pounch.js',
        'js/jquery-plugin-collection_new.js',
        'js/custom.js',
        'js/lazyload.min.js',
        'js/functions.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
