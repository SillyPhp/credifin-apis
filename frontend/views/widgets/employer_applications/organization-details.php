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
                            color="<?= $initial_color; ?>" font="60px"></canvas>
                    <?php
                }
                ?>
            </a>
        </div>
        <div class="job-head-info">
            <a href="/<?= $slug; ?>"><h4><?= $org_name; ?></h4></a>
            <div class="organization-details">
                <?php if ($website): ?>
                    <p><i class="fas fa-unlink"></i><a href="<?= $website; ?>"><?= $website; ?></a></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="actions-main">
            <?php if (Yii::$app->user->isGuest): ?>
                <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="apply-job-btn single-btn"><i
                            class="fas fa-paper-plane"></i>Apply</a>
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
                       class="add-or-compare hvr-icon-pulse"><i class="far fa-heart hvr-icon"></i>Save</a>
                </div>
            <?php else: ?>
                <?php if ($applied): ?>
                    <a href="#" title="" class="apply-job-btn single-btn" disabled="disabled"><i
                                class="fas fa-check"></i>Applied</a>
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
                        <a href="#" class="apply-job-btn apply-btn hvr-icon-pulse"><i
                                    class="fas fa-paper-plane hvr-icon"></i>Apply for <?= $type ?></a>
                        <!--                        <a href="#" class="follow-btn apply-btn hvr-icon-pulse"><i class="fas fa-plus hvr-icon"></i></a>-->
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
        <div class="down-img">
            <h3>Download Sharing Image</h3>
            <a href="<?= $image; ?>" download target="_blank"><i class="fa fa-download"></i> Regular Size (1250*650)</a>
            <a href="<?= $Instaimage; ?>" download target="_blank"><i class="fa fa-download"></i> Square Size (800*800)</a>
        </div>
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
.down-img h3 {  
	color: #fff;
	font-size: 15px;
	font-family: roboto;
	margin: 10px 0 15px;
}
.down-img a {
	color: #fff;
	border: 2px solid #fff;
	padding: 8px 25px;
	font-size: 14px;
	font-family: roboto;
	font-weight: 500;
	border-radius:6px;
	display: inline-block;
    margin: 5px 0px;
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
.job-thumb a{
    width: 125px !Important;
    height: 125px !Important;
    background-color: #fff;
    display: block;
    margin: auto;
    border-radius: 50%;
}
.job-thumb a img{
    margin:5px;
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
#logo_img {
    width: 115px !Important;
    height: 115px !Important;
}
.organization-details{
    display: block;
    text-align: left;
    padding: 25px;
}
.organization-details h4{
    font-size:14px !Important;
    margin-top:15px !important;
}
a.add-or-compare {
    display: inline-block !important;
    background-color: #fff;
    padding: 10px 16px 0;
    width: 42%;
    font-size: 14px;
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
  width: 40px;
  height: 40px;
  display: inline-block;
  border-radius: 50%;
  margin: 0 5px;
  font-size: 17px;
  overflow: hidden;
  position: relative;
  color: #fff;
  border: 2px solid #fff;
}
.effect a i {
  position: relative;
  z-index: 3;
}
.effect a i {
  display: inline-block;
  vertical-align: middle;
  margin-left: 0px;
  margin-top: 2px;
}
.effect a.facebook-f:hover{
    background:#3b5998;
    border-color:#3b5998;
} 
.effect a.twitter-t:hover{
    background:#6699FF;
    border-color:#6699FF;
} 
.effect a.linked-l:hover{
    background:#0e76a8;
    border-color:#0e76a8;
}
.effect a.whatsapp-w:hover{
    background:#25D366;
    border-color:#25D366;
}
.effect a.enve-e:hover{
    background:#00a0e3;
    border-color:#00a0e3;
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

@media only screen and (max-width: 991px) {
    .job-single-head.style2.overlay-top{
        margin-top: 0;
        width: 100% !important;
    }
    .job-single-head.style2 .job-thumb{
        margin-top:0px;
        margin-left:10px;
    }
    .overlay-top{
        padding-bottom:10px;
    }
    .job-thumb{
        max-width: 125px;
    }
    .job-head-info{
        max-width: 275px;
        text-align: left;
    }
    .job-head-info h4{
        margin-left:25px !Important;
    }
    .job-head-info .organization-details h4{
        margin-left:0px !Important;
    }
    .actions-main{
        float: left;
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
        bottom:0px;
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
}
@media only screen and (max-width: 430px) {
    .job-thumb {
        max-width: inherit;
    }
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
        left: 0px;
    }
}
');
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);