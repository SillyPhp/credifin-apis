<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

//$location = ArrayHelper::map($locations, 'city_enc_id', 'name');
//Yii::$app->view->registerJs('var btn_class = "' . $btn_class . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var application_resume_type = "' . ucwords(Yii::$app->controller->id) . '"', \yii\web\View::POS_HEAD);
//if ($applicationType == 'Internships') {
//    $appType = 'Internship';
//} else{
//    $appType = 'Job';
//}
?>

<!--    <div class="modal fade bs-modal-lg in" id="resume_modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">-->
<!--        <div class="modal-dialog modal-lg">-->
<!--            <div class="modal-content">-->
                <?php $form2 = ActiveForm::begin(['id' => 'app_resume_form2']); ?>
                <div class="modal-header">
                    <h4 class="modal-title">Upload Resume</h4>
                </div>
                <div class="modal-body multiAppList">
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

                    <div id="new_resume_multi_app">
                        <?= $form2->field($resumeModel, 'resume_file')->fileInput(['id' => 'resume_fileMultiApp'])->label('Upload Your CV In Doc, Docx,Pdf,Jpg,Jpeg,Png Format Only'); ?>
                    </div>
                    <?php if ($resumes) { ?>
                        <div id="use_existingApp">
                            <div class="row">
                                <label id="warnApp" class="col-md-offset-1 col-md-3">Select One</label>
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
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--<input type="hidden" name="appliedAppIdC" id="appliedAppIdC"/>-->
<?php
//echo $this->render('/widgets/employer_applications/applied-modal', ['applicationType' => $applicationType]);

$script = <<< JS
    // $(document).on('click', '.skipApplyApp', function (e) {
    //     $('.' + btn_class + '').html('<i class="fas fa-paper-plane hvr-icon"></i> <span>Apply for appType</span>');
    // });

    $('.multiAppList input[name="JobAppliedResume[check]"]').on('change', function () {
        if ($(this).val() == 1) {
            $('#use_existingApp').css('display', 'none');
            $('#new_resume_multi_app').css('display', 'block');
        } else if ($(this).val() == 0) {
            $('#app_resume_form2').yiiActiveForm('validate', false);
            $('#new_resume_multi_app').css('display', 'none');
            $('#use_existingApp').css('display', 'block');
        }
    });

    $(document).on('click', '.sav_resume', function (e) {
        e.preventDefault();
        if ($('.multiAppList input[name="JobAppliedResume[check]"]:checked').length > 0) {
            if ($('.multiAppList input[name="JobAppliedResume[check]"]:checked').val() == 0) {
                if ($('.multiAppList input[name="JobAppliedResume[resume_list]"]:checked').length == 0) {
                    $('#warnApp').css('display', 'block');
                    $('.multiAppList input[name="JobAppliedResume[check]"]').focus();
                    return false;
                } else if ($('.multiAppList input[name="JobAppliedResume[resume_list]"]:checked').length > 0) {
                    var formData = new FormData();
                    var id = $('#appliedAppIdC').val();
                    var org_id = $('#app_organization_id').val();
                    var check = 1;
                    var resume_enc_id = $('.multiAppList input[name="JobAppliedResume[resume_list]"]').val();
                    formData.append('application_enc_id', id);
                    formData.append('resume_enc_id', resume_enc_id);
                    formData.append('check', check);
                    formData.append('application_type', application_resume_type);
                    formData.append('org_id', org_id);
                    app_ajax_call2(formData);
                    $('#warnApp').css('display', 'none');
                }
            } else if ($('.multiAppList input[name="JobAppliedResume[check]"]:checked').val() == 1) {
                if ($('#resume_fileMultiApp').val() != '') {
                    $.each($('#resume_fileMultiApp').prop("files"), function (k, v) {
                        var filename = v['name'];
                        var ext = filename.split('.').pop().toLowerCase();
                        if ($.inArray(ext, ['pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg']) == -1 || v['size'] > 2097152) {
                            return false;
                        } else {
                            var formData = new FormData();
                            var formData = new FormData($('#app_resume_form2')[0]);
                            var id = $('#appliedAppIdC').val();
                            var org_id = $('#app_organization_id').val();
                            formData.append('id', id);
                            formData.append('application_type', application_resume_type);
                            formData.append('org_id', org_id);
                            app_ajax_call2(formData);
                        }
                    });
                }
            }
        } else {
            $('#app_resume_form2').yiiActiveForm('validateAttribute', 'jobapplied-check');
            return false;
        }
    });
    
    function app_ajax_call2(formData) {
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
                    app_applied2();
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
                    $('.applied-modal-common-apps').css('display', 'none');
                    $('#applied-modal-common-$applicationType-app').css('display', 'inline-block');
                    app_applied2();
                } else {
                    alert('something went wrong..');
                }
            }
        });
    }
    
    $(document).on('click','.skipResume', function() {
        $('#job-resume-widget-modal').modal('hide');
        $('#appliedModal').modal('show');
        $('.applied-modal-common-apps').css('display', 'none');
        $('#applied-modal-common-$applicationType-app').css('display', 'inline-block');
    });
    function app_applied2() {
        $('#job-resume-widget-modal').modal('hide');
        // $('.' + btn_class + '').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
        // $('.' + btn_class + '').html('<i class = "fas fa-check"></i>Applied');
        // $('.' + btn_class + '').attr("disabled", "true");
    }
JS;
$this->registerJs($script);