<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
$this->title = Yii::t('account', 'Quesionnaire Form');
$this->params['grid_size'] = 'col-md-8 col-md-offset-2';
?>

    <div class="col-md-12 set-overlay">
        <div class="row">
            <div class="f-contain">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-heading text-center"><h3>Please answer the following questions.</h3></div>
                    </div>
                </div>

                <div class="form-wrapper">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'quesionnaire-form',
                        'options' => [
                            'class' => 'questionnair-ui',
                        ],
                        'fieldConfig' => [
                            'template' => '{label}{input}{error}',

                        ],
                    ]);
                    ?>
                    <div class="row">
                        <?php
                        foreach ($fields['fields'] as $field) { ?>
                            <div class="col-md-12">
                                <?php
                                echo $this->render('/widgets/forms/questionnaire/' . $field['field_type'], [
                                    'model' => $model,
                                    'form' => $form,
                                    'field' => $field,
                                ]);
                                ?>
                            </div>

                            <?php
                        }
                        ?>
                        <div class="col-md-12 sub-bttn">
                            <?= Html::submitButton('Submit',['class'=>'btn submit-bttn sav_ques']) ?>
                        </div>

                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
body  {
    background-image: url( ' . Url::to("@eyAssets/images/backgrounds/lco.png") . ' );
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
}
.sub-bttn{
    text-align:center;
}
.submit-bttn{
    background: #00a0e3;
    padding: 8px 18px;
    color: #ffffff !important;
    font-family: Open Sans;
    font-size: 13px;
    text-decoration: none;
    border-radius: 5px !important;
}
.submit-bttn:hover {
    -webkit-border-radius: 8px !important;
    -moz-border-radius: 8px !important;
    -ms-border-radius: 8px !important;
    -o-border-radius: 8px !important;
    border-radius: 8px !important;
    color: #ffffff;
    box-shadow: 0 0 10px rgba(0,0,0,.5) !important;
    text-decoration: none;
    transition: .3s all;
    -webkit-transition: .3s all;
    -moz-transition: .3s all;
    -ms-transition: .3s all;
    -o-transition: .3s all;
}
.layer-overlay.overlay-white-9::before {
    background-color: rgba(255, 255, 255, 0.49);
}
#home {
    padding-bottom: 100px;
}
.set-overlay{
    background-color: #ffffffd9;
    padding: 30px 30px 40px;
    box-shadow: 0px 0px 16px 6px #b3b3b399;
    border-radius: 6px;
}
input[type="text"], select{
    border-radius:5px !important;
}
form label{
    margin-bottom:0px;
}
label{
    text-transform: capitalize;
    font-size: 16px;
    font-weight: 600;
}
.main-heading h3{
    margin:0px;
    text-transform:uppercase;
    color:#00a0e3;
}
.separator{
    width:auto;
}
.form-group  label { 
    font-weight: 500;
}
.form-group{
    margin-bottom: 25px;
}
.form-wrapper{
    padding: 25px 20px 0px;
}
.md-checkbox label>.box{
    border: 2px solid #c2cad8;
}
//.datepicker>div{
//    display:block;
//}
');
$this->registerCssFile('@backendAssets/global/css/components-rounded.min.css');
