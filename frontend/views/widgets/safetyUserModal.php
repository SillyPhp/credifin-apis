<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;

?>
<div id="safetyUserModal" class="modal fade-scale loginModal" role="dialog">
    <div class="modal-dialog modal-dialog-main">
        <!-- Modal content-->
        <div class="modal-content half-bg-color">
            <button type="button" class="close-lg-modal" data-dismiss="modal" aria-hidden="true">✕</button>
            <div class="row margin-0 disFlex">
                <div class="col-md-6 col-sm-6">
                    <div class=" half-bg">
                        <div class="top-circle">
                            <img src="<?= Url::to('@eyAssets/images/pages/login-signup-modal/top-half-circle.png') ?>">
                        </div>
                        <div class="log-icon">
                            <span></span>
                            <img src="<?= Url::to('@eyAssets/images/pages/safety-posters/posters-logo.png') ?>"
                                 class="centerthis">
                        </div>
                        <div class="bottom-circle">
                            <img src="<?= Url::to('@eyAssets/images/pages/login-signup-modal/bottom-circle.png') ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 padding-0 bg-log">
                    <div class="safety-details">
                        <p>To Customize & Download these safety posters you need to
                            <?php
                            if (Yii::$app->user->isGuest) {
                                ?>
                                <a href="/login">Login</a> or <a href="/signup/organization">Sign up</a>
                                <?php
                            } else{
                                echo 'Login or Sign Up';
                            }
                            ?>
                            as an organization.</p>
                        <h3>Or</h3>
                        <h4 class="mt3">Share with your employer</h4>
                        <div class="safety-links-share">
                            <a href="#!"
                               onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=http://mpwr.in/o3nzm', '_blank', 'width=800,height=400,left=200,top=100')"
                               class="share-elem-main">
                                <span class="fb-btn"><i class="fab fa-facebook-f"></i></span>
                            </a>
                            <a href="#!"
                               onclick="window.open('https://api.whatsapp.com/send?text=http://mpwr.in/o3nzm', '_blank', 'width=800,height=400,left=200,top=100')"
                               class="share-elem-main">
                                <span><i class="fab fa-whatsapp"></i></span>
                            </a>
                            <a href="#!"
                               onclick="window.open('https://telegram.me/share/url?url=http://mpwr.in/o3nzm', '_blank', 'width=800,height=400,left=200,top=100')"
                               class="share-elem-main">
                                <span><i class="fab fa-telegram-plane"></i></span>
                            </a>
                            <a href="#!"
                               onclick="window.open('https://twitter.com/intent/tweet?text=http://mpwr.in/o3nzm', '_blank', 'width=800,height=400,left=200,top=100')"
                               class="share-elem-main">
                                <span><i class="fab fa-twitter"></i></span>
                            </a>
                            <a href="#!"
                               onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=http://mpwr.in/o3nzm', '_blank', 'width=800,height=400,left=200,top=100');"
                               class="share-elem-main">
                                <span><i class="fab fa-linkedin-in"></i></span>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.disFlex{
    display: flex;
    align-items: center;
    flex-warp: wrap;
}
.safety-details{
    text-align: center
}
.safety-details p{
    color: #333;
    font-family: roboto;
    padding: 20px 30px 30px;
    font-size: 20px;
    text-transform: capitalize;
}
.safety-details p a{
    color: #ffcc00;
}
.safety-links-share a{
    color:#ffcc00;
    font-size: 25px;
    margin: 10px;
}
.safety-details p a:hover, .safety-links-share a:hover{
    color: #00a0e3;
    transition: .3s ease
}
.mt3{
    margin-top: 30px;
}
.individual-form::-webkit-scrollbar { 
    width: 0 !important 
}
.individual-form { 
    overflow: -moz-scrollbars-none; 
}
.individual-form { 
    -ms-overflow-style: none; 
}
.individual-form{
    overflow: hidden;
    overflow-y: scroll;
    padding-top:50px;
    max-height:76vh; 
}
.intl-tel-input{
    display:block !important;
}
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
.indi-btn a{
    background: #00a0e3;
    color: #fff;
    padding: 7px 42px;
    border: 1px solid #00a0e3;
    border-radius: 5px;
    text-transform: capitalize;
    font-size: 15px;
    width: 245px;
    margin: auto;
    margin-top: 5px;
    display: block;
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
.loginModal.modal.in{
    display:flex !important;
}
.modal.in .modal-dialog{
    margin:auto;
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
    background: linear-gradient(to right, #ffcc00 50%, #fff 50%);
//    background: #ffcc00;
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
.inner-main-log-fom > .ey-logo{
    position:absolute;
    top:20px;
    left:50%;
    transform:translateX(-50%);
}
.inner-main-log-fom > .ey-logo img{
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
.for-a a{
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
    .modal-dialog-main {
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
    z-index: 99;
}
.rem-input .checkbox{
    padding-left: 20px;
    margin: 0px;
    color: inherit;
}
.rem-input .checkbox label{
    font-size: 14px;
}
@media only screen and (max-width: 450px) {
    .close-lg-modal{
        right: -5px;
        color: #777;
    }
}
');
$script = <<< JS

JS;
$this->registerJs($script);
?>
<script>

</script>