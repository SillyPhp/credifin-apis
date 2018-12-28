<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\field\FieldRange;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?= Yii::t('frontend', 'KeySkills And Languages'); ?></h4>
</div>
<?php
$form = ActiveForm::begin([
            'id' => 'Keyskills Form',
            'fieldConfig' => [
                'template' => '<div class="form-group">{input}{error}</div>',
                'labelOptions' => ['class' => ''],
            ]
        ]);
?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($skillsAndLanguagesFormModel, 'keyskills')->textInput(['autocomplete' => 'off', 'placeholder' => $skillsAndLanguagesFormModel->getAttributeLabel('keyskills')]); ?>
       <!--<input type="range" min="0" max="100" value="0"class="slider" id="myRange">-->
        <?= $form->field($skillsAndLanguagesFormModel, 'keyskills')->textInput(['autocomplete' => 'off', 'type' => 'range', 'id' => 'myrange','min' => '0','max' => '100', 'placeholder' => $skillsAndLanguagesFormModel->getAttributeLabel('keyskills')]); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($skillsAndLanguagesFormModel, 'communication')->textInput(['autocomplete' => 'off', 'placeholder' => $skillsAndLanguagesFormModel->getAttributeLabel('communication')]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($skillsAndLanguagesFormModel, 'additionalskills')->textInput(['autocomplete' => 'off', 'placeholder' => $skillsAndLanguagesFormModel->getAttributeLabel('additionalskills')]); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($skillsAndLanguagesFormModel, 'languages')->textInput(['autocomplete' => 'off', 'placeholder' => $skillsAndLanguagesFormModel->getAttributeLabel('languages')]); ?>
    </div>
</div>
<div class="modal-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']); ?>
    <?= Html::button('Close', ['class' => 'btn default', 'data-dismiss' => 'modal']); ?>
</div>
<?php ActiveForm::end(); ?>
<?php
$this->registerCss('
.slidecontainer {
    width: 100%;
    padding-top: 20px;
   text-align: center;
}
.slidecontainer span{text-align: center !important;}
#slide-bar-drag{display: none;}
.slider {
    -webkit-appearance: none;
    width: 100%;
    height: 18px;
    background: #d3d3d3;
    outline: none;
    border-radius: 20px;
    opacity: 0.7;
    -webkit-transition: .2s;
    transition: opacity .2s;
}

.slider:hover {
    opacity: 1;
}

.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 25px;
    background: #00b9ee;
    cursor: pointer;
}

.slider::-moz-range-thumb {
    -moz-appearance: none;
   appearance: none;
   width: 20px;
   height: 25px;
   background: #00b9ee;
   cursor: pointer;
   border:none;
   border-radius:0px; 
}
.slider::-moz-range-track {
 background-color: #d3d3d3;
}    
');
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
