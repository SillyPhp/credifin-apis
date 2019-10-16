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
                    <?php if ($shortlist_btn_display): ?>
                        <div class="job-statistic">
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
                        </div>
            <?php endif; ?>
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
        url:'/account/jobs/shortlist-job',
        data: {app_id:app_id},                         
        method: 'post',
        beforeSend:function(){
            $('.shortlist_job').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
        },
        success:function(data){
            if(data.message =='Shortlisted'){
                $('.shortlist_job').html('<i class="far fa-heart"></i> Shortlisted');
                $('.hover-change').addClass('col_pink');
            } else if(data.message =='unshort'){
                $('.shortlist_job').html('<i class="far fa-heart"></i> Shortlist');
                $('.hover-change').removeClass('col_pink');
            }
        }
     });
});
JS;
$this->registerJs($script);