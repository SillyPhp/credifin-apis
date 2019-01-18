<?php

use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use dosamigos\ckeditor\CKEditor;

$primary_cat = ArrayHelper::map($primaryfields, 'category_enc_id', 'name');
$industry = ArrayHelper::map($industries, 'industry_enc_id', 'industry');
$process = ArrayHelper::map($process_list, 'interview_process_enc_id', 'process_name');
$benefits = ArrayHelper::map($benefit, 'benefit_enc_id', 'benefit');
$loc_list = ArrayHelper::index($location_list, 'location_enc_id');
$int_list = ArrayHelper::index($inter_loc, 'location_enc_id');
$que = ArrayHelper::map($questions_list, 'questionnaire_enc_id', 'questionnaire_name');

?>

    <div class="modal fade bs-modal-lg in" id="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>"
                         alt="<?= Yii::t('account', 'Loading'); ?>" class="loading">
                    <span> &nbsp;&nbsp;<?= Yii::t('account', 'Loading'); ?>... </span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="portlet light" id="form_wizard_1">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-layers font-red"></i>
                    <span class="caption-subject font-red bold uppercase">Internship Application
                    <span class="step-title"> Step 1 of 4</span>
                </span>
                </div>
            </div>
            <div class="portlet-body form">
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
                <div class="form-wizard">
                    <div class="form-body">
                        <ul class="nav nav-pills nav-justified steps">
                            <li>
                                <a href="#tab1" data-toggle="tab" class="step">
                                    <span class="number"> 1 </span><br/>
                                    <span class="desc">
                                    <i class="fa fa-check"></i> Basic Information </span>
                                </a>
                            </li>
                            <li>
                                <a href="#tab2" data-toggle="tab" class="step">
                                    <span class="number"> 2 </span><br/>
                                    <span class="desc">
                                    <i class="fa fa-check"></i> Internship Description </span>
                                </a>
                            </li>
                            <li>
                                <a href="#tab3" data-toggle="tab" class="step">
                                    <span class="number"> 3 </span><br/>
                                    <span class="desc">
                                    <i class="fa fa-check"></i> Interview Process  </span>
                                </a>
                            </li>
                            <li>
                                <a href="#tab4" data-toggle="tab" class="step">
                                    <span class="number"> 4 </span><br/>
                                    <span class="desc">
                                    <i class="fa fa-check"></i> Interview Details  </span>
                                </a>
                            </li>
                            <li class="step5">
                                <a href="#tab5" data-toggle="tab" class="step">
                                    <span class="number"> 5 </span><br/>
                                    <span class="desc">
                                    <i class="fa fa-check"></i> Confirmation </span>

                                </a>
                            </li>
                        </ul>
                        <div id="bar" class="progress progress-striped" role="progressbar">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="select">
                                            <?= $form->field($model, 'primaryfield')->dropDownList($primary_cat, ['prompt' => 'Choose Internship Category', 'disabled' => true])->label(false); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="cat_wrapper">
                                            <i class="Typeahead-spinner fa fa-circle-o-notch fa-spin fa-fw"></i>
                                            <?= $form->field($model, 'jobtitle')->textInput(['class' => 'lowercase form-control', 'placeholder' => 'Internship Title', 'id' => 'jobtitle', 'disabled' => true])->label(false) ?>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'jobtype')->dropDownList(['Full time' => 'Full time', 'Part Time' => 'Part time', 'Work From Home' => 'Work from home'])->label(false); ?>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="radio_rules"></div>
                                        <label>Type Of Stipend</label>
                                        <div class="md-radio-inline">
                                            <?= $form->field($model, 'stipendtype')->inline()->radioList([
                                                1 => 'Unpaid',
                                                2 => 'Performance Based',
                                                3 => 'Negotiable',
                                                4 => 'Fixed',
                                            ], [
                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                    $return = '<div class="md-radio">';
                                                    $return .= '<input type="radio" id="sti' . $index . $name . '" name="' . $name . '"  value="' . $value . '" data-title="' . $value . '"  class="md-radiobtn">';
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
                                                    <?= $form->field($model, 'stipendpaid')->label('Stipend Paid') ?>
                                                </div>
                                            </div>
                                            <div id="min_max">
                                                <div class="col-md-4">
                                                    <?= $form->field($model, 'minstip')->label('Min Stipend') ?>
                                                </div>
                                                <div class="col-md-4">
                                                    <?= $form->field($model, 'maxstip')->label('Max Stipend') ?>
                                                </div>
                                            </div>
                                            <div id="stipend_paid">
                                                <div class="col-md-4">
                                                    <?=
                                                    $form->field($model, 'stipendur')->dropDownList([
                                                        'monthly' => 'Monthly',
                                                        'weekly' => 'Weekly',
                                                    ])->label(false);
                                                    ?>
                                                </div>
                                            </div>
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
                                            <?= $form->field($model, 'pre_place')->inline()->radioList([
                                                1 => 'Yes',
                                                2 => 'No',
                                            ], [
                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                    $return = '<div class="md-radio">';
                                                    $return .= '<input type="radio" id="pre' . $index . $name . '" name="' . $name . '"  value="' . $value . '" data-title="' . $value . '"  class="md-radiobtn">';
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
                                            <?= $form->field($model, 'pre_sal')->label('Salary Package(Yearly)') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider">
                                    <span></span>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="module2-heading">Select Placement Locations</div>

                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'placement_loc', ['template' => '{input}'])->hiddenInput(['id' => 'placement_array'])->label(false); ?>
                                        <span id="place_error"></span>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="button_location">
                                            <?= Html::button('Add New Location', ['value' => URL::to('/account/locations/create'), 'data-key' => '3', 'class' => 'btn modal-load-class custom-buttons2 btn-primary custom_color-set2']); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                Pjax::begin(['id' => 'pjax_locations1']);
                                if (!empty($loc_list)) {
                                    ?>
                                    <?=
                                    $form->field($model, 'placement_locations')->checkBoxList($loc_list, [
                                        'item' => function ($index, $label, $name, $checked, $value) {

                                            if ($index % 3 == 0) {
                                                $return .= '<div class="row">';
                                            }
                                            $return .= '<div class="col-md-4">';
                                            $return .= '<input type="checkbox" name="' . $name . '" id="' . $value . '" data-value="' . $label['city_name'] . '" class="checkbox-input" data-count = "" ' . (($checked) ? 'checked' : '') . '>';
                                            $return .= '<label for="' . $value . '" class="checkbox-label">';
                                            $return .= '<div class="checkbox-text">';
                                            $return .= '<p class="loc_name_tag">' . $label['location_name'] . '</p>';
                                            $return .= '<span class="address_tag">' . $label['address'] . '</span> <br>';
                                            $return .= '<span class="state_city_tag">' . $label['city_name'] . ", " . $label['state_name'] . '</span>';
                                            $return .= '<div class="form-group">';
                                            $return .= '<div class="input-group spinner">';
                                            $return .= '<input type="text" class="form-control place_no" value="1">';
                                            $return .= '<div class="input-group-btn-vertical">';
                                            $return .= '<button class="btn btn-default up_bt" type="button"><i class="fa fa-caret-up"></i></button>';
                                            $return .= '<button class="btn btn-default down_bt" type="button"><i class="fa fa-caret-down"></i></button>';
                                            $return .= '</div>';
                                            $return .= '</div>';
                                            $return .= '</div>';
                                            $return .= '<div class="tooltips">';
                                            $return .= 'Enter No. of Positions.';
                                            $return .= '</div>';
                                            $return .= '</div>';
                                            $return .= '</label>';
                                            $return .= '</div>';
                                            if ($index % 3 == 2 || isset($label['total'])) {
                                                $return .= '</div>';
                                            }
                                            return $return;
                                        }
                                    ])->label(false);
                                    ?>

                                <?php } else { ?>
                                    <div class="empty-section-text">No Placement Location has been found</div>
                                <?php }
                                Pjax::end(); ?>
                                <input type="text" name="placement_calc" id="placement_calc" readonly>
                            </div>

                            <div class="tab-pane" id="tab2">

                                <div class="module2-heading">Provide job description</div>

                                <div class="row padd-10">
                                    <div class="col-md-6">
                                        <div id="manual_questions">
                                            <div class="descrip_wrapper">
                                                <i class="Typeahead-spinner fa fa-circle-o-notch fa-spin fa-fw"></i>
                                                <input type="text" class="form-control" maxlength="150"
                                                       id="question_field"
                                                       placeholder="Type Custom Job Description And Press Enter.">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="manual_notes">
                                            Select from predefined job descriptions list
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div id="checkboxlistarea">
                                            <h3 id="heading_placeholder"> Please type Atleast 3 Job Description above or
                                                select from predefined list <i class="fa fa-share"
                                                                               aria-hidden="true"></i></h3>
                                            <ul class="drop-options connected-sortable droppable-area">

                                            </ul>
                                        </div>

                                    </div>
                                    <div class="col-md-6">

                                        <div class="md-checkbox-list" id="md-checkbox">

                                        </div>
                                        <div id="error-checkbox-msg"></div>
                                        <?= $form->field($model, 'checkboxArray', ['template' => '{input}'])->hiddenInput(['id' => 'checkbox_array']); ?>

                                    </div>
                                </div>

                                <div class="divider"></div>

                                <div class="module2-heading">Educational Requirements</div>

                                <div class="row padd-10">
                                    <div class="col-md-6">
                                        <div id="manual_questions">
                                            <div class="edu_wrapper">
                                                <i class="Typeahead-spinner fa fa-circle-o-notch fa-spin fa-fw"></i>
                                                <input type="text" class="form-control" maxlength="150" id="quali_field"
                                                       placeholder="Type custom educational requirements and press enter.">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="manual_notes">
                                            Select from predefined educational requirement list
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div id="quali_listarea">
                                            <h3 id="heading_quali"> Please type the educational requirements above or
                                                select from predefined list <i class="fa fa-share"></i></h3>
                                            <ul class="quali_drop_options connected-sortable droppable-area">

                                            </ul>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="md-checkbox" id="quali_list">

                                        </div>
                                        <div id="error-edu-msg"></div>
                                        <?= $form->field($model, 'qualifications_arr', ['template' => '{input}'])->hiddenInput(['id' => 'qaulific_array']); ?>
                                    </div>
                                </div>

                                <div class="divider"></div>

                                <div class="module2-heading">Skills Required</div>

                                <div class="row padd-10">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="skill_wrapper">
                                                    <i class="Typeahead-spinner fa fa-circle-o-notch fa-spin fa-fw"></i>
                                                    <input type="text" id="inputfield" name="inputfield"
                                                           class="form-control"
                                                           placeholder="Type required skills and press enter.">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="placeble-area">
                                                    <div id="shownlist">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="manual_notes">
                                                    Select from predefined skills list
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div id="suggestionbox">
                                            </div>
                                            <?= $form->field($model, 'specialskillsrequired', ['template' => '{input}'])->hiddenInput(['id' => 'specialskillsrequired'])->label(false); ?>
                                            <?= $form->field($model, 'skillsArray', ['template' => '{input}'])->hiddenInput(['id' => 'skillsArray'])->label(false); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="row">
                                    <div id="select_benefit_err"></div>
                                    <div class="col-lg-6">
                                        <div class="module2-heading">
                                            Employee Benefits
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="md-radio-inline text-right clearfix">
                                            <?=
                                            $form->field($model, 'benefit_selection')->inline()->radioList([
                                                1 => 'Add Internship Benefits',
                                                0 => 'Skip Benefits',
                                            ], [
                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                    $return = '<div class="md-radio">';
                                                    $return .= '<input type="radio" id="ben' . $index . '" name="' . $name . '" value="' . $value . '" class="md-radiobtn">';
                                                    $return .= '<label for="ben' . $index . '">';
                                                    $return .= '<span></span>';
                                                    $return .= '<span class="check"></span>';
                                                    $return .= '<span class="box"></span> ' . $label . ' </label>';
                                                    $return .= '</div>';
                                                    return $return;
                                                }
                                            ])->label(false);
                                            ?>
                                        </div>
                                        <div class="button_location pull-right clearfix">
                                            <?= Html::button('Add New', ['value' => URL::to('/account/employee-benefits/create'), 'id' => 'benefitPopup', 'class' => 'btn btn-primary custom-buttons2 custom_color-set2 modal-load-class']); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div id="benefits_hide">
                                    <div id="b_error"></div>
                                    <?php
                                    Pjax::begin(['id' => 'pjax_benefits']);
                                    if (!empty($benefits)) {
                                        ?>
                                        <div class="cat-sec">
                                            <div class="row no-gape">
                                                <?=
                                                $form->field($model, 'emp_benefit')->checkBoxList($benefits, [
                                                    'item' => function ($index, $label, $name, $checked, $value) {
                                                        $return .= '<div class="col-lg-3 col-md-3 col-sm-6 p-category-main">';
                                                        $return .= '<div class="p-category">';
                                                        $return .= '<input type="checkbox" id="' . $value . '" name="' . $name . '" value="' . $value . '" class="checkbox-input" ' . (($checked) ? 'checked' : '') . '>';
                                                        $return .= '<label for="' . $value . '" class="checkbox-label-v2">';
                                                        $return .= '<div class="checkbox-text">';
                                                        $return .= '<span class="checkbox-text--title">';
                                                        $return .= '<i class="fa fa-user"></i>';
                                                        $return .= '</span><br/>';
                                                        $return .= '<span class="checkbox-text--description2">';
                                                        $return .= $label;
                                                        $return .= '</span>';
                                                        $return .= '</div>';
                                                        $return .= '</label>';
                                                        $return .= '</div>';
                                                        $return .= '</div>';
                                                        return $return;
                                                    }
                                                ])->label(false);
                                                ?>
                                            </div>
                                        </div>
                                    <?php } else { ?>

                                        <div class="empty-section-text"> No Benefits Yet Added to display</div>

                                    <?php } ?>
                                    <?php Pjax::end() ?>
                                    <input type="text" name="benefit_calc" id="benefit_calc" readonly>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="module2-heading">
                                            Additional Information
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <?= $form->field($model, 'othrdetail')->widget(CKEditor::className(), [
                                            'options' => ['rows' => 6],
                                            'preset' => 'custom',
                                            'clientOptions' => [
                                                'toolbar' => [
                                                    [
                                                        'name' => 'row1',
                                                        'items' => [
                                                            'Undo', 'Redo', '-',
                                                            'Cut', 'Copy', 'Paste', '-',
                                                            'Bold', 'Italic', 'Underline', '-',
                                                            'NumberedList', 'BulletedList', '-',
                                                            'ShowBlocks', 'Maximize',
                                                        ],
                                                    ],
                                                ],
                                            ],

                                        ])->label(false) ?>
<!--                                        --><?//=
//                                        $form->field($model, 'othrdetail')->textarea(['rows' => 4, 'cols' => 50])->label('Any Other Detail(optional)');
//                                        ?>
                                        <input type="text" name="skill_counter" id="skill_counter" readonly>
                                        <input type="text" name="qualific_count" id="qualific_count" readonly>
                                        <input type="text" name="desc_count" id="desc_count" readonly>
                                    </div>
                                </div>
                                <div class="divider"></div>
                            </div>
                            <div class="tab-pane" id="tab3">
                                <div id="process_err"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'getinterviewcity', ['template' => '{input}', 'options' => []])->hiddenInput(['id' => 'getinterviewcity'])->label(false) ?>
                                        <?= $form->field($model, 'question_process', ['template' => '{input}', 'options' => []])->hiddenInput(['id' => 'question_process'])->label(false) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12  m-padd">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3 class="module2-heading">Choose Application Process</h3>
                                            </div>
                                            <div class="col-md-6  ">
                                                <div class="pull-right c-btn-top">
                                                    <a onclick="window.open('/account/interview-processes/create', '_blank', 'width=1200,height=900,left=200,top=100');">
                                                        <?= Html::button('Create Application Process', ['class' => 'btn btn-md btn-primary custom-buttons2 custom_color-set2', 'id' => 'add2']); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    Pjax::begin(['id' => 'pjax_process']);
                                    if (!empty($process)) {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?=
                                                $form->field($model, 'interview_process')->radioList($process, [
                                                    'item' => function ($index, $label, $name, $checked, $value) {
                                                        $return .= '<div class="col-md-4 text-center">';
                                                        $return .= '<div class="radio_questions">';
                                                        $return .= '<div class="overlay-left"><a href="#" data-id="' . $value . '" class="text process_display">View</a></div>';
                                                        $return .= '<div class="inputGroup process_radio">';
                                                        $return .= '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . (($checked) ? 'checked' : '') . '>';
                                                        $return .= '<label for="' . $value . '">' . $label . '</label>';
                                                        $return .= '</div>';
                                                        $return .= '</div>';
                                                        $return .= '</div>';

                                                        return $return;
                                                    }
                                                ])->label(false);
                                                ?>
                                            </div>
                                        </div>

                                    <?php } else {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="empty-section-text">No Process Found</div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    Pjax::end();
                                    ?>
                                </div>
                                <input type="text" name="process_calc" id="process_calc" readonly>
                                <div class="divider"></div>
                                <div class="col-md-12 no-padd">
                                    <div id="select_ques_err"></div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3 class="module2-heading">Choose Questionnaire</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="md-radio-inline text-right clearfix">
                                                <?=
                                                $form->field($model, 'questionnaire_selection')->inline()->radioList([
                                                    1 => 'Add Questionnaire',
                                                    0 => 'Skip Questionnaire',
                                                ], [
                                                    'item' => function ($index, $label, $name, $checked, $value) {
                                                        $return = '<div class="md-radio">';
                                                        $return .= '<input type="radio" id="que' . $index . '" name="' . $name . '" value="' . $value . '" class="md-radiobtn">';
                                                        $return .= '<label for="que' . $index . '">';
                                                        $return .= '<span></span>';
                                                        $return .= '<span class="check"></span>';
                                                        $return .= '<span class="box"></span> ' . $label . ' </label>';
                                                        $return .= '</div>';
                                                        return $return;
                                                    }
                                                ])->label(false);
                                                ?>
                                            </div>
                                            <div class="pull-right c-btn-top clearfix">
                                                <a onclick="window.open('/account/questionnaire/create', '_blank', 'width=1200,height=900,left=200,top=100');">
                                                    <?= Html::button('Create Questionnaire', ['class' => 'btn btn-primary btn-md custom-buttons2 custom_color-set2', 'id' => 'add']); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="questionnaire_hide">
                                    <div id="que_error"></div>
                                    <?php
                                    Pjax::begin(['id' => 'pjax_questionnaire']);
                                    if (!empty($que)) {
                                        ?>
                                        <div class="row">
                                            <?=
                                            $form->field($model, 'questionnaire')->checkBoxList($que, [
                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                    $return .= '<div class="col-md-9">';
                                                    $return .= '<div class="radio_questions">';
                                                    $return .= '<div class="overlay-left"><a href="#" data-id="' . $value . '" class="text questionnaier_display">View</a></div>';
                                                    $return .= '<div class="inputGroup question_checkbox">';
                                                    $return .= '<input type="checkbox" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . (($checked) ? 'checked' : '') . '>';
                                                    $return .= '<label for="' . $value . '">' . $label . '</label>';
                                                    $return .= '</div>';
                                                    $return .= '</div>';
                                                    $return .= '</div>';
                                                    $return .= '<div class="col-md-3">';
                                                    $return .= '<div class="selectWrapper">';
                                                    $return .= '<select class="selectBox">';
                                                    $return .= '<option value="">Choose Stage</option>';
                                                    $return .= '</select>';
                                                    $return .= '</div>';
                                                    $return .= '</div>';
                                                    return $return;
                                                }
                                            ])->label(false);
                                            ?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="empty-section-text">No Questionnaire Found</div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    Pjax::end();
                                    ?>
                                    <input type="text" name="ques_calc" id="ques_calc" readonly>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="module2-heading">Walk In Interview Details </h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="md-radio-inline">
                                            <?=
                                            $form->field($model, 'interradio')->inline()->radioList([
                                                1 => 'Yes',
                                                0 => 'No',
                                            ], [
                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                    $return = '<div class="md-radio">';
                                                    $return .= '<input type="radio" id="1' . $index . '" name="' . $name . '" value="' . $value . '" class="md-radiobtn">';
                                                    $return .= '<label for="1' . $index . '">';
                                                    $return .= '<span></span>';
                                                    $return .= '<span class="check"></span>';
                                                    $return .= '<span class="box"></span> ' . $label . ' </label>';
                                                    $return .= '</div>';
                                                    return $return;
                                                }
                                            ])->label(false);
                                            ?>
                                        </div>
                                        <div id="error-checkbox-msg3"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="interview_box">
                                        <div class="col-md-6">
                                            <?=
                                            DatePicker::widget([
                                                'model' => $model,
                                                'attribute' => 'startdate',
                                                'id' => 'interview_range',
                                                'attribute2' => 'enddate',
                                                'options' => ['placeholder' => 'Start From'],
                                                'options2' => ['placeholder' => 'End Date'],
                                                'type' => DatePicker::TYPE_RANGE,
                                                'form' => $form,
                                                'pluginOptions' => [
                                                    'format' => 'dd-mm-yyyy',
                                                    'autoclose' => true,
                                                    'startDate' => '+0d',
                                                ]
                                            ]);
                                            ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?= $form->field($model, 'interviewstarttime')->widget(TimePicker::classname(), ['pluginOptions' => ['defaultTime' => '9:00 AM']])->label('Starts From');
                                            ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?= $form->field($model, 'interviewendtime')->widget(TimePicker::classname(), ['pluginOptions' => ['defaultTime' => '5:00 PM']])->label('End');
                                            ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-4 m-padd">
                                                <h3 class="module2-heading">Select Interview Locations</h3>
                                            </div>
                                            <div class="col-md-4">
                                                <span id="interview_error"></span>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="btn-padd-top pull-right">
                                                    <?= Html::button('Add New Location', ['value' => URL::to('/account/locations/create'), 'data-key' => '1', 'class' => 'btn modal-load-class btn-primary custom-buttons2']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php
                                        Pjax::begin(['id' => 'pjax_locations2']);
                                        if (!empty($int_list)) {
                                            ?>
                                            <?=
                                            $form->field($model, 'interviewcity')->checkBoxList($int_list, [
                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                    $i++;
                                                    if ($index % 3 == 0) {
                                                        $return .= '<div class="row">';
                                                    }
                                                    $return .= '<div class="col-md-4">';
                                                    $return .= '<input type="checkbox" value="' . $value . '" name="' . $name . '" id="int' . $value . '" data-value="' . $label['city_name'] . '" class="checkbox-input" data-count = "" ' . (($checked) ? 'checked' : '') . '>';
                                                    $return .= '<label for="int' . $value . '" class="checkbox-label">';
                                                    $return .= '<div class="checkbox-text">';
                                                    $return .= '<p class="loc_name_tag">' . $label['location_name'] . '</p>';
                                                    $return .= '<span class="address_tag">' . $label['address'] . '</span> <br>';
                                                    $return .= '<span class="state_city_tag">' . $label['city_name'] . ", " . $label['state_name'] . '</span>';
                                                    $return .= '</div>';
                                                    $return .= '</label>';
                                                    $return .= '</div>';

                                                    if ($index % 3 == 2 || isset($label['total'])) {
                                                        $return .= '</div>';
                                                    }
                                                    return $return;
                                                }
                                            ])->label(false);
                                            ?>
                                        <?php } else { ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="empty-section-text">No Location has been found</div>
                                                </div>
                                            </div>
                                        <?php }
                                        Pjax::end();
                                        ?>
                                        <input type="text" name="interview_calc" id="interview_calc" readonly>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane" id="tab5">
                                <div class="portlet box primary_colr">
                                    <div class="portlet-title">
                                        <div class="caption text-center">
                                            Confirm your details
                                        </div>
                                    </div>
                                    <div class="portlet-body flip-scroll">
                                        <table class="table table-bordered table-striped table-condensed flip-content">
                                            <tbody>
                                            <tr>
                                                <td><strong>Primary Field:</strong></td>
                                                <td><p class="final_confrm" data-display="primaryfield"
                                                       id="fieldvalue"></p></td>
                                                <td><strong>Job Title:</strong></td>
                                                <td><p class="final_confrm" data-display="jobtitle"></p></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Stipend Type:</strong></td>
                                                <td><p class="final_confrm" data-display="stipendtype"></p></td>
                                                <td><strong>Internship Type:</strong></td>
                                                <td><p class="final_confrm" data-display="jobtype"></p></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Min:</strong></td>
                                                <td><p class="final_confrm" data-display="minstip"></p></td>
                                                <td><strong>Max:</strong></td>
                                                <td><p class="final_confrm" data-display="maxstip"></p></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Fixed:</strong></td>
                                                <td><p class="final_confrm" data-display="stipendpaid"></p></td>
                                                <td><strong>Joining Date:</strong></td>
                                                <td><p class="final_confrm" data-display="earliestjoiningdate"></p></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Special Skills:</strong></td>
                                                <td colspan="3"><p class="final_confrm"
                                                                   data-display="specialskillsrequired"
                                                                   id="skillvalues"></p></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Timing From:</strong></td>
                                                <td><p class="final_confrm" data-display="from"></p></td>
                                                <td><strong>Upto:</strong></td>
                                                <td><p class="final_confrm" data-display="to"></p></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Interview Start:</strong></td>
                                                <td><p class="final_confrm" data-display="startdate"></p></td>
                                                <td><strong>Interview End:</strong></td>
                                                <td><p class="final_confrm" data-display="enddate"></p></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Interview Start Time:</strong></td>
                                                <td><p class="final_confrm" data-display="interviewstarttime"
                                                       id="time1"></p></td>
                                                <td><strong>Interview End Time:</strong></td>
                                                <td><p class="final_confrm" data-display="interviewendtime"
                                                       id="time2"></p></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Job Description:</strong></td>
                                                <td colspan="3"><p class="final_confrm" data-display="checkbox[]"
                                                                   id="chackboxvalues"></p></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Educational Qualification:</strong></td>
                                                <td colspan="3"><p class="final_confrm" data-display="qualifications[]"
                                                                   id="education_vals"></p></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Placement Locations (No. of positions):</strong></td>
                                                <td colspan="3"><p class="final_confrm"
                                                                   data-display="placement_locations[]"
                                                                   id="place_locations"></p></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Interview Location:</strong></td>
                                                <td colspan="3"><p class="final_confrm" data-display="interviewcity[]"
                                                                   id="interviewcitycityvalues"></p>
                                                    <span class="final_confrm" data-display="randomfunc"> </span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Brief Description:</strong></td>
                                                <td colspan="3"><p class="final_confrm" data-display="othrdetail"></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Preferred Gender:</strong></td>
                                                <td colspan="3"><p class="final_confrm" data-display="gender"
                                                                   id="gendr_text"></p></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Preferred Industry:</strong></td>
                                                <td colspan="3"><p class="final_confrm" data-display="pref_inds"></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Last Date:</strong></td>
                                                <td colspan="3"><p class="final_confrm" data-display="last_date"></p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div id="loading_img">
                    </div>
                    <div class="form-actions">
                        <div class="row ">
                            <div class="btn-preview">
                                <a href="javascript:;" class="btn custom-buttons3 button-previous custom_color-set">
                                    <i class="fa fa-angle-left"></i>
                                    Back
                                </a>
                                <a href="javascript:;"
                                   class="btn btn-primary custom-buttons2 button-next custom_color-set">
                                    Continue
                                    <i class="fa fa-angle-right"></i>
                                </a>
                                <?= Html::button('Submit', ['class' => 'btn button-submit custom-buttons2 btn-primary custom_color-set2']) ?>
                                <a id="data_preview" href="#"
                                   class="btn button-preview btn-primary custom-buttons2 custom_color-set2"
                                   target="_blank">Preview</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

    <div class="fader"></div>

<?php
$this->registerCss("
.overlay-left {
  position: absolute;
  top: 1px;
  left: 8px;
  right: 0;
  background-color: #008CBA;
  overflow: hidden;
  width: 0;
  height: 53px;
  z-index:99;
  transition: .5s ease;
  border-radius: 8px 0px 0px 8px;
}

.radio_questions:hover .overlay-left {
  width: 130px;
}

.text {
  color: white;
  font-size: 15px;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  white-space: nowrap;
}
/* Feature, categories css starts */
.checkbox-input {
  display: none;
}
.checkbox-label-v2 {
/*   display: inline-block; */
/*   vertical-align: top; */
/*   position: relative; */
  width: 100%;
  cursor: pointer;
  font-weight: 400;
  margin-bottom:0px;
}
#pre_package{display:none;}
.checkbox-label-v2:before {
  content: '';
  position: absolute;
  top: 80px;
  right: 16px;
  width: 40px;
  height: 40px;
  opacity: 0;
  background-color: #00A0E3;
  background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
  background-position: 80% 80%;
  background-repeat: no-repeat;
  background-size: 30px;
  border-radius: 50%;
  -webkit-transform: translate(0%, -50%);
  transform: translate(0%, -50%);
  transition: all 0.4s ease;
}
.checkbox-input:checked + .checkbox-label-v2:before {
  top: 0;
  opacity: 1;
}
.checkbox-input:checked + .checkbox-label-v2 .checkbox-text span {
  -webkit-transform: translate(0, -8px);
  transform: translate(0, -8px);
}

.cat-sec {
    float: left;
    width: 100%;
}
.p-category {
    float: left;
    width: 100%;
    z-index: 1;
    position: relative;
    display:flex;
}
.p-category, .p-category *{
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}
.p-category .checkbox-text {
    float: left;
    width: 100%;
    text-align: center;
    padding-bottom: 30px;
    border-bottom: 1px solid #e8ecec;
    border-right: 1px solid #e8ecec;
}
.p-category .checkbox-text span i {
    float: left;
    width: 100%;
    color: #00A0E3;
    font-size: 70px;
    margin-top: 15px;
    line-height: initial !important;
}
.p-category .checkbox-text span {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 15px;
    color: #202020;
    margin-top: 10px;
}
.p-category:hover {
    background: #ffffff;
    -webkit-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -moz-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -ms-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -o-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    width: 104%;
    margin-left: -2%;
    height: 102%;
    z-index: 10;
}
.p-category:hover .checkbox-text {
    border-color: #ffffff;
}
.p-category:hover .checkbox-label-v2 i{
    color: #f07d1d;
}
.row.no-gape .p-category-main {
    padding: 0;
}
.cat-sec .row .p-category-main:last-child .checkbox-text {
    border-right-color: #ffffff;
}
/* Feature, categories css ends */
.no-padd{
    padding-left:0px; 
    padding-right:0px;
} 
.c-btn-top{
    padding-top:35px;  
} 
.empty-section-text{
    font-size:15px;
    text-align:center;
    padding:20px 0px 10px 0;
} 
.btn-padd-top{
    padding-top:30px !important;
}
.m-padd{
    padding-left:15px !important;
}
.form-wizard .steps>li.active>a.step .number{
    background-color:#00a0e3 !important;
} 
.padd-10{
    padding-top:20px !important;
}
.manual_notes{
    padding: 6px 0px 0 10px;
    color: #999999;
    font-size: 15px;
} 
textarea{
    resize:none;
} 
.materialize-tags {
    border-bottom: 1px solid #c2cad8 !important;
}
.divider{
    border-top:2px solid #eee;
    margin: 35px -40px 19px;
}
.module2-heading{
    text-transform: uppercase;
    font-size: 22px;
    padding: 20px 0 0 0;
    color: #00a0e3; 
    font-weight: initial;
}
.has-success .md-radio label, .has-success.md-radio label {
    color: #00a0e3;
} 
.custom-buttons2{
//    width:100%;
//    background:#00a0e3 !important;
    font-size: 12px !important;
    padding: 8px 10px !important;
//    margin-bottom:20px;
     -webkit-border-radius: 6px !important;
    -moz-border-radius: 6px !important;
    -ms-border-radius: 6px !important;
    -o-border-radius: 6px !important;
    border-radius: 6px !important;
}
.custom-buttons2:hover{
    color: #ffffff;
    box-shadow:0 0 10px rgba(0,0,0,.5) !important;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -ms-transition:.3s all;
    -o-transition:.3s all;
}
.custom-buttons3{
//    width:100%;
    background:#ddd !important;
    font-size: 12px !important;
    padding: 8px 10px !important;
    margin-bottom:20px;
    color:#000 !important;
    border-color:#ddd !important;
     -webkit-border-radius: 6px !important;
    -moz-border-radius: 6px !important;
    -ms-border-radius: 6px !important;
    -o-border-radius: 6px !important;
    border-radius: 6px !important;
}
.custom-buttons3:hover, .custom-buttons3:active, .custom-buttons3:focus{
    color: #000 !important;
    background:#ddd !important;
    box-shadow:0 0 10px rgba(0,0,0,.5) !important;
    border-color:#ddd !important;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -ms-transition:.3s all;
    -o-transition:.3s all;
}
 /*new changes end*/
 
select{
 -moz-appearance: none;
 -o-appearance: none;
 -webkit-appearance: none;
}
.select {
  position: relative;
}


.gender_radio {
  position: absolute;
  visibility: hidden;
  display: none;
}

.gender_label {
    color: #9a929e;
    display: inline-block;
    cursor: pointer;
    font-weight: 400;
    padding: 5px 9px;
    line-height: 24px;
    min-height: 37px;
    margin-top: -2px !important;
    margin-left: -4px;
}

.gender_radio:checked + .gender_label{
    color: #fff;
    background: #00a0e3;
    margin: 0px 0px 0px -4px;
//    border-radius: 4px;
    height: 35px;
    padding-top: 7px;
    
}
.gender_label:last-child{
    
}

.gender_label + .gender_radio + .gender_label {
      border-left: solid 1px #c5cdda;
}
.radio-group {
    border: solid 1px #c5cdda;
    display: inline-block;
    border-radius: 5px;
    overflow: hidden;
    max-height: 36px;
    
}
#gender_pref {
    margin-top: 20px;
    text-align: center;
}

.field-gender
{
 margin:0px;
}

#week_options
{
 margin-left:10px;
}
#week_options div div{
    padding-top:0px;
}

