<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Html;
use kartik\widgets\TimePicker;

$primary_cat = ArrayHelper::map($primaryfields, 'category_enc_id', 'name');
?>
    <div class="container">
        <div class="col-md-12">

            <div class="tabbable-line">
                <ul class="nav nav-tabs ">
                    <li class="active">
                        <a href="#tab_15_1" data-toggle="tab"> Job</a>
                    </li>
                    <li>
                        <a href="#tab_15_2" data-toggle="tab"> Internship</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="portlet light tab-pane active" id="tab_15_1">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-red"></i>
                            <span class="caption-subject font-red bold uppercase">Candidate
                        <span class="step-title"> Preferences</span>
                    </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'job_submit_form',
                            'enableClientValidation' => true,
                            'validateOnBlur' => false,
                            'fieldConfig' => [
                                'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}{error}</div>",
                            ]
                        ]);
                        ?>

                        <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($applicationpreferenceformModel, 'job_category')->dropDownList($primary_cat, ['prompt' => 'Choose Job Profile', 'disabled' => false, 'id' => job_category])->label(false); ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($applicationpreferenceformModel, 'work_experience')->dropDownList(['0' => 'No Experience', '1' => 'Less Than 1', '2' => '1 year', '3' => '2-3 years', '3-5' => '3-5 years', '5-10' => '5-10 years', '10+' => '10+ years'], ['prompt' => 'Relevant Experience', 'id' => 'work_expierence'])->label(false); ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($applicationpreferenceformModel, 'job_type')->dropDownList(['Full Time' => 'Full Time', 'Part Time' => 'Part Time', 'Work from Home' => 'Work From Home'])->label(false); ?>
                            </div>
                            <?=$form->field($applicationpreferenceformModel, 'assigned_too')->hiddenInput(['value'=> 'Jobs'])->label(false);?>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <?=
                                $form->field($applicationpreferenceformModel, 'from_salary')->input('number', ['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Salary From')])->label(false);
                                ?>
                            </div>
                            <div class="col-md-3">
                                <?=
                                $form->field($applicationpreferenceformModel, 'to_salary')->input('number', ['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Salary To')])->label(false);
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?=
                                $form->field($applicationpreferenceformModel, 'salary_range')->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Minimum Monthly Salary'), 'id' => 'range_3'])->label(false);
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 with-load">
                                <div class="load-suggestions Typeahead-spinner" style="display: none;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <?= $form->field($applicationpreferenceformModel, 'key_skills')->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Skills'), 'id' => 'skill_data'])->label(false); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 with-load">
                                <div class="load-suggestions Typeahead-spinner" style="display: none;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <?=
                                $form->field($applicationpreferenceformModel, 'location')->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('City'), 'id' => 'city_data'])->label(false);
                                ?>
                            </div>
                            <div class="col-md-6 with-load">
                                <div class="load-suggestions Typeahead-spinner" style="display: none;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <?= $form->field($applicationpreferenceformModel, 'industry')->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Industry'), 'id' => 'industry_data'])->label(false); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="weekDays-selector">
                                        <?php $applicationpreferenceformModel->weekdays = [1, 2, 3, 4, 5]; ?>
                                        <?=
                                        $form->field($applicationpreferenceformModel, 'weekdays')->inline()->checkBoxList([
                                            '1' => 'M',
                                            '2' => 'T',
                                            '3' => 'W',
                                            '4' => 'T',
                                            '5' => 'F',
                                            '6' => 'S',
                                            '7' => 'S',
                                        ], [
                                            'item' => function ($index, $label, $name, $checked, $value) {
                                                $return = '<input type="checkbox" name="' . $name . '" value="' . $value . '" id="weekday-' . $index . '" class="weekday" ' . (($checked) ? 'checked' : '') . '/>';
                                                $return .= '<label for="weekday-' . $index . '">' . $label . '</label>';
                                                return $return;
                                            }
                                        ])->label(false);
                                        ?>
                                        <label>Working Days</label>
                                        <div id="week_options">
                                            <div class="sat-sun">
                                                <?=
                                                $form->field($applicationpreferenceformModel, 'weekoptsat')->dropDownList([
                                                    'Always' => 'Always',
                                                    'Alternative' => 'Alternative',
                                                    'Rarely' => 'Rarely',
                                                ])->label(false);
                                                ?>
                                                <span class="sat">Sat</span>
                                            </div>
                                            <div class="sat-sun">
                                                <?=
                                                $form->field($applicationpreferenceformModel, 'weekoptsund')->dropDownList([
                                                    'Always' => 'Always',
                                                    'Alternative' => 'Alternative',
                                                    'Rarely' => 'Rarely',
                                                ])->label(false);
                                                ?>
                                                <span class="sun">Sun</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($applicationpreferenceformModel, 'from')->widget(TimePicker::classname(), ['options' => ['id' => 'from'], 'pluginOptions' => []])->label('Job Timing From');
                                    ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($applicationpreferenceformModel, 'to')->widget(TimePicker::classname(), ['options' => ['id' => 'to'], 'pluginOptions' => []])->label('Upto');
                                    ?>
                                </div>
                            </div>
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-circle save_job_preference']); ?>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>

                <div class="portlet light tab-pane" id="tab_15_2">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-red"></i>
                            <span class="caption-subject font-red bold uppercase">Candidate
                        <span class="step-title"> Preferences</span>
                    </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'intern_submit_form',
                            'enableClientValidation' => true,
                            'validateOnBlur' => false,
                            'fieldConfig' => [
                                'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}{error}</div>",
                            ]
                        ]);
                        ?>
                        <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($applicationpreferenceformModel, 'job_category')->dropDownList($primary_cat, ['prompt' => 'Choose Job Profile', 'disabled' => false, 'id' => 'intern_job_category'])->label(false); ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($applicationpreferenceformModel, 'work_experience')->dropDownList(['0' => 'No Experience', '1' => 'Less Than 1', '2' => '1 year', '3' => '2-3 years', '3-5' => '3-5 years', '5-10' => '5-10 years', '10+' => '10+ years'], ['prompt' => 'Relevant Experience', 'id' => 'intern_work_expierence'])->label(false); ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($applicationpreferenceformModel, 'job_type')->dropDownList(['Full Time' => 'Full Time', 'Part Time' => 'Part Time', 'Work from Home' => 'Work From Home'],['id'=>'internship_job_type'])->label(false); ?>
                            </div>
                            <?=$form->field($applicationpreferenceformModel, 'assigned_too')->hiddenInput(['value'=> 'Internships'])->label(false);?>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <?=
                                $form->field($applicationpreferenceformModel, 'from_salary')->input('number', ['id'=>'intern_from_salary','autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Salary From')])->label(false);
                                ?>
                            </div>
                            <div class="col-md-3">
                                <?=
                                $form->field($applicationpreferenceformModel, 'to_salary')->input('number', ['id'=>'intern_to_salary','autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Salary To')])->label(false);
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?=
                                $form->field($applicationpreferenceformModel, 'salary_range')->textInput(['id'=>'intern_salary_range','autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Minimum Monthly Salary')])->label(false);
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 with-load">
                                <div class="load-suggestions Typeahead-spinner" style="display: none;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <?= $form->field($applicationpreferenceformModel, 'key_skills')->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Skills'), 'id' => 'intern_skill_data'])->label(false); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 with-load">
                                <div class="load-suggestions Typeahead-spinner" style="display: none;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <?=
                                $form->field($applicationpreferenceformModel, 'location')->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('City'), 'id' => 'intern_city_data'])->label(false);
                                ?>
                            </div>
                            <div class="col-md-6 with-load">
                                <div class="load-suggestions Typeahead-spinner" style="display: none;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <?= $form->field($applicationpreferenceformModel, 'industry')->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Industry'), 'id' => 'intern_industry_data'])->label(false); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="weekDays-selector">
                                        <?php $applicationpreferenceformModel->weekdays = [1, 2, 3, 4, 5]; ?>
                                        <?=
                                        $form->field($applicationpreferenceformModel, 'weekdays')->inline()->checkBoxList([
                                            '1' => 'M',
                                            '2' => 'T',
                                            '3' => 'W',
                                            '4' => 'T',
                                            '5' => 'F',
                                            '6' => 'S',
                                            '7' => 'S',
                                        ], [
                                                'id'=>'intern_weekdays',
                                            'item' => function ($index, $label, $name, $checked, $value) {
                                                $return = '<input type="checkbox" name="' . $name . '" value="' . $value . '" id="intern_weekday-' . $index . '" class="weekday" ' . (($checked) ? 'checked' : '') . '/>';
                                                $return .= '<label for="intern_weekday-' . $index . '">' . $label . '</label>';
                                                return $return;
                                            }
                                        ])->label(false);
                                        ?>
                                        <label>Working Days</label>
                                        <div id="week_options">
                                            <div class="sat-sun">
                                                <?=
                                                $form->field($applicationpreferenceformModel, 'weekoptsat')->dropDownList([
                                                    'Always' => 'Always',
                                                    'Alternative' => 'Alternative',
                                                    'Rarely' => 'Rarely',
                                                ],['id'=>'intern_weekoptsat'])->label(false);
                                                ?>
                                                <span class="sat">Sat</span>
                                            </div>
                                            <div class="sat-sun">
                                                <?=
                                                $form->field($applicationpreferenceformModel, 'weekoptsund')->dropDownList([
                                                    'Always' => 'Always',
                                                    'Alternative' => 'Alternative',
                                                    'Rarely' => 'Rarely',
                                                ],['id'=>'intern_weekoptsun'])->label(false);
                                                ?>
                                                <span class="sun">Sun</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($applicationpreferenceformModel, 'from')->widget(TimePicker::classname(), ['options' => ['id' => 'intern_from'], 'pluginOptions' => []])->label('Job Timing From');
                                    ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($applicationpreferenceformModel, 'to')->widget(TimePicker::classname(), ['options' => ['id' => 'intern_to'], 'pluginOptions' => []])->label('Upto');
                                    ?>
                                </div>
                            </div>
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-circle save_intern_preference']); ?>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss("

