<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

echo $this->render('/widgets/header/secondary-header', [
    'for' => 'Dashboard',
]);

$is_email_verified = true;
if (Yii::$app->user->identity->organization->organization_enc_id):
    if (!Yii::$app->user->identity->organization->is_email_verified):
        $is_email_verified = false;
    endif;
elseif (!Yii::$app->user->identity->is_email_verified) :
    $is_email_verified = false;
endif;
if (!$is_email_verified):
    echo $this->render('/widgets/verification/resend-email');
endif;
?>

    <div class="row">
        <div class="col-md-3">
            <?= $this->render('/widgets/tasks/taskbar-card', ['viewed' => $viewed]); ?>
            <?=
            $this->render('/widgets/services-selection/edit-services', [
                'model' => $model,
                'services' => $services,
            ]);
            ?>
        </div>
        <div class="col-md-9">
            <?php if (Yii::$app->user->identity->type->user_type == 'Individual'): ?>
                <div class="widget-row">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 blue" href="javascript:;">
                                <div class="visual">
                                    <i class="fa fa-comments"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span><?= $total_reviews ?></span>
                                    </div>
                                    <div class="desc">Applications Reviewed</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 red" href="javascript:;">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span><?= $total_shortlist ?></span>
                                    </div>
                                    <div class="desc">Applications Shortlisted</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 green" href="javascript:;">
                                <div class="visual">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span><?= $total_applied ?></span>
                                    </div>
                                    <div class="desc"> Applications Applied</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 purple" href="javascript:;">
                                <div class="visual">
                                    <i class="fa fa-globe"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span><?= $total_accepted ?></span></div>
                                    <div class="desc"> Applications Accepted</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 yellow" href="javascript:;">
                                <div class="visual">
                                    <i class="fa fa-globe"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span><?= $total_pending ?></span></div>
                                    <div class="desc">Applications Pending</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 pink" href="javascript:;">
                                <div class="visual">
                                    <i class="fa fa-building"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span><?= $total_shortlist_org ?></span></div>
                                    <div class="desc">Followed Companies</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?=
                $this->render('/widgets/applications/dashboard-applied-applications', [
                    'applied' => $applied,
                    'question_list' => $question_list,
                    'shortlist_org' => $shortlist_org
                ]); ?>
            <?php elseif (Yii::$app->user->identity->organization): ?>
                <div class="row marg">
                    <div class="col-md-4 col-sm-6">
                        <a href="javascript:;">
                            <div class="jobs_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 nd-shadow">
                                <h4 class="widget-thumb-heading"><?= Yii::t('account', 'Active Applications'); ?></h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-green fa fa-building-o"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-body-stat"><?= $org_applications['total']?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <a href="javascript:;">
                            <div class="processes_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 nd-shadow">
                                <h4 class="widget-thumb-heading"><?= Yii::t('account', 'Dropped Resumes'); ?></h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-red fa fa-users"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-body-stat"><?= $dropResume;?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <a href="javascript:;">
                            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 employees_count nd-shadow">
                                <h4 class="widget-thumb-heading"><?= Yii::t('account', 'Total Applicants'); ?></h4>
                                <div class="widget-thumb-wrap">
                                    <i class="widget-thumb-icon bg-blue icon-bar-chart"></i>
                                    <div class="widget-thumb-body">
                                        <span class="widget-thumb-subtitle"></span>
                                        <span class="widget-thumb-body-stat"><?= $total_org_applied?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="portlet light portlet-fit nd-shadow">
                    <div class="portlet-title" style="border-bottom:none;">
                        <div class="check-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/check.png') ?>">
                        </div>
                        <div class="caption-1" style="">
                            <i class="icon-microphone font-dark hide"></i>
                            <span class="caption-subject bold font-dark uppercase" style="font-size:16px;"> Welcome Aboard</span><br>
                            <span class="caption-helper">Empower Youth makes it easy to post jobs and manage your candidates</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="how-box">
                                    <div class="how-icon"><img
                                                src="<?= Url::to('@eyAssets/images/pages/dashboard/create.svg') ?>">
                                    </div>
                                    <div class="how-heading">Create a Job</div>
                                    <div class="how-text"><p>Create a Job, get applications, let candidates fill
                                            Questionnaire.</p>
                                        <p class="pera">Ask them what's relevant to your organization.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="how-box">
                                    <div class="how-icon"><img
                                                src="<?= Url::to('@eyAssets/images/pages/dashboard/invite.svg') ?>">
                                    </div>
                                    <div class="how-heading">Invite Candidates</div>
                                    <div class="how-text"><p>Share application with candidates that you have found by
                                            any other means.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="how-box">
                                    <div class="how-icon"><img
                                                src="<?= Url::to('@eyAssets/images/pages/dashboard/share.svg') ?>">
                                    </div>
                                    <div class="how-heading">Compare Applicants</div>
                                    <div class="how-text">
                                        <p>Compare different applicants on the basis of their skills, suitability,
                                            location, experience, expected salary, etc.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="how-box">
                                    <div class="how-icon"><img
                                                src="<?= Url::to('@eyAssets/images/pages/dashboard/process.svg') ?>">
                                    </div>
                                    <div class="how-heading">Process Applications</div>
                                    <div class="how-text">Finalize the candidates that you would like to interview and
                                        schedule seamlessly.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="portlet light nd-shadow">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-social-twitter font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Active Jobs'); ?></span>
                        </div>
                        <div class="actions">
                            <a href="<?= Url::toRoute('/jobs/create'); ?>"
                               class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                            <?php if ($applications['jobs']['total'] > 8): ?>
                                <a href="<?= Url::toRoute('/jobs'); ?>" title=""
                                   class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php
                        Pjax::begin(['id' => 'pjax_active_jobs']);
                        if ($applications['jobs']['total'] > 0) {
                            echo $this->render('/widgets/applications/card', [
                                'applications' => $applications['jobs']['data'],
                                'per_row' => 3,
                                'col_width' => 'col-lg-4 col-md-4 col-sm-4',
                            ]);
                        } else {
                            ?>
                            <h3>No Active Jobs</h3>
                        <?php }
                        Pjax::end();
                        ?>
                    </div>
                </div>
                <div class="portlet light nd-shadow">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-social-twitter font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Active Internships'); ?></span>
                        </div>
                        <div class="actions">
                            <a href="<?= Url::toRoute('/internships/create'); ?>"
                               class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                            <?php if ($applications['internships']['total'] > 8): ?>
                                <a href="<?= Url::toRoute('/internships'); ?>" title=""
                                   class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php
                        Pjax::begin(['id' => 'pjax_active_internships']);
                        if ($applications['internships']['total'] > 0) {
                            echo $this->render('/widgets/applications/card', [
                                'applications' => $applications['internships']['data'],
                                'per_row' => 3,
                                'col_width' => 'col-lg-4 col-md-4 col-sm-4',
                            ]);
                        } else {
                            ?>
                            <h3>No Active Internships</h3>
                        <?php }
                        Pjax::end();
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php
$this->registerCss("
@media only screen and (max-width: 950px) {
.marg{
    margin-top:20px !important;
    }
}
.posRel{
    position:relative;
}
.o-icon{
    text-align:center
}
.o-icon img{
    max-width:220px;
    margin:0 auto;
}
.overlay{
    background: rgba(255,255,255,.9);
    width: 100%;
    height:100%;
//    min-height: 378px;
    position: absolute;
    z-index: 9;
}
/*how it works section css starts*/
.how-icon img{
    height:84px;
    width:84px;
}
.how-text{
    padding:10px 0 0 0;
    font-size:13px;
    color: #9eacb4;
} 
p.pera{
    padding-top:10px;
}
p{ 
    margin:0px 0px !important;  
}
.caption-1{
   text-align:center; 
   float:none !important;
   padding-top:5px;
}
.portlet>.portlet-title>.caption-1>.caption-helper{
    color: #9eacb4;
    font-size: 13px;
    font-weight: 400;
}
.check-icon{
    text-align:center;
}
.how-box{
    border:1px solid #eee;
    padding:20px 10px;
    text-align:center;
    min-height:266px;
}
.how-heading{
    font-weight:bold;
    text-transform:uppercase;
    padding-top:10px;
}
.hr-com-jobs2{
    margin-top:20px;
}
/*how it works section css ends*/

@media screen and (max-width: 992px){
    .o-icon img{
        max-width:320px;
        margin:0 auto;
    }
} 
");
$script = <<<JS

JS;
$this->registerJs($script);