<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?= Yii::t('account', 'Emmployee Benefits'); ?></h4>
</div>
<?php
$form = ActiveForm::begin([
            'id' => 'benefits-form',
            'fieldConfig' => [
                'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
            ]
        ]);
?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($BenefitsModel, 'benefit')->label('<i class="fa fa-building"></i> Employer Benefits'); ?>
    </div>
</div>
<div class="modal-footer">
    <?= Html::submitbutton('Add', ['class' => 'btn btn-primary custom-buttons2 sav_benft']); ?>
    <?= Html::button('Close', ['class' => 'btn default custom-buttons2', 'data-dismiss' => 'modal']); ?>
</div>
<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
    $(document).on('submit', '#benefits-form', function (event) {
        event.stopImmediatePropagation();
        event.preventDefault();
        var url = $(this).attr('action');
        var data = $(this).serialize();
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            beforeSend: function (){
                $('.sav_benft').prop('disabled', 'disabled');
            },
            success: function (response) {
                if (response.status == 'success') {
                    toastr.success(response.message, response.title);
                    $("#benefits-form")[0].reset();
                    $.pjax.reload({container: '#pjax_benefits', async: false});
                } else {
                    toastr.error(response.message, response.title);
                }
                $('#modal').modal('toggle');
            }
        });
    });
JS;
$this->registerJs($script);