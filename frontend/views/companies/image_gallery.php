<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?= Yii::t('frontend', 'Image Gallery'); ?></h4>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="office-gallery">
            <div class="g-image-preview">
                <div id="gImagePreview" style="background-image: url(<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-4.jpg') ?>);">
                </div>
            </div>
            <div class="g-image-edit">
                <?php
                    $gform = ActiveForm::begin([
                        'id' => 'upload-gallary-image',
                        'options' => ['enctype' => 'multipart/form-data'],
                    ]);

                    echo $gform->field($companyImagesForm, 'image', [
                        'template' => '{input}',
                        'options' => ['tag' => false]])->fileInput(['class' => '', 'id' => 'gImageUpload', 'accept' => '.png, .jpg, .jpeg']);
                ?>
<!--                <input type='file' id="gImageUpload" accept=".png, .jpg, .jpeg" />-->
                <label for="gImageUpload">Select Image</label>
                <?= Html::submitbutton('Upload Image', ['class' => 'btn btn-primary custom-buttons2 sav_benft']); ?>
                <?php
                ActiveForm::end();
                ?>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <?= Html::button('Close', ['class' => 'btn default custom-buttons2', 'data-dismiss' => 'modal']); ?>
</div>
<?php
$this->registerCss('
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
            $('#gImagePreview').css('background-image', 'url('+e.target.result +')');
            $('#gImagePreview').hide();
            $('#gImagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#gImageUpload").change(function() {
    readGalleryImgURL(this);
});

$(document).on('submit', '#upload-gallary-image', function(event) {
    var btn = $('.sav_benft');
    event.preventDefault();
    event.stopImmediatePropagation();
    if ( btn.data('requestRunning') ) {
        return false;
    }
    
    btn.data('requestRunning', true);
    
    $.ajax({
        url: "/companies/add-gallery-images",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache:false,
        processData: false,
        beforeSend:function(){
            $('.sav_benft').prop('disabled', true);
            $('#page-loading').fadeIn(1000);
        },
        success: function (response) {
            $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
                $.pjax.reload({container: '#image_gallery', async: false});
            } else {
                toastr.error(response.message, response.title);
            }
            $('#modal').modal('hide');
        },
        complete: function() {
            btn.data('requestRunning', false);
        }
    });
});
// $(document).on('click', '.sav_benft', function(){
//     $('.sav_benft').prop('disabled', 'disabled');
// });
JS;
$this->registerJs($script);