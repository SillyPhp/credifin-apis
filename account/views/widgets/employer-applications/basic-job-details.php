<?php
use kartik\widgets\TimePicker;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
?>
<div class="row">
    <div class="col-md-3">
        <div class="select">
            <?php if ($type == 'Edit_Jobs') {
                echo $form->field($model, 'mainfield')->dropDownList($primary_cat, ['prompt' => 'Choose Job Profile', 'disabled' => true])->label(false);
                echo $form->field($model, 'primaryfield', ['template' => '{input}', 'options' => []])->hiddenInput()->label(false);
            }
            else
            {
               echo $form->field($model, 'primaryfield')->dropDownList($primary_cat, ['prompt' => 'Choose Job Profile', 'disabled' => true])->label(false);
            }
             ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="cat_wrapper">
            <div class="load-suggestions Typeahead-spinner">
                <span></span>
                <span></span>
                <span></span>
            </div>
    <?php if ($type == 'Edit_Jobs') {
        echo $form->field($model, 'title')->textInput(['class' => 'capitalize form-control', 'placeholder' => 'Job Title', 'id' => 'title','readonly' => true])->label(false);
    } else {
        echo $form->field($model, 'title')->textInput(['class' => 'capitalize form-control', 'placeholder' => 'Job Title', 'id' => 'title','disabled' => true])->label(false);
    } ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="desig_wrapper">
            <div class="load-suggestions Typeahead-spinner">
                <span></span>
                <span></span>
                <span></span>
            </div>
    <?php if ($type == 'Edit_Jobs') {
        echo $form->field($model, 'designations')->textInput(['class' => 'capitalize form-control', 'id' => 'designations', 'placeholder' => 'Designation','readonly' => true])->label(false);
    } else {
        echo $form->field($model, 'designations')->textInput(['class' => 'capitalize form-control', 'id' => 'designations', 'placeholder' => 'Designation','disabled' => true])->label(false);
    }?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="row">
            <div class="col-md-12" id="wh_type">
                <?= $form->field($model, 'type')->dropDownList(['Full time' => 'Full time', 'Part Time' => 'Part time', 'Work From Home' => 'Work from home'])->label(false); ?>
            </div>
            <div id="wh_vacancy">
                <div class="col-md-5">
                    <?= $form->field($model, 'vacancy')->textInput(['class' => 'capitalize form-control', 'placeholder' => 'Positions', 'id' => 'wh_positions','maxLength'=>7])->label(false); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div id="radio_rules"></div>
        <label>Salary Type</label>
        <div class="md-radio-inline">
            <?= $form->field($model, 'wage_type')->inline()->radioList([
                1 => 'Fixed',
                2 => 'Negotiable',
            ], [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $return = '<div class="md-radio">';
                    $return .= '<input type="radio" id="sltype' . $index . $name . '" name="' . $name . '"  value="' . $value . '" data-title="' . $value . '" data-name = "' . $label . '"  class="md-radiobtn" ' . (($checked) ? 'checked' : '') . '>';
                    $return .= '<label for="sltype' . $index . $name . '">';
                    $return .= '<span></span>';
                    $return .= '<span class="check"></span>';
                    $return .= '<span class="box"></span> ' . $label . ' </label>';
                    $return .= '</div>';
                    return $return;
                }
            ])->label(false); ?>
        </div>
    </div>
    <div id="fixed_stip">
        <div class="col-md-3">
            <?= $form->field($model, 'fixed_wage')->textInput(['autocomplete' => 'off', 'maxlength' => '15'])->label('Salary'); ?>
        </div>
    </div>
    <div id="min_max">
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'min_wage')->label('Min(Opt)') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'max_wage')->label('Max(Opt)') ?>
                </div>
            </div>
            <div class="salary_errors"></div>
        </div>
    </div>
    <div class="col-md-3">
        <?=
        $form->field($model, 'wage_duration')->dropDownList([
            'Monthly' => 'Monthly',
            'weekly' => 'Weekly',
            'Hourly' => 'Hourly',
            'Annually' => 'Annually'])->label(false);
        ?>
    </div>
    <div class="col-md-3">
        <div id="addct">
            <a id="addctc"><span class="fa fa-plus"></span> Add Annual CTC</a>
        </div>
        <div id="ctc-main">
            <?= $form->field($model, 'ctc')->textInput(['autocomplete' => 'off', 'maxlength' => '15'])->label('CTC'); ?>
            <a class="close-ctc"><i class="fa fa-times"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="weekDays-selector">
            <?=
            $form->field($model, 'weekdays')->inline()->checkBoxList([
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
                    $form->field($model, 'weekoptsat')->dropDownList([
                        'Always' => 'Always',
                        'Alternative' => 'Alternative',
                        'Rearly' => 'Rearly'])->label(false);
                    ?>
                    <span class="sat">Sat</span>
                </div>
                <div class="sat-sun">
                    <?=
                    $form->field($model, 'weekoptsund')->dropDownList([
                        'Always' => 'Always',
                        'Alternative' => 'Alternative',
                        'Rearly' => 'Rearly'])->label(false);
                    ?>
                    <span class="sun">Sun</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'from')->widget(TimePicker::classname(), ['pluginOptions' => ['defaultTime' => '9:00 AM']])->label('Job Timing From');
        ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'to')->widget(TimePicker::classname(), ['pluginOptions' => ['defaultTime' => '5:00 PM']])->label('Upto');
        ?>
    </div>
    <div class="col-md-3">
        <?php
        if ($type=='Edit_Jobs')
        {
            echo $form->field($model, 'pref_indus')->dropDownList($industry, ['prompt' => 'Preferred industry','disabled' => true])->label(false);
            echo $form->field($model, 'industry',['template' => '{input}', 'options' => []])->hiddenInput()->label(false);
        }
        else
            {
//              echo $form->field($model, 'industry')->dropDownList($industry, ['prompt' => 'Preferred industry','disabled' => true])->label(false);
            echo $form->field($model, 'industry')->widget(Select2::classname(), [
                'name' => 'kv-state-210',
                'data' => $industry,
                'size' => Select2::MEDIUM,
                'options' => ['placeholder' => 'Preferred Industry', 'multiple' => false,],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false);
        }
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div id="gender_pref">
            <div class="radio-group">
                <?php $model->gender = [0]; ?>
                <?=
                $form->field($model, 'gender')->inline()->radioList([
                    0 => 'No Pref',
                    1 => 'Male',
                    2 => 'Female',
                    3 => 'Trans',
                ], [
                    'item' => function ($index, $label, $name, $checked, $value) {

                        $return .= '<input type="radio" id="gender' . $index . '" name="' . $name . '" value="' . $value . '" class="gender_radio" ' . (($checked) ? 'checked' : '') . '>';
                        $return .= '<label class="gender_label" for="gender' . $index . '">' . $label . '</label>';

                        return $return;
                    }
                ])->label(false);
                ?>
            </div>
            <label class="g-pref">Gender Preference</label>
        </div>
    </div>
    <div class="col-md-2">
        <?= $form->field($model,'minimum_exp')->dropDownList($exp, [
            'prompt' => 'Min Experience',
            'id'=>'min_exp_details',
            'onchange' => '$("#max_exp_details").empty().append($("<option>", { 
                                        value: "",
                                        text : "Max Experience" 
                                    }));   
                                    var _curIndex = $(this).val();
                                    var experience = '.json_encode($exp).'; 
                                    var _totalLentgh = Object.keys(experience).length;
                                    if(_curIndex!=""||_curIndex!=null){ 
                                    $.each(experience, function (index,value) {
                                      if(index==_curIndex){
                                        return false;
                                      }
                                      else
                                      {
                                      delete experience[index];
                                      }
                                    }); 
                                    delete experience[_curIndex];
                                    var id = "max_exp_details";
                                    var selectbox = $(\'#\' + id + \'\');
                                    $.each(experience, function (index,value) {
                                      selectbox.append($(\'<option>\', {
                                          value: index,
                                          text: value
                                         }));
                                    }); 
                                    } 
                                    ',
        ])->label(false); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model,'maximum_exp')->dropDownList([], [
            'prompt' => 'Max Experience',
            'id' => 'max_exp_details',
        ])->label(false); ?>
    </div>
    <div class="col-md-5">
        <div class="row">
            <div class="col-md-6">
                <?=
                $form->field($model, 'last_date')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Last Date'],
                    'readonly' => true,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-M-yyyy',
                        'name' => 'earliestjoiningdate',
                        'todayHighlight' => true,
                        'startDate' => '+0d',
                    ]])->label(false);
                ?>
            </div>
            <div class="col-md-6">
                <?=
                $form->field($model, 'earliestjoiningdate')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Joining Date'],
                    'readonly' => true,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-M-yyyy',
                        'name' => 'earliestjoiningdate',
                        'todayHighlight' => true,
                        'startDate' => '+0d',
                    ]])->label(false);
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
 $('#addctc').on('click',function(){
    $('#addct').hide();
    $('#ctc-main').show();     
}); 
$('.close-ctc').on('click',function(){
    $('#ctc-main').hide();
    $('#addct').show();
}); 
$('input[name= "wage_type"]').on('change',function(){
   var sl_type = $(this).attr("data-title");
     wage_type(sl_type);
   })    
