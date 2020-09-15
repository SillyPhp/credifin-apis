<?php

use common\models\WebinarPayments;
use yii\helpers\Url;
use yii\widgets\Pjax;

if (Yii::$app->params->paymentGateways->mec->icici) {
    $configuration = Yii::$app->params->paymentGateways->mec->icici;
    if ($configuration->mode === "production") {
        $access_key = $configuration->credentials->production->access_key;
        $secret_key = $configuration->credentials->production->secret_key;
        $url = $configuration->credentials->production->url;
    } else {
        $access_key = $configuration->credentials->sandbox->access_key;
        $secret_key = $configuration->credentials->sandbox->secret_key;
        $url = $configuration->credentials->sandbox->url;
    }
}
$time = $webinar['start_datetime'];
//$interest_status = $webResig['interest_status'];
$interest_status = $userInterest['interest_status'];
$status = $webinar['status'];
$this->title = $webinar['title'];
Yii::$app->view->registerJs('var webinar_id = "' . $webinar['webinar_enc_id'] . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var user_id = "' . Yii::$app->user->identity->user_enc_id . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var access_key = "' . $access_key . '"', \yii\web\View::POS_HEAD);
?>
<script id="context" type="text/javascript" src="https://payments.open.money/layer"></script>
<section>
    <div class="full-width-light"
         style="">
        <div class="title-main">
            <div class="element-percent">
                <h1><?= $webinar['title'] ?></h1>
            </div>
        </div>
    </div>
</section>
<section class="webinar-detail-bg">
    <div class="ts-count-down">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="countdown gradient clearfix">
                        <?php if ($status == 2) { ?>
                            <div>
                                <a id="joinBtn">Webinar Expired</a>
                            </div>
                        <?php } elseif ($webinar['status'] == 1 || $webinar['status'] == 0) { ?>
                            <div id="join">
                                <?php if (Yii::$app->user->isGuest) { ?>
                                    <a id="joinBtn" href="javascript:;" data-toggle="modal" data-target="#loginModal">Click
                                        here to Join</a>
                                <?php } else { ?>
                                    <a id="joinBtn"
                                       href="/mentors/webinar-<?= $share_link ?>?id=<?= $webinar['session_enc_id'] ?>">Click
                                        here to Join</a>
                                <?php } ?>
                            </div>
                            <div id="counter">
                                <div class="counter-item">
                                    <span class="days" id="days"></span>
                                    <div class="smalltext">Days</div>
                                    <b>:</b>
                                </div>
                                <div class="counter-item">
                                    <span class="hours" id="hours"></span>
                                    <div class="smalltext">Hours</div>
                                    <b>:</b>
                                </div>
                                <div class="counter-item">
                                    <span class="minutes" id="minutes"></span>
                                    <div class="smalltext">Minutes</div>
                                    <b>:</b>
                                </div>
                                <div class="counter-item">
                                    <span class="seconds" id="seconds"></span>
                                    <div class="smalltext">Seconds</div>
                                </div>
                            </div>
                        <?php } elseif ($status == 4) { ?>
                            <div>
                                <a id="joinBtn">Webinar Cancel</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($webinar['description'])){ ?>
    <div class="webinar-details">
        <div class="container">
            <div class="row">
                <div class="flex-use">
                    <div class="col-md-7 mx-auto">
                        <h2 class="section-title loc-set">
                            Webinar Details
                        </h2>
                    </div>
                    <div class="col-md-5">
                        <div class="register-btn">
                            <?php
                            $btnName = 'Register';
                            if (Yii::$app->user->isGuest) {
                                ?>
                                <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="ra-btn"
                                   value="interested"><?= $btnName ?></a>
                            <?php } else {
                                if ((int)$webinar['price']) {
                                    $paymentStatus = WebinarPayments::find()
                                        ->where(['webinar_enc_id' => $webinar['webinar_enc_id'], 'created_by' => $user_id])
                                        ->asArray()
                                        ->one();
                                    if ($paymentStatus['payment_status'] != 'captured') {
                                        ?>
                                        <button class="ra-btn"
                                                data-type="register" id="paidRegisterBtn"
                                                data-key="<?= $webinar['webinar_enc_id'] ?>"
                                                value="registered"><?= $btnName ?>
                                        </button>
                                        <?php
                                    } else {
                                        ?>
                                        <button class="ra-btn"
                                                data-type="register" id=""
                                                data-key="<?= $webinar['webinar_enc_id'] ?>"
                                                value="registered"> Registered
                                        </button>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                } else {
                                    ?>
                                    <button class="ra-btn registered"
                                            data-type="register" id="registerBtn"
                                            data-key="<?= $webinar['webinar_enc_id'] ?>"
                                            value="registered"><?= $btnName ?>
                                    </button>
                                    <?php
                                }
                                ?>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="webinar-description">
                        <p>
                            <?= $webinar['description'] ?>
                        </p>
                    </div>
                    <?php } ?>
                    <div class="sidebar text-center">
                        <div class="dis-flex">
                            <p>
                                <i class="fas fa-calendar-day"></i> <?= date('d F Y', strtotime($webinar['start_datetime'])) ?>
                            </p>
                            <p><i class="far fa-clock"></i> <?= date('h:i A', strtotime($webinar['start_datetime'])) ?>
                            </p>
                            <p><i class="fas fa-users"></i> <?= $webinar['seats'] ?> Seats</p>
                            <p><i class="fas fa-microphone-alt"></i> <?= count($assignSpeaker) ?> Speakers</p>
                            <p><i class="fas fa-rupee-sign"></i> <?= ((int)$webinar['price'])?ceil($webinar['price']):"Free" ?></p>
                        </div>
                        <div class="flex2">
                            <?php Pjax::begin(['id' => 'webinar_registations']); ?>
                            <div class="avatars">
                                <ul class="ask-people">
                                    <?php
                                    if ($register) {
                                        foreach ($register as $reg) { ?>
                                            <li>
                                                <img src="<?= Url::to(Yii::$app->params->upload_directories->users->image . $reg['image_location'] . '/' . $reg['image']) ?>">
                                            </li>
                                        <?php }
                                    } ?>
                                </ul>
                                <?php
                                if (!empty($webinarRegistrations)) { ?>
                                    <p><span><?= count($webinarRegistrations) ?></span>
                                        People Registered</p>
                                <?php }
                                ?>
                            </div>
                            <?php Pjax::end(); ?>
                            <div class="register-action">
                                <?php
                                if (Yii::$app->user->isGuest) {
                                    ?>
                                    <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="ra-btn"
                                       value="interested">Interested</a>
                                    <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="ra-btn"
                                       value="not interested">Not Interested</a>
                                    <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="ra-btn">Attending</a>
                                <?php } else { ?>
                                    <button class="ra-btn registered <?php echo $interest_status == 1 ? 'actionColor' : '' ?>"
                                            id="interested" data-key="<?= $webinar['webinar_enc_id'] ?>"
                                            value="1">Interested
                                    </button>
                                    <button class="ra-btn registered <?php echo $interest_status == 2 ? 'actionColor' : '' ?>"
                                            id="notInterested" data-key="<?= $webinar['webinar_enc_id'] ?>"
                                            value="2">Not Interested
                                    </button>
                                    <button class="ra-btn registered <?php echo $interest_status == 3 ? 'actionColor' : '' ?>"
                                            id="attending" data-key="<?= $webinar['webinar_enc_id'] ?>"
                                            value="3">Attending
                                    </button>
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>
<!-- sharing widget start -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            $sharingLink = Url::base('https') . '/webinar/' . $webinar['slug'];
            echo $this->render('/widgets/sharing-widget-webinar', [
                'sharingLink' => $sharingLink
            ]) ?>
        </div>
    </div>
</div>
<!-- sharing widget end -->

<!-- Schedules event section start here -->
<section class="ts-schedule">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <h2 class="section-title text-center">
                    <span>Schedule Details</span>
                    Event Schedules
                </h2>
                <div class="ts-schedule-nav">
                    <ul class="nav nav-tabs justify-content-center" role="tablist">
                        <?php
                        $dcount = 1;
                        foreach ($dateEvents as $key => $de) {
                            $active = "";
                            if ($dcount == 1) {
                                $active = 'active';
                            }
                            ?>
                            <li class="nav-item <?= $active ?>">
                                <a class="" title="Click Me" href="#<?= $key ?>" role="tab"
                                   data-toggle="tab">
                                    <!--                                    <h3>5th June</h3>-->
                                    <h3><?= date('jS M', strtotime($key)) ?></h3>
                                    <span><?= date('l', strtotime($key)) ?></span>
                                </a>
                            </li>
                            <?php
                            $dcount++;
                        }
                        ?>
                    </ul>
                    <!-- Tab panes -->
                </div>
            </div><!-- col end-->

        </div><!-- row end-->
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content schedule-tabs schedule-tabs-item">
                    <?php
                    $ddcount = 1;
                    foreach ($dateEvents as $key => $de) {
                        $active = "";
                        if ($ddcount == 1) {
                            $active = "active";
                        }
                        ?>
                        <div role="tabpanel" class="tab-pane <?= $active ?>" id="<?= $key ?>">
                            <?php
                            foreach ($de as $k => $v) {
                                ?>
                                <div class="schedule-listing">
                                    <div class="schedule-slot-time">
                                        <!--                                                <span> 07.30 - 11.30 PM</span>-->
                                        <span><?= date('H:i A', strtotime($v['event_time'])) ?> - <?= date('H:i A', strtotime($v['endtime'])) ?></span>
                                        <!--                                                Workshop-->
                                    </div>
                                    <div class="schedule-slot-info">
                                        <a href="#">
                                            <?php
                                            $image = Url::to('@eyAssets/images/pages/webinar/default-user.png');
                                            if ($v['image']) {
                                                $image = Yii::$app->params->upload_directories->users->image . $v['image_location'] . DIRECTORY_SEPARATOR . $v['image'];
                                            }
                                            ?>
                                            <img class="schedule-slot-speakers" src="<?= $image ?>" alt="">
                                        </a>
                                        <div class="schedule-slot-info-content">
                                            <h3 class="schedule-slot-title"><?= $v['webinarSpeakers'][0]['fullname'] ?>
                                                <!--                                                <strong>@ Fredric Martinsson</strong>-->
                                            </h3>
                                            <p><?= $v['description'] ?></p>
                                        </div>
                                        <!--Info content end -->
                                    </div><!-- Slot info end -->
                                </div>
                                <?php
                            }
                            ?>
                        </div><!-- tab pane end-->
                        <?php
                        $ddcount++;
                    }
                    ?>
                </div>

            </div>
        </div>
    </div><!-- container end-->
</section>
<!-- Schedules event section end here -->

<!-- ts speaker start-->

<!-- ts speaker end-->
<!-- ts intro start -->
<?php if (!empty($outComes)) { ?>
    <section class="ts-intro-outcome">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <h2 class="section-title text-center">
                        <span>Why Join us</span>
                        Event Outcomes
                    </h2>
                </div>
            </div><!-- row end-->
            <div class="row">
                <?php foreach ($outComes

                as $oc){ ?>
                <div class="col-lg-3 col-md-6 outcome-item">
                    <?php if ($oc['bg_colour']) {
                    $color_code = '#' . $oc['bg_colour'];
                    $reduceColor = createPalette($color_code, $colorCount = 1);
                    ?>
                    <div class="ts-single-outcome"
                         style="background-image: linear-gradient(110deg,<?= $color_code ?> 0%,<?= $reduceColor[0] ?> 136%)">
                        <?php } else {
                        $color_code = '#000';
                        $reduceColor = createPalette($color_code, $colorCount = 1);
                        ?>
                        <div class="ts-single-outcome"
                             style="background: linear-gradient(110deg,<?= $color_code ?> 0%,<?= $reduceColor[0] ?> 136%)">
                            <?php } ?>
                            <?php if ($oc['icon']) { ?>
                                <img src="<?= Url::to(Yii::$app->params->upload_directories->categories->outcomes->image . $oc['icon_location'] . DIRECTORY_SEPARATOR . $oc['icon']) ?>">
                            <?php } else { ?>
                                <img src="<?= Url::to('@eyAssets/images/pages/webinar/default-outcome.png') ?>">
                            <?php } ?>
                            <h3 class="ts-title"><?= $oc['name'] ?></h3>
                        </div><!-- single outcome end-->
                    </div><!-- col end-->
                    <?php } ?>
                </div>
            </div><!-- container end-->
    </section>
<?php } ?>
<!-- ts intro end-->
<!-- ts sponsors start-->

<?php
function color_mod($hex, $diff)
{
    $rgb = str_split(trim($hex, '# '), 2);
    foreach ($rgb as &$hex) {
        $dec = hexdec($hex);
        if ($diff >= 0) {
            $dec += $diff;
        } else {
            $dec -= abs($diff);
        }
        $dec = max(0, min(255, $dec));
        $hex = str_pad(dechex($dec), 2, '0', STR_PAD_LEFT);
    }
    return '#' . implode($rgb);
}

function createPalette($color, $colorCount = 4)
{
    $colorPalette = array();
    for ($i = 1; $i <= $colorCount; $i++) {
        if ($i == 1) {
            $color = $color;
            $colorVariation = -(($i * 4) * 15);
        }
        if ($i == 2) {
            $color = $newColor;
            $colorVariation = -($i * 15);
        }
        if ($i == 3) {
            $color = $newColor;
            $colorVariation = -($i * 15);
        }
        if ($i == 4) {
            $color = $newColor;
            $colorVariation = -($i * 15);
        }
        $newColor = color_mod($color, $colorVariation);
        array_push($colorPalette, $newColor);
    }
    return $colorPalette;
}

$this->registerCss('
.ts-schedule-nav {
  text-align: center;
  margin-bottom: 90px;
}

.ts-schedule-nav ul {
  border: none;
  justify-content: center;
  display: flex;
}

.ts-schedule-nav ul li {
  margin: 0 3px;
}

.ts-schedule-nav ul li a {
  font-size: 12px;
  color: #222222;
  text-transform: uppercase;
  background: #f1f0f6;
  display: block;
  padding: 20px 50px;
  position: relative;
}

.ts-schedule-nav ul li a:before {
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 0 15px 15px 0;
  border-color: transparent #00a0e3 transparent transparent;
  position: absolute;
  left: 0;
  bottom: -15px;
  content: \'\';
  opacity: 0;
  -o-transition: all 0.4s ease;
  transition: all 0.4s ease;
  -webkit-transition: all 0.4s ease;
  -moz-transition: all 0.4s ease;
  -ms-transition: all 0.4s ease;
}

.ts-schedule-nav ul li a h3 {
  font-size: 24px;
  font-weight: 400;
  color: #222222;
  margin-bottom: 0;
  text-transform: capitalize;
}

.ts-schedule-nav ul li.active a, .ts-schedule-nav ul li:hover a {
  background: #00a0e3 !important;
  color: #fff;
}

.ts-schedule-nav ul li.active a h3 {
  color: #fff;
}

.ts-schedule-nav ul li.active a:before {
  opacity: 1;
}

.schedule-listing {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
  -ms-flex-direction: row;
  flex-direction: row;
}

.schedule-listing .schedule-slot-time {
  background: #008fca;
  color: #fff;
  padding: 60px 28px;
  font-size: 18px;
  font-weight: 700;
  -webkit-box-flex: 0;
  -ms-flex: 0 0 18%;
  flex: 0 0 18%;
  max-width: 18%;
}

.schedule-listing .schedule-slot-time span {
  display: block;
  line-height: 26px;
}

.schedule-listing .schedule-slot-info {
  position: relative;
  padding: 35px 40px 35px 170px;
  border: 1px dashed #e5e5e5;
  border-left: none;
  width: 100%;
}

.schedule-listing .schedule-slot-info .schedule-slot-speakers {
  position: absolute;
  left: 40px;
  top: 0;
  height: 80px;
  width: 80px;
  border-radius: 50%;
  -webkit-border-radius: 50%;
  -ms-border-radius: 50%;
  bottom: 0;
  margin: auto;
}

.schedule-listing .schedule-slot-info .schedule-slot-title {
  font-size: 24px;
}

.schedule-listing .schedule-slot-info .schedule-slot-title strong {
  font-size: 14px;
  color: #888888;
  margin-left: 12px;
}

.schedule-listing .schedule-slot-info p {
  margin-bottom: 0;
}

.schedule-listing:hover .schedule-slot-title {
  color: #3b1d82;
}

.schedule-listing:nth-of-type(even) .schedule-slot-time {
  background: #00a0e3;
}
.speaker-flex {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    min-height:80vh;
}
.speak-img, .speak-cntnt {
    flex: 0 0 50%;
    max-width: 50%;
}
.speak-img {
    background-position: center;
    background-size: cover;
}
.loc-set{
    text-align:left !important;
}
.flex-use {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
.register-btn{text-align:right;}
.register-btn a {
    font-size: 16px;
    height: 40px;
    padding: 9px 20px;
    width: 150px;
    line-height: 40px;
    background: #00a0e3;
    color: #fff;
    border: none;
    margin: 5px 5px;
}
#join{
display:none;
}
#counter{
display:none;
}
#joinBtn{
    font-size: 25px;
    padding: 35px;
    display: block;
    text-align: center;
    color: #fff;
}
.ra-btn.active{
  background-color: green;
  transform: scale(1.05);
  box-shadow: 0px 2px 10px 3px #ddd;
}
.mb2{
    margin-bottom: 20px
}
.phone-icon i{
transform: rotate(100deg);
}
.dis-flex{
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    margin-top: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,.1);
    padding: 10px 0 0 0;
}
.flex2{
    display:flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
}
.dis-flex p{
    flex: 1;
    font-size: 16px;
    font-family: roboto;
}
.dis-flex p i{
    color: #00a0e3;
    padding-right: 5px;
}
@media screen and (max-width: 768px){
    .dis-flex p{
        flex: auto;
        font-size: 16px;
        font-family: roboto;
    }
    .dis-flex{
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
    }
}
@media screen and (max-width: 550px){
    .flex2 {
    display: block;
    }
    .speak-img, .speak-cntnt {
    flex: inherit;
    max-width: 100%;
    width: 90% !important;
}
}
.ask-people{
    margin-top: 10px;
    margin-left: 20px;
}
.sidebar h5{
    font-size: 16px;
}
.ask-people li{
    width: 50px;
    height: 50px;
    border: 2px solid #fff;
    border-radius: 50%;
    display: inline-block;
    margin-right: -20px;
}
.ask-people li img{
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}
#footer{
    margin-top: 0px;
}
.webinar-details{
    font-family: roboto;
}
.webinar-title{
    text-align: center;
}
.webinar-title h1{
    color: #fff;
    font-size: 20px;
}
.ts-speakers {
    padding-top: 120px;
    padding-bottom: 40px;
    position: relative;
    overflow: hidden;
}

.ts-speaker {
    position: relative;
    text-align: center;
    margin-bottom: 55px;
}

.ts-speaker .speaker-img {
    width: 255px;
    height: 270px;
    position: relative;
    border-radius: 50%;
    -webkit-border-radius: 50%;
    -ms-border-radius: 50%;
    overflow: hidden;
    margin: auto auto 20px;
}

.ts-speaker .speaker-img img {
    width: 100%;
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1);
    -o-transition: all 0.4s ease;
    transition: all 0.4s ease;
    -webkit-transition: all 0.4s ease;
    -moz-transition: all 0.4s ease;
    -ms-transition: all 0.4s ease;
}

