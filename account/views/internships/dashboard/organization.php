<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

echo $this->render('/widgets/header/secondary-header', [
    'for' => 'Internships',
]);
?>
    <div class="loader"><img src='https://gifimage.net/wp-content/uploads/2017/09/ajax-loading-gif-transparent-background-4.gif'/></div>
    <div class="row widget-row">
        <?=
        $this->render('/widgets/internships/stats', [
            'questionnaire' => $questionnaire,
            'applications' => $applications,
            'interview_processes' => $interview_processes,
            'applied_applications' => $applied_applications,
            'viewed'=>$viewed,
        ]);
        ?>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Active Internships'); ?></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/internships/create'); ?>" class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                        <?php if ($applications['total'] > 8): ?>
                            <a href="<?= Url::toRoute('/internships'); ?>" title="" class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                        <?php endif; ?>
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
                        <h3>No Active Internships</h3>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Questionnaire'); ?></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/questionnaire/create'); ?>" class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                        <?php if ($questionnaire['total'] > 4): ?>
                            <a href="<?= Url::toRoute('/questionnaire'); ?>" class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
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
                                <h3>No Questionnaire To Display</h3>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Interview Processes'); ?></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/hiring-processes/create'); ?>" class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                        <?php if ($interview_processes['total'] > 4): ?>
                            <a href="<?= Url::toRoute('/hiring-processes'); ?>" class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
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
                                <h3>No Processes To Display</h3>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'View Applications'); ?></span>
                    </div>
                    <?php
                    if ($applied_applications['total'] > 10):
                        ?>
                        <div class="actions">
                            <div class="dashboard-button">
                                <a href="javascript:;" class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-actions">
                                <?php
                                if (!empty($applied_applications)) { ?>
                                    <?php foreach ($applied_applications['list'] as $candiates) { ?>
                                        <div class="mt-action">
                                            <div class="mt-action-img" style="width: auto">
                                                <a href="/<?= $candiates['username'] ?>">
                                                    <?php if (!empty($candiates['image_location']) && !empty($candiates['image'])) { ?>
                                                        <?php $user_img = Yii::$app->params->upload_directories->users->image . $candiates['image_location'] . DIRECTORY_SEPARATOR . $candiates['image']; ?>
                                                        <img src="<?= $user_img; ?>" width="50px" height="50" class="img-circle"/>

                                                        <?php
                                                    } else {
                                                        ?>
                                                        <canvas class="user-icon img-circle" name="<?= $candiates['first_name'] . ' ' . $candiates['last_name'] ?>" width="50" height="50" font="25px"></canvas>
                                                    <?php }
                                                    ?>
                                                </a>

                                            </div>
                                            <div class="mt-action-body">
                                                <div class="mt-action-row">
                                                    <div class="mt-action-info ">
                                                        <div class="mt-action-details ">
                                                            <span class="mt-action-author"><a href="/site/candidate-profile"><?= $candiates['first_name'] . ' ' . $candiates['last_name']; ?></a></span>
                                                            <p class="mt-action-desc">Applied For <?= $candiates['name']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-action-buttons">
                                                        <div class="btn-group btn-group-circle">
                                                            <button type="button" data-key="<?= $candiates['applied_application_enc_id'] ?>" class="btn btn-outline green btn-sm approv_btn">Approve</button>
                                                            <button type="button" data-key="<?= $candiates['applied_application_enc_id'] ?>" class="btn btn-outline red btn-sm reject_btn">Reject</button>
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
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <?= $this->render('/widgets/drop-resume/internships_drop_resume', [
                'data' => $primary_fields
            ]); ?>
        </div>
    </div>
<?php
$this->registerCss('
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