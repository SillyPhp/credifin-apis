<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;
?>
<div id="loginModal" class="modal fade-scale" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content half-bg-color">
            <button type="button" class="close-lg-modal" data-dismiss="modal" aria-hidden="true">✕</button>
            <div class="row margin-0">
                <div class="col-md-6 col-sm-6">
                    <div class=" half-bg half-bg-color">
                        <div class="top-circle">
                            <img src="<?= Url::to('@eyAssets/images/pages/login-signup-modal/top-half-circle.png')?>">
                        </div>
                        <div class="log-icon">
                            <span></span>
                            <img src="<?= Url::to('@eyAssets/images/pages/login-signup-modal/login-image.png') ?>"
                                 class="centerthis">
                        </div>
                        <div class="bottom-circle">
                            <img src="<?= Url::to('@eyAssets/images/pages/login-signup-modal/bottom-circle.png')?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 padding-0 bg-log">
                    <div class="log-fom">
                        <div class="inner-log-fom"></div>
                        <div class="inner-main-log-fom">
                            <div class="ey-logo">
                                <img src="<?= Url::to('@commonAssets/logos/logo.svg') ?>">
                            </div>
                            <div class="login-form" id="loginForm">
<!--                                <div class="login-heading">Login</div>-->
<!--                                <form>-->
                                <?php
                                $loginForm = ActiveForm::begin([
                                    'id' => 'login-form',
                                    'options' => [
                                        'class' => 'clearfix',
                                    ],
                                    'fieldConfig' => [
                                        'template' => '{input}{error}',
                                    ],
                                ]);
                                ?>
                                    <div class="uname">
                                        <?=
                                        $loginForm->field($loginFormModel, 'username')->textInput([
                                            'autofocus' => true,
                                            'autocomplete' => 'off',
                                            'class' => 'uname-in',
                                            'placeholder' => $loginFormModel->getAttributeLabel('username'),
                                        ]);
                                        ?>
<!--                                        <input type="text" placeholder="Username" class="uname-in">-->
                                    </div>
                                    <div class="pass">
                                        <?=
                                        $loginForm->field($loginFormModel, 'password')->passwordInput([
                                            'autocomplete' => 'off',
                                            'class' => 'uname-in',
                                            'placeholder' => $loginFormModel->getAttributeLabel('password'),
                                        ]);
                                        ?>
<!--                                        <input type="password" placeholder="Password" class="pass-in">-->
                                    </div>
                                    <div class="forgot-pass">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6 rem-input">
                                                <?=
                                                $loginForm->field($loginFormModel, 'rememberMe')->checkbox();
                                                ?>
<!--                                                <input type="checkbox"> <span>Remember Me</span>-->
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6 for-a">
                                                <button type="button" onclick="changeSlide()">Forgot password ?
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="login-btn">
                                        <?= Html::submitButton('Login', ['class' => 'lg-form', 'name' => 'login-button']); ?>
<!--                                        <button type="">Login</button>-->
                                    </div>
                                <?php ActiveForm::end(); ?>
<!--                                </form>-->
                                <div class="new-user">
                                    New User?
                                    <button type="button" onclick="changeSignup()"> Sign Up</button>
                                </div>
                            </div>

                            <div class="forgot-input" id="forgotForm">
<!--                                <form>-->
                                <?php
                                $fform = ActiveForm::begin([
                                    'id' => 'forgot-form',
                                    'options' => [
                                        'class' => 'clearfix',
                                    ],
                                    'fieldConfig' => [
                                        'template' => '<div class="row"><div class="col-md-12"><div class="form-group">{input}{error}</div></div></div>',
                                        'labelOptions' => ['class' => ''],
                                    ],
                                ]);
                                ?>
                                    <div class="f-text">Forgot your password?</div>
                                    <div class="forgot-pass">
                                        <?=
                                        $fform->field($fmodel, 'email')->textInput([
                                            'autocomplete' => 'off',
                                            'placeholder' => $fmodel->getAttributeLabel('email'),
                                        ]);
                                        ?>
<!--                                        <input type="text" placeholder="Enter Registered Email" class="uname-in">-->
                                    </div>
                                    <div class="f-mail">Enter the email address associated with your account</div>
                                    <div class="f-button">
                                        <?= Html::submitButton('Send Mail', ['class' => '', 'name' => 'forgot-password-button']); ?>
<!--                                        <button type="button" class="">Send Mail</button>-->
                                    </div>
                                <?php ActiveForm::end(); ?>
<!--                                </form>-->
                                <div class="new-user">
                                    Existing User?
                                    <button type="button" onclick="changeBack()"> Login</button>
                                </div>
                            </div>


                            <div class="sign-up-form" id="signForm">
                                <div class="sign-heading">Sign up as</div>
                                <form>
                                    <div class="indi-btn">
                                        <button type="button" onclick="individualSign()">Individual</button>
                                    </div>
                                    <div class="organ-btn">
                                        <a href="/signup/organization">Organization</a>
                                    </div>
                                </form>
                                <div class="new-user">
                                    Existing User?
                                    <button type="button" onclick="changeBackLogin()"> Login</button>
                                </div>
                            </div>

                            <div class="individual-signup" id="individualForm">
                                <div class="sign-heading">Sign up as an individual</div>
                                <form>
