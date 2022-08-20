<?php

use frontend\widgets\login;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['background_image'] = '/assets/themes/ey/images/backgrounds/vector-form-job.png';
Yii::$app->view->registerJs('var link_form = "' . Yii::$app->urlManager->createAbsoluteUrl('/education-loans/apply') . '"', \yii\web\View::POS_HEAD);
?>
<?php if (!Yii::$app->user->isGuest) {
    $first = Yii::$app->user->identity->first_name;
    $last = Yii::$app->user->identity->last_name;
    $name = ucwords($first) . ' ' . ucwords($last);
    $color = Yii::$app->user->identity->initials_color;
    ?>
    <div id="user_box">
        <?php
        if (!empty(Yii::$app->user->identity->image)) {
            $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image;
            ?>
            <img src="<?= $image ?>"/>
        <?php } else { ?>
            <canvas class="user-icon" name="<?= $name; ?>"
                    color="<?= $color; ?>" width="50"
                    height="50" font="20px"></canvas></span>
        <?php } ?>
        <h3 class="p_label l_tag"><?= $name . " (" . Html::a('Logout', ['/logout'], ['data' => ['method' => 'post']]) . ")" ?></h3>
    </div>
<?php } else {
    echo login::widget();
    ?>
    <div id="user_box">
        <h3 class="p_label l_tag">
            <a href="javascript:;" data-toggle="modal" class="login_btn" data-target="#loginModal"><i
                        class="fas fa-sign-in-alt"></i> Login</a>
        </h3>
    </div>
<?php } ?>
<div id="light_box_submit">
    <div class="light-box-modal">
        <div class="light-box-in">
            <div class="light-box-img">
                <img src="/assets/themes/ey/images/pages/dashboard/services.png"/>
            </div>
            <div class="light-box-content">
                <p>Application Reference Number: <span id="app_num"></span></p>
                <div class="row">
                    <p>Click <a href="" target="_blank" class="j-whatsapp share_btn tt" type="button"
                                data-toggle="tooltip" title="Share on Whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a> To Send Him/Her Education Loan Form </p>
                    <p><a class="btn btn-sm btn-primary" onclick="window.location.reload();">Fill Up New Form?</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 set-overlay">
    <div class="row">
        <div class="f-contain">
            <div class="form-wrapper">
                <?php $form = ActiveForm::begin([
                    'id' => 'leads_form',
                ]); ?>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'First Name', 'class' => 'form-control text-capitalize'])->label(false); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Last Name', 'class' => 'form-control text-capitalize'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'student_mobile_number')->textInput(['placeholder' => 'Mobile Number (WhatsApp Number)', 'pattern' => '[0-9]*', 'type' => 'tel', 'maxLength' => 10, 'minLength' => 10])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'student_email')->textInput(['placeholder' => 'Student Email', 'class' => 'form-control'])->label(false); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="radio-heading input-group-text">
                                <strong>LOANS</strong>
                            </div>
                            <p class="help-block help-block-error loan-type-err"></p>
                            <ul class="relationList">
                                <li class="service-list">
                                    <input type="radio" class="input_radio_loan_type loan_type" aria-required="true"
                                           value="Education Loan"
                                           id="education_loan" name="loan_type">
                                    <label for="education_loan">Education Loan</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_loan_type loan_type" aria-required="true"
                                           id="car_loan"
                                           value="Car Loan"
                                           name="loan_type">
                                    <label for="car_loan">Car Loan</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_loan_type loan_type" aria-required="true"
                                           id="persoal_loan"
                                           value="Personal Loan" name="loan_type">
                                    <label for="persoal_loan">Personal Loan</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_loan_type loan_type" aria-required="true"
                                           id="home_loan"
                                           value="Home Loan"
                                           name="loan_type">
                                    <label for="home_loan">Home Loan</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_loan_type loan_type" aria-required="true"
                                           id="two_wheeler_loan"
                                           value="Two Wheeler Loan" name="loan_type">
                                    <label for="two_wheeler_loan">Two Wheeler Loan</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_loan_type loan_type" aria-required="true"
                                           id="e_vehicle_loan"
                                           value="E-Vehicle Loan" name="loan_type">
                                    <label for="e_vehicle_loan">E-Vehicle Loan</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_loan_type loan_type" aria-required="true"
                                           id="business_loan"
                                           value="Business Loan" name="loan_type">
                                    <label for="business_loan">Business Loan</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_loan_type loan_type"
                                           id="loan_against_property" aria-required="true"
                                           value="Loan Against Property" name="loan_type">
                                    <label for="loan_against_property">Loan Against Property</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_loan_type loan_type" id="medical_loan"
                                           value="Medical Loan" aria-required="true" name="loan_type">
                                    <label for="medical_loan">Medical Loan</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_loan_type loan_type" aria-required="true"
                                           id="micro_loan"
                                           value="Micro Loan"
                                           name="loan_type">
                                    <label for="micro_loan">Micro Loan</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_loan_type loan_type" aria-required="true"
                                           id="solar_panel_loan"
                                           value="Solar Panel Loan" name="loan_type">
                                    <label for="solar_panel_loan">Solar Panel Loan</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_loan_type loan_type" aria-required="true"
                                           id="marriage_loan"
                                           value="Marriage Loan" name="loan_type">
                                    <label for="marriage_loan">Marriage Loan</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_loan_type loan_type" aria-required="true"
                                           id="consumar_durable_loan"
                                           value="Consumar Durable Loan" name="loan_type">
                                    <label for="consumar_durable_loan">Consumar Durable Loan</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row loan_purpose">
                    <div class="col-md-12">
                        <div class="radio-heading input-group-text">
                            <label class="p_label">Loan Purpose</label>
                        </div>
                        <?= $form->field($model, 'loan_purpose')->dropDownList([
                            'Travel' => 'Travel',
                            "Credit Card EMI's" => "Credit Card EMI's",
                            "Personal Emergencies" => "Personal Emergencies",
                        ], ['prompt' => 'Select Loan Purposes'])->label(false) ?>
                    </div>
                </div>

                <div class="row edu-show">
                    <div class="col-md-12">
                        <div id="the-basics-college">
                            <?= $form->field($model, 'university_name')->textInput(['placeholder' => 'College / University Name', 'class' => 'form-control text-capitalize typeahead'])->label(false); ?>
                        </div>
                    </div>
                </div>
                <div class="row edu-show">
                    <div class="col-md-12">
                        <div id="the-basics">
                            <?= $form->field($model, 'course_name')->textInput(['placeholder' => 'Course Name', 'class' => 'form-control text-capitalize typeahead'])->label(false); ?>
                        </div>
                    </div>
                </div>
                <div class="row edu-show">
                    <div class="col-md-12">
                        <?= $form->field($model, 'course_fee_annual')->textInput(['placeholder' => 'Annual Course Fee', 'maxLength' => 20])->label(false); ?>
                    </div>
                </div>

                <div class="row type-show">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="radio-heading input-group-text">
                                <strong>Vehicle Type</strong>
                            </div>
                            <ul class="relationList">
                                <li class="service-list">
                                    <input type="radio" class="input_radio_vehicle_type vehicle_type" value="New"
                                           id="vehicle_new" name="condition">
                                    <label for="vehicle_new">New</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_vehicle_type vehicle_type" value="Old"
                                           id="vehicle_old" name="condition">
                                    <label for="vehicle_old">Old</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 e_type">
                        <div class="form-group">
                            <div class="radio-heading input-group-text">
                                <strong>E-Vehicle Type</strong>
                            </div>
                            <ul class="relationList">
                                <li class="service-list list-width">
                                    <input type="radio" class="input_radio_e_type" value="1"
                                           id="two" name="e_type">
                                    <label for="two">2 Wheeler</label>
                                </li>
                                <li class="service-list list-width">
                                    <input type="radio" class="input_radio_e_type" value="2"
                                           id="three" name="e_type">
                                    <label for="three">3 Wheeler</label>
                                </li>
                                <li class="service-list list-width">
                                    <input type="radio" class="input_radio_e_type" value="3"
                                           id="four" name="e_type">
                                    <label for="four">4 Wheeler</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row type-option">
                    <div class="col-md-6 old-options">
                        <div class="form-group">
                            <div class="radio-heading input-group-text">
                                <label class="p_label">Vehicle Type Options</label>
                            </div>
                            <ul class="relationList">
                                <li class="service-list">
                                    <input type="radio" class="input_radio_purchase change-options" value="Purchase"
                                           id="vehicle_purchase" name="vehicle_type_options">
                                    <label for="vehicle_purchase">Purchase</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_purchase change-options" value="Pre-Owned"
                                           id="vehicle_owned" name="vehicle_type_options">
                                    <label for="vehicle_owned">Pre-Owned</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="radio-heading input-group-text">
                                <label class="p_label">Make</label>
                            </div>
                            <ul class="relationList">
                                <li class="service-list">
                                    <input type="radio" class="input_radio_make change-options" value="Hero"
                                           id="hero" name="vehicle_type_make">
                                    <label for="hero">Hero</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_make change-options" value="Bjaj"
                                           id="bjaj" name="vehicle_type_make">
                                    <label for="bjaj">Bjaj</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_make change-options" value="Honda"
                                           id="honda" name="vehicle_type_make">
                                    <label for="honda">Honda</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_make change-options" value="Others"
                                           id="others" name="vehicle_type_make">
                                    <label for="others">Others</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 new-options">
                        <div class="form-group">
                            <div class="radio-heading input-group-text">
                                <label class="p_label">Manufactured Year</label>
                            </div>
                            <ul class="relationList">
                                <li class="service-list">
                                    <input type="radio" class="input_radio_manufactured_year change-options"
                                           value="<?= date('Y', strtotime("-1 year")) ?>"
                                           id="previous_year" name="manufactured_year">
                                    <label for="previous_year"><?= date('Y', strtotime("-1 year")) ?></label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_manufactured_year change-options"
                                           value="<?= date('Y') ?>"
                                           id="next_year" name="manufactured_year">
                                    <label for="next_year"><?= date('Y') ?></label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="radio-heading input-group-text">
                            <label class="p_label">Vehicle Model</label>
                        </div>
                        <?= $form->field($model, 'vehicle_model')->textInput(['placeholder' => 'Enter Model Name', 'class' => 'form-control text-capitalize'])->label(false); ?>
                    </div>
                    <div class="col-md-6 old-options">
                        <div class="radio-heading input-group-text">
                            <label class="p_label">Manufactured Year</label>
                        </div>
                        <?= $form->field($model, 'manufactured_year')->textInput(['placeholder' => 'Enter Manufactured Year', 'class' => 'form-control text-capitalize'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div><label class="p_label">Parent Information (Optional, You Can Add Multiple)</label>
                        </div>
                        <div class="form-group"><input type="text" name="parent_name[]"
                                                       class="form-control text-capitalize" placeholder="Name"
                                                       id="parent_name[]"></div>
                        <div class="form-group">
                            <div class="radio-heading input-group-text">
                                <strong>Relation</strong>
                            </div>
                            <ul class="relationList">
                                <li class="service-list">
                                    <input type="radio" class="input_radio_relation" value="Father" id="reFather"
                                           name="parent_relation[0]">
                                    <label for="reFather">Father</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_relation" id="reMother" value="Mother"
                                           name="parent_relation[0]">
                                    <label for="reMother">Mother</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_relation" id="reBrother" value="Brother"
                                           name="parent_relation[0]">
                                    <label for="reBrother">Brother</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_relation" id="reSister" value="Sister"
                                           name="parent_relation[0]">
                                    <label for="reSister">Sister</label>
                                </li>
                                <li class="service-list">
                                    <input type="radio" class="input_radio_relation" id="reGuardian"
                                           value="Guardian"
                                           name="parent_relation[0]">
                                    <label for="reGuardian">Guardian</label>
                                </li>
                            </ul>
                        </div>
                        <div class="form-group"><input type="text" name="parent_mobile_number[]"
                                                       class="form-control parent_mobile_number"
                                                       placeholder="Mobile Number" id="parent_mobile_number[]"
                                                       maxlength="10" minlength="10"></div>
                        <div class="form-group"><input type="text" name="parent_annual_income[]"
                                                       class="form-control parent_annual_income"
                                                       placeholder="Annual Income" id="parent_annual_income[]">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="clone_fields_parent"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button id="add_parent_info" class="addAnotherCo"><i class="fas fa-plus"></i> Add More
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 center">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary logo-dark-color', 'id' => 'subBtn']) ?>
                        <button type="button" class="button-slide btn" id="loadBtn">
                            Processing <i class="fas fa-circle-notch fa-spin fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>
<input type="hidden" name="parentElem" id="parentElem" value="1">
<script>
    function removeAnotherField(ths) {
        ths.closest('.parent_inforamtion').remove();
        counElement();
    }

    function counElement() {
        var count = $('input[name="parent_name[]"]').length;
        $('#parentElem').val(count);
    }
</script>
<?php
$script = <<< JS
$(document).on('change','.loan_type',function(e) {
  e.preventDefault();
  var value = $(this).val();
  var education_show = $('.edu-show');
  var vehicle_type = $('.type-show');
  $('.loan-type-err').text('');
  $('.loan-type-err').removeClass('has-error');
  $('.type-option').hide();
  $('.e_type').hide();
  vehicle_type.hide();
      education_show.hide();
      $('.loan_purpose').hide();
    if ($(this).is(':checked') && value === 'Education Loan'){
        education_show.show();
    } else{
        $('input:radio').prop('checked',false);
        $(this).prop('checked',true);
    }
    if ($(this).is(':checked') && value === 'Personal Loan'){
        $('.loan_purpose').show();
    } else{
        $('input:radio').prop('checked',false);
        $(this).prop('checked',true);
    }
    if ($(this).is(':checked') && (value === 'E-Vehicle Loan'|| value === 'Car Loan' || value === 'Two Wheeler Loan')){
        vehicle_type.show();
        if($(this).is(':checked') && value === 'E-Vehicle Loan'){
            $('.e_type').show();
        } else {
            $('.e_type').hide();
        }
    } else{
        $('input:radio').prop('checked',false);
        $(this).prop('checked',true);
    }
});
$(document).on('change','.vehicle_type',function(e) {
  e.preventDefault();
  var value = $(this).val();
  var vehicle_type = $('.type-show');
  var type_options = $('.type-option');
  var old_options = $('.old-options');
  vehicle_type.hide();
  old_options.hide();
  $('.new-options').hide();
  $('.change-options').prop('checked',false);
  if ($(this).is(':checked') && (value === 'Old' || value === 'New')){
        vehicle_type.show();
      type_options.show();
    }
  if (value === 'New'){
      $('.new-options').show();
  }
  if (value === 'Old'){
      old_options.show();
  }
});
$('#student_mobile_number').mask("#", {reverse: true});
$('.parent_mobile_number').mask("#", {reverse: true}); 
$('.parent_annual_income').mask("#", {reverse: true});
$('#course_fee_annual').mask("#", {reverse: true});
var addMoreCount = 1;
$(document).on('click','#add_parent_info',function (e){
    addAnotherField();
    addMoreCount++;
});
$(document).on('click','.addAnotherCo',function (e){
    e.preventDefault();
});
function addAnotherField()
{
    var field = ['<div class="col-md-12">' +
     '<div><label class="p_label">Parent Information</label></div>'+
     '<div class="form-group"><input type="text" name="parent_name[]" class="form-control text-capitalize" placeholder = "Name" id="parent_name[]"></div>' +
     '<div class="form-group">' +
      '<div class="radio-heading input-group-text">' +
       '<strong>Relation</strong>' +
        '</div>' +  
         '<ul class="relationList"><li class="service-list"><input type="radio" class="input_radio_relation" value="Father" id="reFather'+addMoreCount+'" name="parent_relation['+addMoreCount+']">'+
                '<label for="reFather'+addMoreCount+'">Father</label></li><li class="service-list">'+
                '<input type="radio" class="input_radio_relation" id="reMother'+addMoreCount+'" value="Mother" name="parent_relation['+addMoreCount+']">'+
                '<label for="reMother'+addMoreCount+'">Mother</label></li><li class="service-list">'+
                '<input type="radio" class="input_radio_relation" id="reBrother'+addMoreCount+'" value="Brother" name="parent_relation['+addMoreCount+']">'+
                '<label for="reBrother'+addMoreCount+'">Brother</label></li><li class="service-list">'+
                '<input type="radio" class="input_radio_relation" id="reSister'+addMoreCount+'" value="Sister" name="parent_relation['+addMoreCount+']">'+
                '<label for="reSister'+addMoreCount+'">Sister</label></li><li class="service-list">'+
                '<input type="radio" class="input_radio_relation" id="reGuardian'+addMoreCount+'" value="Guardian" name="parent_relation['+addMoreCount+']">'+
                '<label for="reGuardian'+addMoreCount+'">Guardian</label></li>' +
         '</ul>' +
        '</div>'+
     '<div class="form-group"><input type="text" name="parent_mobile_number[]" class="form-control parent_mobile_number" placeholder = "Mobile Number" id="parent_mobile_number[]" maxlength="15" minlength="10"></div>' +
     '<div class="form-group"><input type="text" name="parent_annual_income[]" class="form-control parent_annual_income" placeholder = "Annual Income" id="parent_annual_income[]"></div>' +
     '<div class"pull-right">'+
     '<button type="button" class="addAnotherCo input-group-text float-right" onclick="removeAnotherField(this)"><i class="fas fa-times"></i> Remove</button>'+
     '</div>'+
     '</div>'];  
            var textnode = document.createElement("div"); 
            textnode.setAttribute('class', 'parent_inforamtion');
            textnode.innerHTML = field; 
            $('#clone_fields_parent').prepend(textnode);
            $('.parent_mobile_number').mask("#", {reverse: true}); 
            $('.parent_annual_income').mask("#", {reverse: true});
            counElement();
}
getCourses();
getCollege(datatype=0,source=3,type=['College']);
function getCollege(datatype, source, type)
    {
        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
             substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
             // contains the substring `q`, add it to the `matches` array
             $.each(strs, function(i, str) {
             if (substrRegex.test(str)) {
              matches.push(str); 
             }
            });
             cb(matches);  
            }; 
        };
        var _college = []; 
         $.ajax({         
            url : '/api/v3/companies/organization-list', 
            method : 'GET',   
            data:{ 
                datatype:datatype,
                source:source, 
                type:type
                },  
            success : function(res) {
            if (res.response.status==200){
                 res = res.response.results;
                $.each(res,function(index,value) 
                  {   
                   _college.push(value.text);
                  }); 
               } else
                {
                   console.log('colleges could not fetch');
                }
            } 
        });
        $('#the-basics-college .typeahead').typeahead({
             hint: true, 
             highlight: true,
             minLength: 1
            },
        {
         name: '_college',
         source: substringMatcher(_college)
        }); 
    } 
