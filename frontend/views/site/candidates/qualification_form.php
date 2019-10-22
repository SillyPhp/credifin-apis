<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DatePicker;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?= Yii::t('frontend', 'Qualification'); ?></h4>
</div>
<?php
$form = ActiveForm::begin([
            'id' => 'Qualification-form',
            'fieldConfig' => [
                'template' => '<div class="form-group">{input}{error}</div>',
                'labelOptions' => ['class' => ''],
            ]
        ]);
?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($qualificationFormModel, 'degreename')->textInput(['autocomplete' => 'off', 'placeholder' => $qualificationFormModel->getAttributeLabel('degreename')]); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($qualificationFormModel, 'universityname')->textInput(['autocomplete' => 'off', 'placeholder' => $qualificationFormModel->getAttributeLabel('universityname')]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($qualificationFormModel, 'year')->textInput(['autocomplete' => 'off', 'placeholder' => $qualificationFormModel->getAttributeLabel('year')]); ?>
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
