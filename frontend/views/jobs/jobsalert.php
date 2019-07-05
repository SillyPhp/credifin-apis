<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><i class="far fa-bell fa-lg"></i> <?= Yii::t('frontend', 'Jobs alert'); ?></h4>
</div>
<?php
$form = ActiveForm::begin([
            'id' => 'user-form',
//            'enableAjaxValidation' => true,
            'validationUrl' => ['/' . Yii::$app->controller->id . '/' . 'alertsubmit'],
            'fieldConfig' => [
                'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
            ],
        ]);
?>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($JobsAlertForm, 'name')->textInput(['autocomplete' => 'off', 'placeholder' => 'Name'])->label(false); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($JobsAlertForm, 'email')->textInput(['autocomplete' => 'off', 'placeholder' => 'Email'])->label(false); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($JobsAlertForm, 'location')->textInput(['autocomplete' => 'off', 'placeholder' => 'Location'])->label(false); ?>
        </div>
        <div class="col-md-6">
            <?=
            $form->field($JobsAlertForm, 'email_frequency')->dropDownList(['1' => 'Daily', '2' => 'Weekly', '3' => 'Fortnightly', '4' => 'Monthly'],['prompt'=>'Email Frequency'])->label(false);
            ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <?= Html::submitButton('Submit', ['class' => 'btn bubbly-button']); ?>
    <?= Html::button('Close', ['class' => 'btn default', 'data-dismiss' => 'modal']); ?>
</div>
<?php ActiveForm::end(); ?>
<?php
$script = <<<JS
var animateButton = function(e) {

//  e.preventDefault;
  //reset animation
  e.target.classList.remove('animate');
  
  e.target.classList.add('animate');
  setTimeout(function(){
    e.target.classList.remove('animate');
  },700);
};

var bubblyButtons = document.getElementsByClassName("bubbly-button");

for (var i = 0; i < bubblyButtons.length; i++) {
  bubblyButtons[i].addEventListener('click', animateButton, false);
}
JS;
$this->registerJs($script);