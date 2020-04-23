<?php

namespace account\assets;

use yii\web\AssetBundle;

class AppAssets extends AssetBundle {

    public $basePath = '@backendAssetsDirectory';
    public $baseUrl = '@backendAssets';
    public $css = [
//        '//fonts.googleapis.com/css?family=Oswald:400,300,700',
        'https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap',
        '//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css',
        'global/plugins/simple-line-icons/simple-line-icons.min.css',
        'global/css/components-md.min.css',
        'global/css/plugins-md.min.css',
        'layouts/layout5/css/layout.min.css',
        'layouts/layout5/css/custom.min.css',
        'layouts/layout5/css/custom.css',
        'plugins/menuzord/css/menuzord.css',
        'global/plugins/bootstrap-toastr/toastr.min.css',
    ];
    public $js = [
        'lt IE 9' => [
            'global/plugins/respond.min.js',
            'global/plugins/excanvas.min.js',
            'global/plugins/ie8.fix.min.js',
        ],
        'global/plugins/js.cookie.min.js',
        'global/plugins/jquery-slimscroll/jquery.slimscroll.min.js',
        'global/plugins/jquery.blockui.min.js',
        'global/scripts/app.min.js',
        'layouts/layout5/scripts/layout.min.js',
        'layouts/global/scripts/quick-nav.min.js',
        'plugins/menuzord/js/menuzord.js',
        'global/plugins/bootstrap-toastr/toastr.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
