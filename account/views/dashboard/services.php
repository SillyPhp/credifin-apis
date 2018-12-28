<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$services = ArrayHelper::map($services, 'service_enc_id', 'name');
?>
<div class="light-box"></div>
<div class="main-outer">
    <div class="main-inner">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'submit_form',
                    'enableClientValidation' => true,
                    'validateOnBlur' => false,
                    'options' => [
                        'class' => 'form',
                    ],
                    'fieldConfig' => [
                        'template' => '{input}',
                        'options' => [
                            'tag' => false,
                        ],
                    ],
        ]);
        ?>
        <h2 class="text-center"><?= Yii::t('account', 'What services would you like to use?'); ?></h2>
        <div class="row">
            <?php
            echo $form->field($model, 'services[]')->inline()->checkBoxList($services, [
                'id' => 'services',
                'item' => function($index, $label, $name, $checked, $value) {
                    $services = [
                        1 => [
                            'description' => 'Some description text here of the title that displays on hover',
                            'icon' => 'job-search-icon.png',
                        ],
                        2 => [
                            'description' => 'Some description text here of the title that displays on hover',
                            'icon' => 'intership.png',
                        ],
                    ];
                    $return = '<div class="col-md-4 col-sm-4"><input type="checkbox" name="' . $name . '" value="' . $value . '" id="services-' . $index . '" class="checkbox-input services" />';
                    $return .= '<label for="services-' . $index . '" class="checkbox-label">';
                    $return .= '<a class="box"><div class="content"><img src="' . Url::to('@eyAssets/images/pages/home/icons/' . $services[$index + 1]['icon']) . '"/>';
                    $return .= '<h3>' . $label . '</h3>';
                    $return .= '<p class="description">' . $services[$index + 1]['description'] . '</p>';
                    $return .= '</div></a></label></div>';
                    return $return;
                }
            ])->label(false);
            ?>
        </div>
        <div style="width: 175px;height: 50px;position: absolute;bottom: 0;right: 5px;text-align:right;">
            <input type="submit" id="sbt" class="btn green btn-circle" style="position: relative;margin-top: 4px;float: right;margin-left: 5px;" value="Save">
        </div>
