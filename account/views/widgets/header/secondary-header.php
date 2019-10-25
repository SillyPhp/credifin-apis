<?php

use yii\helpers\Url;
?>
<section>
    <div class="row">
        <?php if (Yii::$app->user->identity->organization): ?>
            <?php if ($for == 'Dashboard'): ?>
                <div class="col-md-2 col-sm-3 col-xs-6 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/internships/create'); ?>">
                        <?= Yii::t('account', 'Create Internship'); ?>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/jobs/create'); ?>">
                        <?= Yii::t('account', 'Create Job'); ?>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/jobs/quick-job'); ?>">
                        <?= Yii::t('account', 'Create Quick Job'); ?>
                    </a>
                </div>
<!--                <div class="col-md-2 col-sm-3 col-xs-6 pull-right">-->
<!--                    <a class="btn btn-primary custom-buttons modal-load-form" href="javascript:;" value="/account/training-program/invite-candidates">-->
<!--                        --><?//= Yii::t('account', 'Invite Candidates'); ?>
<!--                    </a>-->
<!--                </div>-->
<!--                <div class="modal fade bs-modal-md in" id="modal-load"  aria-hidden="true">-->
<!--                    <div class="modal-dialog modal-md">-->
<!--                        <div class="modal-content">-->
<!--                            <div class="modal-body">-->
<!--                                <img src="--><?//= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?><!--" alt="--><?//= Yii::t('account', 'Loading'); ?><!--" class="loading">-->
<!--                                <span> &nbsp;&nbsp;--><?//= Yii::t('account', 'Loading'); ?><!--... </span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            <?php elseif ($for == 'Jobs'): ?>
                <div class="col-md-2 col-sm-3 col-xs-6 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/questionnaire/create'); ?>">
                        <?= Yii::t('account', 'Create Questionnaire'); ?>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/jobs/create'); ?>">
                        <?= Yii::t('account', 'Create Job'); ?>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/jobs/quick-job'); ?>">
                        <?= Yii::t('account', 'Create Quick Job'); ?>
                    </a>
                </div>
            <?php elseif ($for == 'Internships'): ?>
                <div class="col-md-2 col-sm-3 col-xs-6 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/questionnaire/create'); ?>">
                        <?= Yii::t('account', 'Create Questionnaire'); ?>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/internships/create'); ?>">
                        <?= Yii::t('account', 'Create Internship'); ?>
                    </a>
                </div>
            <?php elseif ($for == 'Trainings'): ?>
                <div class="col-md-2 col-sm-3 col-xs-6 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/training-program/create'); ?>">
                        <?= Yii::t('account', 'Create Training Program'); ?>
                    </a>
                </div>
            <?php elseif ($for == 'Questionnaire'): ?>
                <div class="col-md-2 col-sm-3 col-xs-6 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/questionnaire/create'); ?>">
                        <?= Yii::t('account', 'Create Questionnaire'); ?>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/internships/create'); ?>">
                        <?= Yii::t('account', 'Create Internship'); ?>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/jobs/create'); ?>">
                        <?= Yii::t('account', 'Create Job'); ?>
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
<?php
if (Yii::$app->user->identity->organization && $for == 'Dashboard'){
    $this->registerJs('
        $(document).on("click", ".modal-load-form", function() {
            $("#modal-load").modal("show").find(".modal-body").load($(this).attr("value"));   
        });
    ');
}