function getCourses()
    {
        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
             substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
             // contains the substring `q`, add it to the `matches` array
             $.each(strs, function(i, str) {
             if (substrRegex.test(str)) {
              matches.push(str);
             }
            });
             cb(matches);
            };
        };
        var _courses = [];
         $.ajax({     
            url : '/api/v3/education-loan/course-pool-list', 
            method : 'GET',
            success : function(res) {
            if (res.response.status==200){
                res = res.response.course;
                $.each(res,function(index,value) 
                  {   
                   _courses.push(value.value);
                  }); 
               } else
                {
                   console.log('courses could not fetch');
                }
            } 
        });
        $('#the-basics .typeahead').typeahead({
             hint: true, 
             highlight: true,
             minLength: 1
            },
        {
         name: '_courses',
         source: substringMatcher(_courses)
        }); 
    } 
    
$(document).on('submit','#leads_form',function(event) {
  event.preventDefault();
  event.stopImmediatePropagation();
  var i = 1;
  var j = 0;
 $.each($('.input_radio_relation'),function(index,value)
  {
      if (i<=5){
       $(this).attr('name','parent_relation['+j+']');   
       i++;
      }
      
      if (i==6)
          {
              i=0;
              j++;
          }
  });
    
  var loan_type = $('.input_radio_loan_type:checked').val();
  var manufactured_year = $('.input_radio_manufactured_year:checked').val();
  var make = $('.input_radio_make:checked').val();
  var type_options = $('.input_radio_purchase:checked').val();
  var vehicle_type = $('.input_radio_vehicle_type:checked').val();
  var e_type = $('.input_radio_e_type:checked').val();
  var formData = new FormData(this);
  formData.append('parentElem',$('#parentElem').val());
  var type_len = $('.input_radio_loan_type:checked').length;
  if (type_len == 0){
      $('.loan-type-err').text('You have to Select at least One Loan type');
      $('.loan-type-err').addClass('has-error');
      return; 
  }
  $("#leads_form *").filter(":input").each(function(){
      if ($(this).val() == '')
        $(this).prop("disabled", true);
    });
  if (loan_type !== undefined){
    formData.append('loan_type',loan_type);
  } 
   
  if (type_options !== undefined){
    formData.append('vehicle_type_options',type_options);
  }
  if (e_type !== undefined){
    formData.append('vehicle_type',e_type);
  }
  if (manufactured_year !== undefined){
    formData.append('manufactured_year',manufactured_year);
  }
  if (make !== undefined){
    formData.append('maker',make);
  }
  if (vehicle_type !== undefined){
    formData.append('vehicle_condition',vehicle_type);
  }
      $.ajax({
        url: "/education-loans/leads",
        method: "POST",
        data: formData,
        contentType: false,
        cache:false,
        processData: false,
        beforeSend:function(){
            $('#subBtn').hide();     
            $('#loadBtn').show(); 
        },
        success: function (response) {
            $('#subBtn').show();     
            $('#loadBtn').hide();
           if (response.status==200)
               {
                   toastr.success(response.message, response.title);
                   $('.share_btn').attr('href','https://api.whatsapp.com/send?phone='+$('#student_mobile_number').val()+'&text='+link_form)
                   $('#app_num').text(response.app_num);
                   $('#light_box_submit').css('display','block');
               }else {
                  toastr.error(response.message, response.title);
               }
        },
    });
})    
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/fonts/fontawesome-5/css/all.css');
$this->registerCss("
.edu-show,.type-option,.type-show,.old-options,.new-options,.loan_purpose,.e_type{
    display:none;
}
.has-error{
color:red;
}
.list-width{
min-width:70px;
}
.l_tag{
margin: 0 0 0 10px;
font-family: 'Roboto', sans-serif;
font-size:15px !important;
}
#user_box{   
    position: fixed;
    width: 100%;
    max-width: 250px;
    display: flex;
    right: 0;
    background-color: #fff;
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0px 3px 10px 5px #eee;
    align-items: center;
}
#user_box img{
    max-width: 50px;
    display: inline-block;
    border-radius: 50%;
}
#user_box canvas{
border-radius: 50%;
}
#user_box h3{
    display: inline-block;
} 
.addAnotherCo{
    background: none;
    border:none;
    margin-bottom:20px;
}
.addAnotherCo:hover{
    color:#00a0e3;
    transition: .3s ease;
}
.p_label{
font-size: 13px;
}
.logo-dark-color{
    background-color: #00a0e3;
    border-color: #00a0e3;
}
.set-overlay{
    background-color: #ffffffd9;
    padding: 30px 30px 40px;
    box-shadow: 0px 0px 16px 6px #b3b3b399;
    border-radius: 6px;
}
.form-wrapper{
    padding: 25px 20px 0px;
}
.twitter-typeahead{width:100%}
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
.center 
{
text-align:center
}
.display-table{z-index:unset !important}
#loadBtn{
display:none;
}

