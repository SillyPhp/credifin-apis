<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DatePicker;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?= Yii::t('frontend', 'Portfolio'); ?></h4>
</div>
<?php
$form = ActiveForm::begin([
            'id' => 'Portfolio Form',
            'fieldConfig' => [
                'template' => '<div class="form-group">{input}{error}</div>',
                'labelOptions' => ['class' => ''],
            ]
        ]);
?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($portfolioFormModel, 'webdesign')->textInput(['autocomplete' => 'off', 'placeholder' => $portfolioFormModel->getAttributeLabel('webdesign')]); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($portfolioFormModel, 'photography')->textInput(['autocomplete' => 'off', 'placeholder' => $portfolioFormModel->getAttributeLabel('photography')]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($portfolioFormModel, 'mobileapp')->textInput(['autocomplete' => 'off', 'placeholder' => $portfolioFormModel->getAttributeLabel('mobileapp')]); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($portfolioFormModel, 'branding')->textInput(['autocomplete' => 'off', 'placeholder' => $portfolioFormModel->getAttributeLabel('branding')]); ?>
    </div>
</div>
<div class="modal-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']); ?>
    <?= Html::button('Close', ['class' => 'btn default', 'data-dismiss' => 'modal']); ?>
</div>
<?php ActiveForm::end(); ?>
<?php
$script = <<<JS
function drp_down(id, data) {
    var selectbox = $('#' + id + '');
    $.each(data, function () {
        selectbox.append($('<option>', { 
            value: this.id,
            text : this.name 
        }));
    });
}     

});
$('#example-component .input-group.date').datepicker();
JS;
$this->registerJs($script);
