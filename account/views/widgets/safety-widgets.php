<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
    <section class="">
        <div class="row">
            <div class="col-md-12">
                <div class="quick-review row colorYellow">
                    <div class="tab" id="step-1">
                        <div class="row quick-review-inner">
                            <div class="col-md-5">
                                <div class="quick-review-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/safety-posters/posters-logo.png'); ?>">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h2 class="text-h">Start Customizing Posters with your own Company's Name & Logo</h2>
                                <div class="row">
                                    <?php $form = ActiveForm::begin([
                                        'id' => 'genrate_image',
                                        'options' => ['enctype' => 'multipart/form-data'],
                                        'action'=>'/jobs/image-script'
                                    ]); ?>
                                    <div class="col-md-6 mb-15">
                                        <label class="cmp-name for-text">Enter Company Name</label>
<!--                                        <input type="text" class="form-control for-n-cmp">-->
                                        <?= $form->field($scriptModel, 'company_name',['template'=>'{input}{error}'])->textInput(['class' => 'capitalize form-control for-n-cmp', 'id' => 'company_name', 'placeholder' => 'Company Name'])->label(false); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="choose-logo for-text">Choose Your Logo (.png)</label>
                                        <?= $form->field($scriptModel, 'logo')->fileInput(['autocomplete' => 'off','class'=>'form-control for-choose','id'=>'logo','accept' => '.png'])->label(false); ?>
<!--                                        <input type="file" class="form-control for-choose" id="FileAttachment"-->
<!--                                               required="required" multiple="multiple" title="">-->
                                    </div>
                                    <div class="col-md-12 dwn">
                                        <?= Html::submitButton('Customize & Download', ['class' => 'sub-btn gnt-btn']) ?>
<!--                                        <button class="sub-btn">Customize & Download</button>-->
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="div_center">
                        <a href="" class="btn" target="_blank" id="db_f">Click Here To Download Your .Zip File</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 progress-container">
                <div id="prog_bar">
                    <div class="progress progress-striped active" style="height: 18px">
                        <div class="progress-bar progress-bar-success" style="width:10%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
.progress.active .progress-bar {
    -webkit-transition: none !important;
    transition: none !important;
}
#prog_bar
{
display:none;
}
#db_f{
display:none;
color: #303096;
margin-top: 16px;
}
.safety-links-share a{
    color:#000;
}
.colorYellow{
    background: #ffcc00;
    padding: 20px 0;
    position: relative;   
}
.sub-btn {
     border: 2px solid #000;
    background: #000;
    color: #ffcc00;
    font-size: 15px;
    font-weight: 500;
    text-transform: capitalize;
    padding: 8px 15px;
    letter-spacing: .5px; 
    transition: .3s ease;
}
.sub-btn:hover{
    color: #000;
    border-color: #000;
    background: #ffcc00;    
    transition: .3s ease;
}

.quick-review-img img{
    max-width: auto;
    width: 100%;
}
.quick-review h2 {
   text-align: center;
    font-size: 18px;
    font-family: roboto;
    margin: 0 auto 20px;
    line-height: 25px;
    border-bottom: none;
    font-weight: 500;
    color: #000;
    max-width: 350px;
}
.submit-b{text-align:center;}
.dwn {
   text-align: center;
   margin-top: 15px;
}
.download {
   background: #00a0e3;
   border: none;
   color: #fff;
   padding: 5px 20px;
   font-size: 18px;
   font-family: roboto;
   border-radius: 4px;
}
.mb-15{
    margin-bottom:15px;
}
.for-text {
   font-size: 15px;
    font-family: roboto;
    margin-bottom: 5px;
    text-transform: capitalize;
    font-weight: 500;
    color: #000;
    
}
input::-webkit-file-upload-button, 
input::-moz-file-upload-button,
input::-ms-browse{
    background: transparent !important;
    border: none; 
    height: 37px;
   cursor: pointer;
}
input::-webkit-file-upload-button:focus{
    outline: none;
}
input::-moz-file-upload-button:focus{
    outline: none;
}
.form-control.for-n-cmp, .form-control.for-choose {
    height: 38px;
    background: #fff5cb;
    border-color: #000;
    border-radius: 0; 
    color: #000;
}
.form-control.for-choose{
    padding: 0 !important;
    color: transparent;
    cursor: pointer;
}
.safty-icon img{
    max-width: 150px;
}
.safty-posters{
    margin-top: 25px;
    text-align: center;
    padding: 20px 10px;
}
.quick-review{
    box-shadow: 0 0 10px rgba(0,0,0,.1);     
}
.safty-icon-text h2{
    font-size: 18px;
    font-family: roboto;
    font-weight: 500;
}
.quick-review-action a{  
   text-align:center;
   display:inline-block; 
    padding:5px 15px; 
//    background:#00a0e3; 
    border-radius:4px; 
    font-size:15px; 
    font-weight:500; 
    color:#fff;
    text-decoration: none;
    text-transform: capitalize;
    font-family: roboto;
}
.quick-review-action a:hover, .quick-review-action a:focus, .quick-review-action:active{
   outline: none;
   box-shadow: none;
} 
');
$script = <<<JS
$('.for-choose').click(function() {
  $('.for-choose').css('color', '#000');
})

var formData = new FormData();
var el = document.getElementById('demo');
var vanilla = new Croppie(el, {
    viewport: { width: 300, height: 300 },
    boundary: { width: 400, height: 400 },
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
    $("#prog_bar").hide(); 
   $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: formData,
            dataType:'JSON',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend:function(){
                $("#prog_bar").show();
                $(".progress-bar").css('width','0%');
                $(".progress-bar").animate({
                width: "100%"
                }, 38000);
               $('.gnt-btn').attr("disabled", "true");
               $('.gnt-btn').hide();
            },
            success: function (response) {
                $('.gnt-btn').removeAttr("disabled");
                $("#prog_bar").hide();
                if (response.status==200) 
                    {
                        //$('.gnt-btn').show();
                        $('#db_f').css('display','block');
                        $('#db_f').attr('href',response.url);
                    }
                else{ 
                    swal({
                        title:"",
                        text: "Server Error, PLease Reload The Page and Try Again !!!",
                        });
                }
            }
        });
});
JS;
$this->registerJS($script);
?>