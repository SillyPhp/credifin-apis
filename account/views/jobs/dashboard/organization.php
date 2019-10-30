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
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Active Jobs'); ?></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/jobs/create'); ?>"
                           class="viewall-jobs"><?= Yii::t('account', 'Create AI Job'); ?></a>
                        <a href="<?= Url::toRoute('/jobs/quick-job'); ?>"
                           class="viewall-jobs"><?= Yii::t('account', 'Create Quick Job'); ?></a>
                        <a href="<?= Url::to('/tweets/job/create'); ?>"
                           class="viewall-jobs"><?= Yii::t('account', 'Post Job Tweet'); ?></a>
                        <?php if ($applications['total'] > 8): ?>
                            <a href="<?= Url::toRoute('/jobs'); ?>" title=""
                               class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
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
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/job.png'); ?>"
                                     class="img-responsive" alt=""/>
                            </div>
                            <div class="tab-empty-text">
                                <div class="">No active jobs</div>
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
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Questionnaire'); ?></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/questionnaire/create'); ?>"
                           class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                        <a href="<?= Url::toRoute('/templates/questionnaire/index'); ?>"
                           class="viewall-jobs"><?= Yii::t('account', 'Choose From Templates'); ?></a>
                        <?php if ($questionnaire['total'] > 4): ?>
                            <a href="<?= Url::toRoute('/questionnaire'); ?>"
                               class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
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
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/questionnare.png'); ?>"
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
            <div class="portlet light nd-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Interview Processes'); ?></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/hiring-processes/create'); ?>"
                           class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                        <a href="<?= Url::toRoute('/templates/hiring-process/index'); ?>"
                           class="viewall-jobs"><?= Yii::t('account', 'Choose From Templates'); ?></a>
                        <?php if ($interview_processes['total'] > 4): ?>
                            <a href="<?= Url::toRoute('/hiring-processes'); ?>"
                               class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
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
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/rejected.png'); ?>"
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
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <?php
            echo $this->render('/widgets/applied-applications/users-card', [
                'applied_applications' => $applied_applications,
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <?= $this->render('/widgets/drop-resume/jobs_drop_resume', [
                'data' => $primary_fields
            ]); ?>
        </div>
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light nd-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Closed Jobs'); ?></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/jobs/create'); ?>"
                           class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                        <?php if ($applications['total'] > 8): ?>
                            <a href="<?= Url::toRoute('/jobs'); ?>" title=""
                               class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
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
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/jobsclose.png'); ?>"
                                     class="img-responsive" alt=""/>
                            </div>
                            <div class="tab-empty-text">
                                <div class="">No closed jobs</div>
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
JS;
$this->registerJs($script);
?>