<?php

use yii\helpers\Url;

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
        <?= $this->render('/widgets/tasks/taskbar-card'); ?>
        <?=
        $this->render('/widgets/services-selection/edit-services', [
            'model' => $model,
            'services' => $services,
        ]);
        ?>
    </div>
    <div class="col-md-9">
        <?php if (Yii::$app->user->identity->type->user_type == 'Individual'): ?>
            <?= $this->render('/widgets/applications/dashboard-applied-applications', [
                'applied' => $applied_app
            ]); ?>
        <?php elseif (Yii::$app->user->identity->organization): ?>
            <div class="portlet light portlet-fit">
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
                                <div class="how-icon"><img src="<?= Url::to('@eyAssets/images/pages/dashboard/create.svg') ?>"></div>
                                <div class="how-heading">Create a Job</div>
                                <div class="how-text"><p>Create a Job, get applications, let candidates fill Questionnaire.</p> 
                                    <p class="pera">Ask them what's relevant to your organization.</p>
                                </div>
                            </div>    
                        </div>
                        <div class="col-md-3">
                            <div class="how-box">
                                <div class="how-icon"><img src="<?= Url::to('@eyAssets/images/pages/dashboard/invite.svg') ?>"></div>
                                <div class="how-heading">Invite Candidates</div>
                                <div class="how-text"><p>Share application with candidates that you have found by any other means.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="how-box">
                                <div class="how-icon"><img src="<?= Url::to('@eyAssets/images/pages/dashboard/share.svg') ?>"></div>
                                <div class="how-heading">Compare Applicants</div>
                                <div class="how-text">
                                    <p>Compare different applicants on the basis of their skills, suitability, location, experience, expected salary, etc.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="how-box">
                                <div class="how-icon"><img src="<?= Url::to('@eyAssets/images/pages/dashboard/process.svg') ?>"></div>
                                <div class="how-heading">Process Applications</div>
                                <div class="how-text">Finalize the candidates that you would like to interview and schedule seamlessly.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
