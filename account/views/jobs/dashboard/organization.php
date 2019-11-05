<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

echo $this->render('/widgets/header/secondary-header', [
    'for' => 'Jobs',
]);
?>
    <div class="row widget-row">
        <?=
        $this->render('/widgets/jobs/stats', [
            'questionnaire' => $questionnaire,
            'applications' => $applications,
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
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Active Jobs'); ?><a
                                    href="#" data-toggle="tooltip" title="Hooray!"><i class="fa fa-info-circle"></i></a></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/jobs/create'); ?>"  data-toggle="tooltip" title="Create AI Job">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/ai-job.png'); ?>"></a>
                        <a href="<?= Url::toRoute('/jobs/quick-job'); ?>" data-toggle="tooltip" title="Create Quick Job">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/quick-job1.png'); ?>"></a>
                        <a href="<?= Url::to('/tweets/job/create'); ?>" data-toggle="tooltip" title="Post Job Tweet">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/job-tweet.png'); ?>"></a>
                        <?php if ($applications['total'] > 8): ?>
                            <a href="<?= Url::toRoute('/jobs'); ?>" data-toggle="tooltip" title="View All">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php
                    if ($applications['total'] > 0) {
                        echo $this->render('/widgets/applications/card', [
                            'applications' => $applications['data'],
                            'per_row' => 4,
                        ]);
                    } else {
                        ?>
                        <div class="tab-empty">
                            <div class="tab-empty-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/jobinterview.png'); ?>"
                                     class="img-responsive" alt=""/>
                            </div>
                            <div class="tab-empty-text">
                                <div class="">No Active Jobs</div>
                            </div>
                        </div>
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
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Questionnaire'); ?><a
                                    href="#" data-toggle="tooltip" title="Hooray!"><i class="fa fa-info-circle"></i></a></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/questionnaire/create'); ?>" data-toggle="tooltip" title="Add New">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/add-new.png'); ?>"></a>
                        <a href="<?= Url::toRoute('/templates/questionnaire/index'); ?>" data-toggle="tooltip" title="Choose from Templates">
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
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light nd-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Interview Processes'); ?><a
                                    href="#" data-toggle="tooltip" title="Hooray!"><i class="fa fa-info-circle"></i></a></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/hiring-processes/create'); ?>" data-toggle="tooltip" title="Add New">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/add-new.png'); ?>"></a>
                        <a href="<?= Url::toRoute('/templates/hiring-process/index'); ?>" data-toggle="tooltip" title="Choose from Templates">
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
            <?= $this->render('/widgets/drop-resume/jobs_drop_resume', [
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
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Closed Jobs'); ?><a
                                    href="#" data-toggle="tooltip" title="Hooray!"><i class="fa fa-info-circle"></i></a></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/jobs/create'); ?>" data-toggle="tooltip" title="Add New">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/add-new.png'); ?>"></a>
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
                            <div class="tab-empty-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/applyingjob.png'); ?>"
                                     class="img-responsive" alt=""/>
                            </div>
                            <div class="tab-empty-text">
                                <div class="">No Closed Jobs</div>
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
.actions > a {
    margin-right: 15px;
}
.actions > a:hover > img{
    -ms-transform: scale(1.2);
    -webkit-transform: scale(1.2);
    transform: scale(1.2);
}
.font-dark > a > i {
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
    $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
JS;
$this->registerJs($script);
?>