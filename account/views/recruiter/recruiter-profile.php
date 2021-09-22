<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\web\JsExpression;
use kartik\select2\Select2;
?>

<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Candidate Details</span>
                </div>
                <div class="actions">
                    <div class="btn-group dashboard-button">
                        <a href="" title="" class="viewall-jobs">View Profile</a>
                        <!--                        <a href="/account/manage-jobs" class="btn orange btn-outline btn-circle btn-sm" >
                                                    View All
                                                </a>-->
                    </div>
                </div> 
            </div> 
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_actions_pending">
                        <div class="mt-actions " style="" >
                            <div class="row">
                                <div class="col-md-2 col-sm-2">
                                    <div class="can-pic">
                                        <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg'); ?>" class="img-responsive img-thumbnail img-rounded"> 
                                    </div>
                                </div> 
                                <div class="col-md-3 col-sm-4"> 
                                    <div class="can-name">Natasha Kim</div>
                                    <div class="can-location"><i class="fa fa-map-marker"></i> Ludhiana</div>
                                    <div class="can-phone"><i class="fa fa-phone"></i> 123-456-789</div>
                                    <div class="can-mail"><i class="fa fa-envelope"></i> yourmailid@dummymail.com</div>
                                    <div class="current-job">Current Job</div>
                                    <div class="can-field">Web Designer <span>at</span> Dsb Edu Tech</div>
                                    <div class="can-field">Unemployed</div>
                                </div> 
                                <div class="col-md-4 col-sm-3">
                                    <div class="ch-heading">Perferences</div>
                                    <div class="p-location can-pref"><span>Location :</span> Ludhiana, Chandigarh, Mohali, Delhi</div>
                                    <div class="p-salary can-pref"><span>Salary :</span> 15,000-20,000</div>
                                    <div class="p-position can-pref"><span>Designation :</span> Sr. Web Designer</div>
                                    <div class="p-joining can-pref"><span>Joining Time :</span> Immediate</div>
                                </div> 
                                <div class="col-md-3 col-sm-3">
                                    <div class="ch-heading">Skills</div>
                                    <div class="can-skills">HTML<span>,</span> Javascript<span>,</span>
                                        Php<span>,</span>  Photoshop<span>,</span>  Bootstrap<span>,</span> 
                                        Media Queris</div>  
                                </div>
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
                    <span class="caption-subject font-dark bold uppercase">Interview Schedule</span>
                </div>
                <div class="actions">
                    <div class="btn-group dashboard-button">
                        <a href="" title="" class="viewall-jobs">Schedule Interview</a>
                    </div>
                </div> 
            </div> 
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_actions_pending">
                        <div class="mt-actions " style="" >
                            <div class="row"> 
                                <div class="col-md-3 col-sm-4">
                                    <a href="/site/job-detail-new">
                                        <div class="hr-company-box"> 
                                            <div class="com-logo">
                                                <img src="<?= Url::to('@commonAssets/logos/text-logo.png'); ?>" >
                                            </div>
                                            <div class="hr-com-name">
                                                Empower Youth
                                            </div>
                                            <div class="com-i-field">
                                                Web Developer
                                            </div>
                                            <div class="com-jobs">
                                                <div class="date">31st December 2018</div>
                                            </div>
                                            <div class="com-i-timing">
                                                <i class="fa fa-clock-o"></i> 5PM
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-4">
                                    <a href="/site/job-detail-new">
                                        <div class="hr-company-box"> 
                                            <div class="com-logo">
                                                <img src="<?= Url::to('@commonAssets/logos/logo-horizontal.svg'); ?>" >
                                            </div>
                                            <div class="hr-com-name">
                                                Empower Youth
                                            </div>
                                            <div class="com-i-field">
                                                Web Developer
                                            </div>
                                            <div class="com-jobs">
                                                <div class="date">31st December 2018</div>
                                            </div>
                                            <div class="com-i-timing">
                                                <i class="fa fa-clock-o"></i> 5PM
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-4">
                                    <a href="/site/job-detail-new"> 
                                        <div class="hr-company-box"> 
                                            <div class="com-logo">
                                                <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg'); ?>" >
                                            </div>
                                            <div class="hr-com-name">
                                                Empower Youth
                                            </div>
                                            <div class="com-i-field">
                                                Web Developer
                                            </div>
                                            <div class="com-jobs">
                                                <div class="date">31st December 2018</div>
                                            </div>
                                            <div class="com-i-timing">
                                                <i class="fa fa-clock-o"></i> 5PM
                                            </div>
                                        </div>
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
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Suggested Jobs</span>
                </div>
                <div class="actions">
                    <div class="btn-group dashboard-button">
                        <!--<a href="" title="" class="viewall-jobs">View Profile</a>-->
                    </div>
                </div> 
            </div> 
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_actions_pending">
                        <div class="mt-actions " style="" >
                            <div class="row">
                                <div class="col-md-3 col-sm-4">
                                    <a href="/site/job-detail-new"> 
                                        <div class="hr-company-box">
                                            <div class="hr-com-icon">
                                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/icon1.png'); ?>" class="img-responsive ">
                                            </div>
                                            <div class="hr-com-name">
                                                Empower Youth
                                            </div>
                                            <div class="hr-com-field">
                                                Marketing Director
                                            </div>
                                            <div class="hr-com-jobs">
                                                <div class="col-md-12 minus-15-pad"> 10 Openings</div>
