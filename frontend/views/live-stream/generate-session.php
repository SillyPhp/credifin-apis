<?php

use yii\helpers\Url;

?>
    <div class="center-align" id="session-status">
        <h2>Please wait...Redirecting..</h2>
    </div>
<?php
$this->registerCss('
div#session-status {
    text-align: center;
    padding: 70px;
}
');
$script = <<<JS
var id = "$id";
var user_id = "$user_id";
var duration = 3600;
$(document).ready(function() {
    var url = 'https://www.ricky.eygb.me/api/v3/video-session/get-tokens';
    generateSession(url);
});

function generateSession(url) {
    $.ajax({
        url: url,
        type: 'POST',
        data: {user_enc_id:user_id, expire_time: duration},
        // beforeSend: function () {
        //     btn.attr('disabled', true);
        //     btn.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
        // },
        success: function (res) {
            if (res.response.status) {
                var session_id = res.response.session_id;
                updateWebinarSession(session_id);
            }
        }
    });
}
function updateWebinarSession(session_id) {
    var url = 'https://www.ricky.eygb.me/api/v3/video-session/update-session';
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