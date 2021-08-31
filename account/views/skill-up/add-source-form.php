<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;


?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?= Yii::t('account', 'Add New Source'); ?></h4>
    </div>
<?php
$eform = ActiveForm::begin([
    'id' => 'add_source',
    'fieldConfig' => [
        'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}{error}</div>",
    ]
]);
?>
    <div class="row pt-20">
        <div class="col-md-5">
            <div class="office-gallery">
                <div class="g-image-preview">
                    <div id="employeeImagePreview"
                         style="background-image: url('https://via.placeholder.com/200x200?text=Logo');">
                    </div>
                </div>
                <div class="g-image-edit">
                    <?= $eform->field($addSourceForm, 'image', [
                        'template' => '{error}{input}',
                    ])->fileInput(['class' => '', 'id' => 'employeeImageUpload', 'accept' => '.png, .jpg, .jpeg']);
                    ?>
                    <label for="employeeImageUpload">Select Image</label>
                    <p class="ot-image help-block help-block-error"></p>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="col-md-12">
                <?= $eform->field($addSourceForm, 'source_name')->textInput(['class' => 'form-control']); ?>
            </div>
            <div class="col-md-12">
                <?= $eform->field($addSourceForm, 'link')->textInput(['class' => 'form-control'])->hint('e.g: https://youtube.com'); ?>
            </div>
            <div class="col-md-12 mt-20">
                <?= $eform->field($addSourceForm, 'description')->textArea(['rows' => 6, 'class' => 'form-control']); ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <?= Html::submitbutton('Add', ['class' => 'btn btn-primary custom-buttons2 sources-main']); ?>
        <?= Html::button('Close', ['class' => 'btn default custom-buttons2', 'data-dismiss' => 'modal']); ?>
    </div>
<?php
ActiveForm::end();
?>
<?php
$this->registerCss('
.has-error .form-group .help-block.help-block-error, .ot-image{
    opacity: 1 !important;
    color: #e73d4a !important;
    filter: alpha(opacity=100);
}
.form-group.form-md-line-input .help-block{
    opacity: 1;
    margin-top: 0px;
    color: #36c6d3;
}
.help-block ~ .help-block.help-block-error{
    bottom: -40px;
}
.office-gallery {
    position: relative;
    max-width: 280px;
    margin: 30px auto;
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
.office-gallery .g-image-edit label,
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
    } else {
        $('#employeeImagePreview').css('background-image', 'url("https://via.placeholder.com/200x200?text=Logo")');
    }
}
$("#employeeImageUpload").change(function() {
    readGalleryImgURL(this);
});

$(document).on('submit', '#add_source', function(event) {
    var btn = $('.sources-main');
    event.preventDefault();
    event.stopImmediatePropagation();
    if ( btn.data('requestRunning') ) {
        return false;
    }
    btn.data('requestRunning', true);
    $.ajax({
        url: "/account/skill-up/add-source",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache:false,
        processData: false,
        beforeSend:function(){
            btn.html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>Loading');
            $('.sav_benft').prop('disabled', 'disabled');
            $('#page-loading').fadeIn(1000);
        },
        success: function (response) {
            $('#page-loading').fadeOut(1000);
            btn.html('Add');
            if (response.status === 200) {
                toastr.success(response.message, response.title);
                var mySelect = $('#source_id');
                var source_text = $('#sourceInputElem');
                mySelect.attr('value',response.id);
                source_text.val(response.val);
                
            } else if(response.status === 201) {
                toastr.error(response.message, response.title);
            } else {
                toastr.error(response.message, response.title);
            }
            $('#modal').modal('hide');
        },
        complete: function() {
            btn.html('Add');
            btn.data('requestRunning', false);
        },
        error: function(){
            toastr.error('An error has occurred, Please try again', 'Error Occurred');
            btn.html('Add');
            btn.data('requestRunning', false);
        }
    });
});
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);