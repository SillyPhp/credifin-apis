<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

echo $this->render('/widgets/header/secondary-header', [
    'for' => 'Internships',
]);
?>
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
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Active Internships'); ?><span
                                    href="#" data-toggle="tooltip" title="Here you will find all your active internships"><i class="fa fa-info-circle"></i></span></span>
                    </div>
                    <div class="actions">
                        <div class="set-im">
                            <a href="<?= Url::toRoute('/internships/create'); ?>" data-toggle="tooltip"
                               title="Create AI Internship" class="ai">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/ai-job.png'); ?>"></a>
                            <a href="<?= Url::to('/tweets/internship/create'); ?>" data-toggle="tooltip"
                               title="Post Internship Tweet" class="tweet">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/job-tweet.png'); ?>"></a>
                            <?php if ($applications['total'] > 8): ?>
                                <a href="<?= Url::toRoute('/internships/active-internships'); ?>" data-toggle="tooltip" title="View All" class="view">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php
                    if ($applications['total'] > 0) {
                        echo $this->render('/widgets/applications/card', [
                            'applications' => $applications['data'],
                            'per_row' => 4,
                            'col_width' => 'col-lg-3 col-md-3 col-sm-3',
                        ]);
                    } else {
                        ?>
                        <div class="tab-empty">
                            <div class="tab-empty-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/active-internships.png'); ?>"
                                     class="img-responsive" alt=""/>
                            </div>
                            <div class="tab-empty-text">
                                <div class="">No active Internships</div>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light nd-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Active Erexx Internships') ?><span
                                    href="#" data-toggle="tooltip" title="Here you will find internships that are active on Erexx"><i class="fa fa-info-circle"></i></span></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/internships/create'); ?>" data-toggle="tooltip" title="Add New">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/add-new.png'); ?>"></a>
                        <?php if ($erexx_applications['total'] > 8): ?>
                            <a href="<?= Url::toRoute('/internships/active-erexx-internships'); ?>" data-toggle="tooltip" title="View All">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php
                    if ($erexx_applications['total'] > 0) {
                        echo $this->render('/widgets/applications/card', [
                            'applications' => $erexx_applications['data'],
                            'per_row' => 4,
                            'col_width' => 'col-lg-3 col-md-3 col-sm-3',
                        ]);
                    } else {
                        ?>
                        <h3>No Active Internships</h3>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light nd-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Questionnaire'); ?><span
                                    href="#" data-toggle="tooltip" title="Here you will find all existing questionnaires"><i class="fa fa-info-circle"></i></span></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/questionnaire/create'); ?>" data-toggle="tooltip" title="Add New">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/add-new.png'); ?>"></a>
                        <a href="<?= Url::toRoute('/templates/questionnaire/index'); ?>" data-toggle="tooltip"
                           title="Choose from Templates">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/templates.png'); ?>"></a>
                        <?php if ($questionnaire['total'] > 4): ?>
                            <a href="<?= Url::toRoute('/questionnaire'); ?>" data-toggle="tooltip" title="View All">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                        <?php endif; ?>
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
        </div>
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light nd-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Interview Processes'); ?><span
                                    href="#" data-toggle="tooltip" title="Here you will find all existing interview processes"><i class="fa fa-info-circle"></i></span></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/hiring-processes/create'); ?>" data-toggle="tooltip"
                           title="Add New">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/add-new.png'); ?>"></a>
                        <a href="<?= Url::toRoute('/templates/hiring-process/index'); ?>" data-toggle="tooltip"
                           title="Choose from Templates">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/templates.png'); ?>"></a>
                        <?php if ($interview_processes['total'] > 4): ?>
                            <a href="<?= Url::toRoute('/hiring-processes'); ?>" data-toggle="tooltip" title="View All">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                        <?php endif; ?>
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
    <div class="row">
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <?php
            echo $this->render('/widgets/applied-applications/users-card', [
                'applied_applications' => $applied_applications,
            ]); ?>
        </div>
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <?= $this->render('/widgets/drop-resume/internships_drop_resume', [
                'data' => $primary_fields
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light nd-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Closed Internships'); ?>
                            <span data-toggle="tooltip" title="Here you will find all companies that you are following">
                                <i class="fa fa-info-circle"></i>
                            </span>
                        </span>
                    </div>
                    <div class="actions">
                        <?php if ($applications['total'] > 8): ?>
                            <a href="<?= Url::toRoute('/jobs'); ?>" data-toggle="tooltip" title="View All">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php
                    if ($closed_application['total'] > 0) {
                        echo $this->render('/widgets/applications/closed-jobs-cards', [
                            'applications' => $closed_application['data'],
                            'model' => $model,
                        ]);
                    } else {
                        ?>
                        <div class="tab-empty">
                            <div class="tab-empty-text">
                                <div class="">No closed Internships</div>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
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