<?php

use yii\helpers\Url;

foreach ($applications as $application) {
    ?>
    <div class="mt-action">
        <div class="mt-action-img">
            <img src="<?= Url::to('@backendAssets/layouts/layout/img/avatar10.jpg'); ?>" />
        </div>
        <div class="mt-action-body">
            <div class="mt-action-row">
                <div class="mt-action-info ">                                       
                    <div class="mt-action-details ">
                        <span class="mt-action-author"><?= $application['first_name'] . ' ' . $application['last_name']; ?></span>
                        <p class="mt-action-desc"><?= Yii::t('account', 'Applied For ') . $application['title']; ?></p>
                    </div>
                </div>
                <div class="mt-action-buttons ">
                    <div class="btn-group btn-group-circle">
                        <button type="button" data-key="<?= $application['applied_application_enc_id']; ?>" class="btn btn-outline green btn-sm approv_btn">Appove</button>
                        <button type="button" data-key="<?= $application['applied_application_enc_id']; ?>" class="btn btn-outline red btn-sm remov_btn">Reject</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
$script = <<<JS
    $(document).on('click', '.approv_btn', function() {
        var data = $(this).attr('data-key');
        $.ajax({
            url: '/account/accept-application',
            data: {
                data: data
            },
            method: 'post',
            beforeSend: function() {
                //$('.sav_job').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
            },
            success: function(data) {
                console.log(data);
            }
        });
    });
JS;
$this->registerJs($script);