.bootstrap-tagsinput{
    width: 100%;
    min-height: 40px;
    border-radius: 0;
    border-top: 0px;
    border-left: 0px;
    border-right: 0px;
}
.bootstrap-tagsinput.focus{
    border-color:#4aa1e3;
    -webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
.bootstrap-tagsinput .tag{
    line-height: 2;
}
.bootstrap-tagsinput input{
    border: 0px !important;
    margin-bottom: 0px !important;
    width: auto !important;
}
.bootstrap-tagsinput input:focus{
    box-shadow:none !important;
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
  width: 100%;
  margin: 0px 0;
  text-align:left;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 0px 0px 6px 6px;
     -moz-border-radius: 0px 0px 6px 6px;
          border-radius: 0px 0px 6px 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
    padding: 4px 15px;
    font-size: 12px;
    line-height: 24px;
    color: #222;
    border-bottom: 1px solid #dddddda3;
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
.Typeahead-spinner-main{
    display:none;
}
.Typeahead-spinner{
    position: absolute;
    color: #222;
    z-index: 999;
    right: 0;
    top: 10px;
    font-size: 25px;
    display: none;
}
.bootstrap-tagsinput input{
       box-shadow:none !important;
       border-color: transparent;
   }
   .bootstrap-tagsinput input:focus{
       outline: none;
   }
   #week_options
{
 margin-left:10px;
}
#week_options div div{
    padding-top:0px;
}
.field-applicationpreferenceform-weekoptsat,.field-applicationpreferenceform-weekoptsund
{
    width: 100%;
    float: left;
    display:none;
}  
#applicationpreferenceform-weekoptsat,#applicationpreferenceform-weekoptsund
{
 width:90%;
}
   .weekDays-selector input {
  display: none!important;
}
.weekDays-selector input[type=checkbox] + label {
  display: inline-block;
  border-radius: 14px;
  background: #dddddd;
  height: 25px;
  width: 25px;
  margin-right: 3px;
  line-height: 25px;
  text-align: center;
  cursor: pointer;
  
}
.weekDays-selector input[type=checkbox]:checked + label {
  background: #4aa1e3;
  color: #ffffff;
}    
.sat{
    float: left;
    width: 100%;
}
.sun{
    float: left;
    width: 100%;
}
.sat-sun{
    width:50%;
    float:left;
}
.weekDays-selector{
    margin-top:25px;
    text-align:center;
}
.weekDays-selector .form-group{
    margin-bottom:0px;
}
.weekDays-selector label{
    display:block;
    margin-top:-2px;
    font-size: 16px;
}
.modal.timepicker-modal{
bottom: auto !important;
}
.control-label{
 font-size: 16px;
}
.chip {
    display: inline-block;
    height: 32px;
    font-size: 13px;
    font-weight: 500;
    color: rgba(0,0,0,0.6);
    line-height: 32px;
    padding: 0 12px;
    border-radius: 16px;
    background-color: #e4e4e4;
    margin-bottom: 5px;
    margin-right: 5px;
    margin-top: 3px;
    margin-bottom: 3px;
    background:#585859;
    color:white;
}
.chip i{
    cursor:pointer;
}
input[type=text]:not(.browser-default){
    margin: 0px;
}
/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    right: 20px;
    top:1px;
}
.load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 35px 1px;
}
.load-suggestions span:nth-child(1){
  animation: bounce 1s ease-in-out infinite;
}
.load-suggestions span:nth-child(2){
  animation: bounce 1s ease-in-out 0.33s infinite;
}
.load-suggestions span:nth-child(3){
  animation: bounce 1s ease-in-out 0.66s infinite;
}
@keyframes bounce{
  0%, 75%, 100%{
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }
  25%{
    -webkit-transform: translateY(-15px);
    -ms-transform: translateY(-15px);
    -o-transform: translateY(-15px);
    transform: translateY(-15px);
  }
}
/*Load Suggestions loader css ends */


