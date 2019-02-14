<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'form-builder',
    'fieldConfig' => [
        'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{error}{hint}</div>",
    ]
]);
?>
<?=
$form->field($model, 'formbuilderdata', [
    'template' => '{input}',
])->hiddenInput(['id' => 'form-value'])->label(false);
?>
    <div class="fade"></div>
    <div class="outer-main">
        <div class="inner-main">

        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="portlet light portlet-fit">
                <div class="portlet-body questionnair-details">
                    <div class="row">
                        <div class="col-md-6 questionnaire-name">
                            <?= $form->field($model, 'formname')->textInput(['class' => 'form-control', 'value' => $fields['questionnaire_name']])->label('Enter name of your questionnaire') ?>
                        </div>
                        <div class="col-md-6 use-questionnaire">
                            <div class="md-checkbox-inline">
                                <label>Where would you like to use this questionnaire ?</label>
                                <?php $model->formusedcategory = json_decode($fields['questionnaire_for']); ?>
                                <?=
                                $form->field($model, 'formusedcategory')->checkBoxList([
                                    '1' => 'Jobs',
                                    '2' => 'Internships',
                                ], [
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        $return = '<div class="md-checkbox">';
                                        $return .= '<input type="checkbox" id="' . $value . $index . '" name="' . $name . '" value="' . $value . '" class="md-check" ' . (($checked) ? 'checked' : '') . '>';
                                        $return .= '<label for="' . $value . $index . '">';
                                        $return .= '<span></span>';
                                        $return .= '<span class="check"></span>';
                                        $return .= '<span class="box"></span> ' . $label . ' </label>';
                                        $return .= '</div>';
                                        return $return;
                                    }
                                ])->label(false);
                                ?>
                                <div id="sticky-anchor"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form_builder">
        <div class="row form-drag-area">
            <div class="col-sm-3 col-md-3">
                <div class="portlet light portlet-fit" id="sticky">
                    <div class="portlet-body field-selections">
                        <nav class="questionnaire-feilds">
                            <ul class="nav">
                                <li class="form_bal_textfield">
                                    <a href="javascript:;"> <i class="fa fa-plus-circle"></i> Text Field</a>
                                </li>
                                <li class="form_bal_textarea">
                                    <a href="javascript:;"><i class="fa fa-plus-circle"></i> Text Area</a>
                                </li>
                                <li class="form_bal_select">
                                    <a href="javascript:;"><i class="fa fa-plus-circle"></i> Select </a>
                                </li>
                                <li class="form_bal_radio">
                                    <a href="javascript:;"><i class="fa fa-plus-circle"></i> Radio Button</a>
                                </li>
                                <li class="form_bal_checkbox">
                                    <a href="javascript:;"><i class="fa fa-plus-circle"></i> Checkbox</a>
                                </li>
                                <li class="form_bal_number">
                                    <a href="javascript:;"><i class="fa fa-plus-circle"></i> Number</a>
                                </li>
                                <li class="form_bal_date">
                                    <a href="javascript:;"><i class="fa fa-plus-circle"></i> Date</a>
                                </li>

                                <li class="form_bal_time">
                                    <a href="javascript:;"><i class="fa fa-plus-circle"></i> Time</a>
                                </li>
                                <li>
                                    <div class="q-btns">  <?= Html::submitButton('Submit', ['class' => 'btn blue custom-buttons2 submit btn-block']); ?></div>
                                </li>
                                <li>
                                    <div class="q-btns">
                                        <button type="button" id="preview" class="btn blue custom-buttons2 btn-block">
                                            Preview
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-9 bal_builder">
                <div class="portlet light portlet-fit">
                    <div class="portlet-body zero-padding">
                        <div id="error_placement"></div>
                        <div class="box_input">
                            <div id="wait"><img
                                        src='http://bestanimations.com/Science/Gears/loadinggears/loading-gear-3-3.gif'
                                        width="100" height="100"/></div>
                            <div class="default-text" id="dragdrop">Drag and Drop the form fields here to create your
                                questionnaire.
                            </div>
                            <div class="form_builder_area">
                                <?php foreach ($fields['questionnaireFields'] as $field) { ?>

                                    <?php
                                    switch ($field['field_type']) {
                                        case 'text':
                                            echo '<div class="li_56430 form_builder_field" style="width: 928.75px; height: 170px;"><div class="all_div"><div class="row li_row"><div class="col-md-6"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="56430"><i class="fa fa-times"></i></button></div><div class="col-md-6"><div class="form-check pull-right"><label class="form-check-label"><input data-field="56430" type="checkbox" class="form-check-input form_input_req" checked="">Required</label></div></div></div></div><hr><div class="row li_row form_output" data-type="text" data-field="56430"><div class="col-md-12"><div class="form-group"><input type="text" name="label_56430" class="form-control form_input_label valid_input" placeholder="Enter Short Question" data-field="56430" value="' . $field['field_label'] . '"></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="placeholder_56430" data-field="56430" class="form-control form_input_placeholder" placeholder="Placeholder"></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name=' . $field['field_name'] . ' class="form-control form_input_name" placeholder="Name" value="text-field_56430"></div></div></div></div>';
                                            break;
                                        case 'textarea':
                                            echo '<div class="li_75717 form_builder_field" style="width: 928.75px; height: 170px;"><div class="all_div"><div class="row li_row"><div class="col-md-6"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="75717"><i class="fa fa-times"></i></button></div><div class="col-md-6"><div class="form-check pull-right"><label class="form-check-label"><input data-field="75717" type="checkbox" class="form-check-input form_input_req" checked="">Required</label></div></div></div></div><hr><div class="row li_row form_output" data-type="textarea" data-field="75717"><div class="col-md-12"><div class="form-group"><input type="text" name="label_75717" class="form-control form_input_label valid_input" placeholder="Long Question" data-field="75717" value="' . $field['field_label'] . '"></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="placeholder_75717" data-field="75717" class="form-control form_input_placeholder" placeholder="Placeholder"></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name=' . $field['field_name'] . ' class="form-control form_input_name" placeholder="Name" value="text-area_75717"></div></div></div></div>';
                                            break;
                                        case 'select':
                                            foreach ($field['questionnaireFieldOptions'] as $options) {
                                                $select_inputs .= '<div data-field="90948" class="row select_row_90948" data-opt="50840"><div class="col-md-4"><div class="form-group"><input type="text" placeholder="Option" class="s_opt form-control valid_input" value = "' . $options['field_option'] . '"></div></div><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_select" data-field="90948"></i></div><div class="col-md-4"><div class="form-group"><input type="hidden" value="Value" class="s_val form-control"></div></div></div>';
                                            }
                                            foreach ($field['questionnaireFieldOptions'] as $options) {
                                                $select .= '<option data-opt="50840" value="Value">' . $options['field_option'] . '</option>';
                                            }
                                            echo '<div class="li_90948 form_builder_field" style="width: 928.75px; height: 253px;"><div class="all_div"><div class="row li_row"><div class="col-md-12"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="90948"><i class="fa fa-times"></i></button></div></div><hr><div class="row li_row form_output" data-type="select" data-field="90948"><div class="col-md-12"><div class="form-group"><input type="text" name="label_90948" class="form-control form_input_label valid_input" placeholder="Dropdown Select Field" data-field="90948" value="' . $field['field_label'] . '"></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="text_90948" class="form-control form_input_name" placeholder="Name" value="name_90948"></div></div><div class="col-md-12"><div class="form-group"><select name="select_90948" class="form-control">' . $select . '</select></div></div></div><div class="row li_row"><div class="col-md-12"><div class="field_extra_info_90948">' . $select_inputs . '</div></div></div></div></div>';
                                            break;
                                        case 'radio':
                                            foreach ($field['questionnaireFieldOptions'] as $options) {
                                                $radio .= '<label class="mt-radio mt-radio-outline"><input data-opt="44842" type="radio" name=' . $field['field_name'] . ' value="Value"><p class="r_opt_name_44842">' . $options['field_option'] . '</p><span></span></label>';
                                            }
                                            foreach ($field['questionnaireFieldOptions'] as $options) {
                                                $radio_inputs .= '<div data-field="90345" class="row radio_row_90345" data-opt="44842"><div class="col-md-4"><div class="form-group"><input type="text" placeholder="Option" class="r_opt form-control valid_input valid" aria-invalid="false" value=' . $options['field_option'] . '></div></div><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_radio" data-field="90345"></i></div><div class="col-md-4"><div class="form-group"><input type="hidden" value="Value" class="r_val form-control"></div></div></div>';
                                            }
                                            echo '<div class="li_90345 form_builder_field" style="width: 928.75px; height: auto;"><div class="all_div"><div class="row li_row"><div class="col-md-12"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="90345"><i class="fa fa-times"></i></button></div></div><hr><div class="row li_row form_output" data-type="radio" data-field="90345"><div class="col-md-12"><div class="form-group"><input type="text" name="label_90345" class="form-control form_input_label valid_input valid" placeholder="Choice Fields" value=' . $field['field_label'] . ' data-field="90345" aria-invalid="false"></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="text_90345" class="form-control form_input_name" placeholder="Name" value=' . $field['field_name'] . '></div></div><div class="col-md-12"><div class="form-group"><div class="mt-radio-list radio_list_90345">' . $radio . '</div></div></div></div><div class="row li_row"><div class="col-md-12"><div class="field_extra_info_90345">' . $radio_inputs . '</div></div></div></div></div>';
                                            break;
                                        case 'checkbox':
                                            foreach ($field['questionnaireFieldOptions'] as $options) {
                                                $checkbox .= '<label class="mt-checkbox mt-checkbox-outline"><input data-opt="54229" type="checkbox" name=' . $field['field_name'] . ' value="Value"> <p class="c_opt_name_54229">' . $options['field_option'] . '</p><span></span></label>';
                                            }
                                            foreach ($field['questionnaireFieldOptions'] as $options) {
                                                $checkbox_inputs .= '<div data-field="12633" class="row checkbox_row_12633" data-opt="54229"><div class="col-md-4"><div class="form-group"><input type="text" placeholder="Option"  class="c_opt form-control valid_input" value=' . $options['field_option'] . '></div></div><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_checkbox" data-field="12633"></i></div><div class="col-md-4"><div class="form-group"><input type="hidden" value="Value" class="c_val form-control"></div></div></div>';
                                            }
                                            echo '<div class="li_12633 form_builder_field" style="width: 928.75px; height: auto;"><div class="all_div"><div class="row li_row"><div class="col-md-12"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="12633"><i class="fa fa-times"></i></button></div></div><hr><div class="row li_row form_output" data-type="checkbox" data-field="12633"><div class="col-md-12"><div class="form-group"><input type="text" name="label_12633" class="form-control form_input_label valid_input" placeholder="Multi Selectbox Field" data-field="12633" value=' . $field['field_label'] . '></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="text_12633" class="form-control form_input_name" placeholder="Name" value="checkbox_12633"></div></div><div class="col-md-12"><div class="form-group"><div class="mt-checkbox-list checkbox_list_12633">' . $checkbox . '</div></div></div></div><div class="row li_row"><div class="col-md-12"><div class="field_extra_info_12633">' . $checkbox_inputs . '</div></div></div></div></div>';
                                            break;
                                        case 'number':
                                            echo '<div class="li_62903 form_builder_field" style="width: 928.75px; height: 170px;"><div class="all_div"><div class="row li_row"><div class="col-md-6"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="62903"><i class="fa fa-times"></i></button></div><div class="col-md-6"><div class="form-check pull-right"><label class="form-check-label"><input data-field="62903" type="checkbox" class="form-check-input form_input_req" checked="">Required</label></div></div></div></div><hr><div class="row li_row form_output" data-type="number" data-field="62903"><div class="col-md-12"><div class="form-group"><input type="text" name="label_62903" class="form-control form_input_label valid_input valid" placeholder="Field Name" data-field="62903" aria-invalid="false" value="' . $field['field_label'] . '"></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="placeholder_62903" data-field="62903" class="form-control form_input_placeholder" placeholder="Placeholder"></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="' . $field['field_name'] . '" class="form-control form_input_name" placeholder="Name" value="number_62903"></div></div></div></div>';
                                            break;
                                        case 'date':
                                            echo '<div class="li_9691 form_builder_field" style="width: 928.75px; height: 155px;"><div class="all_div"><div class="row li_row"><div class="col-md-6"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="9691"><i class="fa fa-times"></i></button></div><div class="col-md-6"><div class="form-check pull-right"><label class="form-check-label"><input data-field="9691" type="checkbox" class="form-check-input form_input_req" checked="">Required</label></div></div></div></div><hr><div class="row li_row form_output" data-type="date" data-field="9691"><div class="col-md-12"><div class="form-group"><input type="text" name="label_9691" class="form-control form_input_label valid_input valid" placeholder="Date Field" data-field="9691" aria-invalid="false" value="' . $field['field_label'] . '"></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="' . $field['field_name'] . '" class="form-control form_input_name" placeholder="Name" value="date-field_9691"></div></div></div></div>';
                                            break;
                                        case 'time':
                                            echo '<div class="li_70745 form_builder_field" style="width: 928.75px; height: 155px;"><div class="all_div"><div class="row li_row"><div class="col-md-6"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="70745"><i class="fa fa-times"></i></button></div><div class="col-md-6"><div class="form-check pull-right"><label class="form-check-label"><input data-field="70745" type="checkbox" class="form-check-input form_input_req" checked="">Required</label></div></div></div></div><hr><div class="row li_row form_output" data-type="time" data-field="70745"><div class="col-md-12"><div class="form-group"><input type="text" name="label_70745" class="form-control form_input_label valid_input valid" placeholder="Time Input" data-field="70745" aria-invalid="false" value="' . $field['field_label'] . '"></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="text_70745" class="form-control form_input_name" placeholder="Name" value="time-field_70745"></div></div></div></div>';
                                            break;
                                    }
                                    ?>

                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="sticky-end"></div>
    </div>
    <input type="hidden" name="totalFields" id="totalFields" value="<?= count($fields['questionnaireFields']); ?>">
<?php ActiveForm::end(); ?>

<?php
$this->registerCss("
.questionnaire-name{
    padding-top:15px;
    padding-left:30px;
}    
.q-btns{
    padding-left:30px;
}    
.field-selections{
    padding-left: 0px !important;
}    
.questionnaire-feilds ul li{
    padding-left:0px;
}
.questionnaire-feilds ul li a{
    border-left:6px solid #00a0e3;
    background-image: linear-gradient(to left, transparent, transparent 50%, #00a0e3 50%, #00a0e3);
    background-position: 100% 0;
    background-size: 200% 100%;
    transition: all .15s ease-in;
}

.questionnaire-feilds ul li a:hover{
    background-position: 0 0;
    color:#fff;
}
.questionnair-details{
    padding-bottom:5px !important;
}    
.use-questionnaire{
    text-align:center !important;
}    
.zero-padding{
    padding:0 !important;
}   
.form_builder .bal_builder{
    padding-right:15px !important;
}
.default-text{
    text-align:center;
    padding-top:10px;
    color:#dbdada;
}       

#wait
  {
    display:none;
    width:100px;
    height:100px;
    
    position:fixed;
    top:50%;
    left:50%;
    padding:2px;
    z-index:99999;
  }

.affix {
    top:70px;
    z-index: 9999 !important;
}
.box_input
{
  border: 4px groove rgba(0, 160, 227, .5);
  margin-top:10px;
}
.form_builder_field {
    padding: 10px 20px !important;
    margin: 10px 0px !important;
}
.box_input{
    min-height: 100vh;
    position: relative;
}
.form_builder_area {
    min-height: 100vh !important;
    position: relative !important;
}

#color_red
{color: #e73d4a;}

.fade{
    position:fixed;
    width:100%;
    height:100%;
    background-color:#000;
    top:0;
    left:0;
    opacity:0.8;
    display:none;
    z-index: 2000;
}
.inner-main{
    width:100%;
    height:100%;
    display:none;
    background-color:#fff;
    color:#000;
    border-radius:10px;
    padding:20px 15px;
    overflow-y:scroll;
}
.outer-main{
    width:60%;
    height:80%;
    top:10%;
    left:20%;
    display: none;
    position: fixed;
    z-index: 2000;
}
@media(min-width : 1500px) {
    .outer-main{
        width: 50%;
        height: 70%;
        top:15%;
        left:25%;
    }
}
#sticky.stick {
    position: fixed;
    top: 80px;
    width: 21%;
}
.portlet-body{
    margin-top: 20px;
}
.stick .portlet-body{
    margin-top:65px;
}
.has-success .md-checkbox label, .has-success.md-checkbox label {
    color: #333 !important;
}

.custom_error
{
border: 1px solid #e73d49;
box-shadow: 0px 0px 5px 0px #e73d49 !important;
}
");

$script = <<<JS
 var count_elem = $('#totalFields').val();
 getPreview();
elem_chk();     
        
   function checkDiv() {
        var dtext = document.querySelector(".form_builder_area");
        if (dtext.innerHTML.length == 0) {
            document.querySelector('#dragdrop').style.display = 'block';
            document.querySelector('.zero-padding').style.dispaly = 'none';
        } else {
            document.querySelector('#dragdrop').style.display = 'none';
        }
   }
        function elem_chk()
        {
            if(count_elem == 0)
            {  
               document.querySelector('#dragdrop').style.display = 'block';
               $('#form-value').val('');
             }
           else
            {
              $('#form-value').val('1');
            }
         }
   
   
    //Form Builder  JS Start Here//
     
    $(".form_bal_textfield").draggable({
        helper: function () {
            return getTextFieldHTML();
            
        },
        connectToSortable: ".form_builder_area"
    });
    $(".form_bal_textarea").draggable({
        helper: function () {
            return getTextAreaFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });
    $(".form_bal_number").draggable({
        helper: function () {
            return getNumberFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });
    $(".form_bal_email").draggable({
        helper: function () {
            return getEmailFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });
    $(".form_bal_date").draggable({
        helper: function () {
            return getDateFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });

    $(".form_bal_time").draggable({
        helper: function () {
            return getTimeFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });

    $(".form_bal_button").draggable({
        helper: function () {
            return getButtonFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });
    $(".form_bal_select").draggable({
        helper: function () {
            return getSelectFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });
    $(".form_bal_radio").draggable({
        helper: function () {
            return getRadioFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });
    $(".form_bal_checkbox").draggable({
        helper: function () {
            return getCheckboxFieldHTML();
        },
        connectToSortable: ".form_builder_area"
    });

    $(".form_builder_area").sortable({
        cursor: 'move',
        placeholder: 'placeholder',
        start: function (e, ui) {
            ui.placeholder.height(ui.helper.outerHeight());
        },
        stop: function (ev, ui) {
            count_elem++;
            elem_chk();
            getPreview();
            checkDiv();
        }
    });
    $(".form_builder_area").disableSelection();

    function getTextFieldHTML() {
        var field = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-6"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="' + field + '"><i class="fa fa-times"></i></button></div><div class="col-md-6"><div class="form-check pull-right"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req" checked>Required</label></div></div></div></div></div><hr/><div class="row li_row form_output" data-type="text" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><input type="text" name="label_' + field + '" class="form-control form_input_label valid_input" placeholder="Enter Short Question" data-field="' + field + '" /></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="placeholder_' + field + '" data-field="' + field + '" class="form-control form_input_placeholder" placeholder="Placeholder" /></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="text_' + field + '" class="form-control form_input_name" placeholder="Name" value = "text-field_' + field + '"/></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getNumberFieldHTML() {
        var field = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-6"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="' + field + '"><i class="fa fa-times"></i></button></div><div class="col-md-6"><div class="form-check pull-right"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req" checked>Required</label></div></div></div></div></div><hr/><div class="row li_row form_output" data-type="number" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><input type="text" name="label_' + field + '" class="form-control form_input_label valid_input" placeholder="Field Name" data-field="' + field + '" /></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="placeholder_' + field + '" data-field="' + field + '" class="form-control form_input_placeholder" placeholder="Placeholder"/></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="text_' + field + '" class="form-control form_input_name" placeholder="Name" value = "number_' + field + '"/></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getEmailFieldHTML() {
        var field = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="' + field + '"><i class="fa fa-times"></i></button></div></div></div><hr/><div class="row li_row form_output" data-type="email" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><input type="text" name="label_' + field + '" class="form-control form_input_label valid_input" placeholder="Field Name" data-field="' + field + '" /></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="placeholder_' + field + '" data-field="' + field + '" class="form-control form_input_placeholder" placeholder="Placeholder"/></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="text_' + field + '" class="form-control form_input_name" placeholder="Name" value = "name_' + field + '"/></div></div><div class="col-md-12"><div class="form-check"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req">Required</label></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getDateFieldHTML() {
        var field = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-6"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="' + field + '"><i class="fa fa-times"></i></button></div><div class="col-md-6"><div class="form-check pull-right"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req" checked>Required</label></div></div></div></div></div><hr/><div class="row li_row form_output" data-type="date" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><input type="text" name="label_' + field + '" class="form-control form_input_label valid_input" placeholder="Date Field" data-field="' + field + '" /></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="text_' + field + '" class="form-control form_input_name" placeholder="Name" value = "date-field_' + field + '"/></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }

    function getTimeFieldHTML() {
        var field = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-6"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="' + field + '"><i class="fa fa-times"></i></button></div><div class="col-md-6"><div class="form-check pull-right"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req" checked>Required</label></div></div></div></div></div><hr/><div class="row li_row form_output" data-type="time" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><input type="text" name="label_' + field + '" class="form-control form_input_label valid_input" placeholder="Time Input" data-field="' + field + '" /></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="text_' + field + '" class="form-control form_input_name" placeholder="Name" value = "time-field_' + field + '" /></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }

    function getTextAreaFieldHTML() {
        var field = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-6"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="' + field + '"><i class="fa fa-times"></i></button></div><div class="col-md-6"><div class="form-check pull-right"><label class="form-check-label"><input data-field="' + field + '" type="checkbox" class="form-check-input form_input_req" checked>Required</label></div></div></div></div></div><hr/><div class="row li_row form_output" data-type="textarea" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><input type="text" name="label_' + field + '" class="form-control form_input_label valid_input" placeholder="Long Question" data-field="' + field + '" /></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="placeholder_' + field + '" data-field="' + field + '" class="form-control form_input_placeholder" placeholder="Placeholder"/></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="text_' + field + '" class="form-control form_input_name" placeholder="Name" value = "text-area_' + field + '"/></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getSelectFieldHTML() {
        var field = generateField();
        var opt1 = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="' + field + '"><i class="fa fa-times"></i></button></div></div><hr/><div class="row li_row form_output" data-type="select" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><input type="text" name="label_' + field + '" class="form-control form_input_label valid_input" placeholder="Dropdown Select Field" data-field="' + field + '" /></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="text_' + field + '" class="form-control form_input_name" placeholder="Name" value = "name_' + field + '"/></div></div><div class="col-md-12"><div class="form-group"><select name="select_' + field + '" class="form-control"><option data-opt="' + opt1 + '" value="Value">Option</option></select></div></div></div><div class="row li_row"><div class="col-md-12"><div class="field_extra_info_' + field + '"><div data-field="' + field + '" class="row select_row_' + field + '" data-opt="' + opt1 + '"><div class="col-md-4"><div class="form-group"><input type="text" placeholder="Option" class="s_opt form-control valid_input" /></div></div><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_select" data-field="' + field + '"></i></div><div class="col-md-4"><div class="form-group"><input type="hidden" value="Value" class="s_val form-control"/></div></div>  </div></div></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getRadioFieldHTML() {
        var field = generateField();
        var opt1 = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="' + field + '"><i class="fa fa-times"></i></button></div></div><hr/><div class="row li_row form_output" data-type="radio" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><input type="text" name="label_' + field + '" class="form-control form_input_label valid_input" placeholder="Choice Fields" data-field="' + field + '" /></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="text_' + field + '" class="form-control form_input_name" placeholder="Name" value = "radio_' + field + '"/></div></div><div class="col-md-12"><div class="form-group"><div class="mt-radio-list radio_list_' + field + '"><label class="mt-radio mt-radio-outline"><input data-opt="' + opt1 + '" type="radio" name="radio_' + field + '" value="Value"> <p class="r_opt_name_' + opt1 + '">Option</p><span></span></label></div></div></div></div><div class="row li_row"><div class="col-md-12"><div class="field_extra_info_' + field + '"><div data-field="' + field + '" class="row radio_row_' + field + '" data-opt="' + opt1 + '"><div class="col-md-4"><div class="form-group"><input type="text" placeholder="Option" class="r_opt form-control valid_input" /></div></div><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_radio" data-field="' + field + '"></i></div><div class="col-md-4"><div class="form-group"><input type="hidden" value="Value" class="r_val form-control"/></div></div></div></div></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
    function getCheckboxFieldHTML() {
        var field = generateField();
        var opt1 = generateField();
        var html = '<div class="all_div"><div class="row li_row"><div class="col-md-12"><button type="button" class="btn btn-primary btn-sm remove_bal_field " data-field="' + field + '"><i class="fa fa-times"></i></button></div></div><hr/><div class="row li_row form_output" data-type="checkbox" data-field="' + field + '"><div class="col-md-12"><div class="form-group"><input type="text" name="label_' + field + '" class="form-control form_input_label valid_input" placeholder="Multi Selectbox Field" data-field="' + field + '" /></div></div><div class="col-md-12"><div class="form-group"><input type="hidden" name="text_' + field + '" class="form-control form_input_name" placeholder="Name" value = "checkbox_' + field + '" /></div></div><div class="col-md-12"><div class="form-group"><div class="mt-checkbox-list checkbox_list_' + field + '"><label class="mt-checkbox mt-checkbox-outline"><input data-opt="' + opt1 + '" type="checkbox" name="checkbox_' + field + '" value="Value"> <p class="c_opt_name_' + opt1 + '">Option</p><span></span></label></div></div></div></div><div class="row li_row"><div class="col-md-12"><div class="field_extra_info_' + field + '"><div data-field="' + field + '" class="row checkbox_row_' + field + '" data-opt="' + opt1 + '"><div class="col-md-4"><div class="form-group"><input type="text" placeholder="Option" class="c_opt form-control valid_input" /></div></div><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_checkbox" data-field="' + field + '"></i></div><div class="col-md-4"><div class="form-group"><input type="hidden" value="Value" class="c_val form-control"/></div></div></div></div></div></div></div>';
        return $('<div>').addClass('li_' + field + ' form_builder_field').html(html);
    }
   
   $(document).on('keypress','.c_opt',function(e)
       {
         if(e.which==13)
         {
           if($(this).val()=="")
           {
            return false;
             }
        else{
            var ref = $(this).closest('.col-md-4').next().find('.add_more_checkbox');
            add_more_check(ref);
            $(this).closest('.col-md-4').parent().next().find('input').focus(); 
            return false;
        }
           }
       })     
   $(document).on('keypress','.r_opt',function(e)
       {
         if(e.which==13)
         {
           if($(this).val()=="")
           {
            return false;
             }
        else{
            var ref = $(this).closest('.col-md-4').next().find('.add_more_radio');
            add_more_radio(ref);
            $(this).closest('.col-md-4').parent().next().find('input').focus(); 
            return false;
        }
           }
       })     
   $(document).on('keypress','.s_opt',function(e)
       {
         if(e.which==13)
         {
         if($(this).val()=="")
           {
            return false;
             }
        else{
            var ref = $(this).closest('.col-md-4').next().find('.add_more_select');
            add_more_select(ref);
            $(this).closest('.col-md-4').parent().next().find('input').focus(); 
            return false;
        }
           }
       })     
    
   function add_more_select(thisObj)
        {
        thisObj.closest('.form_builder_field').css('height', 'auto');
        var field = thisObj.attr('data-field');
        var option = generateField();
        $('.field_extra_info_' + field).append('<div data-field="' + field + '" class="row select_row_' + field + '" data-opt="' + option + '"><div class="col-md-4"><div class="form-group"><input type="text" placeholder="Option" class="s_opt form-control valid_input"/></div></div><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_select" data-field="' + field + '"></i><i class="margin-top-5 margin-left-5 fa fa-times-circle default_red fa-2x remove_more_select" data-field="' + field + '"></i></div><div class="col-md-4"><div class="form-group"><input type="hidden" value="Value" class="s_val form-control"/></div></div></div>');
        var options = '';
        $('.select_row_' + field).each(function () {
            var opt = $(this).find('.s_opt').val();
            var val = $(this).find('.s_val').val();
            var s_opt = $(this).attr('data-opt');
            options += '<option data-opt="' + s_opt + '" value="' + val + '">' + opt + '</option>';
        });
        $('select[name=select_' + field + ']').html(options);
        getPreview();
       }
        
    $(document).on('click', '.add_more_select', function () {
        add_more_select($(this));
    });
    $(document).on('click', '.add_more_radio', function () {
        add_more_radio($(this));
    });
   
        
        function add_more_radio(thisObj)
        {
         thisObj.closest('.form_builder_field').css('height', 'auto');
        var field = thisObj.attr('data-field');
        var option = generateField();
        $('.field_extra_info_' + field).append('<div data-opt="' + option + '" data-field="' + field + '" class="row radio_row_' + field + '"><div class="col-md-4"><div class="form-group"><input type="text" placeholder="Option" class="r_opt form-control valid_input"/></div></div><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_radio" data-field="' + field + '"></i><i class="margin-top-5 margin-left-5 fa fa-times-circle default_red fa-2x remove_more_radio" data-field="' + field + '"></i></div><div class="col-md-4"><div class="form-group"><input type="hidden" value="Value" class="r_val form-control"/></div></div></div>');
        var options = '';
        $('.radio_row_' + field).each(function () {
            var opt = $(this).find('.r_opt').val();
            var val = $(this).find('.r_val').val();
            var s_opt = $(this).attr('data-opt');
            options += '<label class="mt-radio mt-radio-outline"><input data-opt="' + s_opt + '" type="radio" name="radio_' + field + '" value="' + val + '"> <p class="r_opt_name_' + s_opt + '">' + opt + '</p><span></span></label>';
        });
        $('.radio_list_' + field).html(options);
        getPreview();
        }
        
        function add_more_check(thisObj)
        {
        thisObj.closest('.form_builder_field').css('height', 'auto');
        var field = thisObj.attr('data-field');
        var option = generateField();
        $('.field_extra_info_' + field).append('<div data-opt="' + option + '" data-field="' + field + '" class="row checkbox_row_' + field + '"><div class="col-md-4"><div class="form-group"><input type="text" placeholder="Option" class="c_opt form-control valid_input" /></div></div><div class="col-md-4"><i class="margin-top-5 fa fa-plus-circle fa-2x default_blue add_more_checkbox" data-field="' + field + '"></i><i class="margin-top-5 margin-left-5 fa fa-times-circle default_red fa-2x remove_more_checkbox" data-field="' + field + '"></i></div><div class="col-md-4"><div class="form-group"><input type="hidden" value="Value" class="c_val form-control"/></div></div></div>');
        var options = '';
        $('.checkbox_row_' + field).each(function () {
            var opt = $(this).find('.c_opt').val();
            var val = $(this).find('.c_val').val(); 
            var s_opt = $(this).attr('data-opt');
            options += '<label class="mt-checkbox mt-checkbox-outline"><input data-opt="' + s_opt + '" name="checkbox_' + field + '" type="checkbox" value="' + val + '"> <p class="c_opt_name_' + s_opt + '">' + opt + '</p><span></span></label>';
        });
        $('.checkbox_list_' + field).html(options);
        getPreview();
        }
   
    $(document).on('click', '.add_more_checkbox', function () {
       add_more_check($(this));
    });
        
    $(document).on('keyup', '.s_opt', function () {
        var op_val = $(this).val();
        var field = $(this).closest('.row').attr('data-field');
        var option = $(this).closest('.row').attr('data-opt');
        $('select[name=select_' + field + ']').find('option[data-opt=' + option + ']').html(op_val);
        getPreview();
    });
    $(document).on('keyup', '.s_val', function () {
        var op_val = $(this).val();
        var field = $(this).closest('.row').attr('data-field');
        var option = $(this).closest('.row').attr('data-opt');
        $('select[name=select_' + field + ']').find('option[data-opt=' + option + ']').val(op_val);
        getPreview();
    });
    $(document).on('keyup', '.r_opt', function () {
        var op_val = $(this).val();
        var field = $(this).closest('.row').attr('data-field');
        var option = $(this).closest('.row').attr('data-opt');
        $('.radio_list_' + field).find('.r_opt_name_' + option).html(op_val);
        getPreview();
    });
    $(document).on('keyup', '.r_val', function () {
        var op_val = $(this).val();
        var field = $(this).closest('.row').attr('data-field');
        var option = $(this).closest('.row').attr('data-opt');
        $('.radio_list_' + field).find('input[data-opt=' + option + ']').val(op_val);
        getPreview();
    });
    $(document).on('keyup', '.c_opt', function () {
        var op_val = $(this).val();
        var field = $(this).closest('.row').attr('data-field');
        var option = $(this).closest('.row').attr('data-opt');
        $('.checkbox_list_' + field).find('.c_opt_name_' + option).html(op_val);
        getPreview();
    });
    $(document).on('keyup', '.c_val', function () {
        var op_val = $(this).val();
        var field = $(this).closest('.row').attr('data-field');
        var option = $(this).closest('.row').attr('data-opt');
        $('.checkbox_list_' + field).find('input[data-opt=' + option + ']').val(op_val);
        getPreview();
    });
    $(document).on('click', '.edit_bal_textfield', function () {
        var field = $(this).attr('data-field');
        var el = $('.field_extra_info_' + field);
        el.html('<div class="form-group"><input type="text" name="label_' + field + '" class="form-control" placeholder="Enter Text Field Label"/></div><div class="mt-checkbox-list"><label class="mt-checkbox mt-checkbox-outline"><input name="req_' + field + '" type="checkbox" value="1"> Required<span></span></label></div>');
        getPreview();
    });
    $(document).on('click', '.remove_bal_field', function (e) {
        e.preventDefault();
         count_elem--;
            elem_chk();
        var field = $(this).attr('data-field');
        $(this).closest('.li_' + field).hide('400', function () {
            $(this).remove();
            getPreview();
        });
    });
    $(document).on('click', '.remove_more_select', function () {
        var field = $(this).attr('data-field');
        $(this).closest('.select_row_' + field).hide('400', function () {
            $(this).remove();
            var options = '';
            $('.select_row_' + field).each(function () {
                var opt = $(this).find('.s_opt').val();
                var val = $(this).find('.s_val').val();
                var s_opt = $(this).attr('data-opt');
                options += '<option data-opt="' + s_opt + '" value="' + val + '">' + opt + '</option>';
            });
            $('select[name=select_' + field + ']').html(options);
            getPreview();
        });
    });
    $(document).on('click', '.remove_more_radio', function () {
        var field = $(this).attr('data-field');
        $(this).closest('.radio_row_' + field).hide('400', function () {
            $(this).remove();
            var options = '';
            $('.radio_row_' + field).each(function () {
                var opt = $(this).find('.r_opt').val();
                var val = $(this).find('.r_val').val();
                var s_opt = $(this).attr('data-opt');
                options += '<label class="mt-radio mt-radio-outline"><input data-opt="' + s_opt + '" type="radio" name="radio_' + field + '" value="' + val + '"> <p class="r_opt_name_' + s_opt + '">' + opt + '</p><span></span></label>';
            });
            $('.radio_list_' + field).html(options);
            getPreview();
        });
    });
    $(document).on('click', '.remove_more_checkbox', function () {
        var field = $(this).attr('data-field');
        $(this).closest('.checkbox_row_' + field).hide('400', function () {
            $(this).remove();
            var options = '';
            $('.checkbox_row_' + field).each(function () {
                var opt = $(this).find('.c_opt').val();
                var val = $(this).find('.c_val').val();
                var s_opt = $(this).attr('data-opt');
                options += '<label class="mt-checkbox mt-checkbox-outline"><input data-opt="' + s_opt + '" name="checkbox_' + field + '" type="checkbox" value="' + val + '"> <p class="r_opt_name_' + s_opt + '">' + opt + '</p><span></span></label>';
            });
            $('.checkbox_list_' + field).html(options);
            getPreview();
        });
    });
    $(document).on('keyup', '.form_input_button_class', function () {
        getPreview();
    });
    $(document).on('keyup', '.form_input_button_value', function () {
        getPreview();
    });
    $(document).on('change', '.form_input_req', function () {
        getPreview();
    });
    $(document).on('keyup', '.form_input_placeholder', function () {
        getPreview();
    });
    $(document).on('keyup', '.form_input_label', function () {
        getPreview();
    });
    $(document).on('keyup', '.form_input_name', function () {
        getPreview();
    });
    function generateField() {
        return Math.floor(Math.random() * (100000 - 1 + 1) + 57);
    }
        
    function getPreview(plain_html = '') {
        var el = $('.form_builder_area .form_output');
        var html = '';
        var result = [];
        var result2 = [];
        el.each(function () {
            var data_type = $(this).attr('data-type');
            //var field = $(this).attr('data-field');
            var label = $(this).find('.form_input_label').val();
            var name = $(this).find('.form_input_name').val();
            if (data_type === 'text') {
                var placeholder = $(this).find('.form_input_label').val();
                var checkbox = $(this).parent().find('.form-check-input');
                var required = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                }
               
                html += '<div class="form-group"><label class="control-label">' + label + '</label><input type="text" name="' + name + '" placeholder="' + placeholder + '" class="form-control" /></div>';
                var res1 = '<label class="control-label">' + label + '</label><input type="text" name="' + name + '" placeholder="' + placeholder + '" class="form-control" ' + required + '/>';
                result.push(res1);
                var obj1 = {
                    'type': 'text',
                    'label': label,
                    'name': name,
                    'placeholder': placeholder,
                    'required': required
                }
                result2.push(obj1);
            }
            if (data_type === 'number') {
                var placeholder = $(this).find('.form_input_label').val();
                var checkbox = $(this).parent().find('.form-check-input');
                var required = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                }
                html += '<div class="form-group"><label class="control-label">' + label + '</label><input type="number" name="' + name + '" placeholder="' + placeholder + '" class="form-control" /></div>';
                var res2 = '<label class="control-label">' + label + '</label><input type="number" name="' + name + '" placeholder="' + placeholder + '" class="form-control" ' + required + '/>';
                result.push(res2);
                var obj2 = {
                    'type': 'number',
                    'label': label,
                    'name': name,
                    'placeholder': placeholder,
                    'required': required
                }
                result2.push(obj2);
            }
            if (data_type === 'email') {
                var placeholder = $(this).find('.form_input_placeholder').val();
                var checkbox = $(this).parent().find('.form-check-input');
                var required = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                }
                html += '<div class="form-group"><label class="control-label">' + label + '</label><input type="email" name="' + name + '" placeholder="' + placeholder + '" class="form-control" /></div>';
                var res3 = '<label class="control-label">' + label + '</label><input type="email" name="' + name + '" placeholder="' + placeholder + '" class="form-control" ' + required + '/>';
                result.push(res3);
                var obj3 = {
                    'type': 'email',
                    'label': label,
                    'name': name,
                    'placeholder': placeholder,
                    'required': required
                }
                result2.push(obj3);
            }
            if (data_type === 'textarea') {
                var placeholder = $(this).find('.form_input_label').val();
                var checkbox = $(this).parent().find('.form-check-input');
                var required = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                }
                html += '<div class="form-group"><label class="control-label">' + label + '</label><textarea rows="5" name="' + name + '" placeholder="' + placeholder + '" class="form-control" /></div>';
                var res5 = '<label class="control-label">' + label + '</label><textarea rows="5" name="' + name + '" placeholder="' + placeholder + '" class="form-control" ' + required + '/>';
                result.push(res5);
                var obj4 = {
                    'type': 'textarea',
                    'label': label,
                    'name': name,
                    'placeholder': placeholder,
                    'required': required
                }
                result2.push(obj4);
            }
            if (data_type === 'date') {
                var checkbox = $(this).parent().find('.form-check-input');
                var required = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                }
                html += '<div class="form-group"><label class="control-label">' + label + '</label><input type="date" name="' + name + '" class="form-control" /></div>';
                var res6 = '<label class="control-label">' + label + '</label><input type="date" name="' + name + '" class="form-control" ' + required + '/>';
                result.push(res6);
                var obj5 = {
                    'type': 'date',
                    'label': label,
                    'name': name,
                    'required': required
                }
                result2.push(obj5);
            }

            if (data_type === 'time') {
                var checkbox = $(this).parent().find('.form-check-input');
                var required = '';
                if (checkbox.is(':checked')) {
                    required = 'required';
                }
                html += '<div class="form-group"><label class="control-label">' + label + '</label><input type="time" name="' + name + '" value="12:02" class="form-control" /></div>';
                var res12 = '<label class="control-label">' + label + '</label><input type="time" name="' + name + '" class="form-control" ' + required + '/>';
                result.push(res12);
                var obj12 = {
                    'type': 'time',
                    'label': label,
                    'name': name,
                    'required': required
                }
                result2.push(obj12);
            }

            if (data_type === 'select') {
                var option_html = '';
                var options = [];
                $(this).find('select option').each(function () {
                    var option = $(this).html();
                    var value = $(this).val();
                    var arr1 = {
                        'option': option,
                        'value': value
                    };
                    options.push(arr1);
                    option_html += '<option value="' + value + '">' + option + '</option>';
                });
                html += '<div class="form-group"><label class="control-label">' + label + '</label><select class="form-control" name="' + name + '">' + option_html + '</select></div>';
                var res7 = '<label class="control-label">' + label + '</label><select class="form-control" name="' + name + '">' + option_html + '</select>';
                result.push(res7);
                var obj6 = {
                    'type': 'select',
                    'label': label,
                    'name': name,
                    'options': options
                }
                result2.push(obj6);
            }
            if (data_type === 'radio') {
                var option_html = '';
                var options = [];
                $(this).find('.mt-radio').each(function () {
                    var option = $(this).find('p').html();
                    var value = $(this).find('input[type=radio]').val();
                    var arr2 = {
                        'option': option,
                        'value': value
                    };
                    options.push(arr2);
                    option_html += '<div class="form-check"><label class="form-check-label"><input type="radio" class="form-check-input" name="' + name + '" value="' + value + '">' + option + '</label></div>';
                });
                html += '<div class="form-group"><label class="control-label">' + label + '</label>' + option_html + '</div>';
                var res8 = '<label class="control-label">' + label + '</label>' + option_html;
                result.push(res8);
                var obj7 = {
                    'type': 'radio',
                    'label': label,
                    'name': name,
                    'options': options
                }
                result2.push(obj7);
            }
            if (data_type === 'checkbox') {
                var option_html = '';
                var options = [];
                $(this).find('.mt-checkbox').each(function () {
                    var option = $(this).find('p').html();
                    var value = $(this).find('input[type=checkbox]').val();
                    var arr3 = {
                        'option': option,
                        'value': value
                    };
                    options.push(arr3);
                    option_html += '<div class="form-check"><label class="form-check-label"><input type="checkbox" class="form-check-input" name="' + name + '[]" value="' + value + '">' + option + '</label></div>';
                });
                html += '<div class="form-group"><label class="control-label">' + label + '</label>' + option_html + '</div>';
                var res9 = '<label class="control-label">' + label + '</label>' + option_html;
                result.push(res9);
                var obj8 = {
                    'type': 'checkbox',
                    'label': label,
                    'name': name,
                    'options': options
                }
                result2.push(obj8);
            }
        });
        
        if (plain_html === 'html') {
            // $('.preview').hide();
            // $('.plain_html').show().find('textarea').val(html);

            var json_data = JSON.stringify(result2);
             $('#form-value').val(json_data);

        } else {
            $('.plain_html').hide();
            $(document).on('click', '#preview', function () {
                $('.inner-main').html(html).show();
            });
            //$('.preview').html(html).show();
    }
    }
        
    //Form Builder Js End Here//        

    $(function () {
        $('#preview').click(function () {
            $('.fade').fadeIn(500);
            $('.inner-main').fadeIn(1000);
            $('.outer-main').fadeIn(1000);
        });
        $('.fade').click(function () {
            $('.inner-main').fadeOut(1000);
            $('.fade').fadeOut(1000);
            $('.outer-main').fadeOut(1000);
        })
        $(document).bind('keydown', function (e) {
            if (e.which == 27) {
                $('.inner-main').fadeOut(1000);
                $('.fade').fadeOut(1000);
                $('.outer-main').fadeOut(1000);
            }
        });
    });

    function sticky_relocate() {
        var window_top = $(window).scrollTop();
        var footer_top = $("#sticky-end").offset().top;
        var div_top = $('#sticky-anchor').offset().top;
        var div_height = $("#sticky").height();

        var padding = 20;  // tweak here or get from margins etc

        if (window_top + div_height > footer_top - padding)
            $('#sticky').css({top: (window_top + div_height - footer_top + padding) * -1})
        else if (window_top > div_top) {
            $('#sticky').addClass('stick');
            $('#sticky').css({top: 0})
        } else {
            $('#sticky').removeClass('stick');
        }
    }

    $(function () {
        $(window).scroll(sticky_relocate);
        sticky_relocate();
    });
        
    $('#form-builder').validate({
       ignore: ":hidden:not(#form-value)",
       rules: {
                    'formbuilderdata':
                     {
                       required:true,
                     },
        },
                         
        messages: { 
                    'formbuilderdata': { 
                        required:'<div id = "color_red">Please Select Form elements And Drag in Box</div>',
                    },
        },
        
        errorPlacement: function (error, element) { 
                    if (element.attr("name") == "formbuilderdata") { 
                        error.insertAfter("#error_placement");
                    } 
                    } 
   }) ;   
    
    $(document).on('submit', '#form-builder', function(event) {
        event.preventDefault();
        getPreview('html');
        var data = $('#form-builder').serialize();
        var url = $('#form-builder').attr('action');
        $(".valid_input").each(function() {
           if($(this).val() == "")
           {
            $(this).parent().addClass("has-error");
            $(this).focus();
            
           }
        else if($(this).val().length >0)
        {
          $(this).parent().removeClass("has-error");
        }
        });
 if(!$('.has-error').length)
        {
        $.ajax({
        url:url,
        data:data,
        method:'post',
        beforeSend: function()
        {
          $("#wait").css("display", "block");
        },
        success: function(data)
         { 
            $("#wait").css("display", "none");
            if(data == true)
           {
           
             window.location.replace('/account/questionnaire');
            
          }
        else{
             alert('Something went wrong..!!!');
            }

         }
         });
        }
    });
        
    
       
JS;

$this->registerJs($script);
$this->registerCssFile('@root/assets/vendor/form-builder/css/form_builder.css');
$this->registerCssFile('@backendAssets/global/plugins/jquery-ui/jquery-ui.min.css');
$this->registerJsFile('@backendAssets/global/plugins/jquery-ui/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@root/assets/vendor/form-builder/js/tether.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);