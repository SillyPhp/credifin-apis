<?php
namespace frontend\assets;
use yii\web\AssetBundle;
class BlankAssets extends AssetBundle
{

    public $basePath = '@eyAssetsDirectory';
    public $baseUrl = '@eyAssets';
    public $css = [
        'css/jquery-ui.min.css',
    ];
    public $js = [

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}