<?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$this->registerCss("
.box {
    color: #000;
    background-color: #fff;
    display: block;
    width: 100%;
    height: 135px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    font-family: 'Ubuntu', sans-serif;
}
.content {
    position: absolute;
    bottom: 0;
    right: 0;
    top: 0;
    margin: auto;
    text-align:center;
    z-index: 2;
    height: 5.3em;
    transition: all .3s ease;
}
.box:hover .content {
    height: 15em;
    transition: all .3s ease;
}
.content h3{
    margin-top:8px;
}
.content img{
    width:60px;
    height:60px;
}
.box:hover .content h3 {
    color:#000;
    margin-top:30px;
}
.content p {
    height: 0;
    opacity: 0;
    visibility: hidden;
    margin: 5px;
    font-size: 16px;
    line-height: 1.5em;
}
.box:hover p{
    height: 3em;
    opacity: 1;
    visibility: visible;
    transition: all .2s ease;
    color:#000;
}
.box:hover .link {
    transition: all .2s ease;
}
.checkbox-input {
    display: none;
}
.checkbox-label {
    transition: all 0.4s ease;
}
.checkbox-label {
    display: inline-block;
    vertical-align: top;
    position: relative;
    width: 100%;
    cursor: pointer;
    font-weight: 400;
    margin: 5px 0;
    border: 1px solid #d9d9d9;
    border-radius: 2px;
    box-shadow: inset 0 0 0 0 #2196F3;
}
.checkbox-label:before {
    content: '';
    position: absolute;
    top: 75%;
    right: 16px;
    width: 40px;
    height: 40px;
    opacity: 0;
    background-color: #ff8f2d;
    background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
    background-position: 7px 7px;
    background-repeat: no-repeat;
    background-size: 34px;
    border-radius: 50%;
    -webkit-transform: translate(0%, -50%);
    transform: translate(0%, -50%);
    transition: all 0.4s ease;
    z-index:99;
}
.checkbox-input:checked + .checkbox-label {
    box-shadow: inset 0 -12px 0 0 #2196F3;
}
.checkbox-input:checked + .checkbox-label:before {
    top: 0;
    opacity: 1;
}
.checkbox-input:checked + .checkbox-label .checkbox-text {
    -webkit-transform: translate(0, -8px);
    transform: translate(0, -8px);
}
.check_services {
  background-color: #e8e8e8;
  display: block;
  margin: 10px 0;
  position: relative;
      border-radius: 10px;
}
.check_services label {
  padding: 12px 25px;
  width: 100%;
  display: block;
  text-align: left;
  color: #3C454C;
  cursor: pointer;
  position: relative;
  z-index: 2;
  transition: color 200ms ease-in;
  overflow: hidden;
  padding-right:50px;
}
.check_services label:before {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  content: '';
  background-color: #5562eb;
  position: absolute;
  left: 50%;
  top: 50%;
  -webkit-transform: translate(-50%, -50%) scale3d(1, 1, 1);
          transform: translate(-50%, -50%) scale3d(1, 1, 1);
  transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
  opacity: 0;
  z-index: -1;
}
.check_services label:after {
  width: 32px;
  height: 32px;
  content: '';
  border: 2px solid #D1D7DC;
  background-color: #fff;
  background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
  background-repeat: no-repeat;
  background-position: 2px 3px;
  border-radius: 50%;
  z-index: 2;
  position: absolute;
  right: 20px;
  top: 50%;
  -webkit-transform: translateY(-50%);
          transform: translateY(-50%);
  cursor: pointer;
  transition: all 200ms ease-in;
}
.check_services input:checked ~ label {
  color: #fff;
  border-radius: 10px;
}
.check_services input:checked ~ label:before {
  -webkit-transform: translate(-50%, -50%) scale3d(56, 56, 1);
          transform: translate(-50%, -50%) scale3d(56, 56, 1);
  opacity: 1;
}
.check_services input:checked ~ label:after {
  background-color: #54E0C7;
  border-color: #54E0C7;
}
.check_services input {
  width: 32px;
  height: 32px;
  order: 1;
  z-index: 2;
  position: absolute;
  right: 30px;
  top: 50%;
  -webkit-transform: translateY(-50%);
          transform: translateY(-50%);
  cursor: pointer;
  visibility: hidden;
}
@media screen and (min-width: 540px) {
    .checkbox-label {
        width: 100%;
        margin: 25px auto;
    }
}
.form {
    padding: 0 16px;
    max-width: 750px;
    margin: 15px auto;
    font-size: 18px;
    font-weight: 600;
    line-height: 36px;
}
.form h2{
    margin-bottom:15px;
}
.light-box{
    position:fixed;
    width:100%;
    height:100%;
    background-color:#000;
    top:0;
    left:0;
    opacity:0.8;
    display:none;
    z-index: 2000;
}
.main-inner{
    width:100%;
    height:100%;
    display:none;
    background-color: #fff;
    border-radius: 10px;
    position:relative;
}
.main-outer{
    width:60%;
    height:80%;
    top:10%;
    left:20%;
    display: none;
    position: fixed;
    overflow:hidden;
    z-index: 2000;
}
@media(min-width : 1500px) {
    .main-outer{
        width: 50%;
        height: 70%;
        top:15%;
        left:25%;
    }
}
.tab{
    display:none;
}
");
$script = <<<JS

$(function() {
    $('.light-box').fadeIn(500);
    $('.main-inner').fadeIn(1000);
    $('.main-outer').fadeIn(1000);
});
var ps = new PerfectScrollbar('.main-inner');
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
