<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
//use borales\extensions\phoneInput\PhoneInput;

$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg-sign-up.jpg');
$loan_id = null;
$cookies_request = Yii::$app->request->cookies;
$loan_id_ref = $cookies_request->get('loan_id_ref');
if ($loan_id_ref)
{
    $loan_id = $loan_id_ref;
}else{
    if ($loan_ref){
        $loan_id = $loan_id_ref;
    }
}
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="fa fa-check-circle-o"></i> <?= Yii::t('frontend', 'Thank you!'); ?></h4>
                <?= Yii::$app->session->getFlash('success'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="fa fa-check-circle-o"></i> <?= Yii::t('frontend', 'Error'); ?></h4>
                <?= Yii::$app->session->getFlash('error'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
$form = ActiveForm::begin([
    'id' => 'user-form',
    'options' => [
        'class' => 'clearfix',
    ],
    'fieldConfig' => [
        'template' => '<div class="form-group">{input}{error}</div>',
        'labelOptions' => ['class' => ''],
    ],
]);
?>
    <div class="row">
        <div class="col-md-12">
            <legend><?= Yii::t('frontend', 'I Want To Get Hired'); ?></legend>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'first_name')->textInput(['class' => 'capitalize form-control text-capitalize', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('First_Name')]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'last_name')->textInput(['class' => 'capitalize form-control text-capitalize', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('Last_Name')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['class' => 'text-set-lowercase form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('Email')]); ?>
        </div>
        <div class="col-md-6">
            <?=
            $form->field($model, 'phone')->textInput(['id'=>'phone-input']);
            ?>
            <p id="phone-error" style="color:red;" class="help-block help-block-error"></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'username', ['template' => '<div class="input-group"><span class="input-group-addon">https://empoweryouth.com/</span>{input}</div>{error}', 'enableAjaxValidation' => true])->textInput(['class' => 'lowercase form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('Username')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'new_password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('New_Password')]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'confirm_password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('Confirm_Password')]); ?>
        </div>
    </div>
    <?= $form->field($model, 'referer',['template'=>'{input}'])->hiddenInput(['value' => Yii::$app->request->referrer])->label(false) ?>
    <div class="row">
        <div class="col-md-12">
            <?= Html::submitButton('Sign Up', ['class' => 'btn btn-primary btn-lg btn-block mt-15 main-blue-btn', 'name' => 'register-button']); ?>
        </div>
    </div>
<?=$form->field($model,'loan_id_ref',['template'=>'{input}'])->hiddenInput(['id'=>'loan_id_ref','value'=>(($loan_id)?$loan_id:null)]) ?>
<?php ActiveForm::end(); ?>
<div class="col-md-12">
    <div class="separator pb-10 text-black">
        <span><?= Yii::t('frontend', 'Login/Register With Social Accounts'); ?></span>
    </div>
    <div class="form-group mt-10">
        <?=
        \yii\authclient\widgets\AuthChoice::widget([ 'baseAuthUrl' => ['site/auth'], 'popupMode' => true, ])
        ?>
    </div>
</div>

<?php
$this->registerCss('
.separator{
    margin:30px auto 5px !important;
}
.auth-clients {
    display: flex;
    /* text-align: center; */
    /* list-style: none; */
    padding: 0;
    /* overflow: auto; */
    justify-content: center;
}
.intl-tel-input, .iti {
    width: 100%;
}
.input-group-addon{
    color: #555 !Important;
    background-color: #eee !Important;
}
.country-list, .iti__country-list{z-index:99 !important;}
');
$script = <<<JS
 var input = document.querySelector("#phone-input");
    var iti = window.intlTelInput(input, {
        'utilsScript': "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js",
       'allowExtensions': false,
       'preferredCountries': ['in'],
       'nationalMode': false,
       'separateDialCode':true
  });
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
$(document).on('blur','#phone-input', function() {
  if ($('#phone-input').val()) {
      if ($('#phone-input').val().trim()&& allnumeric($('#phone-input').val().trim())) {
        if (iti.isValidNumber()) {
            validatePhone('phone',iti.getNumber(intlTelInputUtils.numberFormat.E164));
        } else {
          input.classList.add("error");
          var errorCode = iti.getValidationError();
          $('#phone-error').html(errorMap[errorCode]);
        }
      } else {
          input.classList.add("error");
          $('#phone-error').html('Invalid Phone Number');
      }
  }
});
function validatePhone(field,value){
     $.ajax({
         url:'/validate-field',
         data:{type:'user',field,value},
         method:'post',
         success:function(res){
             if(res.status === 200){
                 $('#phone-input').addClass('error');
                 $('#phone-error').html('Phone Number already exists');
             }else {
                 $('#phone-input').removeClass('error');
                $('#phone-error').html(res);
             }
          }
    })
}
function allnumeric(inputtxt){
  var numbers = /^[0-9]+$/;
  if(inputtxt.match(numbers)) {
      return true;
  }
  return false;
} 
$('#user-form').on('beforeSubmit', function() {
    if($('input.error').length){
        return false;
    }
    $('#phone-input').val(iti.getNumber(intlTelInputUtils.numberFormat.E164));
});
$(document).on('keyup', '.text-set-lowercase', function(){
   if($(this).val()){
       $(this).css('text-transform','lowercase');
   } else{
       $(this).css('text-transform','unset');
   } 
});
JS;
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/css/intlTelInput.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($script);