<?php
use borales\extensions\phoneInput\PhoneInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

    <div class="row">
        <div class="col-md-6 col-md-offset-6">
            <div class="col-md-3">
                <a class="btn btn-primary custom-buttons" href="/account/jobs/create">
                    Create quick Job
                </a>
            </div>
            <div class="col-md-3">
                <a class="btn btn-primary custom-buttons" href="/account/jobs/create">
                    Create Job
                </a>
            </div>
            <div class="col-md-3">
                <?=
                Html::button('Add New Candidate', [
                    'class' => 'btn btn-primary custom-buttons',
                    'url' => Url::to('/' . Yii::$app->controller->id . '/' . 'add-candidate-profile'),
                    'id' => 'add-new-cand',
                    'data-toggle' => 'modal',
                    'data-target' => '#add-new-candidate',
                ]);
                ?>
            </div>
            <div class="col-md-3">
                <?=
                Html::button('Add New Company', [
                    'class' => 'btn btn-primary custom-buttons modal-load-class',
                    'id' => 'add-new-company',
                    'value' => URL::to('/account/recruiter/add-new-company')
                   ]);
                ?>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-md-3">
        <?= $this->render('/widgets/tasks/taskbar-card'); ?>
    </div>
    <div class="col-md-9">
        <div class="widget-row">
            <div class="col-md-4 col-sm-6">
                <a href="#">
                    <div class="box-des box1 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/company.png') ?>">
                        <span class="count">10</span>
                        <span class="box-text">Total Companies</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="#">
                    <div class="box-des box3 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/internship.png') ?>">
                        <span class="count">100+</span>
                        <span class="box-text">Total Job Openings</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="#">
                    <div class="box-des box6 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/intrnship.png') ?>">
                        <span class="count">100+</span>
                        <span class="box-text">Total Internships</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="#">
                    <div class="box-des box4 mt box2set">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/candidates.png') ?>">
                        <span class="count">20</span>
                        <span class="box-text">Application Received</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="#">
                    <div class="box-des box5 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/candidateplaced.png') ?>">
                        <span class="count">100+</span>
                        <span class="box-text">Total Candidates Placed</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="#">
                    <div class="box-des box7 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/jobopportunities.png') ?>">
                        <span class="count">100+</span>
                        <span class="box-text">Total No. of Opportunities</span>
                    </div>
                </a>
            </div>
        </div>
        <div>
            <div class="col-xs-12 col-sm-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class=" icon-social-twitter font-dark hide"></i>
                            <span class="caption-subject font-dark bold uppercase">Company Profiles</span>
                        </div>
                        <div class="actions">
                            <div class="btn-group dashboard-button">
                                <a href="/account/hr/company" title="" class="viewall-jobs">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_actions_pending">
                                <div class="row">
                                    <div class="mt-actions " style="">
                                        <div id="companies_lst">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="col-xs-12 col-sm-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <i class=" icon-social-twitter font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase">Manage Job</span>
                            </div>
                            <div class="actions">
                                <div class="btn-group dashboard-button">
                                    <a href="/account/hr/manage-all-jobs" title="" class="viewall-jobs">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_actions_pending">
                                    <div class="mt-actions " style="">
                                        <div class="mt-action">
                                            <div class="mt-action-body">
                                                <div class="mt-action-row">
                                                    <div class="mt-action-info ">
                                                        <div class="mt-action-details mt-new">
                                                            <span class="mt-action-author ">Job Details</span>
                                                        </div>
                                                    </div>
                                                    <div class="mt-action-datetime mt-jh">
                                                        Company Name
                                                    </div>
                                                    <div class="mt-action-datetime mt-jh">
                                                        No. of Applications
                                                    </div>
                                                    <div class="mt-action-datetime mt-jh">
                                                        <span class="mt-action-date">Closing Date</span>
                                                    </div>
                                                    <div class="mt-action-buttons ">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-action">
                                            <div class="mt-action-img">
                                                <img src="<?= Url::to('@backendAssets/layouts/layout/img/avatar3.jpg'); ?>"/>
                                            </div>
                                            <div class="mt-action-body">
                                                <div class="mt-action-row">
                                                    <div class="mt-action-info ">
                                                        <div class="mt-action-details  mt-jb">
                                                            <div class="mt-action-author">Web Developer</div>
                                                            <div class="mt-action-field">in Information Technology</div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-action-datetime set-color">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="mt-action-datetime ">
                                                        3
                                                    </div>
                                                    <div class="mt-action-datetime ">
                                                        <span class="mt-action-date">3 jun</span>
                                                    </div>
                                                    <div class="mt-action-buttons ">
                                                        <button type="button" class="btn btn-outline orange btn-sm">View
                                                            Candidates
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-action">
                                            <div class="mt-action-img">
                                                <img src="<?= Url::to('@backendAssets/layouts/layout/img/avatar2.jpg'); ?>"/>
                                            </div>
                                            <div class="mt-action-body">
                                                <div class="mt-action-row">
                                                    <div class="mt-action-info ">
                                                        <div class="mt-action-details mt-jb">
                                                            <span class="mt-action-author">Business Developer</span>
                                                            <div class="mt-action-field">in Information Technology</div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-action-datetime set-color">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="mt-action-datetime ">
                                                        5
                                                    </div>
                                                    <div class="mt-action-datetime ">
                                                        <span class="mt-action-date">3 jun</span>
                                                    </div>
                                                    <div class="mt-action-buttons ">
                                                        <button type="button" class="btn btn-outline orange btn-sm">View
                                                            Candidates
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-action">
                                            <div class="mt-action-img">
                                                <img src="<?= Url::to('@backendAssets/layouts/layout/img/avatar4.jpg'); ?>"/>
                                            </div>
                                            <div class="mt-action-body">
                                                <div class="mt-action-row">
                                                    <div class="mt-action-info ">
                                                        <div class="mt-action-details mt-jb">
                                                            <span class="mt-action-author">Java Developer</span>
                                                            <div class="mt-action-field">in Information Technology</div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-action-datetime set-color">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="mt-action-datetime ">
                                                        5
                                                    </div>
                                                    <div class="mt-action-datetime ">
                                                        <span class="mt-action-date">3 jun</span>
                                                    </div>
                                                    <div class="mt-action-buttons ">
                                                        <button type="button" class="btn btn-outline orange btn-sm">View
                                                            Candidates
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-action">
                                            <div class="mt-action-img">
                                                <img src="<?= Url::to('@backendAssets/layouts/layout/img/avatar10.jpg'); ?>"/>
                                            </div>
                                            <div class="mt-action-body">
                                                <div class="mt-action-row">
                                                    <div class="mt-action-info ">
                                                        <div class="mt-action-details mt-jb">
                                                            <span class="mt-action-author">Business Developer</span>
                                                            <div class="mt-action-field">in Information Technology</div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-action-datetime set-color">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="mt-action-datetime ">
                                                        1
                                                    </div>
                                                    <div class="mt-action-datetime ">
                                                        <span class="mt-action-date">3 jun</span>
                                                    </div>
                                                    <div class="mt-action-buttons ">
                                                        <button type="button" class="btn btn-outline orange btn-sm">View
                                                            Candidates
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-action">
                                            <div class="mt-action-img">
                                                <img src="<?= Url::to('@backendAssets/layouts/layout/img/avatar3.jpg'); ?>"/>
                                            </div>
                                            <div class="mt-action-body">
                                                <div class="mt-action-row">
                                                    <div class="mt-action-info ">
                                                        <div class="mt-action-details mt-jb">
                                                            <span class="mt-action-author">Web Developer</span>
                                                            <div class="mt-action-field">in Information Technology</div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-action-datetime set-color">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="mt-action-datetime ">
                                                        10
                                                    </div>
                                                    <div class="mt-action-datetime ">
                                                        <span class="mt-action-date">3 jun</span>
                                                    </div>
                                                    <div class="mt-action-buttons ">
                                                        <button type="button" class="btn btn-outline orange btn-sm">View
                                                            Candidates
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-action">
                                            <div class="mt-action-img">
                                                <img src="<?= Url::to('@backendAssets/layouts/layout/img/avatar2.jpg'); ?>"/>
                                            </div>
                                            <div class="mt-action-body">
                                                <div class="mt-action-row">
                                                    <div class="mt-action-info ">
                                                        <div class="mt-action-details mt-jb">
                                                            <span class="mt-action-author">Web Developer</span>
                                                            <div class="mt-action-field">in Information Technology</div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-action-datetime set-color">
                                                        DSB Edu Tech
                                                    </div>
                                                    <div class="mt-action-datetime ">
                                                        10
                                                    </div>
                                                    <div class="mt-action-datetime ">
                                                        <span class="mt-action-date">3 jun</span>
                                                    </div>
                                                    <div class="mt-action-buttons ">
                                                        <button type="button" class="btn btn-outline orange btn-sm">View
                                                            Candidates
                                                        </button>
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
            <div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-modal-lg in" id="main-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif'); ?>"
                         alt="<?= Yii::t('account', 'Loading'); ?>" class="loading">
                    <span><?= Yii::t('account', 'Loading'); ?>... </span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-new-candidate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         style="padding-top:10%;">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="org-info">Candidate Information</span>
                </div>
                <div class="modal-body" id="list">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="cand-email">Email Address</span>
                        </div>
                        <div class="col-md-6">
                            <span class="cand-name">Name (Optional)</span>
                        </div>
                    </div>
                    <div class="add-new-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <input type="text" class="form-control" placeholder="name@example.com"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <input type="text" class="form-control" placeholder="optional"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 add-cand-set">
                        <div id="add-cand"><i class="fa fa-plus" style="padding-right:5px;"></i>Add Another</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="/account/jobs/create" class="btn btn-primary">Invite</a>
                </div>
            </div>
        </div>
    </div>
