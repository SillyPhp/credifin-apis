<?php

use yii\helpers\Url;

?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="w-parent row">
                    <div class="col-md-4 col-sm-6 col-md-offset-2 p-0">
                        <div class="w-head">GET THE LATEST FROM EMPOWERYOUTH.COM</div>
                        <div class="w-content">
                            Subscribe to our Newsletter to get latest Updates of Jobs and Internships.
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-6">
                        <form id="subscribe-newsletter">
                            <div class="email-set" style="display: flex;">
                                <input type="email" class="form-control" id="subscription-email" name="email"
                                       placeholder="ENTER E-MAIL ADDRESS" required>
                                <button type="submit" class="btn btn-primary subscribe-widget-btn">
                                    &rarr;
                                    <!--                                    <article class="right-arrow">-->
                                    <!--                                        <span class="arrow"></span>-->
                                    <!--                                    </article>-->
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="thanks-portion row">
                    <div class="col-md-4">
                        <div class="thanks-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/200.png') ?>">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="thanks-text">
                            Thanks for subscribing.<br/>
                            <span>You will be the first to know about latest updates and information. Stay tuned :)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.w-parent {
    margin: 50px 0;
    background-image: linear-gradient(to right,#f3f3f3ad 65%,#fff 0%);
    padding: 0px 0px 32px 0px;
}
.w-head {
    margin-top: -25px;
    font-size: 30px;
    font-weight: 500;
    font-family: Roboto;
    color: #222;
    letter-spacing: 2px;
    line-height: 45px;
}
.w-content {
    font-size: 15px;
    font-family: Roboto;
    color:#444;
}
.subscribe-widget-btn{
    margin-left: 5px;
    position: absolute;
    background-color: transparent !important;
    color: #444 !important;
    border-color: transparent !important;
    right: 0;
    padding-top: 6px;
    font-size: 45px;
    line-height: 16px;
    height: 45px;
    transition: all 0.3s ease-out;
}
.subscribe-widget-btn:hover{
    right:-5px;
    background-color: transparent !important;
    color: #444 !important;
    border-color: transparent !important;
}
.subscribe-widget-btn i.fa-spin{
    font-size: 25px;
    margin-top: 4px;
    display: block;
}
.email-set{
	padding-top: 50px;
}
.email-set .form-control{
	font-family: Roboto;
    border: 1px solid #666;
}
.email-set .form-control::placeholder {
  color: #777 !important;
}
.email-set .form-control:-ms-input-placeholder {
  color: #777 !important;
}
.email-set .form-control::-ms-input-placeholder {
  color: #777 !important;
}
.thanks-portion{
    display:none;
    margin: 50px 0px;
}
.thanks-text {
    text-align: left;
    font-size: 35px;
    font-weight:500;
    font-family: roboto;
    line-height: 45px;
    color: #444;
    margin-top: 30px;
}
.thanks-text span{
    font-size: 18px;
    line-height: 30px;
    display: block;
}
.thanks-icon{
    max-width: 200px;
    margin: 0 auto;
}
//.right-arrow {
//  width: 80px;
//  position:relative;
//}
//.right-arrow > .arrow {
//    position: absolute;
//    top: 0px;
//    right: 4px;
//    width: 40px;
//    height: 3px;
//    background-color: #555;
//    animation: arrow 700ms linear infinite;
//}
//
//.right-arrow > .arrow::after {
//    content: "";
//    position: absolute;
//    width: 45%;
//    height: 3px;
//    top: -5.8px;
//    right: -3.5px;
//    background-color: #555;
//    transform: rotate(45deg);
//}
//
//.right-arrow > .arrow::before {
//    content: "";
//    position: absolute;
//    width: 45%;
//    height: 3px;
//    top: 5px;
//    right: -3.4px;
//    background-color: #555;
//    transform: rotate(-45deg);
//}
');
$script = <<<JS
function validateEmail(emailField){
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if (reg.test(emailField) == false) {
        return false;
    }
    return true;
}
$(document).on('submit', '#subscribe-newsletter', function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var me = $('.subscribe-widget-btn');
    var elemVal = $('#subscription-email').val();
    if(validateEmail(elemVal)){
        if ( me.data('requestRunning') ) {
            return false;
        }
        me.data('requestRunning', true);
        var data = $('#subscribe-newsletter').serialize();
        $.ajax({
            url: '/site/add-new-subscriber',
            type: 'post',
            data: data,
            beforeSend: function (){
                $('.subscribe-widget-btn').html('<i class="fas fa-circle-notch fa-spin"></i>');
                $('.subscribe-widget-btn').prop('disabled', true);
            },
            success: function (response) {
                if (response.status == 200) {
                    toastr.success(response.message, response.title);
                    $(".w-parent").fadeOut(100);
                    $(".thanks-portion").fadeIn(700);
                } else {
                    toastr.error(response.message, response.title);
                }
                $('.subscribe-widget-btn').prop('disabled', false);
                $('.subscribe-widget-btn').html('&rarr;');
            },
            complete: function() {
            me.data('requestRunning', false);
          }
        });
    } else {
        toastr.error('Please Enter Valid Email Address', 'Invalid Email');
    }
});
JS;
$this->registerJs($script);
