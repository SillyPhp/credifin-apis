<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Html;
use kartik\widgets\TimePicker;

$industry = Json::encode($industries);
$skill = Json::encode($skills);
$primary_cat = ArrayHelper::map($primaryfields, 'category_enc_id', 'name');
?>
    <div class="container">
        <div class="col-md-12">
            <div class="portlet light" id="form_wizard_1">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-red"></i>
                        <span class="caption-subject font-red bold uppercase">Candidate
                        <span class="step-title"> Preferences</span>
                    </span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <button id="test">test</button>
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'submit_form',
                        'enableClientValidation' => true,
                        'validateOnBlur' => false,
                        'fieldConfig' => [
                            'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}</div>",
                        ]
                    ]);
                    ?>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($applicationpreferenceformModel, 'job_category', ['template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}</div>"])->dropDownList($primary_cat, ['prompt' => 'Choose Job Profile', 'disabled' => false, 'id' => job_category])->label(false); ?>

                        </div>
                        <div class="col-md-4">
                            <?= $form->field($applicationpreferenceformModel, 'work_expierence', ['template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}</div>"])->dropDownList(['0' => 'No Experience', '1' => 'Less Than 1', '2' => '1 year', '3' => '2-3 years', '3-5' => '3-5 years', '5-10' => '5-10 years', '10+' => '10+ years'], ['prompt' => 'Relevant Experience', 'id' => 'work_expierence'])->label(false); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($applicationpreferenceformModel, 'jobtype')->dropDownList(['Full time' => 'Full time', 'Part Time' => 'Part time', 'Work From Home' => 'Work from home', 'id' => 'job_type'])->label(false); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <?=
                            $form->field($applicationpreferenceformModel, 'from_salary', ['template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}</div>"])->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Salary From')])->label(false);
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?=
                            $form->field($applicationpreferenceformModel, 'to_salary', ['template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}</div>"])->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Salary To')])->label(false);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                            $form->field($applicationpreferenceformModel, 'salary_range', ['template' => "<div class='form-group'>{input}{label}{hint}</div>"])->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Minimum Monthly Salary'), 'id' => 'range_3'])->label(false);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($applicationpreferenceformModel, 'keyskills', ['template' => "<div class='row'><div class='col-md-12'><div class='form-group'>{input}<div class='Typeahead-spinner-main'><i class='Typeahead-spinner fa fa-circle-o-notch fa-spin fa-fw close material-icons'></i></div>{label}{hint}</div></div></div>"])->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Skills'), 'id' => 'skill_data'])->label(false); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=
                            $form->field($applicationpreferenceformModel, 'location', ['template' => "<div class='row'><div class='col-md-12'><div class='form-group'>{input}<div class='Typeahead-spinner-main'><i class='Typeahead-spinner fa fa-circle-o-notch fa-spin fa-fw'></i></div>{label}{hint}</div></div></div>"])->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('City'), 'id' => 'city_data'])->label(false);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($applicationpreferenceformModel, 'industry', ['template' => "<div class='row'><div class='col-md-12'><div class='form-group'>{input}<div class='Typeahead-spinner-main'><i class='Typeahead-spinner fa fa-circle-o-notch fa-spin fa-fw close material-icons'></i></div>{label}{hint}</div></div></div>"])->textInput(['autocomplete' => 'off', 'placeholder' => $applicationpreferenceformModel->getAttributeLabel('Industry'), 'id' => 'industry_data'])->label(false); ?>
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
                                                'always' => 'Always',
                                                'alternative' => 'Alternative',
                                                'rearly' => 'Rearly',
                                                ['options' => ['id' => 'sat']]
                                            ])->label(false);
                                            ?>
                                            <span class="sat">Sat</span>
                                        </div>
                                        <div class="sat-sun">
                                            <?=
                                            $form->field($applicationpreferenceformModel, 'weekoptsund')->dropDownList([
                                                'always' => 'Always',
                                                'alternative' => 'Alternative',
                                                'rearly' => 'Rearly',
                                                ['options' => ['id' => 'sun']]
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
                        <?= Html::submitbutton('Search', ['class' => 'btn btn-primary btn-circle sav_loc']); ?>
                        <?php ActiveForm::end(); ?>
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
    display:none;
    clear: both;
    float: left;
    width: 100%;
}
.sun{
    display:none;
    clear: both;
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
    margin-top: 3px;
}
input[type=text]:not(.browser-default){
    margin: 0px;
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

            var city_name = $('#city_data');
            city_name.materialtags({
                itemValue: 'id',
                itemText: 'text',
                typeaheadjs: {
                    name: 'city',
                    displayKey: 'text',
                    source: city.ttAdapter()
                }
            });
            $(document).on('submit', '#submit_form', function (event) {
                event.preventDefault();
                str_val();
                console.log();
                var data = $(this).serialize();
             
                $.ajax({
                    url: "/account/candidatepreference",
                    method: "POST",
                    data: data,
                    success: function (response) {}
                });
            });

            function init() {

                $.ajax({
                    url: "/account/preferences",
                    method: "POST",
                    dataType: "json ",
                    success: function (response) {
//                  var data = response[0];
                        console.log(2);
                        for (i = 0; i < response[0].userPreferredLocations.length; i++)
                        {

                            $('#city_data').materialtags('add', {"id": response[0].userPreferredLocations[i].city_enc_id, "text": response[0].userPreferredLocations[i].name});
                        }

                        for (i = 0; i < response[0].userPreferredSkills.length; i++)
                        {
                            $('#skill_data').materialtags('add', {"id": response[0].userPreferredSkills[i].skill_enc_id, "text": response[0].userPreferredSkills[i].skill});
                        }

                        for (i = 0; i < response[0].userPreferredIndustries.length; i++)
                        {
                            $('#industry_data').materialtags('add', {"id": response[0].userPreferredIndustries[i].industry_enc_id, "text": response[0].userPreferredIndustries[i].industry});
                        }
                        $("#monthly_salary").val(data.salary);
                        $("#job_category").val(data.job_profile);
                        $("#work_expierence").val(data.experience);
                        $("#job_type").val(data.type);
                        $("#week_days").val(data.working_days);
                        $("#sat").val(data.sat_frequency);
                        $("#sun").val(data.sun_frequency);
                        $("#from").val(data.timings_from);
                        $("#to").val(data.timings_to);
                        $("#from").val(tConv24($('#from').val()));
                        $("#to").val(tConv24($('#to').val()));
//                    $("#salary_from").val(irs-from);                     
                    }
                });
            }
            init();

            function str_val() {
                var data1 = JSON.stringify($('#city_data').materialtags('items'));
                console.log(data1);
                var data2 = JSON.stringify($('#industry_data').materialtags('items'));
                var data3 = JSON.stringify($('#skill_data').materialtags('items'));
                $('#city_data').val(data1);
                $('#industry_data').val(data2);
                $('#skill_data').val(data3);
            }

            var skill = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '',
                remote: {
                    url: '/account/skills?q=%QUERY',
                    wildcard: '%QUERY'
                }
            });
            skill.initialize();

            var skill_name = $('#skill_data');
            skill_name.materialtags({
                itemValue: 'id',
                itemText: 'text',
                typeaheadjs: {
                    name: 'skill',
                    displayKey: 'text',
                    source: skill
                }
            });

            var industries = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '/account/industries'
            });
            industries.initialize();

            var industry_name = $('#industry_data');
            industry_name.materialtags({
                itemValue: 'id',
                itemText: 'text',
                typeaheadjs: {
                    name: 'industries',
                    displayKey: 'text',
                    source: industries
                }
            });

            $('#expected_salary').mask("#,##,##,##,###", {
                reverse: true
            });

            $(document).on('click', '#applicationpreferenceform-weekdays input', function () {
                if ($('#weekday-5').is(':checked')) {
                    $('.field-applicationpreferenceform-weekoptsat').css('display', 'block');
                    $('.sat').css('display', 'block');

                } else if ($('#weekday-5').is(':not(:checked)')) {
                    $('.field-applicationpreferenceform-weekoptsat').css('display', 'none');
                    $('.sat').css('display', 'none');
                }
                if ($('#weekday-6').is(':checked')) {
                    $('.field-applicationpreferenceform-weekoptsund').css('display', 'block');
                    $('.sun').css('display', 'block');
                } else if ($('#weekday-6').is(':not(:checked)')) {
                    $('.field-applicationpreferenceform-weekoptsund').css('display', 'none');
                    $('.sun').css('display', 'none');
                }
            });

            $("#range_3").ionRangeSlider({
                min: 5000,
                max: 1000000,
                from: 40000,
                to: 70000,
                type: 'double',
                //    prefix: "$",
                grid: true,
                grid_num: 5
            });

            var range = $("#range_3");

            range.ionRangeSlider({
                type: "double",
                min: 0,
                max: 100,
                from: 20,
                to: 80
            });

            range.on("change", function () {
                var value = $(this).prop("value").split(";");
                $('#applicationpreferenceform-from_salary').val(value[0]);
                $('#applicationpreferenceform-to_salary').val(value[1]);
            });
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerCssFile('@backendAssets/global/plugins/ion.rangeslider/css/ion.rangeSlider.css');
$this->registerCssFile('@backendAssets/global/plugins/ion.rangeslider/css/ion.rangeSlider.skinFlat.css');
$this->registerCssFile('http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css');
$this->registerCssFile('//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
$this->registerCssFile('@eyAssets/materialized/materialize-tags/css/materialize-tags.css');
$this->registerJsFile('http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/materialized/materialize-tags/js/materialize-tags.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/ion.rangeslider/js/ion.rangeSlider.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
