<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;

$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg-sign-up.jpg');
$loan_id = null;
$cookies_request = Yii::$app->request->cookies;
$loan_id_ref = $cookies_request->get('loan_id_ref');
if ($loan_id_ref)
{
    $loan_id = $loan_id_ref;
}else{
    if ($loan_ref){
        $loan_id = $loan_id_ref;
    }
}
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
        <div class="col-md-12">
            <legend><?= Yii::t('frontend', 'I Want To Get Hired'); ?></legend>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'first_name')->textInput(['class' => 'capitalize form-control text-capitalize', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('first_name')]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'last_name')->textInput(['class' => 'capitalize form-control text-capitalize', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('last_name')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['class' => 'text-lowercase form-control', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('email')]); ?>
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
<?=$form->field($model,'loan_id_ref',['template'=>'{input}'])->hiddenInput(['id'=>'loan_id_ref','value'=>(($loan_id)?$loan_id:null)]) ?>
<?php ActiveForm::end(); ?>
<div class="col-md-12">
    <div class="separator pb-10">
        <span><?= Yii::t('frontend', 'Login With Social Accounts'); ?></span>
    </div>
    <div class="form-group mt-10">
        <?=
        \yii\authclient\widgets\AuthChoice::widget([ 'baseAuthUrl' => ['site/auth'], 'popupMode' => true, ])
        ?>
    </div>
</div>

<?php
$this->registerCss('
.separator{
    margin:30px auto 5px !important;
}
.auth-clients {
    display: flex;
    /* text-align: center; */
    /* list-style: none; */
    padding: 0;
    /* overflow: auto; */
    justify-content: center;
}
.intl-tel-input, .iti {
    width: 100%;
}
.input-group-addon{
    color: #555 !Important;
    background-color: #eee !Important;
}
.country-list, .iti__country-list{z-index:99 !important;}
');