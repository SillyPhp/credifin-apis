<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

$total_applications = count($applications);
$next = 0;
Pjax::begin(['id' => 'pjax_active_jobs']);
if (!empty($total_applications)) {
    if (!function_exists("findDifference")) {
        function findDifference($date)
        {
//            $date = '2019-11-10 21:21:21';
            $date = new DateTime($date);
            $time_now = date("Y-m-d H:i:s");
            $now = new DateTime($time_now);
            return $res = $date->diff($now);
//            return $year = $res->y * (365 * 60 * 60 * 24);
//            $month = $res->m * (30 * 60 * 60 * 24);
//            return $day = $res->d * (60 * 60 * 24);
//
//            $hour = $res->h * (60 * 60);
//            $minute = $res->i * 60;
//            $second = $res->s;
//            return $year + $month + $day + $hour + $minute + $second;

        }
    }
    ?>
    <div class="row">
        <?php
        for ($j = 0; $j < $total_applications; $j++) {
            if ($next < $total_applications) {
                ?>
                <div class="box-main-col <?= (!empty($col_width) ? $col_width : 'col-lg-3 col-md-3 col-sm-6'); ?>">
                    <div class="hr-company-box">
                        <div class="rt-bttns">
                            <?php if (!empty($applications[$next]['interview_process_enc_id'])): ?>
                                <a href="<?= Url::toRoute($applications[$next]['application_type'] . DIRECTORY_SEPARATOR . $applications[$next]["application_enc_id"] . DIRECTORY_SEPARATOR . 'edit'); ?>"
                                   target="_blank"
                                   class="j-edit">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a href="<?= Url::toRoute($applications[$next]['application_type'] . DIRECTORY_SEPARATOR . $applications[$next]["application_enc_id"] . DIRECTORY_SEPARATOR . 'clone'); ?>"
                                   target="_blank"
                                   class="j-clone share_btn">
                                    <i class="fa fa-clone"></i>
                                </a>
                            <?php else: ?>
                                <a href="<?= Url::toRoute($applications[$next]['application_type'] . DIRECTORY_SEPARATOR . 'quick-job-edit?editid=' . $applications[$next]["application_enc_id"]); ?>"
                                   target="_blank"
                                   class="j-edit">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a href="<?= Url::toRoute($applications[$next]['application_type'] . DIRECTORY_SEPARATOR . 'quick-job-clone?editid=' . $applications[$next]["application_enc_id"]); ?>"
                                   target="_blank"
                                   class="j-clone share_btn">
                                    <i class="fa fa-clone"></i>
                                </a>
                            <?php endif; ?>
                            <button type="button" class="j-delete"
                                    value="<?= $applications[$next]['application_enc_id']; ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="lf-bttn">
                            <?php $link = Url::to($applications[$next]["link"], "https"); ?>
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
                        <?php
                        $dayDiff = findDifference($applications[$next]['last_date']);
                        if ($dayDiff->d < 8 && $dayDiff->m == 0 && $dayDiff->y == 0) {
                            $time = $dayDiff->h . 'h:' . $dayDiff->i .'m:'. $dayDiff->s . 's';
                            $day = $dayDiff->d .'d ';
                            ?>
                            <div class="expring-btn" data-toggle="tooltip" title="Expring in - <?= ($day < 1)? $time : $day ?>">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/expired-job2.png') ?>" alt="expring icon">
                            </div>
                            <?php
                        }
                        ?>
                        <a href="<?= Url::toRoute('process-applications' . DIRECTORY_SEPARATOR . $applications[$next]['application_enc_id']); ?>">
                            <div class="hr-com-icon">
                                <img src="<?= Url::to('@commonAssets/categories/' . $applications[$next]["icon"]); ?>"
                                     class="img-responsive ">
                            </div>
                            <div class="hr-com-name">
                                <?= $applications[$next]['name']; ?>
                            </div>
                            <div class="hr-com-field">
                                <?php
                                if (!empty($applications[$next]['placementLocations'][0]['total'])):
                                    echo $applications[$next]['placementLocations'][0]['total'] . ' ' . 'Openings';
                                elseif (!empty($applications[$next]['positions'])):
                                    echo $applications[$next]['positions'] . ' ' . 'Openings';
                                else:
                                    echo 'Work From Home';
                                endif;
                                ?>
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
} else { ?>
    <div class="tab-empty">
        <div class="tab-empty-icon">
            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/jobsclose.png'); ?>" class="img-responsive" alt=""/>
        </div>
        <div class="tab-empty-text">
            <div class="">No Active Jobs</div>
        </div>
    </div>
<?php }
Pjax::end();

$this->registerCss("
.expring-btn{
    position:absolute;
    top:35px;
    right:50px;
    background:#00a0e3;
    height:30px;
    width:30px;
    border-radius:50%; 
}
.expring-btn img{
    padding-top:7px;
}
.tab-empty{
    padding:20px;
}
.tab-empty-icon img{
    max-width:200px; 
    margin:0 auto;
}
.tab-empty-text{
    text-align:center; 
    font-size:35px; 
    font-family:lobster; 
    color:#999999; 
    padding-top:20px;
}
.topic-con{
    position:relative;
}
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
            success:function(data){
                $.pjax.reload({container: "#pjax_active_jobs", async: false});
                  if(data==true) {
                      toastr.success('Deleted Successfully', 'Success');
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