.field-weekoptsat,.field-weekoptsund
{
    width: 100%;
    float: left;
    display:none;
}

    
#weekoptsat,#weekoptsund
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
#add2{
//display:none;
}
.selectBox{
    width: 100%;
    border: 1px solid #d1d7dc;
    border-radius: 5px;
    padding: 6px 15px;
}
.selectBox:focus{
    outline:none !important;
}
.selectWrapper{
    padding: 15px 16px;
}
.weekDays-selector input[type=checkbox]:checked + label {
  background: #00a0e3;
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
.progress-bar-success {
    background-color: #00a0e3;
}
.button-previous
{
  display:none;
}
#last_date,#earliestjoiningdate{
    border-bottom: 1px solid #c2cad8;
    cursor: pointer;
}
.has-error div #last_date, .has-error div #earliestjoiningdate{
border-bottom: 1px solid #e73d4a;
}
.has-error div #interviewstarttime-error{
    margin-top:10px;
}
.has-error div #interviewendtime-error{
    margin-top:10px;
}
.has-success div div .input-group-addon, .has-success div #last_date, .has-success div #earliestjoiningdate{
    border-bottom: 1px solid #00A0E3 !important;
}
.button-submit
{
display:none;
}
#ctc
{
  display:none;
}

.large-container{
    max-width: 1400px !important;
    padding-left: 15px;
    padding-right: 15px;
    margin:auto;
}
.tab-content{
    padding:20px 20px 0 20px;
}
.caption{
    padding:10px;
    width:100%;
}
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
#fixed_stip,#min_max,#stipend_paid
{
 display:none;
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
.cat_wrapper .Typeahead-spinner, .desig_wrapper .Typeahead-spinner {
    position: absolute;
    right: 20px;
    bottom: 46px;
    display: none;
    font-size: 22px;
}

.empty-message {

 text-align: center;
 
}
.skill_wrapper
{
margin-bottom:8px;
}

.skill_wrapper .Typeahead-spinner,.descrip_wrapper .Typeahead-spinner,.edu_wrapper .Typeahead-spinner
{
    position: absolute;
    top: 10px;
    z-index: 999;
    right: 20px;
    display:none;
    font-size:22px;
}

.Typeahead-input {
    position: relative;
    background-color: transparent;
    outline: none;
}

.twitter-typeahead {
    
    width: 100% !important;
}

.n-tag[disabled]
{
  display:none;
}

.materialize-tags-max .n-tag
{
  display:none;
}

.inputGroup {
  background-color: #fff;
  display: block;
  margin: 10px 0;
  position: relative;
}
.inputGroup label {
   padding: 6px 75px 10px 25px;
    width: 96%;
    display: block;
    margin:auto;
    text-align: left;
    color: #3C454C !important; 
    cursor: pointer;
    position: relative;
    z-index: 2;
    transition: color 1ms ease-out;
    overflow: hidden;
    border-radius: 8px;
    border:1px solid #eee;
}

.inputGroup label:before {
  width: 100%;
  height: 10px;
  border-radius: 50%;
  content: '';
//  background-color: #00a0e3;
  background-color: #fff;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%) scale3d(1, 1, 1);
  transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
  opacity: 0;
  z-index: -1;
  box-shadow:0 0 10px rgba(0,0,0,.5) !important;
}
.question_checkbox label:after {
  width: 32px;
  height: 32px;
  content: '';
  border: 2px solid #D1D7DC;
  background-color: #fff;
  background-repeat: no-repeat;
  background-position: 2px 3px;
  background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
  //border-radius: 50%;
  z-index: 2;
  position: absolute;
  right: 30px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  transition: all 200ms ease-in;
}
.process_radio label:after {
  width: 32px;
  height: 32px;
  content: '';
  border: 2px solid #D1D7DC;
  background-color: #fff;
  background-repeat: no-repeat;
  background-position: 2px 3px;
  background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
  border-radius: 50%;
  z-index: 2;
  position: absolute;
  right: 30px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  transition: all 200ms ease-in;
}

.inputGroup input:checked ~ label {
  color: #fff;
  box-shadow:0 0 10px rgba(0,0,0,.3) !important;
}
.inputGroup input:checked ~ label:before {
  transform: translate(-50%, -50%) scale3d(56, 56, 1);
  opacity: 1;
}
.inputGroup input:checked ~ label:after {
  background-color: #00a0e3;
  border-color: #00a0e3;
}
.inputGroup input {
  width: 32px;
  height: 32px;
  order: 1;
  z-index: 2;
  position: absolute;
  right: 30px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  visibility: hidden;
}

.radio_questions {
//      padding: 0 16px;
  max-width: 80%;
  font-size: 18px;
  font-weight: 600;
  line-height: 36px;
  position:relative;
}

#skill_counter,#qualific_count,#desc_count,#placement_calc,#interview_calc,#benefit_calc,#process_calc,#ques_calc
{opacity:0;
cursor:default;
width:5%;
}

.rule-text4
{color:#e9465d;
font-size: 16px;
padding: 0px 15px;}

.checkbox-input {
  display: none;
}

q:before, q:after, blockquote:before, blockquote:after {
  content: '';
  content: none;
}
.checkbox-label, .checkbox-text, .checkbox-text--description {
  transition: all 0.4s ease;
}
.checkbox-label:before {
    content: attr(data-before);
    position: absolute;
    color: #efecec;
    text-align: center;
    top: 75%;
    padding: 5px 4px;
    font-size: 18px;
    font-weight: 600;
    right: 16px;
    width: 36px;
    height: 36px;
    opacity: 0;
    background-color: #00A0E3;
    background-position: center;
    background-repeat: no-repeat;
    background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
    background-size: 100%;
    border-radius: 50%;
    background-position: 4px 4px;
    -webkit-transform: translate(0%, -50%);
    transform: translate(0%, -50%);
    transition: all 0.4s ease;
}
.color_red
{
 color: #e73d49;
 font-size:14px;
}
.spinner {
  width: 100px;
  display:none;
  margin-top:10px;
}
.spinner input {
  text-align: right;
  max-width:48px;
}
.input-group-btn-vertical {
  position: relative;
  white-space: nowrap;
  width: 1%;
  vertical-align: middle;
  display: table-cell;
}
.input-group-btn-vertical > .btn {
  display: block;
  float: none;
  width: 100%;
  max-width: 100%;
  padding: 8px 11px !important;
  margin-left: -1px;
  position: relative;
  border-radius: 0;
}
.input-group-btn-vertical > .btn:first-child {
  border-top-right-radius: 4px;
}
.input-group-btn-vertical > .btn:last-child {
  margin-top: -2px;
  border-bottom-right-radius: 4px;
}
.input-group-btn-vertical i{
  position: absolute;
  top: 0;
  left: 4px;
}
  
.checkbox-label {
    display: inline-block;
    vertical-align: top;
    position: relative;
    width: 100%;
    padding: 5px 29px;
    cursor: pointer;
    
    font-weight: 400;
    margin: 16px 0;
    border: 1px solid #d9d9d9;
    
    border-radius: 2px;
    box-shadow: inset 0 0 0px 0 #00A0E3;
}

#heading_placeholder
{
  font-size:21px;
}

.checkbox-text--title {
  font-weight: 500;
}
.checkbox-text--description {
  font-size: 14px;
  margin-top: 16px;
  padding-top: 10px;
  border-top: 1px solid #00A0E3;
      margin-bottom: 10px;
}
.checkbox-text--description .un {
  display: none;
}

.checkbox-input:checked + .checkbox-label {
  border-color: #00A0E3;
  box-shadow: inset 0 -12px 0 0 #00A0E3;
}
.checkbox-input:checked + .checkbox-label:before {
  top: 0;
  opacity: 1;
}
.checkbox-input:checked + .checkbox-label .checkbox-text {
  -webkit-transform: translate(0, -8px);
  transform: translate(0, -8px);
}
.checkbox-input:checked + .checkbox-label .checkbox-text--description {
  border-color: #d9d9d9;
}
.checkbox-input:checked + .checkbox-label .checkbox-text--description .un {
  display: inline-block;
}
.state_city_tag
{font-size:14px;}

.address_tag
{font-size: 13px;}
#existing_location
{
 padding:6px 0px;
}
.materialize-tags ~ input ~ label {
  color: #999 !important;
  padding: 1rem !important;
  position: absolute !important;
  top: 12px !important;
  left: 0 !important;
  -webkit-transition: .2s ease all !important;
  transition: .2s ease all !important;
  pointer-events: none !important;
}
.materialize-tags ~ input ~ .infocus, .materialize-tags ~ input ~ .active{
 font-size: 12px !important;
 color: #999 !important;
 top: -2.25rem !important;
 -webkit-transition: .2s ease all !important;
 transition: .2s ease all !important;
}
.chip i.material-icons
{
      line-height: 29px !important;
}
.chip {
    display: inline-block;
    height: 28px;
    font-size: 14px;
    font-weight: 500;
    font-weight: 500;
    color: rgba(0, 0, 0, 0.6);
    line-height: 28px;
    padding: 0px 12px;
    border-radius: 5px;
    background-color: #e4e4e4;
    margin-bottom: 4px;
    margin-right: 5px;
    margin-top: 0px;
}

.chip .close {
  cursor: pointer;
  float: right;
  font-size: 16px;
  line-height: 32px;
  padding-left: 8px;
}

span.chip .fa-times
{    cursor: pointer;
    float: right;
    font-size: 14px;
    line-height: 28px;
    padding-left: 8px;
}

.jd_heading{
  margin-top: 0px;
}
.loc_name_tag{
    margin: 5px 0px;
    font-size: 19px;
    padding-top: 6px;
}

.rule-text2{
  padding: 2px 16px;
    color: #e9465d;
}

.md-checkbox {
    position: relative;
    margin-bottom: 8px;
    
}

.field-checkbox{
  margin-top: -22px;
}

.form-group{
    min-height:10px;
}

#md-checkbox,#quali_list
{
    min-height: 288px;
    max-height: 288px;
    overflow-y: scroll;
    margin:0px;
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 6px;
    position:relative;
}
#suggestionbox{
    min-height: 130px;
    max-height: 130px;
    overflow-y: scroll;
    margin:15px;
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 6px;
    position:relative;
}
#startdate-kvdate{
    padding:25px 0px;
}

