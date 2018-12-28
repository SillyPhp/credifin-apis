<?php
$this->title = Yii::t('dsbedutech', 'Create New Password');
$this->params['background_image'] = '/assets/images/bg/bg19.jpg';

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$createNewPasswordForm = ActiveForm::begin([
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
$createNewPasswordForm->field($createNewPasswordModel, 'new_password')->passwordInput([
    'autofocus' => true,
    'autocomplete' => 'off',
    'placeholder' => $createNewPasswordModel->getAttributeLabel('new_password'),
]);
?>
<?=
$createNewPasswordForm->field($createNewPasswordModel, 'confirm_password')->passwordInput([
    'autocomplete' => 'off',
    'placeholder' => $createNewPasswordModel->getAttributeLabel('confirm_password'),
]);
?>
<div class="form-group pull-right mt-10">
    <?= Html::submitButton('Change Password', ['class' => 'btn btn-success btn-md btn-block', 'name' => 'forgot-password-button']); ?>
</div>
<?php ActiveForm::end(); ?>