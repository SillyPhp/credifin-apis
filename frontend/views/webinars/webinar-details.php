<?php

use common\models\Users;
use yii\helpers\Url;
use yii\widgets\Pjax;

$cookies_request = Yii::$app->request->cookies;
$refcode = $cookies_request->get('ref_csrf-webinar');
$promo = false;
$promo = \frontend\models\referral\PromoCodes::getVarify($refcode);
$time = date('Y/m/d H:i:s', strtotime($nextEvent['start_datetime']));
$registeration_status = $webResig['status'];
$interest_status = $userInterest['interest_status'];
$status = $webinar['status'];
$this->title = $webinar['title'];
$image = $webinar['image'];
$keywords = $webinar['title'];
$description = 'Present-day education is radically different from that of the past. The youth are unaware of and oblivious to the importance of recognizing and embracing these changes. They are also utterly lost on their career path and have no idea where their career is taking them.';
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl("https"),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouthin',
        'twitter:creator' => '@EmpowerYouthin',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl("https"),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
Yii::$app->view->registerJs('var webinar_id = "' . $webinar['webinar_enc_id'] . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var user_id = "' . Yii::$app->user->identity->user_enc_id . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var access_key = "' . Yii::$app->params->razorPay->prod->apiKey . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var interest_status = "' . $interest_status . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var refcode = "' . $refcode . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var registeration_status = "' . $registeration_status . '"', \yii\web\View::POS_HEAD);

function finalAmount($totalPrice, $gstAmount)
{
    if ($gstAmount) {
        $gstPercent = $gstAmount;
        if ($totalPrice > 0) {
            $gstAmount = round($gstPercent * ($totalPrice / 100), 2);
        }
    }
    $finalPrice = $totalPrice + $gstAmount;
    return (($finalPrice == 0) ? 'Free' : '₹ ' . $finalPrice);
}

function webDate($webDate)
{
    $date = $webDate;
    $sec = strtotime($date);
    $newDate = date('d-M', $sec);
    return $newDate;
}
$baseUrl = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory;
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <script type="text/javascript">
        alert('Please Register This Webinar to play quiz');
    </script>
<?php endif; ?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript" src="https://addevent.com/libs/atc/1.6.1/atc.min.js" async defer></script>
<script type="text/javascript">
    window.addeventasync = function(){
        addeventatc.settings({
            appleical  : {show:true, text:"Apple Calendar"},
            google     : {show:true, text:"Google <em>(online)</em>"},
            office365  : {show:true, text:"Office 365 <em>(online)</em>"},
            outlook    : {show:true, text:"Outlook"},
            outlookcom : {show:true, text:"Outlook.com <em>(online)</em>"},
            yahoo      : {show:true, text:"Yahoo <em>(online)</em>"}
        });
    };
</script>
<section>
    <div class="full-width-light"
         style="">
        <div class="title-main">
            <img src="<?= $webinar['image'] ?>" class="absolute">
            <div class="element-percent">
                <h1><?= $webinar['title'] ?></h1>
                <div class="register-btn btn-parent" id="registerEventSection">
                    <?php
                    $btnName = 'Register Now';
                    if (Yii::$app->user->isGuest && !$is_expired) {
                        ?>
                        <a href="javascript:;" data-toggle="modal" data-target="#loginModal"
                           class="ra-btn autoRegisterAfter"><?= $btnName ?></a>
                    <?php } else {
                        ?>
                        <button id="loadingBtn" style="display: none" class="ra-btn">
                            Processing <i class="fas fa-spinner fa-spin"></i>
                        </button>
                        <?php
                        if($is_expired){
                            ?>
                            <a href="<?= Url::to('/webinars')?>" class="ra-btn">Back To Home</a>
                            <?php
                        } else if($registeration_status == 1) {
                            ?>
                            <button class="ra-btn">Registered</button>
                            <?php
                        } else {
                            if ((int)$webinar['price']) {
                                if ($promo) { ?>
                                    <button class="ra-btn registerBtn" id="registerBtn"><?= $btnName ?></button>
                                <?php } else { ?>
                                    <button class="ra-btn" id="paidRegisterBtn"><?= $btnName ?></button>
                                <?php }
                                ?>
                                <?php
                            } else {
                                ?>
                                <button class="ra-btn registerBtn" id="registerBtn"><?= $btnName ?></button>
                                <?php
                            }
                        }
                        ?>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="webinar-detail-bg">
    <div class="ts-count-down">
        <div class="container">
            <div class="row">
                <?php Pjax::begin(['id' => 'webinar_join_link']); ?>
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="countdown gradient clearfix">
                        <?php if ($is_expired) { ?>
                            <div>
                                <p class="expiredtext">This Webinar Has Expired</p>
                            </div>
                        <?php } elseif ($webinar['status'] == 1 || $webinar['status'] == 0) { ?>
                            <div id="join">
                                <?php if (Yii::$app->user->isGuest) { ?>
                                    <a id="joinBtn" href="javascript:;" data-toggle="modal" data-target="#loginModal">Click
                                        here to Join</a>
                                <?php } else {
                                    if ($webinar['webinar_conduct_on'] == 1) { ?>
                                        <a id="joinOtherBtn" href="<?= $webinar_link ?>" target="_blank">Click
                                            here to Join</a>
                                    <?php } else { ?>
                                        <a id="joinBtn"
                                           href="javascript:;" data-link="<?= $share_link ?>"
                                           data-id="<?= $nextEvent['session_enc_id'] ?>">Click
                                            here to Join</a>
                                    <?php }
                                } ?>
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
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
    <?php if (!empty($webinar['description'])){ ?>
    <div class="webinar-details">
        <div class="container">
            <div class="row">
                <div class="detail-flex">
                    <h2 class="section-title">
                        Webinar Details
                    </h2>
                    <?php if ($webinar['webinar_conduct_on'] == 1 && $webinar_link && !$is_expired) { ?>

                        <div class="copy-join-link">
                            <div class="link-descriptions" id="link-show">
                                <img src="<?= Url::to('@eyAssets/images/pages/webinar/zoom-logo.png')?>" alt="">
                                <a class="copy-clip view-link" title="View link" id="link-cop" data-link="<?= $webinar_link ?>">Copy Joining Link</a>
                            </div>
                        </div>

                    <?php } ?>
                    
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
                                <i class="fas fa-calendar-day"></i> <?= date('d F Y', strtotime($nextEvent['start_datetime'])) ?>
                            </p>
                            <p>
                                <i class="far fa-clock"></i> <?= date('h:i A', strtotime($nextEvent['start_datetime'])) ?>
                            </p>
                            <p><i class="fas fa-users"></i> <?= $webinar['seats'] ?> Seats</p>
                            <p><i class="fas fa-microphone-alt"></i> <?= count($assignSpeaker) ?> Speakers</p>
                            <p>
                                <i class="fas fa-rupee-sign"></i> <?= ((int)$webinar['price']) ? ceil($webinar['price']) : "Free" ?>
                            </p>
                        </div>
                        <div class="flex2">
                            <?php Pjax::begin(['id' => 'webinar_registations']); ?>
                            <div class="avatars">
                                <ul class="ask-people">
                                    <?php
                                    if ($register) {
                                        foreach ($register as $reg) { ?>
                                            <li>
                                                <img src="<?= Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $reg['image_location'] . '/' . $reg['image']) ?>">
                                            </li>
                                        <?php }
                                    } ?>
                                </ul>
                                <?php
                                if (!empty($webinarRegistrations)) { ?>
                                    <p>
                                        <span><?= ($webinar["slug"] == "new-age-investment-strategies-10407") ? 2 * count($webinarRegistrations) : count($webinarRegistrations); ?></span>
                                        People Registered</p>
                                <?php }
                                ?>
                            </div>
                            <?php Pjax::end(); ?>
                            <div class="register-action">
                                <?php
                                if (Yii::$app->user->isGuest && !$is_expired) {
                                    ?>
                                    <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="ra-btn"
                                       value="interested">Interested <span id="interestCount">(<?= 50 + rand(1,10) + $interestCount?>)</span></a>
                                    <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="ra-btn"
                                       value="not interested">Not Interested</a>
                                    <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="ra-btn">Attending</a>
                                    <!-- Button code -->
                                    <div title="Add to Calendar" class="addeventatc">
                                        Add to Calendar
                                        <span class="start"><?= date('m/d/Y h:i A', strtotime($nextEvent['start_datetime'])) ?></span>
                                        <span class="end"><?= date('m/d/Y h:i A', strtotime($nextEvent['end_datetime'])) ?></span>
                                        <span class="timezone">Asia/Kolkata</span>
                                        <span class="title"><?= $webinar['title'] ?></span>
                                        <span class="description"><?= $webinar['description'] ?></span>
                                    </div>
                                <?php } else if($registeration_status != 1 && !$is_expired) { ?>
                                    <?php
                                    if ((int)$webinar['price']) {
                                        if ($promo) { ?>
                                            <button class="ra-btn registerBtn" id="registerBtn2"><?= $btnName ?></button>
                                        <?php } else { ?>
                                            <button class="ra-btn" id="paidRegisterBtn2"><?= $btnName ?></button>
                                        <?php }
                                        ?>
                                        <?php
                                    } else {
                                        ?>
                                        <button class="ra-btn registerBtn" id="registerBtn2"><?= $btnName ?></button>
                                        <?php
                                    }
                                    ?>
                                    <button class="ra-btn interestBtn <?php echo $interest_status == 1 ? 'actionColor' : '' ?>"
                                            id="interested" data-key="<?= $webinar['webinar_enc_id'] ?>"
                                            value="1">Interested <span id="interestCount">(<?= 50 + rand(1,10) + $interestCount?>)</span>
                                    </button>
                                    <button class="ra-btn interestBtn <?php echo $interest_status == 2 ? 'actionColor' : '' ?>"
                                            id="notInterested" data-key="<?= $webinar['webinar_enc_id'] ?>"
                                            value="2">Not Interested
                                    </button>
                                    <button class="ra-btn interestBtn <?php echo $interest_status == 3 ? 'actionColor' : '' ?>"
                                            id="attending" data-key="<?= $webinar['webinar_enc_id'] ?>"
                                            value="3">Attending
                                    </button>
                                    <!-- Button code -->
                                    <div title="Add to Calendar" class="addeventatc">
                                        Add to Calendar
                                        <span class="start"><?= date('m/d/Y h:i A', strtotime($nextEvent['start_datetime'])) ?></span>
                                        <span class="end"><?= date('m/d/Y h:i A', strtotime($nextEvent['end_datetime'])) ?></span>
                                        <span class="timezone">Asia/Kolkata</span>
                                        <span class="title"><?= $webinar['title'] ?></span>
                                        <span class="description"><?= $webinar['description'] ?></span>
                                    </div>
                                <?php } else if(!$is_expired){
                                    ?>
                                    <!-- Button code -->
                                    <div title="Add to Calendar" class="addeventatc">
                                        Add to Calendar
                                        <span class="start"><?= date('m/d/Y h:i A', strtotime($nextEvent['start_datetime'])) ?></span>
                                        <span class="end"><?= date('m/d/Y h:i A', strtotime($nextEvent['end_datetime'])) ?></span>
                                        <span class="timezone">Asia/Kolkata</span>
                                        <span class="title"><?= $webinar['title'] ?></span>
                                        <span class="description"><?= $webinar['description'] ?></span>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</section>
<?php
    if($webinar["slug"] == 'new-age-investment-strategies-10407'){
        echo $this->render('/widgets/webinar-quiz-banner');
    }
?>
<!-- Schedules event section start here -->
<section class="ts-schedule">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <h2 class="section-title text-center">
                    <span>Schedule Details</span>
                    Event Schedule
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
                                        <span><?= date('h:i A', strtotime($v['event_time'])) ?> - <?= date('h:i A', strtotime($v['endtime'])) ?></span>
                                        <!--                                                Workshop-->
                                    </div>
                                    <div class="schedule-slot-info">
                                            <?php
                                            $image = Url::to('@eyAssets/images/pages/webinar/default-user.png');
                                            $speaker_icon = $v['webinarSpeakers'][0]['image'];
                                            $speaker_icon_path = $v['webinarSpeakers'][0]['image_location'];
                                            if ($speaker_icon) {
                                                $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $speaker_icon_path . DIRECTORY_SEPARATOR . $speaker_icon;
                                            }
                                            ?>
                                            <img class="schedule-slot-speakers" src="<?= $image ?>" alt="">
                                        <div class="schedule-slot-info-content">
                                            <h3 class="schedule-slot-title"><?= $v['webinarSpeakers'][0]['fullname'] ?>
                                                <!--                                                <strong>@ Fredric Martinsson</strong>-->
                                            </h3>
                                            <p><?= ucwords($v['webinarSpeakers'][0]['designation']) ?></p>
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
<?php if($webinar['other_details']) {?>
<section class="other-details-web">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="section-title">Other Details</h2>
            </div>
            <div class="col-md-12">
                <div class="webinar-description">
                    <p>
                        <?= $webinar['other_details'] ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php }?>

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
<!-- ts speaker start-->
<section id="ts-speakers" class="ts-speakers speaker-classic">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <h2 class="section-title text-center">
                    <span>Listen to the</span>
                    Event Speakers
                </h2>
            </div><!-- col end-->
        </div><!-- row end-->
        <div class="row d-flex">
            <?php if (!empty($assignSpeaker)) {
            foreach ($assignSpeaker

            as $as) {
            $designation = ucwords($designation);
            ?>
            <div class="col-lg-3 col-md-6">
                <div class="ts-speaker open-sp-modal">
                    <div class="speaker-img">
                        <?php if ($as['speaker_image']) { ?>
                            <img class="img-fluid" src="<?= $as['speaker_image'] ?>">
                        <?php } else { ?>
                            <img class="img-fluid" src="<?= $as['speaker_image_fake'] ?>">
                        <?php } ?>
                        <a href="#<?= $as['speaker_enc_id'] ?>" class="view-speaker ts-image-popup"
                           data-effect="mfp-zoom-in">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                    <div class="ts-speaker-info">
                        <h3 class="ts-title"><a href="#"><?= $as['fullname'] ?></a></h3>
                        <p>
                            <?php if ($designation) { ?>
                                <?= $designation ?>
                            <?php } ?>
                        </p>
                    </div>
                </div>
                <!-- popup start-->
                <div id="<?= $as['speaker_enc_id'] ?>" class="container ts-speaker-popup mfp-hide">
                    <div class="row">
                        <div class="speaker-flex">
                            <?php
                            if ($as['speaker_image']) {
                                $image = $as['speaker_image'];
                            } else {
                                $image = $as['speaker_image_fake'];
                            }
                            ?>
                            <div class="speak-img" style="background-image: url('<?= $image; ?>');">

                            </div><!-- col end-->
                            <div class="speak-cntnt">
                                <div class="ts-speaker-popup-content">
                                    <h3 class="ts-title"><?= $as['fullname'] ?></h3>
                                    <?php if ($designation) { ?>
                                        <span class="speakder-designation"><?= $designation ?></span>
                                    <?php }
                                    if ($as['org_image']) {
                                        ?>
                                        <img class="company-logo"
                                             src="<?= $as['org_image'] ?>">
                                    <?php }
                                    if ($as['org_name']) { ?>
                                        <span class="speakder-designation"><?= $as['org_name'] ?></span>
                                    <?php }
                                    if ($as['description']) {
                                        ?>
                                        <p>
                                            <?= $as['description'] ?>
                                        </p>
                                    <?php } ?>
                                    <div class="ts-speakers-social">
                                        <?php if ($as['facebook']) { ?><a
                                            href="https://www.facebook.com/<?= $as['facebook'] ?>" target="_blank"><i
                                                        class="fab fa-facebook-f"></i></a><?php } ?>
                                        <?php if ($as['twitter']) { ?><a
                                            href="https://twitter.com/<?= $as['twitter'] ?>"
                                            target="_blank"><i class="fab fa-twitter"></i>
                                            </a><?php } ?>
                                        <?php if ($as['instagram']) { ?><a
                                            href="https://www.instagram.com/<?= $as['instagram'] ?>" target="_blank"><i
                                                        class="fab fa-instagram"></i></a><?php } ?>
                                        <?php if ($as['linkedin']) { ?><a
                                            href="https://www.linkedin.com/in/<?= $as['linkedin'] ?>" target="_blank"><i
                                                        class="fab fa-linkedin-in"></i></a><?php } ?>
                                    </div>
                                </div><!-- ts-speaker-popup-content end-->
                            </div><!-- col end-->
                        </div>
                    </div><!-- row end-->
                </div><!-- popup end-->
            </div>
            <?php }
            } ?><!-- col end-->
        </div><!-- row end-->
    </div><!-- container end-->
</section>
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
            <div class="row outflex">
                <?php foreach ($outComes

                as $oc){ ?>
                <div class="col-lg-3 col-md-6 outcome-item">
                    <?php if ($oc['bg_colour']) {
                    $color_code = '#' . $oc['bg_colour'];
                    $reduceColor = createPalette($color_code, $colorCount = 1);
                    ?>
                    <div class="ts-single-outcome">
                        <?php } else {
                        $color_code = '#000';
                        $reduceColor = createPalette($color_code, $colorCount = 1);
                        ?>
                        <div class="ts-single-outcome">
                            <?php } ?>
                            <?php if ($oc['icon']) { ?>
                                <div class="out-img">
                                    <img src="<?= Url::to($baseUrl.Yii::$app->params->upload_directories->webinars->outcome->icon . $oc['icon_location'] . DIRECTORY_SEPARATOR . $oc['icon']) ?>">
                                </div>
                            <?php } else { ?>
                                <div class="out-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/webinar/default-outcome.png') ?>">
                                </div>
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
<?php
if ($upcoming) {
?>
<section class="upcoming-web">
    <div class="container">
        <div class="row">
            <div class="heading-style">Upcoming Webinars</div>
        </div>
        <div class="row">
            <?php
                foreach ($upcoming as $web) {
                    ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="web-card">
                            <div class="web-img">
                                <a href="<?= Url::to("/webinar/" . $web['slug']) ?>">
                                    <img src="<?= $web['image'] ?>"></a>
                                <div class="web-detail-date">
                                    <div class="web-date">
                                        <?php
                                        $eventDate = webDate($web['webinarEvents'][0]['start_datetime']);
                                        echo $eventDate;
                                        ?>
                                    </div>
                                    <div class="web-paid">
                                        <?php
                                        $finalPrice = finalAmount($web['price'], $web['gst']);
                                        echo $finalPrice;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="web-inr">
                                <div class="web-title"><a
                                            href="<?= Url::to("/webinar/" . $web['slug']) ?>"><?= $web['name'] ?></a>
                                </div>
                                <div class="web-speaker">
                                    <span><?= str_replace(',', ', </span><span>', trim($web['speakers'])) ?></span>
                                </div>
                                <div class="web-des"><?= $web['description'] ?></div>
                            </div>
                            <div class="reg-btn-count">
                                <div class="register-count">
                                    <div class="reg-img">
                                        <?php
                                        if (count($web['webinarRegistrations']) > 0) {
                                            $reg = 1;
                                            foreach ($web['webinarRegistrations'] as $uImage) {
                                                if ($uImage['createdBy']['image']) {
                                                    ?>
                                                    <span class="reg<?= $reg ?> reg">
                                        <img src="<?= $uImage['createdBy']['image'] ?>">
                                    </span>
                                                    <?php
                                                    $reg++;
                                                }
                                                if ($reg == 4) {
                                                    break;
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <span class="cont"> <?= count($web['webinarRegistrations']) ?> Registered</span>
                                </div>
                                <?php if (array_search(Yii::$app->user->identity->user_enc_id, array_column($web['webinarRegistrations'], 'created_by'))) { ?>
                                    <div class="register-btns">
                                        <a href="<?= Url::to("/webinar/" . $web['slug']) ?>" class="btn-drib"> Registered</a>
                                    </div>
                                <?php } else { ?>
                                    <div class="register-btns">
                                        <a href="<?= Url::to("/webinar/" . $web['slug']) ?>" class="btn-drib"><i
                                                    class="icon-drib fa fa-arrow-right"></i> Register Now</a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
</section>
<?php
}
?>
<!-- problem widget start -->
<section class="cntct">
    <div class="container">
        <div class="row">
            <div class="contact-req">
                <h3>if you are facing any problem during registration call us on :</h3>
                <a href="tel:+917009076638">+917009076638</a>
            </div>
        </div>
    </div>
</section>
<!-- problem widget end -->
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
.tab-content{
    padding: 15px 0;
}
.ts-intro-outcome .section-title span{
    font-size: 25px;
    font-weight: 800;
}
.addeventatc{
    max-height: 40px;
    margin-top: 5px;
    padding: 12px 12px 12px 43px;
    z-index:999 !Important;
}
.outflex {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    justify-content: center;
}
.show-l{display:none;}
span.copy-clip {
    color: #8b8b8b !important;
    font-size: 14px !important;
}
.detail-flex {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    padding:0 15px;
}
.copy-join-link {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}
.link-descriptions{
    margin: 20px 0 5px;
    max-width: 164px;
    position: relative;
    display: flex;
    align-items: center;
    padding: 1px 6px;
    border-radius: 0 10px 0 10px;
    cursor: pointer;
    border: 2px solid #4a8cff;
    transition: all .3s ease-out;
}
.link-descriptions:hover{
    background: #4a8cff;
    transition: all .3s ease-out;
}
.link-descriptions:hover a{
    color: #fff;
    transition: all .3s ease-out;
}
p.show-l {
    max-width: 250px;
    overflow: hidden;
    max-height: 25px;
    margin: 0;
    text-align: right;
}
.link-descriptions img {
    width: 30px;
    height: 30px;
    margin-right: 4px;
    object-fit: cover;
}
.link-descriptions a {
    transition: all .3s ease-out;
    color: #4a8cff;
    font-weight: 600;
}
.d-flex{
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}
.cntct{
    background: linear-gradient(178deg, #00a0e3 20%, #fff 110%);
    padding-bottom: 20px;
}
.contact-req {
    text-align: center;
}
.contact-req h3 {
	font-size: 25px;
	font-family: lora;
	text-transform: uppercase;
	color: #fff;
	font-weight: 600;
	margin: 5px 0 15px 0;
}
.contact-req a {
    color: #fff;
    background-color: #ff7803e8;
    padding: 8px 20px;
    border-radius: 4px;
    font-family: roboto;
    font-size: 18px;
    text-transform: uppercase;
    font-weight: 600;
}
.us-marg{
    margin-top:2px;
}
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
  margin: 0;
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
  object-fit: cover;
  object-position: top;
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

//.schedule-listing:hover .schedule-slot-title {
//  color: #3b1d82;
//}

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
    background-position: top;
    background-size: cover;
}
.flex-use {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
.register-btn{text-align:center;}
.register-btn .ra-btn {
    width: 200px;
    height: 50px;
    font-size:18px;
}
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

#joinBtn, #joinOtherBtn, .expiredtext{
    font-size: 25px;
    padding: 48px;
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
.web-card:hover {
	box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
	transform: translateY(-3px);
	transition: all .2s;
}
.header-web {
    background-color: #E8F6EF;
    position: relative;
    overflow: hidden;
    min-height: 500px;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
.back-shadow {
    position: absolute;
    top: -22%;
    right: 0;
    width: 50%;
    background-color: #00a0e3;
    height: 144%;
    border-radius: 50% 0 0 50%;
}
.header-txt h1 {
    font-size: 44px;
    font-family: roboto;
    font-weight: 700;
    margin-top: 0px;
    color: #00a0e3;
    margin-bottom: 0;
    letter-spacing: 1.5px;
    text-transform: uppercase;
}
.header-txt h2 {
    font-size: 20px;
    font-family: roboto;
    margin: 0 0 0 8px;
    color: #707070;
    font-weight: 500;
    text-transform: capitalize;
}
.header-img {
    width: 350px;
    margin: auto;
}
.web-form{
    margin: -9px 0px 0px 2px;
}
.web-form label{
    font-size: 18px;
    font-family: roboto;
    font-weight: 400;
    color: #333;
    margin-bottom: 6px;
}
.web-form input,
.web-form textarea{
     border: 1px solid #d4caca;
     padding: 6px;
     border-radius: 4px;
     width: 100%;
     height:40px;
     line-height:22px !important;
     margin-bottom: 10px;
}
.web-form textarea{
    margin-bottom: 10px;
    height: 100px;
}
.web-button{
    text-align:center;  
}
.web-button button{
    font-family: roboto;
    font-size: 16px;
    padding: 12px 21px;
    border-radius: 4px;
    border:none;
    background-color: #fff;
    color: #000;
    transition:all .3s;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    margin-top: 20px;
    border: 1px solid #d4caca;
}
.web-button button:hover{
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    background-color: #00a0e3;
    color: #fff;
}
.req-web{
    display: flex;
    background-color: #3e8cf9;
    flex-direction: column;
    justify-content: space-between;
}
.req h1{
    font-size: 36px;
    text-align: center;
    font-family: lobster;
    padding: 20px  0 10px;
    color: #fff;
}
.req p{
    font-size: 16px;
    color: #fff;
    text-align: center;
    font-family: roboto;
    font-weight: 400;
    margin:0 0 5px 0;
}
.req-icon {
    max-width: 350px;
    margin: 0 auto;
}
.register-count {
	font-family: roboto;
	color: #f97364;
	font-weight: 500;
	display: flex;
	align-items: center;
}
.reg img {
    width: 35px;
    border-radius: 81px;
    height: 30px;
    object-fit: cover;
    border: 2px solid #fff;
}
.reg2.reg, .reg3.reg {
    margin-left: -25px;
}
.cont {
    margin-left: 5px;
}
.web-card {
	border-radius: 6px;
	overflow: hidden;
	box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
	background-color:#fff;
	margin-bottom:20px;
}
.web-img {
	position: relative;
}
.web-img img{
	height: 200px;
	object-fit: cover;
	width: 100%;
}
.web-detail-date {
    position: absolute;
    bottom: 5px;
    right: 10px;
    display:flex;
    align-items: center;
}
.webinar-date {
    border-radius: 4px;
    padding: 0px 8px;
    text-align: center;
    border: 2px solid #00a0e3;
    font-weight: 500;
    font-family: roboto;
    background-color: #00a0e3;
    color: #fff;
    margin-right: 2px;
}
.web-paid{
    background-color: #ff7803;
    border: 2px solid #ff7803;
    border-radius: 4px;
    padding: 0px 8px;
    text-align: center;
    text-transform: uppercase;
    font-family: roboto;
    font-weight: 500;
    color: #fff;
}
.web-inr {
	padding: 5px 10px 10px;
}
.web-title{
	font-size: 22px;
	font-family: lora;
	font-weight: 600;
	display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.web-title a{
    color: #333
}

.web-title a:hover{
    color: #00a0e3;
}
.web-speaker {
	font-size: 12px;
	font-family: roboto;
	color: #a49f9f;
	font-weight: 500;
}
.web-des {
	font-family: roboto;
	display: -webkit-box;
	-webkit-line-clamp: 3;
	-webkit-box-orient: vertical;
	overflow: hidden;
	height: 75px;
}
.register-btns:hover .btn-drib{
    color:#fff;
}
.btn-drib:hover .icon-drib{
  animation: bounce 1s infinite;
  color:#fff;
}
@keyframes bounce {
    from, 20%, 53%, 80%, to {
      animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
      transform: translate3d(0, 0, 0);
    }
    40%, 43% {
      animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
      transform: translate3d(0, -6px, 0);
    }
    70% {
      animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
      transform: translate3d(0, -4px, 0);
    }
    90% {
      transform: translate3d(0, -2px, 0);
    }
  }
.btn-drib {
	border: 1px solid transparent;
	color: #fff;
	text-align: center;
	font-size: 14px;
	border-radius: 5px;
	cursor: pointer;
	padding: 6px 10px;
	background-color: #00a0e3;
	font-family:roboto;
	font-weight:500;
}
.icon-drib {
  margin-right: 5px;
}
.reg-btn-count {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 0 10px 10px;
}
@media screen and (max-width: 991px){
    .btn-parent {
        position: fixed;
        bottom: 28px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9;
        background: rgba(0,0,0,.1);
        padding: 7px;
    }
}
@media screen and (min-width: 991px){
    .md-flex{
        display:flex;
    }
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
        min-height:50vh;
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
    margin-right: -25px;
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
    background: rgba(0, 0, 0, 0.2);
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
    border: 2px solid #fff;
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
    height: 80vh;
    object-fit: cover;
    object-position: top;
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
    background-image: -webkit-linear-gradient(-60deg, #ff5858 0%, #f09819 100%);
    background-image: -o-linear-gradient(-60deg, #ff5858 0%, #f09819 100%);
    background-image: linear-gradient(-60deg, #ff5858 0%, #f09819 100%);
    -webkit-box-shadow: 0px 20px 30px 0px rgba(0, 0, 0, 0.12);
    box-shadow: 0px 20px 30px 0px rgba(0, 0, 0, 0.12);
    padding: 55px 0;
    -o-transition: all 0.4s ease;
    transition: all 0.4s ease;
    -webkit-transition: all 0.4s ease;
    -moz-transition: all 0.4s ease;
    -ms-transition: all 0.4s ease;
    margin-bottom: 30px !important;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-content: center;
    margin: auto;
}
.out-img {
    width: 80px;
    height: 80px;
    margin: auto;
}

.ts-single-outcome i {
    font-size: 80px;
    color: #fff;
    display: block;
    margin-bottom: 30px; 
}
.ts-single-outcome .ts-title {
    color: #fff;
    text-transform: capitalize;
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
.outcome-item:nth-of-type(6n-1) .ts-single-outcome {
    background-image: -webkit-linear-gradient(340deg, #fc6076 0%, #ff9a44 100%);
    background-image: -o-linear-gradient(340deg, #fc6076 0%, #ff9a44 100%);
    background-image: linear-gradient(110deg, #fc6076 0%, #ff9a44 100%);
}

.outcome-item:nth-of-type(6n-2) .ts-single-outcome {
    background-image: -webkit-radial-gradient(50% 50%, #57c6e1 0%, #b49fda 0%, #7ac5d8 0%, #eea2a2 0%, #b1aff0 0%, #836df0 100%);
    background-image: -o-radial-gradient(50% 50%, #57c6e1 0%, #b49fda 0%, #7ac5d8 0%, #eea2a2 0%, #b1aff0 0%, #836df0 100%);
    background-image: radial-gradient(50% 50%, #57c6e1 0%, #b49fda 0%, #7ac5d8 0%, #eea2a2 0%, #b1aff0 0%, #836df0 100%);
}

.outcome-item:nth-of-type(6n-3) .ts-single-outcome {
    background-image: -webkit-linear-gradient(135deg, #22ffa4 0%, #43c47a 49%, #10ae23 100%);
    background-image: -o-linear-gradient(135deg, #22ffa4 0%, #43c47a 49%, #10ae23 100%);
    background-image: linear-gradient(-45deg, #22ffa4 0%, #43c47a 49%, #10ae23 100%);
}

.outcome-item:nth-of-type(6n-4) .ts-single-outcome {
    background-image: -webkit-linear-gradient(135deg, #22e1ff 0%, #1d8fe1 49%, #625eb1 100%);
    background-image: -o-linear-gradient(135deg, #22e1ff 0%, #1d8fe1 49%, #625eb1 100%);
    background-image: linear-gradient(-45deg, #22e1ff 0%, #1d8fe1 49%, #625eb1 100%);
}

.outcome-item:nth-of-type(6n-5) .ts-single-outcome {
    background-image: -webkit-linear-gradient(to top, #7028e4 0%, #e5b2ca 100%);
    background-image: -o-linear-gradient(to top, #7028e4 0%, #e5b2ca 100%);
    background-image: linear-gradient(to top, #7028e4 0%, #e5b2ca 100%);
}

.outcome-item:nth-of-type(6n-6) .ts-single-outcome {
    background-image: -webkit-linear-gradient(to top, #ff0844 0%, #ffb199 100%);
    background-image: -o-linear-gradient(to top, #ff0844 0%, #ffb199 100%);
    background-image: linear-gradient(to top, #ff0844 0%, #ffb199 100%);
}

.ts-count-down {
    padding: 0;
    margin: -80px 0 0 0;
    z-index: 3;
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
    margin:20px 0 5px;
    font-size: 36px;
    font-weight: 800;
    color: #333;
    position: relative;
//    text-align: center;
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
    width: 140px;
    line-height: 40px;
    background: #00a0e3;
    color: #fff;
    border: none;
    margin:5px 5px;
}
.vc-ra-btn{
    font-size: 14px;
    height: 40px;
    padding: 0 15px;
    /* width: 150px; */
    line-height: 40px;
    background: #00a0e3;
    color: #fff;
    border: none;
    margin: 5px 5px;
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
//    background: url(' . Url::to('@eyAssets/images/pages/webinar/webinar-cover.png') . ');
    height: 90vh;
    background-size: cover;
    background-position: center;
    position: relative;
}
.absolute{
    position: absolute;
    width: 100%;
    z-index: 1;
    top: 0;
    left: 0;
    max-height: 90vh;
    height:100%; 
    object-fit: cover;
    object-position: top center;
}
.element-percent {
    background:#585858d6;
    width: 100%;
    margin: 0 auto;
    height: 90vh;
    display: inline-block;
    padding-top: 28vh;
    z-index: 2;
    position: relative;
}
.element-percent h1 {
    color: #fff;
    font-weight: 700;
    text-align: center;
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
    font-family:roboto;
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
    flex-wrap: wrap;
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
.ts-book-seat {
  background-image:linear-gradient(110deg, #FF7803 50%, #fff 143%);
  position: relative;
  padding: 40px 0;
}
.ts-book-seat:after {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
//  background-image: url(../../../public/images/lines-2.png);
  content: \'\';
  background-repeat: no-repeat;
  background-position: center;
  z-index: 0;
}
.ts-book-seat .book-seat-content {
  position: relative;
  z-index: 1;
}
.ts-book-seat .book-seat-content .section-title {
  margin-bottom: 40px;
  font-size: 24px;
  max-width:600px;
  margin:auto;
}
.ts-book-seat .book-seat-content .section-title span{
  margin-top: 15px;
  color:#fff;
}
.ts-book-seat .book-seat-content p {
  color: #fff;
  margin-bottom: 20px;
}
.ts-book-seat .book-seat-content .section-title {
  margin-bottom: 0px;
  font-size: 28px;
}
.ts-book-seat .book-seat-content .section-title span{
  margin-top: 15px;
}
.ts-book-seat .book-seat-content p {
  color: #fff;
  margin-bottom: 20px;
}
.section-title img {
    max-height: 80px;
    margin-bottom:20px;
}
.section-list{
  color: #fff;
  text-align: left;
  line-height: 20px;
  max-width: 600px;
  margin: auto;
  list-style: disc;
}
.section-list li{
  font-size: 16px;
}
.ts-book-seat.second {
  background:#00008b;
}
@media (max-width: 767px) {
.section-list{
    padding:10px 30px;
}
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
let registeration_status = '$registeration_status';
console.log(registeration_status);
if(registeration_status == '1'){
    openUserDetailsModal();
}
if(localStorage.getItem('autoRegisterAfter') == "true"){
    if(window.location.href == localStorage.getItem('autoRegisterUrl')){
        var date = + new Date();
        var last = JSON.parse(localStorage.getItem('autoRegisterTime'));
        if ((date - last) < ( 2 * 60 * 1000 ) ) {
           setTimeout(function() {
               if($('#registerBtn').length > 0) {
                   $('#registerBtn').trigger('click');  
               }
               if($('#paidRegisterBtn').length > 0) {
                   $('#paidRegisterBtn').trigger('click');  
               }
               localStorage.removeItem('autoRegisterAfter');
               localStorage.removeItem('autoRegisterTime');
               localStorage.removeItem('autoRegisterUrl');
           },1000)
        } else{
           localStorage.removeItem('autoRegisterAfter');
           localStorage.removeItem('autoRegisterTime');
           localStorage.removeItem('autoRegisterUrl');
        }
    } else{
        if ((date - last) < ( 2 * 60 * 1000 ) ) {
           localStorage.removeItem('autoRegisterAfter');
           localStorage.removeItem('autoRegisterTime');
           localStorage.removeItem('autoRegisterUrl');
        }
    }
}
$(document).on('click', '.autoRegisterAfter', function(){
   localStorage.setItem('autoRegisterAfter', true); 
   localStorage.setItem('autoRegisterTime', + new Date()); 
   localStorage.setItem('autoRegisterUrl', window.location.href); 
});
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
$(document).on('click','#paidRegisterBtn, #paidRegisterBtn2',function(event){
    var btn = $(this);
    var demobtn = $('#loadingBtn');
    $.ajax({
        url: '/api/v3/webinar/request-payment',
        method: 'POST',
        data: {webinar_enc_id: webinar_id, created_by : user_id},
        beforeSend: function() {
            demobtn.show();
            btn.hide();
        },  
        success: function(res) {
            if(res.response.status == "200"){
                var callback = res.response.callback;
                var ptoken = callback.payment_token;
                var payment_enc_id = callback.payment_enc_id;
                var reg_id = callback.registration_enc_id;
                if (ptoken!=null || ptoken !=""){
                    //processPayment(ptoken,payment_enc_id,webinar_id,reg_id);
                    _razoPay(ptoken,payment_enc_id,webinar_id);
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
            btn.show();
            demobtn.hide();
        }
    });
});
$(document).on('click','.interestBtn',function(event){
    event.preventDefault();
     var btn = $(this);
     var value = btn.attr('value');
     if(value != interest_status){
        $.ajax({
            url: '/webinars/record-interest',
            type: 'POST',
            data: {wid: webinar_id,value: value},
            beforeSend:function(){
                $("button.interestBtn").attr("disabled","disabled");  
            },
            success:function(res){
                if(res.status == 200){
                    toastr.success(res.message, res.title);
                } else {
                    toastr.error(res.message, res.title);
                }
                $("button.interestBtn").attr("disabled",false);  
            }
        });
        interest_status = value;
     } else {
        toastr.info('Message', 'Already Updated..');
     }
});
$(document).on('click','#registerBtn, #registerBtn2',function(event){
    event.preventDefault();
     var btn = $(this);
     var demobtn = $('#loadingBtn');
    $.ajax({
        url: '/webinars/registration',
        type: 'POST',
        data: {wid: webinar_id,refcode:refcode},
        beforeSend: function() {
            demobtn.show();
            btn.hide();
        },
        success:function(res){
            btn.show();
            demobtn.hide();
            switch (res.status) {
                case 200 :
                    toastr.success(res.message, res.title);
                    btn.text("Registered");
                    btn.attr("id","");
                    window.location.reload();
                    break;
                case 203 :
                    toastr.info(res.message, res.title);
                    break;
                default :
                    toastr.error(res.message, res.title);
            }
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
$(document).on('click','#joinBtn', function (e){
    var ths = $(this);
    var open_link = ths.attr('data-link');
    var id = ths.attr('data-id');
    var link = "/mentors/webinar-" + open_link + "?id=" + id;
    if(open_link == "live"){
           if(typeof open_link !== "undefined" || typeof id !== "undefined"){
                window.location.href = link;
            } else {
                toastr.error("Something went wrong..", "Undefined");
            }
    } else {
        if(registeration_status != ""){
            // use is registered
            if(typeof open_link !== "undefined" || typeof id !== "undefined"){
                window.location.href = link;
            } else {
                toastr.error("Something went wrong..", "Undefined");
            }
        } else {
            // not registered
            $('#registerEventSection').find('button:visible').click();
        }   
    }
});  
function _razoPay(ptoken,payment_enc_id,webinar_id){
    var options = {
    "key": access_key, 
    "name": "Empower Youth",
    "description": "Registration Fee",
    "image": "/assets/common/logos/logo.svg",
    "order_id": ptoken, 
    "handler": function (response){
        updateStatus(payment_enc_id,response.razorpay_payment_id,"captured",response.razorpay_signature);
    },
    "prefill": {
        "name": $('#applicant_name').val(),
        "email": $('#email').val(),
        "contact": $('#mobile').val()
    },
    "theme": {
        "color": "#ff7803"
    }
};
     var rzp1 = new Razorpay(options);
     rzp1.open();
     rzp1.on('payment.failed', function (response){
         updateStatus(payment_enc_id,null,"failed");
      swal({
      title:"Error",
      text: response.error.description,
      });
});
}
function updateStatus(payment_enc_id,payment_id=null,status,signature=null)
{
    $.ajax({
        url : '/api/v3/webinar/update-status',
        method : 'POST', 
        data : {
          payment_enc_id:payment_enc_id,
          payment_id: payment_id, 
          signature:signature,
          status:status, 
        },
        success:function(res)
        {
            if(res.response.status == 200){
                swal({ 
                    title:"Message",
                    text: "Payment Successfully Captured & It will reflect in sometime..",
                 });
            }
            location.reload();
        }
    })
}

$(document).on("click","#joinRegisterBtn", function() {
    $('#registerEventSection').find('button:visible').click();
});



    function CopyToClipboard(value, showNotification, notificationText) {
        var temp = $("<input>");
        $("body").append(temp);
        temp.val(value).select();
        document.execCommand("copy");
        temp.remove();
        toastr.success("", "Link Copy to Clipboard");
    }
    
    
    $("#link-show").click(function () {
        var link = $('#link-cop').attr('data-link');
        CopyToClipboard(link, true, "Link copied");
    });

    
JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/js/magnific-popup.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/jquery-jCounter.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/css/magnific-popup.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerCssFile('//code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css');
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

    function registerEvent() {
        $('#paidRegisterBtn').click();
    }
</script>
