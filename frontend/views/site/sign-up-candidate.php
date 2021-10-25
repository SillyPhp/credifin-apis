<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use borales\extensions\phoneInput\PhoneInput;

?>

    <section class="set-bg">
        <div class="container">
            <div class="row position-relative">
                <div class="position-absolute">
                    <div class="form-main col-md-6 col-sm-12 col-md-offset-3">
                        <div class="emp-logo">
                            <a href="https://www.empoweryouth.com/">
                                <img src="<?= Url::to('@eyAssets/images/logos/eycom.png') ?>">
                            </a>
                        </div>
                        <?php $form = ActiveForm::begin([
                            'id' => 'signup_candidate_form',
                            'options' => [
                                'class' => 'clearfix',
                            ],
                            'fieldConfig' => [
                                'template' => '<div class="form-group">{input}{error}</div>',
                                'labelOptions' => ['class' => ''],
                            ],
                        ]); ?>
                        <div class="tab" id="step-1">
                            <?= $form->field($model, 'job_profile', ['template' => '<div class="job-title col-md-12 pdng">{label}{input}{error}</div>'])->dropDownList($primary_cat, ['prompt' => 'Select Job Profile'])->label('Job Profile'); ?>
                            <?= $form->field($model, 'city', ['template' => '<div class="city col-md-12 pdng">{label}{input}{error}</div>'])->textInput(['autocomplete' => 'off', 'placeholder' => 'Enter City', 'id' => 'city_data'])->label('City'); ?>
                            <?= $form->field($model, 'city_id')->hiddenInput()->label(false); ?>
                            <?= $form->field($model, 'experience', ['template' => '<div class="experience col-md-6 col-sm-6 pdng">{label}{input}{error}</div>'])->dropDownList(['0' => 'No Experience', '1' => 'Less Than 1', '2' => '1 year', '3' => '2-3 years', '3-5' => '3-5 years', '5-10' => '5-10 years', '10+' => '10+ years'], ['prompt' => 'Relevant Experience'])->label('Job Experience'); ?>
                            <?= $form->field($model, 'salary', ['template' => '<div class="salary col-md-6 col-sm-6 pdng">{label}{input}{error}</div>'])->textInput(['placeholder' => '₹:'])->label('Expected Salary'); ?>
                            <div class="submit-b col-md-12 col-sm-12">
                                <?= Html::button('Next', ['class' => 'sub-btn nextBtn']) ?>
                            </div>
                        </div>
                        <div class="tab" id="step-2">
                            <?= $form->field($model, 'first_name', ['template' => '<div class="first-name col-md-7 pdng">{label}{input}{error}</div>'])->textInput(['placeholder' => 'Enter your First-name'])->label('First Name'); ?>
                            <?= $form->field($model, 'last_name', ['template' => '<div class="last-name col-md-5 pdng">{label}{input}{error}</div>'])->textInput(['placeholder' => 'Enter your Last-name'])->label('Last Name'); ?>
                            <?= $form->field($model, 'email', ['enableAjaxValidation' => true, 'template' => '<div class="E-mail col-md-7 pdng">{label}{input}{error}</div>'])->textInput(['placeholder' => 'Enter your E-mail'])->label('E-mail Address'); ?>
                            <?= $form->field($model, 'phone', ['enableAjaxValidation' => true, 'template' => '<div class="phone col-md-5 pdng">{label}{input}{error}</div>'])->textInput(['placeholder' => 'Enter your Phone No'])->widget(PhoneInput::className(), [
                                'jsOptions' => [
                                    'allowExtensions' => true,
                                    'preferredCountries' => ['in'],
                                    'nationalMode' => false,
                                ]
                            ])->label('Phone No'); ?>
                            <div class="submit-b col-md-6 col-sm-6">
                                <?= Html::button('Prev.', ['class' => 'prev-btn prevBtn']) ?>
                            </div>
                            <div class="submit-b col-md-6 col-sm-6">
                                <?= Html::button('Next', ['class' => 'sub-btn nextBtn']) ?>
                            </div>
                        </div>
                        <div class="tab" id="step-3">
                            <?= $form->field($model, 'username', ['enableAjaxValidation' => true, 'template' => '<div class="user-name col-md-12 pdng">{label}{input}{error}</div>'])->textInput(['placeholder' => 'Enter your User-name'])->label('User Name'); ?>
                            <?= $form->field($model, 'new_password', ['enableAjaxValidation' => true, 'template' => '<div class="enter-pass col-md-6 pdng">{label}{input}{error}</div>'])->passwordInput(['autocomplete' => 'off', 'placeholder' => 'Enter your password'])->label('Enter Password'); ?>
                            <?= $form->field($model, 'confirm_password', ['enableAjaxValidation' => true, 'template' => '<div class="confirm-pass col-md-6 pdng">{label}{input}{error}</div>'])->passwordInput(['autocomplete' => 'off', 'placeholder' => 'Confirm your password'])->label('Confirm Password'); ?>
                            <div class="submit-b col-md-12 col-sm-12">
                                <?= Html::submitButton('Submit', ['class' => 'sub-btn submBtn','id' => 'sign_up_btn', 'onclick' => "return Validate()"]) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <!--                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open-->
                        <!--                        Modal-->
                        <!--                    </button>-->
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php
$this->registerCss('
.help-block {
color: #a94442;
}
.emp-logo {
    width: 230px;
    margin: auto;
    margin-bottom: 25px;
}
.emp-logo img{
    width:100%;
}
.form-control{
    height:40px;
}
.set-bg{
    background:url(' . Url::to('@eyAssets/images/bg/bgforms.png') . ');  
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-position:bottom;
}
.position-relative{
    position: relative;
    height: 100vh;
}
.position-absolute{
    position: absolute;
    top:50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
}
.form-main {
	border: 1px solid #eee;
	border-radius: 4px;
	box-shadow: 0 0 25px rgba(0,0,0,0.1);
	background-color: #f8f8ffdb;
	padding:45px 20px;
}
label{font-size:16px;color:#9b9a9a;}
.pdng{
    padding-bottom:18px;
}
.submit-b {
    text-align: center;
    margin-top: 20px;
}
.sub-btn {
    background: #00a0e3;
    color: #fff;
    border: none;
    padding: 5px 25px;
    font-size: 18px;
    border-radius: 4px;
    text-transform: uppercase;
}
.prev-btn {
    background: #ff7803;
    color: #fff;
    border: none;
    padding: 5px 25px;
    font-size: 18px;
    border-radius: 4px;
    text-transform: uppercase;
}
.modal-body p {
    text-align: center;
    margin: 0;
    font-size: 20px;
    text-transform: capitalize;
}
.ys-btns {
    text-align: center;
    padding: 22px 0 10px;
}
.yes, .no {
    display: inline-block;
}
.yes a{
    background-color: #00a0e3;
    color: #fff;
    font-size: 20px;
    font-weight: 500;
    padding: 8px 30px;
    border-radius: 4px;
    text-decoration:none;
}
.no a{
    background-color: #ff7803;
    color: #fff;
    font-size: 20px;
    font-weight: 500;
    padding: 8px 30px;
    border-radius: 4px;
    text-decoration:none;
}
/*Load Suggestions loader css starts*/
.typeahead,
.tt-query,
 {
  width: 396px;
  height: 30px;
  padding: 8px 12px;
  font-size: 18px;
  line-height: 30px;
  border: 2px solid #ccc;
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  outline: none;
}
.form-wizard .steps>li.done>a.step .number {
    background-color: #ffac64 !important;
    color: #fff;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}



.tt-hint {
  color: #999
}
.tt-menu {
  width: 98%;
  margin: 12px 0;
  padding: 8px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
  padding: 3px 20px;
  font-size: 14px;
  line-height: 24px;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
}

.empty-message {

 text-align: center;
 
}
.skill_wrapper
{
margin-bottom:8px;
}

.skill_wrapper .Typeahead-spinner,.descrip_wrapper .Typeahead-spinner,.edu_wrapper .Typeahead-spinner{
    top: -16px;
    z-index: 99;
}
#inputfield, #quali_field, #question_field{
    padding-right:60px;
}
.Typeahead-input {
    position: relative;
    background-color: transparent;
    outline: none;
}

.twitter-typeahead {
    
    width: 100% !important;
}
');
$this->registerCssFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css');
$this->registerjsFile('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js');
$this->registerjsFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js');
?>
<?php
$script = <<< JS
var navListItems = $('.steps-btn'),
    allWells = $('.tab'),
    allNextBtn = $('.nextBtn');
    allPrevBtn = $('.prevBtn');allWells.hide();
$('#step-1').show();
allNextBtn.click(function(){
    var curStep = $(this).closest(".tab"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = curStep.next(),
        isValid = false;
    switch(curStepBtn){
        case 'step-1':
            validate_tab_first(isValid,curStep,nextStepWizard);
            break;
        case 'step-2':
            validate_tab_second(isValid,curStep,nextStepWizard);
            break;
    }
    });
allPrevBtn.click(function(){
    var curStep = $(this).closest(".tab"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = curStep.prev(),
        isValid = false;
    nextStepWizard.show();
    curStep.hide();
    });
            var city = new Bloodhound({
              datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
              queryTokenizer: Bloodhound.tokenizers.whitespace,
               remote: {
                url:'/cities/get-location',
                prepare: function (query, settings) {
                         settings.url += '?q=' +$('#city_data').val();
                         return settings;
                    },  
                'cache': true, 
                filter: function(list) {
                         return list;
                    }
              }
            });    
            
            $('#city_data').typeahead(null, {
              name: 'city',
              display: 'city_name',
              source: city,
               limit: 10,
               hint:false,
            }).on('typeahead:asyncrequest', function() {
                $('.skill_wrapper .Typeahead-spinner').show();
              }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
                
                $('.skill_wrapper .Typeahead-spinner').hide();
              }).on('typeahead:selected',function(e, datum)
              {
                  var citiesdata = datum.city_name;
                  $('#city_id').val(datum.id);
               });
 function validate_tab_first(isValid,curStep,nextStepWizard) {
     isValid = true;
    if ($('#job_profile').val().length==0)
        {
         isValid = false;
        $('#job_profile').next('p').html('Job Profile cannot be blank');
       }
    if ($('input[name="city_id"]').val().length==0)
        {
         isValid = false;
        $('.twitter-typeahead').next('p').html('City cannot be blank');
        }
    if (isValid){
        nextStepWizard.show();
        curStep.hide();
    }
}
 function validate_tab_second(isValid,curStep,nextStepWizard) {
     isValid = true;
    if ($('input[name="first_name"]').val().length==0)
        {
            isValid = false;
        $('#first_name').next('p').html('First Name cannot be blank');
        }
    if ($('input[name="last_name"]').val().length==0)
        {
            isValid = false;
        $('#last_name').next('p').html('Last Name cannot be blank');
        }
    if ($('input[name="email"]').val().length==0)
        {
            isValid = false;
        $('#email').next('p').html('Email cannot be blank');
        }
   if($(".field-email").hasClass("has-error")){
       isValid = false;
  }
   // if ($('input[name="phone"]').val().length==0)
   //      {
   //          isValid = false;
   //      $('#phone').next('p').html('Phone cannot be blank');
   //      }
   if($(".field-phone").hasClass("has-error")){
       isValid = false;
  }
    if (isValid){
        nextStepWizard.show();
        curStep.hide();
    }
}
$(document).on('click', '#sign_up_btn', function (event) {
        event.stopImmediatePropagation();
        event.preventDefault();
        var btn = $(this);
        var form = $('#signup_candidate_form');
        var data = form.serialize();
        $.ajax({
            url: '/site/sign-up',
            type: 'POST',
            data: data,
            beforeSend: function (){
                btn.prop('disabled', 'disabled');
            },
            success: function (response) {
                if (response.status == 'success') {
                    // toastr.success(response.message, response.title);
                } else {
                    toastr.error(response.message, response.title);
                }
            }
        });
    });
        function Validate() {
        var password = document.getElementById("new_password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        if (password != confirmPassword) {
            swal({
            title:"",
            text: "Passwords do not match !!",
        });
            return false;
        }
        return true;
    }
    
JS;
$this->registerJs($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);