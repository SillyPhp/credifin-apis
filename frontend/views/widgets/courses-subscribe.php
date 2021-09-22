<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

    <section class="sub-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cou-heading">Be the first to know about new course and discounts: subscribe to
                        newsletter
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'course-subscribe-form',
                    'options' => ['enctype' => 'multipart/form-data'],
                ]);
                ?>
                <div class="col-md-5">
                    <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off', 'placeholder' => 'Enter Name', 'class' => 'fm-set'])->label(false); ?>
                </div>
                <div class="col-md-5">
                    <?= $form->field($model, 'email')->textInput(['autocomplete' => 'off', 'placeholder' => 'Enter Email', 'class' => 'fm-set'])->label(false); ?>
                </div>
                <div class="col-md-2">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-default sub-btn', 'id' => 'subscribeBtn']); ?>
                </div>
                <?php
                ActiveForm::end();
                ?>
            </div>
        </div>
    </section>

<?php
$this->registercss('
.sub-sec{
    background-color: #00a0e3;
    padding: 10px 0 40px;
    margin: 25px 0;
}
.cou-heading {
    font-size: 22px;
    color: #fff;
    padding-bottom: 10px;
    text-transform: capitalize;
    font-family: roboto;
    font-weight: 500;
}
.fm-set {
    border-radius: 4px;
    font-size: 16px;
    font-family: roboto;
    width: 100%;
    height: 45px;
    padding: 0 15px;
    border: none;
}
.sub-btn{
    padding: 7px 25px;
    font-size: 18px;
    color: #fff;
    font-family: roboto;
    transition: ease-out .3s;
    background-color:#00a0e3;
    border:3px solid;
    font-weight: 500;
}
.sub-btn:hover{
    color:#00a0e3;
    background-color:#fff;
    border-color:#fff;
}
');
$subscriberScript = <<<JS
$(document).on('submit', '#course-subscribe-form', function (event) {
    event.preventDefault();
    var form = $(this);
    var btn = $('#'+ $(this).find("button[type=submit]:focus").attr('id'));
    var btn_value = btn.text();
    event.stopImmediatePropagation();
    if ( form.data('requestRunning') ) {
        return false;
    }
    form.data('requestRunning', true);
    var data = form.serialize();
    var method = form.attr('method');
    $.ajax({
        type: method,
        data: data,
        beforeSend: function () {
            btn.attr('disabled', true);
            btn.html('Wait...');
        },
        success: function (response) {
            btn.attr('disabled', false);
            btn.html(btn_value);
            if (response.status == 200) {
                toastr.success(response.message, response.title);
                form[0].reset();
            } else {
                toastr.error(response.message, response.title);
            }
        },
        complete: function() {
            form.data('requestRunning', false);
            btn.attr('disabled', false);
            btn.html(btn_value);
        }
    }).fail(function(data, textStatus, xhr) {
         toastr.error('Invalid URL', 'Error: '+data.responseJSON.message);
         btn.attr('disabled', false);
         btn.html(btn_value);
    });
});
JS;
$this->registerJs($subscriberScript);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);