<?php
$this->title = Yii::t('frontend', 'Campus Ambassador Form');

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use borales\extensions\phoneInput\PhoneInput;

$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg19.png');
$qualifications = ArrayHelper::map($qualificationsModel, 'qualification_enc_id', 'name');
$states = ArrayHelper::map($statesModel, 'state_enc_id', 'name');

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
            <?= $form->field($caApplicationFormModel, 'first_name')->textInput(['autofocus' => true, 'autocomplete' => 'off', 'placeholder' => $caApplicationFormModel->getAttributeLabel('first_name')]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($caApplicationFormModel, 'last_name')->textInput(['autocomplete' => 'off', 'placeholder' => $caApplicationFormModel->getAttributeLabel('last_name')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($caApplicationFormModel, 'email')->textInput(['autocomplete' => 'off', 'placeholder' => $caApplicationFormModel->getAttributeLabel('email')]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($caApplicationFormModel, 'phone', ['enableAjaxValidation' => false])->widget(PhoneInput::className(), [
                'jsOptions' => [
                    'allowExtensions' => false,
                    'onlyCountries' => ['in'],
                    'nationalMode' => false,
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?=
            $form->field($caApplicationFormModel, 'qualification_enc_id')->dropDownList(
                $qualifications, [
                'prompt' => 'Select Qualification',
            ])->label(Yii::t('frontend', 'Qualification'));
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($caApplicationFormModel, 'college')->textInput(['autocomplete' => 'off', 'placeholder' => $caApplicationFormModel->getAttributeLabel('college')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?=
            $form->field($caApplicationFormModel, 'state_enc_id')->dropDownList(
                $states, [
                'prompt' => 'Select State',
                'onchange' => '
                            $("#cities_drp").empty().append($("<option>", {
                                value: "",
                                text : "Select City"
                            }));
                            $.post(
                                "' . Url::toRoute("cities/get-cities-by-state") . '",
                                {id: $(this).val(),_csrf: $("input[name=_csrf]").val()},
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
            $form->field($caApplicationFormModel, 'city_enc_id')->dropDownList(
                [], [
                'prompt' => 'Select City',
                'id' => 'cities_drp',
            ]);
            ?>
        </div>
    </div>
<?php
foreach ($applicationQuestionsModel as $question) {
    ?>
    <div class="row">
        <div class="col-md-12">
            <?php
            echo $form->field($caApplicationFormModel, 'answers[' . $question['application_question_enc_id'] . ']')->textArea(['autocomplete' => 'off', 'rows' => 5, 'placeholder' => $caApplicationFormModel->getAttributeLabel($question['question'])]);
            ?>
        </div>
    </div>
    <?php
}
?>
    <div class="row">
        <div class="form-group">
            <div class="form-group col-md-12">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-lg btn-block mt-15']); ?>
            </div>
        </div>
    </div>
<?php
ActiveForm::end();

$this->registerCss('
#home {
    height: auto !important;
}
.intl-tel-input {
    width: 100%;
}
');

$this->registerJs("function drp_down(id, data) {
    var selectbox = $('#' + id + '');
    $.each(data, function () {
        selectbox.append($('<option>', {
            value: this.id,
            text : this.name
        }));
    });
}", View::POS_HEAD);