#addct
{
     padding: 28px 10px;
    text-align: center;
}
.close-ctc{
    position: absolute;
    z-index: 11;
    top: 30px;
    font-size: 16px;
    right: 20px;
    color: #a2a2a2;
}
.button_location
{padding: 14px 0px;
float:right;}
.close-drp_down
{
    position: absolute;
    font-size: 16px;
    right: -26px;
    color: #a2a2a2;
    bottom: 16px;
}
.checkbox-text
{
  margin-bottom:8px;
}

.checkbox-text .form-group.form-md-line-input {
   
     padding-top: 0px !important; 
     margin: 0 0 0px !important;
}
.placeble-area
{
    border: 1px solid #ccc;
    min-height:130px;
    max-height: 130px;
    border-radius: 6px;
    display: flex;
    padding: 5px 14px;
    position:relative;
    overflow-y: scroll;
}
.drop-options li{
    padding:10px;
}

.connected-sortable {
     margin: 0;
    list-style: none;
    width: 100%;
    padding: 0px;
}
li.draggable-item {
  width: inherit;
  position:relative;
  padding: 15px 35px 15px 20px;
  background-color: #f5f5f5;
  cursor:move;
  border-bottom:1px solid #d6cece;
  -webkit-transition: transform .25s ease-in-out;
  -moz-transition: transform .25s ease-in-out;
  -o-transition: transform .25s ease-in-out;
  transition: transform .25s ease-in-out;
  
  -webkit-transition: box-shadow .25s ease-in-out;
  -moz-transition: box-shadow .25s ease-in-out;
  -o-transition: box-shadow .25s ease-in-out;
  transition: box-shadow .25s ease-in-out;
  &:hover {
    cursor: pointer;
    background-color: #eaeaea;
  }
}

