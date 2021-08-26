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
        <?php if (Yii::$app->session->hasFlash('success')) { ?>
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="icon fa fa-check"></i>Saved!</h4>
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php } ?>

        <?php if (Yii::$app->session->hasFlash('error')) { ?>
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="icon fa fa-check"></i>Error!</h4>
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php } ?>

        <div class="row">
            <div class="col-md-8">
                <div class="feed-main nd-shadow">
                    <div class="feed-title">Feed Form</div>
                    <?php $form = ActiveForm::begin([
                        'id' => 'feeds_form',
                        'enableClientValidation' => true,
                        'validationUrl' => ['/' . Yii::$app->controller->id . '/' . 'validate-source'],
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
                            <div class="content-t">Content Type</div>
                            <?= $form->field($model, 'content_type')->radioList(['Video' => 'Video', 'Blog' => 'Blog', 'News' => 'News', 'Podcast' => 'Podcast', 'Article' => 'Article', 'Audio' => 'Audio', 'Case Study' => 'Case Study', 'Research Paper' => 'Research Paper', 'Vlog/Webinar' => 'Vlog/Webinar'])->label(false); ?>
                        </div>
                        <div class="source-field hidden">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <?= $form->field($model, 'source_url', ['enableAjaxValidation' => true])->textInput(['placeholder' => 'Source Url', 'class' => 'form-control', 'id' => 'source_url'])->label(false); ?>
                                </div>
                            </div>
                        </div>
                        <div class="all-fields hidden">
                            <div class="col-md-12 mb-30">
                                <div class="content-t mb-20">Cover Image</div>
                                <div id="image-preview">
                                    <img src="https://via.placeholder.com/350x350?text=Cover+Image" alt="your image"
                                         class="target set-w"/>
                                </div>
                                <div class="custom-file">
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
                            <div class="col-md-5">
                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="form-group pt-20 mt-20">
                                        <input type="text" name="sourceElem" class="form-control" id="sourceInputElem"
                                               placeholder="Enter Source Name"/>
                                        <?= $form->field($model, 'source_id')->hiddenInput(['id' => 'source_id'])->label(false); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-primary mt-40 modal-load-class"
                                        value="/account/skill-up/add-source">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="col-md-12 embed_code_field hidden">
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
                                <?= $form->field($model, 'skills')->hiddenInput(['id' => 'skills-field']); ?>
                                <div class="pf-field no-margin">
                                    <ul class="tags skill_tag_list">
                                        <li class="tagAdd taglist">
                                            <div class="skill_wrapper">
                                                <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                                <input type="text" id="search-skill" class="skill-input">
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'industry')->hiddenInput(['id' => 'industry-field']); ?>
                                <div class="pf-field no-margin">
                                    <ul class="tags languages_tag_list">
                                        <li class="tagAdd taglist">
                                            <div class="language_wrapper">
                                                <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                                <input type="text" id="search-language"
                                                       class="skill-input lang-input">
                                            </div>
                                        </li>
                                    </ul>
                                </div>
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
                            <i class="fa fa-user"></i><span id="authorElem"> Author</span>
                        </div>
                        <div class="source">
                            <i class="fa fa-link"></i><span id="sourceElem"> Source</span>
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
                                <i class="fa fa-facebook-f"></i>
                            </a>
                            <a href="javascript:;" class="wts-app">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                            <a href="javascript:;" class="tw">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="javascript:;" class="fb">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade bs-modal-lg in" id="modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>"
                     alt="<?= Yii::t('account', 'Loading'); ?>" class="loading">
                <span> &nbsp;&nbsp;<?= Yii::t('account', 'Loading'); ?>... </span>
            </div>
        </div>
    </div>
</div>
<?php
$source_youtube_key = array_search('Youtube', $source_list);
$this->registerCss('
.has-error .help-block.help-block-error{
    opacity: 1 !important;
    color: #e73d4a !important;
    filter: alpha(opacity=100);  
}
.mt-20{
    margin-top:20px;
}
.mt-40{
    margin-top:40px;
}
.tags {
    float: left;
    width: 100%;
    border: 2px solid #e8ecec;
    list-style:none;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

    padding: 8px;
}
.tags > .addedTag {
    float: left;
    background: #f4f5fa;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    font-family: Open Sans;
    font-size: 13px;
    padding: 7px 17px;
    margin-right: 10px;
    position: relative;
}
.tags > .addedTag > span {
    position: absolute;
    right: -6px;
    top: -5px;
    width: 16px;
    height: 16px;
    font-style: normal;
    background: #fb236a;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
    color: #ffffff;
    text-align: center;
    line-height: 13px;
    font-size: 10px;
    font-family: Open Sans;
    cursor: pointer;
}
.tagAdd.taglist input {
    float: left;
    width: auto;
    background: #ffffff;
    border: 1px solid #e8ecec;
    margin-left: 10px;
    padding: 5px; 
    margin: 5px 0;
    margin-left: 15px;
    padding-left: 15px;
}
.tags li {
    margin: 0;
}
.skill_wrapper,.language_wrapper{position:relative;float:left;}
.skill_wrapper .Typeahead-spinner,.language_wrapper .Typeahead-spinner{
    position: absolute;
    right: 5px;
    top: 13px;
    z-index: 9;
    display:none;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.form-control.tt-hint {
  color: #999;
  opacity: 0 !important;
}
.tt-menu {
  width: 98%;
  margin: 12px 0;
  padding: 8px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
              margin-top: 0px;
}
.tt-suggestion {
  padding: 3px 20px;
  font-size: 14px;
  line-height: 24px;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
}
.tags > .addedTag{
    margin-bottom:10px;
}
.tags > .addedTag > span{
    background: #00a0e3;
}

.form-group.form-md-line-input{
    margin-bottom:0px;
}
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
    display: flex;
    align-items: center;
}
#content_type > .radio label input{
    width: 20px;
    height: 18px;
    margin-top: 0px;
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
    line-height:22px;
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
.twitter-typeahead{
    width: 100%;
}
');
$script = <<<JS
$(document).on('change','input[name=content_type]', function(e) {
    $('.source-field').removeClass('hidden');
    if($(this).val() != 'Video'){
        $('.embed_code_field').removeClass('hidden');
    } else {
        $('.embed_code_field').addClass('hidden');
    }
})
$(document).on('keypress','#search-skill',function(e){
    if(e.which==13) {
        e.preventDefault();
    }
});
$(document).on('keyup','#search-skill',function(e){
    if(e.which==13 && $(this).val()) {
        e.preventDefault();
      add_tags($(this).val(),'skill_tag_list','skills',$(this).val());  
    }
});
var global = [];
var global2 = [];
var skills = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote: {
    url:'/account/skill-up/skill-list',
    prepare: function (query, settings) {
             settings.url += '?q=' +$('#search-skill').val();
             return settings;
        },   
    cache: false,    
    filter: function(list) {
             return list.results;
        }
  }
});    