<?php
echo $this->render('/widgets/hr/companies_lst');
$this->registerCss('
.btn-outline{
    border-radius:0px 25px 25px 0 !important;
}
.btn-outline:hover{
    box-shadow: 0 0 9px 5px #eee !important;
}
.temp-field{position:relative;}
.remove-cand{
    position: absolute;
    right: 12px;
    top: 25px;
}
.add-cand-set{
    padding-left: 35px;
    color: cornflowerblue;
    cursor:pointer;
}
ul.ks-cboxtags {
    list-style: none;
    padding:0px;
}
.service-list{
  display: inline-block;
  min-width: 120px;
}
.service-list label{
    width: 100%;
    display: inline-block;
    background-color: rgba(255, 255, 255, .9);
    border: 2px solid rgba(139, 139, 139, .3);
    color: #333;
    border-radius: 4px;
    white-space: nowrap;
    margin: 3px 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all .2s;
}

.service-list label {
    padding: 8px 12px;
    cursor: pointer;
}

.service-list label::before {
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    font-family: \'Font Awesome 5 Free\';
    font-weight: 900;
    font-size: 12px;
    padding: 2px 6px 2px 2px;
    content: \'067\';
    transition: transform .3s ease-in-out;
}

.service-list input[type=\'checkbox\']:checked + label::before {
    content: \'00c\';
    transform: rotate(-360deg);
    transition: transform .3s ease-in-out;
}

.service-list input[type=\'checkbox\']:checked + label, .service-list label:hover {
    border: 2px solid #00a0e3;
    background-color: #00a0e3;
    color: #fff;
    transition: all .2s;
}

.service-list input[type=\'checkbox\'] {
  display: absolute;
}
.service-list input[type=\'checkbox\'] {
  position: absolute;
  opacity: 0;
}
.service-list input[type=\'checkbox\']:focus + label {
  border: 2px solid #00a0e3;
}
.align{text-align:center;}
.padd{padding-top:10px;}
.org-info{
    font-size:22px;    
}
.comp-logo img{
    width: 90px;
    height: 90px;
    border: 4px solid #fff;    
}
.btnsetnew{
    font-size: 13px !important;
	font-weight: 600 !important;
	text-transform: capitalize !important;
	border-radius: 2px !important;
	overflow: hidden !important;
	position: relative !important;
	user-select: none !important;
	padding: 6px 42px 6px !important    ; 
}
.no-padd{
    padding-left: 0px !important;
    padding-right: 0px !important;
}
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
    .mt-jb{padding-top:2px; padding-left:5px;}
    .mt-new{padding-top: 15px;padding-left: 45px;}
    .mt-jh{font-weight:600; color:#060606 !important;}
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
.hr-company-box{text-align:center;border:2px solid #eef1f5; background:#fff;padding:0px !important;
                    border-radius:10px !important; margin-bottom:20px; text-decoration:none; }
.hr-company-box:hover{border-color:#fff; box-shadow:0 0 20px rgb(0,0,0,.3); transition:.3s all;
                        text-decoration:none;} 
.hr-company-box > div:hover {text-decoration:none;}                       
.hr-com-icon{ text-align:left !important; text-decoration:none;  vertical-align:middle; padding:10px 15px;}
.hr-com-icon img{text-align:center; margin:0; max-width:150px;  max-height:150px; }
.hr-com-name{color:#00a0e3; text-decoration:none; font-size:16px;text-align:left;padding-left:15px;} 
.hr-com-name:hover{text-decoration:none;}                                   
.hr-com-field{padding-top:2px; padding-bottom:10px; font-size:14px; color:#080808;text-align:left;padding-left:15px;height:30px;}
.hr-com-jobs{font-size:13px; color:#080808; text-align:center;  
              margin-top:10px; border-top:1px solid #eef1f5;}            
.openings{
    font-size:13px;
    text-transform:capitalize;
    color:#aaaaaa;
    text-align:center;
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
	text-align: left;
	padding-left: 10px;
	padding-bottom: 11px;
	display:inline-block;
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
.mt-action-field {
	color: #ccc7c7;
	font-size: 14px;
}
.set-color{color: #2f2626 !important    ;}
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
.custom-buttons{
    width:100%;
    font-size: 10px !important;
    padding: 8px 0px !important;
    margin-bottom:20px;
}
a:hover{
    text-decoration:none;
}
.btn.btn-outline.orange {
    border-color: #00A0E3;
    color: #00A0E3;
    background: 0 0;
}
.btn.btn-outline.orange.active, .btn.btn-outline.orange:active, .btn.btn-outline.orange:active:focus, .btn.btn-outline.orange:active:hover, .btn.btn-outline.orange:focus, .btn.btn-outline.orange:hover {
    border-color: #00A0E3;
    color: #fff;
    background-color: #00A0E3;
}

.com-logo {
    float: left;
    text-align: center;
   max-height:100px;
}
.com-logo img {
    float: none;
    display: inline-block;
    max-width: 100px;;
    max-height:100px;
    
}
.job-lctn {
 
    vertical-align: middle;
    font-family: open Sans;
    font-size: 13px;
    color: #888888;
    line-height: 23px;
    
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
.minus-15-pad{padding-left:0px !important; padding-right: 0px !important;}
.manage-jobs-sec > h3 {
    float: left;
    width: 100%;
    margin-top: 40px;
    font-size: 20px;
    color: #202020;
    font-weight: bold;
    margin: 0;
    margin-top: 0px;
    padding-bottom: 20px;
    padding-left: 30px;
    margin-top: 40px;
}
.manage-jobs-sec {
    float: left;
    width: 100%;
    padding:20px 10px;
}
.manage-jobs-sec .extra-job-info {
    border: 2px solid #e8ecec;
    padding: 20px 30px;
    margin-left: 30px;
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

}
.manage-jobs-sec .extra-job-info > span {
    float: left;
    width: 32.334%;
    padding: 0;
    border: none;
    margin: 0;
}
.manage-jobs-sec > table {
    float: left;
    width: calc(100% - 30px);
    margin-top: 50px;
    margin-bottom: 60px;
    margin-left: 30px
}
.manage-jobs-sec > table thead tr td {
    font-size: 15px;
    font-weight: bold;
    color: #fb236a;
    padding-bottom: 14px;
}
.manage-jobs-sec > table thead {
    border-bottom: 1px solid #e8ecec;
} 
.cat-sec {
    float: left;
    width: 100%;
}
.p-category {
    float: left;
    width: 100%;
    z-index: 1;
    position: relative;
}
.p-category > a {
    float: left;
    width: 100%;
    text-align: center;
    padding-bottom: 30px;
    border-bottom: 1px solid #e8ecec;
    border-right: 1px solid #e8ecec;
}
.p-category > a i {
    float: left;
    width: 100%;
    color: #00a0e3;
    font-size: 40px;
   margin:50px 0 0 0 !important;
}
.p-category > a span {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 15px;
    color: #202020;
    margin-top: 18px;
}
.p-category > a p {
    float: left;
    width: 100%;
    font-size: 13px;
    margin: 0;
        margin-top: 0px;
    margin-top: 3px;
}
.p-category:hover a {
    border-color: #ffffff;
    transition: .3s all;
    -webkit-transition: .3s all;
    -moz-transition: .3s all;
    -o-transition: .3s all;
}
.p-category:hover {
    background: #ffffff;
      transition: .2s all;
    -webkit-transition: .2s all;
    -moz-transition: .2s all;
    -o-transition: .2s all;
    
    -webkit-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -moz-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -ms-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -o-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    box-shadow: 0px 0px 25px rgba(0,0,0,0.1);

    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

   width: 104%; 
   margin-left: -2%;
   height: 102%;
   z-index: 10;

}
.row.no-gape{
  margin: 0;
}
.row.no-gape > div{
  padding: 0;
}
html .card-featured-primary {
    border-color: #0088CC;
}
.card-featured-primary {
    border-color: #CCC;
}
.card-featured-left {
    border-left: 3px solid #CCC;
}
.card {
    background: transparent;
    -webkit-box-shadow: none;
    box-shadow: none;
}
.card-body {
    background: #fdfdfd;
    -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    border-radius: 5px;
}
.widget-summary {
    display: table;
    width: 100%;
}
.widget-summary .widget-summary-col.widget-summary-col-icon {
    width: 1%;
}
.widget-summary .widget-summary-col {
    display: table-cell;
    vertical-align: top;
    width: 100%;
}
.widget-summary .summary-icon {
    margin-right: 15px;
    width: 90px;
    height: 90px;
    line-height: 90px;
    font-size: 51.2px;
    font-size: 3.2rem;
    text-align: center;
    color: #fff;
    border-radius: 55px;
}
html .bg-primary, html .background-color-primary {
    background-color: #0088CC !important;
}
.widget-summary .summary {
    min-height: 65px;
    word-break: break-all;
}
.widget-summary .summary-footer {
    padding: 5px 0 0;
    border-top: 1px dotted #ddd;
    text-align: right;
}
.widget-summary .summary .title {
    margin: 0;
    font-size: 14.4px;
    font-size: 0.9rem;
    color: #333;
    font-weight: 500;
    line-height: 1.5;
}
.widget-summary .summary .info {
    font-size: 13.6px;
    font-size: 0.85rem;
}
.widget-summary .summary {
    min-height: 65px;
    word-break: break-all;
}
.widget-summary .summary .amount {
    margin-right: .2em;
    font-weight: 600;
    color: #333;
    vertical-align: middle;
    font-size: 22.4px;
    font-size: 1.4rem;
}
.widget-summary .summary .info span {
    vertical-align: middle;
}
.text-muted {
    color: #999 !important;
}
.text-uppercase {
    text-transform: uppercase !important;
}
.mb-3{
    margin-bottom: 1rem !important;
}
.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-clip: border-box;
    border-radius: 0.25rem;
}
.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
   margin-bottom:20px;
}
html .card-featured-secondary {
    border-color: #E36159;
}
html .bg-secondary, html .background-color-secondary {
    background-color: #E36159 !important;
}
html .card-featured-tertiary {
    border-color: #2BAAB1;
}
html .bg-tertiary, html .background-color-tertiary {
    background-color: #2BAAB1 !important;
}
html .card-featured-quaternary {
    border-color: #383f48;
}
html .bg-quaternary, html .background-color-quaternary {
    background-color: #383f48 !important;
}
html .card-transparent > .card-header {
    background: none;
    border: 0;
    padding-left: 0;
    padding-right: 0;
}
.card-header {
    border-radius: 5px 5px 0 0 !important;
    padding: 18px;
    background-color: #e7eaed !important;
    padding-left: 18px !important;
    position: relative;
}
html .card-transparent > .card-header .card-actions {
    right: 0;
}
.card-actions {
    position: absolute;
    top: 15px;
}
.card-title {
    color: #33353F;
    font-size: 20px;
    font-weight: 400;
    line-height: 20px;
    padding: 0;
    text-transform: none;
    margin: 0;
}
html .card-transparent > .card-header + .card-body {
    border-radius: 5px;
}
html .card-transparent > .card-body {
    padding: 0;
    background: transparent;
    -webkit-box-shadow: none;
    box-shadow: none;
}
.card-header.bg-primary {
    background: #CCC;
    color: #FFF;
    border-bottom: 0 none;
    border-right: 0 none;
}
ul.widget-todo-list {
    list-style: none;
    padding: 0;
    margin: 0;
    position: relative;
}
ul.widget-todo-list li {
    border-bottom: 1px dotted #ddd;
    padding: 15px 15px 15px 0;
    position: relative;
}
ul.widget-todo-list li .checkbox-custom {
    margin-bottom: 0;
}
.checkbox-custom {
    position: relative;
    padding: 0 0 0 25px;
    margin-top: 0;
}
.checkbox-custom input[type="checkbox"] {
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 3px;
    margin: -6px 0 0 0;
    z-index: 2;
    cursor: pointer;
}
ul.widget-todo-list li .checkbox-custom label {
    padding-left: 10px;
}
.checkbox-custom label {
    cursor: pointer;
    margin-bottom: 0;
    text-align: left;
    line-height: 1.5;
}
ul.widget-todo-list li .todo-actions {
    position: absolute;
    top: 14px;
    right: 0;
    bottom: 14px;
}
ul.widget-todo-list li .todo-actions .todo-remove {
    font-size: 10px;
    vertical-align: middle;
    color: #999;
}
.checkbox-custom label:before {
    content:"";
    position: absolute;
    top: 50%;
    left: 0;
    margin-top: -9px;
    width: 19px;
    height: 18px;
    display: inline-block;
    border-radius: 2px;
    border: 1px solid #bbb;
    background: #fff;
}
.checkbox-custom input[type="checkbox"]:checked + label:after {
    position: absolute;
    display: inline-block;
    font-family: "FontAwesome";
    content: "\F00C";
    top: 50%;
    left: 4px;
    margin-top: -5px;
    font-size: 11px;
    line-height: 1;
    width: 16px;
    height: 16px;
    color: #333;
}
ul.widget-todo-list li label.line-through span {
    text-decoration: line-through;
}
.line-pass{
    text-decoration: line-through;
}
.widget-profile-info .profile-picture {
    display: table-cell;
    vertical-align: middle;
    width: 1%;
}
.widget-profile-info .profile-picture img {
    display: block;
    width: 100px;
    height: 100px;
    margin-right: 15px;
    border: 4px solid #fff;
    border-radius: 50px;
}
.font-weight-semibold {
    font-weight: 600 !important;
}
.widget-profile-info .profile-info .profile-footer {
    border-top-color: rgba(0, 170, 255, 0.7);
}
.widget-profile-info .profile-info .profile-footer {
    padding: 5px 0 0;
    border-top: 1px solid rgba(255, 255, 255, 0.6);
    text-align: right;
}
.widget-profile-info .profile-info .profile-footer a {
    color: #fff;
    opacity: 0.6;
}
.card-header {
    margin-bottom: 0;
    background-color: rgba(0, 0, 0, 0.03);
}
.widget-profile-info .profile-info {
    display: table-cell;
    vertical-align: bottom;
    width: 100%;
    color: #FFF;
}
.content-body.card-margin .card {
    margin-top: 40px;
}
.form-wizard {
    margin-bottom: 20px;
}
.card {
    background: transparent;
    -webkit-box-shadow: none;
    box-shadow: none;
    border: none;
}
.form-wizard .tabs {
    margin-bottom: 0;
}

.tabs {
    border-radius: 4px;
    margin-bottom: 20px;
}
.nav-tabs {
    margin: 0;
    padding: 0;
    border-bottom-color: #EEE;
}

.nav-tabs {
    border-bottom: 1px solid #ddd;
}
.nav {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
}
.nav-tabs .nav-item {
    margin-bottom: -1px;
}
html body .tabs .nav-tabs li.active .nav-link, html.dark body .tabs .nav-tabs li.active .nav-link {
    border-top-color: #0088CC;
    color: #0088CC;
}
.tabs .nav-tabs li.active .nav-link, html.dark body .tabs .nav-tabs li.active .nav-link {
    border-top-color: #0088CC;
    color: #0088CC;
}
.tabs .nav-tabs .nav-link, html.dark body .tabs .nav-tabs .nav-link, html body .tabs .nav-tabs .nav-link:hover, html.dark body .tabs .nav-tabs .nav-link:hover {
    color: #0088CC;
}
.tabs .nav-tabs .nav-link, html.dark body .tabs .nav-tabs .nav-link, html body .tabs .nav-tabs .nav-link:hover, html.dark body .tabs .nav-tabs .nav-link:hover {
    color: #0088CC;
}
.nav-tabs li.active .nav-link, .nav-tabs li.active .nav-link:hover, .nav-tabs li.active .nav-link:focus {
    background: #FFF;
    border-left-color: #EEE;
    border-right-color: #EEE;
    border-top: 3px solid #CCC;
    color: #CCC;
}
.nav-tabs li .nav-link, .nav-tabs li .nav-link:hover {
    background: #F4F4F4;
    border-bottom: none;
    border-left: 1px solid #EEE;
    border-right: 1px solid #EEE;
    border-top: 3px solid #EEE;
    color: #CCC;
}
.nav-tabs li .nav-link {
    border-radius: 5px 5px 0 0;
    font-size: 14px;
    margin-right: 1px;
}
.nav-tabs .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}
.text-center {
    text-align: center !important;
}
.nav-link {
    display: block;
    padding: 0.5rem 1rem;
}
.wizard-steps > li.active .badge {
    background-color: #0088CC;
}
.nav-tabs li .nav-link .badge {
    border-radius: 100%;
    padding: 0.4rem 0.55rem;
    margin-right: 5px;
}
.badge-primary {
    background: #0088CC;
}
.badge {
    display: inline-block;
    padding: 0.25em 0.4em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}
.card-footer:last-child {
    border-radius: 0 0 calc(0.25rem - 1px) calc(0.25rem - 1px);
}
.card-footer {
    border-radius: 0 0 5px 5px;
    margin-top: -5px;
    background: #FFF;
}
.card-footer {
    padding:12px 20px;
    border-top: 1px solid rgba(0, 0, 0, 0.125);
}
.card-footer .pager {
    margin: 0;
    padding: 5px 0;
}
.pager {
    padding-left: 0;
    margin: 20px 0;
    list-style: none;
    text-align: center;
}
.pager li {
    display: inline;
}
.form-wizard ul.pager .disabled a {
    cursor: not-allowed;
}
.pager .disabled > a {
    color: #777777;
    background-color: #fff;
    cursor: not-allowed;
}
.pager .previous > a, .pager .previous > span {
    float: left;
}
.pager li > a, .pager li > span {
    display: inline-block;
    padding: 8px 14px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 15px;
}
.hidden {
    display: none !important;
}
.float-right {
    float: right !important;
}
.form-wizard ul.pager .next a, .form-wizard ul.pager .previous a, .form-wizard ul.pager .first a, .form-wizard ul.pager .last a, .form-wizard ul.pager .finish a {
    cursor: pointer;
}
.card-footer .pager::after {
    clear: both;
    content: "";
    display: table;
}
.card-footer::after {
    clear: both;
    content: "";
    display: table;
}
.form-wizard .tab-content {
    background: #FFF;
    border: 0 none;
    box-shadow: none;
}

.tab-content {
    border-radius: 0 0 4px 4px;
//    box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.04);
    background-color: #FFF;
//    border: 1px solid #EEE;
    border-top: 0;
//    padding: 30px;
}
.p-3 {
    padding: 1rem !important;
}
.viewall-jobs {
    background: #00a0e3;
    padding:8px 18px;
    color: #ffffff !important;
    font-family: Open Sans;
    font-size: 13px;
    
    -webkit-border-radius: 5px !important;
    -moz-border-radius: 5px !important;
    -ms-border-radius: 5px !important;
    -o-border-radius: 5px !important;
    border-radius: 5px !important;
}
.viewall-jobs:hover {
    -webkit-border-radius: 5px !important;
    -moz-border-radius: 5px !important;
    -ms-border-radius: 5px !important;
    -o-border-radius: 5px !important;
    border-radius: 5px !important;
    box-shadow:0 0 10px rgba(0,0,0,.5);
    color: #ffffff;
    text-decoration:none;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -ms-transition:.3s all;
    -o-transition:.3s all;
    
}
.bg-orange {
     background: #ff7803!important; 
}
.bg-gold {
     background: #ffd200!important; 
}
.bg-light-gold {
     background: #ff634d!important; 
}
.viewall-jobs:focus .viewall-jobs:visited{text-decoration:none;}
.modal::-webkit-scrollbar {display:none;}
.modal{overflow::-moz-scrollbars-none; -ms-overflow-style: none; }
@-moz-document url-prefix(){
   .modal{
        margin-right:-17px!important;
         overflow-y:scroll;
    }
}
');
$script = <<< JS
$('.todo-check').change(function () {
    if ($(this).prop("checked")) {
        $(this).closest('li').find('.todo-label').addClass('line-pass');
    } else {
        $(this).closest('li').find('.todo-label').removeClass('line-pass');
    }
});
$(document).on('click', '.modal-load-class', function() {
    $('#main-modal').modal('show').find('.modal-body').load($(this).attr('value'));   
});
$('.todo-remove').click(function (e) {
    $(this).closest('li').remove();
    e.preventDefault();
});

fetch_companies_list($('#companies_lst'),limit=6,offset=0,id='EV8KoxNaQZzMJ5MM4mqvyp539GLgXD');
$(document).ready(function(){ 
  $("#add-cand").click(function(){
  var data = $('.add-new-form .row').html();
    $("#list").append('<div class="row temp-field">' + data + '<div class="remove-cand"><i class="fa fa-times"></i></div></div>');
  });
});
$(document).on('click', '.remove-cand', function(){
    $(this).parent('.temp-field').remove(); 
}); 
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
$this->registerCssFile('@backendAssets/global/css/plugins.min.css');
$this->registerCssFile('@backendAssets/global/css/components.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