li.draggable-item.ui-sortable-helper {
  background-color: #e5e5e5;
  -webkit-box-shadow: 0 0 8px rgba(53,41,41, .8);
  -moz-box-shadow: 0 0 8px rgba(53,41,41, .8);
  box-shadow: 0 0 8px rgba(53,41,41, .8);
  transform: scale(1.015);
  z-index: 100;
}
li.draggable-item.ui-sortable-placeholder {
  background-color: #ddd;
  -moz-box-shadow:    inset 0 0 10px #000000;
   -webkit-box-shadow: inset 0 0 10px #000000;
   box-shadow:         inset 0 0 10px #000000;
}

#hiddenlist{
	display:none;
}

#shownlist{
    display: block;
    clear: both;
    margin-top:8px;
}

    .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
        } 
#shownlist span a {
    color: #bcbcbc;
    text-decoration: none;
//    font-weight: 900;
    margin-left: 10px;
}
#suggestionbox span:hover , #suggestionbox span:hover a{
    background-color: #00a0e3;
    color:#FFF;
}
#shownlist span:hover , #shownlist span:hover a{
    background-color: #00a0e3;
    color:#FFF;
}
#suggestionbox span a, .drop-options span a,.quali_drop_options span a
{
    color: #1d1818;
    text-decoration: none;
    
}
#shownlist span,#suggestionbox span{
    display: block;
    float: left;
    padding: 5px 8px;
    background-color: #f4f3f3;
    color: #1d1818;
    margin: 0 10px 10px 0;
    border-radius: 4px;
}

