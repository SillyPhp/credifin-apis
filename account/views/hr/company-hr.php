<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;

?>
    <section>
        <div class="row">
            <div class="col-md-5 col-md-offset-7">
                <div class="col-md-4 col-md-offset-8">
                    <!--                <a class="btn btn-primary custom-buttons" href="/account/job-application-test">
                                        Create a Job
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
    </section>

    <div class="row widget-row">
        <div class="col-md-12">
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
                        <span class="box-text">Looking For Candidates</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="#">
                    <div class="box-des box3 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/internship.png') ?>">
                        <span class="count">100+</span>
                        <span class="box-text">Total Job Openings</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Company Profiles</span>
                    </div>
                    <div class="actions">
                        <!--                        <div class="btn-group dashboard-button">
                                                   
                                                </div>-->
                    </div>
                </div
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_actions_pending">
                            <!-- BEGIN: Actions -->
                            <div class="row pad-top-10 comrow1">
                                <div class="col-md-12">
                                    <div class="col-md-3 col-sm-6">
                                        <div class="topic-con">
                                            <div class="hr-company-box">
                                                <a href="/account/hr/company-dashboard">
                                                    <div class="hr-com-icon">
                                                        <img src="<?= Url::to('/assets/common/logos/logo-vertical.svg'); ?>"
                                                             class="img-responsive ">
                                                    </div>
                                                    <div class="hr-com-name">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="hr-com-field">
                                                        Tech Firm
                                                    </div>
                                                    <div class="overlay">
                                                        <div class="text-o">View Dashboard</div>
                                                    </div>
                                                </a>
                                                <div class="openings">10 Openings</div>
                                                <div class="jobcount">7 jobs, 3 Internships</div>
                                                <div class="j-grid"><a
                                                            href="/site/company-profile" title="">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="topic-con">
                                            <div class="hr-company-box">
                                                <a href="/account/hr/company-dashboard">
                                                    <div class="hr-com-icon">
                                                        <img src="<?= Url::to('/assets/common/logos/logo-vertical.svg'); ?>"
                                                             class="img-responsive ">
                                                    </div>
                                                    <div class="hr-com-name">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="hr-com-field">
                                                        Tech Firm
                                                    </div>
                                                    <div class="overlay">
                                                        <div class="text-o">View Dashboard</div>
                                                    </div>
                                                </a>
                                                <div class="openings">10 Openings</div>
                                                <div class="jobcount">7 jobs, 3 Internships</div>
                                                <div class="j-grid"><a
                                                            href="/site/company-profile" title="">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="topic-con">
                                            <div class="hr-company-box">
                                                <a href="/account/hr/company-dashboard">
                                                    <div class="hr-com-icon">
                                                        <img src="<?= Url::to('/assets/common/logos/logo-vertical.svg'); ?>"
                                                             class="img-responsive ">
                                                    </div>
                                                    <div class="hr-com-name">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="hr-com-field">
                                                        Tech Firm
                                                    </div>
                                                    <div class="overlay">
                                                        <div class="text-o">View Dashboard</div>
                                                    </div>
                                                </a>
                                                <div class="openings">10 Openings</div>
                                                <div class="jobcount">7 jobs, 3 Internships</div>
                                                <div class="j-grid"><a
                                                            href="/site/company-profile" title="">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="topic-con">
                                            <div class="hr-company-box">
                                                <a href="/account/hr/company-dashboard">
                                                    <div class="hr-com-icon">
                                                        <img src="<?= Url::to('/assets/common/logos/logo-vertical.svg'); ?>"
                                                             class="img-responsive ">
                                                    </div>
                                                    <div class="hr-com-name">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="hr-com-field">
                                                        Tech Firm
                                                    </div>
                                                    <div class="overlay">
                                                        <div class="text-o">View Dashboard</div>
                                                    </div>
                                                </a>
                                                <div class="openings">10 Openings</div>
                                                <div class="jobcount">7 jobs, 3 Internships</div>
                                                <div class="j-grid"><a
                                                            href="/site/company-profile" title="">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="topic-con">
                                            <div class="hr-company-box">
                                                <a href="/account/hr/company-dashboard">
                                                    <div class="hr-com-icon">
                                                        <img src="<?= Url::to('/assets/common/logos/logo-vertical.svg'); ?>"
                                                             class="img-responsive ">
                                                    </div>
                                                    <div class="hr-com-name">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="hr-com-field">
                                                        Tech Firm
                                                    </div>
                                                    <div class="overlay">
                                                        <div class="text-o">View Dashboard</div>
                                                    </div>
                                                </a>
                                                <div class="openings">10 Openings</div>
                                                <div class="jobcount">7 jobs, 3 Internships</div>
                                                <div class="j-grid"><a
                                                            href="/site/company-profile" title="">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="topic-con">
                                            <div class="hr-company-box">
                                                <a href="/account/hr/company-dashboard">
                                                    <div class="hr-com-icon">
                                                        <img src="<?= Url::to('/assets/common/logos/logo-vertical.svg'); ?>"
                                                             class="img-responsive ">
                                                    </div>
                                                    <div class="hr-com-name">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="hr-com-field">
                                                        Tech Firm
                                                    </div>
                                                    <div class="overlay">
                                                        <div class="text-o">View Dashboard</div>
                                                    </div>
                                                </a>
                                                <div class="openings">10 Openings</div>
                                                <div class="jobcount">7 jobs, 3 Internships</div>
                                                <div class="j-grid"><a
                                                            href="/site/company-profile" title="">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="topic-con">
                                            <div class="hr-company-box">
                                                <a href="/account/hr/company-dashboard">
                                                    <div class="hr-com-icon">
                                                        <img src="<?= Url::to('/assets/common/logos/logo-vertical.svg'); ?>"
                                                             class="img-responsive ">
                                                    </div>
                                                    <div class="hr-com-name">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="hr-com-field">
                                                        Tech Firm
                                                    </div>
                                                    <div class="overlay">
                                                        <div class="text-o">View Dashboard</div>
                                                    </div>
                                                </a>
                                                <div class="openings">10 Openings</div>
                                                <div class="jobcount">7 jobs, 3 Internships</div>
                                                <div class="j-grid"><a
                                                            href="/site/company-profile" title="">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="topic-con">
                                            <div class="hr-company-box">
                                                <a href="/account/hr/company-dashboard">
                                                    <div class="hr-com-icon">
                                                        <img src="<?= Url::to('/assets/common/logos/logo-vertical.svg'); ?>"
                                                             class="img-responsive ">
                                                    </div>
                                                    <div class="hr-com-name">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="hr-com-field">
                                                        Tech Firm
                                                    </div>
                                                    <div class="overlay">
                                                        <div class="text-o">View Dashboard</div>
                                                    </div>
                                                </a>
                                                <div class="openings">10 Openings</div>
                                                <div class="jobcount">7 jobs, 3 Internships</div>
                                                <div class="j-grid"><a
                                                            href="/site/company-profile" title="">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="topic-con">
                                            <div class="hr-company-box">
                                                <a href="/account/hr/company-dashboard">
                                                    <div class="hr-com-icon">
                                                        <img src="<?= Url::to('/assets/common/logos/logo-vertical.svg'); ?>"
                                                             class="img-responsive ">
                                                    </div>
                                                    <div class="hr-com-name">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="hr-com-field">
                                                        Tech Firm
                                                    </div>
                                                    <div class="overlay">
                                                        <div class="text-o">View Dashboard</div>
                                                    </div>
                                                </a>
                                                <div class="openings">10 Openings</div>
                                                <div class="jobcount">7 jobs, 3 Internships</div>
                                                <div class="j-grid"><a
                                                            href="/site/company-profile" title="">View Profile</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="com-load-more-btn">
                            <button type="button" id="comloadmore" class="btn blue">Load More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal -->

    <div class="modal fade" id="add-new" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body">
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
.topic-con{
position:relative;
width:100%;
// border:1px solid #eee;
border-radius:2px;
text-align: center;
font-size:18px; 
color:#fff;
text-transform: uppercase;
}
    .overlay {
  position: absolute;
  top: 0px;
  left: 0;
  right: 0;
  background-color: rgba(158, 161, 162, 0.57);
  overflow: hidden;
  width: 100%;
  height: 0;
  transition: .3s ease;
}
.topic-con:hover .overlay {
  height: 76%;
  border-radius:10px 10px 0px 0px !important;
}
.text-o {
  color:#fff ;
  font-size: 15px;
//  background:#fff;
  padding:5px 10px;
  position: absolute;
  top: 60% !important;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  white-space: nowrap;
}

