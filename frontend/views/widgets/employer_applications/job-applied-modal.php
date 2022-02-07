<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$location = ArrayHelper::map($locations, 'city_enc_id', 'name');
Yii::$app->view->registerJs('var btn_class = "' . $application_enc_id.'-apply-now"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var application_type = "' . ucwords(Yii::$app->controller->id) . '"', \yii\web\View::POS_HEAD);
if ($applicationType == 'Internships') {
    $appType = 'Internship';
} else{
    $appType = 'Job';
}
?>

<?php $form = ActiveForm::begin(['id' => 'app_resume_form']); ?>
    <div class="modal-header">
        <h4 class="modal-title modal-title-change">Enter Details</h4>
    </div>
    <div class="modal-body">
        <?php if (!empty($location)) {
            echo '<div class="control-group appFieldsAll">'.$form->field($model, 'location_pref')->checkBoxList($location,[
                'item' => function($index, $label, $name, $checked, $value) {
                    $return .= '<label class="control control--checkbox" for="1' . $value . '">' .ucwords($label);
                    $return .= '<input type="checkbox" id="1' . $value . '" name="' . $name . '" value="' . $value . '">';
                    $return .= '<div class="control__indicator"></div>';
                    $return .=  ' </label>';
                    return $return;
                }
            ])->label('Select Placement Location') . '</div>';
        } ?>
        <?= $form->field($model, 'id', ['template' => '{input}'])->hiddenInput(['id' => 'app_application_id', 'value' => $application_enc_id]); ?>
        <?= $form->field($model, 'org_id', ['template' => '{input}'])->hiddenInput(['id' => 'app_organization_id', 'value' => $organization_enc_id]); ?>
        <?php
        if ($que) {
            $ques = 1;
        } else {
            $ques = 0;
        }
        ?>
        <?= $form->field($model, 'questionnaire_id', ['template' => '{input}'])->hiddenInput(['id' => 'app_question_id', 'value' => $ques]); ?>
    </div>
    <div class="modal-footer">
        <?= Html::submitbutton('Apply', ['class' => 'btn btn-primary '.$application_enc_id.'-applyApp']); ?>
        <?= Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
    </div>
