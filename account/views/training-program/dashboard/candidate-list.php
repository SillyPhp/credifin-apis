<?php
?>

<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Applied Candidates'); ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?php if (!empty($user_data)): ?>
                <?=
                $this->render('/widgets/training-program/candidate-profiles', [
                    'user_data' => $user_data,
                ]);
                endif;
                ?>
            </div>
        </div>
    </div>
</div>
