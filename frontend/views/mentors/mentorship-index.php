<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<section class="mentor-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="m-banner-text">
                    A New Way Of <br>Funding Career Development
                </div>
                <div class="mentor-apply-btn">
                    <button type="button" class="mentorSignupModal">Apply to be a mentor</button>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->render('/widgets/mentorships/mentoring-program') ?>
<?= $this->render('/widgets/mentorships/whats-in-for-you') ?>
<?= $this->render('/widgets/mentorships/features') ?>
<?= $this->render('/widgets/mentorships/benefits') ?>
<?= $this->render('/widgets/mentorships/how-it-works') ?>
<div id="mentorModal" class="mentorSignUpmodal">
    <!-- Modal content -->
    <div class="mentor-modal-content">
        <span class="close">&times;</span>
        <div class="">
            <div class="col-md-6">
                <div class="cmc-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/college/online-class-white.png') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="csu-heading">Join our mentorship program today</div>
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
                        <?= $form->field($model, 'email')->textInput(['autocomplete' => 'off', 'placeholder' => 'Email', 'class' => 'uname-in'])->label(false); ?>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="uname">
                    <div class="form-group field-username required">
                        <?= $form->field($model, 'teaching_field')->textInput(['autocomplete' => 'off', 'placeholder' => 'Teaching Field', 'class' => 'uname-in'])->label(false); ?>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
                <div class="uname">
                    <div class="form-group field-username required">
                        <?= $form->field($model, 'experience')->dropDownList([1 => 'fresher', 2 => 'experienced'], ['prompt' => 'select experience', 'class' => 'uname-in'])->label(false) ?>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>

                <div class="uname">
                    <?=
                    $form->field($model, 'phone')->textInput(['placeholder' => 'Phone number', 'class' => 'uname-in'])->label(false);
                    ?>
                    <p class="help-block help-block-error"></p>
                </div>
                <div class="modal-oc">
                    <?= Html::submitButton('Sign Up', ['id' => 'enquiryBtn']); ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<div id="mentorRegister" class="mentorRegisterModal">
    <div class="mentor-modal-content">
        <span class="close close2">&times;</span>
        <div class="">
            <div class="col-md-6">
                <div class="cmc-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/college/online-class-white.png') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="csu-heading">Become A Mentor</div>
                <div class="">
                    <div class="col-md-12">
                        <div class="uname">
                            <input type="text" id="full_name" class="uname-in" name="full_name" autofocus=""
                                   autocomplete="off" placeholder="Full Name" aria-required="true">
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="uname">
                            <input type="text" id="email" class="uname-in" name="email" autofocus=""
                                   autocomplete="off" placeholder="Email" aria-required="true">
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="uname">
                            <input type="text" id="number" class="uname-in" name="number" autofocus=""
                                   autocomplete="off" placeholder="Number" aria-required="true">
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group field-username required">
                            <div class="input-group">
                                <span class="input-group-addon">https://empoweryouth.com/</span>
                                <input type="text" id="username" class="lowercase form-control" name="username"
                                       autocomplete="off" placeholder="Username" aria-required="true">
                            </div>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="uname">
                            <input type="text" id="number" class="uname-in" name="number" autofocus=""
                                   autocomplete="off" placeholder="Password" aria-required="true">
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$this->registerCSS('

.uname-in {
    padding: 13px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 100%;
    font-size: 13px;
}
.input-group {
    position: relative;
    display: table;
    border-collapse: separate;
}
.input-group-addon:first-child {
    border-right: 0;
}
.input-group .form-control {
    position: relative;
    z-index: 2;
    float: left;
    width: 100%;
    margin-bottom: 0;
}
.input-group-addon {
    color: #555 !Important;
    background-color: #eee !Important;
}
.footer{
    margin-top:0px !important;
}
.modal-oc button{
    background: transparent;
    border: 1px solid #00a0e3;
    color:#00a0e3;
    padding:10px 20px;
    margin-top: 30px;
    text-transform: uppercase;
    font-family: roboto;
}
.mentor-header{
    background: url(' . Url::to('@eyAssets/images/pages/mentorship/mentors-main-banner.png') . ');
    background-size: cover;
    min-height: 400px;
    display: flex;
    align-items: center;
        background-position: top;
}
.m-banner-text{
    font-family: lora;
    font-size: 35px;
    color: #333;
    line-height: 40px;
    text-transform: capitalize;
}
.mentor-apply-btn {
    margin-top: 20px;
}
.mentor-apply-btn button{
    text-transform: uppercase;
    background:#00a0e3;
    color:#fff;
    padding:15px 20px;
    border: 1px solid #00a0e3
}
.mentorSignUpmodal, .mentorRegisterModal {
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
.mentor-modal-content {
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

.uname label{
    text-align: left;
    font-weight: bold;
    width:100%;
    line-height:0px;
}
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

.uname-in-phone{
    padding: 10px 15px;
    width: 80%;
    border: none;
    margin-left: 40px;
}
.uname-in-phone:focus{
    outline:none !important;
}
.iti--allow-dropdown input, .iti--allow-dropdown input[type=text], .iti--allow-dropdown input[type=tel], .iti--separate-dial-code input, .iti--separate-dial-code input[type=text], .iti--separate-dial-code input[type=tel] {
    padding-right: 6px;
    padding-left: 10px;
    margin-left: 0;
}
@media screen and (max-width: 992px){
    .mentor-modal-content {
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

JS;
$this->registerJs($script);
?>
<script>
    var modal = document.getElementById("mentorModal");
    var modalRegister = document.getElementById("mentorRegister");

    var btn = document.querySelector(".mentorSignupModal");
    var Regbtn = document.querySelector(".apply-mentor-btn");

    var span = document.querySelector(".close");
    var closeTwo = document.querySelector(".close2");

    btn.onclick = function () {
        modal.style.display = "block";
    }
    Regbtn.onclick = function () {
        modalRegister.style.display = "block";
    }
    span.onclick = function () {
        modal.style.display = "none";
    }
    closeTwo.onclick = function () {
        modalRegister.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target == modal || event.target == modalRegister) {
            modal.style.display = "none";
            modalRegister.style.display = "none";
        }
    }
    window.onkeyup = function (event) {
        if (event.keyCode == 27) {
            modal.style.display = "none";
            modalRegister.style.display = "none";
        }
    }
</script>
