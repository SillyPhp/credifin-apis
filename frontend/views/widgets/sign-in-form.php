<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-10 log-position col-md-offset-1">
                <div class="col-md-6">
                    <div class="login-text">
                        Want to attract top talent ?
                    </div>
                </div>
                <div class="col-md-6 center">
                    <div class="sub-form">
                        <div class="sub-text">
                            Sign In
                        </div>
                    </div>
                    <?php
                    $loginForm = ActiveForm::begin([
                        'id' => 'signin-form',
                        'options' => [
                            'class' => 'clearfix',
                        ],
                        'fieldConfig' => [
                            'template' => '{input}{error}',
                        ],
                    ]);
                    ?>
                    <div class="form-group">
                        <?=
                        $loginForm->field($loginFormModel, 'username')->textInput([
                            'autocomplete' => 'off',
                            'placeholder' => $loginFormModel->getAttributeLabel('username'),
                        ]);
                        ?>
                    </div>
                    <div class="form-group">
                        <?=
                        $loginForm->field($loginFormModel, 'password')->passwordInput([
                            'autocomplete' => 'off',
                            'placeholder' => $loginFormModel->getAttributeLabel('password'),
                        ]);
                        ?>
                    </div>
                    <div class="login-form" id="signInForm">
                        <div class="sign-btn">
                            <?= Html::submitButton('Sign In', ['id' => 'btn1', 'class' => 'lg-form', 'name' => 'login-button']); ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <div class="sign-up">
                            <a href="/signup/organization" class="sign-link">Don't have an account? Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php
$this->registerCss('
#signin-form input{
    border-radius:5px;
}
#signin-form div .has-success .form-control{
    border: 1px solid #c2cad8 !important;
}
.has-error .form-control {
    border-color: #e73d4a !Important;
}
.log-position{
	border-radius:5px;
	box-shadow: 0px 2px 3px 2px lightgray;
	padding-top: 60px;
	padding-bottom: 25px;
	margin-top: -150px;
	background-color: white;
}
.login-text{
    font-size:47px;
    line-height:1.2;
    font-family:robot;
    text-align:left;
    font-weight:645;
    color:#5e5a5a;
    padding:15px;
}
.sub-text{
     margin-bottom:10px;
     display: inline-block;
    font-size: 25px;
    font-weight: 700;
    color: #9d9d9d;
    border-bottom: 2px solid skyblue;
}
#btn1{
   font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
   background: #00a0e3;
   color: #fff;
   border: #00a0e3;
   padding: 10px 20px;
   border-radius: 5px;
   font-size: 13px;
} 
.sign-link{
  color:#1c9cd0;
}
@media only screen and (max-width: 450px){
    .log-position{
        margin:auto;
        width:95%;
        border-radius: 5px;
        box-shadow: 0px 2px 3px 2px lightgray;
        padding-top: 30px;
        padding-bottom: 30px;
        background-color: white;
    }
     .login-text {
        font-size: 34px;
        line-height: 1.2;
        font-family: Roboto;
        text-align: left;
        font-weight: 645;
        color: #5e5a5a;
        padding-bottom: 16px;
    }
} 
');
$script = <<< JS
$(document).on('submit', '#signin-form', function(event) {
    var btn = $('#btn1');
    event.preventDefault();
    event.stopImmediatePropagation();
    if ( btn.data('requestRunning') ) {
        return false;
    }
    btn.data('requestRunning', true);
    var _error = $('.error-occcur');
    if(_error){
        _error.remove();
    }
    $.ajax({
        url: "/login",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache:false,
        processData: false,
        beforeSend:function(){
            $('#btn1').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');  
        },
        success: function (response) {
            $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                location.reload();
            } else {
                $('#btn1').html('Sign In');
                $('#signInForm').prepend('<p class="help-block error-occcur">' + response.message + '</p>');
            }
        },
        complete: function() {
            btn.data('requestRunning', false);
        }
    });
});
JS;
$this->registerJs($script);