<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DatePicker;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?= Yii::t('frontend', 'Work Experience'); ?></h4>
</div>
<?php
$form = ActiveForm::begin([
            'id' => 'Expierence-form',
            'fieldConfig' => [
                'template' => '{input}{error}',
                'labelOptions' => ['class' => ''],
            ]
        ]);
?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($workExperienceFormModel, 'companyname')->textInput(['autocomplete' => 'off', 'placeholder' => $workExperienceFormModel->getAttributeLabel('companyname')]); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($workExperienceFormModel, 'city')->textInput(['autocomplete' => 'off', 'placeholder' => $workExperienceFormModel->getAttributeLabel('city')]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div id="example-component">
            <!-- Datepicker Markup -->
            <div class="input-group date">
                <input type="text" class="form-control date-picker" value="12-02-2012">
                <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <?=
        $form->field($workExperienceFormModel, 'to')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'to'],
            'readonly' => true,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-M-yyyy',
                'name' => 'earliestjoiningdate',
                'todayHighlight' => true,
                'startDate' => '+0d',
        ]]);
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($workExperienceFormModel, 'title')->textInput(['autocomplete' => 'off', 'placeholder' => $workExperienceFormModel->getAttributeLabel('title')]); ?>
    </div>
</div>  
<div class="row">
    <div class="col-md-12">
        <?= $form->field($workExperienceFormModel, 'description')->textInput(['autocomplete' => 'off', 'placeholder' => $workExperienceFormModel->getAttributeLabel('description')]); ?>
    </div>
</div>   
<div class="row">
    <div class="col-md-12">
        <?= $form->field($workExperienceFormModel, 'portfolio')->textInput(['autocomplete' => 'off', 'placeholder' => $workExperienceFormModel->getAttributeLabel('portfolio')]); ?>
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
