<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg19.png');
Yii::$app->view->registerJs('var returnUrl = "' . Yii::$app->request->referrer . '"', \yii\web\View::POS_HEAD);
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
$loginForm = ActiveForm::begin([
    'id' => 'login-form',
    'options' => [
        'class' => 'clearfix',
    ],
    'fieldConfig' => [
        'template' => '<div class="row"><div class="col-md-12"><div class="form-group">{input}{error}</div></div></div>',
        'labelOptions' => ['class' => ''],
    ],
]);
?>
<?=
$loginForm->field($loginFormModel, 'username')->textInput([
    'autofocus' => true,
    'autocomplete' => 'off',
    'placeholder' => $loginFormModel->getAttributeLabel('username'),
]);
?>
<?=
$loginForm->field($loginFormModel, 'password')->passwordInput([
    'autocomplete' => 'off',
    'placeholder' => $loginFormModel->getAttributeLabel('password'),
]);
?>
<?= $loginForm->field($loginFormModel, 'referer',['template'=>'{input}'])->hiddenInput()->label(false) ?>
    <div class="flex-data">
        <div class="checkbox m-0">
            <?=
            $loginForm->field($loginFormModel, 'rememberMe', [
                'template' => '{input}{error}',
            ])->checkbox();
            ?>
        </div>
        <div class="clear">
            <a class="text-theme-colored font-weight-600 font-12"
               href="<?= Url::to('/forgot-password'); ?>"><?= Yii::t('frontend', 'Forgot Your Password?'); ?></a>
        </div>
        <div class="form-group m-0 log-b">
            <?= Html::submitButton('Login', ['class' => 'btn main-blue-btn btn-md btn-block m-0 pad-m', 'name' => 'login-button']); ?>
        </div>
    </div>
    <div class="separator pb-10 text-black">
        <span><?= Yii::t('frontend', 'Login With Social Accounts'); ?></span>
    </div>
    <div class="form-group mt-10">
        <?= \yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['site/auth'], 'popupMode' => true,]); ?>
    </div>
    <div class="separator pb-10 text-black">
        <span><?= Yii::t('frontend', 'Or Signup as'); ?></span>
    </div>
    <div class="row pt-20">
        <div class="col-md-6">
            <a class="btn btn-dark btn-lg btn-block no-border hvr-float main-orange-btn"
               href="<?= Url::to('/signup/organization'); ?>"
               data-bg-color="#ff7803"><?= Yii::t('frontend', 'Organization'); ?></a>
        </div>
        <div class="col-md-6">
            <a class="btn btn-dark btn-lg btn-block no-border hvr-float main-orange-btn"
               href="<?= Url::to('/signup/individual'); ?>"
               data-bg-color="#ff7803"><?= Yii::t('frontend', 'Individual'); ?></a>
        </div>
    </div>
<?php ActiveForm::end();
$this->registerCss('
.pad-m{padding: 12px 30px !important;}
.flex-data {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap:wrap;
}
//.flex-data div{flex-basis:50%;}
.clear {
    text-align: right;
}
.auth-clients{
    display: flex !important;
    justify-content: center !important;
    }  
.text-theme-colored {
    color: #202C45 !important;
}
.font-12 {
    font-size: 12px !important;
}
.font-weight-600 {
    font-weight: 600 !important;
}
@media only screen and (max-width: 500px) {
.checkbox.m-0, .clear, .log-b {
    width: 50%;
}
.log-b {
    margin: 0 auto !important;
}
}
');
$script = <<< JS
$(document).on('click','.auth-link',function(e) {
    var url = returnUrl;
    if (url!==""||url==null){
     storeSessionUrl(url);   
    }
})
function storeSessionUrl(url)
{
    $.ajax({
       url:'/auth-status',
       method:'POST',
       data:{url:url},
       success:function(res) {
           if (res.status==200){
            console.log(res.message);   
           }else{
            console.log(res.message);   
           }
       }
    })
}
JS;
$this->registerJs($script);
