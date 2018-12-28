<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use borales\extensions\phoneInput\PhoneInput;

$primary_cat = ArrayHelper::map($primaryfields, 'category_enc_id', 'name');
$this->title = 'Form';
$this->params['grid_size'] = 'col-md-8 col-md-offset-2';
?>
<div class="loader-aj-main"><div class="loader-aj"><div class="dot first"></div><div class="dot second"></div></div></div>
<div class="col-md-12 set-overlay">
    <!--<hr>-->
    <?php
    $form = ActiveForm::begin([
                'id' => 'free-form',
                'enableAjaxValidation' => true,
                'validationUrl' => '/site/free-form',
//                'action' => '/site/validate-form',
                'options' => [
                    'class' => 'clearfix',
                ],
                'fieldConfig' => [
                    'template' => '<div class="row"><div class="col-md-12"><div class="form-group">{input}{error}</div></div></div>',
                    'labelOptions' => ['class' => ''],
                ],
    ]);
    ?>
    <div class="tab_1">
        <div class="row">
            <div class="col-md-12">
                <h4>Personal Information</h4>
            </div>
            <div class="col-md-6">
                <?= $form->field($freeFormModel, 'first_name')->textInput(['autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('first_name')]); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($freeFormModel, 'last_name')->textInput(['autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('last_name')]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($freeFormModel, 'job_functions')->dropDownList($primary_cat, ['prompt' => 'Select Job Function'])->label(false); ?>
            </div>
            <div class="col-md-6">
                <?=
                $form->field($freeFormModel, 'phone')->widget(PhoneInput::className(), [
                    'jsOptions' => [
                        'allowExtensions' => false,
                        'nationalMode' => false,
                        'preferredCountries' => ['in'],
                    ]
                ]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($freeFormModel, 'email')->textInput(['autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('email')]); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($freeFormModel, 'city')->textInput(['id' => 'cities', 'autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('city')]); ?>
                <?= $form->field($freeFormModel, 'city_main')->hiddenInput(['id' => 'cities-main', 'autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('city')]); ?>
                <i class="Typeahead-spinner fa fa-circle-o-notch fa-spin fa-fw"></i>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($freeFormModel, 'address')->textInput(['autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('address')]); ?>
            </div>
        </div>
        <hr class="devider"/>
        <div class="row">
            <div class="col-md-12">
                <h4>Your Profile</h4>
            </div>
            <div class="col-md-3 text-right">
                <h3>Highest Education</h3>
            </div>
            <div id="educations_to" class="col-md-9 divider-left">
                <div id="educations">
                    <div class="col-md-12">
                        <?= $form->field($freeFormModel, 'school')->textInput(['autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('school')]); ?>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($freeFormModel, 'field')->textInput(['autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('field')]); ?>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($freeFormModel, 'degree')->textArea(['rows' => 4, 'autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('degree')]); ?>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($freeFormModel, 'from_degree')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'From'],
                            'readonly' => true,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy',
                                'name' => 'from_degree',
                                'todayHighlight' => true,
                    ]])->label(false);
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($freeFormModel, 'to_degree')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'To'],
                            'readonly' => true,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy',
                                'name' => 'to_degree',
                                'todayHighlight' => true,
                    ]])->label(false);
                        ?>
                    </div>
                </div>
            </div>
            <!--            <div class="col-md-9 col-md-offset-3">
                            <a href="#" class="add-education"><i class="fa fa-plus-circle"></i> Add Education</a>
                        </div>-->
        </div>
        <div class="row">
            <div class="col-md-3 text-right">
                <h3>Last Experience</h3>
            </div>
            <div id="experience_to" class="col-md-9 divider-left">
                <div id="experiences">
                    <div class="col-md-12">
                        <?= $form->field($freeFormModel, 'company')->textInput(['autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('company')]); ?>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($freeFormModel, 'experience_cities')->textInput(['id' => 'experience_cities', 'autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('city')]); ?>
                        <?= $form->field($freeFormModel, 'experience_city_main')->hiddenInput(['id' => 'experience-cities-main']); ?>
                        <i class="Typeahead-spinner fa fa-circle-o-notch fa-spin fa-fw"></i>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($freeFormModel, 'title')->textInput(['autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('title')]); ?>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($freeFormModel, 'summary')->textArea(['rows' => 4, 'autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('summary')]); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="check">
                            <?=
                                    $form->field($freeFormModel, 'currently')->checkbox(array('id' => '#currently-working', 'label' => 'I currently work here'))
                                    ->label('I currently work here');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($freeFormModel, 'date_from')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'From'],
                            'readonly' => true,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy',
                                'name' => 'date_from',
                                'todayHighlight' => true,
                    ]])->label(false);
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($freeFormModel, 'date_to')->widget(DatePicker::classname(), [
                            'options' => ['id' => 'experience-to', 'placeholder' => 'To'],
                            'readonly' => true,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy',
                                'name' => 'date_to',
                                'todayHighlight' => true,
                    ]])->label(false);
                        ?>
                    </div>
                </div>
            </div>
            <!--            <div class="col-md-9 col-md-offset-3">
                            <a href="#" class="add-experience"><i class="fa fa-plus-circle"></i> Add Experience</a>
                        </div>-->
        </div>
        <hr class="devider"/>
        <div class="row">
            <div class="col-md-12">
                <h4>Describe yourself</h4>
            </div>
            <div class="col-md-12">
                <?= $form->field($freeFormModel, 'description')->textArea(['rows' => 4, 'autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('description')]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-lg btn-block mt-15 new-btn', 'name' => 'register-button']); ?>
            </div>
        </div>
    </div>
    <?php
    ActiveForm::end();

    $formm = ActiveForm::begin([
                'id' => 'free-form-signup',
                'enableAjaxValidation' => true,
                'validationUrl' => '/site/free-form',
                'action' => '/site/validate-form',
                'options' => [
                    'class' => 'clearfix',
                ],
                'fieldConfig' => [
                    'template' => '<div class="row"><div class="col-md-12"><div class="form-group">{input}{error}</div></div></div>',
                    'labelOptions' => ['class' => ''],
                ],
    ]);
    ?>
    <div class="tab_2">
        <div class="row">
            <div class="col-md-12">
                <h4>Login Information</h4>
            </div>
            <div class="col-md-12">
                <?= $formm->field($freeFormModel, 'username')->textInput(['autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('username')]); ?>
            </div>
            <div class="col-md-6">
                <?= $formm->field($freeFormModel, 'password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('password')]); ?>
            </div>
            <div class="col-md-6">
                <?= $formm->field($freeFormModel, 'confirm_password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $freeFormModel->getAttributeLabel('confirm_password')]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= Html::submitButton('Sign up', ['class' => 'btn btn-primary btn-lg btn-block mt-15 new-btn submit-button', 'name' => 'register-button']); ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<div class="col-md-12 text-center">
    <h2 class="subscribe-head">Subscribe <span>Us</span></h2> 
    <div class="effect jaques">
        <div class="buttons">
            <a href="https://www.facebook.com/empower/" class="fb" target="_blank" title="Join us on Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="https://twitter.com/EmpowerYouth2" class="tw" target="_blank" title="Join us on Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="https://www.instagram.com/empoweryouth.in/" class="insta" target="_blank" title="Join us on Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        </div>
    </div>
    <button data-modal-trigger="trigger-1" class="trigger done hide"></button>
</div>
<div data-modal="trigger-1" class="modal">
    <article class="content-wrapper">
        <button class="close"></button>
        <header class="modal-header">
            <h2>Welcome to the First day of your Career journey.</h2>
        </header>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <p>Your registered email is <span id="email"></span> and username is <span id="username"></span>.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-8 text-right">
                    <a href="/" class="action">Next</a>
                </div>
            </div>
        </div>
        <!--<footer class="modal-footer">-->
        <!--<button class="action">Next</button>-->
        <!--            <button class="action">Decline</button>-->
        <!--</footer>-->
    </article>
</div>

<script>
    const buttons = document.querySelectorAll(`button[data-modal-trigger]`);
    for (let button of buttons) {
        modalEvent(button);
    }

    function modalEvent(button) {
        button.addEventListener('click', () => {
            const trigger = button.getAttribute('data-modal-trigger');
            const modal = document.querySelector(`[data-modal=${trigger}]`);
            const contentWrapper = modal.querySelector('.content-wrapper');
            const close = modal.querySelector('.close');

            close.addEventListener('click', () => modal.classList.remove('open'));
            modal.addEventListener('click', () => modal.classList.remove('open'));
            contentWrapper.addEventListener('click', (e) => e.stopPropagation());

            modal.classList.toggle('open');
        });
    }


</script>
<?php
$this->registerCss('
body  {
    background-image: url( ' . Url::to("@eyAssets/images/backgrounds/lco.png") . ' );
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
}
h4{
    text-transform: uppercase;
    font-size: 16px;
    font-weight: 600;
}
h3{
    font-size: 18px;
}
.set-overlay{
    background-color: #ffffffd9;
    padding: 30px 30px 40px;
    box-shadow: 0px 0px 16px 6px #b3b3b399;
    border-radius: 6px;
}
.form-control{
    border: 1px solid #e0e0e0;
}
.form-group {
    margin-bottom: 5px;
}
.layer-overlay.overlay-white-9::before {
    background-color: rgba(255, 255, 255, 0.49);
}
.tab_2{
    display:none;
}
.new-btn, .new-btn:hover, .new-btn:focus{
    background-color: #4bc6e2;
    border-color: #2bbed6;
}
.devider{
    margin-left: -30px;
    margin-right: -30px;
    border-top: 1px solid #ccc;
}
.divider-left{
    border-left: 5px solid #dddddd8a;
    margin-bottom: 10px;
}
.add-education, .add-experience{
    color:#4aa1e3;
    margin: 0px 0px 20px 0px;
    display: block;
}
div#educations {
    position: relative;
    display: inline-block;
}
.remove-education, .remove-experience{
    float:right;
    color:red;
}
.intl-tel-input {
    width: 100%;
}
.select2-container--krajee .select2-selection--single {
    height: 45px;
    border-radius: 0px;
}
.select2-container--krajee .select2-selection--single .select2-selection__arrow{
    height:44px;
}
.select2-container--krajee .select2-selection--single .select2-selection__rendered{
    margin-top: 6px;
}
.subscribe-head {
  font-family: "Roboto", sans-serif;
  font-weight: 900;
  font-size: 30px;
  text-transform: uppercase;
  color: #212121;
  letter-spacing: 3px;
  margin-top:40px;
}
.subscribe-head span {
  display: inline-block;
}
.subscribe-head span:before, .subscribe-head span:after {
  content: "";
  display: block;
  width: 34px;
  height: 2px;
  background-color: #212121;
  margin: 0px 0px 0px 2px;
}
.effect {
  width: 100%;
  padding: 10px 0px 30px 0px;
}
.effect .buttons {
  display: flex;
  justify-content: center;
}
.effect a {
  text-decoration: none !important;
  color: #fff;
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px;
  margin-right: 20px;
  font-size: 25px;
  overflow: hidden;
  position: relative;
}
.effect a i {
  position: relative;
  z-index: 3;
}
.effect a.fb {
  background-color: #3b5998;
}
.effect a.tw {
  background-color: #00aced;
}
.effect a.insta {
  background-color: #bc2a8d;
}
/* jaques effect */
.effect.jaques a {
  transition: border-top-left-radius 0.1s linear 0s, border-top-right-radius 0.1s linear 0.1s, border-bottom-right-radius 0.1s linear 0.2s, border-bottom-left-radius 0.1s linear 0.3s;
}
.effect.jaques a:hover {
  border-radius: 50%;
}
/* file input css ends */ 
.Typeahead-spinner{
    position: absolute;
    color: #222;
    z-index: 999;
    right: 25px;
    top: 10px;
    font-size: 25px;
    display: none;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}
.tt-hint {
  color: #999
}
.tt-menu {
  width: 100%;
  margin: 0px 0;
//  padding: 8px 0;
  text-align:left;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 0px 0px 6px 6px;
     -moz-border-radius: 0px 0px 6px 6px;
          border-radius: 0px 0px 6px 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
    padding: 4px 15px;
    font-size: 12px;
    line-height: 24px;
    color: #222;
    border-bottom: 1px solid #dddddda3;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
}
.twitter-typeahead{
    width:100%;
}
.hides {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}

label[for="upload"], label[for="resume"] {
  display: inline-block;
  cursor: pointer;
  padding: 9px 25px;
  background-color: #e1beab;
  color: #ffffff;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.25), 0 2px 10px 0 rgba(0, 0, 0, 0.2);
  border-radius: 2px;
  transition: all 0.3s;
  width: 100%;
  text-align: center;
}
label[for="upload"]:hover {
  box-shadow: 0 3px 10px 0 rgba(0, 0, 0, 0.25), 0 5px 18px 0 rgba(0, 0, 0, 0.2);
}
label[for="resume"]{
    max-width: 280px;
}
.loader-aj-main{
    display:none;
    position:fixed;
    background-color:#f9f9f9b0;
    top:0;
    left:0;
    width:100%;
    height:100%;
    z-index:99999;
}
.loader-aj {
    display: flex;
    animation: rotate 1s ease-in-out infinite;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
}
.loader-aj .dot {
    width: 50px;
    height: 50px;
    background: #4aa1e3;
    border-radius: 50%;
  }
.loader-aj .dot.first {
    animation: dot-1 1s ease-in-out infinite;
  }
.loader-aj .dot.second {
    animation: dot-2 1s ease-in-out infinite;
  }
@keyframes rotate {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@keyframes dot-1 {
  0% {
    transform: translate(0px, 0) rotate(0deg);
  }
  50% {
    transform: translate(-50px, 0) rotate(180deg);
  }
  100% {
    transform: translate(0px, 0) rotate(360deg);
  }
}
@keyframes dot-2 {
  0% {
    transform: translate(0px, 0) rotate(0deg);
  }
  50% {
    transform: translate(50px, 0) rotate(180deg);
  }
  100% {
    transform: translate(0px, 0) rotate(360deg);
  }
}

.trigger {
    visibility: hidden;
    opacity: 0;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 0vh;
  background-color: transparent;
  overflow: hidden;
  transition: background-color 0.25s ease;
  z-index: 9999;
}
.modal.open {
  position: fixed;
  width: 100%;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  transition: background-color 0.25s;
}
.modal.open > .content-wrapper {
  transform: scale(1);
}
.modal .content-wrapper {
  position: relative;
  display: block;
  width: 50%;
  margin: 0;
  padding: 1.5rem 2.5rem;
  background-color: white;
  border-radius: 0.3125rem;
  box-shadow: 0 0 2.5rem rgba(0, 0, 0, 0.5);
  margin-top:-10%;
  transform: scale(0);
  transition: transform 0.25s;
  transition-delay: 0.15s;
}
.modal .content-wrapper .close {
  position: absolute;
  top: 0.5rem;
  right: 0.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 2.5rem;
  height: 2.5rem;
  border: none;
  background-color: transparent;
  font-size: 1.5rem;
  transition: 0.25s linear;
}
.modal .content-wrapper .close:before, .modal .content-wrapper .close:after {
  position: absolute;
  content: "";
  width: 1.25rem;
  height: 0.125rem;
  background-color: black;
}
.modal .content-wrapper .close:before {
  transform: rotate(-45deg);
}
.modal .content-wrapper .close:after {
  transform: rotate(45deg);
}
.modal .content-wrapper .close:hover {
  transform: rotate(360deg);
}
.modal .content-wrapper .close:hover:before, .modal .content-wrapper .close:hover:after {
  background-color: tomato;
}
.modal .content-wrapper .modal-header {
  position: relative;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  margin: 0;
  padding: 0 0 0.25rem;
  margin-bottom: 10px;
}
.modal .content-wrapper .modal-header h2 {
  font-size: 1.5rem;
  font-weight: bold;
}
.modal .content-wrapper .content {
  position: relative;
  display: block;
  text-align:center;
}
.modal .content-wrapper .content p {
    font-size: 20px;
    line-height: 75px;
    font-family: -webkit-pictograph;
}
.modal .content-wrapper .modal-footer {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  width: 100%;
  margin: 0;
  padding: 1.875rem 0 0;
}
.action {
  position: relative;
  margin-left: 0.625rem;
  padding: 0.625rem 1.25rem;
  border: none;
  background-color: slategray;
  border-radius: 0.25rem;
  color: white;
  font-size: 0.87rem;
  font-weight: 300;
  overflow: hidden;
  z-index: 1;
}
.action:before {
  position: absolute;
  content: "";
  top: 0;
  left: 0;
  width: 0%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.2);
  transition: width 0.25s;
  z-index: 0;
}
.action:first-child {
  background-color: #2ecc71;
}
.action:last-child {
  background-color: #e74c3c;
}
.action:hover:before {
  width: 100%;
}


');

$script = <<< JS
$(document).on('click', '.check', function(){
    var isChecked = $("#currently-working").is(":checked");
        console.log(1);
    if (isChecked) {
        $('#experience-to').hide();
        $('#currently-working').val('1');
    } else {
        $('#experience-to').show();
        $('#currently-working').val('0');
    }
});
        
        
var form = {
    firstform: '',
    secondform: ''
}
$(document).on('submit', '#free-form', function(event) {
    event.preventDefault();
    form.firstform = $('#free-form').serialize(); 
    $('.tab_1').hide();
    $('.tab_2').show();
});
$(document).on('submit', '#free-form-signup', function(event) {
    event.preventDefault();
    $('.submit-button').attr("disabled", true);
    form.secondform = $('#free-form-signup').serialize();    
    var url = $(this).attr('action');
    var result = form.firstform + form.secondform;
    var method = $(this).attr('method');
    $.ajax({
        url: url,
        method: method,
        data: result,
        beforeSend:function(){
            $('.loader-aj-main').fadeIn(1000);  
        },
        success: function (response) {
        $('.loader-aj-main').fadeOut(1000);
        $('.submit-button').attr("disabled", false);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
                    $('.done').trigger('click');
                    $('#username').text(response.data['username']);
                    $('#phone').text(response.data['phone']);
                    $('#email').text(response.data['email']);
//                window.location.href='/';
            } else {
                toastr.error(response.message, response.title);
            }
            
        }
    });
});
        
$(document).on('focus','.input-group.date',function(){
        $(this).datepicker();
});
        
var global = [];
var city = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '',
  remote: {
    url:'/cities/city-list?q=%QUERY',  
    wildcard: '%QUERY',
    filter: function(list) {
            global = list;
            return list;
        }
  }
});    
            
$('#cities').typeahead(null, {
  name: 'cities',
  highlight: true,       
  display: 'text',
  source: city,
   limit: 15,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.Typeahead-spinner').hide();
  }).on('typeahead:selected typeahead:completed',function(e,datum)
      {
        $('#cities-main').val(datum.id); 
     }).blur(validateSelection);
            
$('#experience_cities').typeahead(null, {
  name: 'experience_cities',
  highlight: true,       
  display: 'text',
  source: city,
   limit: 15,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.Typeahead-spinner').hide();
  }).on('typeahead:selected typeahead:completed',function(e,datum)
      {
        $('#experience-cities-main').val(datum.id);
     }).blur(validateSelection2);
        
function validateSelection() {
   var theIndex = -1;
  for (var i = 0; i < global.length; i++) {
  if (global[i].text == $(this).val()) {
  theIndex = i;
 break;
   }
 }
   if (theIndex == -1) {
   $('#cities').val("");
  }
   
}
        
function validateSelection2() {
   var theIndex = -1;
  for (var i = 0; i < global.length; i++) {
  if (global[i].text == $(this).val()) {
  theIndex = i;
 break;
   }
 }
   if (theIndex == -1) {
   $('#experience_cities').val("");
  }
   
}
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('//platform-api.sharethis.com/js/sharethis.js#property=5aab8e2735130a00131fe8db&product=sticky-share-buttons', ['depends' => [\yii\web\JqueryAsset::className()], 'async' => 'async']);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
