<?php

use yii\helpers\Url;
use yii\widgets\Pjax;


// echo $this->render('/widgets/header/secondary-header', [
//     'for' => 'Jobs',
// ]);
?>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Open Jobs'); ?></span>
                </div>
                <div class="actions">
                                <div class="set-im">
                                    <a href="<?= Url::toRoute('/jobs/create'); ?>" data-toggle="tooltip"
                                       title="Create AI Job"
                                       class="ai">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/ai-job.png'); ?>"></a>
                                    <?php
                                    if (Yii::$app->user->identity->businessActivity->business_activity != "College" && Yii::$app->user->identity->businessActivity->business_activity != "School" && Yii::$app->user->identity->organization->has_placement_rights == 1) {
                                        ?>
                                        <a href="<?= Url::toRoute('/jobs/campus-placement'); ?>" data-toggle="tooltip"
                                           title="Campus Hiring" class="ai">
                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/placement.png'); ?>"></a>
                                        <?php
                                    }
                                    ?>
                                    <a href="<?= Url::to('/tweets/job/create'); ?>" data-toggle="tooltip"
                                       title="Post Job Tweet"
                                       class="tweet">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/job-tweet.png'); ?>"></a>
                                    <a href="<?= Url::toRoute('/jobs/quick-job'); ?>" data-toggle="tooltip"
                                       title="Create Quick Job" class="quick">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/quick-job-icon1.png'); ?>"></a>
                                </div>
                            </div>
            </div>
            <div class="portlet-body">
                <?php
                Pjax::begin(['id' => 'pjax_active_jobs']);
                if ($applications['total'] > 0) {
                    echo $this->render('/widgets/applications/card', [
                        'applications' => $applications['data'],
                        'type' => 'Job',
                        'per_row' => 4,
                    ]);
                }
                Pjax::end();
                ?>
            </div>
        </div>
    </div>
</div>


<?php $this->registerCss('
    .set-im a {
        margin-right: 10px;
    }
    .caption{
        height: 100%;
        line-height: 40px !important;
    }
')?>