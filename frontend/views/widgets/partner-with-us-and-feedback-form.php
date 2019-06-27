<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<section class="partner">
    <div class="container">
        <h1 class="heading-style ">Join our Community</h1>
        <div class="row partner-row">
            <div class="col-md-12">
                <div class="col-md-6 col-sm-6">
                    <div class="partner-btn">
                        <button type='button' class="feed-open2">Partner with Us</button>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="partner-btn">
                        <button type="button" class="feed-open">Give us Feedback</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="window-popup message-popup">
    <a href="#" class="popup-close">
        <i class="fas fa-times"></i>
    </a>
    <article class="content-wrapper">
        <header class="modal-header">
            <h3>Reach us instantly via form below.</h3>
        </header>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'feedback-form',
                        'action' => '/site/send-feedback',
                    ]);
                    ?>
                    <?= $form->field($feedbackFormModel, 'name', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fas fa-user"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Your Name', 'autocomplete' => 'off'])->label(false); ?>
                    <?= $form->field($feedbackFormModel, 'email', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fas fa-envelope"></i>{error}{hint}</div>'])->textInput(['class' => 'lowercase', 'placeholder' => 'Email Address', 'autocomplete' => 'off'])->label(false); ?>
                    <?= $form->field($feedbackFormModel, 'phone', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fas fa-phone-alt"></i>{error}{hint}</div>'])->textInput(['placeholder' => 'Phone Number', 'autocomplete' => 'off'])->label(false); ?>
                    <?= $form->field($feedbackFormModel, 'subject', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user far fa-file-alt"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Subject', 'autocomplete' => 'off'])->label(false); ?>
                    <?= $form->field($feedbackFormModel, 'message', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fas fa-pencil-alt"></i>{error}{hint}</div>'])->textarea(['placeholder' => 'Your Message', 'autocomplete' => 'off'])->label(false); ?>
                    <?= Html::submitButton('Submit', ['class' => 'action']); ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </article>

</div>
<div class="window-popup2 message-popup">
    <a href="#" class="popup-close2">
        <i class="fas fa-times"></i>
    </a>
    <article class="content-wrapper">
        <header class="modal-header">
            <h2>Partner With Us.</h2>
            <h5>Want to collaborate with us, fill the form and we will get back to you</h5>
        </header>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <?php
                        $formm = ActiveForm::begin([
                            'id' => 'partner-with-us-form',
                            'action' => '/site/partner-with-us',
                        ]);
                        ?>
                        <?= $formm->field($partnerWithUsModel, 'name', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fas fa-user"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Your Name', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'email', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fas fa-envelope"></i>{error}{hint}</div>'])->textInput(['class' => 'lowercase', 'placeholder' => 'Email Address', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'phone', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fas fa-phone-alt"></i>{error}{hint}</div>'])->textInput(['placeholder' => 'Phone Number', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'subject', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user far fa-file-alt"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Subject', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'company_name', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user far fa-file-alt"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Company Name', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'message', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fas fa-pencil-alt"></i>{error}{hint}</div>'])->textarea(['placeholder' => 'Your Message', 'autocomplete' => 'off'])->label(false); ?>
                        <?= Html::submitButton('Submit', ['class' => 'action']); ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>
<?php
$this->registerCss('
/*partner with us*/
.partner{
    padding:0px 0 80px 0;
    text-align:center;
    background:#ecf5fe;
}
.partner-btn button{
    border: 2px solid #00a0e3;
    border-width: 2px 12px;
    padding: 14px 59px;
    background: #00a0e3 !important;
    color: #fff;
    text-transform: uppercase;
    border-radius: 9px 50px;
    transition:.6s all;
    -webkit-transition:.6s all;
    -o-transition:.6s all;
    -moz-transition:.6s all;
    -ms-transition:.6s all;
}
.partner-btn button:hover{
    border:2px solid #00a0e3;
    border-width: 2px 12px;
    background: #00a0e3 !important;
    color: #fff;
    border-radius: 9px 0px;
    transition:.6s all;
    -webkit-transition:.6s all;
    -moz-transition:.6s all;
    -o-transition:.6s all;
    -ms-transition:.6s all;
}
.partner-row{
    padding:30px 0 0 0; 
}
.footer{
    margin-top:0px !important;
}
/*partner with us ends*/
/*Modal css starts */
.content-wrapper {
    position: relative;
    display: block;
    max-width: 560px;
    margin: 100px auto;
    padding: 1.5rem 3.5rem;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0px -15px 0px 0px rgba(69, 74, 79, 0.5), 15px -30px 0px 0px rgba(69, 74, 79, 0.5), 30px -45px 0px 0px rgba(69, 74, 79, 0.5), 45px -60px 0px 0px rgba(69, 74, 79, 0.5);
    transition: transform 0.25s;
    transition-delay: 0.15s;
}
.content-wrapper .modal-header {
    position: relative;
    width: 100%;
    margin: 0;
    padding: 0 0 0.25rem;
    margin-bottom: 10px;
    text-align:center;
}
.content-wrapper .modal-header h2 {
    font-size: 22px;
    font-weight: bold;
}
.content-wrapper .content {
    position: relative;
    display: block;
    text-align:center;
}
.action {
    position: relative;
    width: 100%;
    height: 53px;
    padding: 0.625rem 1.25rem;
    border: none;
    background-color: slategray;
    border-radius: 0.25rem;
    color: white;
    font-size: 15px;
    font-weight: 300;
    overflow: hidden;
    z-index: 1;
    background-color: #e74c3c;
}
.action:before {
    position: absolute;
    content: "";
    top: 0;
    left: 0;
    width: 0%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.2);
    transition: width 0.25s;
    z-index: 0;
}
.action:hover:before {
    width: 100%;
}
.with-icon {
    position: relative;
}
.has-error .with-icon input, .has-error .with-icon textarea {
    border: 1px solid #ff00004d !important;
}
.has-success .form-control {
    border-color: transparent !important;
}
#feedback-form input, #feedback-form textarea, #partner-with-us-form input, #partner-with-us-form textarea{
    padding: 13px 40px !important;
    border: 1px solid transparent !important;
    transition: all .3s ease !important;
    font-size: 16px !important;
    color: #273f5b !important;
    margin-bottom: 20px !important;
    border-radius: 50px !important;
    height:53px !important;
    background-color: #fff !important;
    box-shadow: 0 0 30px 0 rgba(18, 25, 33, 0.15) !important;
    width: 100% !important;
    outline: none !important;
    padding-left: 50px !important;
}
#feedback-form input:focus, #feedback-form textarea:focus, #partner-with-us-form input:focus, #partner-with-us-form textarea:focus{
    -webkit-box-shadow: 5px 0 40px 0 rgba(0, 88, 171, 0.25) !important;
    box-shadow: 5px 0 40px 0 rgba(0, 88, 171, 0.25) !important;
    color: #0083ff !important;
    outline: 0 !important;
}
.with-icon .utouch-icon {
    position: absolute !important;
    left: 12px !important;
    top: 18px !important;
    height: 16px !important;
    border-right: 1px solid #dbe3ec !important;
    z-index: 1 !important;
    transition: all .3s ease !important;
    padding-left: 6px !important;
    padding-right: 8px !important;
}
.utouch-icon {
    transition: all .3s ease !important;
    width: 32px !important;
}
.with-icon input:focus + .utouch-icon, .with-icon textarea:focus + .utouch-icon, .with-icon select:focus + .utouch-icon {
    color: #0083ff !important;
}
textarea {
    height: 120px !important;
    border-radius: 30px !important;
}
.window-popup, .window-popup2 {
    opacity: 0;
    visibility: hidden;
    background-color: #66b5ff;
    position: fixed;
    top: 0;
    width: calc(100% + 20px);
    height: 100%;
    -webkit-transition: opacity .5s ease, -webkit-transform .5s ease, scale .6s ease;
    transition: opacity .5s ease, -webkit-transform .5s ease, scale .6s ease;
    -o-transition: opacity .5s ease, transform .5s ease, scale .6s ease;
    transition: opacity .0s ease, transform .5s ease, -webkit-transform .5s ease, scale .6s ease;
    -webkit-transform: scale(0);
    -ms-transform: scale(0);
    transform: scale(0);
    z-index: 50;
    right: -17px;
}
.window-popup.open, .window-popup2.open2 {
    opacity: 1;
    z-index: 999999;
    visibility: visible;
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1);
    overflow: auto;
    background-color: #1e242c;
}
.popup-close, .popup-close2 {
    border-radius: 0 0 0 30px;
    background-color: #131a22;
    width: 80px;
    height: 80px;
    font-size: 40px;
    text-align: center;
    line-height: 80px;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 99999;
    transition: all .0s ease;
}
.sc_remove::-webkit-scrollbar { width: 0 !important }
.sc_remove { -ms-overflow-style: none; overflow: hidden; overflow: -moz-scrollbars-none; }
/*Modal css ends */
@media screen and (max-width: 767px){
    .partner-btn button{
        margin-bottom:10px;
    }
}
@media only screen and (max-width:560px){
    .content-wrapper{
        max-width: 80%;
        margin-left: 8.5% !important;
    }
    .content-wrapper .modal-header h2 {
        font-size: 19px;
    }
}
@media screen and (max-width: 495px){
    .companies{
        padding: 0px 0 55px 0;
    }
');
$this->registerJs("
$(document).on('click', '.feed-open', function(){
   $('.window-popup').addClass('open') ;
   $('body').toggleClass('sc_remove') ;
});
$(document).on('click', '.popup-close', function(e){
    e.preventDefault();
   $('.window-popup').removeClass('open') ;
   $('body').toggleClass('sc_remove') ;
});
$(document).on('click', '.feed-open2', function(){
   $('.window-popup2').addClass('open2') ;
   $('body').toggleClass('sc_remove') ;
});
$(document).on('click', '.popup-close2', function(e){
    e.preventDefault();
   $('.window-popup2').removeClass('open2') ;
   $('body').toggleClass('sc_remove') ;
});
        
$(document).on('submit', '#feedback-form', function(event) {
    event.preventDefault();
    var form_method = $(this).attr('method');
    var form_url = $(this).attr('action');
    var form_data = $(this).serialize();
    var before = function(){     
        $('.loader-aj-main').fadeIn(1000);  
    };
    var req = function(){
        var result = ajax(form_method, form_url, form_data);
        var resp = result['responseJSON'];
        $('.loader-aj-main').fadeOut(1000);
        if(resp.status == 200){
            toastr.success(resp.message, resp.title);
            $('#feedback-form')[0].reset();
            $('.popup-close').trigger('click');
        }else{
            toastr.error(resp.message, resp.title);
        }
    }
    order(before, req);
});
        
function order(before, req){
    before();
    req();
}
        
$(document).on('submit', '#partner-with-us-form', function(event) {
    event.preventDefault();
    var form_method = $(this).attr('method');
    var form_url = $(this).attr('action');
    var form_data = $(this).serialize();
    var before = function(){     
        $('.loader-aj-main').fadeIn(1000);  
    };
    var req = function(){
        var result = ajax(form_method, form_url, form_data);
        var resp = result['responseJSON'];
        $('.loader-aj-main').fadeOut(1000);
        if(resp.status == 200){
            toastr.success(resp.message, resp.title);
            $('#partner-with-us-form')[0].reset();
            $('.popup-close2').trigger('click');
        }else{
            toastr.error(resp.message, resp.title);
        }
    }
    order(before, req);
});
");
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
?>