<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-md-12">
        <?php
        $form  = ActiveForm::begin([
            'id' => 'newsletterForm',
            'fieldConfig' => [
                'template' => '<div class="form-group ">{label}{input}{error}</div>',
            ]
        ]);
        ?>
        <div class="sub-newletter">Sign up to our newsletter</div>
        <?=
        $form->field($newsletterForm,'first_name')->textInput([
            'autocomplete' => 'off',
            'placeholder' => $newsletterForm->getAttributeLabel('first_name')
        ])
        ?>
        <?=
        $form->field($newsletterForm,'last_name')->textInput([
            'autocomplete' => 'off',
            'placeholder' => $newsletterForm->getAttributeLabel('last_name')
        ])
        ?>
        <?=
        $form->field($newsletterForm,'email')->textInput([
            'autocomplete' => 'off',
            'placeholder' => $newsletterForm->getAttributeLabel('email')
        ])
        ?>
        <?=
        Html::submitButton('Submit', ['class' => 'btn btn-primary sendFeedback']);
        ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$this->registerCss('
.sub-newletter{
    font-size:20px;
    text-transform:capitalize;
    color:#000;
    padding-bottom:10px;
    font-weight:bold;
}
.sendFeedback{
    margin-top:5px;
    width:100%;
    text-transform: uppercase;
}
form label{
    margin-bottom:0px !important;
    font-size:14px;
    color:#00a0e3;
    
}
.form-control{
    height: 40px !important;
    font-size: 14px !important;
    padding: 6px 10px !important;
    border: none !important;
    box-shadow:0 0 5px rgba(0,0,0,.1) !important;
}
')
?>
