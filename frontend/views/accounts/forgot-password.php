<?php
$this->title = Yii::t('frontend', 'Forgot Password');
$this->params['background_image'] = '/assets/themes/ey/images/backgrounds/bg19.png';

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
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
<div class="row">
    <div class="col-md-12 text-center">
        <h4><?= Yii::t('frontend', 'Please enter your email address to request new password.') ?></h4>
    </div>
</div>
<?=
$form->field($model, 'email')->textInput([
    'autocomplete' => 'off',
    'placeholder' => $model->getAttributeLabel('email'),
]);
?>
<div class="form-group pull-right mt-10">
    <?= Html::submitButton('Send', ['class' => 'btn btn-success btn-md btn-block main-blue-btn', 'name' => 'forgot-password-button']); ?>
</div>
<?php ActiveForm::end(); ?>