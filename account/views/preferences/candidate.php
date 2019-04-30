<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Html;
use kartik\widgets\TimePicker;
use kartik\select2\Select2;

$primary_cat = ArrayHelper::map($primaryfields, 'category_enc_id', 'name');
?>


    <div class="container">
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="tabbable-line">
                <ul class="nav nav-tabs ">
                    <li class="active">
                        <a href="#tab_15_1" data-toggle="tab"> Jobs</a>
                    </li>
                    <li>
                        <a href="#tab_15_2" data-toggle="tab" id="interns"> Internships</a>
                    </li>
                </ul>
            </div>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                <div class="tab-pane active" id="tab_15_1">
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
                            <div class="col-md-6">
                                <?= $form->field($applicationpreferenceformModel, 'job_category')->widget(Select2::classname(), [
                                    'name' => 'kv-state-210',
                                    'data' => $primary_cat,
                                    'size' => Select2::MEDIUM,
                                    'options' => ['placeholder' => 'Select Job Profile', 'multiple' => true, 'id' => 'job_category'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ])->label(false); ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($applicationpreferenceformModel, 'work_experience')->dropDownList(['0' => 'No Experience', '1' => 'Less Than 1', '2' => '1 year', '3' => '2-3 years', '3-5' => '3-5 years', '5-10' => '5-10 years', '10+' => '10+ years'], ['prompt' => 'Relevant Experience', 'id' => 'work_expierence'])->label(false); ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($applicationpreferenceformModel, 'job_type')->dropDownList(['Full Time' => 'Full Time', 'Part Time' => 'Part Time', 'Work from Home' => 'Work From Home'])->label(false); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <?=
                                $form->field($applicationpreferenceformModel, 'from_salary')->textInput(['autocomplete' => 'off', 'placeholder' => 'Min Salary (p.a)', 'maxlength' => '15', 'min' => '1'])->label(false);
                                ?>
                            </div>
                            <div class="col-md-3">
                                <?=
                                $form->field($applicationpreferenceformModel, 'to_salary')->textInput(['autocomplete' => 'off', 'placeholder' => 'Max Salary (p.a)', 'maxlength' => '15', 'min' => '1'])->label(false);
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?=
                                $form->field($applicationpreferenceformModel, 'salary_range')->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Minimum Monthly Salary'), 'id' => 'range_3'])->label(false);
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pf-field no-margin">
                                    <ul class="tags skill_tag_list">
                                        <?php if (!empty($juser_skills)) {
                                            foreach ($juser_skills as $skill) { ?>
                                                <li class="addedTag"><?= $skill['skill'] ?><span
                                                            onclick="$(this).parent().remove();"
                                                            class="tagRemove">x</span><input type="hidden"
                                                                                             name="skills[]"
                                                                                             value="<?= $skill['skill'] ?>">
                                                </li>
                                            <?php }
                                        } ?>
                                        <li class="tagAdd taglist">
                                            <div class="skill_wrapper">
                                                <i class="Typeahead-spinner fa fa-circle-o-notch fa-spin fa-fw"></i>
                                                <?= $form->field($applicationpreferenceformModel, 'key_skills', ['template' => '{input}'])->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Skills'), 'id' => 'search-skill', 'class' => "skill-input"])->label(false); ?>

                                            </div>
                                </div>
                                </li>
                                </ul>
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
                                            <div class="sat-sun sat-hide">
                                                <?=
                                                $form->field($applicationpreferenceformModel, 'weekoptsat')->dropDownList([
                                                    'Always' => 'Always',
                                                    'Alternative' => 'Alternative',
                                                    'Rarely' => 'Rarely',
                                                ])->label(false);
                                                ?>
                                                <span class="sat">Saturday</span>
                                            </div>
                                            <div class="sat-sun sun-hide">
                                                <?=
                                                $form->field($applicationpreferenceformModel, 'weekoptsund')->dropDownList([
                                                    'Always' => 'Always',
                                                    'Alternative' => 'Alternative',
                                                    'Rarely' => 'Rarely',
                                                ])->label(false);
                                                ?>
                                                <span class="sun">Sunday</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($applicationpreferenceformModel, 'from')->widget(TimePicker::classname(), ['options' => ['id' => 'from'], 'pluginOptions' => ['defaultTime' => '9:00 AM']])->label('Job Timing From');
                                    ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($applicationpreferenceformModel, 'to')->widget(TimePicker::classname(), ['options' => ['id' => 'to'], 'pluginOptions' => ['defaultTime' => '5:00 PM']])->label('Upto');
                                    ?>
                                </div>
                            </div>
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-circle save_job_preference']); ?>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab_15_2">
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
                            <div class="col-md-6">
                                <?= $form->field($internapplicationpreferenceformModel, 'job_category')->widget(Select2::classname(), [
                                    'name' => 'kv-state-210',
                                    'data' => $primary_cat,
                                    'size' => Select2::MEDIUM,
                                    'options' => ['placeholder' => 'Job Profile', 'multiple' => true, 'id' => 'intern_job_category'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ])->label(false); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($internapplicationpreferenceformModel, 'job_type')->dropDownList(['Full Time' => 'Full Time', 'Part Time' => 'Part Time', 'Work from Home' => 'Work From Home'], ['id' => 'internship_job_type'])->label(false); ?>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pf-field no-margin">
                                    <ul class="tags intern_skill_tag_list">
                                        <?php if (!empty($iuser_skills)) {
                                            foreach ($iuser_skills as $skill) { ?>
                                                <li class="addedTag"><?= $skill['skill'] ?><span
                                                            onclick="$(this).parent().remove();"
                                                            class="tagRemove">x</span><input type="hidden"
                                                                                             id="intern_skill"
                                                                                             name="intern_skills[]"
                                                                                             value="<?= $skill['skill'] ?>">
                                                </li>
                                            <?php }
                                        } ?>
                                        <li class="tagAdd taglist">
                                            <div class="skill_wrapper">
                                                <i class="Typeahead-spinner fa fa-circle-o-notch fa-spin fa-fw"></i>
                                                <?= $form->field($internapplicationpreferenceformModel, 'key_skills', ['template' => '{input}'])->textInput(['autocomplete' => 'off', 'placeholder' => $internapplicationpreferenceformModel->getAttributeLabel('Skills'), 'id' => 'intern-search-skill', 'class' => "intern-skill-input"])->label(false); ?>

                                            </div>
                                </div>
                                </li>
                                </ul>
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
                                $form->field($internapplicationpreferenceformModel, 'location')->textInput(['autocomplete' => 'off', 'placeholder' => $internapplicationpreferenceformModel->getAttributeLabel('City'), 'id' => 'intern_city_data'])->label(false);
                                ?>
                            </div>
                            <div class="col-md-6 with-load">
                                <div class="load-suggestions Typeahead-spinner" style="display: none;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <?= $form->field($internapplicationpreferenceformModel, 'industry')->textInput(['autocomplete' => 'off', 'placeholder' => $internapplicationpreferenceformModel->getAttributeLabel('Industry'), 'id' => 'intern_industry_data'])->label(false); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="weekDays-selector">
                                        <?php $internapplicationpreferenceformModel->weekdays = [1, 2, 3, 4, 5]; ?>
                                        <?=
                                        $form->field($internapplicationpreferenceformModel, 'weekdays')->inline()->checkBoxList([
                                            '1' => 'M',
                                            '2' => 'T',
                                            '3' => 'W',
                                            '4' => 'T',
                                            '5' => 'F',
                                            '6' => 'S',
                                            '7' => 'S',
                                        ], [
                                            'id' => 'intern_weekdays',
                                            'item' => function ($index, $label, $name, $checked, $value) {
                                                $return = '<input type="checkbox" name="' . $name . '" value="' . $value . '" id="intern_weekday-' . $index . '" class="weekday" ' . (($checked) ? 'checked' : '') . '/>';
                                                $return .= '<label for="intern_weekday-' . $index . '">' . $label . '</label>';
                                                return $return;
                                            }
                                        ])->label(false);
                                        ?>
                                        <label>Working Days</label>
                                        <div id="week_options">
                                            <div class="sat-sun intern-sat-hide">
                                                <?=
                                                $form->field($internapplicationpreferenceformModel, 'weekoptsat')->dropDownList([
                                                    'Always' => 'Always',
                                                    'Alternative' => 'Alternative',
                                                    'Rarely' => 'Rarely',
                                                ], ['id' => 'intern_weekoptsat'])->label(false);
                                                ?>
                                                <span class="sat">Saturday</span>
                                            </div>
                                            <div class="sat-sun intern-sun-hide">
                                                <?=
                                                $form->field($internapplicationpreferenceformModel, 'weekoptsund')->dropDownList([
                                                    'Always' => 'Always',
                                                    'Alternative' => 'Alternative',
                                                    'Rarely' => 'Rarely',
                                                ], ['id' => 'intern_weekoptsun'])->label(false);
                                                ?>
                                                <span class="sun">Sunday</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($internapplicationpreferenceformModel, 'from')->widget(TimePicker::classname(), ['options' => ['id' => 'intern_from'], 'pluginOptions' => ['defaultTime' => '9:00 AM']])->label('Job Timing From');
                                    ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($internapplicationpreferenceformModel, 'to')->widget(TimePicker::classname(), ['options' => ['id' => 'intern_to'], 'pluginOptions' => ['defaultTime' => '5:00 PM']])->label('Upto');
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
    </div>
<?php
$this->registerCss("
.irs-disabled{
    pointer-events: none;
}
.s2-togall-button{
    display:none;
}

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
.Typeahead-spinner{
    position: absolute;
    right: 8px;
    top: 18px;
    font-size: 22px;
    display:none;
    }
    
    .skill_wrapper .Typeahead-spinner{
    position: absolute;
    right: 5px;
    top: 10px;
    z-index: 9;
    font-size:18px;
    display:none;
}
.bootstrap-tagsinput input{
       box-shadow:none !important;
       border-color: transparent;
   }
   input:focus{
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
  background: #00a0e3;
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
    position: relative;
    height: 32px;
    font-size: 13px;
    font-weight: 500;
    line-height: normal;
    padding: 7px 17px;
    border-radius: 8px;
    background-color: #e4e4e4;
    margin-right: 5px;
    margin-top: 3px;
    margin-bottom: 3px;
    background: #f4f5fa;
    color: #333;
}
.chip i{
    cursor:pointer;
    position: absolute;
    background-color: #00a0e3;
    padding: 1px;
    border-radius: 100%;
    top: -4px;
    right: -4px;
    width: 16px;
    height: 16px;
    text-align: center;
    color: #fff;
    font-weight: 100;
    font-size: 11px;
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
.tt-hint, .tt-input{
    padding-top:8px !important;
}
.select2-selection{
    padding-right:10px !important;
}
.skill_wrapper div .twitter-typeahead{
    width: 100%;
}
.twitter-typeahead{
    height:38px;
}

/*-- skills tags input css starts --*/
.tags > .addedTag > span{
    background: #00a0e3;
}
//.taglist{
//    float:left !important;
//}
.input_search{
    position: relative;
    vertical-align: top;
    background-color: transparent;
    padding: 15px 10px !important;
    font-size: 15px;
    border-radius: 7px;
}
.skill_wrapper{position:relative;width:100%;}
.no-margin {
    margin: 0 !important;
}
.pf-field {
    float: left;
    width: 100%;
    position: relative;
}
.tags {
    float: left;
    width: 100%;
    border: 2px solid #e8ecec;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    padding: 8px;
}
.tags > .addedTag {
    display: inline-block;
    position: relative;
    height: 32px;
    font-size: 13px;
    font-weight: 500;
    line-height: normal;
    padding: 7px 17px;
    border-radius: 8px;
    background-color: #e4e4e4;
    margin-right: 7px;
    margin-top: 3px;
    margin-bottom: 3px;
    background: #f4f5fa;
    color: #333;
}
.tags > .addedTag > span {
    position: absolute;
    right: -6px;
    top: -5px;
    width: 16px;
    height: 16px;
    font-style: normal;
    background: #00a0e3;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
    color: #ffffff;
    text-align: center;
    font-weight: 700;
    line-height: 14px;
    font-size: 10px;
    font-family: Open Sans;
    cursor: pointer;
}
.tagAdd.taglist input {
    float: left;
    width: 100%;
    background: #ffffff;
//    border: 1px solid #e8ecec !important;
    border: 0px;
    height: 40px;
    padding-left: 14px;
    padding-top: 1px !important;
    margin-top: 0px;
    font-size: 12px;
    border-radius: 5px;
    font-weight: 400;
}
.taglist .skill_wrapper .form-group{
    margin-bottom:0px;
}
li.tagAdd.taglist{
    flex-grow: 1;
    position: relative;
    display: inline-block;
}
ul.tags.skill_tag_list, ul.tags.intern_skill_tag_list {
    list-style: outside none none;
    margin: 0 0 30px;
    background: transparent;
    display: flex;
    flex-wrap: wrap;
    padding: 0 6px;
    padding-top: 5px;
    margin-bottom: 10px;
    color: #444;
    vertical-align: middle;
    width: 100%;
    max-width: 100%;
    line-height: 22px;
    cursor: text;
    -webkit-transition: all .3s;
    -moz-transition: all .3s;
    -ms-transition: all .3s;
    -o-transition: all .3s;
    transition: all .3s;
}
/*-- skills tags input css starts --*/
.select2-selection.select2-selection--multiple{
    max-height: 86px;
    position:relative;
    overflow-y: scroll;
}
.select2-container--krajee .select2-selection--multiple .select2-selection__clear {
    right: 2rem;
    top: 0.2rem;
}
.irs--round .irs-bar{
    background-color: #00a0e3;
}
.irs--round .irs-handle{
    border: 4px solid #00a0e3;
}
.irs--round .irs-from, .irs--round .irs-to, .irs--round .irs-single{
    background-color: #00a0e3;
}
.bootstrap-timepicker ~ label{
    color: inherit !important;
}
.tabbable-line>.nav-tabs>li.active, .tabbable-line>.nav-tabs>li:hover{
    border-bottom: 4px solid #00a0e3;
}
");

$script = <<< JS

        $('#candidatepreferenceform-to_salary, #candidatepreferenceform-from_salary').mask("#,#0,#00", {reverse: true});
        
        $(document).on('click','#interns',function() {
          var ps = new PerfectScrollbar('#intern_job_category ~ span > .selection > span');
        });

        $(document).on('keyup','#search-skill',function(e)
        {
            if(e.which==13)
                {
                  add_tags($(this),'skill_tag_list','skills');
                }
        });

        $(document).on('keyup','#intern-search-skill',function(e)
                {
                    if(e.which==13)
                        {
                          add_tags($(this),'intern_skill_tag_list','intern_skills');
                        }
                });

        $(document).on('keypress','input',function(e)
        {
            if(e.which==13)
                {
                    return false;
                }
        });

        var global = [];

        var skills = new Bloodhound({
          datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
          queryTokenizer: Bloodhound.tokenizers.whitespace,
           remote: {
            url:'/account/categories-list/skills-data',
            prepare: function (query, settings) {
                     settings.url += '?q=' +$('#search-skill').val();
                     return settings;
                },   
            cache: false,    
            filter: function(list) {
                     return list;
                }
          }
        });    
                    
        $('#search-skill').typeahead(null, {
          name: 'skill',
          display: 'value',
          source: skills,
           limit: 6,
        }).on('typeahead:asyncrequest', function() {
             $('.skill_wrapper .Typeahead-spinner').show();
          }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
             $('.skill_wrapper .Typeahead-spinner').hide();
          }).on('typeahead:selected',function(e, datum)
          {
              add_tags($(this),'skill_tag_list','skills');
           }).blur(validateSelection);
        
        var intern_skills = new Bloodhound({
          datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
          queryTokenizer: Bloodhound.tokenizers.whitespace,
           remote: {
            url:'/account/categories-list/skills-data',
            prepare: function (query, settings) {
                     settings.url += '?q=' +$('#intern-search-skill').val();
                     return settings;
                },   
            cache: false,    
            filter: function(list) {
                     return list;
                }
          }
        });    
                    
        $('#intern-search-skill').typeahead(null, {
          name: 'skill',
          display: 'value',
          source: intern_skills,
           limit: 6,
        }).on('typeahead:asyncrequest', function() {
             $('.skill_wrapper .Typeahead-spinner').show();
          }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
             $('.skill_wrapper .Typeahead-spinner').hide();
          }).on('typeahead:selected',function(e, datum)
          {
              add_tags($(this),'intern_skill_tag_list','intern_skills');
           }).blur(validateSelection);
        
        function validateSelection() {
          var theIndex = -1;
          for (var i = 0; i < global.length; i++) {
          if (global[i].value == $(this).val()) {
          theIndex = i;
         break;
           }
          }
          if (theIndex == -1) {
           $(this).val(""); 
           global = [];
          }
          }
          
          function add_tags(thisObj,tag_class,name,duplicates)
            {
                var duplicates = [];
                $.each($('.'+tag_class+' input[type=hidden]'),function(index,value)
                                    {
                                     duplicates.push($.trim($(this).val()).toUpperCase());
                                    });
                if(thisObj.val() == '' || jQuery.inArray($.trim(thisObj.val()).toUpperCase(), duplicates) != -1) {
                            thisObj.val('');
                                } else {
                                 $('<li class="addedTag">' + thisObj.val() + '<span class="tagRemove" onclick="$(this).parent().remove();">x</span><input type="hidden" value="' + thisObj.val() + '" name="'+name+'[]"></li>').insertBefore('.'+tag_class+' .tagAdd');
                                 thisObj.val('');
                            }
            }


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
                cache: true, 
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

            var industries = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                cache: true, 
                prefetch:{
                    url: '/account/preferences/get-industry?q=com',
                },
                remote: {
                    url: '/account/preferences/get-industry?q=%QUERY',
                    wildcard: '%QUERY',
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
                if ($('#weekday-5').is(':not(:checked)')) {
                    $("#candidatepreferenceform-weekoptsat").val('');    
                }
                if ($('#weekday-6').is(':not(:checked)')) {
                    $("#candidatepreferenceform-weekoptsund").val('');    
                }
                
                var data = $(this).serialize();
                
                $.ajax({
                    url: "/account/preferences/index",
                    method: "POST",
                    data: data,
                    success: function (res) {
                        if($("#candidatepreferenceform-weekoptsat").val() == null){
                            $("#candidatepreferenceform-weekoptsat").val('Always');    
                        }
                        if($("#candidatepreferenceform-weekoptsund").val() == null){
                            $("#candidatepreferenceform-weekoptsund").val('Always');   
                        }
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
                if ($('#intern_weekday-5').is(':not(:checked)')) {
                    $("#intern_weekoptsat").val('');    
                }
                if ($('#intern_weekday-6').is(':not(:checked)')) {
                    $("#intern_weekoptsun").val('');    
                }
                var data = $(this).serialize();
                $.ajax({
                    url: "/account/preferences/index",
                    method: "POST",
                    data: data,
                    success: function (res) {
                        if($("#intern_weekoptsat").val() == null){
                            $("#intern_weekoptsat").val('Always');    
                        }
                        if($("#intern_weekoptsun").val() == null){
                            $("#intern_weekoptsun").val('Always');   
                        }
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
                                if ($('#weekday-5').is(':checked')) {
                                    $('.sat-hide').css('display', 'block');
                                } else if ($('#weekday-5').is(':not(:checked)')) {
                                    $('.sat-hide').css('display', 'none');
                                }
                                if ($('#weekday-6').is(':checked')) {
                                    $('.sun-hide').css('display', 'block');
                                } else if ($('#weekday-6').is(':not(:checked)')) {
                                    $('.sun-hide').css('display', 'none');
                                }
                            });
                            
                            if(data.sat_frequency == null){
                                $("#candidatepreferenceform-weekoptsat").val('Always');
                            }else{
                                $("#candidatepreferenceform-weekoptsat").val(data.sat_frequency);
                            }
                            if(data.sun_frequency == null){
                                $("#candidatepreferenceform-weekoptsund").val('Always');        
                            }else{
                                $("#candidatepreferenceform-weekoptsund").val(data.sun_frequency);
                            }
                            
                            $("#work_expierence").val(data.experience);
                            $("#candidatepreferenceform-job_type").val(data.type);
                            $("#from").val(data.timings_from);
                            $("#to").val(data.timings_to);
                            $("#from").val(tConv24($('#from').val()));
                            $("#to").val(tConv24($('#to').val()));
                            $("#candidatepreferenceform-from_salary").val(data.min_expected_salary);
                            $("#candidatepreferenceform-to_salary").val(data.max_expected_salary);
                            
                            var fivehun = (500/100)*data.min_expected_salary;
                            var thirtyper = (30/100)*data.min_expected_salary;
                            var min_val =  parseInt(data.min_expected_salary) - parseInt(thirtyper);
                            
                            var range = $("#range_3");
                            var rangee = range.data("ionRangeSlider");
                            rangee.update({
                                min: min_val,
                                max: fivehun,
                                from: data.min_expected_salary,
                                to: data.max_expected_salary,
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
                                if ($('#intern_weekday-5').is(':checked')) {
                                    $('.intern-sat-hide').css('display', 'block');
                
                                } else if ($('#intern_weekday-5').is(':not(:checked)')) {
                                    $('.intern-sat-hide').css('display', 'none');
                                }
                                if ($('#intern_weekday-6').is(':checked')) {
                                    $('.intern-sun-hide').css('display', 'block');
                                } else if ($('#intern_weekday-6').is(':not(:checked)')) {
                                    $('.intern-sun-hide').css('display', 'none');
                                }
                            });
                            
                            if(data.sat_frequency == null){
                                $("#intern_weekoptsat").val('Always');
                            }else{
                                $("#intern_weekoptsat").val(data.sat_frequency);
                            }
                            if(data.sun_frequency == null){
                                $("#intern_weekoptsun").val('Always');        
                            }else{
                                $("#intern_weekoptsun").val(data.sun_frequency);
                            }
                            
                            $("#internship_job_type").val(data.type);
                            $("#intern_from").val(data.timings_from);
                            $("#intern_to").val(data.timings_to);
                            $("#intern_from").val(tConv24($('#intern_from').val()));
                            $("#intern_to").val(tConv24($('#intern_to').val()));
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
            
            $('.sat-hide').css('display', 'none');
            $('.sun-hide').css('display', 'none');
            $('.intern-sat-hide').css('display', 'none');
            $('.intern-sun-hide').css('display', 'none');

            $(document).on('click', '#candidatepreferenceform-weekdays', function () {
                if ($('#weekday-5').is(':checked')) {
                    $('.sat-hide').css('display', 'block');
                } else if ($('#weekday-5').is(':not(:checked)')) {
                    $('.sat-hide').css('display', 'none');
                }
                if ($('#weekday-6').is(':checked')) {
                    $('.sun-hide').css('display', 'block');
                } else if ($('#weekday-6').is(':not(:checked)')) {
                    $('.sun-hide').css('display', 'none');
                }
            });
            
            $(document).on('click', '#intern_weekdays', function () {
                if ($('#intern_weekday-5').is(':checked')) {
                    $('.intern-sat-hide').css('display', 'block');

                } else if ($('#intern_weekday-5').is(':not(:checked)')) {
                    $('.intern-sat-hide').css('display', 'none');
                }
                if ($('#intern_weekday-6').is(':checked')) {
                    $('.intern-sun-hide').css('display', 'block');
                } else if ($('#intern_weekday-6').is(':not(:checked)')) {
                    $('.intern-sun-hide').css('display', 'none');
                }
            });
            
            function my_prettify (n) {
                return n.toLocaleString('en-IN');
            }
            
            //Jobs salary slider
            $("#range_3").ionRangeSlider({
                skin: "round",
                min: 0,
                max: 0,
                from: 0,
                to: 0,
                type: 'double',
                grid: true,
                grid_num: 5,
                step: 100,
                force_edges: true,
                prettify: my_prettify,
                prettify_separator:",",
                postfix: " Rs",
            });
            
            var range = $("#range_3");
            var raangee = range.data("ionRangeSlider");
            
            $(document).on('keyup','#candidatepreferenceform-from_salary',function(e)
            {
                if(e.which==13)
                    {
                        
                        $('#candidatepreferenceform-from_salary').unmask();
                        
                        if($(this).val() < 0 ){
                            $(this).val(0);
                        }
                       var s_from = $('#candidatepreferenceform-from_salary').prop('value');
                
                        var thirtyper = (30/100)*s_from;
                        var min_val =  parseInt(s_from) - parseInt(thirtyper);
                        thirtyper = parseInt(s_from) + parseInt(thirtyper);
                        var fivehun = (500/100)*s_from;
                        
                        raangee.update({
                            min: min_val,
                            max: fivehun,
                            from: s_from,
                            to: thirtyper,
                        });
                        
                        $('#candidatepreferenceform-to_salary, #candidatepreferenceform-from_salary').mask("#,#0,#00", {reverse: true});
                    }
            });
            
            $(document).on('keyup','#candidatepreferenceform-to_salary',function(e){
                if(e.which==13){
                    $('#candidatepreferenceform-to_salary,#candidatepreferenceform-from_salary').unmask();
                    
                    var s_to = $('#candidatepreferenceform-to_salary').prop('value'); 
                    var s_from = $('#candidatepreferenceform-from_salary').prop('value');
                    
                    if(s_from == null || s_from == 0){
                        $('#candidatepreferenceform-to_salary').val('0');
                    }
                    if(s_to > (500/100)*parseInt(s_from)){
                        $('#candidatepreferenceform-to_salary').val((500/100)*parseInt(s_from));
                    }
                    raangee.update({
                    to: s_to,
                });
                    
                    $('#candidatepreferenceform-to_salary, #candidatepreferenceform-from_salary').mask("#,#0,#00", {reverse: true});
                }
            });
            
            $("#candidatepreferenceform-to_salary").on("change",function() {
                $('#candidatepreferenceform-to_salary').unmask();
               var s_to = $('#candidatepreferenceform-to_salary').prop('value'); 
               var s_from = $('#candidatepreferenceform-from_salary').prop('value');
                    
               if(s_from == null || s_from == 0){
                    $('#candidatepreferenceform-to_salary').val('0');
               }
               if(s_to > (500/100)*s_from){
                   $('#candidatepreferenceform-to_salary').val((500/100)*s_from);
               }
               
               raangee.update({
                    to: s_to,
                });
               $('#candidatepreferenceform-to_salary, #candidatepreferenceform-from_salary').mask("#,#0,#00", {reverse: true});
            });
            
            $("#candidatepreferenceform-from_salary").on("change",function() {
                
                if($(this).val() < 0 ){
                    $(this).val(0);
                }
                
                if($(this).val() == ""){
                    $(this).val('0');
                }
                $('#candidatepreferenceform-from_salary').unmask();
                
                var s_from = $('#candidatepreferenceform-from_salary').prop('value');
                
                var thirtyper = (30/100)*s_from;
                var min_val =  parseInt(s_from) - parseInt(thirtyper);
                thirtyper = parseInt(s_from) + parseInt(thirtyper);
                var fivehun = (500/100)*s_from;
                
                raangee.update({
                    min: min_val,
                    max: fivehun,
                    from: s_from,
                    to: thirtyper,
                });
                
                $('#candidatepreferenceform-to_salary, #candidatepreferenceform-from_salary').mask("#,#0,#00", {reverse: true});
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
                var num = parseInt(value[0]);
                $('#candidatepreferenceform-from_salary').val(num.toLocaleString("en-IN"));
                var num2 = parseInt(value[1]);
                $('#candidatepreferenceform-to_salary').val(num2.toLocaleString("en-IN"));
            });
            
$('.field-range_3 div .irs-with-grid').addClass('irs-disabled');
var ps = new PerfectScrollbar('.select2-selection.select2-selection--multiple');
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css');
//$this->registerCssFile('@backendAssets/global/plugins/ion.rangeslider/css/ion.rangeSlider.css');
//$this->registerCssFile('@backendAssets/global/plugins/ion.rangeslider/css/ion.rangeSlider.skinFlat.css');
$this->registerCssFile('http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css');
//$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css');
$this->registerCssFile('//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
$this->registerCssFile('@eyAssets/materialized/materialize-tags/css/materialize-tags.css');
$this->registerJsFile('http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/materialized/materialize-tags/js/materialize-tags.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('@backendAssets/global/plugins/ion.rangeslider/js/ion.rangeSlider.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);