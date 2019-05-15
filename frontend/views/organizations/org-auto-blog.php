<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;
//print_r(Yii::$app->user->identity->organization_enc_id);
//exit;
//$e = \common\models\EmployerApplications::find()
//    ->alias('a')
//    ->joinWith(['title b' => function($b){
//        $b->joinWith(['categoryEnc c']);
//    }])
//    ->asArray()
//    ->all();
//print_r($e);
//exit;
$this->title = 'Blog Auto Generate Info Form';
//$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg-sign-up.jpg');
//$keywords = 'freelance work at home jobs, freelance work from home, best freelance jobs 2018, freelance programming jobs, how to start freelancing, freelancer find work, freelance designer, freelance jobs, freelance writers, freelance jobs for beginners, freelance developer jobs, graphic design freelance, freelancing job, work opportunities from home, top freelance jobs, freelancers, freelance career';
//$description = 'Empower Youth provides an online platform for various businesses to post freelancer projects and makes the freelancers self employed with limitless work opportunities across the world.';

//$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/themes/ey/images/backgrounds/freelancer-share.png');

//$this->params['seo_tags'] = [
//    'rel' => [
//        'canonical' => Url::canonical(),
//    ],
//    'name' => [
//        'keywords' => $keywords,
//        'description' => $description,
//        'twitter:card' => 'summary',
//        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
//        'twitter:site' => '@EmpowerYouth2',
//        'twitter:creator' => '@EmpowerYouth2',
//        'twitter:image' => $image,
//    ],
//    'property' => [
//        'og:locale' => 'en',
//        'og:type' => 'website',
//        'og:site_name' => 'Empower Youth',
//        'og:url' => Url::canonical(),
//        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
//        'og:description' => $description,
//        'og:image' => $image,
//    ],
//];
?>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="fa fa-check-circle-o"></i> Error</h4>
                    <?= Yii::$app->session->getFlash('error'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="fader"></div>
            <div class="light-box-outer">
                <div class="light-box-inner">
                    <h2><i class="fa fa-check-circle-o"></i> Thank You!</h2>
                    <p><?= Yii::$app->session->getFlash('success'); ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php
    $this->registerJs("
        $('.fader').fadeIn(500);
        $('.light-box-outer').fadeIn(1000);
        $('.light-box-inner').fadeIn(1000);
        
        var width = $('.light-box-outer').width();
        var marginLeft = width / 2;
        $('.light-box-outer').css('margin-left', -marginLeft);
        
        setTimeout(function(){ window.location = 'https://www.empoweryouth.in'; }, 3000);
    ");
endif;
$form = ActiveForm::begin([
    'id' => 'freelancers-form',
    'options' => [
        'class' => 'clearfix',
        'enctype' => 'multipart/form-data',
    ],
    'fieldConfig' => [
        'template' => '<div class="row"><div class="col-md-12"><div class="form-group">{input}{error}</div></div></div>',
        'labelOptions' => ['class' => ''],
    ],
]);
?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('name')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'images[]')->fileInput(['multiple' => 'multiple', 'accept' => 'image/*']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
<!--            <span class="pf-title">Pick Some Tags</span>-->
            <div class="pf-field no-margin">
                <ul class="tags custom_tags">
                    <li class="tagAdd taglist">
                        <div class="tags_wrapper">
                            <i class="Typeahead-spinner fa fa-circle-o-notch fa-spin fa-fw"></i>
                            <span class="twitter-typeahead" style="position: relative; display: inline-block;">
                                <input class="skill-input lang-input tt-hint"
                                        style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: rgb(255, 255, 255) none repeat scroll 0% 0%;"
                                        readonly="" autocomplete="off" spellcheck="false"
                                        tabindex="-1"
                                        dir="ltr" type="text">
                                <input id="search-tags"
                                     placeholder="Enter Job Names to add"
                                     class="skill-input lang-input tt-input"
                                     autocomplete="off"
                                     spellcheck="false"
                                     dir="auto"
                                     style="position: relative; vertical-align: top; background-color: transparent;"
                                     type="text">
                                <pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Cantarell; font-size: 12px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;"></pre>
                                <div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;">
                                    <div class="tt-dataset tt-dataset-languages"></div>
                                </div>
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'desc')->textarea(['rows' => 5,'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('desc')]); ?>
        </div>
    </div>
    <div class="modal-footer">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-circle']); ?>
<!--        --><?//= Html::button('Close', ['class' => 'btn default btn-circle', 'data-dismiss' => 'modal']); ?>
    </div>
<?php ActiveForm::end(); ?>
    <div class="col-md-12 text-center">
        <h2 class="subscribe-head">Subscribe <span>Us</span></h2>
        <div class="effect jaques">
            <div class="buttons">
                <a href="https://www.facebook.com/empower/" class="fb" target="_blank" title="Join us on Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a href="https://twitter.com/EmpowerYouth2" class="tw" target="_blank" title="Join us on Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <a href="https://www.instagram.com/empoweryouth.in/" class="insta" target="_blank" title="Join us on Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    <div style="position: fixed;width: 100%;z-index: 9999;top: 20%;right: 0;">
        <div class="row row-offcanvas">
            <div class="sidebar-offcanvas sidebar">
                <h3>Why we are Doing this?</h3>
                <h5>We are launching a new holistic career development platform where you will be able to find Freelancing Jobs and much more. Please Register on the form and we will notify you once the platform goes live.<br/>
                    We currently have freelancing jobs available for Web Developers. If you are one we will be contact you soon.</h5>
            </div>
            <a type="button" id="change" class="btn btn-collapse btn-" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-down"></i> <span id="change-text">Close</span></a>
        </div>
    </div>
<?php
$this->registerCss('
.bootstrap-tagsinput{
    width: 100%;
    min-height: 40px;
    border-radius: 0;
    border-top: 0px;
    border-left: 0px;
    border-right: 0px;
}
.bootstrap-tagsinput.focus{
    border-color:#4aa1e3;
    -webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
.bootstrap-tagsinput .tag{
    line-height: 2;
}
.bootstrap-tagsinput input{
    border: 0px !important;
    margin-bottom: 0px !important;
    width: auto !important;
}
.bootstrap-tagsinput input:focus{
    box-shadow:none !important;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}
.tt-hint {
  color: #999
}
.tt-menu {
  margin: 0px 0;
  text-align:left;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 0px 0px 6px 6px;
     -moz-border-radius: 0px 0px 6px 6px;
          border-radius: 0px 0px 6px 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
    padding: 4px 15px;
    font-size: 12px;
    line-height: 24px;
    color: #222;
    border-bottom: 1px solid #dddddda3;
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
.Typeahead-spinner-main{
    display:none;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.Typeahead-spinner{
    position: absolute;
    color: #222;
    z-index: 999;
    right: 15px;
    top: -20px;
    font-size: 25px;
    display: none;
}
.control-label{
 font-size: 16px;  
}
.chip {
    margin-top: 3px;
}
.chip i{
    padding: 10px 0 10px 10px;
    cursor: pointer;
}
input[type=text]:not(.browser-default){
    margin: 0px;
}
.ck-editor__editable{
    min-height:200px
}
.tags {
    float: left;
    width: 100%;
    border: 2px solid #e8ecec;
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
    background: #f10719;
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
    z-index:999;
}
.tagAdd.taglist input {
    float: left;
    width: auto;
    background: #ffffff;
    border-left: 1px solid #e8ecec !important;
    padding: 0;
    height: 19px;
    margin: 5px 0;
    margin-left: 15px;
    padding-left: 15px;
    vertical-align: top;
    padding: 15px 10px !important;
    border-radius: 7px;
    border: medium none;
}
.tags li {
    margin: 0;
}
.tags {
    list-style: outside none none;
}

/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    right: 20px;
}
.load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 35px 1px;
}
.load-suggestions span:nth-child(1){
  animation: bounce 1s ease-in-out infinite;
}
.load-suggestions span:nth-child(2){
  animation: bounce 1s ease-in-out 0.33s infinite;
}
.load-suggestions span:nth-child(3){
  animation: bounce 1s ease-in-out 0.66s infinite;
}
@keyframes bounce{
  0%, 75%, 100%{
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }
  25%{
    -webkit-transform: translateY(-15px);
    -ms-transform: translateY(-15px);
    -o-transform: translateY(-15px);
    transform: translateY(-15px);
  }
}
/*Load Suggestions loader css ends */

.fader{
    position:fixed;
    width:100%;
    height:100%;
    background-color:#000;
    top:0;
    left:0;
    opacity:0.7;
    display:none;
    z-index: 999999;
}
.light-box-outer{
    width:auto;
    height:auto;
    top:25%;
    left:50%;
    display: none;
    position: fixed;
    z-index: 999999;
    background-color:#fff;
    border-radius:10px;
}
.light-box-inner{
    width:100%;
    height:100%;
    margin:auto;
    display:none;
    border-radius: 10px;
    padding: 20px;
    text-align:center;
}
.intl-tel-input {
    width: 100%;
}
.select2-container--krajee .select2-selection--single {
    height: 45px;
    border-radius: 0px;
}
.select2-container--krajee .select2-selection--single .select2-selection__arrow{
    height:44px;
}
.select2-container--krajee .select2-selection--single .select2-selection__rendered{
    margin-top: 6px;
}
.subscribe-head {
  font-family: "Roboto", sans-serif;
  font-weight: 900;
  font-size: 30px;
  text-transform: uppercase;
  color: #212121;
  letter-spacing: 3px;
  margin-top:40px;
}
.subscribe-head span {
  display: inline-block;
}
.subscribe-head span:before, .subscribe-head span:after {
  content: "";
  display: block;
  width: 34px;
  height: 2px;
  background-color: #212121;
  margin: 0px 0px 0px 2px;
}
.effect {
  width: 100%;
  padding: 10px 0px 30px 0px;
}
.effect .buttons {
  display: flex;
  justify-content: center;
}
.effect a {
  text-decoration: none !important;
  color: #fff;
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px;
  margin-right: 20px;
  font-size: 25px;
  overflow: hidden;
  position: relative;
}
.effect a i {
  position: relative;
  z-index: 3;
}
.effect a.fb {
  background-color: #3b5998;
}
.effect a.tw {
  background-color: #00aced;
}
.effect a.insta {
  background-color: #bc2a8d;
}
/* jaques effect */
.effect.jaques a {
  transition: border-top-left-radius 0.1s linear 0s, border-top-right-radius 0.1s linear 0.1s, border-bottom-right-radius 0.1s linear 0.2s, border-bottom-left-radius 0.1s linear 0.3s;
}
.effect.jaques a:hover {
  border-radius: 50%;
}
@media screen and (min-width: 768px) {
  .row-offcanvas {
    position: relative;
    right: 25%;
    -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
  }
  .row-offcanvas.active {
    right: 0;
  }
  .row-offcanvas .sidebar-offcanvas {
    position: absolute;
    top: 0;
    width: 25%;
    right: -25%;
  }
}
@media screen and (max-width: 767px) {
  .row-offcanvas {
    right: 0;
    position: relative;
    -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
  }
  .row-offcanvas.active {
    right: 50%;
  }
  .sidebar-offcanvas {
    position: absolute;
    top: 0;
    width: 50%;
    right: -50%;
  }
}
/* styling the sidebar and the toggle button */
.sidebar {
  background: rgba(51, 122, 183, 0.09);
  padding: 10px 25px 10px 12px;
  margin-top: -20px;
  border-radius: 10px 0 0 10px;
}
.sidebar h3{
    margin-top:10px;
}
.btn-collapse {
  position: absolute;
  padding: 8px 12px;
  border-radius: 10px 10px 0 0;
  top: 20px;
  right: 0;
  margin-right: -21px;
  background: rgba(51, 122, 183, 0.09);
  transform: rotate(-90deg);
  -webkit-transition: all 0.3s ease-out;
  -moz-transition: all 0.3s ease-out;
  -ms-transition: all 0.3s ease-out;
  -o-transition: all 0.3s ease-out;
  transition: all 0.3s ease-out;
}

.row-offcanvas.active .btn-collapse {
  right: 10px;
  -webkit-transition: all 0.3s ease-out;
  -moz-transition: all 0.3s ease-out;
  -ms-transition: all 0.3s ease-out;
  -o-transition: all 0.3s ease-out;
  transition: all 0.3s ease-out;
}
.row-offcanvas.active .btn-collapse i {
  transform: rotate(180deg);
}
.bootstrap-tagsinput{
    width: 100%;
    min-height: 45px;
    padding: 11px 6px;
    border-radius: 0px;
}
.bootstrap-tagsinput .tag{
    padding: 8px 12px;
    font-size: 88%;
    line-height: 3;
}
.bootstrap-tagsinput input:focus{
    box-shadow:none !important;
}
');

$script = <<< JS

// $('#pre_tags').on('click', ':checkbox', function() {
//     var chk = $(this);
//     var data = chk.next('label').attr('value');
//     var id = chk.attr('id');
//     if (chk.is(':checked')) {
//         $(".custom_tags").prepend('<li class="addedTag" value-id="' + id + '">' + data + '<input type="hidden" value="' + data + '" name="tags[]"></li>');
//     } else {
//         $('.custom_tags [value-id = "' + id + '"]').remove();
//     }
// });

var global = [];

$(document).on('keypress', 'input', function(e) {
    if (e.which == 13) {
        return false;
    }
});

var tags = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: '/organizations/get-applications',
        prepare: function(query, settings) {
            settings.url += '?q=' + $('#search-tags').val();
            return settings;
        },
        cache: false,
        filter: function(list) {
            global = list;
            return list;
        }
    }
});

    
    $(document).on('keyup', '#search-tags', function(e) {
        if (e.which == 13) {
            add_tags($(this), 'custom_tags', 'tags');
        }
    });
    var tag_class;

    function add_tags(thisObj, tag_class, name, duplicates) {
        var duplicates = [];
        $.each($('.' + tag_class + ' input[type=hidden]'), function(index, value) {
            duplicates.push($.trim($(this).val()).toUpperCase());
        });
        if (thisObj.val() == '' || jQuery.inArray($.trim(thisObj.val()).toUpperCase(), duplicates) != -1) {
            thisObj.val('');
        } else {
            $('<li class="addedTag">' + thisObj.val() + '<span class="tagRemove" onclick="$(this).parent().remove();">x</span><input class="lastSelection" type="hidden" value="' + thisObj.val() + '" name="' + name + '[]"></li>').insertBefore('.' + tag_class + ' .tagAdd');
            thisObj.val('');
        }
    }
    
$('#search-tags').typeahead(null, {
    name: 'tags',
    display: 'name',
    source: tags,
    limit: 5,
}).on('typeahead:asyncrequest', function() {
    $('.tags_wrapper .Typeahead-spinner').show();
}).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    $('.tags_wrapper .Typeahead-spinner').hide();
}).on('typeahead:selected', function(e, datum) {
    var a = $('#search-tags').parent().parent().parent().parent().closest('.lastSelection');
    console.log(a);
    return false;
    // add_tags($(this), 'custom_tags', 'tags');
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
// var tag_name = $('#tag_data');

//   $('[data-toggle=offcanvas]').click(function () {
//     $('.row-offcanvas').toggleClass('active');
//   });
//        
//     $('#change').click(function(){
//         $('#change-text').toggleText('Close', 'Open');
//     });
//        
//         $.fn.toggleText = function(t1, t2){
//   if (this.text() == t1) this.text(t2);
//   else                   this.text(t1);
//   return this;
// };
      
// $(".field-hidden").hide();

// $(document).on('change', '#job_profile', function () {
//     var value = $(this).val();
//     if (value == "Others"){
//         $(".field-hidden").show();
//     } else {
//         $(".field-hidden").hide();
//     }
// });

    
//$('#skills').materialtags({});
JS;
$this->registerJs($script);
//$this->registerJsFile('//platform-api.sharethis.com/js/sharethis.js#property=5aab8e2735130a00131fe8db&product=sticky-share-buttons', ['depends' => [\yii\web\JqueryAsset::className()], 'async' => 'async']);
$this->registerCssFile('http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css');
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
