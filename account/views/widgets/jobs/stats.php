<?php

use yii\helpers\Url;
use yii\helpers\Html;
echo Html::hiddenInput('value', $viewed,['id'=>'hidden_input']);
?>

    <div class="col-md-3 col-sm-6">
        <a href="<?= Url::toRoute('/jobs'); ?>">
            <div class="jobs_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 nd-shadow">
                <h4 class="widget-thumb-heading"><?= Yii::t('account', 'Total Jobs'); ?></h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-green fa fa-building-o"></i>
                    <div class="widget-thumb-body">
                        <span class="widget-thumb-body-stat" data-counter="counterup"
                              data-value="<?= $applications ?>"><?= $applications ?></span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6">
        <a href="<?= Url::toRoute('/hiring-processes'); ?>">
            <div class="processes_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 nd-shadow">
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
    <div class="col-md-3 col-sm-6">
        <a href="<?= Url::toRoute('/questionnaire'); ?>">
            <div class="questionnaire_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 nd-shadow">
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
    <div class="col-md-3 col-sm-6">
        <a href="<?= Url::toRoute('/jobs'); ?>">
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 employees_count nd-shadow">
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
    var value = document.getElementById('hidden_input').value;
    if(value == 0){
        dashboard_organization_jobs_count();
            $.ajax({
            type:"POST",
            url:"/account/dashboard/coaching",
            data:{dat:"organization_jobs_stats"},
            });
    }
JS;
$this->registerJs($script);

$this->registerCssFile('@vendorAssets/tutorials/css/introjs.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('/assets/themes/dashboard/tutorials/dashboard_tutorial.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_HEAD]);