#checkboxlistarea,#quali_listarea
{
    border: 1px solid #c2cad8;
    min-height: 288px;
    max-height: 288px;
    overflow-y: scroll;
    border-radius:6px;
    position:relative;
}

#checkboxlistarea h3,#quali_listarea h3
{
    color: #c2cad8;
    text-align: center;
    font-size: 16px;
    font-weight: 300;
    padding:100px 10px 0 10px;
    line-height: 23px;
}

#add_existing_location
{
  margin:-21px;
}

.rule-text{
    position: absolute;
    color: #e73d49;
    font-size:16px;
}

.inter_cust_rule
{
color: #e73d49;
font-size:16px;
}

#add,#question_dropdown
 {
 //display:none;
 }
 
 #interview_box
 {
display:none; 
}
.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('http://www.downgraf.com/wp-content/uploads/2014/09/01-progress.gif?e44397') 50% 50% no-repeat rgb(249,249,249);
}

#loading_img
{
  display:none;
}

#loading_img.show
{
display : block;
position : fixed;
z-index: 100;
background-image : url('https://cdn.dribbble.com/users/178981/screenshots/1642680/tick.gif');
opacity : 1;
background-repeat : no-repeat;
background-position : center;
width:60%;
height:60%;
left : 20%;
bottom : 0;
right : 0;
top : 20%;
}
.fader{
  width:100%;
  height:100%;
  position:fixed;
  top:0;
  left:0;
  display:none;
  z-index:99;
  background-color:#fff;
  opacity:0.7;
}

.step5
{
 display:none !important;
}
#bar
{
height:17px !important;
}
.tooltips{
    display: none; 
    width: 167px;
    position: absolute;
    left: 90px;
    border: solid 1px transparent;
    background-color: #00A0E3;
    padding: 10px;
    color: #fff;
    z-index: 1000;
    bottom: -3px;
    border-radius:4px;
}
.tooltips:before{
    content: '';
    left: -15px;
    top: 10px;
    position: absolute;
    border-top: 10px solid transparent;
    border-right: 15px solid #00A0E3;
    border-bottom: 10px solid transparent;
}


.number-input input[type=\"number\"] {
  -webkit-appearance: textfield;
  -moz-appearance: textfield;
  appearance: textfield;
}

.number-input input[type=number]::-webkit-inner-spin-button,
.number-input input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
}

.number-input {
  border: 2px solid #ddd;
  display: inline-flex;
  display:none;
}

.number-input,
.number-input * {
  box-sizing: border-box;
}

.number-input button {
  outline:none;
  -webkit-appearance: none;
  background-color: transparent;
  border: none;
  align-items: center;
  justify-content: center;
  width: 3rem;
  height: 3rem;
  cursor: pointer;
  margin: 0;
  position: relative;
}

#manual_questions
{
  margin-bottom:8px;
}

.number-input button:before,
.number-input button:after {
  display: inline-block;
  position: absolute;
  content: '';
  width: 1rem;
  height: 2px;
  background-color: #212121;
  transform: translate(-50%, -50%);
}
.number-input button.plus:after {
  transform: translate(-50%, -50%) rotate(90deg);
}

.number-input input[type=number] {
  font-family: sans-serif;
  max-width: 5rem;
  padding: .5rem;
  border: solid #ddd;
  border-width: 0 2px;
  font-size: 2rem;
  height: 3rem;
  font-weight: bold;
  text-align: center;
}
.btn-preview{
    margin: auto;
    width: 100%;
    text-align: center;
}
.btn-preview a{
    margin:0px 5px;
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
}
.remove_this_item{
   position: absolute;
    right: 10px;
    top: 0%;
    background-color: #ff3434;
    color: #fff !important;
    border-radius: 0px 0px 9px 9px;
    width: 30px;
    height: 23px;
    text-align: center;
    line-height: 21px;
}

.button-preview {
    display:none;
}
.place_no{
    text-align: center !important;
    border: 1px solid #ddd !important;
}
.md-radio-inline.text-right.clearfix{padding-top:20px;}
#benefits_hide,#questionnaire_hide,#benefitPopup,#add
{
 display:none;
}
");

$script = <<< JS
$('input[name= "benefit_selection"]').on('change',function(){
        var option = $(this).val();
        if(option==1)
            {
             $('#benefits_hide').css('display','block');   
             $('#benefitPopup').css('display','block');   
            }
        else {
            $('#benefits_hide').css('display','none');   
            $('#benefitPopup').css('display','none');   
        }
          
        });

$('input[name= "questionnaire_selection"]').on('change',function(){
        var option = $(this).val();
        if(option==1)
            {
             $('#questionnaire_hide').css('display','block');   
             $('#add').css('display','block');   
            }
        else {
            $('#questionnaire_hide').css('display','none');   
            $('#add').css('display','none');   
        }
          
        });
$(document).on('click','.questionnaier_display',function(e) {
    e.preventDefault();
    var data = $(this).attr('data-id');
    window.open('/account/questionnaire/'+data+'/view', "_blank");
});

$(document).on('click','.process_display',function(e) {
    e.preventDefault();
    var data = $(this).attr('data-id');
    window.open('/account/interview-processes/'+data+'/view', "_blank");
});
$('input[name= "pre_place"]').on('change',function(){
        var pre = $(this).attr("data-title");
        if(pre==1)
        {
         $('#pre_package').show();
        }
        else if(pre==2)
        {
         $('#pre_package').hide();
        }
        });
$('input[name= "stipendtype"]').on('change',function(){
        var stipendtyp = $(this).attr("data-title");
   if(stipendtyp=='1')
        {
        $('#fixed_stip').hide();
        $('#stipend_paid').hide();
        $('#min_max').hide();
        $('#minstip').val('');
        $('#maxstip').val('');
        $('#stipendpaid').val('');
        }
     else if(stipendtyp =='4')
        {
        $('#fixed_stip').show();
        $('#stipend_paid').show();
        $('#min_max').hide();
        $('#minstip').val('');
        $('#maxstip').val('');
        $('#stipendpaid').val('');
        }
     else if(stipendtyp=='2')
        {
        $('#fixed_stip').hide();
        $('#stipend_paid').show();
        $('#min_max').show(); 
        $('#stipendpaid').val('');
        }
     else if(stipendtyp=='3')
        {
        $('#fixed_stip').hide();
        $('#stipend_paid').show();
        $('#min_max').show(); 
        $('#stipendpaid').val('');
        }
   }) 
var session_tok = "";
function genrate_session_token() {
    var possible = "abcdefghijklmnopqrstuvwxyz1234567890";
    for(var i = 0;i < 8; i++) {
        session_tok += possible.charAt(Math.floor(Math.random()*possible.length));
    }
}
genrate_session_token();
//$('#loading_img').addClass('show');
$("#primaryfield").prop("disabled", false);          
$("#jobtitle").prop("disabled", false);
$('.selectBox').prop("disabled", true);    
   
