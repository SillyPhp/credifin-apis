<?php

use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="loader"><img
            src='https://gifimage.net/wp-content/uploads/2017/09/ajax-loading-gif-transparent-background-4.gif'/></div>
<section>
    <div class="row">
        <div class="col-md-12">
            <!--            <div class="col-md-3">-->
            <!--                --><? //=
            //                Html::button('Upload CV', ['value' => URL::to('/account/upload-cv'), 'class' => 'btn btn-primary custom-buttons',
            //                    'url' => Url::to('/' . Yii::$app->controller->id . '/' . 'upload-cv'),
            //                    'id' => 'uploadcv',
            //                    'data-toggle' => 'modal',
            //                    'data-target' => '#addprofile',
            //                ]);
            //                ?><!--   -->
            <!--            </div>-->
            <div class="col-md-2 col-md-offset-2">
                <a class="btn btn-primary custom-buttons job_btn" href="/account/jobs/application">
                    Create Quick Job
                </a>
            </div>
            <div class="col-md-2">
                <a class="btn btn-primary custom-buttons job_btn" href="/account/jobs/application">
                    Create AI Job
                </a>
            </div>
            <div class="col-md-2">
                <a class="btn btn-primary custom-buttons job_btn" href="/account/jobs/application">
                    Create Tweet Job
                </a>
            </div>
            <div class="col-md-2">
                <a class="btn btn-primary custom-buttons questionnaire_btn" href="/account/questionnaire">
                    Create Questionnaire
                </a>
            </div>
            <div class="col-md-2">
                <a class="btn btn-primary custom-buttons interview_btn" href="/account/process-flow">
                    Create Interview Process
                </a>
            </div>
        </div>
    </div>
</section>

<div class="row widget-row">
    <div class="col-md-3 col-sm-6">
        <a href="#">
            <div class="box-des box3 mt">
                <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/internship.png') ?>">
                <span class="count">100+</span>
                <span class="box-text">Total Job Openings</span>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6">
        <a href="#">
            <div class="box-des box6 mt">
                <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/intrnship.png') ?>">
                <span class="count">100+</span>
                <span class="box-text">Total Process</span>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6">
        <a href="#">
            <div class="box-des box5 mt">
                <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/candidateplaced.png') ?>">
                <span class="count">100+</span>
                <span class="box-text">Total Questionnaire</span>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-6">
        <a href="#">
            <div class="box-des box4 mt box2set">
                <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/candidates.png') ?>">
                <span class="count">20</span>
                <span class="box-text">Total Employees</span>
            </div>
        </a>
    </div>
</div>

