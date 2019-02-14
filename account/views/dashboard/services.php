<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$services = ArrayHelper::map($services, 'service_enc_id', 'name');
?>
    <div class="light-box"></div>
    <div class="main-outer">
        <div class="main-inner">
            <h2 class="lightbox-title text-center"><?= Yii::t('account', 'What services would you like to access?'); ?></h2>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'submit_form',
                        'enableClientValidation' => true,
                        'validateOnBlur' => false,
                        'options' => [
                            'class' => 'form',
                        ],
                        'fieldConfig' => [
                            'template' => '{input}{error}',
                            'options' => [
                                'tag' => false,
                            ],
                        ],
                    ]);
                    ?>
                    <div class="row">
                        <?php
                        echo $form->field($model, 'services[]')->inline()->checkBoxList($services, [
                            'id' => 'services',
                            'item' => function ($index, $label, $name, $checked, $value) {
                                $services = [
                                    1 => [
                                        'icon' => 'job-search-icon.png',
                                    ],
                                    2 => [
                                        'icon' => 'intership.png',
                                    ],
                                ];
                                $return = '<div class="col-md-6 col-sm-6"><input type="checkbox" name="' . $name . '" value="' . $value . '" id="services-' . $index . '" class="checkbox-input services" />';
                                $return .= '<label for="services-' . $index . '" class="checkbox-label">';
                                $return .= '<a class="box"><div class="content"><img src="' . Url::to('@eyAssets/images/pages/home/icons/' . $services[$index + 1]['icon']) . '"/>';
                                $return .= '<h3>' . $label . '</h3>';
                                $return .= '</div></a></label></div>';
                                return $return;
                            }
                        ])->label(false);
                        ?>
                    </div>
                    <div style="text-align:center;margin-top: 20px;">
                        <input type="submit" id="sbt" class="btn custom-buttons2 btn-primary" value="Save">
                    </div>
                    <div class="error"></div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss("
.error{
    color:red;
    font-size: 15px;
    text-align: center;
    display: none;
}
#sbt{
    padding: 8px 15px !important;
}
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
    left:0;
    margin: auto;
    text-align:center;
    z-index: 2;
    height: 5.3em;
    transition: all .3s ease;
}
.content h3{
    margin-top:8px;
}
.content img{
    width:60px;
    height:60px;
}
.box:hover .content {
    transform: scale(1.1);
    color:rgb(0, 0, 0);
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
    border-radius: 2px;
    box-shadow: 0px 0px 10px 0px #dddd;
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
    box-shadow:0px 0px 10px 5px #efefef;
}
.checkbox-input:checked + .checkbox-label:before {
    top: 0;
    opacity: 1;
}
.checkbox-input:checked + .checkbox-label .checkbox-text {
    -webkit-transform: translate(0, -8px);
    transform: translate(0, -8px);
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
.lightbox-title{
    margin-bottom:15px;
    font-weight: 500;
    font-size: 26px;
    color: #444;
    border-bottom: 1px solid #ddd;
    padding-bottom: 20px;
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
    width:50%;
    height:60%;
    top:12%;
    left:25%;
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
.ps__rail-x{
    display:none !important;
}
");
$script = <<<JS
     $(document).ready(function() {
         
      $("#sbt").on('click', function(){
          var chk1 = $('#services-0');
          var chk2 = $('#services-1');
          
          if(chk1.prop("checked") == true || chk2.prop("checked") == true){
              return true;
          }else{
              $('.error').html('Select at least one to continue');
              $('.error').fadeIn(1000);
          }
      });
      $('.checkbox-input').click(function(){
        $('.error').fadeOut(1000);
      });
    });
    
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
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);