.ts-speaker .speaker-img:before {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    content: \'\';
    background: rgba(59, 29, 130, 0.5);
    -o-transition: all 0.4s ease;
    transition: all 0.4s ease;
    -webkit-transition: all 0.4s ease;
    -moz-transition: all 0.4s ease;
    -ms-transition: all 0.4s ease;
    opacity: 0;
    z-index: 1;
}

.ts-speaker .view-speaker {
    position: absolute;
    left: 0;
    top: 70%;
    right: 0;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    color: #fff;
    font-size: 22px;
    width: 50px;
    height: 50px;
    margin: auto;
    border: 2px solid #ddd;
    border-radius: 50%;
    -webkit-border-radius: 50%;
    -ms-border-radius: 50%;
    padding: 6px 0;
    -o-transition: all 0.4s ease;
    transition: all 0.4s ease;
    -webkit-transition: all 0.4s ease;
    -moz-transition: all 0.4s ease;
    -ms-transition: all 0.4s ease;
    opacity: 0;
    z-index: 2;
}

.ts-speaker .ts-title {
    margin-bottom: 0px;
}
.ts-title {
    font-family: lora;
}

.ts-speaker .ts-title a {
    color: #222222;
    text-transform: capitalize;
    height: 34px;
    font-size: 22px;
    display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
.ts-speaker-info p{
    height:23px;
}
.ts-speaker:hover .speaker-img img {
    -webkit-transform: scale(1.2);
    -ms-transform: scale(1.2);
    transform: scale(1.2);
}

.ts-speaker:hover .speaker-img:before {
    opacity: 1;
}

.ts-speaker:hover .view-speaker {
    top: 50%;
    opacity: 1;
}

.ts-speaker:hover .ts-title a {
    color: #e7015e;
}

.ts-speaker.white-text .ts-title a,
.ts-speaker.white-text p {
    color: #fff;
}

.speaker-classic {
    padding-top: 50px;
    margin-top: 50px;
    background-image:url(' . Url::to('@eyAssets/images/pages/webinar/speakers-bg.png') . ');
    background-repeat: no-repeat;
    background-size: cover;
}

.speaker-classic .ts-speaker {
    margin-bottom: 60px;
}

.speaker-classic .ts-speaker .speaker-img {
    width: 100%;
//    height: auto;
    border-radius: 0;
    -webkit-border-radius: 0;
    -ms-border-radius: 0;
}

.speaker-classic .ts-speaker .ts-speaker-info {
    position: absolute;
    right: 0;
    bottom: -13px;
    background: #fff;
    z-index: 1;
    width: 90%;
    padding: 20px 0 10px;
}

.speaker-classic .ts-speaker .ts-speaker-info .ts-title {
    margin-bottom: 0;
}

.speaker-classic .ts-speaker .ts-speaker-info p {
    font-family: roboto;
    font-size: 14px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    margin: 0 5px;
}

.speaker-shap img {
    position: absolute;
    left: 0;
    top: 0;
    max-width: 100px;
}

.speaker-shap img.shap1 {
    top: 15%;
}

.speaker-shap img.shap2 {
    bottom: 0;
    left: auto;
    top: 35%;
    right: 0;
    margin: auto;
}

.speaker-shap img.shap3 {
    top: auto;
    bottom: -25px;
    margin: auto;
    left: 6%;
}

.ts-speaker-popup {
    background: #fff;
    padding: 0;
    position: relative;
}

.ts-speaker-popup .ts-speaker-popup-img img {
    width: 100%;
}

.ts-speaker-popup .ts-speaker-popup-content {
    padding: 60px 40px;
}

.ts-speaker-popup .ts-speaker-popup-content .ts-title {
    margin-bottom: 10px;
}

.ts-speaker-popup .ts-speaker-popup-content .speakder-designation {
    display: block;
    font-size: 14px;
    margin-bottom: 20px;
}

.ts-speaker-popup .ts-speaker-popup-content .company-logo {
    margin-bottom: 15px;
}

.ts-speaker-popup .ts-speaker-popup-content p {
    margin-bottom: 25px;
}

.ts-speaker-popup .ts-speaker-popup-content h4 {
    font-size: 20px;
    font-weight: 700;
}

.ts-speaker-popup .ts-speaker-popup-content .session-name {
    margin-bottom: 15px;
}

.ts-speaker-popup .ts-speaker-popup-content .speaker-session-info p {
    color: #e7015e;
    margin-bottom: 30px;
}

.ts-speaker-popup .ts-speaker-popup-content .ts-speakers-social a {
    color: #ababab;
    margin-right: 18px;
}

.ts-speaker-popup .ts-speaker-popup-content .ts-speakers-social a:hover {
    color: #e7015e;
}

.ts-speaker-popup button.mfp-close {
    font-size: 30px;
}
.mfp-hide {
    display: none !important;
 }
.mfp-fade.mfp-bg {
    opacity: 0;
    -webkit-transition: all 0.15s ease-out;
    -moz-transition: all 0.15s ease-out;
    transition: all 0.15s ease-out;
}
.mfp-fade.mfp-bg.mfp-ready {
    opacity: 0.8;
}
.mfp-fade.mfp-bg.mfp-removing {
    opacity: 0;
}

.mfp-fade.mfp-wrap .mfp-content {
    opacity: 0;
    -webkit-transition: all 0.15s ease-out;
    -moz-transition: all 0.15s ease-out;
    transition: all 0.15s ease-out;
}
.mfp-fade.mfp-wrap.mfp-ready .mfp-content {
    opacity: 1;
}
.mfp-fade.mfp-wrap.mfp-removing .mfp-content {
    opacity: 0;
}

/*outcome*/
.ts-intro-outcome {
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center center;
  padding: 70px;
}

.ts-single-outcome {
  text-align: center;
  border-radius: 50%;
  -webkit-border-radius: 50%;
  -ms-border-radius: 50%;
  width: 250px;
  height: 250px;
//  background-image: -webkit-linear-gradient(340deg, #fc6076 0%, #ff9a44 100%);
//  background-image: -o-linear-gradient(340deg, #fc6076 0%, #ff9a44 100%);
//  background-image: linear-gradient(110deg, #fc6076 0%, #ff9a44 100%);
  -webkit-box-shadow: 0px 20px 30px 0px rgba(0, 0, 0, 0.12);
  box-shadow: 0px 20px 30px 0px rgba(0, 0, 0, 0.12);
  padding: 55px 0;
  -o-transition: all 0.4s ease;
  transition: all 0.4s ease;
  -webkit-transition: all 0.4s ease;
  -moz-transition: all 0.4s ease;
  -ms-transition: all 0.4s ease;
  margin-bottom: 30px;
}
.ts-single-outcome i {
    font-size: 80px;
    color: #fff;
    display: block;
    margin-bottom: 30px; 
}
.ts-single-outcome .ts-title {
    color: #fff;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    width: 80%;
    overflow: hidden;
    font-size: 16px;
    margin: 10px auto;
    font-family: roboto;
}
.ts-single-outcome:hover img {
    -webkit-animation-name: shake;
    animation-name: shake;
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both; 
}

.ts-count-down {
    padding: 0;
    margin: -80px 0 0 0;
    z-index: 1;
    position: relative;
}
.gradient {
//    background: rgba(0, 160, 227, .9);
    background-image: linear-gradient(144deg, #00C0FF 0%, #236CD7 51%, #4218B8 100%);
    width: 100%;
    height: 100%;
    position: relative;
//    opacity: 0.902; 
}
.ts-count-down .countdown {
    margin-bottom: 0;
    min-height: 138px;
}
.ts-count-down .countdown .counter-item {
    width: 25%;
    float: left;
    margin-right: 0;
    border: none;
    position: relative;
    height: auto;
}
.ts-count-down .countdown .counter-item {
    width: 25%;
    float: left;
    margin-right: 0;
    border: none;
    position: relative;
    height: auto;
}
.countdown .counter-item {
    display: inline-block;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    -webkit-border-radius: 50%;
    -ms-border-radius: 50%;
    text-align: center;
    color: #fff;
    margin-right: 18px;
    padding: 35px 0;
    position: relative;
}
.countdown .counter-item {
    text-align: center;
    color: #fff;
    font-size: 30px;
}
.countdown .counter-item .smalltext {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 2.5px;
}
.ts-count-down .countdown .counter-item b {
    position: absolute;
    right: 0;
    top: 50%;
    bottom: 0;
    margin: auto;
    font-size: 30px;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
}
b, strong {
    font-weight: bolder;
}
/*sponsers*/
	  .ts-intro-sponsors {
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
	padding: 50px 0 80px;
	font-family: roboto;
}

.section-title.white, .column-title.white {
    color: #fff;
}
.section-title, .column-title {
    font-size: 36px;
    font-weight: 800;
    color: #333;
    position: relative;
    text-align: center;
    font-family: lora;
}
.section-title span, .column-title span {
    display: block;
    font-size: 14px;
    font-family: "Roboto", sans-serif;
    font-weight: 400;
    line-height: 26px;
    color: #888888;
    text-transform: uppercase;
    letter-spacing: 1.4px;
    margin-bottom: 10px;
    margin-top: -5px;
}
.section-title.white::after, .column-title.white::after {
    background-image: url(../images/shap/title-white.png);
}
.section-title::after, .column-title::after {
    position: absolute;
    left: 0;
    top: 0;
    content: \'\';
    right: 0;
    background-image: url(../images/shap/title.png);
    background-repeat: no-repeat;
    background-size: center center;
    background-position: contain;
    width: 70px;
    height: 10px;
    margin: auto auto 0;
    top: auto;
    bottom: 0;
}
.text-center {
    text-align: center !important;
}
a:link, a:visited {
    text-decoration: none;
}
.ts-intro-sponsors .sponsors-logo img {
    margin: 0 38px 50px;
	vertical-align: middle;
}
.btn-sponsor {
    font-size: 16px;
    font-weight: 700;
    color: #fff;
    text-transform: uppercase;
    background: #00a0e3;
    height: 50px;
    padding: 15px 35px;
    line-height: 50px;
    border-radius: 3px;
    -webkit-border-radius: 3px;
    -ms-border-radius: 3px;
    -o-transition: all 0.4s ease;
    transition: all 0.4s ease;
    -webkit-transition: all 0.4s ease;
    -moz-transition: all 0.4s ease;
    -ms-transition: all 0.4s ease;
    outline: none;
    text-decoration: none;
    cursor: pointer;
}
.ra-btn{
    font-size: 14px;
    height: 40px;
    padding: 0 0;
    width: 150px;
    line-height: 40px;
    background: #00a0e3;
    color: #fff;
    border: none;
    margin:5px 5px;
}
.ra-btn:hover{
    box-shadow: 0 6px 8px rgba(0,0,0,.2);
    transition: .3s ease;
    color:#fff;
}
/*--*/
.bottom-social {
    padding: 40px 0;
    background-color: #E9E9E9;
    text-align: center;
    width: 100%;
}
.bottom-social a {
    color: #C3C2C2;
    font-size: 38px;
    margin: 0 25px;
}
/*---*/
.disabled{
    cursor: not-allowed;
}
.full-width-light {
    background-size: 100% !important;
    background-repeat: no-repeat !important;
}

.title-main {
    background: url(' . Url::to('@eyAssets/images/pages/webinar/webinar-cover.png') . ');
    height: 90vh;
    background-size: cover;
    background-position: center;
}

.element-percent {
    background: #00a0e3b8;
    width: 100%;
    margin: 0 auto;
//    padding-left: 12%;
    height: 90vh;
    display: inline-block;
//    -webkit-clip-path: polygon(0 0, 100% 0%, 75% 100%, 0% 100%);
//    clip-path: polygon(0 0, 100% 0%, 75% 100%, 0% 100%);
    display: flex;
    align-items: center;
    justify-content: center
}

.element-percent h1 {
    color: #fff;
    font-weight: 700;
    max-width: 70%;
}

.webinar-description, .sidebar {
//    padding-top: 30px;
}

.webinar-description h4, .web-heading {
    padding-top: 30px;
    margin-bottom: 20px !Important;
    color: #333;
    font-weight: 600;
    font-size: 22px;
    font-family: lora;
}

.webinar-description p {
    font-size: 17px;
    letter-spacing: .5px;
    text-align: justify;
    line-height: 26px;
    color: #333;
    margin-bottom: 30px;
}

.webinar-description ul {
    padding-left: 20px;
    list-style: circle;
}

.webinar-description ul li {
    margin: 10px;
}

div.icon {
    font-size: 1em; /* change icon size */
    display: block;
    position: relative;
    width: 9em;
    height: 9em;
    margin: 30px auto;
    background-color: #fff;
    border-radius: 0.6em;
    box-shadow: 0 1px 0 #bdbdbd, 0 2px 0 #fff, 0 3px 0 #bdbdbd, 0 4px 0 #fff, 0 5px 0 #bdbdbd, 0 0 0 1px #bdbdbd;
    overflow: hidden;
}

div.icon * {
    display: block;
    width: 100%;
    font-size: 1em;
    font-weight: bold;
    font-style: normal;
    text-align: center;
}

div.icon strong {
    position: absolute;
    top: 0;
    padding: 0.4em 0;
    color: #fff;
    background-color: #00a0e3;
    border-bottom: 1px dashed #00a0e3;
    box-shadow: 0 2px 0 #00a0e3;
}

div.icon em {
    position: absolute;
    bottom: 0.5em;
    color: #00a0e3;
}

div.icon span {
    font-size: 2.8em;
    letter-spacing: -0.05em;
    padding-top: 0.8em;
    color: #2f2f2f;
}

.sidebar h4 {
    margin: 20px 0px !important;
    text-align: center;
}

.register-action {
    display: flex;
    
}
.speaker-author {
    margin-right: 15px;
    float: left;
    width: 100px;
}

.speaker-author img {
    border-radius: 100%;
    width: 100%;
}

.speaker-content {
    overflow: hidden;
    position: relative;
}

.speaker-content h4 {
    font-size: 15px;
    font-weight: 600;
    margin: 10px 0px !important;
}

.speaker-content p {
    color: #708790;
    line-height: 24px;
    max-width: 100%;
    margin-bottom: 0;
}

.avatars {
    display: flex;
    align-items: center;
    margin-left: -20px;
}
.avatars p {
    font-size: 18px;
    padding-top: 10px;
    margin-left: 40px;
    margin-bottom: 0px;
}

.avatar {
    margin-left: -20px;
    position: relative;
    border: 1px solid #fff;
    border-radius: 50%;
    overflow: hidden;
    width: 40px;
    height: 40px;
}

.avatar img {
    width: 40px;
    height: 40px;
}
#attending.actionColor{
    background: #ff7803;
    transform: scale(1.05);
  box-shadow: 0px 2px 10px 3px #ddd;
}
#notInterested.actionColor{
    background: #FF0000;
    transform: scale(1.05);
  box-shadow: 0px 2px 10px 3px #ddd;
}
#interested.actionColor{
    background: #32CD32;
    transform: scale(1.05);
  box-shadow: 0px 2px 10px 3px #ddd;
}
@media (max-width: 767px) {
.schedule-listing {
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column; }
    .schedule-listing .schedule-slot-time {
      -webkit-box-flex: 0;
      -ms-flex: 0 0 100%;
      flex: 0 0 100%;
      max-width: 100%;
      padding: 20px 35px; }
    .schedule-listing .schedule-slot-info {
      padding: 35px 40px 35px 35px;
      border-left: 1px dashed #e5e5e5; }
      .schedule-listing .schedule-slot-info .schedule-slot-speakers {
        display: none; }
  .schedule-listing-btn {
    margin-top: 40px; }
  .ts-schedule-nav {
    margin-bottom: 40px; }
    .ts-schedule-nav ul li a {
      display: inline-block;
      padding: 20px 20px;
      margin: 5px 0; }
  .schedule-tabs-item .schedule-listing-item:before, .schedule-tabs-item .schedule-listing-item:after {
    display: none; }
  .schedule-tabs-item .schedule-listing-item.schedule-left {
    margin-top: 0;
    padding: 0px 110px 20px 0; }
  .schedule-tabs-item .schedule-listing-item.schedule-right {
    padding: 0px 20px 0px 110px;
    margin-bottom: 30px; }
  .schedule-tabs-item .schedule-listing-item .schedule-slot-speakers {
    top: 5px; }
}
');
$script = <<<JS
function countdown(e){
    var countDownDate = new Date(e).getTime();
    var x = setInterval(function() {
        // Get today's date and time
        var now = new Date().getTime();
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
        // Time calculations for days, hours, minutes and seconds
        $('#days').text(Math.floor(distance / (1000 * 60 * 60 * 24)));
        $('#hours').text(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
        $('#minutes').text(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)));
        $('#seconds').text(Math.floor((distance % (1000 * 60)) / 1000));
        if (distance <= 0) {
            clearInterval(x);
            $('#join').css('display','block');
            $('#counter').css('display','none');
        } else { 
            $('#counter').css('display','block');
            $('#join').css('display','none');
        }
    }, 1000);
};
countdown('$time');
$(document).on('click','#paidRegisterBtn',function(event){
    $.ajax({
        url: '/api/v3/webinar/request-payment',
        method: 'POST',
        data: {webinar_enc_id: webinar_id, created_by : user_id},
        success: function(res) {
            if(res.response.status == "200"){
                var callback = res.response.callback;
                var ptoken = callback.payment_token;
                var payment_enc_id = callback.payment_enc_id;
                var reg_id = callback.registration_enc_id;
                console.log(ptoken);
                if (ptoken!=null || ptoken !=""){
                    processPayment(ptoken,payment_enc_id,webinar_id,reg_id);
                } else{
                    swal({
                        title:"Error",
                        text: "Payment Gatway Is Unable to Process Your Payment At The Moment, Please Try After Some Time",
                    });
                }
            } else {
                swal({
                    title: "Error",
                    text: res.response.message,
                });    
            }
            
            swal({
                title: res.response.status,
                text: res.response.message,
            });
        }
    });
});
$(document).on('click','.registered',function(event){
    event.preventDefault();
     var btn = $(this);
     var web_id = btn.attr('data-key');
     var value = btn.attr('value');
    $.ajax({
        url: '/webinars/registration',
        type: 'POST',
        data: {wid: web_id,value: value},
        success:function(res){
            toastr.success('Registered Successfully..', 'Success');
            $.pjax.reload({container: '#webinar_registations', async: false});
        }
    });
});
   $('.ts-image-popup').magnificPopup({
      type: 'inline',
      closeOnContentClick: false,
      midClick: true,
      callbacks: {
         beforeOpen: function () {
            this.st.mainClass = this.st.el.attr('data-effect');
         }
      },
      zoom: {
         enabled: true,
         duration: 500, // don't foget to change the duration also in CSS
      },
      mainClass: 'mfp-fade',
   });
