<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use borales\extensions\phoneInput\PhoneInput;

?>
<section class="virus-bg">
    <div class="virus-icons">
        <img src="<?= Url::to('@eyAssets/images/pages/college/coronavi.png') ?>">
    </div>
    <div class="virus-icon-left">
        <img src="<?= Url::to('@eyAssets/images/pages/college/coronavi.png') ?>">
    </div>
    <div class="container">
        <div class="onlineClasses">
            <div class="online-icon">
                <img src="<?= Url::to('@eyAssets/images/pages/college/online-class.png') ?>">
            </div>
            <div class="online-content">
                <p class="oc-sub-heading">Protecting Education against Corona Virus</p>
                <p class="oc-text">We at Empower Youth are transforming your physical classroom to digital and taking
                    it online so the education of child is not hampered</p>
                <div class="oc-text-icons">
                    <div class="collegeSignupModal">
                        <span>
                            <img src="<?= Url::to('@eyAssets/images/pages/college/school-icon.png') ?>"
                                 class="hoverHide">
                            <img src="<?= Url::to('@eyAssets/images/pages/college/school-icon-white.png') ?>"
                                 class="hoverShow">
                        </span>
                        <p>Schools</p>
                    </div>
                    <div class="collegeSignupModal">
                        <span>
                            <img src="<?= Url::to('@eyAssets/images/pages/college/colg-icon.png') ?>" class="hoverHide">
                            <img src="<?= Url::to('@eyAssets/images/pages/college/colg-icon-white.png') ?>"
                                 class="hoverShow">
                        </span>
                        <p>Universities & Colleges</p>
                    </div>
                    <div class="collegeSignupModal">
                        <span>
                            <img src="<?= Url::to('@eyAssets/images/pages/college/educational-institute.png') ?>"
                                 class="hoverHide">
                            <img src="<?= Url::to('@eyAssets/images/pages/college/educational-institute-white.png') ?>"
                                 class="hoverShow">
                        </span>
                        <p>Educational Institutes</p>
                    </div>
                </div>
                <div class="oc">
                    <button type="button" class="collegeSignupModal">Join The Movement</button>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="virusModal" class="collegeSignUpmodal">

    <!-- Modal content -->
    <div class="college-modal-content">
        <span class="close">&times;</span>
        <div class="row">
            <div class="col-md-6">
                <div class="cmc-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/college/online-class-white.png') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="csu-heading">Join the movement today</div>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'enquiry-form',
                    'enableClientValidation' => true,
                    'validateOnBlur' => false,
                    'options' => [
                            'enctype' => 'multipart/form-data',
                            'class' => 'mx-600',
                        ],
                ]);
                ?>
                <div class="uname">
                    <div class="form-group field-username required">
                        <?= $form->field($model, 'full_name')->textInput(['autofocus' => true, 'autocomplete' => 'off', 'placeholder' => 'Full Name', 'class' => 'uname-in'])->label(false); ?>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="uname">
                    <div class="form-group field-username required">
                        <?= $form->field($model, 'organization_name')->textInput(['autocomplete' => 'off', 'placeholder' => 'Organization Name', 'class' => 'uname-in'])->label(false); ?>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="uname">
                    <div class="form-group field-username required">
                        <?= $form->field($model, 'designation')->textInput(['autocomplete' => 'off', 'placeholder' => 'Designation', 'class' => 'uname-in'])->label(false); ?>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="uname">
                    <div class="form-group field-username required">
                        <?= $form->field($model, 'email')->textInput(['autocomplete' => 'off', 'placeholder' => 'Email', 'class' => 'uname-in'])->label(false); ?>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="uname">
                    <?=
                    $form->field($model, 'phone')->widget(PhoneInput::className(), [
                        'jsOptions' => [
                            'allowExtensions' => false,
                            'preferredCountries' => ['in'],
                            'nationalMode' => false,
                        ],
                        'options' =>[
                            'class' => 'uname-in-phone',
                        ]
                    ])->label(false);
                    ?>
                    <p class="help-block help-block-error"></p>
                </div>
                <div class="uname checkBox-padding">
                    <?=
                    $form->field($model, 'enquiry_for')->checkBoxList(['Campus Placement' => 'Campus Placement', 'Online Classes' => 'Online Classes', 'Hiring' => 'Hiring'], [
                        'item' => function ($index, $label, $name, $checked, $value) {
                            $return = '<label for="weekday-' . $index . '" class="checkbox-container">' . $label ;
                            $return .= '<input type="checkbox" name="' . $name . '" value="' . $value . '" id="weekday-' . $index . '" class="weekday" ' . (($checked) ? 'checked' : '') . '/>';
                            $return .=  '<span class="checkmark"></span></label>';
                            return $return;
                        }
                    ])->label(false);
                    ?>
                </div>
                <div class="modal-oc">
                    <?= Html::submitButton('Sign Up', ['id' => 'enquiryBtn']); ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</div>
<?php