var languages = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote: {
    url:'/account/skill-up/industry-list',
    prepare: function (query, settings) {
             settings.url += '?q=' +$('#search-language').val();
             return settings;
        },   
    cache: false,    
    filter: function(list) {
             return list.results;
        }
  }
});    

var sources = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote: {
    url:'/account/skill-up/get-sources',
    prepare: function (query, settings) {
             settings.url += '?keywords=' +$('#sourceInputElem').val();
             return settings;
        },   
    cache: false,    
    filter: function(list) {
                global2 = list.sources;
             return list.sources;
        }
  }
});    
            
var sourceElem = $('#sourceInputElem').typeahead(null, {
  name: 'source_enc_id',
  display: 'name',
  source: sources,
   limit: 6,
}).on('typeahead:asyncrequest', function() {
    // $('.language_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
   // $('.language_wrapper .Typeahead-spinner').hide();
  }).on('typeahead:selected',function(e, datum)
  {
      $('#source_id').val(datum.source_enc_id)
      $('#sourceElem').html(datum.name);
  }).blur(validateSelection2);
   // });

var language_type = $('#search-language').typeahead(null, {
  name: 'id',
  display: 'text',
  source: languages,
   limit: 6,
}).on('typeahead:asyncrequest', function() {
    $('.language_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
   $('.language_wrapper .Typeahead-spinner').hide();
  }).on('typeahead:selected',function(e, datum)
  {
      add_tags(datum.text,'languages_tag_list','industry',datum.id);
      language_type.typeahead('val','');
   }).blur(validateSelection);

function validateSelection() {
  var theIndex = -1;
  for (var i = 0; i < global.length; i++) {
    if (global[i].value == $(this).val()) {
        theIndex = i;
        break;
    }
  }
  if (theIndex == -1) {
    $(this).val(""); 
    global = [];
  }
}

function validateSelection2() {
  var theIndex = -1;
  for (var i = 0; i < global2.length; i++) {
    if (global2[i].name == $(this).val()) {
        theIndex = i;
        break;
    }
  }
  if (theIndex == -1) {
    $(this).val("");
    $('#source_id').val("");
  }
}
var skill_type = $('#search-skill').typeahead(null, {
  name: 'id',
  display: 'text',
  source: skills,
   limit: 6,
}).on('typeahead:asyncrequest', function() {
     $('.skill_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
     $('.skill_wrapper .Typeahead-spinner').hide();
  }).on('typeahead:selected',function(e, datum){
      add_tags(datum.text,'skill_tag_list','skills',datum.text);
      skill_type.typeahead('val','');
   }).blur(validateSelection);

var tag_class;

function add_tags(thisObj,tag_class,name,id,duplicates){
    var duplicates = [];
    $.each($('.'+tag_class+' li'),function(index,value){
        duplicates.push($.trim($(this).text()).toUpperCase());
    });
    if(jQuery.inArray($.trim(thisObj).toUpperCase(), duplicates) != -1) {
        alert('Already Added');
    } else {
        $('<li class="addedTag">' + thisObj + '<span class="tagRemove '+name+'remove" onclick="$(this).parent().remove();"><i class="fa fa-times"></i></span><input type="hidden" value="' + id + '" name="'+name+'[]"></li>').insertBefore('.'+tag_class+' .tagAdd');
    }
    if(document.getElementsByName('skills[]').length){
        $('#skills-field').val('done');
    } else {
        $('#skills-field').val('');
    }
    if(document.getElementsByName('industry[]').length){
        $('#industry-field').val('done');
    } else {
        $('#industry-field').val('');
    }
}
let description = '';

$(document).on('click', '.tagRemove', function() {
    if(document.getElementsByName('skills[]').length){
        $('#skills-field').val('done');
    } else {
        $('#skills-field').val('');
    }
    if(document.getElementsByName('industry[]').length){
        $('#industry-field').val('done');
    } else {
        $('#industry-field').val('');
    }   
});
$(document).on('click', '.modal-load-class', function() {
    $('#modal').modal('show').find('.modal-body').load($(this).attr('value'));   
});
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
        $('#editor').val(self.getData());
    }, 500);
});
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

