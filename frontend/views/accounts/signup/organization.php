    <?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
//use borales\extensions\phoneInput\PhoneInput;

$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg-sign-up.jpg');
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
    'id' => 'organization-form',
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
            <legend><?= Yii::t('frontend', 'I Want To Hire'); ?></legend>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <?= $form->field($model, 'organization_name')->textInput(['class' => 'capitalize form-control text-capitalize', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('Organization_Name')]); ?>
        </div>
        <div class="col-md-6 col-sm-6">
            <?= $form->field($model, 'organization_email', ['enableAjaxValidation' => true])->textInput(['class' => 'lowercase form-control text-lowercase', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('Organization_Email')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <?= $form->field($model, 'organization_website')->textInput(['class' => 'text-lowercase form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('Organization_Website')]); ?>
        </div>
        <div class="col-md-6 col-sm-6">
            <?=
            $form->field($model, 'organization_phone')->textInput(['id'=>'orgphone-input']);
            ?>
            <p id="orgphone-error" style="color:red;" class="help-block help-block-error"></p>

            <!--            --><?//=
//            $form->field($model, 'organization_phone', ['enableAjaxValidation' => true])->widget(PhoneInput::className(), [
//                'jsOptions' => [
//                    'allowExtensions' => true,
//                    'preferredCountries' => ['in'],
//                    'nationalMode' => false,
//                ]
//            ]);
//            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'username', ['template' => '<div class="input-group"><span class="input-group-addon">https://empoweryouth.com/</span>{input}</div>{error}', 'enableAjaxValidation' => true])->textInput(['class' => 'lowercase form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('username')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <?= $form->field($model, 'new_password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('Password')]); ?>
        </div>
        <div class="col-md-6 col-sm-6">
            <?= $form->field($model, 'confirm_password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('Confirm_Password')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <legend><?= Yii::t('frontend', 'Contact Person Information'); ?></legend>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <?= $form->field($model, 'first_name')->textInput(['class' => 'capitalize form-control text-capitalize', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('First_Name')]); ?>
        </div>
        <div class="col-md-6 col-sm-6">
            <?= $form->field($model, 'last_name')->textInput(['class' => 'capitalize form-control text-capitalize', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('Last_Name')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <?= $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['class' => 'text-lowercase form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('Email')]); ?>
        </div>
        <div class="col-md-6 col-sm-6">
            <?=
            $form->field($model, 'phone')->textInput(['id'=>'phone-input']);
            ?>
            <p id="phone-error" style="color:red;" class="help-block help-block-error"></p>

            <!--            --><?//=
//            $form->field($model, 'phone', ['enableAjaxValidation' => true])->widget(PhoneInput::className(), [
//                'jsOptions' => [
//                    'allowExtensions' => false,
//                    'preferredCountries' => ['in'],
//                    'nationalMode' => false,
//                ]
//            ]);
//            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= Html::submitButton('Sign Up', ['class' => 'btn btn-primary btn-lg btn-block mt-15 main-blue-btn', 'name' => 'register-button']); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>

<?php
$this->registerCss('
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
    var input2 = document.querySelector("#orgphone-input");
    var iti2 = window.intlTelInput(input2, {
        'utilsScript': "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js",
       'allowExtensions': false,
       'preferredCountries': ['in'],
       'nationalMode': false,
       'separateDialCode':true
  });
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
$(document).on('blur','#phone-input', function() {
  if ($('#phone-input').val().trim()&& allnumeric($('#phone-input').val().trim())) {
    if (iti.isValidNumber()) {
        validatePhone('user','phone',iti.getNumber(intlTelInputUtils.numberFormat.E164));
    } else {
      input.classList.add("error");
      var errorCode = iti.getValidationError();
      $('#phone-error').html(errorMap[errorCode]);
    }
  } else {
      input.classList.add("error");
      $('#phone-error').html('Invalid Number');
  }
});
$(document).on('blur','#orgphone-input', function() {
  if ($('#orgphone-input').val().trim()&& allnumeric($('#orgphone-input').val().trim())) {
    if (iti2.isValidNumber()) {
        validatePhone('organization','phone',iti2.getNumber(intlTelInputUtils.numberFormat.E164));
    } else {
      input2.classList.add("error");
      var errorCode = iti2.getValidationError();
      $('#orgphone-error').html(errorMap[errorCode]);
    }
  } else {
      input2.classList.add("error");
      $('#orgphone-error').html('Invalid Number');
  }
});
function validatePhone(type,field,value){
     $.ajax({
         url:'/validate-field',
         data:{type,field,value},
         method:'post',
         success:function(res){
             if(res.status === 200){
                 if(type == 'user'){
                     $('#phone-input').addClass('error');
                     $('#phone-error').html('Phone Number already exists');
                 } else{
                     $('#orgphone-input').addClass('error');
                     $('#orgphone-error').html('Phone Number already exists');
                 }
             }else {
                 if(type == 'user'){
                    $('#phone-input').removeClass('error');
                    $('#phone-error').html(res);
                 } else{
                    $('#orgphone-input').removeClass('error');
                    $('#orgphone-error').html(res);
                 }
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
$('#organization-form').on('beforeSubmit', function() {
    if($('input.error').length){
        return false;
    }
    $('#phone-input').val(iti.getNumber(intlTelInputUtils.numberFormat.E164));
    $('#orgphone-input').val(iti.getNumber(intlTelInputUtils.numberFormat.E164));
});
JS;
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/css/intlTelInput.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($script);
