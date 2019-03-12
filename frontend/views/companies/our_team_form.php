<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?= Yii::t('frontend', 'Add Employee'); ?></h4>
    </div>
<?php
$eform = ActiveForm::begin([
    'id' => 'add_employee',
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{error}{hint}</div>",
    ]
]);
?>
    <div class="row">
        <div class="col-md-5">
            <div class="office-gallery">
                <div class="g-image-preview">
                    <div id="employeeImagePreview"
                         style="background-image: url(<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-03.jpg') ?>);">
                    </div>
                </div>
                <div class="g-image-edit">
                    <?= $eform->field($organizationEmployeesForm, 'image', [
                        'template' => '{input}',
                        'options' => ['tag' => false]])->fileInput(['class' => '', 'id' => 'employeeImageUpload', 'accept' => '.png, .jpg, .jpeg']);
                    ?>
                    <label for="employeeImageUpload">Select Image</label>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="col-md-6">
                <?= $eform->field($organizationEmployeesForm, 'first_name')->textInput(['class' => 'capitalize form-control']); ?>
            </div>
            <div class="col-md-6">
                <?= $eform->field($organizationEmployeesForm, 'last_name')->textInput(['class' => 'capitalize form-control']); ?>
            </div>
            <div class="col-md-12">
                <?= $eform->field($organizationEmployeesForm, 'designation')->textInput(['class' => 'form-control']); ?>
            </div>
            <div class="col-md-12">
                <?= $eform->field($organizationEmployeesForm, 'facebook')->textInput(['class' => 'form-control']); ?>
            </div>
            <div class="col-md-12">
                <?= $eform->field($organizationEmployeesForm, 'twitter')->textInput(['class' => 'form-control']); ?>
            </div>
            <div class="col-md-12">
                <?= $eform->field($organizationEmployeesForm, 'linkedin')->textInput(['class' => 'form-control']); ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <?= Html::submitbutton('Add', ['class' => 'btn btn-primary custom-buttons2']); ?>
        <?= Html::button('Close', ['class' => 'btn default custom-buttons2', 'data-dismiss' => 'modal']); ?>
    </div>
<?php
ActiveForm::end();
?>
<?php
$this->registerCss('
.has-error .form-group .help-block.help-block-error{
    opacity: 1 !important;
    color: #e73d4a !important;
    filter: alpha(opacity=100);
}
.office-gallery {
    position: relative;
    max-width: 280px;
    margin: 50px auto;
    margin-bottom: 0px;
}
.office-gallery .g-image-edit {
    position: relative;
    z-index: 1;
    padding: 20px 0px;
    text-align: center;
}
.office-gallery .g-image-edit input {
    display: none;
}
.office-gallery .g-image-edit input + label {
    display: inline-block;
    width: 124px;
    border-radius: 4px;
    background: #FFFFFF;
    border: 1px solid transparent;
    box-shadow: 0px 1px 5px 1px rgba(0, 0, 0, 0.12);
    cursor: pointer;
    font-weight: normal;
    padding:6px 8px;
    font-size: 12px;
    font-weight: 600;
    text-align:center;
    transition: all 0.2s ease-in-out;
    margin:0px;
    margin-right: 10px;
    text-transform: uppercase;
}
.office-gallery .g-image-edit input + label:hover {
    background: #f1f1f1;
    border-color: #d6d6d6;
}
.office-gallery .g-image-preview {
    width: 192px;
    height: 192px;
    position: relative;
    border-radius: 5px;
    border: 6px solid #F8F8F8;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
    margin: auto;
}
.office-gallery .g-image-preview > div {
    width: 100%;
    height: 100%;
    border-radius: 5px;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}
');
$script = <<< JS
function readGalleryImgURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#employeeImagePreview').css('background-image', 'url('+e.target.result +')');
            $('#employeeImagePreview').hide();
            $('#employeeImagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#employeeImageUpload").change(function() {
    readGalleryImgURL(this);
});

$(document).on('submit', '#add_employee', function(event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    $.ajax({
        url: "/companies/add-employee",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache:false,
        processData: false,
        beforeSend:function(){     
            $('#page-loading').fadeIn(1000);  
        },
        success: function (response) {
            $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
                $.pjax.reload({container: '#our_team', async: false});
            } else {
                toastr.error(response.message, response.title);
            }
            $('#modal').modal('hide');
        }
    });
});
JS;
$this->registerJs($script);