.Typeahead-spinner{
    position: absolute;
    color: #222;
    z-index: 999;
    right: 20px;
    top: -5px;
    font-size: 25px;
    display: none;
}
");

$script = <<< JS
        function tConv24(time24) {
                var ts = time24;
                var H = +ts.substr(0, 2);
                var h = (H % 12) || 12;
                h = (h < 10) ? ("0" + h) : h;  // leading 0 at the left for 1 digit hours
                var ampm = H < 12 ? " AM" : " PM";
                ts = h + ts.substr(2, 3) + ampm;
                return ts;
            }
            
            function skills_arr() {
                var array_val = [];
                $.each($('.placeble-area span'), function (index, value) {
                    var obj_val = {};
                    obj_val["id"] = $(this).attr('data-value');
                    obj_val["value"] = $.trim($(this).text());

                    array_val.push(obj_val);
                });
                $('#skillsArray').val(JSON.stringify(array_val));
            }

            var city = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '',
                remote: {
                    url: '/cities/city-list?q=%QUERY',
                    wildcard: '%QUERY'
                }
            });
            city.initialize();

            var city_name = $('#city_data,#intern_city_data');
            city_name.materialtags({
                itemValue: 'id',
                itemText: 'text',
                typeaheadjs: {
                    name: 'city',
                    displayKey: 'text',
                    source: city.ttAdapter()
                }
            });
            
            var skill = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '',
                remote: {
                    url: '/account/skills/get-skills?q=%QUERY',
                    wildcard: '%QUERY'
                }
            });
            skill.initialize();

            var skill_name = $('#skill_data,#intern_skill_data');
            skill_name.materialtags({
                itemValue: 'id',
                itemText: 'text',
                typeaheadjs: {
                    name: 'skill',
                    displayKey: 'text',
                    source: skill.ttAdapter()
                }
            });

            var industries = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '',
                remote: {
                    url: '/account/preferences/get-industry?q=%QUERY',
                    wildcard: '%QUERY'
                }
            });
            industries.initialize();

            var industry_name = $('#industry_data,#intern_industry_data');
            industry_name.materialtags({
                itemValue: 'id',
                itemText: 'text',
                typeaheadjs: {
                    name: 'industry',
                    displayKey: 'text',
                    source: industries.ttAdapter()
                }
            });
            
            $(document).on('submit', '#job_submit_form', function (event) {
                event.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    url: "/account/preferences/candidate",
                    method: "POST",
                    data: data,
                    success: function (res) {
                        
                        var response = JSON.parse(res);
                        if(response.status == 201){
                            toastr.error(response.message, 'error');   
                        }if(response.status == 200){
                            toastr.success(response.message, 'success');   
                        }
                    }
                });
            });
            
            $(document).on('submit', '#intern_submit_form', function (event) {
                event.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    url: "/account/preferences/candidate",
                    method: "POST",
                    data: data,
                    success: function (res) {
                        var response = JSON.parse(res);
                        if(response.status == 201){
                            toastr.error(response.message, 'error');   
                        }if(response.status == 200){
                            toastr.success(response.message, 'success');   
                        }
                    }
                });
            });

            function initJob() {

                $.ajax({
                    url: "/account/preferences/get-job-data",
                    method: "POST",
                    success: function (res) {
                        
                        var response = JSON.parse(res);
                        var data = response[0];
                        if(response.status == 201){
                            
                        }else{
                            for ( var j = 0; j < response[0].userPreferredSkills.length; j++)
                            {
                                $('#skill_data').materialtags('add', {"id": response[0].userPreferredSkills[j].skill_enc_id, "text": response[0].userPreferredSkills[j]['skillEnc'].skill});
                            }
                            
                            for (var i = 0; i < response[0].userPreferredLocations.length; i++)
                            {
                                $('#city_data').materialtags('add', {"id": response[0].userPreferredLocations[i].city_enc_id, "text": response[0].userPreferredLocations[i]['cityEnc'].name});
                            }
                            
                            for (var k = 0; k < response[0].userPreferredIndustries.length; k++)
                            {
                                $('#industry_data').materialtags('add', {"id": response[0].userPreferredIndustries[k].industry_enc_id, "text": response[0].userPreferredIndustries[k]['industryEnc'].industry});
                            }
                            $('#candidatepreferenceform-weekdays input').each(function (){
                                var val = $(this).val();
                                if(jQuery.inArray(val, data.working_days)!== -1) {
                                    $(this).prop('checked', true);
                                } else{
                                    $(this).prop('checked', false);
                                }
                            });
                            $("#job_category").val(data.job_profile);
                            $("#work_expierence").val(data.experience);
                            $("#candidatepreferenceform-job_type").val(data.type);
                            $("#candidatepreferenceform-weekoptsat").val(data.sat_frequency);
                            $("#candidatepreferenceform-weekoptsund").val(data.sun_frequency);
                            $("#from").val(data.timings_from);
                            $("#to").val(data.timings_to);
                            $("#from").val(tConv24($('#from').val()));
                            $("#to").val(tConv24($('#to').val()));
                            $("#candidatepreferenceform-from_salary").val(data.min_expected_salary);
                            $("#candidatepreferenceform-to_salary").val(data.max_expected_salary);
                            
                            var range = $("#range_3");
                            var rangee = range.data("ionRangeSlider");
                            rangee.update({
                                min: 5000,
                                max: 1000000,
                                from: data.min_expected_salary,
                                to: data.max_expected_salary,
                                type: 'double',
                                grid: true,
                                grid_num: 5
                            });
                        }
                    }
                });
            }
            initJob();
            
            function initIntern() {
                $.ajax({
                    url: "/account/preferences/get-intern-data",
                    method: "POST",
                    success: function (res) {
                        
                        var response = JSON.parse(res);
                        var data = response[0];
                        if(response.status == 201){
                            
                        }else{
                            for ( var j = 0; j < response[0].userPreferredSkills.length; j++)
                            {
                                $('#intern_skill_data').materialtags('add', {"id": response[0].userPreferredSkills[j].skill_enc_id, "text": response[0].userPreferredSkills[j]['skillEnc'].skill});
                            }
                            
                            for (var i = 0; i < response[0].userPreferredLocations.length; i++)
                            {
                                $('#intern_city_data').materialtags('add', {"id": response[0].userPreferredLocations[i].city_enc_id, "text": response[0].userPreferredLocations[i]['cityEnc'].name});
                            }
                            
                            for (var k = 0; k < response[0].userPreferredIndustries.length; k++)
                            {
                                $('#intern_industry_data').materialtags('add', {"id": response[0].userPreferredIndustries[k].industry_enc_id, "text": response[0].userPreferredIndustries[k]['industryEnc'].industry});
                            }
                            $('#intern_weekdays input').each(function (){
                                var val = $(this).val();
                                if(jQuery.inArray(val, data.working_days)!== -1) {
                                    $(this).prop('checked', true);
                                } else{
                                    $(this).prop('checked', false);
                                }
                            });
                            $("#intern_job_category").val(data.job_profile);
                            $("#intern_work_expierence").val(data.experience);
                            $("#internship_job_type").val(data.type);
                            $("#intern_weekoptsat").val(data.sat_frequency);
                            $("#intern_weekoptsun").val(data.sun_frequency);
                            $("#intern_from").val(data.timings_from);
                            $("#intern_to").val(data.timings_to);
                            $("#intern_from").val(tConv24($('#intern_from').val()));
                            $("#intern_to").val(tConv24($('#intern_to').val()));
                            $("#intern_from_salary").val(data.min_expected_salary);
                            $("#intern_to_salary").val(data.max_expected_salary);
                            
                            var range = $("#intern_salary_range");
                            var rangee = range.data("ionRangeSlider");
                            rangee.update({
                                min: 5000,
                                max: 1000000,
                                from: data.min_expected_salary,
                                to: data.max_expected_salary,
                                type: 'double',
                                grid: true,
                                grid_num: 5
                            });
                        }
                    }
                });
            }
            initIntern();

            $('.field-city_data div div span .tt-input, .field-skill_data div div span .tt-input, .field-industry_data div div .twitter-typeahead .tt-input').on('typeahead:asyncrequest', function() {
                $(this).parentsUntil('.with-load').prev('.Typeahead-spinner').show();
            });
            $('.field-city_data div div span .tt-input, .field-skill_data div div span .tt-input, .field-industry_data div div .twitter-typeahead .tt-input').on('typeahead:asynccancel typeahead:asyncreceive', function() {
                $(this).parentsUntil('.with-load').prev('.Typeahead-spinner').hide();
            });
            
            $('.field-intern_city_data div div span .tt-input, .field-intern_skill_data div div span .tt-input, .field-intern_industry_data div div .twitter-typeahead .tt-input').on('typeahead:asyncrequest', function() {
                $(this).parentsUntil('.with-load').prev('.Typeahead-spinner').show();
            });
            $('.field-intern_city_data div div span .tt-input, .field-intern_skill_data div div span .tt-input, .field-intern_industry_data div div .twitter-typeahead .tt-input').on('typeahead:asynccancel typeahead:asyncreceive', function() {
                $(this).parentsUntil('.with-load').prev('.Typeahead-spinner').hide();
            });

            $('#expected_salary').mask("#,##,##,##,###", {
                reverse: true
            });

            // $(document).on('click', '#applicationpreferenceform-weekdays,#intern_weekdays input', function () {
            //     if ($('#weekday-5').prop('checked', true)) {
            //         $('.field-applicationpreferenceform-weekoptsat').css('display', 'block');
            //         $('.sat').css('display', 'block');
            //
            //     } else if ($('#weekday-5').prop('checked', false)) {
            //         $('.field-applicationpreferenceform-weekoptsat').css('display', 'none');
            //         $('.sat').css('display', 'none');
            //     }
            //     if ($('#weekday-6').is(':checked')) {
            //         $('.field-applicationpreferenceform-weekoptsund').css('display', 'block');
            //         $('.sun').css('display', 'block');
            //     } else if ($('#weekday-6').is(':not(:checked)')) {
            //         $('.field-applicationpreferenceform-weekoptsund').css('display', 'none');
            //         $('.sun').css('display', 'none');
            //     }
            // });
            
            //Jobs salary slider

            $("#range_3").ionRangeSlider({
                min: 5000,
                max: 1000000,
                from: 40000,
                to: 70000,
                type: 'double',
                grid: true,
                grid_num: 5
            });
            
            var range = $("#range_3");
            var raangee = range.data("ionRangeSlider");
            
            $("#candidatepreferenceform-from_salary,#candidatepreferenceform-to_salary").on("change",function() {
                var s_from = $('#candidatepreferenceform-from_salary').prop('value');
                var s_to = $('#candidatepreferenceform-to_salary').prop('value');
                
                raangee.update({
                    min: 5000,
                    max: 1000000,
                    from: s_from,
                    to: s_to,
                    type: 'double',
                    grid: true,
                    grid_num: 5
                });
            });

            range.ionRangeSlider({
                type: "double",
                min: 0,
                max: 100,
                from: 20,
                to: 80
            });

            range.on("change", function () {
                var value = $(this).prop("value").split(";");
                $('#candidatepreferenceform-from_salary').val(value[0]);
                $('#candidatepreferenceform-to_salary').val(value[1]);
            });
            
            //InterShip salary slider
            
            $("#intern_salary_range").ionRangeSlider({
                min: 5000,
                max: 1000000,
                from: 40000,
                to: 70000,
                type: 'double',
                grid: true,
                grid_num: 5
            });
            
            var range = $("#intern_salary_range");
            var rangee = range.data("ionRangeSlider");
            
            $("#intern_from_salary,#intern_to_salary").on("change",function() {
                var s_from = $('#intern_from_salary').prop('value');
                var s_to = $('#intern_to_salary').prop('value');
                
                rangee.update({
                    min: 5000,
                    max: 1000000,
                    from: s_from,
                    to: s_to,
                    type: 'double',
                    grid: true,
                    grid_num: 5
                });
            });

            range.ionRangeSlider({
                type: "double",
                min: 0,
                max: 100,
                from: 20,
                to: 80
            });

            range.on("change", function () {
                var value = $(this).prop("value").split(";");
                $('#intern_from_salary').val(value[0]);
                $('#intern_to_salary').val(value[1]);
            });
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerCssFile('@backendAssets/global/plugins/ion.rangeslider/css/ion.rangeSlider.css');
$this->registerCssFile('@backendAssets/global/plugins/ion.rangeslider/css/ion.rangeSlider.skinFlat.css');
$this->registerCssFile('http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css');
//$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css');
$this->registerCssFile('//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
$this->registerCssFile('@eyAssets/materialized/materialize-tags/css/materialize-tags.css');
$this->registerJsFile('http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/materialized/materialize-tags/js/materialize-tags.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/ion.rangeslider/js/ion.rangeSlider.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
