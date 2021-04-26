<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

//echo $this->render('/widgets/header/secondary-header', [
//    'for' => 'Internships',
//]);
?>
    <div class="row padd-top-20">
        <div class="col-md-2">
            <div class="new-card-container">
                <div class="card">
                    <div class="face face1">
                        <div class="content">
                            <a href="/account/internships/create">
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
                    <a href="/account/internships/create" target="_blank">
                        <div class="face face2">
                            <div class="content">
                                <h3>
                                    AI Internships
                                </h3>
                                <p>Create AI Internship</p>
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
                                <a href="/account/internships/campus-placement">
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
                        <a href="/account/internships/campus-placement" target="_blank">
                            <div class="face face2">
                                <div class="content">
                                    <h3>
                                        Campus Hiring
                                    </h3>
                                    <p>Select internships for campus hiring</p>
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
                            <a href="/tweets/internship/create">
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
                    <a href="/tweets/internship/create" target="_blank">
                        <div class="face face2">
                            <div class="content">
                                <h3>
                                    Internship Tweet
                                </h3>
                                <p>Post Internship Tweet</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="card">
                    <div class="face face1">
                        <div class="content">
                            <a href="/account/internships/quick-internship">
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
                    <a href="/account/internships/quick-internship" target="_blank">
                        <div class="face face2">
                            <div class="content">
                                <h3>
                                    Quick Internship
                                </h3>
                                <p>Create Quick Internships</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?= $this->render('/widgets/templates-jobs', [
                'jobs' => $internships,
                'type' => 'Internships',
            ]); ?>
        </div>
        <div class="col-md-10">
            <div class="loader"><img
                        src='https://gifimage.net/wp-content/uploads/2017/09/ajax-loading-gif-transparent-background-4.gif'/>
            </div>
            <div class="row widget-row">
                <?=
                $this->render('/widgets/internships/stats', [
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
                                <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Internships'); ?><span
                                            data-toggle="tooltip"
                                            title="Here you will find all your active internships"><i
                                                class="fa fa-info-circle"></i></span></span>
                            </div>
                            <div class="actions">
                                <div class="set-im">
                                    <a href="<?= Url::toRoute('/internships/create'); ?>" data-toggle="tooltip"
                                       title="Create AI Internship" class="ai">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/ai-job.png'); ?>"></a>
                                    <?php
                                    if (Yii::$app->user->identity->businessActivity->business_activity != "College" && Yii::$app->user->identity->businessActivity->business_activity != "School" && Yii::$app->user->identity->organization->has_placement_rights == 1) {
                                        ?>
                                        <a href="<?= Url::toRoute('/internships/campus-placement'); ?>"
                                           data-toggle="tooltip"
                                           title="Campus Hiring" class="ai">
                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/placement.png'); ?>"></a>
                                        <?php
                                    }
                                    ?>
                                    <a href="<?= Url::to('/tweets/internship/create'); ?>" data-toggle="tooltip"
                                       title="Post Internship Tweet" class="tweet">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/job-tweet.png'); ?>"></a>
                                    <a href="<?= Url::toRoute('/internships/active-internships'); ?>"
                                       data-toggle="tooltip"
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
                                    'per_row' => 4,
                                    'col_width' => 'col-lg-4 col-md-4 col-sm-4',
                                ]);
                            } else {
                                ?>
                                <div class="tab-empty">
                                    <div class="tab-empty-icon">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/active-internships.png'); ?>"
                                             class="img-responsive" alt=""/>
                                    </div>
                                    <div class="tab-empty-text">
                                        <div class="">There Are No Active Internships In This Company</div>
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
                                <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Campus Placement Internships') ?><span
                                            data-toggle="tooltip"
                                            title="Here you will find internships that are active on Erexx"><i
                                                class="fa fa-info-circle"></i></span></span>
                            </div>
                            <div class="actions">
                                <a href="<?= Url::toRoute('/internships/create'); ?>" data-toggle="tooltip"
                                   title="Create AI Internship" class="ai">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/ai-job.png') ?>"></a>
                                <a href="<?= Url::toRoute('/internships/active-erexx-internships'); ?>"
                                   data-toggle="tooltip" title="View All" class="view">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <?php
                            if ($erexx_applications['total'] > 0) {
                                echo $this->render('/widgets/applications/card', [
                                    'applications' => $erexx_applications['data'],
                                    'card_type'=>'mec_card',
                                    'per_row' => 4,
                                    'col_width' => 'col-lg-4 col-md-4 col-sm-4',
                                ]);
                            } else {
                                ?>
                                <div class="tab-empty">
                                    <div class="tab-empty-icon">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/activeerexxi.png'); ?>"
                                             class="img-responsive" alt=""/>
                                    </div>
                                    <div class="tab-empty-text">
                                        <div class="">You Have Not Posted Any Internships</div>
                                        <span class="create-new-i">
                                        <a href="<?= Url::toRoute('/internships/create'); ?>" data-toggle="tooltip"
                                           title="Add New">CREATE</a>
                                        </span>
                                    </div>
                                </div>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
            ?>
            <div class="row">
                <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="portlet light nd-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-social-twitter font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Shortlisted Candidates'); ?><span
                                            data-toggle="tooltip" title="shortlisted candidates"><i
                                                class="fa fa-info-circle"></i></span></span>
                            </div>
                            <div class="actions">
                                <div class="set-im">
                                    <a href="<?= Url::toRoute('/internships'); ?>" data-toggle="tooltip"
                                       title="View All">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <?= $this->render('/widgets/applications/shortlisted-candidates'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-xs-12 col-sm-12">
                    <?= $this->render('/widgets/drop-resume/drop_resume', [
                        'data' => $primary_fields,
                        'type' => 'Internships'
                    ]); ?>

                    <div class="portlet light nd-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-social-twitter font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Questionnaire'); ?><span
                                            data-toggle="tooltip"
                                            title="Here you will find all existing questionnaires"><i
                                                class="fa fa-info-circle"></i></span></span>
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
                                                <div class="">No Questionnaires to display</div>
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
                    if ($closed_application['total'] > 0) {
                        ?>
                        <div class="portlet light nd-shadow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class=" icon-social-twitter font-dark hide"></i>
                                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Closed Internships'); ?><span
                                                data-toggle="tooltip"
                                                title="Here you will find all companies that you are following"><i
                                                    class="fa fa-info-circle"></i></span></span>
                                </div>
                                <div class="actions">
                                    <a href="<?= Url::toRoute('/jobs'); ?>" data-toggle="tooltip" title="View All">
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
                    }
                    Pjax::end();
                    ?>
                </div>
                <div class="col-lg-6 col-xs-12 col-sm-12">
                    <?php
                    echo $this->render('/widgets/applied-applications/users-card', [
                        'applied_applications' => $applied_applications,
                        'type' => 'internships'
                    ]); ?>

                    <div class="portlet light nd-shadow">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=" icon-social-twitter font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Interview Processes'); ?><span
                                            data-toggle="tooltip"
                                            title="Here you will find all existing interview processes"><i
                                                class="fa fa-info-circle"></i></span></span>
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
                </div>
            </div>
        </div>
    </div>
    <div class="pos-relative">
        <?= $this->render('/widgets/college-list-modal')?>
    </div>

<?php
$this->registerCss('
.total-intern{
    background: linear-gradient(145deg, #1e21f4, #43c7f0);
}
.total-inter{
    background: linear-gradient(145deg, #f41ea0, #f08143);
}
.total-qne{
    background: linear-gradient(145deg, #1ea4f4, #4ed0d0);
}
.total-apply{
    background: linear-gradient(145deg, #3cc4a4, #43f0d0);
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
.create-new-i a {
	background: #00a0e3;
	color: #fff;
	border-radius: 6px;
	padding: 5px 25px;
	font-family: roboto;
	font-size: 20px;
}
.padd-top-20{
    padding-top:30px;
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
/*-------*/
.font-dark > span > i {
    font-size: 13px;
    margin-left: 5px;
    color:darkgray;
}
.quick > img{
    height:38px;
}
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
@media only screen and (max-width: 450px) {
  .viewall-jobs {
    margin-bottom:5px;
  }
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
.loader
{
    display:none;
    position:fixed;
    top:50%;
    left:50%;
    padding:2px;
    z-index:99999;
}
.mt-action-author a{
    color: #000;
}
.mt-actions .mt-action .mt-action-body .mt-action-row .mt-action-buttons {
    width:170px;
}
');
$script = <<<JS
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