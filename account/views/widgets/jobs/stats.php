<?php

use yii\helpers\Url;

?>


    <div class="col-md-3">
        <a href="<?= Url::toRoute('/jobs'); ?>">
            <div class="jobs_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                <h4 class="widget-thumb-heading"><?= Yii::t('account', 'Total Jobs'); ?></h4>
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
    <div class="col-md-3">
        <a href="<?= Url::toRoute('/interview-processes'); ?>">
            <div class="processes_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                <h4 class="widget-thumb-heading"><?= Yii::t('account', 'Total Interview Processes'); ?></h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-red fa fa-users"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-body-stat" data-counter="counterup"
                              data-value="<?= $interview_processes['total']; ?>"><?= $interview_processes['total']; ?></span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?= Url::toRoute('/questionnaire'); ?>">
            <div class="questionnaire_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                <h4 class="widget-thumb-heading"><?= Yii::t('account', 'Total Questionnaire'); ?></h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-purple fa fa-question"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-body-stat" data-counter="counterup"
                              data-value="<?= $questionnaire['total']; ?>"><?= $questionnaire['total']; ?></span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?= Url::toRoute('/jobs'); ?>">
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 employees_count">
                <h4 class="widget-thumb-heading"><?= Yii::t('account', 'Total Applicants'); ?></h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-blue icon-bar-chart"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-subtitle"></span>
                        <span class="widget-thumb-body-stat" data-counter="counterup"
                              data-value="<?= $applied_applications['total']; ?>"><?= $applications['total']; ?></span>
                    </div>
                </div>
            </div>
        </a>
    </div>
<?php
$script = <<< JS
var intro = introJs();

intro.setOptions({
 steps: [
   {
     element: document.querySelector('.jobs_count'),
     intro: "Total Jobs",
     position: 'top'
   },
   {
     element: document.querySelector('.processes_count'),
     intro: "Total Processes",
     position: 'bottom'
   },
   {
     element: document.querySelector('.questionnaire_count'),
     intro: "Total Questionnaire",
     position: 'top'
   },
   {
     element: document.querySelector('.employees_count'),
     intro: "Total Employees",
     position: 'bottom'
   },
 ]
});

intro.start();

JS;
$this->registerJs($script);
$this->registerCssFile('@vendorAssets/tutorials/css/introjs.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@vendorAssets/tutorials/js/intro.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);