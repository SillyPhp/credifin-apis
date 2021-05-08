<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\web\JsExpression;

$source_list = ArrayHelper::map($sources, 'source_enc_id', 'name');

?>

<section class="feeds-form pt-100">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="feed-main nd-shadow">
                    <div class="feed-title">Feed Form</div>
                    <?php $form = ActiveForm::begin([
                        'id' => 'feeds_form',
                        'enableClientValidation' => true,
                        'options' => ['enctype' => 'multipart/form-data']
                    ]); ?>
                    <?= $form->field($model, 'channel_name')->hiddenInput(['id' => 'channel_name'])->label(false); ?>
                    <?= $form->field($model, 'channel_id')->hiddenInput(['id' => 'channel_id'])->label(false); ?>
                    <?= $form->field($model, 'video_id')->hiddenInput(['id' => 'video_id'])->label(false); ?>
                    <?= $form->field($model, 'video_tags')->hiddenInput(['id' => 'video_tags'])->label(false); ?>
                    <?= $form->field($model, 'video_duration')->hiddenInput(['id' => 'video_duration'])->label(false); ?>
                    <?= $form->field($model, 'image_url')->hiddenInput(['id' => 'image_url'])->label(false); ?>
                    <div class="feeds-data row">
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <?= $form->field($model, 'source_url')->textInput(['placeholder' => 'Source Url', 'class' => 'form-control', 'id' => 'source_url'])->label(false); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="content-t">Content Type</div>
                            <?= $form->field($model, 'content_type')->radioList(['Video' => 'Video', 'Blog' => 'Blog', 'News' => 'News', 'Podcast' => 'Podcast', 'Course' => 'Course'])->label(false); ?>
                        </div>
                        <div class="col-md-12 mb-30">
                            <div class="content-t mb-20">Cover Image</div>
                            <div id="image-preview">
                                <img src="https://via.placeholder.com/350x350?text=Cover+Image" alt="your image"
                                     class="target set-w"/>
                            </div>
                            <!--                            <img src="-->
                            <? //= Url::to('@eyAssets/images/pages/educational-loans/schoolfee-financing.png') ?><!--"-->
                            <!--                                 alt="your image" class="target set-w"/>-->
                            <div class="custom-file">
                                <!--                                <input type="file" id="file" class="imgInp custom-file-input"-->
                                <!--                                       aria-describedby="inputGroupFileAddon01">-->
                                <label class="custom-file-label" for="file">Choose Image</label>
                                <?= $form->field($model, 'image')->fileInput(['id' => 'file', 'class' => 'imgInp custom-file-input'])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <div class="default text">&nbsp;</div>
                                <?= $form->field($model, 'title')->textInput(['placeholder' => 'Title', 'class' => 'form-control setResult', 'targetElem' => 'titleElem'])->label(false); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <div class="default text">Select Source</div>
                                <?php echo $form->field($model, 'source_id')->dropDownList(
                                    $source_list,
                                    ['prompt' => 'Choose...']
                                )->label(false); ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <?= $form->field($model, 'embed_code')->textInput(['placeholder' => 'Embed Code', 'class' => 'form-control'])->label(false); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <?= $form->field($model, 'author')->textInput(['placeholder' => 'Author', 'class' => 'form-control setResult', 'targetElem' => 'authorElem'])->label(false); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <?= $form->field($model, 'short_description')->textInput(['placeholder' => 'Short Description', 'class' => 'form-control', 'id' => 'short_desc'])->label(false); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'skills')->widget(Select2::classname(), [
//                                'data' => $data,
                                'options' => ['multiple' => true, 'placeholder' => 'Search for a skills ...', 'class' => 'form-control'],
                                'pluginOptions' => [
//                                    'allowClear' => true,
                                    'minimumInputLength' => 1,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => '/skills-up/skill-list',
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(data) { return data.text; }'),
                                    'templateSelection' => new JsExpression('function (data) { return data.text; }'),
                                ],
//                                'pluginEvents' => [
//                                    'change' => 'function(results){
//                                           console.log(results.target);
//                                         }'
//                                ],
                            ]); ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'industry')->widget(Select2::classname(), [
//                                'data' => $data,
                                'options' => ['multiple' => true, 'placeholder' => 'Search for a industry ...', 'class' => 'form-control'],
                                'pluginOptions' => [
//                                    'allowClear' => true,
                                    'minimumInputLength' => 2,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => '/skills-up/industry-list',
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                                        'cache' => true
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-12 mt-20 mb-30">
                            <?= $form->field($model, 'description')->textArea(['placeholder' => 'Description', 'class' => 'form-control', 'id' => 'editor'])->label(false); ?>
                        </div>
                        <div class="col-md-12">
                            <div class="submit-b">
                                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>
                                <a href="javascript:;" id="preview-button">PREVIEW</a>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feed-box dash-inner-box nd-shadow">
                    <!--                    <div class="rec-batch">Recommended</div>-->
                    <div class="feed-img">
                        <img src="https://via.placeholder.com/350x350?text=Cover+Image" alt="your image"
                             class="target"/>
                    </div>
                    <h3 class="feed-heading">
                        <a href="javascript:;" id="titleElem">Post Title</a>
                    </h3>
                    <div class="author-s">
                        <div class="author list-data">
                            <i class="fas fa-user"></i><span id="authorElem"> Author</span>
                        </div>
                        <div class="source">
                            <i class="fas fa-link"></i><span id="sourceElem"> Source</span>
                        </div>
                    </div>
                    <p class="feed-content" id="descriptionElem">

                    </p>
                    <div class="feed-btns">
                        <div class="like-dis disabled">
                            <a href="javascript:;" class="like-btn default" title="Like"><i class="fa fa-thumbs-up"></i></a>
                        </div>
                        <div class="feed-share disabled">
                            <a href="javascript:;" class="fb">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="javascript:;" class="wts-app">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="javascript:;" class="tw">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="javascript:;" class="male">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$source_youtube_key = array_search('Youtube', $source_list);
$this->registerCss('
.disabled,.disabled *{
    cursor:not-allowed !important;
}
.checkbox-skill {
  position: relative;
  margin: 0.5rem;
  font-family: Arial, sans-serif;
  line-height: 135%;
  cursor: pointer;
}

.checkboxx {
//  position: relative;
  top: -0.375rem;
  margin: 0 1rem 0 0 !important;
  cursor: pointer;
}
.checkboxx:before {
  -webkit-transition: all 0.3s ease-in-out;
  -moz-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out;
  content: "";
  position: absolute;
  left: 0;
  z-index: 1;
  width: 1rem;
  height: 1rem;
  border: 2px solid #f2f2f2;
}
.checkboxx:checked:before {
  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  -o-transform: rotate(-45deg);
  transform: rotate(-45deg);
  height: 0.5rem;
  border-color: #00a0e3;
  border-top-style: none;
  border-right-style: none;
}
.checkboxx:after {
  content: "";
  position: absolute;
  top: -0.125rem;
  left: 0;
  width: 1.1rem;
  height: 1.1rem;
  background: #fff;
  cursor: pointer;
}

body {
    background-image: url(/assets/themes/ey/images/backgrounds/campus-hiring.png) !important;
    background-size: cover !important;
    background-attachment: fixed !important;
    background-repeat: no-repeat !important;
}
.custom-file {
    position: relative;
    width: 130px;
    cursor: pointer;
}
.custom-file-input {
    position: relative;
    z-index: 2;
    cursor: pointer;
    width: 100%;
    height: calc(2.25rem + 2px);
    margin: 0;
    opacity: 0;
}
.custom-file-label {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1;
    padding: 8px 10px;
    line-height: 1.5;
    cursor: pointer;
    color: #fff;
    background-color: #00a0e3;
    border-radius: .25rem;
    font-family: Roboto;
    text-align: center;
    font-size: 15px;
}
.set-w {
    width: 130px;
    height: 100px;
    object-fit: cover;
    padding: 5px;
    margin-bottom: 10px;
    border-radius: 4px;
    box-shadow: 0 0 6px 0px rgb(0 0 0 / 20%);
}
body{font-family:roboto;}
.height-s{height:45px !important;}
.feed-main {
    background-color:#fffffffa;
    padding: 20px;
    margin-bottom: 30px;
}
.nd-shadow {
    box-shadow: 0px 1px 10px 2px #eee !important;
}
.feed-title {
    border-bottom: 1px solid #eee;
    font-size:22px;
    font-family: \'Roboto\';
    text-align: center;
    margin-bottom: 15px;
    color: #333;
    padding-bottom: 10px;
    font-weight: 500;
}
.content-t {
    color: #999;
    font-size: 16px;
    font-family: Roboto;
    font-weight:500 !important;
}
.dis-flex, #content_type{
    display: flex;
    align-items: center;
    justify-content: flex-start;
    flex-wrap: wrap;
    margin-bottom: 20px !important;
}
.md-radio, #content_type > .radio {
    margin: 0px 25px 10px 0;
}
#content_type > .radio label{
    padding-left: 25px;
}
#content_type > .radio label input{
    width: 20px;
    height: 18px;
    margin-top: 5px;
    margin-left: -25px;
}
.md-radio input[type="radio"] {
  display: none;
}
.md-radio input[type="radio"]:checked + label:before {
  border-color: #00a0e3;
  animation: ripple 0.2s linear forwards;
}
.md-radio input[type="radio"]:checked + label:after {
  transform: scale(1);
}
.md-radio label {
    display: inline-block;
    position: relative;
    padding: 0 0 0 25px;
    margin-bottom: 0;
    color: #555;
    font-family:Roboto;
    cursor: pointer;
    vertical-align: bottom;
}
.md-radio label:before,
.md-radio label:after {
  position: absolute;
  content: "";
  border-radius: 50%;
  transition: all 0.3s ease;
  transition-property: transform, border-color;
}
.md-radio label:before {
  left: 0;
  top: 0;
  width: 20px;
  height: 20px;
  border: 2px solid rgba(0, 0, 0, 0.54);
  box-sizing: border-box;
}
.md-radio label:after {
  top: 5px;
  left: 5px;
  width: 10px;
  height: 10px;
  transform: scale(0);
  background: #00a0e3;
}
.test-sem{height:auto !important;}
.submit-b {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}
.submit-b a,.submit-b button {
    background-color: #00a0e3;
    color: #fff;
    padding: 10px 40px !important;
    border-radius: 4px !important;
    display: inline-block;
    font-family: Roboto;
    font-size: 13px !important;
    font-weight: 500 !important;
    margin: 0px 5px;
}
.ui.multiple.dropdown>.label{
    background-color: #00a0e3;
    color: #fff;
    font-weight: 400;
    font-family: Roboto;
    box-shadow:none;
    padding: 7px 10px;
}
a.ui.active.label:hover, a.ui.labels .active.label:hover{
    background-color: #00a0e3;
    color: #fff;
}
.ui.dropdown .menu>.item{
    font-size: 14px;
    font-family: Roboto;
}
.ui.dropdown .menu .selected.item, .ui.dropdown.selected, .ui.dropdown .menu>.item:hover {
    background: #00a0e3;
    color: #fff;
}
.feed-box {
    padding: 20px 20px 15px 20px;
    margin-bottom: 30px;
    position: relative;
    background-color:#fffffffa;
}

