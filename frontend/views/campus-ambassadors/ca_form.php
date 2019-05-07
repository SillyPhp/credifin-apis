<?php
$this->title = Yii::t('frontend', 'Campus Ambassador Form');

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg19.png');
$qualifications = ArrayHelper::map($qualificationsModel, 'qualification_id', 'name');
$states = ArrayHelper::map($statesModel, 'state_id', 'name');

$form = ActiveForm::begin([
    'id' => 'ca-application-form',
    'fieldConfig' => [
        'template' => '<div class="form-group">{input}{error}</div>',
    ],
]);
?>
    <div class="row">
        <div class="col-md-12 text-center">
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="fa fa-check-circle-o"></i>Thanks for Applying!</h4>
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-error alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="fa fa-check-circle-o"></i>An error has occurred. Please try again.</h4>
                    <?= Yii::$app->session->getFlash('error') ?>
                </div>
            <?php endif; ?>
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
            <div class="error-message"></div>
        </div>
        <div class="col-md-6 i-hint-medium input-with-hints">
            <?= $form->field($applicationFormModel, 'college')->textInput(['autocomplete' => 'off', 'class' => 'form-control campus-apply', 'placeholder' => $applicationFormModel->getAttributeLabel('college')]); ?>
            <a class="i-hint" href="javascript:;"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
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
            <a class="i-hint" href="javascript:;"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
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
<?php
ActiveForm::end();

$this->registerCss('
#home {
    height: auto !important;
}
.i-hint{
    position: absolute;
    top: 9px;
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