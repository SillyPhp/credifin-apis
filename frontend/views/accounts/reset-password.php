<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('frontend', 'Reset Password');
$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg19.png');

$form = ActiveForm::begin([
            'id' => 'reset-password',
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
$form->field($model, 'new_password')->passwordInput([
    'autofocus' => true,
    'autocomplete' => 'off',
    'placeholder' => $model->getAttributeLabel('new_password'),
]);
?>
<?=
$form->field($model, 'confirm_password')->passwordInput([
    'autocomplete' => 'off',
    'placeholder' => $model->getAttributeLabel('confirm_password'),
]);
?>

<div class="form-group pull-right mt-10">
    <?= Html::submitButton('Change', ['class' => 'btn btn-success btn-md btn-block', 'name' => 'login-button']); ?>
</div>
<?php ActiveForm::end(); ?>