.btn-primary {
    background-color: #0088CC;
    border-color: #0088CC #0088CC #006699;
    color: #FFF;
}
.custom-buttons{
    width:100%;
    font-size: 10px !important;
    padding: 8px 0px !important;
    margin-bottom:20px;
}    
a:hover{
    text-decoration:none;
}
.dashboard-button a, .dashboard-button button{    
    margin-left:10px !important;
}
.intl-tel-input {
    width: 100%;
}

.thumbnail{
    padding: 0px !important;
    margin: 20px auto 25px auto !important;
}
.thumbnail img{
    width: 100%;
    height: 100%;
}
.js-title-step span{
    display:none;
}
.hr-company-box{text-align:center;border:2px solid #eef1f5; background:#fff;padding:0px !important;
                    border-radius:10px !important; margin-bottom:20px; text-decoration:none; }
.hr-company-box:hover{border-color:#fff; box-shadow:0 0 20px rgb(0,0,0,.3); transition:.3s all;
                        text-decoration:none;} 
.hr-company-box > div:hover {text-decoration:none;}                 
.hr-com-icon{ text-align:left !important; text-decoration:none;  vertical-align:middle; padding:10px 15px;}
.hr-com-icon img{text-align:center; margin:0; max-width:150px;  max-height:150px; }
.hr-com-name{color:#00a0e3; text-decoration:none; font-size:16px;text-align:left;padding-left:15px;} 
.hr-com-name:hover{text-decoration:none;}                                   
.hr-com-field{padding-top:2px; padding-bottom:10px; font-size:14px; color:#080808;text-align:left;padding-left:15px;}
.hr-com-jobs{font-size:13px; color:#080808; text-align:center;  
              margin-top:10px; border-top:1px solid #eef1f5;}       
.openings{
    font-size:13px;
    text-transform:capitalize;
    color:#aaaaaa;
    text-align:left;
    padding-left:15px;
}
.jobcount{
    font-size:12px;
    text-transform:capitalize;
    color:#aaaaaa;
    text-align:left;
    padding-left:15px;
    }
.pad-top-10{padding-top:10px;}
.hr-com-view{ text-align:right;  }
.hr-com-view > .num-vac{border:2px solid #b7b2b2;padding:4px 8px; color:#b7b2b2;
                    border-radius:20px !important; font-weight:bold;}
.com-load-more-btn{text-align:center; padding-top:30px; }
.open{padding:10px;font-size:12px;font-family:roboto;}
.j-grid {
	text-align: right;
	padding-right: 10px;
	margin-top: -36px;
	padding-bottom: 11px;
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
    border-radius: 4px !important;
    margin:5px 0;
    padding: 6px 12px;  
}
.job-grid > a:hover {
    background: #00a0e3 !important;
    color: #ffffff;
    transition: all 0.4s ease 0s;
}
/*jobs hunt css*/

.com-logo {
    float: left;
    text-align: center;
    min-height:115px;
}
.com-logo img {
    float: none;
    display: inline-block;
    width: 150px;;
    height:115px;
    
}
.job-lctn {
    display: table-cell;
    vertical-align: middle;
    font-family: open Sans;
    font-size: 13px;
    color: #888888;
    line-height: 23px;
    width: 25%;
}
.job-lctn i {
    font-size: 24px;
    float: left;
    margin-right: 7px;
}
.fav-job {
    display: table-cell;
    vertical-align: middle;
    font-size: 25px;
    color: #888888;
    line-height: 10px;
    text-align: center;
    cursor: pointer;
}
.fav-job-active{
 color:#00a0e3 !important;
}

');
$script = <<<JS
$(document).on("click", "#open-modal", function () {
    $(".modal-body").load($(this).attr("url"));
});
        
  $(document).on('click','#comloadmore', function(){
       $('.comrow1:first').clone().appendTo('.tab-pane');     
   }); 
       
$('.fav-job').on('click', function(){
        $(this).toggleClass('fav-job-active');
    });        
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
$this->registerCssFile('@backendAssets/global/css/plugins.min.css');
$this->registerCssFile('@backendAssets/global/css/components.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
