<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DatePicker;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?= Yii::t('frontend', 'Personal Profile'); ?></h4>
</div>
<?php
$form = ActiveForm::begin([
            'id' => 'Personal-profile-form',
            'fieldConfig' => [
                'template' => '<div class="form-group">{input}{error}</div>',
                'labelOptions' => ['class' => ''],
            ]
        ]);
?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($personalProfileFormModel, 'name')->textInput(['autocomplete' => 'off', 'placeholder' => $personalProfileFormModel->getAttributeLabel('name')]); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($personalProfileFormModel, 'nationality')->textInput(['autocomplete' => 'off', 'placeholder' => $personalProfileFormModel->getAttributeLabel('nationality')]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($personalProfileFormModel, 'email')->textInput(['autocomplete' => 'off', 'placeholder' => $personalProfileFormModel->getAttributeLabel('phone')]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($personalProfileFormModel, 'marital')->textInput(['autocomplete' => 'off', 'placeholder' => $personalProfileFormModel->getAttributeLabel('marital')]); ?>
    </div>
</div>  
<div class="row">
    <div class="col-md-12">
        <?= $form->field($personalProfileFormModel, 'dob')->textInput(['autocomplete' => 'off', 'placeholder' => $personalProfileFormModel->getAttributeLabel('dob')]); ?>
    </div>
</div>   
<div class="row">
    <div class="col-md-12">
        <?= $form->field($personalProfileFormModel, 'phone')->textInput(['autocomplete' => 'off', 'placeholder' => $personalProfileFormModel->getAttributeLabel('phone')]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($personalProfileFormModel, 'aboutme')->textInput(['autocomplete' => 'off', 'placeholder' => $personalProfileFormModel->getAttributeLabel('aboutme')]); ?>
    </div>
</div>
<h4 class="modal-title"><?= Yii::t('frontend', 'Social Links'); ?></h4>
<div class="row">
    <div class="col-md-4">
        <?= $form->field($personalProfileFormModel, 'facebook')->textInput(['autocomplete' => 'off', 'placeholder' => $personalProfileFormModel->getAttributeLabel('facebook')]); ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($personalProfileFormModel, 'twitter')->textInput(['autocomplete' => 'off', 'placeholder' => $personalProfileFormModel->getAttributeLabel('twitter')]); ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($personalProfileFormModel, 'youtube')->textInput(['autocomplete' => 'off', 'placeholder' => $personalProfileFormModel->getAttributeLabel('youtube')]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($personalProfileFormModel, 'linkedin')->textInput(['autocomplete' => 'off', 'placeholder' => $personalProfileFormModel->getAttributeLabel('linkedin')]); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($personalProfileFormModel, 'skype')->textInput(['autocomplete' => 'off', 'placeholder' => $personalProfileFormModel->getAttributeLabel('skype')]); ?>
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
