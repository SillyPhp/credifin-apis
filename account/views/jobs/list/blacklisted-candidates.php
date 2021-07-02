<?php
?>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
    <div class="portlet light nd-shadow">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-social-twitter font-dark hide"></i>
                <span class="caption-subject font-dark bold uppercase">
                    <?= Yii::t('account', 'Blacklisted Candidates'); ?></span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <?= $this->render('/widgets/applications/blacklisted-candidates', [
                    'blacklistedApplicants' => $blacklistedApplicants,
                    'type' => 'job'
                ]) ?>
            </div>
        </div>
    </div>
</div>
</div>