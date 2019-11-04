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
        'template' => "<div class='col-md-4'><div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}{error}</div></div>",
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
                        <?= $form->field($inviteForm, 'phone[]')->textInput(['autocomplete' => false, 'class' => 'invitation_phone form-control'])->label('Phone'); ?>
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
        <?= Html::submitButton('Invite', ['class' => 'btn btn-primary submit-invitations']) ?>
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
    var field = '<div class="row"><div class="col-md-12"><div class="form-group"><div class="col-md-4"><div class="form-group form-md-line-input form-md-floating-label"><input type="text" id="invitecandidatesform-email' + elem + '" class="invitation_email form-control" name="email[]"><label class="control-label" for="invitecandidatesform-email' + elem + '">Email</label><p class="help-block help-block-error"></p></div></div></div><div class="form-group"><div class="col-md-4"><div class="form-group form-md-line-input form-md-floating-label"><input type="text" id="phone' + elem + '" class="invitation_phone form-control" name="phone[]"><label class="control-label" for="phone' + elem + '">Phone</label><p class="help-block help-block-error"></p></div></div></div><div class="form-group"><div class="col-md-4"><div class="form-group form-md-line-input form-md-floating-label"><input type="text" id="invitecandidatesform-name' + elem + '" class="form-control" name="name[]"><label class="control-label" for="invitecandidatesform-name' + elem + '">Name</label><p class="help-block help-block-error"></p></div></div></div><a href="javascript:;" class="remove-fields"><i class="fa fa-times"></i></a></div></div>';
    $('#invitation-data').append(field);
    elem++;
});
$(document).on('blur', '.invitation_email', function() {
    if($(this).val() !== null && $(this).val() !== "" && !validateEmail($(this).val())){
        if(!$(this).parent().children('.i-error').length){
            $(this).parent().append('<p class="i-error">Invalid Email</p>');
        }
        $(this).addClass('has-e-error');
    } else {
        var temp_elem = $(this).parent().children('.i-error');
        if(temp_elem){
            temp_elem.remove();
        }
        if($(this).hasClass('has-e-error')){
            $(this).removeClass('has-e-error');
        }
    }
});
$(document).on('blur', '.invitation_phone', function() {
    if($(this).val() !== null && $(this).val() !== "" && !phonenumber($(this).val())){
        if(!$(this).parent().children('.i-error').length){
            $(this).parent().append('<p class="i-error">Invalid Number</p>');
        }
        $(this).addClass('has-e-error');
    } else {
        var temp_elem = $(this).parent().children('.i-error');
        if(temp_elem){
            temp_elem.remove();
        }
        if($(this).hasClass('has-e-error')){
            $(this).removeClass('has-e-error');
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
function phonenumber(inputtxt){
    var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    if (phoneno.test(inputtxt) == false) {
	   return false;
	}
   return true;
}
$(document).on('submit', '#invitation_form', function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    $('.invitation_email, .invitation_phone').each(function() {
        if($(this).hasClass('has-e-error')){
            return false;
        }
    });
    var me = $('.submit-invitations');
    if ( me.data('requestRunning') ) {
        return false;
    }
    me.data('requestRunning', true);
    var url = '/account/training-program/submit-invitations';
    var data = $('#invitation_form').serialize();
    $.ajax({
        url: url,
        type: 'post',
        data: data,
        beforeSend: function (){
            $('.submit-invitations').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
            $('.submit-invitations').prop('disabled', true);
        },
        success: function (response) {
            if (response.status == 200) {
                toastr.success(response.message, response.title);
                $("#invitation_form")[0].reset();
                $('#modal-load').modal('hide');
            } else {
                toastr.error(response.message, response.title);
                $('.submit-invitations').prop('disabled', false);
            }
            $('.submit-invitations').html('Invite');
        },
        complete: function() {
        me.data('requestRunning', false);
      }
    });
});
JS;

$this->registerJs($script);
