<?php
/* @var $business_activities string */

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

$business_activities = ArrayHelper::index($business_activities, NULL, 'business_activity_enc_id');
?>
    <div class="light-box"></div>
    <div class="main-outer">
        <div class="main-inner">
            <h2 class="lightbox-title text-center"><?= Yii::t('account', 'Do you fall under any of these specialised categories of business?'); ?></h2>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'ba_submit_form',
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
                        <ul class="ba-list">
                            <?=
                            $form->field($model, 'businessActivity')->inline()->checkBoxList($business_activities, [
                                'id' => 'services',
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    if ($label[0]['business_activity'] !== "Others") {
                                        $return = '<li><div class="ba-box"><input type="radio" name="' . $name . '" value="' . $value . '" id="services-' . $index . '" class="checkbox-input services" />';
                                        $return .= '<label for="services-' . $index . '" class="checkbox-label">';
                                        $return .= '<a class="box"><div class="content"><img src="' . $label[0]['icon'] . '"/>';
                                        $return .= '<h3>' . $label[0]['business_activity'] . '</h3>';
                                        $return .= '</div></a></label></div></li>';
                                        return $return;
                                    }
                                }
                            ])->label(false);
                            ?>
                        </ul>
                    </div>
                    <div style="min-height: 21px;">
                        <div class="error"></div>
                    </div>
                    <div class="pull-right" style="margin-right: 10px;margin-bottom: 15px;">
                        <a class="services-submit" id="skip-it"
                           url="<?= Url::to("/account/dashboard/skip-business-activity"); ?>">
                            <span>Skip</span>
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
                        </a>
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
    </div>
<?php
$this->registerCss("
.error{
    color:red;
    font-size: 15px;
    text-align: center;
    display: none;
}
.ba-list{
    padding-inline-start: 0px;
    text-align:center;
}
.ba-list li{
    display:inline-block;
    width:200px;
    padding:0 5px;     
}
.ba-box{
    width:100%;
    text-align:center;
}
.ba-box h3{
    font-size:15px;
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
    height:140px;
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
        margin: 10px auto;
    }
}
.form {
    padding: 0 16px;
    max-width: 1000px;
    margin: 15px auto;
    font-size: 18px;
    font-weight: 600;
    line-height: 36px;
}
.lightbox-title{
    font-weight: 500;
    font-size: 24px;
    color: #444;
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
    padding:8px 20px 0px;
}
.main-outer{
    width:80%;
    height:80%;
    top:10%;
    left:10%;
    display: none;
    position: fixed;
    overflow:hidden;
    z-index: 2000;
}
.services-submit{
    display: inline-block;
    padding: 0px 15px !Important;
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
.services-submit span{display: inline-block;}
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
@media(min-width : 1500px) {
    .main-outer{
        width: 70%;
        height: 70%;
        top:15%;
        left:15%;
    }
    .form {
        padding: 0 16px;
        max-width: 900px;
        margin: 15px auto;
        font-size: 18px;
        font-weight: 600;
        line-height: 36px;
        
    }
}
@media(max-width : 500px) {
    .main-outer{
        width: 90%;
        height: 80%;
        top:10%;
        left:5%;
    }
    .lightbox-title{
        font-size:17px;
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
    
    $(document).on('click', '#skip-it', function (a) {
        a.preventDefault();
        url = $(this).attr('url');
        var d_template = $(this).html();
        $(this).css('pointer-events', 'none');
        $(this).html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
        $.ajax({
            url: url,
            method: "POST",
            success: function (response) {
                if (response.status === 200) {
                    location.reload();
                } else {
                    toastr.error(response.message, response.title);
                }
            }
        });
    });
    
    $(document).on('click', '#sbt', function(){
        var chk1 = $('.ba-box input[type=radio]:checked').length;
        
        if(chk1 === 1){
            // $(this).css('pointer-events', 'none');
            // $(this).html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
            $("#ba_submit_form").submit();
        } else {
            $('.error').html('Select at least one to continue');
            $('.error').fadeIn(1000);
            return false;
        }
    });
    
    $('.checkbox-input').click(function(){
        $('.error').fadeOut(1000);
    });
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);