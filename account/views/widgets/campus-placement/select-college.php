<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?= Yii::t('frontend', 'Add Employee'); ?></h4>
    </div>
<?php
$eform = ActiveForm::begin([
    'id' => 'select-college',
    'fieldConfig' => [
        'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}{error}</div>",
    ]
]);
?>
    <div class="row">
        <div class="col-md-6">
            <?= $eform->field($organizationEmployeesForm, 'first_name')->textInput(['class' => 'capitalize form-control']); ?>
        </div>
    </div>
    <div class="modal-footer">
        <?= Html::submitbutton('Submit', ['class' => 'btn btn-primary custom-buttons2 our-team']); ?>
        <?= Html::button('Close', ['class' => 'btn default custom-buttons2', 'data-dismiss' => 'modal']); ?>
    </div>
<?php
ActiveForm::end();
?>
<?php
$this->registerCss('

');
$script = <<< JS

JS;
$this->registerJs($script);