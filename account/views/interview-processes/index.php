<?php
use yii\widgets\Pjax;
echo $this->render('/widgets/header/secondary-header', [
    'for' => 'Questionnaire',
]);
?>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Interview Processes'); ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active">
                        <div class="mt-actions">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="padding-left">
                                        <div class="manage-jobs-sec">
                                            <?php
                                            Pjax::begin(['id' => 'pjax_active_process']);
                                            if ($processes['total'] > 0) {
                                                echo $this->render('/widgets/processes/card', [
                                                    'processes' => $processes['data'],
                                                    'per_row' => 4,
                                                    'col_width' => 'col-lg-3 col-md-3 col-sm-6',
                                                ]);
                                            }
                                            Pjax::end();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>