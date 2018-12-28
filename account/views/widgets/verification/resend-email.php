<?php

use yii\helpers\Url;
?>
<div class="row"> 
    <div class="col-md-12">
        <div class="alert alert-danger">
            Your Account has not yet been verified. Please verify your email-address to complete setting up your Account. If you didn't received the email, <a id="get-email" href="javascript:void(0);" url="<?= Url::to('/resend-verification-email'); ?>"><strong>Click Here</strong></a> to resend it.
        </div>
    </div>
</div>
<?php
$this->registerCss("
/*verify email section css starts*/
.alert-danger a{
    color:#e73d4a;
    text-decoration:none;
}
/*verify email section css ends*/
");

$script = <<< JS
    $(document).on('click', '#get-email', function (a) {
        a.preventDefault();
        url_email = $(this).attr('url');
        $(this).attr('disabled', true);
        $.ajax({
            url: url_email,
            method: "POST",
            success: function (response) {
                $('#get-email').removeAttr('disabled');
                toastrstatus(response);
            }
        });
        function toastrstatus(response) {
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
            } else {
                toastr.error(response.message, response.title);
            }
        }

    });
JS;
$this->registerJs($script);
