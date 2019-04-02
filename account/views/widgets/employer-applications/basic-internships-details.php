<?php
use kartik\widgets\TimePicker;
use kartik\widgets\DatePicker;
?>
<div class="row">
    <div class="col-md-4">
        <div class="select">
            <?= $form->field($model, 'primaryfield')->dropDownList($primary_cat, ['prompt' => 'Choose Internship Profile', 'disabled' => true])->label(false); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="cat_wrapper">
            <div class="load-suggestions Typeahead-spinner">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <?= $form->field($model, 'title')->textInput(['class' => 'capitalize form-control', 'placeholder' => 'Internship Title', 'id' => 'title', 'disabled' => true])->label(false) ?>
        </div>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'type')->dropDownList(['Full time' => 'Full time', 'Part Time' => 'Part time', 'Work From Home' => 'Work from home'])->label(false); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div id="radio_rules"></div>
        <label>Type Of Stipend</label>
        <div class="md-radio-inline">
            <?= $form->field($model, 'wage_type')->inline()->radioList([
                0 => 'Unpaid',
                3 => 'Performance Based',
                2 => 'Negotiable',
                1 => 'Fixed',
            ], [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $return = '<div class="md-radio">';
                    $return .= '<input type="radio" id="sti' . $index . $name . '" name="' . $name . '"  value="' . $value . '" data-title="' . $value . '" data-name = "' . $label . '"  class="md-radiobtn" ' . (($checked) ? 'checked' : '') . '>';
                    $return .= '<label for="sti' . $index . $name . '">';
                    $return .= '<span></span>';
                    $return .= '<span class="check"></span>';
                    $return .= '<span class="box"></span> ' . $label . ' </label>';
                    $return .= '</div>';
                    return $return;
                }
            ])->label(false); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div id="fixed_stip">
                <div class="col-md-8">
                    <?= $form->field($model, 'fixed_wage')->label('Stipend Paid') ?>
                </div>
            </div>
            <div id="min_max">
                <div class="col-md-4">
                    <?= $form->field($model, 'min_wage')->label('Min Stipend') ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'max_wage')->label('Max Stipend') ?>
                </div>
            </div>
            <div id="wage_duration">
                <div class="col-md-4">
                    <?=
                    $form->field($model, 'wage_duration')->dropDownList([
                        'Monthly' => 'Monthly',
                        'Weekly' => 'Weekly',
                    ])->label(false);
                    ?>
                </div>
            </div>
            <div class="salary_errors"></div>
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
                        'always' => 'Always',
                        'alternative' => 'Alternative',
                        'rearly' => 'Rearly'])->label(false);
                    ?>
                    <span class="sat">Sat</span>
                </div>
                <div class="sat-sun">
                    <?=
                    $form->field($model, 'weekoptsund')->dropDownList([
                        'always' => 'Always',
                        'alternative' => 'Alternative',
                        'rearly' => 'Rearly'])->label(false);
                    ?>
                    <span class="sun">Sun</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'from')->widget(TimePicker::classname(), ['pluginOptions' => ['defaultTime' => '9:00 AM']])->label('Internship Timing From');
        ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'to')->widget(TimePicker::classname(), ['pluginOptions' => ['defaultTime' => '5:00 PM']])->label('Upto');
        ?>
    </div>
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
</div>
<div class="row">
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
    <div class="col-md-3">
        <div id="pre_placement_err"></div>
        <label>Is there Any Pre Placement Offer?</label>
        <div class="md-radio-inline">
            <?= $form->field($model, 'pre_placement_offer')->inline()->radioList([
                1 => 'Yes',
                0 => 'No',
            ], [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $return = '<div class="md-radio">';
                    $return .= '<input type="radio" id="pre' . $index . $name . '" name="' . $name . '"  value="' . $value . '" data-title="' . $value . '" data-name = "' . $label . '"  class="md-radiobtn" ' . (($checked) ? 'checked' : '') . '>';
                    $return .= '<label for="pre' . $index . $name . '">';
                    $return .= '<span></span>';
                    $return .= '<span class="check"></span>';
                    $return .= '<span class="box"></span> ' . $label . ' </label>';
                    $return .= '</div>';
                    return $return;
                }
            ])->label(false); ?>
        </div>
    </div>
    <div class="col-md-3">
        <div id="pre_package">
            <?= $form->field($model, 'pre_placement_package')->label('Salary Package(Yearly)') ?>
        </div>
    </div>
</div>
<?php
$this->registerCss("
#pre_package{display:none;}
");
$script = <<< JS
$('#min_wage, #max_wage').mask("#,#0,#00", {reverse: true}); 
$('#fixed_wage, #pre_placement_package').mask("#,#0,#00", {reverse: true});
$('input[name= "pre_placement_offer"]').on('change',function(){
        var pre = $(this).attr("data-title");
        pre_placement(pre);
        });
function pre_placement(pre) {
   if(pre==1)
        {
         $('#pre_package').show();
        }
        else
        {
         $('#pre_package').hide();
        }
}
if (doc_type=='Clone_Internships') 
    {
        wage_types2('$model->wage_type');
        pre_placement('$model->pre_placement_offer');
    }
function wage_types2(stipendtyp)
{
    if(stipendtyp=='0')
        {
        $('#fixed_stip').hide();
        $('#min_max').hide();
        }
     else if(stipendtyp =='1')
        {
        $('#fixed_stip').show();
        $('#min_max').hide();
        }
     else if(stipendtyp=='3'||stipendtyp=='2')
        {
        $('#fixed_stip').hide();
        $('#min_max').show();
        }
}
$('input[name= "wage_type"]').on('change',function(){
        var stipendtyp = $(this).attr("data-title");
        wage_types(stipendtyp);
   });
function wage_types(stipendtyp)
{
    if(stipendtyp=='0')
        {
        $('#fixed_stip').hide();
        $('#min_max').hide();
        $('#min_wage').val('');
        $('#max_wage').val('');
        $('#fixed_wage').val('');
        }
     else if(stipendtyp =='1')
        {
        $('#fixed_stip').show();
        $('#min_max').hide();
        $('#min_wage').val('');
        $('#max_wage').val('');
        $('#fixed_wage').val('');
        }
     else if(stipendtyp=='3'||stipendtyp=='2')
        {
        $('#fixed_stip').hide();
        $('#min_max').show(); 
        $('#fixed_wage').val('');
        }
}
$(document).on('click','#weekdays input',function()
    {
     if ($('#weekday-5').is(':checked'))
        {
         $('.field-weekoptsat').css('display','block');
         $('.sat').css('display','block');
        
        }
     else if ($('#weekday-5').is(':unchecked'))
        {
          $('.field-weekoptsat').css('display','none');
          $('.sat').css('display','none');
        }
    if($('#weekday-6').is(':checked'))
        {
          $('.field-weekoptsund').css('display','block');
          $('.sun').css('display','block');
        }
        
     else if($('#weekday-6').is(':unchecked'))
        { 
          $('.field-weekoptsund').css('display','none');
          $('.sun').css('display','none');
        }
   });
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>