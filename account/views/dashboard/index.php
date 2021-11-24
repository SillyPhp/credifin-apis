<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

//echo $this->render('/widgets/header/secondary-header', [
//    'for' => 'Dashboard',
//]);
$is_email_verified = true;
if (Yii::$app->user->identity->organization->organization_enc_id) :
    if (!Yii::$app->user->identity->organization->is_email_verified) :
        $is_email_verified = false;
    endif;
elseif (!Yii::$app->user->identity->is_email_verified) :
    $is_email_verified = false;
endif;
if (!$is_email_verified) :
    echo $this->render('/widgets/verification/resend-email');
endif;
?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('/widgets/tasks/taskbar-card', ['viewed' => $viewed]); ?>


        <!--=====Active Module=====-->
        <!-- <?=
            $this->render('/widgets/services-selection/edit-services', [
                'model' => $model,
                'services' => $services,
            ]);
        ?> -->

        <!-- <section class="company-ques">
            <div class="upper-half">
                <h4 style="transform: translate(0, 31%);margin: 0 30px;">Are you offering Tech Roles in your company?</h4>
                <h4>Are you offering Tech Roles in your company?</h4>
            </div>
            <div class="ans">
                <span>YES</span>
                <span>NO</span>
            </div>
        </section> -->
        
        <?php if (Yii::$app->user->identity->organization->organization_enc_id) { ?>
            <?= $this->render('/widgets/safety-widgets', ['scriptModel' => $scriptModel]) ?>
        <?php } ?>


        <section class="app-prom-desktop">
        <?php if (Yii::$app->user->identity->type->user_type == 'Individual') { ?>
            <?= $this->render('/widgets/download-app', ['scriptModel' => $scriptModel]) ?>
        <?php } ?>
        </section>
    </div>
    <div class="col-md-9">
        <?php if (Yii::$app->user->identity->type->user_type == 'Individual') : ?>
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
                                <div class="desc">Applications Saved</div>
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
                                    <span><?= $total_accepted ?></span>
                                </div>
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
                                    <span><?= $total_pending ?></span>
                                </div>
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
                                    <span><?= $total_shortlist_org ?></span>
                                </div>
                                <div class="desc">Followed Companies</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <?php
                if($webinar) {
                    echo $this->render('/widgets/dashboard-webinar-widget', [
                           'webinar' => $webinar,
                    ]);
                }
            ?>

            <?php
                if ($loanApplication && Yii::$app->user->identity->type->user_type == 'Individual') {
                    echo $this->render('/widgets/education-loan/loan-detail-individual-dashboard', [
                        'loanApplication' => $loanApplication,
                    ]);
                }
            ?>
            <?php
                if($loanLoginFee){
                    foreach ($loanLoginFee as $loginFee){
                        echo $this->render('/widgets/login-fee-due', [
                                'loginFee' => $loginFee,
                        ]);
                    }
                }
            ?>
            <?=
            $this->render('/widgets/applications/dashboard-applied-applications', [
                'applied' => $applied,
                'question_list' => $question_list,
                'shortlist_org' => $shortlist_org,
                'viewed' => $viewed,
                'loan' => $loan,
            ]); ?>
            <?= $this->render('/widgets/applications/reminder-applications', [
                'app_reminder' => $app_reminder,
                'app_reminder_form' => $app_reminder_form,
            ]); ?>
            <?php
            if ($userValues['is_complete'] == 0) {
                echo $this->render('@common/widgets/complete-profile-modal', [
                    'userData' => $userValues['userVal']
                ]);
            }
            ?>
            <?php
            if ($userValues['is_complete'] == 1 && $userPref['is_complete'] == 0) {
                echo $this->render('@common/widgets/preference-and-location-modal', [
                    'userPref' => $userPref['userPref']
                ]);
            }
            ?>
        <?php elseif (Yii::$app->user->identity->organization) : ?>
            <div class="row marg">
                <div class="col-md-4 col-sm-6">
                    <a href="javascript:;">
                        <div class="jobs_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 nd-shadow actv-app">
                            <h4 class="widget-thumb-heading"><?= Yii::t('account', 'Active Applications'); ?></h4>
                            <div class="widget-thumb-wrap">
                                <i class="widget-thumb-icon fa fa-building-o"></i>
                                <div class="widget-thumb-body">
                                    <span class="widget-thumb-body-stat"><?= $org_applications['total'] ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="javascript:;">
                        <div class="processes_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 nd-shadow actv-resume">
                            <h4 class="widget-thumb-heading"><?= Yii::t('account', 'Dropped Resumes'); ?></h4>
                            <div class="widget-thumb-wrap">
                                <i class="widget-thumb-icon fa fa-users"></i>
                                <div class="widget-thumb-body">
                                    <span class="widget-thumb-body-stat"><?= $dropResume; ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="javascript:;">
                        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 employees_count nd-shadow actv-applicants">
                            <h4 class="widget-thumb-heading"><?= Yii::t('account', 'Total Applicants'); ?></h4>
                            <div class="widget-thumb-wrap">
                                <i class="widget-thumb-icon icon-bar-chart"></i>
                                <div class="widget-thumb-body">
                                    <span class="widget-thumb-subtitle"></span>
                                    <span class="widget-thumb-body-stat"><?= $total_org_applied ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php
            if ($viewed == 0) {
            ?>
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
                                    <div class="how-icon"><img src="<?= Url::to('@eyAssets/images/pages/dashboard/create.svg') ?>">
                                    </div>
                                    <div class="how-heading">Create a Job</div>
                                    <div class="how-text">
                                        <p>Create a Job, get applications, let candidates fill
                                            Questionnaire.</p>
                                        <p class="pera">Ask them what's relevant to your organization.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="how-box">
                                    <div class="how-icon"><img src="<?= Url::to('@eyAssets/images/pages/dashboard/invite.svg') ?>">
                                    </div>
                                    <div class="how-heading">Invite Candidates</div>
                                    <div class="how-text">
                                        <p>Share application with candidates that you have found
                                            by
                                            any other means.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="how-box">
                                    <div class="how-icon"><img src="<?= Url::to('@eyAssets/images/pages/dashboard/share.svg') ?>">
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
                                    <div class="how-icon"><img src="<?= Url::to('@eyAssets/images/pages/dashboard/process.svg') ?>">
                                    </div>
                                    <div class="how-heading">Process Applications</div>
                                    <div class="how-text">Finalize the candidates that you would like to interview
                                        and
                                        schedule seamlessly.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

            <div class="portlet light nd-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Open Jobs'); ?><span data-toggle="tooltip" title="Here you will find all your active jobs"><i class="fa fa-info-circle"></i></span></span>
                    </div>
                    <div class="actions">
                        <div class="set-im">
                            <a href="<?= Url::toRoute('/jobs/create'); ?>" data-toggle="tooltip" title="Create AI Job" class="ai" target="_blank">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/ai-job.png'); ?>"></a>
                            <?php
                            if (Yii::$app->user->identity->businessActivity->business_activity != "College" && Yii::$app->user->identity->businessActivity->business_activity != "School" && Yii::$app->user->identity->organization->has_placement_rights == 1) {
                            ?>
                                <a href="<?= Url::toRoute('/jobs/campus-placement'); ?>" data-toggle="tooltip" title="Campus Hiring" class="ai" target="_blank">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/placement.png'); ?>"></a>
                            <?php
                            }
                            ?>
                            <a href="<?= Url::to('/tweets/job/create'); ?>" data-toggle="tooltip" title="Post Job Tweet" class="tweet" target="_blank">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/job-tweet.png'); ?>"></a>
                            <a href="<?= Url::toRoute('/jobs/quick-job'); ?>" data-toggle="tooltip" title="Create Quick Job" class="quick" target="_blank">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/quick-job-icon1.png'); ?>"></a>
                            <a href="<?= Url::toRoute('/jobs'); ?>" data-toggle="tooltip" title="View All" class="view" target="_blank">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php
                    Pjax::begin(['id' => 'pjax_active_jobs']);
                    if ($applications['jobs']['total'] > 0) {
                        echo $this->render('/widgets/applications/card', [
                            'applications' => $applications['jobs']['data'],
                            'per_row' => 3,
                            'type' => 'Job',
                            'col_width' => 'col-lg-4 col-md-4 col-sm-6',
                        ]);
                    } else {
                    ?>
                        <div class="tab-empty">
                            <div class="tab-empty-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/jobinterview.png'); ?>" class="img-responsive" alt="" />
                            </div>
                            <div class="tab-empty-text">
                                <div class="">There Are No Active Jobs In This Company</div>
                            </div>
                        </div>
                    <?php }
                    Pjax::end();
                    ?>
                </div>
            </div>

            <div class="portlet light nd-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Open Internships'); ?><span data-toggle="tooltip" title="Here you will find all your active internships"><i class="fa fa-info-circle"></i></span></span>
                    </div>
                    <div class="actions">
                        <div class="set-im">
                            <a href="<?= Url::toRoute('/internships/create'); ?>" data-toggle="tooltip" title="Create AI Internship" target="_blank">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/ai-job.png'); ?>">
                            </a>
                            <?php
                            if (Yii::$app->user->identity->businessActivity->business_activity != "College" && Yii::$app->user->identity->businessActivity->business_activity != "School" && Yii::$app->user->identity->organization->has_placement_rights == 1) {
                            ?>
                                <a href="<?= Url::toRoute('/internships/campus-placement'); ?>" data-toggle="tooltip" title="Campus Hiring" class="ai" target="_blank">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/placement.png'); ?>"></a>
                            <?php
                            }
                            ?>
                            <a href="<?= Url::toRoute('/internships/create'); ?>" data-toggle="tooltip" title="Post Internship Tweet" target="_blank">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/job-tweet.png'); ?>">
                            </a>
                            <a href="<?= Url::toRoute('/internships/quick-internship'); ?>" data-toggle="tooltip" title="Create Quick Internship" class="quick" target="_blank">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/quick-job-icon1.png'); ?>">
                            </a>
                            <a href="<?= Url::toRoute('/internships'); ?>" data-toggle="tooltip" title="View All" target="_blank">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php
                    Pjax::begin(['id' => 'pjax_active_internships']);
                    if ($applications['internships']['total'] > 0) {
                        echo $this->render('/widgets/applications/card', [
                            'applications' => $applications['internships']['data'],
                            'per_row' => 3,
                            'type' => 'Internship',
                            'col_width' => 'col-lg-4 col-md-4 col-sm-6',
                        ]);
                    } else {
                    ?>
                        <div class="tab-empty">
                            <div class="tab-empty-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/active-internships.png'); ?>" class="img-responsive" alt="" />
                            </div>
                            <div class="tab-empty-text">
                                <div class="">There Are No Internships Open Right Now</div>
                            </div>
                        </div>
                    <?php }
                    Pjax::end();
                    ?>
                </div>
            </div>

            <?= $this->render('@common/widgets/career-page-section') ?>
            <div id="form_modal2" class="modal fade in" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Re-Open The Application</h4>
                        </div>
                        <div class="modal-body">
                            <?php
                            $extendModelform = ActiveForm::begin([
                                'id'=>'extends_job',
                                'action'=>'/account/jobs/extends-date',
                            ]);
                            echo $extendModelform->field($extendModel, 'date')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Last Date To Apply'],
                                'readonly' => true,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-M-yyyy',
                                    'name' => 'date',
                                    'todayHighlight' => true,
                                    'startDate' => '+0d',
                                ]])->label(false);
                            echo $extendModelform->field($extendModel, 'application_enc_id', ['template' => '{input}'])->hiddenInput(['id' => 'application_enc_id'])->label(false);
                            ?>
                            <div class="modal-footer">
                                <?= Html::submitButton('Save',['class'=>'btn btn-c-save']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>

        <?php endif; ?>
        <!--            <div class="portlet light portlet-fit nd-shadow">-->
        <!--                 <div class="portlet-title" style="border-bottom:none;">-->
        <div class="car-main row">
            <!--                        <div class="c-head">Careers</div>-->
            <!--                        <div class="career-descripption">It is a long established fact that a reader will be distracted-->
            <!--                            by the readable content of a page when looking at its layout. The point of using Lorem Ipsum-->
            <!--                            is that it has a more-or-less normal distribution of letters, as opposed to using 'Content-->
            <!--                            here, content here', making it look like readable English. Many desktop publishing packages-->
            <!--                            and web page editors now use Lorem Ipsum as their default model text,-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                    <div class="works-main row">-->
            <!--                        <div class="works">-->
            <!--                            <div class="w-head">How It Works</div>-->
            <!--                        </div>-->
            <!--                        <div class="col-md-4">-->
            <!--                            <div class="step-main">-->
            <!--                                <div class="s-logo">-->
            <!--                                    <img src="-->
            <? //= Url::to('@eyAssets/images/pages/dashboard/check.png') 
            ?>
            <!--">-->
            <!--                                </div>-->
            <!--                                <div class="s-text">Put Your Website address Here</div>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                        <div class="col-md-4">-->
            <!--                            <div class="step-main">-->
            <!--                                <div class="s-logo">-->
            <!--                                    <img src="-->
            <? //= Url::to('@eyAssets/images/pages/dashboard/check.png') 
            ?>
            <!--">-->
            <!--                                </div>-->
            <!--                                <div class="s-text">copy Link</div>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                        <div class="col-md-4">-->
            <!--                            <div class="step-main">-->
            <!--                                <div class="s-logo">-->
            <!--                                    <img src="-->
            <? //= Url::to('@eyAssets/images/pages/dashboard/check.png') 
            ?>
            <!--">-->
            <!--                                </div>-->
            <!--                                <div class="s-text">Paste On your website</div>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                    <div class="row">-->
            <!--                        <div class="main-btn">-->
            <!--                            <div class="inner-btn">-->
            <!--                                <input type="text" title="Click to Copy" id="share_manually" onclick="copyToClipboard()"-->
            <!--                                       class="form-control" value="--><? //= $link 
                                                                                        ?>
            <!--" readonly>-->
            <!--                                <i class="fa fa-copy"></i>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
        </div>
    </div>
    <section class="app-prom-mobile">
            <?php if (Yii::$app->user->identity->type->user_type == 'Individual') { ?>
                <?= $this->render('/widgets/download-app', ['scriptModel' => $scriptModel]) ?>
            <?php } ?>
        </section>
    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("share_manually");
            copyText.select();
            document.execCommand("copy");
            // toastr.success("", "Copied");
            alert("Copied the text: " + copyText.value);
        }
    </script>
    <?php
    $this->registerCss("
a:focus, a:hover{
    outline: none;
    text-decoration: none !important;
}
.portlet.light.portlet-fit{
    padding:12px 20px 15px;
}
.actv-app{
    background-image:linear-gradient(to top left, #70c6ea, #06729f);
}
.actv-resume{
    background-image: linear-gradient(to top left, #ffbb80, #ff7803);
}
.actv-applicants{
    background-image: linear-gradient(to top left, #d5dfa2, #28838c);
}
.widget-thumb .widget-thumb-heading{
    color:#fff;
}
.widget-thumb .widget-thumb-body .widget-thumb-body-stat{
    color:#fff;
}
.widget-thumb .widget-thumb-wrap .widget-thumb-icon{
    font-size:45px ;
}
.dwn {
	text-align: center;
	margin-top: 15px;
}
.download {
	background: #00a0e3;
	border: none;
	color: #fff;
	padding: 5px 20px;
	font-size: 18px;
	font-family: roboto;
	border-radius: 4px;
}
.mb-15{margin-bottom:15px;}

.form-control.for-n-cmp, .form-control.for-choose {
	height: 38px;
}
.safty-icon img{
    max-width: 150px;
}
.safty-posters{
    margin-top: 25px;
    text-align: center;
    padding: 20px 10px;
}
.quick-review{
    box-shadow: 0 0 10px rgba(0,0,0,.1);     
}
.safty-icon-text h2{
    font-size: 18px;
    font-family: roboto;
    font-weight: 500;
}
.quick-review-action a{  
	text-align:center;
	display:inline-block; 
    padding:5px 15px; 
//    background:#00a0e3; 
    border-radius:4px; 
    font-size:15px; 
    font-weight:500; 
    color:#fff;
    text-decoration: none;
    text-transform: capitalize;
    font-family: roboto;
}
.quick-review-action a:hover, .quick-review-action a:focus, .quick-review-action:active{
	outline: none;
	box-shadow: none;
} 
.ps__rail-x{
    display:block !important;
}
.quick > img{
    height:38px;
}
.set-im > a{
    margin-right:10px;
}
.ai img, .view img{
    height:31px;
}
.actions > a > img {
    height:22px;
    margin-top:7px;
}
.portlet.light > .portlet-title > .actions{
    padding:0px !important;
}
@media only screen and (max-width: 400px) {
 .portlet.light > .portlet-title > .actions{
    padding-bottom:10px !important;
    width:100%;
    text-align:center;
    }
}
.actions > a {
    margin-right: 15px;
}
.set-im > a:hover > img{
    -ms-transform: scale(1.2);
    -webkit-transform: scale(1.2);
    transform: scale(1.2);
}
.actions > a:hover > img{
    -ms-transform: scale(1.2);
    -webkit-transform: scale(1.2);
    transform: scale(1.2);
}
.font-dark > span > i {
    font-size: 13px;
    margin-left: 5px;
    color:darkgray;
}
.tab-empty{
    padding:20px;
}
.tab-empty-icon img{
    height:170px;
    margin:0 auto;
}
.tab-empty-text{
    text-align:center; 
    font-size:35px; 
    font-family:lobster; 
    color:#999999; 
    padding-top:20px;
}
.topic-con{
    position:relative;
}
.main-btn {
    width: 85px;
    margin: 0 auto;
    position: relative;
    cursor: pointer;
}
.inner-btn .form-control {
    cursor: pointer;
    background: #00a0e3;
    border: 2px solid #00a0e3;
}
.inner-btn .form-control:hover{
    box-shadow: 0px 1px 10px 4px #eee !important;
}
.inner-btn > i {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 18px;
    color:#fff;
}
.car-main{
    text-align:center;
    padding-bottom:20px;
    border-bottom: 1px solid #eee;
}
.c-head, .b-head, .w-head{
    font-size: 16px;
    font-weight: 700;
    font-family: \"Open Sans\",sans-serif;
    padding-bottom: 10px;
    text-transform: uppercase;
}
.career-descripption{
    font-size: 13px;
    text-align: justify;
    color: #9eacb4;
}
.works-main{
    padding-bottom:35px;
    padding-top:35px;
}
.works{
    text-align:center;
    padding-bottom:35px;
}
.step-main {
    text-align: center;
    border: 1px solid #eee;
    padding: 25px 10px;
}
.s-logo{
    padding-bottom:20px;
}
.s-logo img{
    height:100px;
    width:100px;
}
.s-text {
    font-size: 14px;
    font-weight: bold;
    text-transform: uppercase;
    color:#9eacb4;
}
@media screen and (min-width: 992px){
    .app-prom-mobile{
        display:none;
    }
}
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
    .app-prom-desktop{
        display: none;
    }
    .o-icon img{
        max-width:320px;
        margin:0 auto;
    }
} 
.overflow-hidden{
    overflow:hidden;
}
.quick-review{
	border:2px solid #eee;
	margin: 20px 0;
//	background-color:  #fbfcfc ;
	border-radius: 5px;
}
.quick-review-inner{
    margin:15px;
    display: flex;
    align-items: center;
}
.quick-review-img{
    text-align: center;
}
.modal {
  text-align: center;
}
@media screen and (min-width: 768px) { 
  .modal:before {
    display: inline-block;
    vertical-align: middle;
    content: '';
    height: 100%;
  }
}
.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}
.datepicker > div {
    display: block;
}


/* =====Dashboard Questions CSS======*/
.company-ques {
    padding: 20px 10px;
    margin-top: 20px;
    box-shadow: 0 0 5px 2px rgb(0 0 0 / 18%);
    position: relative;
    min-height: 225px;
}
.upper-half {
    background-image: linear-gradient(to top, #30cfd0 0%, #330867 165%);
    position: absolute;
    top: 0;
    left: 0;
    height: 50%;
    width: 100%;
} 
.company-ques h4 {
    font-size: 16px;
    text-align: center;
    margin: 15px 0;
    font-weight: 500;
    font-family: 'Roboto';
    line-height: 1.3;
    background: #fff;
    margin: 0 18px;
    display: block;
    position: absolute;
    bottom: 0;
    transform: translate(0, 25%);
    padding: 18px;
    box-shadow: 0px 5px 9px 1px rgb(0 0 0 / 25%);
    border-radius: 5px;
}
.company-ques > span {
    font-size: 14px;
    font-family: 'Roboto';
    display: block;
    text-align: center;
    font-weight: 500;
    color: #505050;
}
.ans {
    display: flex;
    justify-content: center;
    margin-top: 10px;
    position: absolute;
    bottom: 25px;
    width: 100%;
}
.ans span {
    padding: 5px 0;
    margin: 0 10px;
    font-weight: 700;
    width: 73px;
    border: 2px solid #ff7803;
    text-align: center;
}
.ans span:first-child{
    border-color: #00a0e3;
}
");
$script = <<< JS
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
    $(document).on('click','.datepicker_opn',function(e) {
        e.preventDefault();
        $('#application_enc_id').val($(this).attr('data-id'));
        $('#form_modal2').modal('show');
    });
JS;
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($script);
