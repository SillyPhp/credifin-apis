<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;

$this->title = Yii::t('frontend', 'Organization Signup');
$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg-sign-up.jpg');
$this->params['grid_size'] = 'col-md-8 col-md-push-2';
$organization_types = ArrayHelper::map($organization_types, 'organization_type_enc_id', 'organization_type');
$business_activities = ArrayHelper::map($business_activities, 'business_activity_enc_id', 'business_activity');
$industries = ArrayHelper::map($industries, 'industry_enc_id', 'industry');
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="fa fa-check-circle-o"></i> <?= Yii::t('frontend', 'Thank you!'); ?></h4>
                <?= Yii::$app->session->getFlash('success'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="fa fa-check-circle-o"></i> <?= Yii::t('frontend', 'Error'); ?></h4>
                <?= Yii::$app->session->getFlash('error'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php
$form = ActiveForm::begin([
    'id' => 'organization-form',
    'enableAjaxValidation' => true,
    'options' => [
        'class' => 'clearfix',
    ],
    'fieldConfig' => [
        'template' => '<div class="form-group">{input}{error}</div>',
        'labelOptions' => ['class' => ''],
    ],
]);
?>
    <div class="row">
        <div class="col-md-12">
            <legend><?= Yii::t('frontend', 'Organization Information'); ?></legend>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?=
            $form->field($model, 'organization_type')->dropDownList(
                $organization_types, [
                'prompt' => Yii::t('frontend', 'Type of Organization'),
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'organization_business_activity')->dropDownList(
                $business_activities, [
                'prompt' => Yii::t('frontend', 'Business Activity'),
                'id' => 'ba_drp',
                'onchange' => '
                                    $("#ind_drp").empty().append($("<option>", { 
                                        value: "",
                                        text : "Select Industry" 
                                    }));
                                    $.post(
                                        "' . Url::toRoute("industries/get-industries-by-business-activity") . '", 
                                        {id: $(this).val(),_csrf: $("input[name=_csrf]").val()}, 
                                        function(res){
                                            if(res.status === 200) {
                                                console.log(res);
                                                drp_down("ind_drp", res.industries);
                                                $("#ind_drp").show();
                                            } else {
                                                $("#ind_drp").hide();
                                            }
                                        }
                                    );',
            ])->label(false);
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'organization_industry')->dropDownList(
                [], [
                'prompt' => Yii::t('frontend', 'Industry'),
                'id' => 'ind_drp',
                'style' => 'display: none',
            ])->label(false);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'organization_name')->textInput(['class' => 'capitalize form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('organization_name')]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'organization_email')->textInput(['class' => 'lowercase form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('organization_email')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'organization_website')->textInput(['class' => 'lowercase form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('organization_website')]); ?>
        </div>
        <div class="col-md-6">
            <?=
            $form->field($model, 'organization_phone')->widget(PhoneInput::className(), [
                'jsOptions' => [
                    'allowExtensions' => false,
                    'onlyCountries' => ['in'],
                    'nationalMode' => false,
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'username')->textInput(['class' => 'lowercase form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('username')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'new_password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('password')]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'confirm_password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('confirm_password')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <legend><?= Yii::t('frontend', 'Contact Person Information'); ?></legend>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'first_name')->textInput(['class' => 'capitalize form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('first_name')]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'last_name')->textInput(['class' => 'capitalize form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('last_name')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['class' => 'lowercase form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('email')]); ?>
        </div>
        <div class="col-md-6">
            <?=
            $form->field($model, 'phone')->widget(PhoneInput::className(), [
                'jsOptions' => [
                    'allowExtensions' => false,
                    'onlyCountries' => ['in'],
                    'nationalMode' => false,
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= Html::submitButton('Sign Up', ['class' => 'btn btn-primary btn-lg btn-block mt-15', 'name' => 'register-button']); ?>
        </div>
    </div>
    <div class="row  pt-20">
        <div class="col-md-12">
            <a class="btn btn-dark btn-lg btn-block no-border hvr-float" href="<?= Url::to('/signup/individual'); ?>"
               data-bg-color="#800040"><?= Yii::t('frontend', 'Signup as Individual'); ?></a>
        </div>
    </div>
<?php ActiveForm::end(); ?>

<?php
$this->registerCss('
    .intl-tel-input {
        width: 100%;
}');

$script = <<<JS
    function drp_down(id, data) {
        var selectbox = $('#' + id + '');
        $.each(data, function () {
            selectbox.append($('<option>', {
                value: this.id,
                text: this.name
            }));
        });
    }
JS;
$this->registerJs($script, \yii\web\View::POS_HEAD);