<?php ActiveForm::end(); ?>
<input type="hidden" name="appliedAppIdC" id="appliedAppIdC"/>
<?php
//echo $this->render('/widgets/employer_applications/applied-modal', ['applicationType' => $applicationType]);
$this->registerCss("

/*!
 * custom-checkboxes-radio-buttons-and-select-boxes
 */
.control-group {display: inline-block;vertical-align: top;background: #fff;text-align: left;box-shadow: 0 1px 2px rgba(0,0,0,0.1);padding: 30px;width: 200px;height: 210px;margin: 10px;}.control {display: block;position: relative;padding-left: 30px;margin-bottom: 15px;cursor: pointer;font-size: 18px;}.control input {position: absolute;z-index: -1;opacity: 0;}.control__indicator {position: absolute;top: 2px;left: 0;height: 20px;width: 20px;background: #e6e6e6;}.control--radio .control__indicator {border-radius: 50%;}.control:hover input ~ .control__indicator,.control input:focus ~ .control__indicator {background: #ccc;}.control input:checked ~ .control__indicator {background: #2aa1c0;}.control:hover input:not([disabled]):checked ~ .control__indicator,.control input:checked:focus ~ .control__indicator {background: #0e647d;}.control input:disabled ~ .control__indicator {background: #e6e6e6;opacity: 0.6;pointer-events: none;}.control__indicator:after {content: '';position: absolute;display: none;}.control input:checked ~ .control__indicator:after {display: block;}.control--checkbox .control__indicator:after {left: 8px;top: 4px;width: 3px;height: 8px;border: solid #fff;border-width: 0 2px 2px 0;transform: rotate(45deg);}.control--checkbox input:disabled ~ .control__indicator:after {border-color: #7b7b7b;}.control--radio .control__indicator:after {left: 7px;top: 7px;height: 6px;width: 6px;border-radius: 50%;background: #fff;}.control--radio input:disabled ~ .control__indicator:after {background: #7b7b7b;}.select {position: relative;display: inline-block;margin-bottom: 15px;width: 100%;}.select select {display: inline-block;width: 100%;cursor: pointer;padding: 10px 15px;outline: 0;border: 0;border-radius: 0;background: #e6e6e6;color: #7b7b7b;appearance: none;-webkit-appearance: none;-moz-appearance: none;}.select select::-ms-expand {display: none;}.select select:hover,.select select:focus {color: #000;background: #ccc;}.select select:disabled {opacity: 0.5;pointer-events: none;}.select__arrow {position: absolute;top: 16px;right: 15px;width: 0;height: 0;pointer-events: none;border-style: solid;border-width: 8px 5px 0 5px;border-color: #7b7b7b transparent transparent transparent;}.select select:hover ~ .select__arrow,.select select:focus ~ .select__arrow {border-top-color: #000;}.select select:disabled ~ .select__arrow {border-top-color: #ccc;}
#app_new_resume,#app_use_existing, #new_resume_multi_app, #use_existingApp{
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

    // $('.appFieldsAll input[name="JobApplied[check]"]').on('change', function () {
    //     if ($(this).val() == 1) {
    //         $('#app_use_existing').css('display', 'none');
    //         $('#app_new_resume').css('display', 'block');
    //     } else if ($(this).val() == 0) {
    //         $('#app_resume_form').yiiActiveForm('validate', false);
    //         $('#app_new_resume').css('display', 'none');
    //         $('#app_use_existing').css('display', 'block');
    //     }
    // });

    var que_id = $('#app_question_id').val();
    $(document).on('click', '.$application_enc_id-applyApp', function (e) {
        e.preventDefault();
        if ($('.appFieldsAll input[name="JobApplied[location_pref][]"]').length !== 0) {
            if ($('.appFieldsAll input[name="JobApplied[location_pref][]"]:checked').length <= 0) {
                $('#app_resume_form').yiiActiveForm('validateAttribute', 'jobapplied-location_pref');
                return false;
            }
        }
        var formData = new FormData();
        var id = $('#app_application_id').val();
        var org_id = $('#app_organization_id').val();
        var loc_array = [];
        if ($('.appFieldsAll input[name="JobApplied[location_pref][]"]').length !== 0) {
            $(".appFieldsAll input[name='JobApplied[location_pref][]']:checked").each(function () {
                loc_array.push($(this).val());
            });
        }
        formData.append('application_enc_id', id);
        formData.append('application_type', application_type);
        formData.append('org_id', org_id);
        if ($('#app_question_id').val() == 1) {
            var status = 'incomplete';
            formData.append('status', status);
        } else {
            var status = 'Pending';
            formData.append('status', status);
        }
        var json_loc = JSON.stringify(loc_array);
        formData.append('json_loc', json_loc);
        app_ajax_call(formData);
        $('#app_warn').css('display', 'none');
    });

    function app_ajax_call(formData) {
        $.ajax({
            url: '/jobs/jobs-apply',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            beforeSend: function () {
                $('.$application_enc_id-applyApp').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
            },
            success: function (data) {
                var res = JSON.parse(data);
                $('#appliedAppIdC').val(res.aid);
                $.ajax({
                    url: '/jobs/save-preference-according-to-application',
                    method: 'POST',
                    data: {eaidk:$('#app_application_id').val(), type:application_type, appliedId:res.aid},
                    success: function(response){
                        console.log(response);
                    }
                })
                if (res.status == true && $('#app_question_id').val() == 1) {
                    app_applied();
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
                    // $('#appliedModal').modal('show');
                    app_applied();
                } else {
                    alert('something went wrong..');
                }
            }
        });
    }

    function app_applied() {
        $('#job-apply-widget-modal').modal('hide');
        $('.' + btn_class + '').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
        $('.' + btn_class + '').html('<i class="fas fa-check"></i>Applied');
        $('.' + btn_class + '').attr("disabled", "true");
        // $('#job-resume-widget-modal').modal('show');
        $('#appResumeModalData').html('<div class="p-20"><i class="fas fa-circle-notch fa-spin fa-fw"></i> Loading...</div>')
        let app_type = '$applicationType';
        $('#job-resume-widget-modal').modal('show');
         $.ajax({
                method: "POST",
                url : "/jobs/application-apply-resume-modal",
                data:{applicationType:app_type},
                success: function(response) {
                    $('#appResumeModalData').html(response);
                }
        })
    }
    
    $('.' + btn_class + '').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');    
   if ($('.appFieldsAll input[name="JobApplied[location_pref][]"]').length <= 1) {
       $('.appFieldsAll input[name="JobApplied[location_pref][]"]').prop('checked', true);
       $('.$application_enc_id-applyApp').trigger('click');
   }
JS;

$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);