<!--                                --><?php
//                                $form = ActiveForm::begin([
//                                    'id' => 'user-form',
//                                    'options' => [
//                                        'class' => 'clearfix',
//                                    ],
//                                    'fieldConfig' => [
//                                        'template' => '<div class="form-group">{input}{error}</div>',
//                                        'labelOptions' => ['class' => ''],
//                                    ],
//                                ]);
//                                ?>
                                    <div class="uname-padd-10">
<!--                                        --><?//= $form->field($model, 'first_name')->textInput(['class' => 'capitalize form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('first_name')]); ?>
                                        <input type="text" placeholder="First Name" class="uname-in">
                                    </div>
                                    <div class=" uname-padd-10">
<!--                                        --><?//= $form->field($model, 'last_name')->textInput(['class' => 'capitalize form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('last_name')]); ?>
                                        <input type="text" placeholder="Last Name" class="uname-in">
                                    </div>
                                    <div class="uname-padd-10">
<!--                                        --><?//= $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['class' => 'lowercase form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('email')]); ?>
                                        <input type="text" placeholder="Email" class="uname-in">
                                    </div>
                                    <div class="uname-padd-10">
<!--                                        --><?//=
//                                        $form->field($model, 'phone', ['enableAjaxValidation' => true])->widget(PhoneInput::className(), [
//                                            'jsOptions' => [
//                                                'allowExtensions' => false,
//                                                'onlyCountries' => ['in'],
//                                                'nationalMode' => false,
//                                            ]
//                                        ]);
//                                        ?>
                                        <input type="text" placeholder="Phone Number" class="uname-in">
                                    </div>
                                    <div class="uname-padd-10">
<!--                                        --><?//= $form->field($model, 'username', ['enableAjaxValidation' => true])->textInput(['class' => 'lowercase form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('username')]); ?>
                                        <input type="text" placeholder="Username" class="uname-in">
                                    </div>
                                    <div class="uname-padd-10">
<!--                                        --><?//= $form->field($model, 'new_password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('new_password')]); ?>
                                        <input type="text" placeholder="Password" class="uname-in">
                                    </div>
                                    <div class="uname-padd-10">
<!--                                        --><?//= $form->field($model, 'confirm_password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('confirm_password')]); ?>
                                        <input type="text" placeholder="Confirm Password" class="uname-in">
                                    </div>
                                    <div class="login-btn">
<!--                                        --><?//= Html::submitButton('Sign Up', ['class' => '', 'name' => 'register-button']); ?>
                                        <button type="">Sign Up</button>
                                    </div>
<!--                                --><?php //ActiveForm::end(); ?>
                                </form>
                                <div class="new-user">
                                    Existing User ?
                                    <button type="button" onclick="signupToLogin()"> Login</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<?php
