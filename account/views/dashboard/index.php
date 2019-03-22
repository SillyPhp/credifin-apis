<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
echo $this->render('/widgets/header/secondary-header', [
    'for' => 'Dashboard',
]);
?>

    <div class="row">
        <div class="col-md-3">
            <?= $this->render('/widgets/tasks/taskbar-card',['viewed'=>$viewed]); ?>
            <?=
            $this->render('/widgets/services-selection/edit-services', [
                'model' => $model,
                'services' => $services,
            ]);
            ?>
        </div>
        <div class="col-md-9">
            <?php if (Yii::$app->user->identity->type->user_type == 'Individual'): ?>
                <?=
                $this->render('/widgets/applications/dashboard-applied-applications', [
                    'applied' => $applied,
                    'question_list' => $question_list
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
            <div class="posRel">
                <div class="overlay">
                    <div class="o-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/coming-soon.png')?>" class="img-responsive">
                    </div>
                </div>
            <div class="portlet light">
                <div class="portlet-title">
                   <div class="caption">
                       <span class="caption-subject font-dark bold uppercase">Templates</span>
                   </div>
                </div>

                <div class="portlet-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="hr-company-box">
                            <div class="hr-com-icon hr-com-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/template.svg') ?>" class="img-responsive ">
                            </div>
                            <div class="hr-com-name">
                                Internship
                                <p>Templates</p>
                            </div>
                            <div class="hr-com-jobs2">
                                <div class="minus-15-pad j-grid"><a href="/account/all-internship-templates" title="">VIEW TEMPLATES</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="hr-company-box">
                            <div class="hr-com-icon hr-com-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/template.svg') ?>" class="img-responsive ">
                            </div>
                            <div class="hr-com-name">
                                Questionnaire
                                <p>Templates</p>
                            </div>
                            <div class="hr-com-jobs2">
                                <div class="minus-15-pad j-grid"><a href="/account/all-questionnaire-templates" title="">VIEW TEMPLATES</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="hr-company-box">
                            <div class="hr-com-icon hr-com-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/template.svg') ?>" class="img-responsive ">
                            </div>
                            <div class="hr-com-name">
                                Jobs
                                <p>Templates</p>
                            </div>
                            <div class="hr-com-jobs2">
                                <div class="minus-15-pad j-grid"><a href="/account/all-questionnaire-templates" title="">VIEW TEMPLATES</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="hr-company-box">
                            <div class="hr-com-icon hr-com-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/template.svg') ?>" class="img-responsive ">
                            </div>
                            <div class="hr-com-name">
                                Interview
                                <p>Templates</p>
                            </div>
                            <div class="hr-com-jobs2">
                                <div class="minus-15-pad j-grid"><a href="/account/all-questionnaire-templates" title="">VIEW TEMPLATES</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                 </div>
            </div>
            </div>
                <div class="portlet light">
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
                <div class="portlet light">
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