function validURL(str) {
  var regexp =  /^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/;
  return regexp.test(str);
}

$(document).on('change','#source_url',function (e){
        e.preventDefault();
        if(!validURL($(this).val())){
            alert('Invalid URL');
            return false;
        }
        $('.all-fields').removeClass('hidden');
        let url = $(this).val();
        if (url != undefined || url != '') {
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var match = url.match(regExp);
            if (match && match[2].length == 11) {
                var id = match[2];
                var api_key = "AIzaSyDIZMbmF9Cl1thox_ok7a21r7FYVsQ4lyU";
                var snippet;
                $.ajax({
                    type: 'GET',
                    async: false,
                    url: 'https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id=' + match[2] + '&key=' + api_key,
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
                        $('.embed_code_field').addClass('hidden');
                        $('#sourceElem').html('Youtube');
                        $('#sourceInputElem').val('Youtube');
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
                        $('#short_desc').val(snippet['description'] ? snippet['description'].substr(0,200) + '...' : "");
                        $('#descriptionElem').html(CKEDITOR.instances.editor.getData());
                        $('#editor').val(CKEDITOR.instances.editor.getData());
                    }
                });
            } else {
                let domain = new URL(url).hostname.split('.');
                $.ajax({
                    url:'/account/skill-up/validate-url',
                    data:{url:url,source:domain.slice(0).slice(-(domain.length === 4 ? 3 : 2)).join('.')},
                    method:'post',
                    success:function(res){
                        if(res['status'] === 203){
                            $('#image_url').val(res['image']);
                            $(".target").attr("src", res['image'] ? res['image'] : 'https://via.placeholder.com/350x350?text=Cover+Image');
                            CKEDITOR.instances.editor.setData("");
                            $('#title').val(res['title']);
                            $('#titleElem').html(res['title']);
                            $('#short_desc').val(res['description']);
                            $('#editor').val("");
                            if(res['source']){
                                $('#sourceElem').html(res['source'].name);
                                $('#sourceInputElem').val(res['source'].name);
                                $('#source_id').val(res['source'].source_enc_id);
                            }
                        }
                    }
                })
            }
        }        
        
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
        if(form.find('.has-error').length) {
            alert('Please Enter required fields');
            return false;
        }
        $.ajax({
            url:'/account/skill-up/preview',
            data:form.serialize()+ "&description=" + encodeURIComponent(description),
            method:'post',
            success: function(data) {
               if(data['status'] === 200){
                   window.open("/account/skill-up/feed-preview?id="+data['id']);
               }else if(data['status'] === 409){
                   toastr.error('Please fill all required fields', 'error'); 
               }else{
                   toastr.error(response.message, 'error'); 
               }
            }
        });
    })
    
    localStorage.removeItem("imgData");
JS;
$this->registerJS($script);
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdn.ckeditor.com/4.16.0/full/ckeditor.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
