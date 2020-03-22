<?php

use borales\extensions\phoneInput\PhoneInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>

    <div class="row">
        <div class="col-md-6 col-md-offset-6">
            <div class="col-md-3">
                <a class="btn btn-primary custom-buttons" href="/account/jobs/create">
                    Create quick Job
                </a>
            </div>
            <div class="col-md-3">
                <a class="btn btn-primary custom-buttons" href="/account/jobs/hr-application">
                    Create Job
                </a>
            </div>
            <div class="col-md-3">
                <?=
                Html::button('Add New Candidate', [
                    'class' => 'btn btn-primary custom-buttons',
                    'url' => Url::to('/' . Yii::$app->controller->id . '/' . 'add-candidate-profile'),
                    'id' => 'addpro',
                    'data-toggle' => 'modal',
                    'data-target' => '#addprofile',
                ]);
                ?>
            </div>
            <div class="col-md-3">
                <!--      <a class="btn btn-primary custom-buttons" href="/account/companies">
                                   Add new company
                                </a>-->
                <?=
                Html::button('Add New Company', [
                    'class' => 'btn btn-primary custom-buttons',
                    'url' => Url::to('/' . Yii::$app->controller->id . '/' . 'company-form'),
                    'id' => 'open-modal',
                    'data-toggle' => 'modal',
                    'data-target' => '#add-new',
                ]);
                ?>
            </div>
        </div>
    </div>

    <div class="row widget-row">
        <div class="col-md-12">
            <div class="col-md-3 col-sm-6">
                <a href="#">
                    <div class="box-des box3 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/internship.png') ?>">
                        <span class="count">100+</span>
                        <span class="box-text">Total Active Jobs</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="#">
                    <div class="box-des box1 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/company.png') ?>">
                        <span class="count">10</span>
                        <span class="box-text">Total Companies</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="#">
                    <div class="box-des box6 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/intrnship.png') ?>">
                        <span class="count">100+</span>
                        <span class="box-text">Total Active Profiles</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="#">
                    <div class="box-des box4 mt box2set">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/candidates.png') ?>">
                        <span class="count">20</span>
                        <span class="box-text">Immediate Hiring</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
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
                <?php if (!empty($employerApplications)) { ?>
                    <div class="portlet-body">
                        <!--                    <div class="tab-content">
                                                <div class="tab-pane active" id="tab_actions_pending">-->
                        <?php
                        Pjax::begin(['id' => 'pjax_active_jobs']);
                        $rows = ceil($total_applications / 4);
                        $next = 0;
                        for ($i = 1; $i <= $rows; $i++) {
                            ?>
                            <div class="row">
                                <?php
                                for ($j = 0; $j < 4; $j++) {
                                    if ($next < $total_applications) {
                                        ?>
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
                                                <a href="/account/application-process?v=<?= $employerApplications[$next]['application_enc_id']; ?>">
                                                    <div class="hr-com-icon">
                                                        <img src="<?= Url::to('@commonAssets/categories/' . $employerApplications[$next]['title']["icon"]); ?>"
                                                             class="img-responsive ">
                                                    </div>
                                                    <div class="hr-com-name">
                                                        <?= $employerApplications[$next]['title']['name']; ?>
                                                    </div>
                                                    <div class="hr-com-field">
                                                        <?= $employerApplications[$next]['placementLocations'][0]['total']; ?>
                                                        Openings
                                                    </div>
                                                </a>
                                                <div class="hr-com-jobs">
                                                    <div class="col-md-6 minus-15-pad"> <?= sizeof($employerApplications[$next]['appliedApplications']); ?>
                                                        Applications
                                                    </div>
                                                    <div class="col-md-6 minus-15-pad j-grid"><a
                                                                href="/job/<?= $employerApplications[$next]['slug']; ?>"
                                                                title="">VIEW JOB</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    $next++;
                                }
                                ?>
                            </div>
                            <?php

                        }
                        ?>
                        <!--                        </div>
                                            </div>-->
                    </div>
                    <?php Pjax::end();
                } else { ?>
                    <h3>No active Jobs to display</h3>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light active_jobs">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Active Profiles</span>
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
                            <div class="hr-company-box" id="<?=  $employerApplications[$next]['application_enc_id']; ?>">
                                <div class="rt-bttns">
                                    <a onclick="window.open('<?= Url::to('/account/jobs/edit/' . $employerApplications[$next]["application_enc_id"]); ?>', '_blank');" class="j-edit" type="button">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                    <a href="" onclick="window.open('<?= Url::to('/account/jobs/clone/' . $employerApplications[$next]["application_enc_id"]); ?>', '_blank');"  class="j-clone share_btn">
                                        <i class="fa fa-clone"></i>
                                    </a>
                                    <button type="button" class="j-delete" value="<?= $employerApplications[$next]['application_enc_id']; ?>">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <div class="lf-bttn">
                                    <a href="" onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=http%3A//www.eygb.me/job/' . $employerApplications[$next]["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="j-fb share_btn" type="button">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                    <a href="" onclick="window.open('<?= Url::to('https://twitter.com/home?status=http%3A//www.eygb.me/job/' . $employerApplications[$next]["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="j-twitter share_btn" type="button">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                    <a href="" onclick="window.open('<?= Url::to('mailto:?&body=http%3A//www.eygb.me/job/' . $employerApplications[$next]["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');"  class="j-email share_btn"  type="button">
                                        <i class="fa fa-envelope-o"></i>
                                    </a>
                                    <a href="" onclick="window.open('<?= Url::to('https://wa.me/?text=http%3A//www.eygb.me/job/' . $employerApplications[$next]["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="j-whatsapp share_btn" type="button">
                                        <i class="fa fa-whatsapp"></i>
                                    </a>
                                    <a href="" onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=http%3A//www.eygb.me/job/' . $employerApplications[$next]["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="j-linkedin share_btn" type="button">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </div>
                                <!--<a href="/ricky/application-process">-->
                                <a href="/account/application-process?v=<?=  $employerApplications[$next]['application_enc_id']; ?>">
                                    <div class="hr-com-icon">
                                        <img src="<?= Url::to('@commonAssets/categories/' . $employerApplications[$next]['title']["icon"]); ?>" class="img-responsive ">
                                    </div>
                                    <div class="hr-com-name">title</div>
                                    <div class="hr-com-field">total Openings</div>
                                </a>
                                <div class="hr-com-jobs">
                                    <div class="col-md-6 minus-15-pad"> <?= sizeof($employerApplications[$next]['appliedApplications']); ?> Applications</div>
                                    <div class="col-md-6 minus-15-pad j-grid"><a href="/job/<?= $employerApplications[$next]['slug']; ?>" title="">VIEW JOB</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Companies</span>
                    </div>
                    <div class="actions">
                        <!--<div class="dashboard-button">-->
                        <a href="<?= Url::to('/account/shortlist-companies') ?>" title="" class="viewall-jobs">View
                            All</a>
                        <!--</div>-->
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-3 hr-j-box">
                            <div class="topic-con">
                                <div class="hr-company-box">
                                    <a href="/company/<?= $shortlist['slug']; ?>">
                                        <div class="hr-com-icon">
                                            <canvas class="user-icon" name="<?= $shortlist['org_name'] ?>"
                                            <img src="<?= Url::to($logo_image); ?>" class="img-responsive ">
                                        </div>
                                        <div class="hr-com-name">org_name</div>
                                        <div class="hr-com-field">industry</div>
                                    </a>
                                    <div class="hr-com-jobs">
                                        <div class="row">
                                            <div class="col-md-1 j-cross">
                                                <button value="<?= $shortlist['shortlisted_enc_id']; ?>"
                                                        class="rmv_org"><i class="fa fa-times"></i></button>
                                            </div>
                                            <div class="col-md-offset-3 col-md-6 minus-15-pad j-grid">
                                                <a href="/company/<?= $shortlist['slug']; ?>" title="">VIEW
                                                    PROFILE</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--                                --><?php
                        //                            }
                        //                        } else {
                        //                            ?>
                        <!--                            <div class="col-md-12">-->
                        <!--                                <div class="tab-empty">-->
                        <!--                                    <div class="tab-empty-icon">-->
                        <!--                                        <img src="--><?//= Url::to('@eyAssets/images/pages/dashboard/sr.png'); ?><!--"-->
                        <!--                                             class="img-responsive" alt=""/>-->
                        <!--                                    </div>-->
                        <!--                                    <div class="tab-empty-text">-->
                        <!--                                        <div class="">There are no companies to show,</div>-->
                        <!--                                        <div class="">You haven't added any company.</div>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                            --><?php
                        //                        }
                        //                        Pjax::end();
                        //                        ?>
                    </div>
                    <!-- END: Actions -->
                    <!--                    </div>
                                    </div>-->
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
.modal-footer{
    text-align:center;
} 
.tab-empty{
    padding:20px;
}
.tab-empty-icon img{
    max-width:200px; 
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
.overlay, .overlay1, .overlay2 {
  position: absolute;
  top: 0px;
  left: 0;
  right: 0;
  background: rgba(208, 208, 208, 0.5);
  overflow: hidden;
  width: 100%;
  height: 0;
  transition: .5s ease;
}
.loader{
    display:none;
    position:fixed;
    top:50%;
    left:50%;
    padding:2px;
    z-index:99999;
}
.topic-con:hover .overlay, .topic-con:hover .overlay1,.topic-con:hover .overlay2 {
  height: 80%;
  border-radius:10px 10px 0px 0px !important;
}
button.over-bttn, .ob1, button.over-bttn, .ob2{
    background:#00a0e3 !important; 
    border:2px solid #00a0e3; 
    border-radius:5px !important;
    padding:6px 12px;
    color:#fff;
}
button.over-bttn, .ob2{
    background:#ff7803 !important; 
}                  
.ob1:hover{
    background:#fff !important;
    color:#00a0e3; 
    transition:.3s all;
}                 
.ob2:hover{
    background:#fff !important; 
    color:#ff7803; 
    transition:.3s all;
}
.text-o {
    font-size: 14px;
    line-height:280px;
}
ul.tabs{
    margin: 0px;
    padding: 0px;
    list-style: none;
}
ul.tabs li{
    background: none;
    color: #222;
    display: inline-block;
    padding: 10px 15px;
    cursor: pointer;
}
.caption > ul.tabs > li.tab-link:hover{
    color:#00a0e3 !important;
}
.tab-con{
    display:none
}
.tab-con.current{
    display:inherit
}
.current{
    color:#00a0e3 !important; 
    transition:2s ease-out;
}
.tab-con.current{
    animation: slide-down 1s ease-out;
}
@keyframes slide-down {
    0% { opacity: 0; transform: translateY(100%); }
    100% { opacity: 1; transform: translateY(0); }
}
li.current{ 
    border-bottom:1px solid #00a0e3;
    transition:2s ease-out;
}
.mt-com-logo{
    padding-top:10px;
}
.btn.btn-outline.orange {
    border-color: #ff7803;
    color: #ff7803;
    background: 0 0;
}
.btn.btn-outline.orange.active, .btn.btn-outline.orange:active, .btn.btn-outline.orange:active:focus, .btn.btn-outline.orange:active:hover, .btn.btn-outline.orange:focus, .btn.btn-outline.orange:hover {
    border-color: #ff7803;
    color: #fff;
    background-color: #ff7803;
}
.hr-company-box{text-align:center;border:2px solid #eef1f5; background:#fff; padding:20px 10px;
                    border-radius:14px !important; margin-bottom:20px; text-decoration:none; }
.hr-company-box:hover{border-color:#fff; box-shadow:0 0 20px rgb(0,0,0,.3); transition:.3s all;
                        text-decoration:none;} 
.hr-company-box > div:hover {text-decoration:none;}                       
.hr-com-icon{ text-align:center; text-decoration:none;  vertical-align:middle; padding:20px 0;}
.hr-com-icon img{text-align:center; margin:0 auto; max-width:100px;  max-height:100px; }
.hr-com-name{color:#00a0e3; padding-top:10px;text-decoration:none; font-size:16px;} 
.hr-com-name:hover{text-decoration:none;}                                   
.hr-com-field{padding-top:2px; font-weight:bold;font-size:14px; color:#080808;}
.hr-com-jobs{font-size:13px; color:#080808; padding:10px 0 10px; 
              margin-top:10px; border-top:1px solid #eef1f5;}            
.pad-top-10{padding-top:10px;}
.minus-15-pad{padding-left:0px !important; padding-right:0px !important;}
.com-load-more-btn{text-align:center; padding-top:30px; }
a:hover{
    text-decoration:none;
}
.j-grid > a {
    font-family: Open Sans;
    font-size: 11px;
    color: #00a0e3;
    border: 1px solid #00a0e3;
    -webkit-border-radius: 20px !important;
    -moz-border-radius: 20px !important;
    -ms-border-radius: 20px !important;
    -o-border-radius: 20px !important;
    border-radius: 20px !important;
    margin:10px 0;
    padding: 6px 12px; 
    display:initial; 
}
.job-grid > a:hover {
    background: #00a0e3 !important;
    color: #ffffff;
    transition: all 0.4s ease 0s;
    text-decoration:none;
}                                 
#view-all{
    margin-top:5px;
}
');