$this->registerCss('
::placeholder{
    color:#999;
}
.login-heading{
    text-align:left;
    padding-left:40px;
}
.top-circle{
    position:absolute;
    top: 0;
    left: 40px;
    max-width: 100px;
}
.bottom-circle{
    position:absolute;
    bottom: 0;
    right: 40px;
    max-width: 80px;
}
#signForm, #individualForm{
    display:none;
}
.sign-heading{
    padding: 30px 0px 10px 0;
}
.indi-btn button{
    background: #00a0e3;
    color: #fff;
    padding: 12px 50px;
    border: 1px solid #00a0e3;
    border-radius: 5px;
    text-transform: capitalize;
    font-size: 15px;
}
.organ-btn{
    margin-top:20px;
}
.organ-btn a{
    padding: 10px 37px;
    background: #ff7803;
    border:1px solid #ff7803;
    margin-top:10px;
    color:#fff;
    border-radius: 5px;
    text-transform: capitalize;
    font-size: 14px;
}
.uname-padd-10{
    padding-top:5px !important;
}
/*---forget box---*/
#forgotForm{
    display:none;
}
.f-text{
    padding:45px 0 5px 35px;
    text-align:left; 
    font-size:13px;
}
.f-button{
    padding:20px 0 0 0;
}
.f-mail{
    font-size:13px;
    padding:10px 50px 0 50px;
    white-space: normal !important;
}
.f-button button{
    background:#00a0e3;
    color:#fff;
    border:#00a0e3;
    padding:10px 20px;
    border-radius:5px;
    font-size:13px !important;
}
/*---forget box ends---*/
.modal.in{
    display:flex !important;
}
.modal.in .modal-dialog{
    margin:auto;
//    position:absolute;
//    top:50%;
//    left:50%;
//    transform: translate(-50%, -50%);
}
.fade-scale {
  transform: scale(0);
  opacity: 0;
  -webkit-transition: all .25s linear;
  -o-transition: all .25s linear;
  transition: all .25s linear;
}
.fade-scale.in {
  opacity: 1;
  transform: scale(1);
}
.new-user{
    font-size:13px;
    position:absolute;
    bottom:5px;
    left:50%;
    transform: translateX(-50%);
}
.new-user button{
    font-size:14px;
    background:none;
    border:none;
    color:#00a0e3;
}
.bg-log{
//    background:url(' . Url::to('@eyAssets/images/pages/login-signup-modal/lock-bg.png') . ');
    background:#fff;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 0 5px 5px 0;
    min-height:365px;
}
.margin-0{
    margin-left:0px !important;
    margin-right:0px !important;
}
.half-bg-color{
    background: #00a0e3;
}
.half-bg{
    background-size:cover;
    height:100%;
    border-radius: 5px 0 0 5px;
}
.log-fom, .log-icon{
    padding:50px 0;
    text-align:center;
    white-space: nowrap;
    height: 540px;
}
.ey-logo{
    position:absolute;
    top:20px;
    left:50%;
    transform:translateX(-50%);
}
.ey-logo img{
    max-width:200px;
}
.log-btn{
    padding:100px
}
.log-icon span{
    display: inline-block;
    height: 100%;
    vertical-align: middle;
}
.log-icon img{
    max-width:315px;
    vertical-align: middle;
}
.inner-log-fom{
    display: inline-block;
    height: 100%;
    vertical-align: middle;
}
.inner-main-log-fom{
    vertical-align: middle;
    display: inline-block;
    width:100%;
}
.uname{
    padding:10px 0 10px 0;
    
}
.uname-in, .pass-in{
    padding:10px 15px;
    border:1px solid #ddd;
    border-radius:5px;
    width:80%;
    font-size: 13px;
}
.forgot-pass{
    font-size:12px;
}
.rem-input{
    padding-top: 3px;
    padding-left: 30px;
}
.rem-input span{
    padding-left:3px;
}
.for-a{
    padding-top:3px;
    text-align:right; 
}
.for-a button{
    background:transparent;
    border:none;
    font-size:13px;
    margin-right:30px
}
input{
    font: normal;
}
.login-btn{
    padding-top:10px;
}
.login-btn button{
    background:#00a0e3;
    color:#fff;
    border:#00a0e3;
    padding:10px 20px;
    border-radius:5px;
    font-size:13px;
}
@media screen and (max-width: 992px){
    .half-bg{
        border-radius:5px 5px 0 0;
    }
    .bg-log{
        border-radius:0px 0px 5px 5px;
    }
    .rem-input input{
        margin-left:0px;
    }
}
@media screen and (max-width: 767px){
    .rem-input{
        padding-right:15px !important;
    }
    .half-bg{
        display:none;
    }
    .bg-log{
        min-width:300px;
    }
    .f-mail{
        white-space: normal !important;
    }
}
@media screen and(max-width: 550px){
    .bg-log{
        max-width:280px;
    }
}
@media screen and (min-width: 768px){
    .modal-dialog {
        width: 750px !important;
        margin: 30px auto;
    }
}
body.modal-open{
    padding-right:0px !important;
    overflow:visible;
}
.error-occcur{color:red;}
.close-lg-modal{
    position: absolute;
    right: -40px;
    font-size: 40px;
    color: #fff;
    opacity: 1;
    top: -8px;
    font-weight: 100;
    background: transparent;
    border: 0;
    outline: 0;
}
.rem-input .checkbox{
    padding-left: 20px;
    margin: 0px;
    color: inherit;
}
.rem-input .checkbox label{
    font-size: 14px;
}
');
$script = <<< JS
$(document).on('submit', '#login-form', function(event) {
    var btn = $('.lg-form');
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
            $('.lg-form').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');  
        },
        success: function (response) {
            $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                location.reload();
            } else {
                $('.lg-form').html('Login');
                $('#loginForm').prepend('<p class="help-block error-occcur">' + response.message + '</p>');
            }
        },
        complete: function() {
            btn.data('requestRunning', false);
        }
    });
});
JS;
$this->registerJs($script);
?>
<script>
    function changeSlide() {
        document.getElementById('loginForm').style.display = "none";
        document.getElementById('forgotForm').style.display = "block";
    }
    function changeBack() {
        document.getElementById('forgotForm').style.display = "none";
        document.getElementById('loginForm').style.display = "block";
    }
    function changeSignup() {
        document.getElementById('loginForm').style.display = "none";
        document.getElementById('signForm').style.display = "block";
    }
    function changeBackLogin() {
        document.getElementById('signForm').style.display = "none";
        document.getElementById('loginForm').style.display = "block";
    }
    function individualSign() {
        document.getElementById('signForm').style.display = "none";
        document.getElementById('individualForm').style.display = "block";
    }
    function signupToLogin() {
        document.getElementById('individualForm').style.display = "none";
        document.getElementById('loginForm').style.display = "block";
    }
</script>