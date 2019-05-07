<?php
use kartik\widgets\TimePicker;
use kartik\widgets\DatePicker;
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
        <?= $form->field($model, 'type')->dropDownList(['Full time' => 'Full time', 'Part Time' => 'Part time', 'Work From Home' => 'Work from home'])->label(false); ?>
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
              echo $form->field($model, 'industry')->dropDownList($industry, ['prompt' => 'Preferred industry','disabled' => true])->label(false);
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
            <label>Gender Preference</label>
        </div>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'min_exp')->dropDownList([
            '0' => 'No Experience',
            '1' => 'Less Than 1',
            '2' => '1 Year',
            '3' => '2-3 Years',
            '3-5' => '3-5 Years',
            '5-10' => '5-10 Years',
            '10-20' => '10-20 Years',
            '20+' => 'More Than 20 Years',
        ], [
            'prompt' => 'Experience Required',
        ])->label(false); ?>
    </div>
    <div class="col-md-3">
        <?=
        $form->field($model, 'last_date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Last Date To Apply'],
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
    <div class="col-md-3">
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
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>