<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main dashboard application asset bundle.
 */
class BackendNewAssets extends AssetBundle {

    public $basePath = '@backendAssetsDirectory';
    public $baseUrl = '@backendAssets';
    public $css = [
        '//fonts.googleapis.com/css?family=Oswald:400,300,700',
        '//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all',
        'global/plugins/font-awesome/css/font-awesome.min.css',
//        'global/plugins/jquery-ui/jquery-ui.min.css',
        'global/plugins/simple-line-icons/simple-line-icons.min.css',
//        'global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
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
//        'global/plugins/jquery-ui/jquery-ui.min.js',
        'global/plugins/js.cookie.min.js',
        'global/plugins/jquery-slimscroll/jquery.slimscroll.min.js',
        'global/plugins/jquery.blockui.min.js',
//        'global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
        'global/scripts/app.min.js',
        'layouts/layout5/scripts/layout.min.js',
//        'layouts/global/scripts/quick-sidebar.min.js',
        'layouts/global/scripts/quick-nav.min.js',
        'plugins/menuzord/js/menuzord.js',
        'global/plugins/bootstrap-toastr/toastr.min.js',
//        'pages/scripts/ui-modals.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
