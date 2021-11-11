<?php

use borales\extensions\phoneInput\PhoneInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$logo_image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $org_logo_location . DIRECTORY_SEPARATOR . $org_logo;
?>
    <div class="job-single-head style2 overlay-top">
        <div class="job-thumb">
            <a href="/<?= $slug; ?>">
                <?php
                if (!empty($org_logo)) {
                    ?>
                    <img src="<?= Url::to($logo_image); ?>" id="logo_img" alt=""/>
                    <?php
                } else {
                    ?>
                    <canvas class="user-icon" name="<?= $org_name; ?>" width="125" height="125"
                            color="<?= $initial_color; ?>" font="48px"></canvas>
                    <?php
                }
                ?>
            </a>
        </div>
        <div class="job-head-info">
            <a href="/<?= $slug; ?>"><h4><?= $org_name; ?></h4></a>
        </div>
        <div class="actions-main">
            <?php if (Yii::$app->user->isGuest): ?>
                <div class="btn-parent">
                    <a href="javascript:;" data-toggle="modal" data-target="#loginModal"
                       class="apply-job-btn single-btn"><i
                                class="fas fa-paper-plane"></i>Apply</a>
                </div>
                <div class="sub-actions">
                    <?php
                    if ($type == 'Internship'): ?>
                        <a href="<?= Url::to('/internships/compare?s=' . $application_slug) ?>"
                           class="add-or-compare hvr-icon-pulse full-width"><i class="far fa-copy hvr-icon"></i>
                            Compare Internship</a>
                    <?php elseif ($type == 'Job'): ?>
                        <a href="<?= Url::to('/jobs/compare?s=' . $application_slug) ?>"
                           class="add-or-compare hvr-icon-pulse"><i class="far fa-copy hvr-icon"></i>
                            Compare Job</a>
                    <?php endif; ?>
                    <a href="#"
                       data-toggle="modal" data-target="#loginModal"
                       class="add-or-compare hvr-icon-pulse"><i class="far fa-heart hvr-icon"></i>Shortlist</a>
                </div>
            <?php else: ?>
                <?php if ($applied): ?>
                    <div class="btn-parent">
                        <a href="#" title="" class="apply-job-btn single-btn" disabled="disabled"><i
                                    class="fas fa-check"></i>Applied</a>
                    </div>
                    <div class="sub-actions">
                        <?php
                        if ($type == 'Internship'): ?>
                            <a href="<?= Url::to('/internships/compare?s=' . $application_slug) ?>"
                               class="add-or-compare hvr-icon-pulse full-width"><i class="far fa-copy hvr-icon"></i>
                                Compare Internship</a>

                        <?php elseif ($type == 'Job'): ?>
                            <a href="<?= Url::to('/jobs/compare?s=' . $application_slug) ?>"
                               class="add-or-compare hvr-icon-pulse full-width"><i class="far fa-copy hvr-icon"></i>
                                Compare Job</a>
                        <?php endif; ?>
                    </div>
                <?php elseif (!Yii::$app->user->identity->organization): ?>
                    <div class="btn-parent">
                        <a href="#" class="apply-job-btn apply-btn move-anim-btn">
                            <i class="fas fa-paper-plane hvr-icon"></i> <span>Apply for <?= $type ?></span>
                        </a>
                    </div>
                    <?php if ($shortlist_btn_display): ?>
                        <div class="sub-actions">
                            <?php
                            if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->organization) {
                                if (!empty($shortlist) && $shortlist['shortlisted'] == 1) {
                                    ?>
                                    <a href="#"
                                       class="add-or-compare hvr-icon-pulse shortlist_job <?= (($type == 'Internship') ? 'full-width' : '') ?>"><i
                                                class="far fa-heart hvr-icon"></i>Shortlisted</a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="#"
                                       class="add-or-compare hvr-icon-pulse shortlist_job <?= (($type == 'Internship') ? 'full-width' : '') ?>"><i
                                                class="far fa-heart hvr-icon"></i>Shortlist</a>
                                    <?php
                                }
                            }
                            ?>
                            <?php
                            if ($type == 'Internship'): ?>
                                <a href="<?= Url::to('/internships/compare?s=' . $application_slug) ?>"
                                   class="add-or-compare hvr-icon-pulse full-width"><i class="far fa-copy hvr-icon"></i>
                                    Compare Internship</a>

                            <?php elseif ($type == 'Job'): ?>
                                <a href="<?= Url::to('/jobs/compare?s=' . $application_slug) ?>"
                                   class="add-or-compare hvr-icon-pulse"><i class="far fa-copy hvr-icon"></i>
                                    Compare Job</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php
            if ($type == 'Internship'): ?>
                <a href="<?= Url::to('/internships/list?company=' . $org_name); ?>" title="" class="view-all-a">View all
                    Internships</a>
            <?php elseif ($type == 'Job'): ?>
                <a href="<?= Url::to('/jobs/list?company=' . $org_name); ?>" title="" class="view-all-a">View all
                    Jobs</a>
            <?php endif; ?>
        </div>
        <div class="effect thurio">
            <h3 class="text-white size-set">Sharing Links</h3>
            <div class="buttons">
                <?php
                if ($type == 'Internship') {
                    $link = Url::to('internship/' . $application_slug, 'https');
                } else if ($type == 'Job') {
                    $link = Url::to('job/' . $application_slug, 'https');
                } else if ($type == 'Training') {
                    $link = Url::to('training/' . $application_slug, 'https');
                }
                ?>
                <a href="javascript:;" class="facebook-f"
                   onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="javascript:;" class="twitter-t"
                   onclick="window.open('<?= Url::to('https://twitter.com/intent/tweet?text=' . $this->title . '&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="javascript:;" class="linked-l"
                   onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link . '&title=' . $this->title . '&summary=' . $this->title . '&source=' . Url::base(true)); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="javascript:;" class="whatsapp-w"
                   onclick="window.open('<?= Url::to('https://api.whatsapp.com/send?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="javascript:;" class="enve-e"
                   onclick="window.open('<?= Url::to('mailto:?&body=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="javascript:;" class="tg-tele"
                   onclick="window.open('<?= Url::to('https://t.me/share/url?url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                    <i class="fab fa-telegram-plane"></i>
                </a>
            </div>
            <!--            <div class="qr-code">-->
            <!--                <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg">-->
            <!--            </div>-->
            <div class="wts-ap">
                <h3>Share on Whatsapp via Number</h3>
                <div class="col-md-12 form-whats">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'whatsapp-form',
                        'fieldConfig' => [
                            'template' => '<div class="form-group">{input}{error}</div>',
                            'labelOptions' => ['class' => ''],
                        ],
                    ]);
                    ?>
                    <?=
                    $form->field($whatsAppmodel, 'phone')->widget(PhoneInput::className(), [
                        'options' => ['class' => 'wts-txt', 'placeholder' => '+91 98 XXXX XXXX'],
                        'jsOptions' => [
                            'allowExtensions' => false,
                            'preferredCountries' => ['in'],
                            'nationalMode' => false,
                        ]
                    ]);
                    ?>
                    <?php ActiveForm::end(); ?>
                    <div class="send"><i class="fa fa-arrow-right"></i></div>
                </div>
            </div>
            <div class="row m-0">
                <div class="col-lg-12">
                    <h4 class="text-white">or</h4>
                    <div class="pf-field">
                        <input type="text" title="Click to Copy" id="share_manually" onclick="copyToClipboard()"
                               class="form-control" value="<?= $link ?>" readonly>
                        <i class="far fa-copy"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="down-img">
        <div class="show-img">
            <img src="<?= Url::to($Instaimage); ?>" alt=""/>
        </div>
        <h3>Download Sharing Image</h3>
        <a href="<?= $image; ?>" download target="_blank" title="Banner Image" class="img-down">
            <img src="<?= Url::to('@eyAssets/images/pages/employers/poster.png'); ?>" alt=""/>
        </a>
        <a href="<?= $Storyimage; ?>" download target="_blank" title="Story Image" class="img-down">
            <img src="<?= Url::to('@eyAssets/images/pages/employers/story.png'); ?>" alt=""/>
        </a>
        <a href="<?= $Instaimage; ?>" download target="_blank" title="Post Image" class="img-down">
            <img src="<?= Url::to('@eyAssets/images/pages/employers/square.png'); ?>" alt=""/>
        </a>
    </div>
