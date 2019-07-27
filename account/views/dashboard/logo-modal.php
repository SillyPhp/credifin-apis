<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

if ($organization['logo']) {
    $image_path = Yii::$app->params->upload_directories->organizations->logo_path . $organization['logo_location'] . DIRECTORY_SEPARATOR . $organization['logo'];
    $image = Yii::$app->params->upload_directories->organizations->logo . $organization['logo_location'] . DIRECTORY_SEPARATOR . $organization['logo'];
    if (!file_exists($image_path)) {
        $image = "https://ui-avatars.com/api/?name=" . $organization['name'] . '&size=200&rounded=false&background=' . str_replace("#", "", $organization['initials_color']) . '&color=ffffff';
    }
} else {
    $image = "https://ui-avatars.com/api/?name=" . $organization['name'] . '&size=200&rounded=false&background=' . str_replace("#", "", $organization['initials_color']) . '&color=ffffff';
}
?>
<div class="light-box-modal">
    <div class="light-box-in">
        <div class="light-box-description">
            <div class="light-box-heading">
                <h3>Update your Logo</h3>
            </div>
            <div class="logo">
                <img id="logo-img" src="<?= Url::to($image); ?>">
            </div>
            <div class="actions">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'upload-logo',
                    'options' => ['enctype' => 'multipart/form-data'],
                ])
                ?>
                <div class="text-center">
                    <?=
                    $form->field($companyLogoFormModel, 'logo', [
                        'template' => '{input}',
                        'options' => ['tag' => false]])->fileInput(['class' => '', 'id' => 'logoUpload', 'accept' => '.png, .jpg, .jpeg']);
                    ?>
                    <label for="logoUpload" class="btn btn-primary">
                        Change Profile Picture
                    </label>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                </div>
                <div class="modal-body">
                    <div id="demo"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary custom-buttons2 vanilla-result">Done</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
#logoUpload{
  display: none;
}
.logo {
    display: block;
    width: 200px;
    margin: 10px auto;
    border: 4px solid #f3f3f3;
    box-shadow: 0px 1px 10px 0px #ddd;
    border-radius: 4px;
}
.logo img {
    border-radius: 4px;
    max-height: 200px;
    width: 100%;
}
.light-box-heading{
    padding: 10px;
    border-bottom: 1px solid #ddd;
    margin-bottom: 20px;
}
.light-box-heading h3{
    margin: 4px;
    font-weight: 500;
    font-size: 20px;
}
.light-box-modal{
    position: fixed;
    background-color: #000000b5;
    width: 100%;
    height: 100%;
    z-index: 9999;
    top: 0;
    left: 0;
}
.light-box-in{
    position: relative;
    width: 90%;
    max-width: 450px;
    margin: auto;
//    height: 78vh;
    height: 380px;
    top: calc(48vh - 190px);
    background-color: #fff;
    border-radius: 4px;
    overflow: hidden;
    box-shadow: 0px 1px 5px 1px #eeeeeea3;
}
@media screen and (max-width: 992px){
    .light-box-in{
        height: 400px;
    }
}
');
$this->registerJs('
$("#logoUpload").change(function() {
    readURL(this);
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#cropImagePop").modal("show");
            var rawImg = e.target.result;
            setTimeout(function() {
                renderCrop(rawImg);
            }, 500);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
var el = document.getElementById("demo");
var vanilla = new Croppie(el, {
    viewport: { width: 200, height: 200 },
    boundary: { width: 300, height: 300 },
    enforceBoundary: false,
    showZoomer: true,
    enableZoom: true,
    // enableExif: true,
    mouseWheelZoom: true,
    maxZoomedCropWidth: 10,
    // enableOrientation: true
});
function renderCrop(img){
    vanilla.bind({
        url: img,
        points: [20,20,20,20]
        // orientation: 4
    });
}

document.querySelector(".vanilla-result").addEventListener("click", function (ev) {
    vanilla.result({
        type: "base64",
        // format:"jpeg",
    }).then(function (data) {
        $.ajax({
            url: "/organizations/update-logo",
            method: "POST",
            data: {data:data},
            beforeSend:function(){
                $("#page-loading").fadeIn(1000);
            },
            success: function (response) {
                $("#page-loading").fadeOut(1000);
                $("#cropImagePop").modal("hide");
                if (response.title == "Success") {
                    toastr.success(response.message, response.title);
                    $("#logo-img").attr("src", data);
                    window.location.replace("/account/dashboard ");
                } else {
                    toastr.error(response.message, response.title);
                }
            }
        });
    });
});
');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.js', ['depends' => [\yii\web\JqueryAsset::className()]]);