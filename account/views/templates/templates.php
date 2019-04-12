<?php
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Questionnaire Templates'); ?></span>
                </div>
                <div class="actions">
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
                            echo $this->render('/widgets/questionnaire/template-card', [
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
    </div>
</div>