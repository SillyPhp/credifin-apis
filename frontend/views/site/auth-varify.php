<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg19.png');
?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert" style="border:1px solid #c2cad8;">
                <p>Do You Want To Change This Username Or Keep As It Is ?</p>
                <p>Note: This Will Be Your Empower Youth Username And You Can Use It For Sharing Your Profile To Someone, You Will Not Be Able To Change It Once It Is Set</p>
            </div>
        </div>
    </div>
<?php
$form = ActiveForm::begin([
    'id' => 'form',
    'validationUrl' => Url::toRoute('validate-user'),
    'action' => Url::toRoute('post-credentials'),
]);
?>
<div class="row">
        <div class="col-md-12">
            <?= $form->field($credentialsSetup, 'username', ['template' => '<div class="input-group"><span class="input-group-addon">https://empoweryouth.com/</span>{input}</div>{error}', 'enableAjaxValidation' => true])->textInput(['class' => 'lowercase form-control lwrcase', 'autocomplete' => 'off','value'=>Yii::$app->user->identity->username,'placeholder' => 'Username']); ?>
        </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group pull-right mt-10">
            <?= Html::submitButton('Continue', ['class' => 'btn main-blue-btn btn-md btn-block', 'name' => 'continue']); ?>
        </div>
    </div>
</div>
<?php ActiveForm::end();
$this->registerCss('
.alert p
{
    font-size: 18px;
    font-family: roboto;
    color: #333;
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
.lwrcase{text-transform: lowercase;}
');
