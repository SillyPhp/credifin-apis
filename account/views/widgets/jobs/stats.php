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
$this->registerCssFile('@vendorAssets/tutorials/css/introjs.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('/assets/themes/dashboard/tutorials/dashboard_tutorial.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_HEAD]);

if (!Yii::$app->session->has("tutorial_organization_jobs_count")) {
    echo '<script>dashboard_organization_jobs_count()</script>';
    Yii::$app->session->set("tutorial_organization_jobs_count", "Yes");
}