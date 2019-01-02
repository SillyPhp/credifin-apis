<?php
echo $this->render('/widgets/header/secondary-header', [
    'for' => 'Jobs',
]);
?>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Active Jobs'); ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?php
                if ($applications['total'] > 0) {
                    echo $this->render('/widgets/applications/card', [
                        'applications' => $applications['data'],
                        'per_row' => 4,
                        'col_width' => 'col-lg-6 col-md-6 col-sm-6',
                    ]);
                }
                ?>
            </div>
        </div>
    </div>
</div>