$(document).on('click','.open-sp-modal', function (){
   $(this).children().children('a').trigger('click');
});  

function processPayment(ptoken,payment_enc_id,webinar_id,reg_id)
{
    Layer.checkout({ 
        token: ptoken,
        accesskey: access_key
    }, 
    function(response) {
          // response.payment_token_id
           // response.payment_id  
        if (response.status == "captured") {
            updateStatus(payment_enc_id,response.payment_id,response.status, reg_id);
               swal({
                    title: "",
                    text: "Your Registration Successfully",
                    type:'success',
                    showCancelButton: false,  
                    confirmButtonClass: "btn-primary",
                    confirmButtonText: "Close",
                    closeOnConfirm: true, 
                    closeOnCancel: true
                     },
                        function (isConfirm) { 
                         location.reload(true);
                     }
                );
        } else if (response.status == "created") {
            updateStatus(payment_enc_id,response.payment_id,response.status, reg_id);
        } else if (response.status == "pending") {
          updateStatus(payment_enc_id,response.payment_id,response.status, reg_id);
        } else if (response.status == "failed") { 
           updateStatus(payment_enc_id,response.payment_id,response.status, reg_id);
        } else if (response.status == "cancelled") {
          updateStatus(payment_enc_id,response.payment_id,response.status, reg_id);
        }
    },
    function(err) { 
        swal({ 
                title:"Error",
                text: "Some Internal Server Error, Please Try After Some Time",
         });
    }
);
} 

function updateStatus(payment_enc_id, payment_id, status,reg_id)
{
    $.ajax({
            url : '/api/v3/webinar/update-status',
            method : 'POST', 
            data : {
              payment_status:status,
              payment_enc_id:payment_enc_id,
              payment_id: payment_id, 
              registration_enc_id: reg_id, 
            },
            success:function(resp)
            {
                if(res.response.status != 200){
                    swal({ 
                        title:"Message",
                        text: "Payment Successfully Captured & It will reflect in sometime..",
                     });
                }
            }
            
    })
}

JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/js/magnific-popup.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/jquery-jCounter.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/css/magnific-popup.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerCssFile('https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js');
?>
<script>
    let actionBtns = document.getElementsByClassName('ra-btn');
    for (let i = 0; i < actionBtns.length; i++) {
        actionBtns[i].addEventListener('click', function () {
            let actionColors = document.getElementsByClassName('actionColor');
            if (actionColors.length > 0) {
                actionColors[0].classList.remove('actionColor')
            }
            clickedEle = event.currentTarget;
            clickId = event.currentTarget.getAttribute('id');
            clickedEle.classList.toggle('actionColor');
        })
    }
</script>
