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
                <div class="light-box-footer">
                    <a href="/account/dashboard" class="services-submit">
                        <span>Skip</span>
                        <span>
                          <svg width="50px" height="14px" viewBox="0 0 66 43" version="1.1"
                               xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <path class="one"
                                    d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z"
                                    fill="#FFFFFF"></path>
                              <path class="two"
                                    d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z"
                                    fill="#FFFFFF"></path>
                              <path class="three"
                                    d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z"
                                    fill="#FFFFFF"></path>
                            </g>
                          </svg>
                        </span>
                    </a>
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
    padding-bottom: 50px;
}
.light-box-footer{
    position: absolute;
    bottom: 8px;
    right: 8px;
}
.services-submit{
    display: flex;
    padding: 5px 15px !Important;
    padding-right: 20px !Important;
    text-transform: none !Important;
    text-decoration: none;
    font-size: 14px !Important;
    color: #fff !important;
    outline: 0!important;
    border-radius: 4px;
    border: 1px solid transparent;
    box-shadow: 0 1px 3px rgba(0,0,0,.1), 0 1px 2px rgba(0,0,0,.18);
    transition: box-shadow .28s cubic-bezier(.4,0,.2,1);
    background-color: #00A0E3 !important;
}
.services-submit span:nth-child(2) {
    transition: 0.5s;
    margin-right: 0px;
    margin-top: 2px;
    width: 15px;
    margin-left: 0px;
    position: relative;
    top: 12%;
}
.services-submit:hover span:nth-child(2), .services-submit:focus span:nth-child(2) {
    transition: 0.5s;
    margin-right: 15px;
}

path.one {
    transition: 0.4s;
    transform: translateX(-60%);
}

path.two {
    transition: 0.5s;
    transform: translateX(-30%);
}

.services-submit:hover path.three, .services-submit:focus path.three {
    animation: color_anim 1s infinite 0.2s;
}

.services-submit:hover path.one, .services-submit:focus path.one {
    transform: translateX(0%);
    animation: color_anim 1s infinite 0.6s;
}

.services-submit:hover path.two, .services-submit:focus path.two {
    transform: translateX(0%);
    animation: color_anim 1s infinite 0.4s;
}

/* SVG animations */

@keyframes color_anim {
    0% {
        fill: white;
    }
    50% {
        fill: #FBC638;
    }
    100% {
        fill: white;
    }
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