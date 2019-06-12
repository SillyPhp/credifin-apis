<?php
$this->title = Yii::t('frontend', 'Campus Ambassador Form');

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use borales\extensions\phoneInput\PhoneInput;

$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg19.png');
$qualifications = ArrayHelper::map($qualificationsModel, 'qualification_id', 'name');
$states = ArrayHelper::map($statesModel, 'state_id', 'name');
?>

    <div class="tab_1">
        <?php
        $form = ActiveForm::begin([
            'id' => 'ca-application-form',
            'validationUrl' => ['/' . Yii::$app->controller->id . '/' . 'apply-campus'],
            'fieldConfig' => [
                'template' => '<div class="form-group">{input}{error}</div>',
            ],
        ]);
        ?>
        <div class="row">
            <div class="col-md-6 input-with-hints">
                <?= $form->field($applicationFormModel, 'first_name')->textInput(['autocomplete' => 'off', 'class' => 'form-control campus-apply', 'placeholder' => $applicationFormModel->getAttributeLabel('first_name')]); ?>
                <a class="i-hint" href="javascript:;"><i class="fas fa-info-circle" aria-hidden="true"></i></a>
                <div class="i-message">
                    Your First Name.
                </div>
            </div>
            <div class="col-md-6 input-with-hints">
                <?= $form->field($applicationFormModel, 'last_name')->textInput(['autocomplete' => 'off', 'class' => 'form-control campus-apply', 'placeholder' => $applicationFormModel->getAttributeLabel('last_name')]); ?>
                <a class="i-hint" href="javascript:;"><i class="fas fa-info-circle" aria-hidden="true"></i></a>
                <div class="i-message">
                    Your Last Name.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 i-hint-medium input-with-hints">
                <?= $form->field($applicationFormModel, 'email', ['enableAjaxValidation' => true])->textInput(['autocomplete' => 'off', 'class' => 'form-control campus-apply', 'placeholder' => $applicationFormModel->getAttributeLabel('email')]); ?>
                <a class="i-hint" href="javascript:;"><i class="fas fa-info-circle" aria-hidden="true"></i></a>
                <div class="i-message">
                    Your active Email ID.<br/>
                    Ex. xyz@gmail.com
                </div>
            </div>
            <div class="col-md-6 i-hint-large input-with-hints">
                <?= $form->field($applicationFormModel, 'phone', ['enableAjaxValidation' => true])->widget(PhoneInput::className(), [
                    'jsOptions' => [
                        'allowExtensions' => false,
                        'onlyCountries' => ['in'],
                        'nationalMode' => false,
                    ],
                    'options' => ['class' => 'form-control campus-apply'],
                ]);
                ?>
                <a class="i-hint" href="javascript:;"><i class="fas fa-info-circle" aria-hidden="true"></i></a>
                <div class="i-message">
                    Your active Phone Number. Note: WhatsApp Number is Preferred.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?=
                $form->field($applicationFormModel, 'qualification_id')->dropDownList(
                    $qualifications, [
                    'prompt' => 'Select Qualification',
                    'class' => 'form-control campus-apply',
                ])->label(Yii::t('frontend', 'Qualification'));
                ?>
            </div>
            <div class="col-md-6 i-hint-medium input-with-hints">
                <?= $form->field($applicationFormModel, 'college')->textInput(['autocomplete' => 'off', 'class' => 'form-control campus-apply', 'placeholder' => $applicationFormModel->getAttributeLabel('college')]); ?>
                <a class="i-hint" href="javascript:;"><i class="fas fa-info-circle" aria-hidden="true"></i></a>
                <div class="i-message">
                    Your Highest Education Institution.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?=
                $form->field($applicationFormModel, 'state_id')->dropDownList(
                    $states, [
                    'prompt' => 'Select State',
                    'class' => 'form-control campus-apply',
                    'onchange' => '
                            $("#cities_drp").empty().append($("<option>", {
                                value: "",
                                text : "Select City"
                            }));
                            $.post(
                                "' . Url::toRoute("cities/get-cities-by-state") . '",
                                {id: $(this).val()},
                                function(res){
                                    if(res.status === 200) {
                                        drp_down("cities_drp", res.cities);
                                    }
                                }
                            );',
                ]);
                ?>
            </div>
            <div class="col-md-6">
                <?=
                $form->field($applicationFormModel, 'city_id')->dropDownList(
                    [], [
                    'prompt' => 'Select City',
                    'id' => 'cities_drp',
                    'class' => 'form-control campus-apply'
                ]);
                ?>
            </div>
        </div>
        <?php
        foreach ($applicationQuestionsModel as $question) {
            ?>
            <div class="row">
                <div class="col-md-12 input-with-hints">
                    <?php
                    echo $form->field($applicationFormModel, 'answers[' . $question['application_question_id'] . ']')->textArea(['autocomplete' => 'off', 'class' => 'form-control campus-apply', 'rows' => 5, 'placeholder' => $applicationFormModel->getAttributeLabel($question['question'])]);
                    ?>
                    <a class="i-hint" href="javascript:;"><i class="fas fa-info-circle" aria-hidden="true"></i></a>
                    <div class="i-message">
                        Answer in about 100 words.
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="form-group">
                <div class="form-group col-md-12">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-lg btn-block mt-15 f-first-btn']); ?>
                </div>
            </div>
        </div>
    </div>
<?php
ActiveForm::end();
?>
    <div class="tab_2">
        <?php
        $formm = ActiveForm::begin([
            'id' => 'ca-application-login-form',
            'action' => '/campus-ambassador/apply',
            'validationUrl' => ['/' . Yii::$app->controller->id . '/' . 'apply-campus'],
            'fieldConfig' => [
                'template' => '<div class="form-group">{input}{error}</div>',
            ],
        ]); ?>

        <div class="row">
            <div class="col-md-12">
                <?= $formm->field($applicationFormModel, 'username', ['enableAjaxValidation' => true])->textInput(['autocomplete' => 'off', 'placeholder' => $applicationFormModel->getAttributeLabel('username')]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $formm->field($applicationFormModel, 'password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $applicationFormModel->getAttributeLabel('password')]); ?>
            </div>
            <div class="col-md-6">
                <?= $formm->field($applicationFormModel, 'confirm_password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $applicationFormModel->getAttributeLabel('confirm_password')]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= Html::submitButton('Sign up', ['class' => 'btn btn-primary btn-lg btn-block mt-15 new-btn submit-button',]); ?>
            </div>
        </div>

        <?php
        ActiveForm::end();
        ?>
    </div>
<?php

$this->registerCss('
#home {
    height: auto !important;
}
.intl-tel-input {
    width: 100%;
}
.i-hint{
    position: absolute;
    top: 12px;
    right: 25px;
    font-size: 16px;
    color: #999999b8;
}
.has-error ~ .i-hint{
    color:#e73d4a;
}
.i-message{
    display: block;
    width: 200px;
    position: absolute;
    right: -192px;
    border: solid 1px transparent;
    background-color: #00A0E3;
    padding: 10px;
    color: #fff;
    z-index: 1000;
    top: -2px;
    opacity:0;
    border-radius: 4px;
    -webkit-transition: all 0.5s ease-out;
	-moz-transition: all 0.5s ease-out;
	-ms-transition: all 0.5s ease-out;
	-o-transition: all 0.5s ease-out;
	transition: all 0.5s ease-out;
    visibility: hidden;
}
.i-message:before {
    content: "";
    left: -15px;
    top: 30%;
    position: absolute;
    border-top: 10px solid transparent;
    border-right: 15px solid #00A0E3;
    border-bottom: 10px solid transparent;
}
.i-hint:hover ~ .i-message, i-message:hover{
    visibility: visible;
    opacity:1;
}
input, textarea {
    padding-right: 32px !important;
}
.i-hint-medium .i-message{top:-9px}
.i-hint-large .i-message{top:-16px}
.tab_2{
    display:none;
}
');
$script = <<< JS
$('input, textarea').focus(function(){
    var hintMain = $(this).parentsUntil('.input-with-hints').parent().find('.i-message');
    if ($(this).is(":focus")) {
        hintMain.css('visibility','visible');
        hintMain.css('opacity','1');
    }
});
$(document).on('blur', 'input, textarea', function(){
    $('.i-message').css('visibility','hidden');
    $('.i-message').css('opacity','0');
});
$(document).on('mouseover','.i-hint', function(){
    var hintMain = $(this).next('.i-message');
    hintMain.css('visibility','visible');
    hintMain.css('opacity','1');
});
$(document).on('mouseout','.i-hint', function(){
    var hintMain = $(this).next('.i-message');
    hintMain.css('visibility','hidden');
    hintMain.css('opacity','0');
});

var form = {
    firstform: '',
    secondform: ''
}

$(document).on('submit', '#ca-application-form', function(event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    form.firstform = $('#ca-application-form').serialize(); 
    $('.tab_1').hide();
    $('.tab_2').show();
});
$(document).on('submit','#ca-application-login-form', function(event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    $('.submit-button').attr("disabled", true);
    $('.submit-button').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
    form.secondform = $('#ca-application-login-form :input:not(:hidden)').serialize(); 
    var url = window.location.href;
    var result = form.firstform + '&' + form.secondform;
    var method = $(this).attr('method');
    $.ajax({
        url: url,
        method: method,
        data: result,
        beforeSend:function(){
            // $('.loader-aj-main').fadeIn(1000);  
        },
        success: function (response) {
            $('.submit-button').attr("disabled", false);
            $('.submit-button').html('Sign up');
            $('.tab_1').show();
            $('.tab_2').hide();
            if (response.status == 200) {
                toastr.success(response.message, response.title);
                $("#ca-application-form")[0].reset();
                $("#ca-application-login-form")[0].reset();
            } else {
                toastr.error(response.message, response.title);
            }
           
        }
    });
});
JS;
$this->registerJs($script);
$this->registerJs("function drp_down(id, data) {
    var selectbox = $('#' + id + '');
    $.each(data, function () {
        selectbox.append($('<option>', {
            value: this.id,
            text : this.name
        }));
    });
}", View::POS_HEAD);
$this->registerCssFile('https://use.fontawesome.com/releases/v5.8.2/css/all.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);