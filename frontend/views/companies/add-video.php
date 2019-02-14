<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use borales\extensions\phoneInput\PhoneInput;
?>
    <div class="modal-header">
        <h4 class="modal-title"><?= Yii::t('frontend', 'Enter Youtube link here'); ?></h4>
    </div>
<?php
$form = ActiveForm::begin([
    'id' => 'video-form',
    'fieldConfig' => [
        'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
    ]
]);
?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?= $form->field($organizationVideoForm, 'link')->textInput(['autocomplete' => 'off', 'id' => 'url']); ?>
        </div>
    </div>
    <div class="row title">
        <div class="col-md-6 col-md-offset-3">
            <?= $form->field($organizationVideoForm, 'name')->textInput(['autocomplete' => 'off', 'readonly'=>'readonly', 'id' => 'youtube-title']); ?>
        </div>
    </div>
    <div class="row description">
        <div class="col-md-6 col-md-offset-3">
            <?= $form->field($organizationVideoForm, 'description')->textArea(['rows' => 6, 'autocomplete' => 'off', 'readonly'=>'readonly', 'id' => 'youtube-description']); ?>
        </div>
    </div>
    <div class="modal-footer">
        <?= Html::submitbutton('Save', ['class' => 'btn btn-primary btn-circle sav_loc']); ?>
        <?= Html::button('Close', ['class' => 'btn default btn-circle cancel', 'data-dismiss' => 'modal']); ?>
    </div>
<?php ActiveForm::end(); ?>
<?php
$this->registerCss("
.modal-header{
    color:blue;
}
         ");
$script = <<<JS
$(document).ready(function () {
    console.log("js is woking");    
    $(".row.title").hide();
    $(".row.description").hide();
    $('#url').blur(geturl);
    function geturl(){
        var link = $('#url').val();
        var videoid = link.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
        $.ajax({
            url: 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id='+videoid[1]+'&key=AIzaSyCdo0IpmiavCbEIY_BGb8O0XCqKpbxPVIk',
            contentType: "application/json",
            dataType: "json",
            success: function(data){
                $("#youtube-title").val(data.items[0].snippet.title);
                $("#youtube-description").val(data.items[0].snippet.description);
                //$("#cover-image").val(data.items[0].snippet.thumbnails.high.url);
            }
        });
        $(".row.title").show();
        $(".row.description").show();
        //$("#tooltip").show();
        //$(".tooltip1").show();
    }
        
$(document).on('submit', '#video-form', function (event) {
    event.stopImmediatePropagation();    
    event.preventDefault();
    var url = $(this).attr('action');
    var data = $(this).serialize();
    $.ajax({
        url: url,
        type: 'post',
        data: data,
        beforeSend:function()
        {     
              $("#wait").css("display", "block");  
              $('.sav_loc').prop('disabled','true');
              $('.cancel').prop('disabled','true');
        },
        success: function (response) {
        console.log("this is response", response);
            if (response == 1) {
                toastr.success("Video Uploaded");
                $("#video-form")[0].reset();
                $("#wait").css("display", "none");
                $.pjax.reload({container: '#pjax_locations3', async: false});
                $('#modal').modal('toggle');
            } else {
//                $("#wait").css("display", "none");
                $('.sav_loc').removeAttr("disabled");
                $('.cancel').removeAttr("disabled");
                toastr.error("This video can not be uploaded.");
            }
        }
    });
});
//    $("#field-hidden").hide();
  //  $(document).on('change', '#video_type', function () {
    //    var value = $(this).val();
    //    if (value == "Others"){
    //        $("#field-hidden").show();
    //    } else {
    //        $("#field-hidden").hide();
      //  }
//    });
  //  $('#categories, #sub-cat').tagsinput({
    //    maxTags: 1,
      //  trimValue: true
   // });
   
});
//        
//$('.add-more').click(function() {
//  var clone = $('#careers-form div > input').clone('#careers-form div > input');
//  $('#careers-form').append(clone);
//});
JS;
$this->registerJs($script);