$('#minstip, #maxstip').mask("#,#0,#00", {reverse: true});
$('#stipendpaid, #pre_sal').mask("#,#0,#00", {reverse: true});
$('[data-toggle="tooltip"]').tooltip();
    $(document).on("keypress",'.place_no', function (evt) {
    if (evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
   });     
   
   $(document).on('click','.up_bt',function(e)
       {
       e.preventDefault();  
       var up = $(this).parent().prev().val();
       if(up>=0) 
       $(this).parent().prev().val( parseInt(up,10)+1 );
       else{
        return false;
           } 
   });
 
  $(document).on('change','input[name="interview_process"]',function()
      {
        $('.selectBox').html('<option value="">Choose Stage</option>');
         var id = $(this).val();
        if(!id=="")
        {
           $.ajax({
                 url:'/account/categories-list/process-list',
                 data:{id:id},
                 method:'post',
                 success:function(res)
                 {
                       var obj = JSON.parse(res);
                       var html = []; 
                       $.each(obj,function(index,value)
                             {
                              html.push('<option value="'+value.field_enc_id+'">'+value.field_name+'</option>');
                            });
                        $('.selectBox').append(html);
                  }
               })
         }
   })      
   
   $(document).on('click','.down_bt',function(e)
       {
       e.preventDefault();
       var down = $(this).parent().prev().val(); 
       if(down>=2)  
       $(this).parent().prev().val( parseInt(down,10)-1 );
       else
        {
        return false;
         }  
   });     
      
var data_before = null;
var checked = null;
var array = [];
var place_len = 0;        
var interview_len = 0; 
var benefit_len = 0;
var ques_len = 0;
var stage_len = 0;
var process_len = 0;


$(document).on("click",'input[name="placement_locations[]"]', function() {
    checked = $(this);
     
    if (this.checked == true) {
        place_len =  $('[name="placement_locations[]"]:checked').length;
        place_checker(place_len);
        checked.next('label').find('.spinner').css('display','inline-flex');
        checked.next('label').find(".tooltips").fadeIn(1000);
        checked.next('label').find(".tooltips").fadeOut(2000);
    } 
        
    else {
        place_len =  $('[name="placement_locations[]"]:checked').length;
        place_checker(place_len);   
      checked.next('label').find('.spinner').css('display','none');
      checked.next('label').find(".tooltips").css('display','none');  
   }   
});

$(document).on("click",'input[name="interviewcity[]"]', function() {
    checked = $(this);
    if (this.checked == true) {
        interview_len =  $('[name="interviewcity[]"]:checked').length;
        interview_checker(interview_len);
    } 
        
    else {
        interview_len =  $('[name="interviewcity[]"]:checked').length;
        interview_checker(interview_len); 
        
   }   
});

$(document).on("click",'input[name="emp_benefit[]"]', function() {
    checked = $(this);
    if (this.checked == true) {
        benefit_len =  $('[name="emp_benefit[]"]:checked').length;
        benefit_checker(benefit_len);
       
    } 
        
    else {
        benefit_len =  $('[name="emp_benefit[]"]:checked').length;
        benefit_checker(benefit_len); 
        
   }   
});

$(document).on("click",'input[name="interview_process"]', function() {
    checked = $(this);
    if (this.checked == true) {
        process_len =  $('[name="interview_process"]:checked').length;
        process_checker(process_len);

    } 
        
    else {
        process_len =  $('[name="interview_process"]:checked').length;
        process_checker(process_len); 
        
   }   
}); 
         
var prime_id = null;

        function place_checker(place_len)
        {
          if(place_len == 0)
          {
              $('#placement_calc').val('');
           }
          else 
          {
              $('#placement_calc').val('1');
           }
        }
        function interview_checker(interview_len)
        {
          if(interview_len == 0)
          {
              $('#interview_calc').val('');
           }
          else 
          {
              $('#interview_calc').val('1');
           }
        }

   function benefit_checker(benefit_len)
        {
          if(benefit_len == 0)
          {
              $('#benefit_calc').val('');
           }
          else 
          {
              $('#benefit_calc').val('1');
           }
        }
   function process_checker(process_len)
        {
          if(process_len == 0)
          {
              $('#process_calc').val('');
           }
          else 
          {
              $('#process_calc').val('1');
           }
        } 
        function ques_checker(ques_len,stage_len)
        {  
          if(ques_len>0&&stage_len>0&&ques_len==stage_len)
          {
              $('#ques_calc').val('1');
           }
           else
           {
            $('#ques_calc').val('');
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
   
   }) 
   
$('#primaryfield').on('change',function()
    {
      prime_id = $(this).val();
      $('#jobtitle').val('');
      $('.tt-dataset').empty();  
   })
var skills = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote: {
    url:'/account/categories-list/skills-data',
    prepare: function (query, settings) {
             settings.url += '?q=' +$('#inputfield').val();
             return settings;
        },  
    'cache': true, 
    filter: function(list) {
             return list;
        }
  }
});    
            
$('#inputfield').typeahead(null, {
  name: 'skill',
  display: 'value',
  source: skills,
   limit: 6,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.skill_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.skill_wrapper .Typeahead-spinner').hide();
  }).on('typeahead:selected',function(e, datum)
  {
      var skillsdata = datum.value;
      var value = datum.id;
      addTags(skillsdata,value);
   });
        
var categories = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url:'/account/categories-list/categories-data',
    prepare: function (query, settings) {
             settings.url += '?q=' + $('#jobtitle').val()+'&type=Internships&id='+prime_id;
             return settings;
        },  
    'cache': false,  
  }
});
        
$('#jobtitle').typeahead(null, {
  name: 'categories',
  display: 'value',
  source: categories,
  minLength: 1,
  highlight: true, 
   limit: 20    ,
}).on('typeahead:asyncrequest', function() {
    $('.cat_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.cat_wrapper .Typeahead-spinner').hide();
     
  }).on('typeahead:selected typeahead:autocompleted',function(e, datum)
  {var data =  datum.id; 
      skils_update(data); 
      educational_update(data); 
      $('.drop-options').empty();
      $('#shownlist').empty();
      $('#heading_placeholder').css('display','block'); 
      $.ajax({
      url:"/account/categories-list/job-description",
      data:{data:data},
      method:"post",
      success:function(data)
     {
     var obj = JSON.parse(data);
     var html = [];
     $.each(obj,function()
     { 
      html.push ("<div class=\'md-checkbox\'>"+
     "<input type=\'checkbox\' id=\'"+this.job_description_enc_id+"\' value = \'"+this.job_description_enc_id+"\' class=\'md-check\' name = \'checkbox[]\'>"+
      "<label for=\'"+this.job_description_enc_id+"\'>"+
      "<span></span>"+
       "<span class=\'check\'></span>"+
       "<span class=\'box\'></span>"+this.job_description+"</label>"+
       "</div>");  
         });
                                                
        $("#md-checkbox").html(html); 
         }
     });  
    });
    
function skils_update(data)
        {
      $.ajax({
      url:"/account/categories-list/job-skills",
      data:{data:data},
      method:"post",
      success:function(response)
        {
           var obj = JSON.parse(response);
           var html = [];
     $.each(obj,function()
     { 
      html.push ("<span ><a href='#' class='clickable' data-value = '"+this.skill_enc_id+"'>"  +this.skill+ "</a> </span>");  
         });
                                                
        $("#suggestionbox").html(html);
        }
      });    
        }
        
 function educational_update(data)
        {
        $.ajax({
      url:"/account/categories-list/job-qualifications",
      data:{data:data},
      method:"post",
      success:function(data)
     {
     var obj = JSON.parse(data);
     var html = [];
     $.each(obj,function()
     { 
      html.push ("<div class=\'md-checkbox\'>"+
     "<input type=\'checkbox\' id=\'"+this.educational_requirement_enc_id+"\' value = \'"+this.educational_requirement+"\' class=\'md-check\' name = \'qualifications[]\'>"+
      "<label for=\'"+this.educational_requirement_enc_id+"\'>"+
      "<span></span>"+
       "<span class=\'check\'></span>"+
       "<span class=\'box\'></span>"+this.educational_requirement+"</label>"+
       "</div>");  
         });                                
        $("#quali_list").html(html); 
         }
     });  
        }
   
  
 function ChildFunction()
     {
       
       $.pjax.reload({container: '#pjax_questionnaire', async: false});
       $.pjax.reload({container: '#pjax_process', async: false});
     }
window.ChildFunction = ChildFunction;
var Education = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('educational_requirement'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: '/account/categories-list/educations?q=%QUERY', 
    wildcard: '%QUERY',
    cache: true,     
        filter: function(list) {
            return list;
        }
  }
});   
        
var edu_type = $('#quali_field').typeahead(null, {
  name: 'quali_field',
  display: 'educational_requirement',
   limit: 4,      
  source: Education
}).on('typeahead:asyncrequest', function() {
    $('.edu_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.edu_wrapper .Typeahead-spinner').hide(); 
  }).on('typeahead:selected',function(e, datum)
  { 
      var id = datum.educational_requirement_enc_id;
      var qualification = datum.educational_requirement;  
      drop_edu(id,qualification);
      edu_type.typeahead('val','');  
   });         
        
var Descriptions = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('job_description'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: '/account/categories-list/description?q=%QUERY',
    wildcard: '%QUERY',
    cache: true,     
        filter: function(list) {
            return list;
        }
  }
});   
        