.feed-box:hover {
    box-shadow: 0 0 10px rgba(0, 0, 0, .3);
    transition: .3s ease;
}
.rec-batch {
    position: absolute;
    right: 25px;
    top: 25px;
    background-color: #fff;
    padding: 5px 8px;
    font-family: roboto;
    font-size: 11px;
    text-transform: uppercase;
    font-weight: 500;
}

.feed-img img {
    width: 100%;
    object-fit: cover;
    min-height: 220px;
    max-height: 320px;
}

.feed-heading a {
    font-size: 18px;
    font-family: roboto;
    text-transform: capitalize;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    cursor: pointer;
    color: #000;
}

.author-s {
    display: flex;
    align-items: center;
    font-family: roboto;
    flex-wrap: wrap;
}

.author, .source {
    margin-right: 10px;
    color: #fff;
    padding: 4px 8px;
    margin-bottom: 10px;
}
.author i, .source i{
    margin-right:5px;
}

.author {
    background-color: #00a0e3;
}

.source {
    background-color: #ff7803;
}

.feed-content {
    text-align: justify;
    font-size: 14px;
    font-family: roboto;
    line-height: 22px;
    display: -webkit-box;
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.feed-btns {
    display: flex;
    border-top: 2px solid #eee;
    padding: 10px 0 0;
    flex-wrap: wrap;
    justify-content: space-between;
    position: relative;
}

.like-dis {
    flex-basis: 50%;
}

.feed-share {
    text-align: right;
    display: flex;
    justify-content: space-between;
    flex-basis: 22%;
    align-items: center;
}

.like-btn {
    color: #00a0e3;
    font-size: 20px;
}

.like-btn.default, .recommend-student.default {
    color: #aaa;
}

.recommend-student {
    font-size: 20px;
    margin-left: 15px;
    color: #00a0e3;
}

.wts-app, .fb, .tw, .male {
    width: 25px;
    text-align: center;
    border-radius: 50px;
    height: 25px;
    font-size: 13px;
    padding-top: 3px;
    margin:0 1px;
}

.wts-app {
    background-color: #25D366;
}

.male {
    background-color: #d3252b;
}

.tw {
    background-color: #1c99e9;
}

.fb {
    background-color: #236dce;
}

.wts-app i, .male i, .tw i, .fb i {
    color: white;
    font-size: 14px;
    cursor: pointer;
}
');
$script = <<<JS
let description = '';
$(document).on('keyup','.setResult',function() {
    $('#'+$(this).attr('targetElem')).html($(this).val());
});
$(document).on('change','select[name="source_id"]',function() {
    $('#sourceElem').html(' '+$('select[name="source_id"] option:selected').text());
});
 CKEDITOR.replace('editor', {
      // Define the toolbar groups as it is a more accessible solution.
      toolbarGroups: [{
          "name": "basicstyles",
          "groups": ["basicstyles"]
        },
        {
          "name": "links",
          "groups": ["links"]
        },
        {
          "name": "paragraph",
          "groups": ["list", "blocks", "align"]
        },
        {
          "name": "styles",
          "groups": ["styles"]
        }
      ],
      // Remove the redundant buttons from toolbar groups defined above.
      removeButtons: 'Source,Smiley,Iframe,Strike,Subscript,Superscript,Styles,Specialchar,Flash,'
    });
 CKEDITOR.instances.editor.on('change', function(e) {
    var self = this;

    setTimeout(function() {
        $('#descriptionElem').html(self.getData());
        description = self.getData();
    }, 10);
});
// $('.test-sem').dropdown();
// $(function () {

    // "use strict";

    function url(input) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();
            reader.onload = function (e) {
                $(".target").attr("src", e.target.result);
                // $('#image-preview').html('<img src="'+e.target.result+'" height="100px" width="auto" class="set-w">');
            };

            reader.readAsDataURL(input.files[0]);

        }
    }
    $("#file").change(function () {
        url(this);
    });
