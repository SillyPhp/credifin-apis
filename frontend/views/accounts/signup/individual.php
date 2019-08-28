<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;

$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg-sign-up.jpg');
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
    'id' => 'user-form',
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
        <div class="col-md-6">
            <?= $form->field($model, 'first_name')->textInput(['class' => 'capitalize form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('first_name')]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'last_name')->textInput(['class' => 'capitalize form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('last_name')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['class' => 'lowercase form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('email')]); ?>
        </div>
        <div class="col-md-6">
            <?=
            $form->field($model, 'phone', ['enableAjaxValidation' => true])->widget(PhoneInput::className(), [
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
        <div class="col-md-12">
            <?= $form->field($model, 'username', ['template' => '<div class="input-group"><span class="input-group-addon">https://empoweryouth.com/</span>{input}</div>{error}', 'enableAjaxValidation' => true])->textInput(['class' => 'lowercase form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('username')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'new_password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('new_password')]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'confirm_password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('confirm_password')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= Html::submitButton('Sign Up', ['class' => 'btn btn-primary btn-lg btn-block mt-15 main-blue-btn', 'name' => 'register-button']); ?>
        </div>
    </div>
    <div class="row pt-20">
        <div class="col-md-12">
            <a class="btn btn-dark btn-lg btn-block no-border hvr-float main-orange-btn" href="/signup/organization"
               data-bg-color="#ff7803"><?= Yii::t('frontend', 'Signup as Organization'); ?></a>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<?php
$this->registerCss('
.intl-tel-input {
    width: 100%;
}
.input-group-addon{
    color: #555 !Important;
    background-color: #eee !Important;
}
');