var que_type = $('#question_field').typeahead(null, {
  name: 'question_field',
  display: 'job_description',
   limit: 4,      
  source: Descriptions
}).on('typeahead:asyncrequest', function() {
    $('.descrip_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.descrip_wrapper .Typeahead-spinner').hide(); 
  }).on('typeahead:selected',function(e, datum)
  { 
      var id = datum.job_description_enc_id;
      var questions = datum.job_description;  
      drop_options(id,questions); 
      que_type.typeahead('val','');
   }); 
        
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
$(document).on('click', '.modal-load-class', function() {
    $('#modal').modal('show').find('.modal-body').load($(this).attr('value'));   
});


 $('#add_existing_location').hide();        
 $('#existing_location').on('click',function()
   {
     $('#existing_location').hide();   
     $('#add_existing_location').show();   
   })    
 $('.close-drp_down').on('click',function()
   {
         $('#add_existing_location').hide();
         $('#existing_location').show();
   })

        
   $('input[name = "interradio"]').on('change',function()
   {
     var i  = $(this).val();
        if (i==1) 
        {
          $('#interview_box').show();
        }
        else
        {
            $('#interview_box').hide();
        }
   })    
        var quesn_count = 0;
        $('#question_field').keypress(function(e){
        if(e.which == 13){
        
        questions  = $('#question_field').val();
        
        if(questions == "")
        {
         return false;
        }
        else{
             drop_options(id="",questions);
              $('#question_field').val("");
            }
        } 
    });
      
         function drop_options(id,questions)
        {
            var duplicate_jd = [];
           $.each($('.drop-options li'),function(index,value)
                        {
                         duplicate_jd.push($.trim($(this).text()).toUpperCase());
                        });
           if(jQuery.inArray($.trim(questions).toUpperCase(), duplicate_jd) != -1) {
                return false;
                    } else {
                     $('#heading_placeholder').hide();$(".drop-options").append('<li  value-id="'+id+'" class="draggable-item"> <i class="fa fa-arrows" aria-hidden="true"></i> ' +questions+ '<span> <a href = "#" class = "remove_this_item"><i class="fa fa-times"></i></a></span> </li>');
                        scroll_checklist();
                        quesn_count++
                        quesn_upt();
                }
        }
        
        function drop_edu(id,qualification)
        {
            duplicate_ed=[];
            $.each($('.quali_drop_options li'),function(index,value)
                        {
                         duplicate_ed.push($.trim($(this).text()).toUpperCase());
                        });
           if(jQuery.inArray($.trim(qualification).toUpperCase(), duplicate_ed) != -1) {
                return false;
                    } else {
                     $('#heading_quali').hide();$(".quali_drop_options").append('<li  value-id="'+id+'" class="draggable-item"> <i class="fa fa-arrows" aria-hidden="true"></i> ' +qualification+ '<span> <a href = "#" class = "remove_this_item"><i class="fa fa-times"></i></a></span> </li>');   
               scroll_qualifications();
              count_edu++;
              edu_counter_set();
                }
       
       }
        
        
        var count_edu = 0;
        $('#quali_field').keypress(function(e){
        if(e.which == 13){
        qualification  = $('#quali_field').val();
        if(qualification == "")
        {
         return false;
        }
        else{
              drop_edu(id="",qualification);
              $('#quali_field').val("");
            }
        } 
    });
        
        $(document).on('click','.drop-options span a', function(event){
		event.preventDefault();
                var btn = $(this);
                var tag = btn.closest("li").remove();
                quesn_count--
                quesn_upt();
	});
        $(document).on('click','.quali_drop_options span a', function(event){
		event.preventDefault();
                var btn = $(this);
                var tag = btn.closest("li").remove();
                count_edu--;
                edu_counter_set();
	});
        
        $(document).on('click','.button-submit',function(event)
            {
            event.preventDefault();
             var url =  $('#submit_form').attr('action');
             var data = $('#submit_form').serialize()+'&n='+session_tok;
                  $.ajax({
                   url: url,
                   type: 'post',
                   data: data,
                   beforeSend: function()
                       {
                         $('#loading_img').addClass('show');
                         $('.button-submit').prop('disabled','disabled');
                         $('.fader').css('display','block');
                       },
                   success: function(data) {
                   if(data == true)
                    {
                    function explode(){
                     $('#loading_img').removeClass('show');
                     $('.button-submit').prop('disabled','');
                     window.location.replace('/account/jobs/dashboard'); 
                     }
                       setTimeout(explode, 3000); 
                     }
                     else {
                     $('#loading_img').removeClass('show');
                     $('.fader').css('display','none');
                     alert('Opps Something Went Wrong..!');
                       }
                    }            
                    });
                });
 
       var skillsdata = null;
       $(document).on('click','.clickable', function(event){
		event.preventDefault();
                skillsdata = $(this).text();
                var value = $(this).attr('data-value');
                addTags(skillsdata,value);
   });
        
 function getTags(){ //Gets array of existing tags
		var alltags = new Array();
		var i = 0;
		$("#shownlist span").each(function( index ) {
  			alltags[i] = $(this).html().substr(0,$(this).html().length - 36);
			i ++;
		});	
		return alltags;
	};
function setTags(){ //Gets string of existing tags separated by commas
		var texttags = getTags();
		var finaltext = "";
		for(var i=0; i<texttags.length; i++){
			if(finaltext == ""){
				finaltext = texttags[i];	
			}
			else{
				finaltext = finaltext + "," + texttags[i];
			}
		}
		return finaltext;
	}
    var count = 0; 
  function addTags(skillsdata,value){
		var tags = skillsdata.trim();
		var listnews = "";
		var newtags = "";
		var existenttags = getTags();
		if(tags.substr(tags.length - 1) == ","){ 
			tags = tags.substr(0, tags.length -1);	
		}
		if(tags.substr(0,1) == ","){
			tags = tags.substr(1, tags.length);	
		}
		if(tags.indexOf(",") !== -1){
			var artags = tags.split(',');	
			for(var i=0; i<artags.length; i++){
				if((artags[i].trim() !== "")&&($.inArray(artags[i].trim(), existenttags) == -1)){
					listnews = listnews + '<span data-value = "'+value+'">'+artags[i].trim()+'<a href="#" class="fa fa-times"></a></span>';
					existenttags.push(artags[i].trim());
                                    count++;
                                    skill_counter();
                                    scroll_skills();
				}
			}
		}
		else{
                    if($.inArray(tags, existenttags) == -1){
	            listnews = '<span data-value = "'+value+'">'+tags+'<a href="#" class="fa fa-times"></a></span>';
                    count++;
                    skill_counter();
                    scroll_skills();
		}
		}
		$("#shownlist").append(listnews);
		$("#inputfield").val("");
	};        
        
$("#inputfield").keypress(function(e){
        if(e.which == 13){
        skillsdata = $('#inputfield').val();
        if(skillsdata == "")
        {
         return false;
        }
        else{
             addTags(skillsdata,value = "");
            }
        } 
    })
$(document).on('click','#shownlist span a', function(event){
		event.preventDefault();
		var btn = $(this);
		var tag = btn.parent().html().toString();
		tag = tag.substr(0,tag.length-20);
		btn.parent().remove();
                count--;
                skill_counter();
	});   
 
 function skill_counter()
        {
           if(count == 0)
               {
                 $('#skill_counter').val("");
               }
           else
           {
           $('#skill_counter').val("1");
          }
        }
         $('#md-checkbox').on('click', ':checkbox', function () {
            if ($(this).is(':checked')) {
                $('#heading_placeholder').hide();
                $(".drop-options").append('<li value-id="' + $(this).attr("id") + '" class="draggable-item"> <i class="fa fa-arrows" aria-hidden="true"></i> ' + $(this).closest("div").find("label").text() + '</li>');
                scroll_checklist();
                quesn_count++
               quesn_upt();
            } else if ($(this).is(':unchecked')) {
              $('.drop-options [value-id = "'+$(this).attr("id")+'"]').remove();
              quesn_count--
              quesn_upt();
            }
        });
        
         $('#quali_list').on('click', ':checkbox', function () {
            if ($(this).is(':checked')) {
                $('#heading_quali').hide();
                $(".quali_drop_options").append('<li value-id="' + $(this).attr("id") + '" class="draggable-item"> <i class="fa fa-arrows" aria-hidden="true"></i> ' + $(this).closest("div").find("label").text() + '</li>');
                scroll_checklist();
               count_edu++;
              edu_counter_set();
            } else if ($(this).is(':unchecked')) {
              $('.quali_drop_options [value-id = "'+$(this).attr("id")+'"]').remove();
              count_edu--;
              edu_counter_set();
            }
        });
        
       $( init );