if (doc_type=='Clone_Jobs'||doc_type=='Edit_Jobs') 
    {
        wage_type2('$model->wage_type');
    }
function wage_type2(sl_type) {
  if(sl_type=='1')
        {
        $('#fixed_stip').show();
        $('#min_max').hide();
        }
     
     else if(sl_type=='2')
        {
        $('#fixed_stip').hide();
        $('#min_max').show();
        }
}    
function wage_type(sl_type)
{
    if(sl_type=='1')
        {
        $('#fixed_stip').show();
        $('#min_max').hide();
        $('#min_wage').val('');
        $('#max_wage').val('');
        $('#fixed_wage').val('');
        }
     
     else if(sl_type=='2')
        {
        $('#fixed_stip').hide();
        $('#min_max').show();
        $('#min_wage').val('');
        $('#max_wage').val('');
        $('#fixed_wage').val('');
        }
}
 var designations = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('designation'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: '/account/categories-list/designations?q=%QUERY',
    wildcard: '%QUERY',
    cache: true,     
        filter: function(list) {
            return list;
        }
  }
});
$('#fixed_wage, #ctc').mask("#,#0,#00", {reverse: true});
$('#max_wage, #min_wage').mask("#,#0,#00", {reverse: true});
$('#wh_positions').mask("#", {reverse: true});   
$('#designations').typeahead(null, {
  name: 'designations_test',
  display: 'designation',
   limit: 20,      
  source: designations
}).on('typeahead:asyncrequest', function() {
    $('.desig_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    $('.desig_wrapper .Typeahead-spinner').hide();
  });
if (doc_type=='Clone_Jobs'||doc_type=='Edit_Jobs') {
    var exp_id = "max_exp_details";
    var experience = _experience; 
    _setExperience('$model->minimum_exp',exp_id,_experience); 
}
function _setExperience(e,exp_id,experience) {
    if(e!=""||e!=null){ 
        $.each(experience, function (index,value) {
    if(index==e){
     return false;
    }
    else
    {
    delete experience[index];
    }
    }); 
    delete experience[e];
    var selectbox = $('#' + exp_id + '');
    $.each(experience, function (index,value) {
    selectbox.append($('<option>', {
    value: index,
    text: value
    }));
    }); 
    selectbox.val('$model->maximum_exp');
    }
  }
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>