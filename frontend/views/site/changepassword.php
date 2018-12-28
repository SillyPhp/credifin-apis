<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="fa fa-key" aria-hidden="true"></i> <?= Yii::t('frontend', 'Change Password'); ?></h4>
</div>
<?php
$form = ActiveForm::begin([
            'id' => 'user-form',
//            'enableAjaxValidation' => true,
//            'validationUrl' => ['/' . Yii::$app->controller->id . '/' . 'alertsubmit'],
            'fieldConfig' => [
                'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
            ],
        ]);
?>
<div class="modal-body">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?= $form->field($ChangePasswordForm, 'oldpassword')->passwordInput(['autocomplete' => 'off', 'placeholder' => 'Old Password'])->label(false); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?= $form->field($ChangePasswordForm, 'newpassword')->passwordInput(['autocomplete' => 'off', 'placeholder' => 'New Password'])->label(false); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?= $form->field($ChangePasswordForm, 'repeatnewpassword')->passwordInput(['autocomplete' => 'off', 'placeholder' => 'Repeat New Password'])->label(false); ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']); ?>
    <?= Html::button('Cancel', ['class' => 'btn btn-success', 'data-dismiss' => 'modal']); ?>
</div>
<?php ActiveForm::end(); ?>
<?php
$script = <<<JS
$(document).on("submit", "#user-form", function (a) {
    a.preventDefault();
    var data = $('#user-form').serialize();
    var method = $(this).attr('method');
    $.ajax({
      url: "/site/changepass",
      method: method,
      data: data,
      success: function (response) {
           if (response.title == 'Success') {
               toastr.success(response.message, response.title);
               $('#myModal2').modal('hide');
           } else {
               toastr.error(response.message, response.title);
           }

       }
    });
});
        
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