function init() {
  $( ".droppable-area" ).sortable({
      connectWith: ".connected-sortable",
      stack: '.connected-sortable ul'
    }).disableSelection();
}       
   
     $('#addctc').on('click',function()
         {
        $('#addct').hide();
        $('#ctc').show();     
   }); 
        
    $('.close-ctc').on('click',function()
        {
            $('#ctc').hide();
            $('#addct').show();
       
   });
       function skills_arr()
       {
        var array_val = [];

        $.each($('.placeble-area span'),function(index,value)
        {
        var obj_val = {};
        obj_val = $.trim($(this).text());

        array_val.push(obj_val);
         });
         $('#skillsArray').val(JSON.stringify(array_val));
        };
        
        function placement_arr()
        {
                        var array =[];
                        $.each($("input[name='placement_locations[]']:checked"), function(index,value){
                        var obj = {};
                        obj["id"] = $(this).attr('id');
                        obj["value"] = $(this).next('label').find('.place_no').val();
                        obj["name"] = $(this).attr('data-value');
                        array.push(obj);
                        }); 
              $('#placement_array').val(JSON.stringify(array));     
       }
        function question_process_arr()
        {
                        var process_question_arr =[];
                        $.each($("input[name='questionnaire[]']:checked"),
                        function(index,value){
                        var obj = {};
                        obj["id"] = $(this).attr('id');
                        obj["process_id"] = $(this).closest('.col-md-9').next().find('.selectBox').val();
                        process_question_arr.push(obj);
                        }); 
              $('#question_process').val(JSON.stringify(process_question_arr)); 
                  
       }
   $(document).on('change','input[name="questionnaire[]"]',function(){
        var box;
    if ($(this).is(':checked')) {
        box =  $(this).closest('.col-md-9').next().find('.selectBox');
        box.prop("disabled", false);
        ques_len = $('[name="questionnaire[]"]:checked').length;
        stage_len = $('.selectBox option:selected:not([value=""])').length;
        ques_checker(ques_len,stage_len);
        }
        else if ($(this).is(':unchecked'))
        {
        box =  $(this).closest('.col-md-9').next().find('.selectBox');
        box.prop("disabled", true);
        box.val("");
        ques_len = $('[name="questionnaire[]"]:checked').length;
        stage_len = $('.selectBox option:selected:not([value=""])').length;
        ques_checker(ques_len,stage_len);
        }
   })
   $(document).on('change','.selectBox',function()
   {
     if($(this).val()!=="")
     {
        ques_len = $('[name="questionnaire[]"]:checked').length;
        stage_len = $('.selectBox option:selected:not([value=""])').length;
        ques_checker(ques_len,stage_len);
     }
     else
     {
        ques_len = $('[name="questionnaire[]"]:checked').length;
        stage_len = $('.selectBox option:selected:not([value=""])').length;
        ques_checker(ques_len,stage_len);
     }
    }) 

     function edu_counter_set()
        {
             if(count_edu == 0)
               {
                 $('#qualific_count').val("");
               }
           else
           {
           $('#qualific_count').val("1");
          }
         }
     function quesn_upt()
        {
             if(quesn_count <= 2)
               {
                 $('#desc_count').val("");
               }
           else
           {
           $('#desc_count').val("1");
          }
         }
        
    var FormWizard = function () {
    return {
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }
            var form = $('#submit_form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);
        
            $('#submit_form').validate({
                ignore: ":hidden:not(#jobtitle,#designations)",
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                
                rules: {
                    'questionnaire_selection':
                    {
                        required:true
                    },
                    'benefit_selection':
                    {
                        required:true
                    },
                    'pre_sal': {
                        required: true
                    },
                    'stipendtype': {
                        required: true
                    },
                    'pre_place': {
                        required: true
                    },
                     'minstip': {
                        required: true
                    },
                    'maxstip': {
                        required: true
                    },
                    'stipendpaid': {
                        required: true
                    },
                    'jobtitle': {
                        required: true
                    },
                    'benefit_calc': {
                        required: true
                    },
                    'designations': {
                        required: true
                    },
                    'process_calc': {
                        required: true
                    },
                    'placement_calc': {
                        required: true
                    },
                    'interview_calc': {
                        required: true
                    },
                    'jobtype': {
                        required: true
                    },
                    'primaryfield': {
                      
                       required:true
                    },
                    'pref_inds': {
                      
                       required:true
                    },
                    'gender': {
                       required:true
                    },
                   'skill_counter':
                    {
                      required:true
                    },
                   'qualific_count':
                    {
                      required:true
                    },
                   'desc_count':
                    {
                      required:true
                    },
                    'earliestjoiningdate': {
                        required: true
                    },
                    'salaryinhand': {
                        required: true,
                        
                    },
                    'last_date': {
                        required: true,
                    },
                    'interviewstarttime': {
                        required: true,
                    },
                    'interviewendtime': {
                        required: true,
                    },
                    'ctc': {
                        required: true,
                        
                    },
                    'min_exp': {
                        required: true,
                        
                    },
                    'startdate':
                     {
                       required:true
                       },
                   'enddate':
                   {
                       required:true
                       },
                   'jobdescription':
                    {
                     required:true
                     
                      },
                   'ques_calc':
                    {
                     required:true
                      },
                   
                   'quesradio':
                    {
                     required:true
                      },
        
                   'interradio':
                 {
                 required:true     
                },
                  'fill_quesio_on':
                 {
                 required:true     
                },
        
                },
                messages: { 
                     'questionnaire_selection':
                      {
                       required:'<div class = "color_red">Please Select From the options</div>',
                       },
                     'benefit_selection':
                    {
                        required:'<div class = "color_red">Please Select From the options</div>'
                    },
                    'stipendtype': {
                      
                       required:'<div class = "color_red">Please Select One Option From The List</div>',
                    },
                   'pre_place': {
                      
                       required:'<div class = "color_red">Choose One</div>',
                    },
                    'startdate':
                     {
                       required:'<div class = "color_red">Field Is Required</div>',
                       },
                    'fill_quesio_on':
                     {
                       required:'<div class = "color_red">Please Choose Fill Quesionnaire</div>',
                       },
                       'benefit_calc': {
                        required: '<div class = "color_red">Please Choose Or Add One Benefit</div>',
                    },
                    'ques_calc':
                     {
                       required:'<div class = "color_red">Please Choose atleast One Questionnaire and Process Stage</div>',
                       },
                   'enddate':
                     {
                       required:'<div class = "color_red">Field Is Required</div>',
                       },

                    'process_calc':
                      {
                       required:'<div class = "color_red">Please Choose one Interview process</div>',
                       },
                    'desc_count': { 
                        required:'<div class = "rule-text">Select or add atleast Three Job Descriptions</div>',
                    },
                    'qualific_count': { 
                        required:'<div class = "rule-text">Select or add atleast One Educational Requirments</div>',
                    },
                    'placement_calc': { 
                        required:'<div class = "rule-text">Please Select Atleast One placement Location</div>',
                    },
              'interview_calc': {
                        required: '<div class = "inter_cust_rule">Please Select Atleast One Interview Location</div>',
                    },
             'quesradio':
                    {
                     required:'<div class = "color_red">Please Select From the options</div>'
                     
                      },
             'interradio':
                 {
                 required: '<div class = "rule-text2">Please Select From the options</div>'    
                },
                
                   'skill_counter':
                    {
                      required:'<div class = "rule-text4">Please Add Atleast One Skill</div>',
                    },
                },
                errorPlacement: function (error, element) { 
                    if (element.attr("name") == "salaryinhand") { 
                        error.insertAfter("#salaryinhand");
                    } else if (element.attr("name") == "desc_count") { 
                        error.insertAfter("#error-checkbox-msg");
                    } 
              else if (element.attr("name") == "qualific_count") { 
                        error.insertAfter("#error-edu-msg");
                    } 
              else if (element.attr("name") == "placement_calc") { 
                        error.insertAfter("#place_error");
                    } 
              else if (element.attr("name") == "interview_calc") { 
                        error.insertAfter("#interview_error");
                    } 
            else if (element.attr("name") == "quesradio") { 
                        error.insertAfter("#error-checkbox-msg2");
                    } 
             else if(element.attr("name") == "stipendtype")
               { 
                    error.insertAfter("#radio_rules");
                }
              else if(element.attr("name") == "pre_place")
               { 
                    error.insertAfter("#pre_placement_err");
                }
            else if (element.attr("name") == "ques_calc") { 
                        error.insertAfter("#que_error");
                    } 
        else if (element.attr("name") == "interradio") { 
                        error.insertAfter("#error-checkbox-msg3");
                    }
        else if (element.attr("name") == "process_calc") { 
                        error.insertAfter("#process_err");
                    } 
             else if (element.attr("name") == "benefit_calc") { 
                        error.insertAfter("#b_error");
              } 
        else if(element.attr("name") == "skill_counter")
               { 
                    error.insertAfter("#suggestionbox");
                }
            else if(element.attr("name") == "benefit_selection")
            {
                error.insertAfter("#select_benefit_err");
            } 
        else if(element.attr("name") == "questionnaire_selection")
            {
                error.insertAfter("#select_ques_err");
            } 
                        
            else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success.hide();
                    error.show();
                    App.scrollTo(error, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    if (label.attr("for") == "checkbox[]") { // for checkboxes and radio buttons, no need to show OK icon
                        label
                            .closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove(); // remove error label here
                    } else { // display success icon for other inputs
                        label
                            .addClass('valid') // mark the current input as valid and display OK icon
                        .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    }
                },
            });

            var displayConfirm = function() {
                $('#tab5 .final_confrm', form).each(function(){
                    var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                    if (input.is(":radio")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
                    if (input.is(":text") || input.is("textarea")) {
                        $(this).html(input.val());
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio") && input.is(":checked")) {
                        $(this).html(input.attr("data-title"));
                    } 
                  else if ($(this).attr("data-display") == 'checkbox[]') {
                   var arr_val = [];
                   var checkboxvalues = new Array();
                   $.each($('.drop-options li'),function(index,value)
                    {
                    var object_val = {};
                    object_val = $.trim($(this).text());
                    checkboxvalues.push("&#8728; "+$.trim($(this).text())+"<br>"); 
                    arr_val.push(object_val);
                    });
                    $('#checkbox_array').val(JSON.stringify(arr_val));
                    $('#chackboxvalues').html(checkboxvalues);
                     var arr_quali = new Array();
                     var qualifications_arr = new Array();
                     $.each($('.quali_drop_options li'),function(index,value)
                    {
                    var obj_quali = {};
                    obj_quali = $.trim($(this).text());
                    qualifications_arr.push("&#8728; "+$.trim($(this).text())+"<br>"); 
                    arr_quali.push(obj_quali);
                    });
                     $('#qaulific_array').val(JSON.stringify(arr_quali));
                     $('#education_vals').html(qualifications_arr);
                    
                    }
                  else if($(this).attr("data-display") == 'randomfunc')
                  {
                  var gendr =  $('.gender_radio:checked').next('label').text();
                  $('#gendr_text').html(gendr);
                        skills_arr();
                        placement_arr();
                        question_process_arr();
                   if($('input[name="interradio"]:checked' ).val()== 0)
                   {
                      $('#interviewstarttime').val('');
                      $('#interviewendtime').val('');
                      $('#time1').html('');
                      $('#time2').html('');
                     
                   }
                   var n = "";
                   var possible = "abcdefghijklmnopqrstuvwxyz";
                   for(var i = 0;i < 5; i++)
                    {
                         n += possible.charAt(Math.floor(Math.random()*possible.length));
                    }
                
                var data = $('#submit_form').serialize()+'&n='+session_tok;
                
                    $.ajax({
                         url: '/account/internships/preview', 
                         data:data, 
                         method:'post',
                         success: function(data) {
                            $('.button-preview').attr('href','/internships/internship-preview?data='+session_tok+'');  
                         }
                    });
                }
                 else if($(this).attr("data-display") == 'placement_locations[]' || $(this).attr("data-display") == 'specialskillsrequired' || $(this).attr("data-display") == 'primaryfield' || $(this).attr("data-display") == 'interviewcity[]')
                    {
                      var interviewcitynames = new Array();
                      var getintercity = new Array();
                       $('input[name = "interviewcity[]"]:checked').each(function(){
                          interviewcitynames.push('<span class = "chip">'+ $(this).attr('data-value')+ '</span>');
                          getintercity.push($(this).attr('data-value'));
                    });
                        $('#interviewcitycityvalues').html(interviewcitynames.join(" "));
                        $('#getinterviewcity').val(JSON.stringify(getintercity));
                        var placement_city = new Array();
                        $('input[name = "placement_locations[]"]:checked').each(function(){
                        placement_city.push('<span class = "chip">'+ $(this).attr('data-value')+":"+"("+$(this).next('label').find(".place_no").val()+")"+'</span>');
                  });
                      $('#place_locations').html(placement_city.join(" "));
           
                       var skills_list = getTags();
                       $('#skillvalues').html(skills_list.toString());
                      var skill_data =  getTags();
                      $('#specialskillsrequired').val(skill_data);
                   }
                });
            }
            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                    $('#form_wizard_1').find('.button-preview').show();
                    displayConfirm();
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                    $('#form_wizard_1').find('.button-preview').hide();
                }
                App.scrollTo($('.page-title'));
            }
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    return false;
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    
                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    if (form.valid() == false) {
                        return false;
                    }

                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();
                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: percent + '%'
                    });
                }
            });

            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').click(function () {
               
            }).hide();
        }
    };

}();

jQuery(document).ready(function() {
    FormWizard.init();
});
        
    function scroll_skills() {
        $(".placeble-area").animate({ scrollTop: $('.placeble-area').prop("scrollHeight")}, 1000);
    }

     function scroll_checklist() {
        $("#checkboxlistarea").animate({ scrollTop: $('#checkboxlistarea').prop("scrollHeight")}, 1000);
    }
     function scroll_qualifications() {
        $("#quali_listarea").animate({ scrollTop: $('#quali_listarea').prop("scrollHeight")}, 1000);
    }


var ps = new PerfectScrollbar('#checkboxlistarea');
var ps = new PerfectScrollbar('#quali_listarea');
var ps = new PerfectScrollbar('#md-checkbox');
var ps = new PerfectScrollbar('#quali_list');        
var ps = new PerfectScrollbar('#suggestionbox');        
var ps = new PerfectScrollbar('.placeble-area');
JS;

$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/additional-methods.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/materialized/materialize-tags/css/materialize-tags.css');
$this->registerJsFile('@eyAssets/materialized/materialize-tags/js/materialize-tags.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/gmaps/gmaps.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-ui/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);