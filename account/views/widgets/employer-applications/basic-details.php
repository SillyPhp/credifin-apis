<?php
use kartik\widgets\TimePicker;
use kartik\widgets\DatePicker;
?>
<div class="row">
    <div class="col-md-3">
        <div class="select">
            <?= $form->field($model, 'primaryfield')->dropDownList($primary_cat, ['prompt' => 'Choose Job Category', 'disabled' => true])->label(false); ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="cat_wrapper">
            <div class="load-suggestions Typeahead-spinner">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <?= $form->field($model, 'jobtitle')->textInput(['class' => 'capitalize form-control', 'placeholder' => 'Job Title', 'id' => 'jobtitle', 'disabled' => true])->label(false) ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="desig_wrapper">
            <div class="load-suggestions Typeahead-spinner">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <?= $form->field($model, 'designations')->textInput(['class' => 'capitalize form-control', 'id' => 'designations', 'placeholder' => 'Designation'])->label(false); ?>
        </div>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'jobtype')->dropDownList(['Full time' => 'Full time', 'Part Time' => 'Part time', 'Work From Home' => 'Work from home'])->label(false); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div id="radio_rules"></div>
        <label>Salary Type</label>
        <div class="md-radio-inline">
            <?= $form->field($model, 'salary_type')->inline()->radioList([
                1 => 'Fixed',
                2 => 'Negotiable',
            ], [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $return = '<div class="md-radio">';
                    $return .= '<input type="radio" id="sltype' . $index . $name . '" name="' . $name . '"  value="' . $value . '" data-title="' . $value . '" data-name = "' . $label . '"  class="md-radiobtn">';
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
            <?= $form->field($model, 'salaryinhand')->textInput(['autocomplete' => 'off', 'maxlength' => '15'])->label('Salary'); ?>
        </div>
    </div>
    <div id="min_max">
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'min_salary')->label('Min(Opt)') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'max_salary')->label('Max(Opt)') ?>
                </div>
            </div>
            <div class="salary_errors"></div>
        </div>
    </div>
    <div class="col-md-3">
        <?=
        $form->field($model, 'ctctype')->dropDownList([
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
            <?php $model->weekdays = [1, 2, 3, 4, 5]; ?>

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
        <?= $form->field($model, 'from')->widget(TimePicker::classname(), ['pluginOptions' => ['defaultTime' => '9:00 AM']])->label('Job Timing From');
        ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'to')->widget(TimePicker::classname(), ['pluginOptions' => ['defaultTime' => '5:00 PM']])->label('Upto');
        ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'pref_inds')->dropDownList($industry, ['prompt' => 'Preferred industry'])->label(false); ?>
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