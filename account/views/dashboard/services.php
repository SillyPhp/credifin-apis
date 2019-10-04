<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$services = ArrayHelper::map($services, 'service_enc_id', 'name');
?>
    <div class="light-box-modal">
        <div class="light-box-in">
            <div class="light-box-img">
                <img src="/assets/themes/ey/images/pages/dashboard/services.png"/>
            </div>
            <div class="light-box-content">
                <p>What services would you like to access?</p>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'services_submit_form',
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
                    <ul class="ks-cboxtags">
                        <?php
                        echo $form->field($model, 'services[]')->inline()->checkBoxList($services, [
                            'id' => 'services',
                            'item' => function ($index, $label, $name, $checked, $value) {
                                $return = '<li class="service-list">';
                                $return .= '<input type="checkbox" name="' . $name . '" value="' . $value . '" id="services-' . $index . '" class="checkbox-input services" />';
                                $return .= '<label for="services-' . $index . '">' . $label;
                                $return .= '</label>';
                                $return .= '</li>';
                                return $return;
                            }
                        ])->label(false);
                        ?>
                    </ul>
                </div>
                <div style="min-height: 21px;">
                    <div class="error"></div>
                </div>
                <div class="pull-right" style="margin-right: 10px;">
                    <button type="submit" id="sbt" class="services-submit">
                        <span>Continue</span>
                        <span>
                          <svg width="50px" height="14px" viewBox="0 0 66 43" version="1.1"
                               xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <path class="one"
                                    d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z"
                                    fill="#FFFFFF"></path>
                              <path class="two"
                                    d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z"
                                    fill="#FFFFFF"></path>
                              <path class="three"
                                    d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z"
                                    fill="#FFFFFF"></path>
                            </g>
                          </svg>
                        </span>
                    </button>
                </div>
                <?php ActiveForm::end(); ?>
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
#services{
    margin-top:10px;
}
.help-block.help-block-error{
    padding:0px;
}
.services-submit{
    display: flex;
    padding: 5px 15px !Important;
    padding-right: 20px !Important;
    text-transform: none !Important;
    text-decoration: none;
    font-size: 14px !Important;
    color: #fff !important;
    outline: 0!important;
    border-radius: 4px;
    border: 1px solid transparent;
    box-shadow: 0 1px 3px rgba(0,0,0,.1), 0 1px 2px rgba(0,0,0,.18);
    transition: box-shadow .28s cubic-bezier(.4,0,.2,1);
    background-color: #00A0E3 !important;
}
.services-submit span:nth-child(2) {
    transition: 0.5s;
    margin-right: 0px;
    margin-top: 2px;
    width: 15px;
    margin-left: 0px;
    position: relative;
    top: 12%;
}
.services-submit:hover span:nth-child(2), .services-submit:focus span:nth-child(2) {
    transition: 0.5s;
    margin-right: 15px;
}

path.one {
    transition: 0.4s;
    transform: translateX(-60%);
}

path.two {
    transition: 0.5s;
    transform: translateX(-30%);
}

.services-submit:hover path.three, .services-submit:focus path.three {
    animation: color_anim 1s infinite 0.2s;
}

.services-submit:hover path.one, .services-submit:focus path.one {
    transform: translateX(0%);
    animation: color_anim 1s infinite 0.6s;
}

.services-submit:hover path.two, .services-submit:focus path.two {
    transform: translateX(0%);
    animation: color_anim 1s infinite 0.4s;
}

/* SVG animations */

@keyframes color_anim {
    0% {
        fill: white;
    }
    50% {
        fill: #FBC638;
    }
    100% {
        fill: white;
    }
}
.light-box-modal *{
    font-family: lora;
}
.light-box-modal{
    position: fixed;
    background-color: #000000b5;
    width: 100%;
    height: 100%;
    z-index: 9999;
    top: 0;
    left: 0;
}
.light-box-in{
    position: relative;
    width: 90%;
    max-width: 450px;
    margin: auto;
//    height: 78vh;
    height: 380px;
    top: calc(48vh - 190px);
    background-color: #fff;
    border-radius: 4px;
    overflow: hidden;
    box-shadow: 0px 1px 5px 1px #eeeeeea3;
}
.light-box-img{
    position: relative;
    width: 100%;
    background: linear-gradient(90deg, #86dbff 5%, #00b4ff 85%);
    height: calc(100% - 165px);
    text-align:center;
}
.light-box-img img{
    width: 225px;
    margin-top: 20px;
}
.light-box-img h3{
    display: block;
    color: #fff;
    font-weight: 600;
    font-size:21px;
    margin: 9px;
}
.light-box-content{
    text-align: center;
    height: 110px;
//    line-height: 72px;
}
.light-box-content p{
    vertical-align: middle;
    line-height: 15px;
    padding: 15px;
    color: #222;
    margin: 0;
    font-size: 17px;
    padding-bottom: 0px;
}
.light-box-content a{
    display: inline-block;
    text-align: center;
    padding: 6px 10px;
    width: 47%;
    border: 1px solid #ddd;
    color: #565656;
    vertical-align: middle;
    line-height: normal;
    border-radius: 4px;
    transition: 0.7s all;
}
.light-box-content a:hover{
    box-shadow: 0px 1px 5px 1px #ddd;
}
.light-box-content a.highlight{
    color: #fff;
    background-color: #00a0e3;
    border: 1px solid #00a0e3;
}
ul.ks-cboxtags {
    list-style: none;
    padding:0px;
}
.service-list{
  display: inline-block;
  min-width: 120px;
}
.service-list label{
    width: 100%;
    display: inline-block;
    background-color: rgba(255, 255, 255, .9);
    border: 2px solid rgba(139, 139, 139, .3);
    color: #333;
    border-radius: 4px;
    white-space: nowrap;
    margin: 3px 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all .2s;
}

.service-list label {
    padding: 8px 12px;
    cursor: pointer;
}

.service-list label::before {
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    font-size: 12px;
    padding: 2px 6px 2px 2px;
    content: '\f067';
    transition: transform .3s ease-in-out;
}

.service-list input[type='checkbox']:checked + label::before {
    content: '\f00c';
    transform: rotate(-360deg);
    transition: transform .3s ease-in-out;
}

.service-list input[type='checkbox']:checked + label, .service-list label:hover {
    border: 2px solid #00a0e3;
    background-color: #00a0e3;
    color: #fff;
    transition: all .2s;
}

.service-list input[type='checkbox'] {
  display: absolute;
}
.service-list input[type='checkbox'] {
  position: absolute;
  opacity: 0;
}
.service-list input[type='checkbox']:focus + label {
  border: 2px solid #00a0e3;
}
@media screen and (max-width: 992px){
    .light-box-in{
        height: 400px;
    }
    .light-box-img{
        height: calc(100% - 180px);
    }
}
");
$script = <<<JS
     $(document).ready(function() {
         
      $("#sbt").on('click', function(){
          var chk1 = $('#services-0');
          var chk2 = $('#services-1');
          
          if (chk1.prop("checked") == true || chk2.prop("checked") == true) {
                $(this).css('pointer-events', 'none');
                $(this).html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
                $("#services_submit_form").submit();
          }else {
                $('.error').html('Select at least one to continue');
                $('.error').fadeIn(1000);
          }
      });
      $('.checkbox-input').click(function(){
        $('.error').fadeOut(1000);
      });
    });

JS;
$this->registerJs($script);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);