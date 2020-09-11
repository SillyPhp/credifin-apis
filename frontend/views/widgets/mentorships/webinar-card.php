<?php

use yii\helpers\Url;
$base_url = Url::base('https');
foreach ($webinars as $webinar) {
    ?>
    <div class="col-md-6">
        <div class="webinar-box">
            <div class="webinar-icon">
                <img src="<?= Url::to('@eyAssets/images/pages/jobs/default-cover.png') ?>">
            </div>
            <div class="web-date">
                <span class="cont"><?= date('d', strtotime($webinar['start_datetime'])) ?></span>
                <span class="abs"><?= date('F', strtotime($webinar['start_datetime'])) ?></span>
            </div>
            <div class="webinar-details">
                <div class="webinar-title"><?= $webinar['title'] ?></div>
                <div class="webinar-city"><i
                            class="far fa-clock"></i> <?= date('h:s A', strtotime($webinar['start_datetime'])) ?></div>
                <div class="webinar-desc"><?= $webinar['description'] ?></div>
            </div>
            <?php
            $registrationCount = count($webinar['webinarRegistrations']);
            if ($registrationCount) {
                ?>
                <div class="avatars">
                    <span class="avatar">
                        <img src="https://picsum.photos/70">
                    </span>
                    <span class="avatar">
                        <img src="https://picsum.photos/80">
                    </span>
                    <span class="avatar">
                        <img src="https://picsum.photos/90">
                    </span>
                    <span class="avatar">
                       <img src="https://picsum.photos/100">
                    </span>
                    <!-- Variable amount more avatars -->
                    <p><?= $registrationCount ?> People</p>
                </div>
                <?php
            }
            ?>
            <div class="new-btns">
                <div class="join-btn naam">
                    <?php
                    $dt = new \DateTime();
                    $tz = new \DateTimeZone('Asia/Kolkata');
                    $dt->setTimezone($tz);
                    $current_time = $dt->format('Y-m-d H:i:s');
                    $webinar_start_time = $webinar['start_datetime'];
                    $btn_id = 'join_btn';
                    $btnValue = 'Join Event';
                    $s_id = $webinar['session_enc_id'];
                    $w_id = $webinar['webinar_enc_id'];
                    $chkRegisteration = \common\models\WebinarRegistrations::findOne(['webinar_enc_id' => $webinar['webinar_enc_id'], 'created_by' => Yii::$app->user->identity->user_enc_id]);
                    if ($current_time < $webinar_start_time) {
                        if (!$chkRegisteration) {
                            $btn_id = 'register_btn';
                            $btnValue = 'Register';
                        } else {
                            $s_id = "";
                        }
                    } else {
                        if (!$chkRegisteration) {
                            $btnValue = 'Register & Join';
                            $btn_id = 'register_join_btn';
                        } else {
                            $btnValue = 'Join Now';
                        }
                    }
                    ?>
                    <button data-key="<?= $s_id ?>" data-id="<?= $w_id ?>"
                            id="<?= $btn_id ?>" type="button"><?= $btnValue ?></button>
                </div>
                <div class="detail-btn naam">
                    <button type="button" onclick="window.open('<?= Url::to($base_url.'/webinar/'.  $webinar['slug']); ?>', '_blank')">View Details</button>
                </div>
<!--                <div class="sharing-btn naam">-->
<!--                    <button type="button" title="share with friend">Share <i class="fas fa-share-alt"></i></button>-->
<!--                </div>-->
            </div>
        </div>
    </div>
    <?php
}
$this->registerCss('
.new-btns{
    display: flex;
    margin-top: 20px;
    justify-content: center;
}
.naam button {
	background-color: #00a0e3;
	border: none;
	color: #fff;
	margin: 0 2px;
	padding: 7px 20px;
	font-size: 16px;
	border-radius: 4px;
	font-family: roboto;
}
.webinar-box{
    padding: 15px;
    border: 2px solid #eee;
    border-radius: 8px;
    background-color:#fff;
}
.webinar-icon {
    position: relative;
    z-index: 0;
}
.web-date {
	border: 1px solid transparent;
	text-align: center;
	width: 130px;
	height: 130px;
	margin: auto;
	background-color: #00a0e3;
	color: #fff;
	padding: 27px 0;
	border-radius: 100px;
	margin-top: -70px;
    position: relative;
    z-index: 1;
}
.cont{
    font-size: 50px;
    line-height: 50px;
    font-family: roboto;
    font-weight: 600;
    display: block;
}
.abs{
    font-size: 18px;
    text-transform: uppercase;
    font-family: roboto;
}
.webinar-title {
    font-size: 28px;
    text-align: center;
    font-family: roboto;
    font-weight: 600;
    line-height: 35px;
    padding-top: 10px;
}
.webinar-city {
    text-align: center;
    font-size: 16px;
    color: #00a0e3;
    font-family: roboto;
    font-weight: 500;
    padding-bottom: 10px;
}
.webinar-desc {
    font-size: 16px;
    font-family: roboto;
    text-align: center;
}
.webinar-icon > img {
    width: 100%;
}

.avatars {
    display: inline-flex;
    padding-left: 30px;
    margin-top:20px;
}
.avatars p{
    font-size: 16px;
    line-height: 40px;
    padding-left: 15px;
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
');
$script = <<<JS
$(document).on('click', '#register_join_btn', function(event) {
    var ths = $(this);
    event.stopImmediatePropagation();
    if ( ths.data('requestRunning') ) {
        return false;
    }
    ths.data('requestRunning', true);
    
    var session_id = ths.attr('data-key');
    var webinar_id = ths.attr('data-id');
    registerWebinar(ths, webinar_id, session_id, true);
});
$(document).on('click', '#join_btn', function(event) {
    var ths = $(this);
    event.stopImmediatePropagation();
    if ( ths.data('requestRunning') ) {
        return false;
    }
    ths.data('requestRunning', true);
    
    var session_id = ths.attr('data-key');
    joinWebinar(session_id);
});
function joinWebinar(session_id){
    if(session_id == ""){
        toastr.warning("Webinar not started..", "DateTime Remaining");
        ths.data('requestRunning', false);
        return false;
    }
    window.location.href = '/mentors/webinar-view?id=' + session_id;
}
$(document).on('click', '#register_btn', function(event) {
    var ths = $(this);
    event.stopImmediatePropagation();
    if ( ths.data('requestRunning') ) {
        return false;
    }
    ths.data('requestRunning', true);
    var session_id = ths.attr('data-key');
    var webinar_id = ths.attr('data-id');
    registerWebinar(ths, webinar_id, session_id, false);
});
function registerWebinar(ths, webinar_id, session_id, type) {
    var btnValue = ths.text();
    $.ajax({
        url : '/mentors/register-webinar',
        method : 'POST',
        data : {key:webinar_id},
        beforeSend: function () {
            ths.attr('disabled', true);
            ths.html('loading..');
        },
        success : function(res){
            ths.attr('disabled', false);
            ths.data('requestRunning', false);
            if(res.status == 200) {
                ths.text('Join Event');
                ths.attr('id', 'join_btn');
                toastr.success(res.message, res.title);
                if(type == false){
                    ths.attr('data-key', '');
                } else {
                    ths.attr('data-key', session_id);
                    window.location.href = '/mentors/webinar-view?id=' + session_id;
                }
            } else {
                ths.text(btnValue);
                toastr.error(res.message, res.title);
            }
        }
    });
}
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);