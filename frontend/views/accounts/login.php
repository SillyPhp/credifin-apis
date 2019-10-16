<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg19.png');

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
    <div class="checkbox pull-left mt-15">
        <?=
        $loginForm->field($loginFormModel, 'rememberMe', [
            'template' => '{input}{error}',
        ])->checkbox();
        ?>
    </div>
    <div class="form-group pull-right mt-10">
        <?= Html::submitButton('Login', ['class' => 'btn main-blue-btn btn-md btn-block', 'name' => 'login-button']); ?>
    </div>
    <div class="clear text-center pt-10">
        <a class="text-theme-colored font-weight-600 font-12"
           href="<?= Url::to('/forgot-password'); ?>"><?= Yii::t('frontend', 'Forgot Your Password?'); ?></a>
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
.text-theme-colored {
    color: #202C45 !important;
}
.font-12 {
    font-size: 12px !important;
}
.font-weight-600 {
    font-weight: 600 !important;
}
');
