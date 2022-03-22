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
                                    value="<?= $applications[$next]['application_enc_id']; ?>"
                                    data-type="<?= $tipvalue ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="j-closed tt" data-toggle="tooltip"
                                    title="Close <?= $tipvalue ?>" data-name="<?= $tipvalue ?>"
                                    value="<?= $applications[$next]['application_enc_id']; ?>"
                                    data-type="<?= $tipvalue ?>">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="lf-bttn">
                            <?php $link = Url::to($applications[$next]["link"], "https"); ?>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                               class="fb-book tt" type="button" data-toggle="tooltip"
                               title="Share on Facebook">
                                <i class="fa fa-facebook-f"></i>
                            </a>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('https://twitter.com/intent/tweet?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                               class="tw-twitter tt" type="button" data-toggle="tooltip"
                               title="Share on Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('mailto:?&body=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                               class="ml-mail tt" type="button" data-toggle="tooltip"
                               title="Share via E-mail">
                                <i class="fa fa-envelope-o"></i>
                            </a>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('https://api.whatsapp.com/send?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                               class="wa-whats tt" type="button" data-toggle="tooltip"
                               title="Share on Whatsapp">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                               class="li-linked tt" type="button" data-toggle="tooltip"
                               title="Share on LinkedIn">
                                <i class="fa fa-linkedin"></i>
                            </a>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('https://t.me/share/url?url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                               class="tg-tele tt" type="button" data-toggle="tooltip"
                               title="Share on Telegram">
                                <i class="fa fa-telegram"></i>
                            </a>
                            <a href="javascript:;" class="clipb tt jj-clipboard" type="button" data-toggle="tooltip"
                               title="Copy Link" data-link="<?= $link ?>">
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
                                        <svg width="20px" height="20px" viewBox="0 0 73 88" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <g id="hourglass">
                                                <path d="M63.8761664,86 C63.9491436,84.74063 64,83.4707791 64,82.1818182 C64,65.2090455 57.5148507,50.6237818 48.20041,44 C57.5148507,37.3762182 64,22.7909545 64,5.81818182 C64,4.52922091 63.9491436,3.25937 63.8761664,2 L10.1238336,2 C10.0508564,3.25937 10,4.52922091 10,5.81818182 C10,22.7909545 16.4851493,37.3762182 25.79959,44 C16.4851493,50.6237818 10,65.2090455 10,82.1818182 C10,83.4707791 10.0508564,84.74063 10.1238336,86 L63.8761664,86 Z" id="glass" fill="#ddd"></path>
                                                <rect id="top-plate" fill="#333" x="0" y="0" width="74" height="8" rx="2"></rect>
                                                <rect id="bottom-plate" fill="#333" x="0" y="80" width="74" height="8" rx="2"></rect>
                                                <g id="top-sand" transform="translate(18, 21)">
                                                    <clipPath id="top-clip-path" fill="white">
                                                        <rect x="0" y="0" width="38" height="21"></rect>
                                                    </clipPath>
                                                    <path fill="#00a0e3" clip-path="url(#top-clip-path)" d="M38,0 C36.218769,7.51704545 24.818769,21 19,21 C13.418769,21 1.9,7.63636364 0,0 L38,0 Z"></path>
                                                </g>
                                                <g id="bottom-sand" transform="translate(18, 55)">
                                                    <clipPath id="bottom-clip-path" fill="white">
                                                        <rect x="0" y="0" width="38" height="21"></rect>
                                                    </clipPath>
                                                    <g clip-path="url(#bottom-clip-path)">
                                                        <path fill="#00a0e3" d="M0,21 L38,21 C36.1,13.3636364 24.581231,0 19,0 C13.181231,0 1.781231,13.4829545 0,21 Z"></path>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                </a>
                                <div class="exp-soon-msg">
                                    <?= $type ?> Expiring Soon
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
                            <a href="javascript:;" onclick="window.open('<?= Url::to($applications[$next]["link"], true); ?>', '_blank');"
                               class="detail-clg" title="View Details">
                                <i class="fa fa-info-circle"></i>
                            </a>
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
                            <?php if ($card_type == 'mec_card') { ?>
                                <div class="college-asign">
                                    <a href="javascript:;" class="fancy-btn open colleges-btn"
                                       id="<?= $applications[$next]['application_enc_id']; ?>" data-toggle="tooltip"
                                       title="View Colleges"><i class="fa fa-university"></i></a>
                                </div>
                            <?php } ?>
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

<?php
$this->registerCss(" 
@keyframes top-clip {
	0%{}
	50%{transform: translateY(21px);}
	100%{transform: translateY(21px);}
}
@keyframes bottom-sand-path {
	0%{}
	50%{transform: translateY(0);}
	100%{transform: translateY(0);}
}
@keyframes bottom-sand-g {
	0%{}
	85%{transform: translateY(0);}
	100%{transform: translateY(-8px);}
}
@keyframes hourglass-rotation {
	50%{transform: rotateZ(0);}
	100%{transform: rotateZ(180deg);}
}
#top-sand #top-clip-path rect,
#bottom-sand path,
#bottom-sand g,
.expring-btn svg {
	animation-duration: 5s;
	animation-delay: 1s;
	animation-iteration-count: infinite;
}
#top-sand #top-clip-path rect {
	animation-name: top-clip;
}
#bottom-sand path {
	transform: translateY(21px);
	animation-name: bottom-sand-path;
}
#bottom-sand g {
	animation-name: bottom-sand-g;
}
.expring-btn svg{
	animation-name: hourglass-rotation;
}
.lf-bttn{
    transition:all .3s;
    opacity:0;
    left:0;
    top:5px;
}
.hr-company-box:hover > .lf-bttn{
    left:0px;
    opacity:1;
}
.lf-bttn a{
    display:block;
    padding:5px 7px;
    border-radius: 0 8px 8px 0;
    -webkit-appearance: none;
}
.fb-book{color:#3b5998;}
.fb-book:hover{background-color:#3b5998;color:#fff;}
.tw-twitter{color:#1DA1F2;}
.tw-twitter:hover{background-color:#1DA1F2;color:#fff;}
.ml-mail{color:#DB4437;}
.ml-mail:hover{background-color:#DB4437;color:#fff;}
.wa-whats{color:#4FCE5D;}
.wa-whats:hover{background-color:#4FCE5D;color:#fff;}
.li-linked{color:#3B5998;}
.li-linked:hover{background-color:#3B5998;color:#fff;}
.tg-tele{color:#0088cc;}
.tg-tele:hover{background-color:#0088cc;color:#fff;}
.clipb{color:#797777;}
.clipb:hover{background-color:#797777;color:#fff;}

.hr-com-name{
    padding:10px 15px 0 15px;
    text-transform:capitalize;
}
.detail-clg{flex-basis:10%;}
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
    flex-basis: 90%;
    position:relative;
}
.college-asign {
	flex-basis: 10%;
}
.college-asign a i {
	font-size: 20px;
	color: #00a0e3;
    transition: all .3s;
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
    margin:0 5px;
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
    min-width:80px;
    max-width:150px;
}
.exp-soon-msg.exp-soon-msg {
    box-shadow: 0 0 10px rgb(0 0 0 / 20%);
    padding: 5px;
    position: absolute;
    top: 58px;
    right: 4px;
    max-width: 80px;
    font-size: 11px;
    font-family: roboto;
    font-weight:500;
    border-radius: 0 5px 5px;
    display: none;
    -webkit-animation: myOrbit 4s linear infinite;
    -moz-animation: myOrbit 4s linear infinite;
    -o-animation: myOrbit 4s linear infinite;
    animation: myOrbit 4s linear infinite;
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
//.exp-soon-main:hover .exp-soon-msg  {
//    display:none !important;
//}
.expring-btn img{
   animation: BigSmall .5s linear infinite;
}
@keyframes BigSmall {
    from{transform: scale(1)}
    to{transform: scale(1.1)}
}
.expring-btn{
    position:absolute;
    top:35px;
    right:35px;
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
    right: 0px;
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

        $(document).on('click', '.jj-clipboard',function (event) {
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
    
    $(document).on('click','.colleges-btn',function(event) {
        let app_id = $(this).attr('id');
        var url = "/account/jobs/get-job-colleges";
            $.ajax({
                url:url,
                data:{app_id:app_id},
                method:'post',
                beforeSend: function(){
                    $('#college_modal').html('<div class="text-center col-md-12"><i style="font-size:40px;" class="fa fa-circle-o-notch fa-spin fa-fw"></i></div>');
                    $('.overlay').addClass('state-show');
                    $('.frame').removeClass('state-leave').addClass('state-appear');
                    $('body').addClass('modal-open');
                },
                success:function(data){
                      if(data['status'] == 200) {
                          $('#college_modal').html('');
                          $('#college_modal').append(Mustache.render($('#college-modal').html(),data['colleges']));
                      } else {
                          $('.overlay').removeClass('state-show');
                          $('.frame').removeClass('state-appear').addClass('state-leave');
                          $('body').removeClass('modal-open');
                           toastr.error('Something went wrong. Please try again.', 'Opps!!');
                      }
                }
            });
    })

JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
