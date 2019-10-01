<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

    <div class="col-md-3 col-sm-6">
        <a href="<?= Url::toRoute('/training-program'); ?>">
            <div class="jobs_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                <h4 class="widget-thumb-heading"><?= Yii::t('account', 'Total Programs'); ?></h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-green fa fa-building-o"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-body-stat" data-counter="counterup"
                              data-value="<?= $applications['total']; ?>"><?= $applications['total']; ?></span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6">
        <a href="<?= Url::toRoute('/training-program'); ?>">
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 employees_count">
                <h4 class="widget-thumb-heading"><?= Yii::t('account', 'Total Applicants'); ?></h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-blue icon-bar-chart"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle"></span>
                        <span class="widget-thumb-body-stat" data-counter="counterup"
                              data-value="<?= $total_applied; ?>"><?= $total_applied; ?></span>
                    </div>
                </div>
            </div>
        </a>
    </div>
<?php

$script = <<< JS

JS;
$this->registerJs($script);

$this->registerCssFile('@vendorAssets/tutorials/css/introjs.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('/assets/themes/dashboard/tutorials/dashboard_tutorial.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_HEAD]);
