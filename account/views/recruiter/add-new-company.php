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
    'validationUrl'=>'validate-form',
    'fieldConfig' => [
        'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
    ]
]); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model,'username',['enableAjaxValidation' => true]); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model,'organization_name'); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model,'organization_email',['enableAjaxValidation' => true]); ?>
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
    <?= Html::submitButton('Add', ['class' => 'btn btn-primary btn_save_cmpany']) ?>
    <?= Html::button('Close', ['class' => 'btn default custom-buttons2', 'data-dismiss' => 'modal']); ?>
</div>
<?php ActiveForm::end();?>
<?php
$script = <<< JS
 $(document).on('submit', '#company_add_form', function (event) {
  event.preventDefault();
   $.ajax({
    method: "POST",
    url : 'https://sneh.eygb.me/api/v3/companies/create',
    data:$(this).serialize(),
    beforeSend:function()
    {
         $('.btn_save_cmpany').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
    },
    success: function(response) { 
        $('.btn_save_cmpany').html('Add');
          if (response===true)
              {
                   $('#main-modal').modal('toggle');
                  toastr.success('Company Added', 'Success');
              }
          else
              {
                  toastr.error('Server  Error', 'Error'); 
              }
      }
      });  
 });
JS;
$this->registerJs($script);
?>
