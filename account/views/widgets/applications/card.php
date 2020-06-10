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
            $date = new DateTime($date);
            $time_now = date("Y-m-d H:i:s");
            $now = new DateTime($time_now);
            return $res = $date->diff($now);
        }
    }
    ?>
    <div class="row">
        <?php
        for ($j = 0; $j < $total_applications; $j++) {
            if ($next < $total_applications) {
                $tipvalue = explode('/',$applications[$next]['link'])[1];
                ?>
                <div class="box-main-col <?= (!empty($col_width) ? $col_width : 'col-lg-3 col-md-3 col-sm-6'); ?>">
                    <div class="hr-company-box">
                        <div class="rt-bttns">
                            <?php if (!empty($applications[$next]['interview_process_enc_id'])): ?>
                                <a href="<?= Url::toRoute($applications[$next]['application_type'] . DIRECTORY_SEPARATOR . $applications[$next]["application_enc_id"] . DIRECTORY_SEPARATOR . 'edit'); ?>"
                                   target="_blank" data-toggle="tooltip" title="Edit <?= $tipvalue ?>"
                                   class="j-edit tt">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a href="<?= Url::toRoute($applications[$next]['application_type'] . DIRECTORY_SEPARATOR . $applications[$next]["application_enc_id"] . DIRECTORY_SEPARATOR . 'clone'); ?>"
                                   target="_blank" data-toggle="tooltip" title="Clone <?= $tipvalue ?>"
                                   class="j-clone share_btn tt">
                                    <i class="fa fa-clone"></i>
                                </a>
                            <?php else: ?>
                                <a href="<?= Url::toRoute($applications[$next]['application_type'] . DIRECTORY_SEPARATOR . 'quick-job-edit?editid=' . $applications[$next]["application_enc_id"]); ?>"
                                   target="_blank" data-toggle="tooltip" title="Edit <?= $tipvalue ?>"
                                   class="j-edit tt">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>
                                <a href="<?= Url::toRoute($applications[$next]['application_type'] . DIRECTORY_SEPARATOR . 'quick-job-clone?editid=' . $applications[$next]["application_enc_id"]); ?>"
                                   target="_blank" data-toggle="tooltip" title="Clone <?= $tipvalue ?>"
                                   class="j-clone share_btn tt">
                                    <i class="fa fa-clone"></i>
                                </a>
                            <?php endif; ?>
                            <button type="button" class="j-delete tt" data-toggle="tooltip" title="Delete <?= $tipvalue ?>"
                                    value="<?= $applications[$next]['application_enc_id']; ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="j-closed tt" data-toggle="tooltip" title="Close <?= $tipvalue ?>"
                                    value="<?= $applications[$next]['application_enc_id']; ?>">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="lf-bttn">
                            <?php $link = Url::to($applications[$next]["link"], "https"); ?>
                            <a href=""
                               onclick="window.open('<?= Url::to('https://twitter.com/home?status=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                               class="j-twitter share_btn" type="button" >
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
                            ?>
                            <div class="exp-soon-main">
                                <a href="#" class="datepicker_opn" data-id="<?= $applications[$next]['application_enc_id']?>" data-date="<?= date("d-m-Y", strtotime($application['last_date'])); ?>">
                                    <div class="expring-btn" data-toggle="tooltip" title="Extend Date">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/expired-job4.png') ?>" alt="expring icon">
                                    </div>
                                </a>
                                <div class="exp-soon-msg">
                                    Expring Soon
                                </div>
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
                            <div class="row">
                            <div class="col-md-12" style="font-family: roboto;">
                                <a href="<?= Url::toRoute('process-applications' . DIRECTORY_SEPARATOR . $applications[$next]['application_enc_id'],true); ?>">
                                    <?= sizeof($applications[$next]['appliedApplications']).' Applications'; ?>
                                </a>
                            </div>
                            <div class="col-md-12 j-grid"><a
                                        href="<?= Url::to($applications[$next]["link"],true); ?>"><?= Yii::t('account', 'VIEW '.strtoupper($applications[$next]['application_type'])); ?></a>
                            </div>
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
.tt + .tooltip > .tooltip-inner {width:115px;}
.exp-soon-msg{
     box-shadow: 0 0 10px rgba(0,0,0,.2);
    padding: 5px;
    position: absolute;
    top: 51px;
    right: -2px;
    max-width: 60px;
    font-size: 12px;
    border-radius: 0 5px 5px;
    display:none;
    
     -webkit-animation: myOrbit 4s linear infinite; /* Chrome, Safari 5 */
       -moz-animation: myOrbit 4s linear infinite; /* Firefox 5-15 */
         -o-animation: myOrbit 4s linear infinite; /* Opera 12+ */
            animation: myOrbit 4s linear infinite; /* Chrome, Firefox 16+, IE 10+, Safari 5 */
}
@-webkit-keyframes myOrbit {
    from { -webkit-transform: rotate(0deg) translateX(2px) rotate(0deg); }
    to   { -webkit-transform: rotate(360deg) translateX(2px) rotate(-360deg); }
}

@-moz-keyframes myOrbit {
    from { -moz-transform: rotate(0deg) translateX(2px) rotate(0deg); }
    to   { -moz-transform: rotate(360deg) translateX(2px) rotate(-360deg); }
}

@-o-keyframes myOrbit {
    from { -o-transform: rotate(0deg) translateX(2px) rotate(0deg); }
    to   { -o-transform: rotate(360deg) translateX(2px) rotate(-360deg); }
}

@keyframes myOrbit {
    from { transform: rotate(0deg) translateX(2px) rotate(0deg); }
    to   { transform: rotate(360deg) translateX(2px) rotate(-360deg); }
}
.hr-company-box:hover > div > .exp-soon-msg{
    display:block;
    transition:1s ease !important;
}
.hr-company-box:hover .expring-btn img{
    animation-play-state: paused !important;
    transform: scale(1) !important;
}
.exp-soon-main:hover .exp-soon-msg  {
    display:none !important;
}
.expring-btn img{
   animation: BigSmall .5s linear infinite;
}
@keyframes BigSmall {
    from{transform: scale(1)}
    to{transform: scale(1.1)}
}
.j-twitter{
    left: 40px !important;
}
.j-email {
    left: 65px !important;
}
.j-linkedin{
    left: 93px !important;
}
.expring-btn{
    position:absolute;
    top:35px;
    right:50px;
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
.j-grid > a{ 
    margin-top:0px;
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

$(document).on('click','.j-closed',function(e){
     e.preventDefault();
     var main_card =$(this).parentsUntil(".hr-company-box").closest(".box-main-col");
     if (window.confirm("Do you really want to Delete the current Application?")) { 
        main_card.remove();
        var data = $(this).attr('value');
        var url = "/account/jobs/close-application";
        $.ajax({
            url:url,
            data:{data:data},
            method:'post',
            success:function(data){
                $.pjax.reload({container: "#pjax_active_jobs", async: false});
                  if(data==true) {
                      $.pjax.reload({container: "#pjax_closed_jobs", async: false});
                      toastr.success('Closed Successfully', 'Success');
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