<?php
$script = <<<JS
$(document).on('keypress','.wts-txt',function(e) {
    if(e.which == 13) {
        var val = $(this).val();
        var location = window.location.href;
        if(val.length < 8){
            alert('Enter Valid Number')
        }
        else {
             window.open('https://api.whatsapp.com/send?phone='+val+'&text=' + location);
        }
        $(this).val('');
    } else {
        var iKeyCode = (e.which) ? e.which : e.keyCode;
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57) && iKeyCode != 43){
            return false;
        }
        // return true;
    }
});
$(document).on('submit','#whatsapp-form',function(e) {
  e.preventDefault();
  return false;
});
$('.send').click(function () {        
    var val = $('.wts-txt').val();
    var location = window.location.href;
       if(val.length < 10){
            alert('Enter Valid Number')
        }
        else {
             window.open('https://api.whatsapp.com/send?phone='+val+'&text=' + location);
        }
        $('.wts-txt').val('');
});
JS;

$this->registerCss('
.down-img {
    background: #4ECDC4;
    background: -webkit-linear-gradient(to right, #556270, #4ECDC4);
    background: linear-gradient(to right, #556270, #333a44);
    width: 80%;
    margin: 15px auto;
    text-align:center;
    padding:20px 0;
}
.down-img h3 {  
	color: #fff;
	font-size: 16px;
	font-family: roboto;
	margin: 0px 0 15px;
}
.down-img a {
    background-color: #fff;
    padding: 5px;
    border-radius: 4px;
    display: inline-block;
    margin: 0px 2px;
    width: 38px;
    height: 36px;
}
.show-img img {
    width: 100%;
    height: 250px;
    object-fit: contain;
    margin-bottom: 15px;
}
.job-thumb canvas {
    border-radius: 50%;
    width: 125px;
    height: 125px;
}
.organization-details p{
    display: flex;
    align-items: center;
    word-break: break-all;
}
.qr-code {
	width: 100px;
	margin: 5px auto 20px;
	background-color: #fff;
	border-radius: 15px;
}
.size-set {
	font-size: 18px;
	font-weight: bold;
}
.form-whats {
	position: relative;
}
.send {
	position: absolute;
	top: 2px;
	right: 22px;
	font-size: 22px;
	cursor:pointer;
}
.form-group.field-whatsappshareform-phone, .field-whatsappshareform-phone > .form-group{
    margin-bottom:0;
}
.wts-ap{position:relative;}
.wts-ap h3 {
    margin: 0;
    font-size: 14px;
    color: #fff;
    margin-bottom: 8px !important;
    font-family: roboto;
}
.wts-ap input {
    font-family: roboto;
    width: 100%;
    margin: auto;
    height: 40px;
    border-radius: 6px;
    padding: 5px 10px;
}
.fa-send {
    position: absolute;
    bottom: 0px;
    right: 13px;
    font-size: 24px;
    width: 40px;
    cursor:pointer;
}
.follow-btn{
    background:#ff7803;
    box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
    border-radius: 2px;
    font-family: Open Sans;
    font-size: 13px;
    color:#fff;
    width: 32px;
    height: auto;
    padding: 15px 10px;
    text-align: center;
}
.follow-btn:hover{color:#fff;}
.job-thumb{
    width: 125px !Important;
    height: 125px !Important;
    background-color: #fff;
    display: block;
    overflow: hidden;
    line-height: 125px;
    margin: auto;
    border-radius: 50%;
}
#logo_img {
    max-width: 100px !Important;
    max-height: 100px !Important;
    background-color: #fff;
    object-fit: contain;
}
.overlay-top{
    width: 80% !Important;
    margin: auto;
    margin-top: -150px;
    float: none;
    background-color: #333a44;
    z-index: 9;
    padding-top: 20px;
    padding-bottom: 50px;
}
.organization-details{
    display: block;
    text-align: center;
}
.organization-details a{color:#fff;}
.organization-details h4{
    font-size:14px !Important;
    margin-top:15px !important;
}
a.add-or-compare {
    display: inline-block !important;
    background-color: #fff;
    padding:5px;
    width: 42%;
    font-size: 12px;
    font-family: roboto;
    border-radius: 2px;
    color: #333;
    margin-top: 15px;
    box-shadow: 0px 0px 10px -2px #ddd;
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}
.single-btn{
    display:inline-block;
}
a.add-or-compare.full-width {
    width:175px;
}
a.add-or-compare:hover, a.add-or-compare:focus {
    background-color:#00a0e3;
    color:#fff;
    border-radius:6px;
}
.add-or-compare i {
    display: block;
}
.hvr-icon-pulse {
    display: inline-block;
    vertical-align: middle;
    -webkit-transform: perspective(1px) translateZ(0);
    transform: perspective(1px) translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
    padding-right:1.2em;
}
.hvr-icon-pulse .hvr-icon {
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
    -webkit-transition-timing-function: ease-out;
    transition-timing-function: ease-out;
}
.hvr-icon-pulse:hover .hvr-icon, .hvr-icon-pulse:focus .hvr-icon, .hvr-icon-pulse:active .hvr-icon {
    -webkit-animation-name: hvr-icon-pulse;
    animation-name: hvr-icon-pulse;
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-timing-function: linear;
    animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
}
.hvr-icon-pulse:before{
    content:"" !important;
}
.effect {
  width: 100%;
}
.effect .buttons {
  display: block;
  padding: 10px 0px;
}
.effect a {
	text-decoration: none !important;
	width: 32px;
	height: 32px;
	display: inline-block;
	border-radius: 50%;
	margin: 0 5px 5px;
	font-size: 17px;
	overflow: hidden;
	position: relative;
	color: #fff;
	border: 2px solid #fff;
	line-height: 26px;
}
.effect a i {
	font-size: 14px;
}
.effect a.facebook-f:hover{
    background:#3b5998;
    border-color:#3b5998;
} 
.effect a.twitter-t:hover{
    background:#1DA1F2;
    border-color:#1DA1F2;
} 
.effect a.linked-l:hover{
    background:#3B5998;
    border-color:#3B5998;
}
.effect a.whatsapp-w:hover{
    background:#4FCE5D;
    border-color:#4FCE5D;
}
.effect a.enve-e:hover{
    background:#DB4437;
    border-color:#DB4437;
}
.effect a.tg-tele:hover{
    background-color:#0088cc;
    border-color:#0088cc;  
}
.intl-tel-input, .iti {
    width: 100%;
}
.intl-tel-input .country-list, .iti .country-list {
    max-width: 260px;
}
.input-group-addon{
    color: #555 !Important;
    background-color: #eee !Important;
}
.country-list{z-index:99 !important;}
/* thurio effect */
//.effect.thurio a {
//  transition: border-radius 0.2s linear 0s;
//  -webkit-transform: rotate(45deg);
//          transform: rotate(45deg);
//}
//.effect.thurio a i {
//  transition: -webkit-transform 0.01s linear 0s;
//  transition: transform 0.01s linear 0s;
//  transition: transform 0.01s linear 0s, -webkit-transform 0.01s linear 0s;
//  -webkit-transform: rotate(-45deg);
//          transform: rotate(-45deg);
//}
//.effect.thurio a:hover {
//  border-radius: 0px;
//}

.view-all-a{
    margin-top: 15px;
    display: block;
    color: #ddd;
}
.move-anim-btn {
    font-family: roboto;
    font-size: 16px;
    background: #00a0e3;
    color: white;
    padding: 0.5em 1em;
    padding-left: 0.9em;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 4px;
    overflow: hidden;
    transition: all 0.2s;
    width: 150px;
    margin: 0 auto;
}
.move-anim-btn span {
     display: block;
     margin-left: 0.3em;
     transition: all 0.3s ease-in-out;
}

.move-anim-btn i {
 display: block;
 transform-origin: center center;
 transition: transform 0.3s ease-in-out;
}

.move-anim-btn:hover i {
 transform: translateX(3.2em) rotate(45deg) scale(1.1);
 color:#fff;
}

.move-anim-btn:hover span {
 transform: translateX(8em);
 color: #fff;
}

@keyframes fly-1 {
 from {
  transform: translateY(0.1em);
 }

 to {
  transform: translateY(-0.1em);
 }
}
@media only screen and (max-width: 991px) {
    .job-single-head.style2.overlay-top{
        margin-top: 0;
        width: 100% !important;
    }
    .overlay-top{
        padding-bottom:10px;
    }
    .job-head-info{
//        max-width: 275px;
        text-align: center;
    }
    .job-head-info .organization-details h4{
        margin-left:0px !Important;
    }
    .actions-main{
//        float: left;
        display: inline-block;
        width: 42%;
    }
    a.add-or-compare{
        padding: 10px 5px;
    }
    .effect.thurio{
        clear:both;
    }
    .showOnTab{
        display: block;
    }
    .btn-parent{
        position: fixed;
        bottom:28px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9;
        background: rgba(0,0,0,.1);
        padding: 7px;
    }
}
@media only screen and (max-width: 720px) {
    .actions-main{
        width: 30%;
        font-size:11px;
    }
}
@media only screen and (max-width: 640px) {
    a.add-or-compare{
        width:97%;
        padding: 13px 5px;
    }
    .add-or-compare i{display:inline-block;}
}
@media only screen and (max-width: 640px) {
    a.add-or-compare{
        width: 44%;
    }
    .actions-main {
        width: 100%;
    }
    .btn-parent{
        left:28px;
        }
}
@media only screen and (max-width: 430px) {
    .job-head-info {
        max-width: inherit;
        text-align: center;
    }
    .organization-details {
        text-align: center;
    }
    .job-head-info h4{
        margin-left:0px !Important;
    }
    .btn-parent{
        position: fixed;
        bottom:0px;
    }
}
@media only screen and (max-width: 380px) {
.btn-parent{
    left:0px;
    }
}
');
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);