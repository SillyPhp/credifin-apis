<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use borales\extensions\phoneInput\PhoneInput;
?>
<div class="modal-header">
    <span class="org-info">Organization Information</span>
</div>
<?php $form = ActiveForm::begin([
    'id' => 'company_add_form',
    'fieldConfig' => [
        'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
    ],
]); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model,'username'); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model,'organization_name'); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model,'organization_email'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model,'organization_website')->textInput(['class' => 'lowercase form-control']); ?>
        </div>
        <div class="col-md-6">
            <?=
            $form->field($model, 'organization_phone', ['enableAjaxValidation' => true])->widget(PhoneInput::className(), [
                'jsOptions' => [
                    'allowExtensions' => false,
                    'preferredCountries' => ['in'],
                    'nationalMode' => false,
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 padd">
            <?= $form->field($model,'description'); ?>
            <?= $form->field($model, 'created_by', ['template' => '{input}'])->hiddenInput(['id' => 'hidden_created_by','value'=>Yii::$app->user->identity->user_enc_id])->label(false); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 align">
<!--            <div class="form-group">-->
<!--                <ul class="ks-cboxtags">-->
<!--                    <li class="service-list">-->
<!--                        <input type="checkbox" id="services" class="checkbox-input services"/>-->
<!--                        <label for="services">-->
<!--                            Jobs-->
<!--                        </label>-->
<!--                    </li>-->
<!--                    <li class="service-list">-->
<!--                        <input type="checkbox" id="services2" class="checkbox-input services"/>-->
<!--                        <label for="services2">-->
<!--                            Internships-->
<!--                        </label>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
        </div>
    </div>
<div class="modal-footer">
    <?= Html::button('Save', ['class' => 'btn btn-primary btn_save_cmpany']) ?>
    <?= Html::button('Close', ['class' => 'btn default custom-buttons2', 'data-dismiss' => 'modal']); ?>
</div>
<?php ActiveForm::end();?>
<?php
$script = <<< JS
 $(document).on('submit', '#company_add_form', function (e) {
     e.preventDefault();
    console.log(1); 
 });
JS;

?>