// });

$(document).on('change','#source_url',function (e){
        e.preventDefault();
        let url = $(this).val();
        $.ajax({
            url:'/skills-up/validate-url',
            data:{url:url},
            method:'post',
            success:function(res){
                if(res['status'] === 200) {
                    if(res['video_id'] !== ''){
                        var id = res['video_id']
                        var api_key = "AIzaSyDIZMbmF9Cl1thox_ok7a21r7FYVsQ4lyU";
                        var snippet;
                        $.ajax({
                            type: 'GET',
                            async: false,
                            url: 'https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id=' + id + '&key=' + api_key,
                            success: function(response) {
                                snippet = response['items'][0]['snippet'];
                                $('#title').val(snippet['title']);
                                $('#titleElem').html(snippet['title']);
                                CKEDITOR.instances.editor.setData(snippet['description']);
                                $('input[name="content_type"]').each(function(){
                                    if($(this).val() == 'Video'){
                                        $(this).prop('checked',true);
                                    }
                                })
                                $('#sourceElem').html('Youtube');
                                $('#channel_id').val(snippet['channelId']);
                                $('#channel_name').val(snippet['channelTitle']);
                                $('#author').val(snippet['channelTitle']);
                                $('#authorElem').html(snippet['channelTitle']);
                                $('#video_duration').val(response['items'][0]['contentDetails']['duration']);
                                $('#video_id').val(id);
                                $('#video_tags').val(snippet['tags']);
                                $('#source_id').val('$source_youtube_key');
                                var imge = snippet['thumbnails']['high']['url'];
                                // $('#image-preview').html('<img src="'+imge+'" height="100px" width="auto">');
                                $(".target").attr("src", imge);
                                $('#image_url').val(imge);
                                $('#short_desc').val(snippet['description'].substr(0,200) + '...');
                                $('#descriptionElem').html(CKEDITOR.instances.editor.getData());
                            }
                        });
                    }
                }
            }
        })
    })
    
    document.querySelector("#file").addEventListener('change',function() {
      const reader = new FileReader();
      reader.addEventListener('load',()=>{
          localStorage.setItem('imgData',reader.result)
      });
      reader.readAsDataURL(this.files[0]);
    });
    
    $(document).on('click','#preview-button',function(e) {
            e.preventDefault();
            var form = $('#feeds_form');
            $.ajax({
                url:'/skills-up/preview',
                data:form.serialize()+ "&description=" + description,
                method:'post',
                success: function(data) {
                   if(data['status'] === 200){
                       window.open("http://ravinder.eygb.me/skills-up/feed-preview?id="+data['id']);
                   }else{
                       toastr.error(response.message, 'error'); 
                   }
                }
            });
    })
    
    // $('.select2-search__field').css('width',$(".select2-selection__rendered").width());
    // var ps = new PerfectScrollbar('.select2-selection.select2-selection--multiple');
JS;
$this->registerJS($script);
//$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
//$this->registerCssFile('/assets/themes/dashboard/plugins/schedular/css/semantic.min.css');
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
//$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('/assets/themes/dashboard/plugins/schedular/js/semantic.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/scripts/app.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdn.ckeditor.com/4.16.0/full/ckeditor.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