.light-box-modal{
    position: fixed;
    background-color: #000000b5;
    width: 100%;
    height: 100%;
    z-index: 9999;
    top: 0;
    left: 0;
}
.light-box-in{
    position: relative;
    width: 90%;
    max-width: 450px;
    margin: auto;
//    height: 78vh;
    height: 380px;
    top: calc(48vh - 190px);
    background-color: #fff;
    border-radius: 4px;
    overflow: hidden;
    box-shadow: 0px 1px 5px 1px #eeeeeea3;
}
.light-box-img{
    position: relative;
    width: 100%;
    background: linear-gradient(90deg, #86dbff 5%, #00b4ff 85%);
    height: calc(100% - 165px);
    text-align:center;
}
.light-box-img img{
    width: 225px;
    margin-top: 20px;
}
.light-box-img h3{
    display: block;
    color: #fff;
    font-weight: 600;
    font-size:21px;
    margin: 9px;
}
.light-box-content{
    text-align: center;
    height: 110px;
//    line-height: 72px;
}
.light-box-content p{
    vertical-align: middle;
    line-height: 15px;
    padding: 15px;
    color: #222;
    margin: 0;
    font-size: 17px;
    padding-bottom: 0px;
}
.light-box-content a:hover{
    box-shadow: 0px 1px 5px 1px #ddd;
}
.light-box-content a.highlight{
    color: #fff;
    background-color: #00a0e3;
    border: 1px solid #00a0e3;
}
#light_box_submit{display:none}
#app_num{
font-weight: 700;
}
.share_btn
{
font-size:22px
}
.service-list {
        display: inline-block;
        min-width: 90px;
        text-align: center;
        margin: 0px 5px;
    }

    .service-list > label {
        width: 100%;
        display: inline-block;
        background-color: rgba(255, 255, 255, .9);
        border: 2px solid rgba(139, 139, 139, .3);
        color: #333;
        font-weight:normal;
        border-radius: 4px;
        white-space: nowrap;
        margin: 3px 0px;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-tap-highlight-color: transparent;
        transition: all .2s;
    }

    .service-list > label {
        padding: 8px 5px;
        cursor: pointer;
    }
    .relationList{
        padding:0px;
    }

    .service-list > input[type='radio']:checked + label, .service-list > label:hover {
        border: 2px solid #00a0e3;
        background-color: #00a0e3;
        color: #fff;
        transition: all .2s;
    }

    .service-list > input {
        position: absolute;
        opacity: 0;
    }

    .service-list > input[type='radio']:focus + label {
        border: 2px solid #00a0e3;
    }
");
$this->registerCssFIle('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
