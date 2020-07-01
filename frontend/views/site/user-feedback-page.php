<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<section class="feedback-bg">
    <div class="pos-abso"><img src="<?= Url::to('@eyAssets/images/pages/custom/a1.png')?>"> </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="dis-flex">
                    <div class="icon-left">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/feedback-icon.png') ?>" alt="">
                    </div>
                    <div class="feedback-form">
                        <div class="form-heading">Your feedback is really valuable to us.</div>
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
        </div>
    </div>
</section>
<?php
$this->registerCss('
.pos-abso{
    position:absolute;
    top:0px;
    left:0px;
    
    animation: topBottom 3s;
    
}

@keyframes topBottom{
    from{left:-300px; top:-300px}
    to{left:0px; top:0px}
}
.icon-left img{
    max-width: 500px;
    width:100%;
}
.form-heading{
    text-align:center;
    font-size:16px;
    font-weight:bold;
    color:#333;
}
p.help-block{
    margin-left: 15px;
    font-size: 12px;
    margin-bottom:5px !important;
}
.feedback-form{
    width: 100%;
    max-width: 400px;
    background:#fff;
    padding:30px 40px;
    border-radius:20px;
    box-shadow: 0 0 10px rgba(0,0,0,.2);
}
.feedback-bg{
    background:url(' . Url::to('@eyAssets/images/pages/custom/feedbackbg.png') . ');
    min-height:100vh;
    background-size:cover;
    position: relative;
}
.dis-flex{
    display:flex;
    min-height:100vh;
    height:100%;
    align-items: center;
    margin-top:50px;
    justify-content: space-around;
    flex-wrap: wrap;
    padding:20px 0;
}
.footer{
    margin-top:0px !important;
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
#feedback-form textarea{
   height: 100px !important;
    border-radius: 20px !important;
}
#feedback-form input, #feedback-form textarea, #partner-with-us-form input, #partner-with-us-form textarea{
    padding: 13px 40px !important;
    border: 1px solid transparent !important;
    transition: all .3s ease !important;
    font-size: 13px !important;
    color: #273f5b !important;
    border-radius: 50px;
    height:40px;
    background-color: #fff !important;
    box-shadow: 0 0 5px 0 rgba(18, 25, 33, 0.1) !important;
    width: 100% !important;
    outline: none !important;
    padding-left: 50px !important;
}
*:placeholder{
    color:#333;    
}
#feedback-form input:focus, #feedback-form textarea:focus, #partner-with-us-form input:focus, #partner-with-us-form textarea:focus{
    -webkit-box-shadow: 0px 0 10px 0 rgba(0, 88, 171, 0.25) !important;
    box-shadow: 0px 0 10px 0 rgba(0, 88, 171, 0.25) !important;
    color: #0083ff !important;
    outline: 0 !important;
}
.with-icon .utouch-icon {
    position: absolute !important;
    left: 12px !important;
    top: 14px !important;
    height: 14px !important;
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

@media only screen and (max-width:992px){
    .icon-left img{
        max-width: 350px;
        width:100%;
        padding-top:50px;
        padding-bottom:30px;
    }
}
');
$script = <<<JS
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
JS;
$this->registerJS($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
?>
