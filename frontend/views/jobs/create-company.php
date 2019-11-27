<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

    <div class="modal-body">
        <?php
        $form = ActiveForm::begin([
            'id' => 'created-company',
        ]);
        ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($createCompany, 'name')->textInput(['placeholder'=>'Name','id'=>'comp_name'])->label(false); ?>
                <div class="name_error"></div>
            </div>
            <div class="col-md-6">
                <?= $form->field($createCompany, 'email')->textInput(['placeholder'=>'Company Email(Optional)'])->label(false); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($createCompany, 'contact')->textInput(['placeholder'=>'Contact No. (Optional)'])->label(false); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($createCompany, 'website')->textInput(['placeholder'=>'Website (Optional)'])->label(false); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($createCompany, 'type')->dropDownList($b)->label(false); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($createCompany, 'logo')->fileInput()->label(false); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($createCompany, 'description')->textArea(['placeholder'=>'Write Some Company Description(Optional)','rows'=>6])->label(false); ?>
            </div>
        </div>
        <div class="modal-footer">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary save_comp']); ?>
            <?= Html::button('Close', ['class' => 'btn default', 'data-dismiss' => 'modal']); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php
$script = <<< JS
$(document).on('submit','#created-company',function(event) {
    var l_btn = $('.save_comp');
    var name = $('#comp_name').val();
    var email = $('#comp_email').val();
    if (name=='')
        {
            $('.name_error').html('<div class = "s_error">name cannot be blank.</div>');
            return false;
        }
    else 
        {
            $('.name_error').html(' ');
        }
  event.preventDefault();
  event.stopImmediatePropagation();
  var formData = new FormData(this);
  if ( l_btn.data('requestRunning') ) {
            return false;
        }
        
        l_btn.data('requestRunning', true);
        $.ajax({
            url: '/jobs/create-org',
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
               l_btn.html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
               l_btn.attr("disabled","true");
            },
            success: function (response) {
                if (response.status == 'success') {
                    toastr.success(response.message, response.title);
                    $('#modal').modal('hide');
                    $('#search_comp').val(name);
                    $('#email').val(email);
                } else {
                    toastr.error(response.message, response.title);
                    l_btn.html('submit');
                    l_btn.removeAttr("disabled");
                }
            },
            complete: function() {
                l_btn.data('requestRunning', false);
            }
        });
})
JS;
$this->registerCss("
.s_error{
   color: #e73d49;
   font-size: 14px;
}
");
$this->registerJs($script);
