<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Invite Candidates for Trainings</h4>
    </div>
<?php $form = ActiveForm::begin([
    'id' => 'invitation_form',
    'fieldConfig' => [
        'template' => "<div class='col-md-6'><div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}{error}</div></div>",
    ]
]);
?>
    <div class="modal-body">
        <div id="invitation-data">
            <?php
            for ($i = 0; $i <= 2; $i++) {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($inviteForm, 'email[]')->textInput(['autocomplete' => false, 'class' => 'invitation_email form-control'])->label('Email'); ?>
                        <?= $form->field($inviteForm, 'name[]')->textInput()->label('Name'); ?>
                        <?php
                        if ($i != 0) {
                            ?>
                            <a href="javascript:;" class="remove-fields"><i class="fa fa-times"></i></a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <a class="add-field pull-right" href="javascript:;">Add <i class="fa fa-plus"></i></a>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?= Html::submitButton('Invite', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end() ?>
<?php
$this->registerCss('
#invitation_form .form-group{
    margin-bottom:5px;
}
#invitation_form .modal-body{
    padding-top:0px;
}
.remove-fields{
    position: absolute;
    top: 25px;
    right: 0px;
    font-size: 15px;
    color: #444;
}
p.i-error {
    position: absolute;
    color: red;
}
');
$script = <<< JS
$(document).on('click','.remove-fields', function(){
    $(this).parent().closest('.row').remove();
});
var elem = 1;
$(document).on('click','.add-field', function(){
    var field = '<div class="row"><div class="col-md-12"><div class="form-group"><div class="col-md-6"><div class="form-group form-md-line-input form-md-floating-label"><input type="text" id="invitecandidatesform-email' + elem + '" class="invitation_email form-control" name="email[]"><label class="control-label" for="invitecandidatesform-email' + elem + '">Email</label><p class="help-block help-block-error"></p></div></div></div><div class="form-group"><div class="col-md-6"><div class="form-group form-md-line-input form-md-floating-label"><input type="text" id="invitecandidatesform-name' + elem + '" class="form-control" name="name[]"><label class="control-label" for="invitecandidatesform-name' + elem + '">Name</label><p class="help-block help-block-error"></p></div></div></div><a href="javascript:;" class="remove-fields"><i class="fa fa-times"></i></a></div></div>';
    $('#invitation-data').append(field);
    elem++;
});
$(document).on('blur', '.invitation_email', function() {
    if($(this).val() !== null && $(this).val() !== "" && !validateEmail($(this).val())){
        $(this).parent().append('<p class="i-error">Invalid Email</p>');
    } else {
        var temp_elem = $(this).parent().children('.i-error');
        if(temp_elem){
            temp_elem.remove();
        }
    }
});
function validateEmail(emailField){
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if (reg.test(emailField) == false) {
        return false;
    }
    return true;
}
$(document).on('submit', '#job_for_colleges', function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    if(valdidate_form){
        var me = $('#submit-cl');
        if ( me.data('requestRunning') ) {
            return false;
        }
        me.data('requestRunning', true);
        var url = '/account/jobs/application-colleges-submit';
        var data = $('#job_for_colleges').serialize();
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            beforeSend: function (){
                $('#submit-cl').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
                $('#submit-cl').prop('disabled', true);
            },
            success: function (response) {
                if (response.status == 200) {
                    toastr.success(response.message, response.title);
                } else {
                    toastr.error(response.message, response.title);
                    $('#submit-cl').prop('disabled', false);
                }
                $('#submit-cl').html('Submit');
            },
            complete: function() {
            me.data('requestRunning', false);
          }
        });
    }
});
JS;

$this->registerJs($script);
