<?php

use yii\helpers\Url;
?>
<section>
    <div class="row">
        <?php if (Yii::$app->user->identity->organization): ?>
            <?php if ($for == 'Dashboard'): ?>
                <div class="col-md-2 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/internships/create'); ?>">
                        <?= Yii::t('account', 'Create Internship'); ?>
                    </a>
                </div>
                <div class="col-md-2 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/jobs/create'); ?>">
                        <?= Yii::t('account', 'Create Job'); ?>
                    </a>
                </div>
            <?php elseif ($for == 'Jobs'): ?>
                <div class="col-md-2 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/questionnaire/create'); ?>">
                        <?= Yii::t('account', 'Create Questionnaire'); ?>
                    </a>
                </div>
                <div class="col-md-2 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/jobs/create'); ?>">
                        <?= Yii::t('account', 'Create Job'); ?>
                    </a>
                </div>
            <?php elseif ($for == 'Internships'): ?>
                <div class="col-md-2 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/questionnaire/create'); ?>">
                        <?= Yii::t('account', 'Create Questionnaire'); ?>
                    </a>
                </div>
                <div class="col-md-2 pull-right">
                    <a class="btn btn-primary custom-buttons" href="<?= Url::to('/account/internships/create'); ?>">
                        <?= Yii::t('account', 'Create Internship'); ?>
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>