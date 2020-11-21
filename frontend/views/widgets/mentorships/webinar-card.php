<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

$base_url = Url::base('https');
$model = new \frontend\models\webinars\webinarFunctions();
foreach ($webinars as $webinar) {
    $register = $model->getRegisteration($webinar['webinar_enc_id']);
    $webinarRegistrations = $model->getWebinarRegisteration($webinar['webinar_enc_id']);
    $start_time = $webinar['webinarEvents'][0]['start_datetime'];
    ?>
    <div class="col-md-4">
        <div class="webinar-box">
            <div class="webinar-icon">
                <img src="<?= Url::to('@eyAssets/images/pages/jobs/default-cover.png') ?>">
            </div>
            <div class="web-date">
                <span class="cont"><?= date('d', strtotime($start_time)) ?></span>
                <span class="abs"><?= date('F', strtotime($start_time)) ?></span>
            </div>
            <div class="webinar-details">
                <div class="webinar-title"><?= $webinar['title'] ?></div>
                <div class="webinar-city"><i
                            class="far fa-clock"></i> <?= date('h:i A', strtotime($start_time)) ?></div>
                <div class="webinar-desc"><?= $webinar['description'] ?></div>
            </div>
            <?php Pjax::begin(['id' => 'webinar_registations']); ?>
            <div class="avatars">
                <?php
                if ($register) {
                    foreach ($register as $reg) { ?>
                        <span class="avatar">
                            <img src="<?= Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $reg['image_location'] . '/' . $reg['image']) ?>">
                        </span>
                    <?php }
                } ?>
                <?php
                if (!empty($webinarRegistrations)) { ?>
                    <p><?= ($webinar["slug"] == "entrepreneurship-innovation-summit-75367") ? 320 + count($webinarRegistrations) : count($webinarRegistrations); ?> People Registered</p>
                <?php }
                ?>
            </div>
            <?php Pjax::end(); ?>

            <div class="new-btns">
                <div class="detail-btn naam">
                    <button type="button"
                            onclick="window.open('<?= Url::to($base_url . '/webinar/' . $webinar['slug']); ?>', '_blank')">
                        View Details
                    </button>
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
.new-btns {
    display: flex;
    margin-top: 5px;
    justify-content: center;
    margin-bottom: 15px;
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
//    padding: 15px;
    border: 2px solid #eee;
    border-radius: 8px;
    background-color:#fff;
    margin-bottom:20px;
}
.webinar-icon {
    position: relative;
    z-index: 0;
}
.web-date {
	border: 1px solid transparent;
	text-align: center;
	width: 115px;
	height: 115px;
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
    font-size: 40px;
    line-height: 36px;
    font-family: roboto;
    font-weight: 600;
    display: block;
}
.abs{
    font-size: 15px;
    text-transform: uppercase;
    font-family: roboto;
}
.webinar-details {
    padding: 0 15px;
}
.webinar-title {
	font-size: 24px;
	text-align: center;
	font-family: lora;
	line-height: 30px;
	padding-top: 10px;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
	min-height: 75px;
	text-transform:capitalize;
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
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 80px;
    height: 80px;
}
.webinar-icon > img {
    min-height: 150px;
    object-fit: cover;
}

.avatars {
    display: inline-flex;
    padding:0 30px;
    margin-top:20px;
    min-height: 43px;
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
    background-color:#eee;
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