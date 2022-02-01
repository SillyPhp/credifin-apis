<?php

use yii\helpers\Url;

?>
    <section class="overlape dark-color">
        <div data-velocity="-.1"
             style="background: url('<?= Url::to("@eyAssets/images/backgrounds/default_cover.png"); ?>') repeat scroll 50% 422.28px transparent;background-size: 100% 100% !important;background-repeat: no-repeat;"
             class="parallax scrolly-invisible no-parallax"></div>
        <div class="background-container">
            <div class="row m-0">
                <div class="col-lg-12 p-0">
                    <div class="inner-header">
                        <div class="profile_icons">
                            <img src="/assets/common/categories/profile/<?= $icon_png; ?>"/>
                        </div>
                        <h3><?= $job_title; ?></h3>
                        <div class="job-statistic">
                            <?php if ($shortlist_btn_display): ?>
                                <?php
                                if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->organization) {
                                    if (!empty($shortlist) && $shortlist['shortlisted'] == 1) {
                                        ?>
                                        <span class="hover-change col_pink"><a href="#" class="shortlist_job"><i
                                                        class="far fa-heart"></i> Shortlisted</a></span>
                                        <?php
                                    } else {
                                        ?>
                                        <span class="hover-change"><a href="#" class="shortlist_job"><i
                                                        class="far fa-heart"></i> Shortlist</a></span>
                                        <?php
                                    }
                                }
                                ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--</div>-->
        <!--</div>-->
    </section>
<?php
$script = <<< JS
$(document).on('click','.shortlist_job',function(e){
     e.preventDefault();
     var app_id = $('#application_id').val();
     $.ajax({
        url:'/jobs/item-id',
        data: {'itemid':app_id},         
        method: 'post',
        beforeSend:function(){
            $('.shortlist_job').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
        },
        success:function(data){
            if(data.status === 200 || data.status === 'short'){
                $('.shortlist_job').html('<i class="far fa-heart"></i> Shortlisted');
                $('.hover-change').addClass('col_pink');
            } else if(data.status === 'unshort'){
                $('.shortlist_job').html('<i class="far fa-heart"></i> Shortlist');
                $('.hover-change').removeClass('col_pink');
            } else if (data === 'error') {
                alert('Please Login first..');
            } else if(data.status === 201) {
                alert('Error occurred: ' + data.message);
            }
        }
     });
});
JS;
$this->registerJs($script);