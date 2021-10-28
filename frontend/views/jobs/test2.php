<?php
$this->params['header_dark'] = true;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="box_outer">
    <?php $form = ActiveForm::begin([
        'id' => 'genrate_image',
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <?= $form->field($model, 'logo')->fileInput(['autocomplete' => 'off','id'=>'logo','accept' => '.png'])->label('Add Company Logo'); ?>
        </div>
        <div class="col-md-4 col-md-offset-4">
            <?= $form->field($model, 'company_name')->textInput(['class' => 'capitalize form-control', 'id' => 'company_name', 'placeholder' => 'Company Name'])->label(false); ?>
        </div>
        <div class="col-md-4 col-md-offset-4">
            <?= Html::submitButton('Download Warning Board', ['class' => 'btn btn-success btn-md gnt-btn']) ?>
        </div>
        <br>
        <br>
        <div class="col-md-4 col-md-offset-4">
            <a href="" target="_blank" id="db_f">Click Here To Download Your File</a>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
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
$this->registerCss("
#db_f{
display:none;
color: #303096;
margin-top: 16px;
}
.control-label{
    color: #00a0e3;
    font-size: 14px;
    font-weight: 500;
    font-family: sans-serif;
}
.box_outer{
    margin-top: 50px;
}
");
$script = <<< JS
var formData = new FormData();
var el = document.getElementById('demo');
var vanilla = new Croppie(el, {
    viewport: { width: 200, height: 200 },
    boundary: { width: 300, height: 300 },
    enforceBoundary: false,
    showZoomer: true,
    enableZoom: true,
    mouseWheelZoom: true,
    maxZoomedCropWidth: 10,
});
$("#logo").change(function() {
    readURL(this);
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#cropImagePop').modal('show');
            var rawImg = e.target.result;
            setTimeout(function() {
                renderCrop(rawImg);
            }, 500);
            
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function renderCrop(img){
    vanilla.bind({
        url: img,
        points: [20,20,20,20]
        // orientation: 4
    });
}
document.querySelector('.vanilla-result').addEventListener('click', function (ev) {
   vanilla.result('blob').then(function (data) {
       formData.append('logo', data);
        $('#cropImagePop').modal('hide');
    });
    });
$(document).on('submit','#genrate_image',function(event) {
   event.preventDefault();
   event.stopImmediatePropagation();
   var name = $('#company_name').val();
   if (name.length==0||name.length>80)
       {
           alert('character limit 80 only');
           return false
       }
   formData.append('company_name', name);
   $('#db_f').hide();
   $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: formData,
            dataType:'JSON',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend:function(){
               $('.gnt-btn').attr("disabled", "true");
               $('.gnt-btn').html('Download Warning Board <i class="fas fa-circle-notch fa-spin fa-fw"></i>');
            },
            success: function (response) {
                $('.gnt-btn').removeAttr("disabled");
                $('.gnt-btn').html('Download Warning Board');
                if (response.status==200)
                    {
                        $('#db_f').css('display','block');
                        $('#db_f').attr('href',response.url);
                    }
            }
        });
})
JS;
$this->registerJs($script);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
