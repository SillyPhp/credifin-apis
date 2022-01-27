<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$location = ArrayHelper::map($locations, 'city_enc_id', 'name');
Yii::$app->view->registerJs('var btn_class = "' . $btn_class . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var application_type = "' . ucwords(Yii::$app->controller->id) . '"', \yii\web\View::POS_HEAD);
if ($applicationType == 'Internships') {
    $appType = 'Internship';
} else{
    $appType = 'Job';
}
?>
    <div class="modal fade bs-modal-lg in" id="modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php $form = ActiveForm::begin(['id' => 'resume_form']); ?>
                <div class="modal-header">
                    <h4 class="modal-title">Fill Out The Details</h4>
                </div>
                <div class="modal-body">
                    <?php if (!empty($location)) {
                        echo '<div class="control-group">' . $form->field($model, 'location_pref')->checkBoxList($location, [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    $return .= '<label class="control control--checkbox" for="2' . $value . '">' . ucwords($label);
                                    $return .= '<input type="checkbox" id="2' . $value . '" name="' . $name . '" value="' . $value . '">';
                                    $return .= '<div class="control__indicator"></div>';
                                    $return .= ' </label>';
                                    return $return;
                                }
                            ])->label('Select Placement Location') . '</div>';
                    } ?>
                    <?= $form->field($model, 'id', ['template' => '{input}'])->hiddenInput(['id' => 'application_id', 'value' => $application_enc_id]); ?>
                    <?= $form->field($model, 'org_id', ['template' => '{input}'])->hiddenInput(['id' => 'organization_id', 'value' => $organization_enc_id]); ?>
                    <?php
                    if ($que) {
                        $ques = 1;
                    } else {
                        $ques = 0;
                    }
                    ?>
                    <?= $form->field($model, 'questionnaire_id', ['template' => '{input}'])->hiddenInput(['id' => 'question_id', 'value' => $ques]); ?>
                </div>
                <div class="modal-footer">
                    <?= Html::submitbutton('Apply', ['class' => 'btn btn-primary sav_job']); ?>
                    <?= Html::button('Close', ['class' => 'btn btn-default skipApplyApp', 'data-dismiss' => 'modal']); ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div class="modal fade bs-modal-lg in" id="resume_modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <?php $form2 = ActiveForm::begin(['id' => 'resume_form2']); ?>
                <div class="modal-header">
                    <h4 class="modal-title">Upload Resume</h4>
                </div>
                <div class="modal-body">
                    <?php
                    if (!empty($resumes)) {
                        $checkList = [0 => 'Use Existing One', 1 => 'Upload New'];
                    } else {
                        $checkList = [1 => 'Upload New'];
                    }
                    ?>
                    <?= '<div class="control-group">' . $form2->field($resumeModel, 'check')->radioList($checkList, [
                        'item' => function ($index, $label, $name, $checked, $value) {
                            $return .= '<label class="control control--radio" for="2' . $value . '">' . ucwords($label);
                            $return .= '<input type="radio" id="2' . $value . '" name="' . $name . '" value="' . $value . '">';
                            $return .= '<div class="control__indicator"></div>';
                            $return .= ' </label>';
                            return $return;
                        }
                    ])->label(false) . '</div>' ?>

                    <div id="new_resume">
                        <?= $form2->field($resumeModel, 'resume_file')->fileInput(['id' => 'resume_file'])->label('Upload Your CV In Doc, Docx,Pdf,Jpg,Jpeg,Png Format Only'); ?>
                    </div>
                    <?php if ($resumes) { ?>
                        <div id="use_existing">
                            <div class="row">
                                <label id="warn" class="col-md-offset-1 col-md-3">Select One</label>
                                <?php foreach ($resumes as $res) {
                                    ?>
                                    <div class="col-md-offset-1 col-md-10">
                                        <div class="radio_questions">
                                            <div class="inputGroup">
                                                <input id="<?= $res['resume_enc_id']; ?>" name="JobAppliedResume[resume_list]"
                                                       type="radio" value="<?= $res['resume_enc_id']; ?>"/>
                                                <label for="<?= $res['resume_enc_id']; ?>"> <?= $res['title']; ?> </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <?= Html::submitbutton('Save', ['class' => 'btn btn-primary sav_resume']); ?>
                    <?= Html::button('Skip', ['class' => 'btn btn-default skipResume']); ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
<input type="hidden" name="appliedAppId" id="appliedAppId"/>
<?php
echo $this->render('/widgets/employer_applications/applied-modal', ['applicationType' => $applicationType]);
$this->registerCss("

/*!
 * custom-checkboxes-radio-buttons-and-select-boxes
 */
.control-group {display: inline-block;vertical-align: top;background: #fff;text-align: left;box-shadow: 0 1px 2px rgba(0,0,0,0.1);padding: 30px;width: 200px;height: 210px;margin: 10px;}.control {display: block;position: relative;padding-left: 30px;margin-bottom: 15px;cursor: pointer;font-size: 18px;}.control input {position: absolute;z-index: -1;opacity: 0;}.control__indicator {position: absolute;top: 2px;left: 0;height: 20px;width: 20px;background: #e6e6e6;}.control--radio .control__indicator {border-radius: 50%;}.control:hover input ~ .control__indicator,.control input:focus ~ .control__indicator {background: #ccc;}.control input:checked ~ .control__indicator {background: #2aa1c0;}.control:hover input:not([disabled]):checked ~ .control__indicator,.control input:checked:focus ~ .control__indicator {background: #0e647d;}.control input:disabled ~ .control__indicator {background: #e6e6e6;opacity: 0.6;pointer-events: none;}.control__indicator:after {content: '';position: absolute;display: none;}.control input:checked ~ .control__indicator:after {display: block;}.control--checkbox .control__indicator:after {left: 8px;top: 4px;width: 3px;height: 8px;border: solid #fff;border-width: 0 2px 2px 0;transform: rotate(45deg);}.control--checkbox input:disabled ~ .control__indicator:after {border-color: #7b7b7b;}.control--radio .control__indicator:after {left: 7px;top: 7px;height: 6px;width: 6px;border-radius: 50%;background: #fff;}.control--radio input:disabled ~ .control__indicator:after {background: #7b7b7b;}.select {position: relative;display: inline-block;margin-bottom: 15px;width: 100%;}.select select {display: inline-block;width: 100%;cursor: pointer;padding: 10px 15px;outline: 0;border: 0;border-radius: 0;background: #e6e6e6;color: #7b7b7b;appearance: none;-webkit-appearance: none;-moz-appearance: none;}.select select::-ms-expand {display: none;}.select select:hover,.select select:focus {color: #000;background: #ccc;}.select select:disabled {opacity: 0.5;pointer-events: none;}.select__arrow {position: absolute;top: 16px;right: 15px;width: 0;height: 0;pointer-events: none;border-style: solid;border-width: 8px 5px 0 5px;border-color: #7b7b7b transparent transparent transparent;}.select select:hover ~ .select__arrow,.select select:focus ~ .select__arrow {border-top-color: #000;}.select select:disabled ~ .select__arrow {border-top-color: #ccc;}
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
        color: #3C454C;
        cursor: pointer;
        position: relative;
        z-index: 2;
        transition: color 1ms ease-out;
        overflow: hidden;
        border-radius: 8px !important;
        line-height: 30px;
        border:1px solid #eee;
    }
    .inputGroup label:before {
      width: 100%;
      height: 10px;
      border-radius: 50%;
      content: '';
      background-color: #00a0e3;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%) scale3d(1, 1, 1);
      transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
      opacity: 0;
      z-index: -1;
    }
    .inputGroup label:after {
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
    }
    .inputGroup input:checked ~ label:before {
      transform: translate(-50%, -50%) scale3d(56, 56, 1);
      opacity: 1;
    }
    .inputGroup input:checked ~ label:after {
      background-color: #54E0C7;
      border-color: #54E0C7;
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
    .has-success .control-label, .has-success.radio-inline label, .has-success .checkbox-inline, .has-success .radio-inline, .has-error .control-label, .has-error.radio-inline label, .has-error .checkbox-inline{
        color:inherit;
    }
    
    label.control-label {
        font-family: roboto;
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 10px;
    }
    .control-group{
        width: 100%;
        box-shadow: none;
        padding: 0;
        height: auto;
        margin: 0;
    }
    .modal-title-change {
        font-family: 'Roboto';
        font-size: 18px;
        font-weight: 500;
    }
    .control {
        margin-bottom:10px;
        display: inline-block;
        margin-right: 20px;
        font-family: roboto;
        font-size: 16px;
        font-weight: 400;
    }
    .control-group > .form-group{
        margin-bottom:0px;
    }
    .control--checkbox .control__indicator:after {
        left: 7.5px;
        top: 4px;
        width: 5px;
        height: 10px;
    }
    .control:hover input:not([disabled]):checked ~ .control__indicator,
        .control input:checked:focus ~ .control__indicator {
          background: #00a0e3;
        }
");
$script = <<< JS
    $(document).on('click', '.skipApplyApp', function (e) {
        $('.' + btn_class + '').html('<i class="fas fa-paper-plane hvr-icon"></i> <span>Apply for $appType</span>');
    });
    $(document).on('click', '.' + btn_class + '', function (e) {
        e.preventDefault();
        if ($('.' + btn_class + '').attr("disabled") == "disabled") {
            return false;
        }
        $('.' + btn_class + '').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
        if ($('input[name="JobApplied[location_pref][]"]').length <= 1) {
            $('input[name="JobApplied[location_pref][]"]').prop('checked', true);
            $('.sav_job').trigger('click');
        } else{
            $('#modal').modal('show');
        }
    });

    $('input[name="JobAppliedResume[check]"]').on('change', function () {
        if ($(this).val() == 1) {
            $('#use_existing').css('display', 'none');
            $('#new_resume').css('display', 'block');
        } else if ($(this).val() == 0) {
            $('#resume_form2').yiiActiveForm('validate', false);
            $('#new_resume').css('display', 'none');
            $('#use_existing').css('display', 'block');
        }
    });

    var que_id = $('#question_id').val();
    $(document).on('click', '.sav_job', function (e) {
        e.preventDefault();
        if ($('input[name="JobApplied[location_pref][]"]').length !== 0) {
            if ($('input[name="JobApplied[location_pref][]"]:checked').length <= 0) {
                $('#resume_form').yiiActiveForm('validateAttribute', 'jobapplied-location_pref');
                return false;
            }
        }
        var formData = new FormData();
        var id = $('#application_id').val();
        var org_id = $('#organization_id').val();
        var loc_array = [];
        if ($('input[name="JobApplied[location_pref][]"]').length !== 0) {
            $("input[name='JobApplied[location_pref][]']:checked").each(function () {
                loc_array.push($(this).val());
            });
        }
        formData.append('application_enc_id', id);
        formData.append('application_type', application_type);
        formData.append('org_id', org_id);
        if ($('#question_id').val() == 1) {
            var status = 'incomplete';
            formData.append('status', status);
        } else {
            var status = 'Pending';
            formData.append('status', status);
        }
        var json_loc = JSON.stringify(loc_array);
        formData.append('json_loc', json_loc);
        ajax_call(formData);
        $('#warn').css('display', 'none');
    });
    $(document).on('click', '.sav_resume', function (e) {
        e.preventDefault();
        if ($('input[name="JobAppliedResume[check]"]:checked').length > 0) {
            if ($('input[name="JobAppliedResume[check]"]:checked').val() == 0) {
                if ($('input[name="JobAppliedResume[resume_list]"]:checked').length == 0) {
                    $('#warn').css('display', 'block');
                    $('input[name="JobAppliedResume[check]"]').focus();
                    return false;
                } else if ($('input[name="JobAppliedResume[resume_list]"]:checked').length > 0) {
                    var formData = new FormData();
                    var id = $('#appliedAppId').val();
                    var org_id = $('#organization_id').val();
                    var check = 1;
                    var resume_enc_id = $('input[name="JobAppliedResume[resume_list]"]').val();
                    formData.append('application_enc_id', id);
                    formData.append('resume_enc_id', resume_enc_id);
                    formData.append('check', check);
                    formData.append('application_type', application_type);
                    formData.append('org_id', org_id);
                    ajax_call2(formData);
                    $('#warn').css('display', 'none');
                }
            } else if ($('input[name="JobAppliedResume[check]"]:checked').val() == 1) {
                if ($('#resume_file').val() != '') {
                    $.each($('#resume_file').prop("files"), function (k, v) {
                        var filename = v['name'];
                        var ext = filename.split('.').pop().toLowerCase();
                        if ($.inArray(ext, ['pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg']) == -1 || v['size'] > 2097152) {
                            return false;
                        } else {
                            var formData = new FormData();
                            var formData = new FormData($('#resume_form2')[0]);
                            var id = $('#appliedAppId').val();
                            var org_id = $('#organization_id').val();
                            formData.append('id', id);
                            formData.append('application_type', application_type);
                            formData.append('org_id', org_id);
                            ajax_call2(formData);
                        }
                    });
                }
            }
        } else {
            $('#resume_form2').yiiActiveForm('validateAttribute', 'jobapplied-check');
            return false;
        }
    });

    function ajax_call(formData) {
        $.ajax({
            url: '/jobs/jobs-apply',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            beforeSend: function () {
                $('.sav_job').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
            },
            success: function (data) {
                $.ajax({
                    url: '/jobs/save-preference-according-to-application',
                    method: 'POST',
                    data: {eaidk:$('#application_id').val(), type:application_type},
                    success: function(response){
                        console.log(response);
                    }
                })
                var res = JSON.parse(data);
                $('#appliedAppId').val(res.aid);
                if (res.status == true && $('#question_id').val() == 1) {
                    // $('#resume_modal').modal('show');
                    applied();
                    swal({
                            title: "Submitted!",
                            text: "Your Application Has been successfully registered But There Are Some Questionnaire Pending From Your Side you can fill them now By clicking below Fill Questionnaire button!",
                            type: "success",
                            showCancelButton: true,
                            confirmButtonClass: "btn-primary",
                            confirmButtonText: "Fill Questionnaire!",
                            cancelButtonText: "Fill Later!",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                window.location.pathname = "/account/dashboard";
                            } else {
                                swal("Please Note!", "Your Application Would not be process further if your don't complete it. To fill it visit your dashboard.", "warning");
                            }
                        });
                } else if (res.status == true) {
                    // $('#resume_modal').modal('show');
                    // $('#appliedModal').modal('show');
                    applied();
                } else {
                    alert('something went wrong..');
                }
            }
        });
    }
    
    function ajax_call2(formData) {
        $.ajax({
            url: '/jobs/jobs-apply-resume',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            beforeSend: function () {
                $('.sav_resume').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
            },
            success: function (data) {
                var res = JSON.parse(data);
                if (res.status == true && $('#question_id').val() == 1) {
                    // $('#resume_modal').modal('show');
                    applied2();
                    swal({
                            title: "Submitted!",
                            text: "Your Application Has been successfully registered But There Are Some Questionnaire Pending From Your Side you can fill them now By clicking below Fill Questionnaire button!",
                            type: "success",
                            showCancelButton: true,
                            confirmButtonClass: "btn-primary",
                            confirmButtonText: "Fill Questionnaire!",
                            cancelButtonText: "Fill Later!",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                window.location.pathname = "/account/dashboard";
                            } else {
                                swal("Please Note!", "Your Application Would not be process further if your don't complete it. To fill it visit your dashboard.", "warning");
                            }
                        });
                } else if (res.status == true) {
                    // $('#resume_modal').modal('show');
                    $('#appliedModal').modal('show');
                    applied2();
                } else {
                    alert('something went wrong..');
                }
            }
        });
    }
    
    $(document).on('click','.skipResume', function() {
        $('#resume_modal').modal('hide');
        $('#appliedModal').modal('show');
    });

    function applied() {
        $('#modal').modal('hide');
        $('.' + btn_class + '').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
        $('.' + btn_class + '').html('<i class = "fas fa-check"></i>Applied');
        $('.' + btn_class + '').attr("disabled", "true");
        $('#resume_modal').modal('show');
    }
    
    function applied2() {
        $('#resume_modal').modal('hide');
        // $('.' + btn_class + '').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
        // $('.' + btn_class + '').html('<i class = "fas fa-check"></i>Applied');
        // $('.' + btn_class + '').attr("disabled", "true");
    }
JS;

$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);