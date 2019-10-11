<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="col-md-12">
    <div class="row widget-row">
        <div class="col-md-3 col-sm-6">
            <a href="#">
                <div class="box-des box1 mt">
                    <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/totalprograms.png') ?>">
                    <span class="count">10</span>
                    <span class="box-text">Total Programs</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="#">
                <div class="box-des box2 mt">
                    <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/totalopenings.png') ?>">
                    <span class="count">15</span>
                    <span class="box-text">Total Openings</span>
                </div>
            </a>
        </div>
    </div>
</div>
<?php
$this ->registercss('
.box1{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1job.png");}
.box2{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1company.png");}
.box-des {
   background-size: 100% 100%;
   background-repeat: no-repeat;
   position: relative;
   height: 160px;
}
.mt{margin-bottom:15px;}
.box-des img{
   position: absolute;
   max-width: 63px;
   right: 25px;
   top: 15px;
}
.box2set img{
    max-width: 80px !important;
}
.box-text {
   position: absolute;
   bottom: 3px;
   left: 16px;
   color: white;
   font-size: 21px;
   font-family: roboto;
}
.count {
   position: absolute;
   bottom: 28px;
   left: 16px;
   color: white;
   font-size: 30px;
   font-family: roboto;
}
');
$script = <<< JS

JS;
$this->registerJs($script);

$this->registerCssFile('@vendorAssets/tutorials/css/introjs.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('/assets/themes/dashboard/tutorials/dashboard_tutorial.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_HEAD]);