$this->registerCss('
.mx-600 .flag-container {
    left: 45px !important;
}
.iti{
        position: relative;
    display: inline-block;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 80%;
    font-size: 13px;
}
.uname-in-phone{
    padding: 10px 15px;
    width: 80%;
    border: none;
    margin-left: 40px;
}
.uname-in-phone:focus{
    outline:none;
}
.virus-bg{
    position: ralative;
    overflow: hidden;
    background:#eee ;
    background-size: contain;
    padding:30px 0 50px 0;
}
.virus-icons, .virus-icon-left{
    position: absolute;
}
.virus-icons{
    top:-150px; 
    right:-150px;
    max-width: 350px;
    opacity:.5;
}
.virus-icon-left{
    bottom: -100px;
    left: -100px;
    max-width:250px;
    opacity:.4;
}

.oc button, .modal-oc button{
    background: transparent;
    border: 1px solid #00a0e3;
    color:#00a0e3;
    padding:15px 20px;
    margin-top: 30px;
    text-transform: uppercase;
    font-family: roboto;
}
.modal-oc button{    
    margin-top: 0px;
    padding:10px 15px;
}
.oc button:hover, .modal-oc button:hover{
    background: #00a0e3;
    color:#fff;
    transition: .3s ease;
}
.oc-text-icons div span{
    position: relative;   
    display:inline-block;
}
.oc-text-icons div span .hoverShow{
    display: none;
    position: absolute;
    top:0;
    left:0;
    z-index:99;
}
.oc-text-icons div:hover  span .hoverShow{
    display: inline;
    transition: 0.2s ease;
}
.oc-text-icons div:hover  span .hoverHide{
    display: hidden;
}
.oc-text-icons div{
    flex-basis: 200px;
    text-align: center;
     box-shadow:0 0 10px rgba(0,0,0,.1);
    margin:10px 10px 0 0;
    padding:10px 10px 5px 10px;
    border-radius: 10px;
} 
.oc-text-icons div:hover{
    background:#00a0e3;
    color:#fff;
    transition:.3s ease;
    cursor: pointer;
}
.oc-text-icons p{
    font-size:16px; 
    padding-top: 5px;
    font-family: roboto;
    line-height:20px;
}
.oc-text-icons{
    display: flex;
    flex-wrap: wrap;
    margin-top: 20px;
}

.onlineClasses{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
.oc-text{
    font-size: 18px;
    font-family: roboto;
    color: #333;
}
.online-content{
    flex-basis:60%;
    margin-left: 40px;
}
.online-icon{
    text-align:center;
    flex-basis:30%
}
.oc-sub-heading{
   font-size: 30px;
    font-weight: 600;
    color: #000;
    font-family: lora;
    margin: 0px;
    text-transform: capitalize;
}
@media screen and (max-width:1200px){
    .onlineClasses{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        text-align:center;
    }
    .online-content{
        flex-basis:100%;
        margin-left: 40px;
    }
    .online-icon{
        text-align:center;
        flex-basis:100%
    }
    .online-icon img{
        max-width:250px;
    }
    .oc-text-icons{
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
        justify-content: center;
    }
}
/*virus Modal*/
.collegeSignUpmodal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0px;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
 z-index: 9999;
}

/* Modal Content/Box */
.college-modal-content {
    background: linear-gradient(to right, #00a0e3 50%, #fff 50%);
    position:absolute;
    top:50%;
    left:50%;
    transform: translate(-50%, -50%);
    text-align:center;  
    border-radius: 10px;
    width: 70%; /* Could be more or less, depending on screen size */
     padding:30px 0 30px 0;
     
     
}
.csu-heading{
    text-transform: capitalize;
    font-size:18px;
    color:#000;
    font-family: roboto;
}
/* The Close Button */
.close {
  position: absolute;
  top:10px;
  right: 10px;
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
.checkbox-container {
  display: inline-block;
  position: relative;
  padding-left: 25px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 16px;
  font-weight: 500;
  margin-right: 20px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.cmc-icon{
    margin-top: 50px;
}
.checkBox-padding{
    padding: 0 50px !important;
    text-align: left !important;
}
/* Hide the browser\'s default checkbox */
.checkbox-container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 4px;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.checkbox-container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.checkbox-container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.checkbox-container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.checkbox-container .checkmark:after {
  left: 8px;
  top: 4px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
.mx-600 .uname{
    padding: 10px 0 0px 0;
}
.mx-600 .uname-in {
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 80%;
    font-size: 13px;
}
.mx-600 .form-group{
    margin-bottom: 5px;
}
@media screen and (max-width: 992px){
    .college-modal-content {
        background: linear-gradient(to right, #fff 50%, #fff 50%);
    }
    .cmc-icon {
        margin-top: 00px;
    }
    .cmc-icon img{
        max-width: 200px;
    }
}
');
$script = <<<JS
$(document).on('submit', '#enquiry-form', function (event) {
    event.preventDefault();
    var form = $(this);
    var btn = $('#enquiryBtn');
    var btn_value = btn.text();
    event.stopImmediatePropagation();
    if ( form.data('requestRunning') ) {
        return false;
    }
    form.data('requestRunning', true);
    var url = form.attr('action');
    var data = form.serialize();
    var method = form.attr('method');
    var formData = new FormData(this);
    $.ajax({
        url: url,
        type: method,
        enctype: 'multipart/form-data',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            btn.attr('disabled', true);
            btn.html('Please Wait..');
        },
        success: function (response) {
            if (response.status == 200) {
                btn.attr('disabled', false);
                btn.html(btn_value);
                $(".close").click();
                toastr.success(response.message, response.title);
            } else {
                btn.attr('disabled', false);
                btn.html(btn_value);
                toastr.error(response.message, response.title);
            }
        },
        complete: function() {
            form.data('requestRunning', false);
        }
    }).fail(function(data, textStatus, xhr) {
         btn.attr('disabled', false);
         btn.html(btn_value);
    });
});
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    var modal = document.getElementById("virusModal");
    // Get the button that opens the modal
    var btn = document.getElementsByClassName("collegeSignupModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    for (var i = 0; i < btn.length; i++) {
        btn[i].onclick = function () {
            modal.style.display = "block";
        }
    }
    span.onclick = function () {
        modal.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    window.onkeyup = function (event) {
        if(event.keyCode == 27){
            modal.style.display = "none";
        }
    }

</script>
