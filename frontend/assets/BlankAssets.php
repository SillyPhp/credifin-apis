<?php
namespace frontend\assets;
use yii\web\AssetBundle;
class BlankAssets extends AssetBundle
{

    public $basePath = '@eyAssetsDirectory';
    public $baseUrl = '@eyAssets';
    public $css = [
        'css/jquery-ui.min.css',
        'css/custom.css',
        'fonts/fontawesome-5/css/all.css',
        'https://fonts.googleapis.com/css?family=Lobster|Open+Sans|Roboto:400,500,700&display=swap',
    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}