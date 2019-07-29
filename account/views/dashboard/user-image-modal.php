<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>
    <div class="light-box-modal">
        <div class="light-box-in">
            <div class="light-box-description">
                <div class="light-box-heading">
                    <h3>Update your Profile Image</h3>
                </div>
                <div class="logo">
                    <?php if (!empty(Yii::$app->user->identity->image)) {
                        $image = Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image; ?>
                        <img src="<?= $image ?>" id="logo-img">
                    <?php } else {
                        $name = Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name;
                        $color = ltrim(Yii::$app->user->identity->initials_color, '#');
                        $image = "https://ui-avatars.com/api/?name={$name}&size=200&rounded=false&background={$color}&color=ffffff";
                        ?>
                        <img src="<?= $image ?>" id="logo-img">
                    <?php } ?>
                </div>
                <div class="actions">
                    <?php $form = ActiveForm::begin(['id' => 'userProfilePicture', 'action' => '/users/update-profile-picture']) ?>
                    <div class="text-center">
                        <?= $form->field($userProfilePicture, 'profile_image', ['template' => '{input}{error}', 'options' => []])->fileInput(['id' => 'tg-photogallery', 'class' => 'tg-fileinput', 'accept' => 'image/*'])->label(false) ?>
                        <label for="tg-photogallery" class="btn btn-primary">
                            Change Profile Picture
                        </label>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
#tg-photogallery{
  display: none;
}
.logo {
    display: block;
    width: 180px;
    margin: 10px auto;
    border: 4px solid #f3f3f3;
    box-shadow: 0px 1px 10px 0px #ddd;
    border-radius: 4px;
}
.logo img {
    border-radius: 4px;
    height: 180px;
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
$("#tg-photogallery").change(function() {
    readURL(this);
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var rawImg = e.target.result;
            $("#logo-img").attr("src",rawImg);
            setTimeout(function() {
                $("#tg-photogallery").submit();
            }, 500);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$(document).on("submit","#userProfilePicture",function(event){
    event.preventDefault();
    data = new FormData(this);
    var f_url = $(this).attr("action");
    $.ajax({
     url:f_url,
     data:data,
     method:"post",
     contentType: false,
     cache:false,
     processData: false,
     beforeSend:function() {
        $("#page-loading").fadeIn(1000);
     },
     success:function(response) {
        $("#page-loading").fadeOut(1000);
        if (response.status == "success") {
            toastr.success(response.message, response.title);
            window.location.replace("/account/dashboard ");
        } else {
            toastr.error(response.message, response.title);
        }
     }
  })
});
');