<!--                                                <div class="col-md-6 minus-15-pad"> 4 Shortlisted</div>-->
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-4">
                                    <a href="/site/job-detail-new"> 
                                        <div class="hr-company-box">
                                            <div class="hr-com-icon">
                                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/icon1.png'); ?>" class="img-responsive ">
                                            </div>
                                            <div class="hr-com-name">
                                                Empower Youth
                                            </div>
                                            <div class="hr-com-field">
                                                Marketing Director
                                            </div>
                                            <div class="hr-com-jobs">
                                                <div class="col-md-12 minus-15-pad"> 10 Openings</div>
<!--                                                <div class="col-md-6 minus-15-pad"> 4 Shortlisted</div>-->
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-4">
                                    <a href="/site/job-detail-new"> 
                                        <div class="hr-company-box">
                                            <div class="hr-com-icon">
                                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/icon1.png'); ?>" class="img-responsive ">
                                            </div>
                                            <div class="hr-com-name">
                                                Empower Youth
                                            </div>
                                            <div class="hr-com-field">
                                                Marketing Director
                                            </div>
                                            <div class="hr-com-jobs">
                                                <div class="col-md-12 minus-15-pad"> 10 Openings</div>
<!--                                                <div class="col-md-6 minus-15-pad"> 4 Shortlisted</div>-->
                                            </div>
                                        </div>
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
<?php
$this->registerCss('  
.hr-company-box{
    text-align:center;
    border:2px solid #eef1f5; 
    background:#fff; 
    padding:20px 10px 10px 10px;
    border-radius:14px !important;
    margin-bottom:20px;
    text-decoration:none;
}
.hr-company-box:hover{
    border-color:#fff;
    box-shadow:0 0 20px rgb(0,0,0,.3);
    transition:.3s all;
    text-decoration:none;
} 
.hr-company-box > div:hover {
    text-decoration:none;
} 
.hr-com-jobs{
    font-size:13px;
    color:#080808;
    padding:10px 0 15px; 
    margin-top:10px;
    border-top:1px solid #eef1f5;
} 
.com-logo{
    text-align:center; 
    text-decoration:none; 
    vertical-align:middle;
    padding:20px 0;
    height:100px;
}
.com-logo img{
    text-align:center;
    top:50%;
    position:relative;
    max-width:100px !important;
    max-height:100px !important; 
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
}
.hr-com-name{
    color:#00a0e3; 
    padding-top:10px;
    text-decoration:none;
    font-size:16px;
} 
.hr-com-name:hover{
    text-decoration:none;
}
.com-i-field{
     font-size:14px;
    color:#080808;
}
.com-i-timing{
    padding-top:2px; 
    font-weight:bold;
    font-size:14px;
    color:#080808;
}
.com-jobs{
    font-size:13px; 
    color:#00a0e3;
    padding:10px 0px 0 0 ; 
    margin-top:10px;
    border-top:1px solid #eef1f5;
}            
.pad-top-10{
    padding-top:10px;
}
    
/*candidate details*/ 
.can-skills span{
    color:#00a0e3;
    font-weight:bold;
    font-size:18px;
}
.p-location{
    padding-top:5px;  
}
.can-pref span{
    font-weight:bold;  
    padding-right:5px;
}
.ch-heading{
    font-size:18px;
    text-transform:uppercase;
    font-weight:bold;
}
.can-pic{
    max-width:150px;
}
.can-name{
    font-weight:bold;
    font-size:18px;
    text-transform:uppercase;
}
.can-location{
    padding-top:5px;
}
.can-location i, .can-phone i, .can-mail i{
    color:#00a0e3;
    padding-right: 5px;
}
.current-job{
   padding-top: 20px;
   text-transform: uppercase;
   font-weight: bold;
}
.can-field{
    color:#00a0e3;
}
.can-field span{
    color:#333;
}
/*candidate details ends*/    
/* Application process css starts */
.m-widget4 .m-widget4__item {
    display: table;
    padding-top: 1.15rem;
    padding-bottom: 1.25rem;
}
.m-widget4__item {
    border-bottom: 0.07rem dashed #ebedf2;
}
.m-widget4 .m-widget4__item .m-widget4__img {
    display: table-cell;
    vertical-align: middle;
}
.m-widget4 .m-widget4__item .m-widget4__img.m-widget4__img--pic img {
    width: 10rem;
//    border-radius: 50%;
}
.m-widget4.m-widget4--progress .m-widget4__info {
    width: 50%;
}
.m-widget4 .m-widget4__item .m-widget4__info {
    display: table-cell;
    padding-left: 1.2rem;
    padding-right: 1.2rem;
    font-size: 1rem;
    vertical-align: middle;
}
.m-widget4 .m-widget4__item .m-widget4__info .m-widget4__title {
    font-size: 15px;
    font-weight: 600;
    color: #575962;
}
.m-widget4 .m-widget4__item .m-widget4__info .m-widget4__sub {
    font-size: 11px;
    color: #7b7e8a;
}
.m-widget4.m-widget4--progress .m-widget4__progress {
    display: table-cell;
    vertical-align: middle;
    padding-left: 2rem;
    padding-right: 2rem;
    width: 50%;
}
.m-widget4.m-widget4--progress .m-widget4__progress .m-widget4__progress-wrapper .m-widget17__progress-number {
    font-size: 14px;
    font-weight: 600;
}
.m-widget4.m-widget4--progress .m-widget4__progress .m-widget4__progress-wrapper .m-widget17__progress-label {
    font-size: 11px;
    float: right;
    margin-top: 0.3rem;
}
.m-widget4.m-widget4--progress .m-widget4__progress .m-widget4__progress-wrapper .progress {
    display: block;
    margin-top: 0.8rem;
    height: 0.5rem;
}
.progress.m-progress--sm {
    height: 6px;
}
.progress {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    height: 1rem;
    overflow: hidden;
    font-size: .75rem;
    background-color: #e9ecef;
    border-radius: .25rem;
}
.progress-bar {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    background-color: #5867dd;
    -webkit-transition: width 0.6s ease;
    transition: width 0.6s ease;
}
.progress.m-progress--sm .progress-bar {
    border-radius: 3px;
}
.progress .progress-bar {
    -webkit-transition: all 0.5s ease;
    transition: all 0.5s ease;
}
.bg-danger {
    background-color: #f4516c !important;
}
.m-widget4 .m-widget4__item .m-widget4__ext {
    display: table-cell;
    vertical-align: middle;
}
.btn.btn-secondary {
    background: white !important;
    border-color: #ebedf2 !important;
    box-shadow:none !important;
    color: #212529;
    -webkit-transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out !important;
    transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out !important;
    transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out !important;
    transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out !important;
}
.btn.m-btn--pill {
    border-radius: 60px !important;
}
.m-portlet__body {
    color: #575962;
    padding: 0.0rem 2.2rem;
}
.m-widget4__item.m-widget4__item--last, .m-widget4__item:last-child {
    border-bottom: 0;
}
.btn.m-btn--hover-brand:hover, .btn.m-btn--hover-brand.active, .btn.m-btn--hover-brand:active, .btn.m-btn--hover-brand:focus, .show>.btn.m-btn--hover-brand.dropdown-toggle {
    border-color: #716aca !important;
    color: #fff !important;
    background-color: #716aca !important;
    box-shadow:none !important;
}
/* Application process css ends */
');
