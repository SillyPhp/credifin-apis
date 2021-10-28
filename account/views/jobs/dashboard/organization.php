<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

if (Yii::$app->user->identity->businessActivity->business_activity != "College" && Yii::$app->user->identity->businessActivity->business_activity != "School" && Yii::$app->user->identity->organization->has_placement_rights == 1) {
    echo $this->render('/widgets/campus-placement/select-college', [
        'colleges' => $colleges,
        'addedColleges' => $addedColleges,
        'saveCollege' => $saveCollege,
    ]);
}

//echo $this->render('/widgets/header/secondary-header', [
//    'for' => 'Jobs',
//]);
?>
    <div class="row">
        <div class="col-md-2 col-sm-3">
            <div class="new-card-container">
                <div class="card">
                    <div class="face face1">
                        <div class="content">
                            <a href="/account/jobs/create">
                                <div class="icon">
                                    <div class="icon-white-bg">
                                        <div class="iwb-pos-abso">
                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/ai-job.png') ?>"
                                                 alt="">
                                        </div>
                                    </div>
                                    <!--                                <i class="fa fa-linkedin-square" aria-hidden="true"></i>-->
                                </div>
                            </a>
                        </div>
                    </div>
                    <a href="/account/jobs/create" target="_blank">
                        <div class="face face2">
                            <div class="content">
                                <h3>
                                    AI Jobs
                                </h3>
                                <p>Create AI Jobs</p>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                if (Yii::$app->user->identity->businessActivity->business_activity != "College" && Yii::$app->user->identity->businessActivity->business_activity != "School" && Yii::$app->user->identity->organization->has_placement_rights == 1) {
                    ?>
                    <div class="card">
                        <div class="face face1">
                            <div class="content">
                                <a href="/account/jobs/campus-placement">
                                    <div class="icon">
                                        <div class="icon-white-bg">
                                            <div class="iwb-pos-abso">
                                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/placement.png') ?>"
                                                     alt="">
                                            </div>
                                        </div>
                                        <!--                                <i class="fa fa-twitter-square" aria-hidden="true"></i>-->
                                    </div>
                                </a>
                            </div>
                        </div>
                        <a href="/account/jobs/campus-placement" target="_blank">
                            <div class="face face2">
                                <div class="content">
                                    <h3>
                                        Campus Hiring
                                    </h3>
                                    <p>Select jobs for campus hiring</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                ?>
                <div class="card">
                    <div class="face face1">
                        <div class="content">
                            <a href="/tweets/job/create">
                                <div class="icon">
                                    <div class="icon-white-bg">
                                        <div class="iwb-pos-abso">
                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/job-tweet.png') ?>"
                                                 alt="">
                                        </div>
                                    </div>
                                    <!--                                <i class="fa fa-github-square" aria-hidden="true"></i>-->
                                </div>
                            </a>
                        </div>
                    </div>
                    <a href="/tweets/job/create" target="_blank">
                        <div class="face face2">
                            <div class="content">
                                <h3>
                                    Job Tweet
                                </h3>
                                <p>Post Job Tweet</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="card">
                    <div class="face face1">
                        <div class="content">
                            <a href="/account/jobs/quick-job">
                                <div class="icon">
                                    <div class="icon-white-bg">
                                        <div class="iwb-pos-abso">
                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/quick-job-icon1.png') ?>"
                                                 alt="">
                                        </div>
                                    </div>
                                    <!--                                <i class="fa fa-linkedin-square" aria-hidden="true"></i>-->
                                </div>
                            </a>
                        </div>
                    </div>
                    <a href="/account/jobs/quick-job" target="_blank">
                        <div class="face face2">
                            <div class="content">
                                <h3>
                                    Quick Jobs
                                </h3>
                                <p>Create Quick Jobs</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?= $this->render('/widgets/templates-jobs', [
                'jobs' => $jobs,
                'type' => 'Jobs',
            ]); ?>
        </div>
        <div class="col-md-10 col-sm-9">
            <div class="row widget-row">
                <?=
                $this->render('/widgets/jobs/stats', [
                    'questionnaire' => $questionnaire,
                    'applications' => $applications['total'] + $erexx_applications['total'],
                    'interview_processes' => $interview_processes,
                    'total_applied' => $total_applied,
                    'viewed' => $viewed,
                ]);
                ?>
            </div>
            <div class="row">
                <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="portlet light nd-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-social-twitter font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Jobs'); ?>
                            <span href="#" data-toggle="tooltip" title="Here you will find all your active jobs"><i
                                        class="fa fa-info-circle"></i></span>
                        </span>
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
                                    <a href="<?= Url::toRoute('/jobs/active-jobs'); ?>" data-toggle="tooltip"
                                       title="View All" class="view">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php
                            if ($applications['total'] > 0) {
                                echo $this->render('/widgets/applications/card', [
                                    'applications' => $applications['data'],
                                    'type' => 'Job',
                                    'col_width' => 'col-lg-4 col-md-4 col-sm-6',
                                ]);
                            } else {
                                ?>
                                <div class="tab-empty">
                                    <div class="tab-empty-icon">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/jobinterview.png'); ?>"
                                             class="img-responsive" alt=""/>
                                    </div>
                                    <div class="tab-empty-text">
                                        <div class="">There Are No Active Jobs In This Company</div>
                                    </div>
                                </div>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>

                <?php
                if (Yii::$app->user->identity->businessActivity->business_activity != "College" && Yii::$app->user->identity->businessActivity->business_activity != "School" && Yii::$app->user->identity->organization->has_placement_rights == 1) {
                    ?>
                    <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="portlet light nd-shadow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-social-twitter font-dark hide"></i>
                                    <span class="caption-subject font-dark bold uppercase">Campus Placement Jobs
                            <span data-toggle="tooltip" title="Here you will find jobs that are active on Erexx"><i
                                        class="fa fa-info-circle"></i></span></span>
                                </div>
                                <div class="actions">
                                    <a href="<?= Url::toRoute('/jobs/create'); ?>" data-toggle="tooltip"
                                       title="Create AI Job" class="ai">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/placement.png') ?>"></a>
                                    <a href="<?= Url::toRoute('/jobs/active-erexx-jobs'); ?>" data-toggle="tooltip"
                                       title="View All" class="ai">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <?php
                                if ($erexx_applications['total'] > 0) {
                                    echo $this->render('/widgets/applications/card', [
                                        'applications' => $erexx_applications['data'],
                                        'card_type' => 'mec_card',
                                        'type' => 'Job',
                                        'col_width' => 'col-lg-4 col-md-4 col-sm-6',
                                    ]);
                                } else {
                                    ?>
                                    <div class="tab-empty">
                                        <div class="tab-empty-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/activeerexx.png'); ?>"
                                                 class="img-responsive" alt=""/>
                                        </div>
                                        <div class="tab-empty-text">
                                            <div class="">You Have Not Posted Any Job</div>
                                            <span class="create-new-j">
                                        <a href="<?= Url::toRoute('/jobs/create'); ?>" data-toggle="tooltip"
                                           title="Add New">CREATE</a>
                                        </span>
                                        </div>
                                    </div>
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php }
                ?>
                <?php if ($shortlistedApplicants['count'] > 0) { ?>
                    <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="portlet light nd-shadow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-social-twitter font-dark hide"></i>
                                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Shortlisted Candidates'); ?><span
                                                data-toggle="tooltip" title="Shortlisted Candidates"><i
                                                    class="fa fa-info-circle"></i></span></span>
                                </div>
                                <?php if ($shortlistedApplicants['count'] > 3) { ?>
                                    <div class="actions">
                                        <div class="set-im">
                                            <a href="<?= Url::toRoute('shortlisted-candidates'); ?>"
                                               data-toggle="tooltip" title="View All">
                                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="portlet-body">
                                <div class="row">
                                    <?= $this->render('/widgets/applications/shortlisted-candidates', [
                                        'shortlistedApplicants' => $shortlistedApplicants,
                                        'type' => 'job'
                                    ]); ?>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php } ?>
                <?php if($savedApplicants['count'] > 0){ ?>
                    <div class="col-lg-12 col-xs-12 col-sm-12">
                        <div class="portlet light nd-shadow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-social-twitter font-dark hide"></i>
                                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Saved Candidates'); ?><span
                                                data-toggle="tooltip" title="Candidates Saved For Later"><i
                                                    class="fa fa-info-circle"></i></span></span>
                                </div>
                                <?php if ($savedApplicants['count'] > 3) { ?>
                                    <div class="actions">
                                        <div class="set-im">
                                            <a href="<?= Url::toRoute('saved-candidates'); ?>"
                                               data-toggle="tooltip" title="View All">
                                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="portlet-body">
                                <div class="row">
                                    <?= $this->render('/widgets/applications/saved-candidates', [
                                        'savedApplicants' => $savedApplicants,
                                        'type' => 'job'
                                    ]); ?>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php }?>
                <?php if($blacklistedApplicants['count'] > 0){ ?>
                    <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="portlet light nd-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-social-twitter font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Blacklisted Candidates'); ?><span
                                            data-toggle="tooltip" title="Permanently Blocked Candidates"><i
                                                class="fa fa-info-circle"></i></span></span>
                            </div>
                            <?php if ($blacklistedApplicants['count'] > 3) { ?>
                                <div class="actions">
                                    <div class="set-im">
                                        <a href="<?= Url::toRoute('blacklisted-candidates'); ?>"
                                           data-toggle="tooltip" title="View All">
                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                 <?= $this->render('/widgets/applications/blacklisted-candidates', [
                                     'blacklistedApplicants' => $blacklistedApplicants,
                                     'type' => 'job'
                                 ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
            <div class="row">
                <div class="col-lg-6 col-xs-12 col-sm-12">
                    <?= $this->render('/widgets/drop-resume/drop_resume', [
                        'data' => $primary_fields,
                        'type' => 'Jobs'
                    ]); ?>

                    <div class="portlet light nd-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-social-twitter font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Interview Processes'); ?>
                            <span data-toggle="tooltip" title="Here you will find all existing interview processes">
                                <i class="fa fa-info-circle"></i>
                            </span>
                        </span>
                            </div>
                            <div class="actions">
                                <a href="<?= Url::toRoute('/hiring-processes/create'); ?>" data-toggle="tooltip"
                                   title="Add New">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/add-new.png'); ?>"></a>
                                <a href="<?= Url::toRoute('/templates/hiring-process/index'); ?>" data-toggle="tooltip"
                                   title="Choose from Templates">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/templates.png'); ?>"></a>
                                <a href="<?= Url::toRoute('/hiring-processes'); ?>" data-toggle="tooltip"
                                   title="View All">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php
                                    if ($interview_processes['total'] > 0) {
                                        echo $this->render('/widgets/processes/card', [
                                            'processes' => $interview_processes['data'],
                                            'per_row' => 2,
                                            'col_width' => 'col-lg-6 col-md-6 col-sm-6',
                                        ]);
                                    } else {
                                        ?>
                                        <div class="tab-empty">
                                            <div class="tab-empty-icon">
                                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/process.png'); ?>"
                                                     class="img-responsive" alt=""/>
                                            </div>
                                            <div class="tab-empty-text">
                                                <div class="">No process to display</div>
                                            </div>
                                        </div>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    Pjax::begin(['id' => 'pjax_closed_jobs']);
                        ?>
                        <div class="portlet light nd-shadow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-social-twitter font-dark hide"></i>
                                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Closed Jobs'); ?>
                                <span data-toggle="tooltip" title="Here you will find all your closed jobs"><i
                                            class="fa fa-info-circle"></i></span></span>
                                </div>
                                <div class="actions">
                                    <a href="<?= Url::toRoute('/jobs/all-closed-jobs'); ?>" data-toggle="tooltip" title="View All">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <?php
                                echo $this->render('/widgets/applications/closed-jobs-cards', [
                                    'applications' => $closed_application['data'],
                                    'model' => $model,
                                ]);
                                ?>
                            </div>
                        </div>
                        <?php
                    Pjax::end();
                    ?>
                </div>
                <div class="col-lg-6 col-xs-12 col-sm-12">
                    <?php
                    echo $this->render('/widgets/applied-applications/users-card', [
                        'applied_applications' => $applied_applications,
                        'type' => 'jobs'
                    ]);
                    ?>

                    <div class="portlet light nd-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-social-twitter font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Questionnaire'); ?>
                            <span data-toggle="tooltip" title="Here you will find all existing questionnaires">
                                <i class="fa fa-info-circle"></i>
                            </span>
                        </span>
                            </div>
                            <div class="actions">
                                <a href="<?= Url::toRoute('/questionnaire/create'); ?>" data-toggle="tooltip"
                                   title="Add New">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/add-new.png'); ?>"></a>
                                <a href="<?= Url::toRoute('/templates/questionnaire/index'); ?>" data-toggle="tooltip"
                                   title="Choose from Templates">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/templates.png'); ?>"></a>
                                <a href="<?= Url::toRoute('/questionnaire'); ?>" data-toggle="tooltip"
                                   title="View All">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php
                                    if ($questionnaire['total'] > 0) {
                                        echo $this->render('/widgets/questionnaire/card', [
                                            'questionnaire' => $questionnaire['data'],
                                            'per_row' => 2,
                                            'col_width' => 'col-lg-6 col-md-6 col-sm-6',
                                        ]);
                                    } else {
                                        ?>
                                        <div class="tab-empty">
                                            <div class="tab-empty-icon">
                                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/questionnaires.png'); ?>"
                                                     class="img-responsive" alt=""/>
                                            </div>
                                            <div class="tab-empty-text">
                                                <div class="">No Questionnaires</div>
                                            </div>
                                        </div>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pos-relative">
        <?= $this->render('/widgets/college-list-modal') ?>
    </div>
<?php
$this->registerCss('
.total-jobs{
    background: linear-gradient(145deg, #3cc4a4, #43f0d0);
}
.total-int-p{
    background: linear-gradient(145deg, #f41ea0, #f08143);
}
.total-qn{
    background: linear-gradient(145deg, #1ea4f4, #4ed0d0);
}
.total-appl{
    background: linear-gradient(145deg, #1e21f4, #43c7f0);
}
.widget-thumb .widget-thumb-heading{
    color:#fff;
}
.widget-thumb .widget-thumb-body .widget-thumb-body-stat{
    color:#fff;
    font-size:32px !important;
}
.widget-thumb .widget-thumb-wrap .widget-thumb-icon{
    font-size:45px ;
}
.create-new-j a {
	background: #00a0e3;
	color: #fff;
	border-radius: 6px;
	padding: 5px 25px;
	font-family: roboto;
	font-size: 20px;
}
.padd-top-20{
    padding-top:10px; 
}
/*---- new code-----*/
.new-card-container .card {
    position: relative;
    border-radius: 10px;
}

.new-card-container .card .icon {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #f00;
    transition: 0.7s;
    z-index: 1;
}

.new-card-container .card:nth-child(1) .icon {
    background: linear-gradient(145deg, #f4b61e, #f08143);
}

.new-card-container .card:nth-child(2) .icon {
    background: linear-gradient(145deg, #4997dd, #7c59ec);
}
.new-card-container .card:nth-child(3) .icon {
    background: linear-gradient(145deg, #83cff5, #4fafef);
}
.new-card-container .card:nth-child(4) .icon {
    background: linear-gradient(145deg, #c23465,#4c0e50);
}
.new-card-container .card:nth-child(5) .icon {
    background: linear-gradient(145deg, #56ba85,#255b6b);
}
.icon-white-bg{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    transition: 0.7s;
    background: #fff;
    width:70px;
    height:70px;
    border-radius:10px;
}
.iwb-pos-abso{
    position:relative;
     width:70px;
    height:70px;
}
.iwb-pos-abso img{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.new-card-container .card .icon .fa {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 80px;
    transition: 0.7s;
    color: #fff;

}

.new-card-container .card i {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 80px;
    transition: 0.7s;
    color: #fff;
}

.new-card-container .card .face {
    width: 100%;
    height: 130px;
    transition: 0.5s;
    margin-bottom:20px;
}

.new-card-container .card .face.face1 {
    position: relative;
    background: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2;
//    transform: translateY(100px);
}

.new-card-container .card:hover .face.face1{
    background: #ff0057;
    transform: translateX(0px);
}

.new-card-container .card .face.face1 .content {
    opacity: 1;
    transition: 0.5s;
}

.new-card-container .card:hover .face.face1 .content {
    opacity: 1;
}

.new-card-container .card .face.face1 .content i{
    max-width: 100px;
}

.new-card-container .card .face.face2 {
    width:99%;
    position: absolute;
    top:0px;
    right:0px;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px 15px;
    box-sizing: border-box;
    box-shadow: 0 8px 19px rgba(0,0,0,0.4);
    transform: translateX(0px);
    z-index:1;
}

.new-card-container .card:hover .face.face2{
    transform: translateX(0x);
    right:-99%;
    z-index:1;
}

.new-card-container .card .face.face2 .content p {
    margin: 0;
    padding: 0;
    text-align: center;
    color: #414141;
    font-size: 13px;
}

.new-card-container .card .face.face2 .content h3 {
    margin: 0 0 10px 0;
    padding: 0;
    color: #fff;
    font-size: 20px;
    text-align: center;
    color: #414141;
    font-weight: 500;
} 

.new-card-container a {
    text-decoration: none;
    color: #414141;
}
/*---- new code ends-----*/
.set-im > a{
    margin-right:10px;
}
.ai img, .view img{
    height:31px !important;
    margin: 0 !important;
}
.actions > a > img {
    height:22px;
    margin-top:7px;
}
.portlet.light > .portlet-title > .actions{
    padding:0px !important;
}
@media only screen and (max-width:400px) {
 .portlet.light > .portlet-title > .actions{
    padding-bottom:10px !important;
    width:100%;
    text-align:center;
    }
}
.quick > img{
    height:38px;
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
.mt-action-author a{
    color: #000;
}
.mt-actions .mt-action .mt-action-body .mt-action-row .mt-action-buttons {
    width:170px;
}

/*shortlist jobs and saved candidates css start here*/
.divRel{
    position: relative;
    width: 100%;
    margin-bottom: 30px;
}
.shortText{
    text-transform: capitalize;
    font-size: 13px;
}
.short-main {
    border: 2px solid #eef1f5;
    padding: 10px 10px 0;
    position: relative;
    transition: all .3s;
    border-radius: 6px;
    z-index:0;
}
.short-main:hover .remove-btn{
    opacity:1;
}
.short-main:hover{
    box-shadow:0 0 10px rgb(0 0 0 / 10%);
    border-color:transparent;
}
.flex-short {
    display: flex;
    align-items: center;
}
.short-logo img {
    width: 60px;
    height: 60px;
    object-fit: fill;
}
.short-details {
    flex-basis: 80%;
    padding-left: 15px;
}
.short-job {
    color: #00a0e3;
    font-size: 16px;
    font-family: Roboto;
    text-transform: capitalize;
    margin: 5px 0 !important;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.short-name {
    color: #999;
    font-family: Roboto;
    display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
.short-name i{
    margin-right: 5px;
}
.remove-btn {
    position: absolute;
    right: 0px;
    top: 2px;
    opacity:0;
    transition:all .3s;
}
.remove-btn button {
    border: none;
    background: none !important;
    color: #d75946;
    line-height: 0;
}
.short-skills {
    border-radius: 8px;
    margin: 10px 0;
    display: flex;
    padding-left: 6px;
    font-family:roboto;
    flex-wrap: wrap;
    height: 22px;
    overflow: hidden;
}
.short-skills a {
    color: #333;
    font-family: roboto;
    margin-bottom: 5px;
    text-transform:capitalize;
    transition:all .3s;
}
.short-skills span {
    font-weight: 500;
}
.short-skills a:hover {
    color: #00a0e3;
}
.slide-btn {
    margin-bottom: -1px;
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translate(-50%, 0px);
}
.slide-bttn{
    background:#00a0e3;
    border:none;
    color:#fff;
    border-radius:10px 10px 0 0 !important;
    padding:1px 15px;
}
.slide-bttn:hover{
    box-shadow:0px -2px 8px rgba(0, 0, 0, .3);
    transition:.3s all;     
    -webkit-transition:.3s all;     
    -moz-transition:.3s all;     
    -o-transition:.3s all; 
}
.rotate180{
    animation: rotate180 1s 1;
    transform: rotate(180deg);
    transition: .5s ease;
}
.slide-bttn:focus{
    outline:none;
}
.cd-box-border{
    border:2px solid #eef1f4; 
    border-top:none;
    padding:10px; 
    background:#fff; 
    border-radius:0 0 4px 4px !important; 
    color:#999999;
    margin:0; 
    position: absolute;
    z-index: 9;
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% - 40px);
}
.cd-box-border table{margin:0 !important;}
.tt {
    transition: .5s ease;
}
.unblockBtn{
    position: absolute;
    top:0px; 
    right:0px;
}
.unblock-cand{
    background: #00a0e3;
    color: #fff;
    padding: 2px 7px;
    border: 1px solid #00a0e3;
    border-radius: 0 5px 0;
    font-size: 12px;
}
.short-skills > .question_list:nth-child(n + 3):before {
    content: ",";
}
/*shortlist jobs and saved candidates css end here*/
');
$script = <<<JS
    $(document).on('click', '.approv_btn', function (e) {
        e.preventDefault();
        var data = $(this).attr('data-key');
        $.ajax({
            url: '/account/accept-application',
            data: {data: data},
            method: 'post',
            beforeSend: function () {
            },
            success: function (data) {
            }
        });
    });
    $(document).on('click', '.remov_btn', function (e) {
        e.preventDefault();
    });

    $(document).on('click', '.share_btn', function (e) {
        e.preventDefault();
    });
    $('[data-toggle="tooltip"]').tooltip();
JS;
$this->registerJs($script);
?>