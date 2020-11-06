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
                $tipvalue = explode('/', $applications[$next]['link'])[1];
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
                            <button type="button" class="j-delete tt" data-toggle="tooltip"
                                    title="Delete <?= $tipvalue ?>"
                                    value="<?= $applications[$next]['application_enc_id']; ?>" data-type="<?= $tipvalue ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="j-closed tt" data-toggle="tooltip"
                                    title="Close <?= $tipvalue ?>" data-name="<?= $tipvalue ?>"
                                    value="<?= $applications[$next]['application_enc_id']; ?>" data-type="<?= $tipvalue ?>">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="lf-bttn">
                            <?php $link = Url::to($applications[$next]["link"], "https"); ?>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                               class="j-facebook j-linkedin share_btn tt" type="button" data-toggle="tooltip"
                               title="Share on Facebook">
                                <i class="fa fa-facebook-f"></i>
                            </a>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('https://twitter.com/intent/tweet?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                               class="j-twitter share_btn tt" type="button" data-toggle="tooltip"
                               title="Share on Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('mailto:?&body=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                               class="j-email share_btn tt" type="button" data-toggle="tooltip"
                               title="Share via E-mail">
                                <i class="fa fa-envelope-o"></i>
                            </a>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('https://api.whatsapp.com/send?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                               class="j-whatsapp share_btn tt" type="button" data-toggle="tooltip"
                               title="Share on Whatsapp">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                               class="j-linkedin share_btn tt" type="button" data-toggle="tooltip"
                               title="Share on LinkedIn">
                                <i class="fa fa-linkedin"></i>
                            </a>
                            <a href="javascript:;" class="j-clipboard share_btn tt" type="button" data-toggle="tooltip"
                               title="Copy Link" data-link="<?=$link?>">
                                <i class="fa fa-clipboard"></i>
                            </a>
                        </div>
                        <?php
                        $dayDiff = findDifference($applications[$next]['last_date']);
                        if ($dayDiff->d < 8 && $dayDiff->m == 0 && $dayDiff->y == 0) {
                            ?>
                            <div class="exp-soon-main">
                                <a href="#" class="datepicker_opn"
                                   data-id="<?= $applications[$next]['application_enc_id'] ?>"
                                   data-date="<?= date("d-m-Y", strtotime($application['last_date'])); ?>">
                                    <div class="expring-btn" data-toggle="tooltip" title="Extend Date">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/expired-job4.png') ?>"
                                             alt="expring icon">
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
                                $concat = "";
                                if (!empty($applications[$next]['placementLocations'][0]['total'])):
                                    if ($applications[$next]['placementLocations'][0]['total'] > 1) {
                                        $concat = "s";
                                    }
                                    echo $applications[$next]['placementLocations'][0]['total'] . ' ' . 'Opening' . $concat;
                                elseif (!empty($applications[$next]['positions'])):
                                    if ($applications[$next]['positions'] > 1) {
                                        $concat = "s";
                                    }
                                    echo $applications[$next]['positions'] . ' ' . 'Opening' . $concat;
                                else:
                                    echo 'Work From Home';
                                endif;
                                ?>
                            </div>
                        </a>
                        <div class="hr-com-jobs">
                            <!--                            <a href="-->
                            <?//= Url::to($applications[$next]["link"], true); ?><!--">-->
                            <?//= Yii::t('account', 'VIEW ' . strtoupper($applications[$next]['application_type'])); ?><!--</a>-->
                            <a href="<?= Url::to($applications[$next]["link"], true); ?>" data-toggle="tooltip"
                               title="View Details"><i
                                        class="fa fa-info-circle"></i></a>
                            <div class="appl">
                                <a href="<?= Url::toRoute('process-applications' . DIRECTORY_SEPARATOR . $applications[$next]['application_enc_id'], true); ?>">
                                    <?php
                                    $appliedApp = sizeof($applications[$next]['appliedApplications']);
                                    switch ($appliedApp) {
                                        case 0:
                                            echo '0 Application';
                                            break;
                                        case 1:
                                            echo '1 Application';
                                            break;
                                        default:
                                            echo $appliedApp . ' Applicants';
                                            break;
                                    }
                                    ?>
                                </a>
                                <!--                                <div class="new">-->
                                <!--                                    <div class="pulse"></div>-->
                                <!--                                    <div class="dot"></div>-->
                                <!--                                </div>-->
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
?>
<!--    <script>-->
<!--        function copyToClipboard() {-->
<!--            var copyText = document.getElementById("share_manually");-->
<!--            copyText.select();-->
<!--            document.execCommand("copy");-->
<!--            toastr.success("", "Copied");-->
<!--        }-->
<!--    </script>-->
<?php
$this->registerCss("
.appl a span {
    background-color: #ff7803;
    color: #fff;
    border-radius: 100px;
    font-family: roboto;
    font-weight: 600;
    padding: 2px 5px;
}
.hr-com-jobs{
    font-size:13px; 
    color:#080808; 
    padding:10px 0 0px;
    margin-top:10px; 
    border-top:1px solid #eef1f5;
    display: flex;
    justify-content: space-around;
    align-items: center;
}
.hr-com-jobs > a > i{
    font-size: 25px;
    margin-top: 4px;
    transition: all .3s;
    color:#00a0e3;
}
.hr-com-jobs > a > i:hover{
    color:#ff7803;
}
.hr-com-field {
    font-weight: 400;
    color: #807575;
}
.appl {
    flex-basis: 100%;
    position:relative;
}
.appl a {
    font-family: roboto;
    font-size: 12px;
    color: #00a0e3;
    border: 2px solid #00a0e3;
    -webkit-border-radius: 20px !important;
    -moz-border-radius: 20px !important;
    -ms-border-radius: 20px !important;
    -o-border-radius: 20px !important;
    border-radius: 4px !important;
    padding: 6px 0;
    display: block;
    margin-left: 10px;
    flex-basis: 50%;
    position: relative;
}
.appl a:hover {
    background: #00a0e3 !important;
    color: #ffffff;
    transition: all 0.4s ease 0s;
    text-decoration:none;
}
.tt + .tooltip > .tooltip-inner {
    min-width:70px;
    max-width:110px;
}
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
    left: 54px !important;
}
.j-email {
    left: 78px !important;
}
.j-whatsapp {
    left: 30px !important;
}
.j-linkedin{
    left: 103px !important;
}
.j-clipboard{
    left: 125px !important;
    color:#797777;
}
.j-facebook {
    left: 10px !important;
    color:#3b5998;
}
.j-facebook:hover{color:#fff;}
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

.new {
    height: 16px;
    width: 16px;
    margin: 0 auto;
    position: absolute;
    top: -6px;
    right: -4px;
}

.dot {
    height: 10px;
    width: 10px;
    border-radius: 50%;
    background-color: #FF7803;
    position: absolute;
    top: 25%;
    left: 25%;
}
.pulse {
    z-index: 0;
    height: 18px;
    width: 18px;
    border-radius: 50%;
    background-color: #FF78033D;
    position: absolute;
    animation-name: pulsing;
    animation-duration: 1s;
    animation-iteration-count: infinite;
    animation-direction: alternate;
}
@-webkit-keyframes pulsing {
  from {transform: scale(1)}
  to {transform: scale(0.5)}
}
@keyframes pulsing {
  from {transform: scale(1)}
  to {transform: scale(0.5)}
}
.lead{
    margin-bottom:20px !important;
}
");
$script = <<<JS
$(document).on('click','.j-delete',function(e){
     e.preventDefault();
        var dataTab = $(this).attr('data-type');
        var main_card =$(this).parentsUntil(".hr-company-box").closest(".box-main-col");
        var data = $(this).attr('value');
       swal({ 
             title: "Are you sure?",
             text: "This "+dataTab+" will be deleted permanently from your dashboard",
             type: "warning",
             closeOnClickOutside: false,
             showCancelButton : true,
         },
         function(isConfirm){
             if (isConfirm) { 
                main_card.remove();
                var url = "/account/jobs/delete-application";
                $.ajax({
                    url:url,
                    data:{data:data},
                    method:'POST',
                    success:function(data){
                          if(data==true) {
                              toastr.success('Deleted Successfully', 'Success');
                            }
                           else {
                              toastr.error('Something went wrong. Please try again.', 'Opps!!');
                           }
                           $.pjax.reload({container: "#pjax_active_jobs", async: false});
                       }
                  });
            }       
         });
    });

$(document).on('click','.j-closed',function(e){
     e.preventDefault();
      var dataTab = $(this).attr('data-type');
      var main_card =$(this).parentsUntil(".hr-company-box").closest(".box-main-col");
      var data = $(this).attr('value');
      swal({ 
             title: "Are you sure?",
             text: "If you close this "+dataTab+" you will stop receiving new applications",
             type: "warning",
             closeOnClickOutside: false,
             showCancelButton : true,
         },
     function(isConfirm){
         if (isConfirm) { 
            main_card.remove();
            var url = "/account/jobs/close-application";
            $.ajax({
                url:url,
                data:{data:data},
                method:'post',
                success:function(data){
                      if(data==true) {
                          toastr.success('The Application moved to Closed ' + data_name +'s', 'Success');
                        }
                       else {
                           toastr.error('Something went wrong. Please try again.', 'Opps!!');
                       }
                       $.pjax.reload({container: "#pjax_active_jobs", async: false});
                     }
              });
    }
         });
});

        $(document).on('click', '.j-clipboard',function (event) {
            event.preventDefault();
            var link = $(this).attr('data-link');
            CopyToClipboard(link, true, "Link copied");
        });

    function CopyToClipboard(value, showNotification, notificationText) {
        var temp = $("<input>");
        $("body").append(temp);
        temp.val(value).select();
        document.execCommand("copy");
        temp.remove();
        toastr.success("", "Link Copy to Clipboard");
    }
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);