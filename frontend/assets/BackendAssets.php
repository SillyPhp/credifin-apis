<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main dashboard application asset bundle.
 */
class BackendAssets extends AssetBundle {

    public $basePath = '@backendAssetsDirectory';
    public $baseUrl = '@backendAssets';
    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all',
//        'global/plugins/font-awesome/css/font-awesome.min.css',
        'global/plugins/simple-line-icons/simple-line-icons.min.css',
        'global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
        'global/css/components-rounded.min.css',
        'global/css/plugins.min.css',
        'global/css/custom.css',
        'layouts/layout2/css/layout.min.css',
        'layouts/layout2/css/themes/blue.min.css',
        'layouts/layout2/css/custom.min.css',
        'plugins/menuzord/css/menuzord.css',
        'global/plugins/bootstrap-toastr/toastr.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css',
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
        'global/plugins/jquery-ui/jquery-ui.min.js',
        'global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
        'global/scripts/app.min.js',
        'layouts/layout2/scripts/layout.min.js',
        'layouts/layout2/scripts/demo.min.js',
        'layouts/global/scripts/quick-sidebar.min.js',
        'layouts/global/scripts/quick-nav.min.js',
        'plugins/menuzord/js/menuzord.js',
        'global/plugins/bootstrap-toastr/toastr.min.js',
        'pages/scripts/ui-modals.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
