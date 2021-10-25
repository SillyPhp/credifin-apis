<?php

use yii\helpers\Url;

$baseUrl = Url::base("https");
?>
    <div class="center-align" id="session-status">
        <h2>Please wait...Redirecting..</h2>
    </div>
<?php
$this->registerCss('
div#session-status {
    text-align: center;
    padding: 70px;
    color: #fff;
}
');
$script = <<<JS
var id = "$id";
var user_id = "$user_id";
var baseUrl = "$baseUrl";
var duration = 18000;
$(document).ready(function() {
    var url = baseUrl + '/api/v3/video-session/get-tokens';
    generateSession(url);
});

function generateSession(url) {
    $.ajax({
        url: url,
        type: 'POST',
        data: {user_enc_id:user_id, expire_time: duration},
        success: function (res) {
            if (res.response.status) {
                var session_id = res.response.session_id;
                updateWebinarSession(session_id);
            }
            window.top.location.reload();
        }
    });
}
function updateWebinarSession(session_id) {
    var url = baseUrl + '/api/v3/video-session/update-session';
    $.ajax({
        url: url,
        type: 'POST',
        data: {session_id:session_id, id:id},
        success: function (res) {
            window.location.replace('/mentors/webinar-live?id=' + id);
        }
    });
}
JS;
$this->registerJs($script);