$this->registerCss("
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
/*how it works section css ends*/

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
    width: 4rem;
    border-radius: 50%;
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
    
//html .card-featured-primary {
//    border-color: #0088CC;
//}
//.card-featured-primary {
//    border-color: #CCC;
//}
//.card-featured-left {
//    border-left: 3px solid #CCC;
//}

//.widget-summary {
//    display: table;
//    width: 100%;
//}
//.widget-summary .widget-summary-col.widget-summary-col-icon {
//    width: 1%;
//}
//.widget-summary .widget-summary-col {
//    display: table-cell;
//    vertical-align: top;
//    width: 100%;
//}
//.widget-summary .summary-icon {
//    margin-right: 15px;
//    width: 90px;
//    height: 90px;
//    line-height: 90px;
//    font-size: 51.2px;
//    font-size: 3.2rem;
//    text-align: center;
//    color: #fff;
//    border-radius: 55px;
//}

//.widget-summary .summary {
//    min-height: 65px;
//    word-break: break-all;
//}
//.widget-summary .summary-footer {
//    padding: 5px 0 0;
//    border-top: 1px dotted #ddd;
//    text-align: right;
//}
//.widget-summary .summary .title {
//    margin: 0;
//    font-size: 14.4px;
//    font-size: 0.9rem;
//    color: #333;
//    font-weight: 500;
//    line-height: 1.5;
//}
//.widget-summary .summary .info {
//    font-size: 13.6px;
//    font-size: 0.85rem;
//}
//.widget-summary .summary {
//    min-height: 65px;
//    word-break: break-all;
//}
//.widget-summary .summary .amount {
//    margin-right: .2em;
//    font-weight: 600;
//    color: #333;
//    vertical-align: middle;
//    font-size: 22.4px;
//    font-size: 1.4rem;
//}
//.widget-summary .summary .info span {
//    vertical-align: middle;
//}
//.text-muted {
//    color: #999 !important;
//}
//.text-uppercase {
//    text-transform: uppercase !important;
//}

//html .card-featured-secondary {
//    border-color: #E36159;
//}
//html .bg-secondary, html .background-color-secondary {
//    background-color: #E36159 !important;
//}
//html .card-featured-tertiary {
//    border-color: #2BAAB1;
//}
//html .bg-tertiary, html .background-color-tertiary {
//    background-color: #2BAAB1 !important;
//}
//html .card-featured-quaternary {
//    border-color: #383f48;
//}
//html .bg-quaternary, html .background-color-quaternary {
//    background-color: #383f48 !important;
//} 
//
//html .card-transparent > .card-header .card-actions {
//    right: 0;
//}
//.card-actions {
//    position: absolute;
//    top: 15px;
//}


//.content-body.card-margin .card {
//    margin-top: 40px;
//}
//.form-wizard {
//    margin-bottom: 20px;
//}

//.form-wizard .tabs {
//    margin-bottom: 0;
//}

//.tabs {
//    border-radius: 4px;
//    margin-bottom: 20px;
//}
//.nav-tabs {
//    margin: 0;
//    padding: 0;
//    border-bottom-color: #EEE;
//}
//
//.nav-tabs {
//    border-bottom: 1px solid #ddd;
//}
//.nav {
//    display: -ms-flexbox;
//    display: flex;
//    -ms-flex-wrap: wrap;
//    flex-wrap: wrap;
//    padding-left: 0;
//    margin-bottom: 0;
//    list-style: none;
//}
//.nav-tabs .nav-item {
//    margin-bottom: -1px;
//}
//html body .tabs .nav-tabs li.active .nav-link, html.dark body .tabs .nav-tabs li.active .nav-link {
//    border-top-color: #0088CC;
//    color: #0088CC;
//}
//.tabs .nav-tabs li.active .nav-link, html.dark body .tabs .nav-tabs li.active .nav-link {
//    border-top-color: #0088CC;
//    color: #0088CC;
//}
//.tabs .nav-tabs .nav-link, html.dark body .tabs .nav-tabs .nav-link, html body .tabs .nav-tabs .nav-link:hover, html.dark body .tabs .nav-tabs .nav-link:hover {
//    color: #0088CC;
//}
//.tabs .nav-tabs .nav-link, html.dark body .tabs .nav-tabs .nav-link, html body .tabs .nav-tabs .nav-link:hover, html.dark body .tabs .nav-tabs .nav-link:hover {
//    color: #0088CC;
//}
//.nav-tabs li.active .nav-link, .nav-tabs li.active .nav-link:hover, .nav-tabs li.active .nav-link:focus {
//    background: #FFF;
//    border-left-color: #EEE;
//    border-right-color: #EEE;
//    border-top: 3px solid #CCC;
//    color: #CCC;
//}
//.nav-tabs li .nav-link, .nav-tabs li .nav-link:hover {
//    background: #F4F4F4;
//    border-bottom: none;
//    border-left: 1px solid #EEE;
//    border-right: 1px solid #EEE;
//    border-top: 3px solid #EEE;
//    color: #CCC;
//}
//.nav-tabs li .nav-link {
//    border-radius: 5px 5px 0 0;
//    font-size: 14px;
//    margin-right: 1px;
//}
//.nav-tabs .nav-link {
//    border: 1px solid transparent;
//    border-top-left-radius: 0.25rem;
//    border-top-right-radius: 0.25rem;
//}
//.text-center {
//    text-align: center !important;
//}
//.nav-link {
//    display: block;
//    padding: 0.5rem 1rem;
//}
//.wizard-steps > li.active .badge {
//    background-color: #0088CC;
//}
//.nav-tabs li .nav-link .badge {
//    border-radius: 100%;
//    padding: 0.4rem 0.55rem;
//    margin-right: 5px;
//}
//.badge-primary {
//    background: #0088CC;
//}
//.badge {
//    display: inline-block;
//    padding: 0.25em 0.4em;
//    font-size: 75%;
//    font-weight: 700;
//    line-height: 1;
//    text-align: center;
//    white-space: nowrap;
//    vertical-align: baseline;
//    border-radius: 0.25rem;
//}
//.card-footer:last-child {
//    border-radius: 0 0 calc(0.25rem - 1px) calc(0.25rem - 1px);
//}
//.card-footer {
//    border-radius: 0 0 5px 5px;
//    margin-top: -5px;
//    background: #FFF;
//}
//.card-footer {
//    padding:12px 20px;
//    border-top: 1px solid rgba(0, 0, 0, 0.125);
//}
//.card-footer .pager {
//    margin: 0;
//    padding: 5px 0;
//}
//.pager {
//    padding-left: 0;
//    margin: 20px 0;
//    list-style: none;
//    text-align: center;
//}
//.pager li {
//    display: inline;
//}
//.form-wizard ul.pager .disabled a {
//    cursor: not-allowed;
//}
//.pager .disabled > a {
//    color: #777777;
//    background-color: #fff;
//    cursor: not-allowed;
//}
//.pager .previous > a, .pager .previous > span {
//    float: left;
//}
//.pager li > a, .pager li > span {
//    display: inline-block;
//    padding: 8px 14px;
//    background-color: #fff;
//    border: 1px solid #ddd;
//    border-radius: 15px;
//}
//.hidden {
//    display: none !important;
//}
//.float-right {
//    float: right !important;
//}
//.form-wizard ul.pager .next a, .form-wizard ul.pager .previous a, .form-wizard ul.pager .first a, .form-wizard ul.pager .last a, .form-wizard ul.pager .finish a {
//    cursor: pointer;
//}
//.card-footer .pager::after {
//    clear: both;
//    content: '';
//    display: table;
//}
//.card-footer::after {
//    clear: both;
//    content: '';
//    display: table;
//}
//.form-wizard .tab-content {
//    background: #FFF;
//    border: 0 none;
//    box-shadow: none;
//}

//.tab-content {
//    border-radius: 0 0 4px 4px;
//    box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.04);
//    background-color: #FFF;
//    border: 1px solid #EEE;
//    border-top: 0;
//    padding: 30px;
//}

//.p-3 {
//    padding: 1rem !important;
//}
");

