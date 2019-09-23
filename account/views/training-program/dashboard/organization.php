<?php
use yii\helpers\Url;
use yii\widgets\Pjax;

echo $this->render('/widgets/header/secondary-header', [
'for' => 'Trainings',
]);
?>
 <div class="row widget-row">
        <?=
        $this->render('/widgets/training-program/stats', [
            'applications' => $applications,
            'total_applied' => $total_applied,
        ]);
        ?>
    </div>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Active Training Programs'); ?></span>
                </div>
                <div class="actions">
                    <a href="<?= Url::toRoute('/training-program/create'); ?>"
                       class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                    <?php if ($applications['total'] > 8): ?>
                        <a href="<?= Url::toRoute('/training-program'); ?>" title=""
                           class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="portlet-body">
                <?php
                if ($applications['total'] > 0) {
                    echo $this->render('/widgets/training-program/cards', [
                        'applications' => $applications['data'],
                        'per_row' => 4,
                    ]);
                } else {
                    ?>
                    <h3>No Active Trainings</h3>
                <?php }
                ?>
            </div>
        </div>
    </div>
</div>