<?php
$total_applications = count($employerApplications);
?>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light active_jobs">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Active Jobs</span>
                </div>
                <div class="actions">
                    <div class="btn-group dashboard-button">
                        <a href="/account/view-jobs" title="" class="viewall-jobs">View All</a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="hr-company-box">
                            <div class="rt-bttns">
                                <a onclick="window.open('<?= Url::to('/account/jobs/edit/' . $employerApplications[$next]["application_enc_id"]); ?>', '_blank');"
                                   class="j-edit" type="button">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a href=""
                                   onclick="window.open('<?= Url::to('/account/jobs/clone/' . $employerApplications[$next]["application_enc_id"]); ?>', '_blank');"
                                   class="j-clone share_btn">
                                    <i class="fa fa-clone"></i>
                                </a>
                                <button type="button" class="j-delete"
                                        value="<?= $employerApplications[$next]['application_enc_id']; ?>">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="lf-bttn">
                                <a href=""
                                   onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=http%3A//www.eygb.me/job/' . $employerApplications[$next]["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-fb share_btn" type="button">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a href=""
                                   onclick="window.open('<?= Url::to('https://twitter.com/home?status=http%3A//www.eygb.me/job/' . $employerApplications[$next]["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-twitter share_btn" type="button">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a href=""
                                   onclick="window.open('<?= Url::to('mailto:?&body=http%3A//www.eygb.me/job/' . $employerApplications[$next]["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-email share_btn" type="button">
                                    <i class="fa fa-envelope-o"></i>
                                </a>
                                <a href=""
                                   onclick="window.open('<?= Url::to('https://wa.me/?text=http%3A//www.eygb.me/job/' . $employerApplications[$next]["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-whatsapp share_btn" type="button">
                                    <i class="fa fa-whatsapp"></i>
                                </a>
                                <a href=""
                                   onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=http%3A//www.eygb.me/job/' . $employerApplications[$next]["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-linkedin share_btn" type="button">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </div>
                            <a href="#">
                                <div class="hr-com-icon">
                                    <img src="" class="img-responsive ">
                                </div>
                                <div class="hr-com-name">title name</div>
                                <div class="hr-com-field">total Openings</div>
                            </a>
                            <div class="hr-com-jobs">
                                <div class="col-md-6 minus-15-pad"> Applications</div>
                                <div class="col-md-6 minus-15-pad j-grid"><a href="#" title="">VIEW JOB</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light all_questionnaire">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">All Questionnaire </span>
                </div>
                <div class="actions">
                    <div class="btn-group dashboard-button">
                        <a href="/account/questionnaire" title="" class="viewall-jobs">Add New</a>
                        <a href="/account/view-questionnaire" title="" class="viewall-jobs">View All</a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <!--                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_actions_pending">-->
                <!-- BEGIN: Actions -->
                <div class="mt-actions">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="padding-left">
                                <div class="manage-jobs-sec">
                                    <div class="cat-sec">
                                        <div class="row no-gape">
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="p-category">
                                                    <div class="rt-bttns">
                                                        <button class="clone-bttn clone_questionnaire"
                                                                type="button"
                                                                onclick="window.open('<?= Url::to('/account/questionnaire/clone/' . $organizationQuestionnaire[$next]["id"]); ?>', '_blank');">
                                                            <i class="fa fa-clone"></i>
                                                        </button>
                                                        <button class="edit-bttn edit_questionnaire"
                                                                type="button"
                                                                onclick="window.open('<?= Url::to('/account/questionnaire/edit/' . $organizationQuestionnaire[$next]["id"]); ?>', '_blank');">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </button>
                                                    </div>
                                                    <div class="lt-bttn">
                                                        <button type="button"
                                                                class="e-bttn delete_questionnaire"
                                                                value="<?= $organizationQuestionnaire[$next]['id']; ?>">
                                                            <i class="fa fa-trash-o"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <a href="/account/questionnaire-view/<?= $organizationQuestionnaire[$next]['id']; ?>"
                                                       title="" target="_blank">
                                                        <i class="fa fa-file-text"></i>
                                                        <span>questionnaire_name</span>
                                                        <p>questionnaire_for</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="p-category">
                                                    <div class="rt-bttns">
                                                        <button class="clone-bttn clone_questionnaire"
                                                                type="button"
                                                                onclick="window.open('<?= Url::to('/account/questionnaire/clone/' . $organizationQuestionnaire[$next]["id"]); ?>', '_blank');">
                                                            <i class="fa fa-clone"></i>
                                                        </button>
                                                        <button class="edit-bttn edit_questionnaire"
                                                                type="button"
                                                                onclick="window.open('<?= Url::to('/account/questionnaire/edit/' . $organizationQuestionnaire[$next]["id"]); ?>', '_blank');">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </button>
                                                    </div>
                                                    <div class="lt-bttn">
                                                        <button type="button"
                                                                class="e-bttn delete_questionnaire"
                                                                value="<?= $organizationQuestionnaire[$next]['id']; ?>">
                                                            <i class="fa fa-trash-o"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <a href="/account/questionnaire-view/<?= $organizationQuestionnaire[$next]['id']; ?>"
                                                       title="" target="_blank">
                                                        <i class="fa fa-file-text"></i>
                                                        <span>questionnaire_name</span>
                                                        <p>questionnaire_for</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="p-category">
                                                    <div class="rt-bttns">
                                                        <button class="clone-bttn clone_questionnaire"
                                                                type="button"
                                                                onclick="window.open('<?= Url::to('/account/questionnaire/clone/' . $organizationQuestionnaire[$next]["id"]); ?>', '_blank');">
                                                            <i class="fa fa-clone"></i>
                                                        </button>
                                                        <button class="edit-bttn edit_questionnaire"
                                                                type="button"
                                                                onclick="window.open('<?= Url::to('/account/questionnaire/edit/' . $organizationQuestionnaire[$next]["id"]); ?>', '_blank');">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </button>
                                                    </div>
                                                    <div class="lt-bttn">
                                                        <button type="button"
                                                                class="e-bttn delete_questionnaire"
                                                                value="<?= $organizationQuestionnaire[$next]['id']; ?>">
                                                            <i class="fa fa-trash-o"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <a href="/account/questionnaire-view/<?= $organizationQuestionnaire[$next]['id']; ?>"
                                                       title="" target="_blank">
                                                        <i class="fa fa-file-text"></i>
                                                        <span>questionnaire_name</span>
                                                        <p>questionnaire_for</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="p-category">
                                                    <div class="rt-bttns">
                                                        <button class="clone-bttn clone_questionnaire"
                                                                type="button"
                                                                onclick="window.open('<?= Url::to('/account/questionnaire/clone/' . $organizationQuestionnaire[$next]["id"]); ?>', '_blank');">
                                                            <i class="fa fa-clone"></i>
                                                        </button>
                                                        <button class="edit-bttn edit_questionnaire"
                                                                type="button"
                                                                onclick="window.open('<?= Url::to('/account/questionnaire/edit/' . $organizationQuestionnaire[$next]["id"]); ?>', '_blank');">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </button>
                                                    </div>
                                                    <div class="lt-bttn">
                                                        <button type="button"
                                                                class="e-bttn delete_questionnaire"
                                                                value="<?= $organizationQuestionnaire[$next]['id']; ?>">
                                                            <i class="fa fa-trash-o"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <a href="/account/questionnaire-view/<?= $organizationQuestionnaire[$next]['id']; ?>"
                                                       title="" target="_blank">
                                                        <i class="fa fa-file-text"></i>
                                                        <span>questionnaire_name</span>
                                                        <p>questionnaire_for</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="portlet light interview_processes">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"> Interview Processes </span>
                </div>
                <div class="actions">
                    <div class="btn-group dashboard-button">
                        <a href="/account/process-flow" title="" class="viewall-jobs">Add New</a>
                        <a href="/account/view-process" title="" class="viewall-jobs">View All</a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <!--                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_actions_pending">-->
                <!-- BEGIN: Actions -->
                <div class="mt-actions">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="padding-left">
                                <div class="manage-jobs-sec">
                                    <div class="cat-sec">
                                        <div class="row no-gape">
                                            <div class="col-lg-6 col-md-6 col-sm-6 catbox">
                                                <div class="p-category" id="p-cat">
                                                    <div class="lt-bttn">
                                                        <button class="edit-bttn" type="button">
                                                            <i class="fa fa-pencil-square-o"></i>
                                                        </button>
                                                        <button type="button" class="e-bttn">
                                                            <i class="fa fa-trash-o"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <a href="/account/process-view?id=<?= $process_list[$next]['process_id']; ?>"
                                                       title="">
                                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/execution.png') ?>">
                                                        <span>process_name</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--                    </div>
                                </div>-->
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light view_applications">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">View Applications</span>
                </div>
                <div class="actions">
                    <div class="btn-group dashboard-button">
                        <a href="/account/view-jobs" title="" class="viewall-jobs">View All</a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <!--                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_actions_pending">-->
                <!-- BEGIN: Actions -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="mt-actions">
                            <?php if (!empty($candidates_app)) { ?>
                                <?php foreach ($candidates_app as $candiates) { ?>
                                    <div class="mt-action">
                                        <div class="mt-action-img" style="width: auto">
                                            <a href="/user/<?= $candiates['username'] ?>">
                                                <?php if (!empty($candiates['image_location']) && !empty($candiates['image'])) { ?>
                                                    <?php $user_img = Yii::$app->params->upload_directories->users->image . $candiates['image_location'] . DIRECTORY_SEPARATOR . $candiates['image']; ?>
                                                    <img src="<?= $user_img; ?>" width="50px" height="50"
                                                         class="img-circle"/>

                                                <?php } else { ?>
                                                    <canvas class="user-icon img-circle"
                                                            name="<?= $candiates['first_name'] . ' ' . $candiates['last_name'] ?>"
                                                            width="50" height="50" font="25px"></canvas>
                                                <?php }
                                                ?>
                                            </a>

                                        </div>
                                        <div class="mt-action-body">
                                            <div class="mt-action-row">
                                                <div class="mt-action-info ">
                                                    <div class="mt-action-details ">
                                                        <span class="mt-action-author"><a
                                                                    href="/site/candidate-profile"><?= $candiates['first_name'] . ' ' . $candiates['last_name']; ?></a></span>
                                                        <p class="mt-action-desc">Applied
                                                            For <?= $candiates['name']; ?></p>
                                                    </div>
                                                </div>
                                                <div class="mt-action-buttons">
                                                    <div class="btn-group btn-group-circle">
                                                        <button type="button"
                                                                data-key="<?= $candiates['applied_application_enc_id'] ?>"
                                                                class="btn btn-outline green btn-sm approv_btn">Approve
                                                        </button>
                                                        <button type="button"
                                                                data-key="<?= $candiates['applied_application_enc_id'] ?>"
                                                                class="btn btn-outline red btn-sm reject_btn">Reject
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <h3>No Applications To Display</h3>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!--                    </div>
                                </div>-->
            </div>
        </div>
    </div>
    <!--                                    </div>
                                    </div>-->
</div>

<!-- Modal -->

<div class="modal fade" id="addprofile" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body load-modal">
                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>"
                     alt="<?= Yii::t('account', 'Loading'); ?>" class="loading">
                <span> &nbsp;&nbsp;<?= Yii::t('account', 'Loading'); ?>... </span>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addprofile" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body load-modal">
                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>"
                     alt="<?= Yii::t('account', 'Loading'); ?>" class="loading">
                <span> &nbsp;&nbsp;<?= Yii::t('account', 'Loading'); ?>... </span>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.box1{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1job.png");}
.box2{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1company.png");}
.box3{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1internship.png");}
.box4{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1institute.png");}
.box5{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1school.png");}
.box6{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/college.png");}
.box7{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/g.png");}
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
.e-bttn {
	background: transparent;
	border: none;
	color: #d75946;
	padding: 5px 10px 5px 10px;
	position: absolute;
	display: none;
	right: 5px;
}
.edit-bttn {
	background: transparent;
	border: none;
	color: #65c97a;
	padding: 6px 10px 4px 10px;
	position: absolute;
	display: none;
	right: 30px;
}
.clone-bttn {
	background: transparent;
	border: none;
	color: #55659c;
	padding: 5px 10px 5px 10px;
	position: absolute;
	display: none;
	right: 60px;
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
.mt-actions .mt-action .mt-action-body .mt-action-row .mt-action-buttons {
    width:170px;
}
//*:focus{
//    outline:none !important;
//}
.mt-action-author a{
    color:#000;
}

//.intl-tel-input {
//    width: 100%;
//}
//.thumbnail{
//    padding: 0px !important;
//    margin: 20px auto 25px auto !important;
//}
//.thumbnail img{
//    width: 100%;
//    height: 100%;
//}
//.js-title-step span{
//    display:none;
//}
//.btn.btn-outline.orange {
//    border-color: #ff7803;
//    color: #ff7803;
//    background: 0 0;
//}
//.btn.btn-outline.orange.active, .btn.btn-outline.orange:active, .btn.btn-outline.orange:active:focus,
//.btn.btn-outline.orange:active:hover, .btn.btn-outline.orange:focus, 
//.btn.btn-outline.orange:hover {
//    border-color: #ff7803;
//    color: #fff;
//    background-color: #ff7803;
//}
//.manage-jobs-sec .extra-job-info {
//    border: 2px solid #e8ecec;
//    padding: 20px 30px;
//    margin-left: 30px;
//    
//    -webkit-border-radius: 8px;
//    -moz-border-radius: 8px;
//    -ms-border-radius: 8px;
//    -o-border-radius: 8px;
//    border-radius: 8px;
//}
//.manage-jobs-sec .extra-job-info > span {
//    float: left;
//    width: 32.334%;
//    padding: 0;
//    border: none;
//    margin: 0;
//}
//.manage-jobs-sec > table {
//    float: left;
//    width: calc(100% - 30px);
//    margin-top: 50px;
//    margin-bottom: 60px;
//    margin-left: 30px
//}
//.manage-jobs-sec > table thead tr td {
//    font-size: 15px;
//    font-weight: bold;
//    color: #fb236a;
//    padding-bottom: 14px;
//}
//.manage-jobs-sec > table thead {
//    border-bottom: 1px solid #e8ecec;
//}
');
$script = <<<JS

    
$(document).on("click", "#uploadcv", function () {
    $(".load-modal").load($(this).attr("url"));
});
    
 
$(document).on('click','.share_btn',function(e)
    {
       e.preventDefault();
    })
        
       
var intro = introJs();

intro.setOptions({
  steps: [
    {
      element: document.querySelector('.job_btn'),
      intro: "This is the section where you can create the jobs.",
      disableInteraction: true
    },
    {
      element: document.querySelector('.questionnaire_btn'),
      intro: "This is the section where you can create the questionnaire.",
      position: 'bottom'
    },
    {
      element: document.querySelector('.interview_btn'),
      intro: "This is the section where you can schedule the interviews.",
      position: 'bottom'
    },
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
    {
      element: document.querySelector('.active_jobs'),
      intro: 'This displays the active jobs.',
      position: 'top'
    },
    {
      element: document.querySelector('.all_questionnaire'),
      intro: "This displays all the questionnaire.",
      position: 'right'
    },
    {
      element: document.querySelector('.view_applications'),
      intro: "This displays all the applications.",
      position: 'left'
    },
    {
      element: document.querySelector('.interview_processes'),
      intro: 'This displays all the processes.',
      disableInteraction: true
    }
  ]
});

intro.start();
    
$(document).on('click', '.approv_btn', function() {
    $(this).prop("disabled","true");
    var key = $(this).attr('data-key');  
    var btn = $(this);
    var parent = $(this).closest('.mt-action');
       
   $.ajax({
       url:'/account/approve',
       data:{key:key},
       method:'POST',
           
       success:function(data)
           {
            if(data==true)
                {
                  parent.fadeOut(500);
                }
            else
            {
               alert('something went wrong..');
                btn.prop("disabled","false");
            }
          }
       }) 
});
    
$(document).on('click', '.reject_btn', function() {
    $(this).prop("disabled","true");
    var key = $(this).attr('data-key');  
    var btn = $(this);
    var parent = $(this).closest('.mt-action');
   $.ajax({
       url:'/account/reject',
       data:{key:key},
       method:'POST',
           
       success:function(data)
           {
            if(data==true)
            {
              parent.fadeOut(500);
            }
            else
            {
               alert('something went wrong..');
                btn.prop("disabled","false");
            }
          }
       }) 
});            
        
$(document).on('click','.j-delete',function(e)
       {
         e.preventDefault();
         if (window.confirm("Do you really want to Delete the current Application?")) { 
            var data = $(this).attr('value');
            url = "/account/jobs/delete-application";
            pjax_container = "#pjax_active_jobs";
            Ajax_delete(data,url,pjax_container);
        }
       }) 
           
    $(document).on('click','.delete_questionnaire',function(e)
       {
          e.preventDefault();
         if (window.confirm("Do you really want to Delete the current Application?")) { 
            var data = $(this).attr('value');
            url = "/account/delete-questionnaire";
            pjax_container = "#pjax_active_questionnaire";
            Ajax_delete(data,url,pjax_container);
        }
       }) 

 function Ajax_delete(data,url,pjax_container)
        {
          $.ajax({
                url:url,
                data:{data:data},
                method:'post',
                beforeSend:function(){
                    $(".loader").css("display", "block");
                  },
                success:function(data)
                    {
                      if(data==true)
                        {
                          $(".loader").css("display", "none");
                          $.pjax.reload({container: pjax_container, async: false});
                        }
                       else
                       {
                          alert('Something went wrong.. !');
                       }
                     }
              })
        }
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
$this->registerCssFile('@backendAssets/global/css/plugins.min.css');
$this->registerCssFile('@backendAssets/global/css/components.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@vendorAssets/tutorials/css/introjs.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@vendorAssets/tutorials/js/intro.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);


function used_for($n)
{
    switch ($n) {
        case 1:
            $a = 'Jobs';
            break;
        case 2:
            $a = 'Internships';
            break;
        case 3:
            $a = 'Training Programs';
            break;
        default:
            $a = 'NA';
    }
    return $a;
}

?>
<script type="text/javascript">
    //                                    function del(this){
    //                                       var catb = document.querySelector('.catbox');
    //                                        catb.remove();
    //                                        console.log(catb);
    //                                    }
    //                                    function del(event){
    ////                                        var catb = document.querySelector('.catbox');
    //                                        var chose = document.getElementsByClassName("catbox");
    //                                        console.log("length :",chose.length );
    //
    //                                        for (var i=0; i<= chose.length; i++){
    //                                            var chose = chose[i];
    //                                            chose.onclick = function(){
    //                                                console.log("clicked", chose);
    //                                            }
    //                                        }
    ////                                              event.target.parentNode.parentNode.parentNode.remove();
    ////                                         console.log(catb);
    //
    //                                    }
</script>