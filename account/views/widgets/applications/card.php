<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
$total_applications = count($applications);
//$rows = ceil($total_applications / $per_row);
$next = 0;
Pjax::begin(['id' => 'pjax_active_jobs']);
if (!empty($total_applications)) {
//    for ($i = 1; $i <= $rows; $i++) {
        ?>
        <div class="row">
            <?php
            for ($j = 0; $j < $total_applications; $j++) {
                if ($next < $total_applications) {
                    ?>
                    <div class="box-main-col <?= (!empty($col_width) ? $col_width : 'col-lg-3 col-md-3 col-sm-3'); ?>">
                        <div class="hr-company-box">
                            <div class="rt-bttns">
                                <a href=""
                                   onclick="window.open('<?= Url::toRoute(Yii::$app->controller->id . DIRECTORY_SEPARATOR . $applications[$next]["application_enc_id"] . DIRECTORY_SEPARATOR . 'clone'); ?>', '_blank');"
                                   class="j-clone share_btn">
                                    <i class="fa fa-clone"></i>
                                </a>
                                <button type="button" class="j-delete"
                                        value="<?= $applications[$next]['application_enc_id']; ?>">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                            </div>
                            <div class="lf-bttn">
                                <?php $link = Url::to($applications[$next]["link"], true); ?>
                                <a href=""
                                   onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-fb share_btn" type="button">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a href=""
                                   onclick="window.open('<?= Url::to('https://twitter.com/home?status=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-twitter share_btn" type="button">
                                    <i class="fa fa-twitter"></i>
                                </a>
                                <a href=""
                                   onclick="window.open('<?= Url::to('mailto:?&body=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-email share_btn" type="button">
                                    <i class="fa fa-envelope-o"></i>
                                </a>
                                <a href=""
                                   onclick="window.open('<?= Url::to('https://wa.me/?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-whatsapp share_btn" type="button">
                                    <i class="fa fa-whatsapp"></i>
                                </a>
                                <a href=""
                                   onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-linkedin share_btn" type="button">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </div>
                            <a href="<?= Url::toRoute('process-applications' . DIRECTORY_SEPARATOR . $applications[$next]['application_enc_id']); ?>">
                                <div class="hr-com-icon">
                                    <img src="<?= Url::to('@commonAssets/categories/' . $applications[$next]["icon"]); ?>"
                                         class="img-responsive ">
                                </div>
                                <div class="hr-com-name">
                                    <?= $applications[$next]['name']; ?>
                                </div>
                                <div class="hr-com-field">
                                    <?= $applications[$next]['placementLocations'][0]['total']; ?> Openings
                                </div>
                            </a>
                            <div class="hr-com-jobs">
                                <div class="col-md-6 minus-15-pad"><?= sizeof($applications[$next]['appliedApplications']); ?>
                                    Applications
                                </div>
                                <div class="col-md-6 minus-15-pad j-grid"><a
                                            href="<?= Url::to($applications[$next]["link"]); ?>"><?= Yii::t('account', 'VIEW JOB'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                $next++;
            }
            ?>
        </div>
        <?php
//    }
} else
{ ?>
    <h3>No Active Jobs</h3>
<?php }
Pjax::end();
$this->registerCss("

");
$script = <<<JS
$(document).on('click','.j-delete',function(e){
     e.preventDefault();
     var main_card =$(this).parentsUntil(".hr-company-box").closest(".box-main-col");
     if (window.confirm("Do you really want to Delete the current Application?")) { 
        main_card.remove();
        var data = $(this).attr('value');
        var url = "/account/jobs/delete-application";
        $.ajax({
            url:url,
            data:{data:data},
            method:'post',
            beforeSend:function(){
                // $(".loader").css("display", "block");
              },
            success:function(data){
                $.pjax.reload({container: "#pjax_active_jobs", async: false});
                  if(data==true) {
                      toastr.success('Deleted Successfully', 'Success');
                      // $(".loader").css("display", "none");
                    }
                   else {
                      toastr.error('Something went wrong. Please try again.', 'Opps!!');
                   }
                 }
          });
    }
});
JS;
$this->registerJs($script);
