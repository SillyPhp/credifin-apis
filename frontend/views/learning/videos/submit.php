<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
$this->title = 'Learning Corner';
$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/lco.png');
$keywords = 'learning corner activities, what is learning corner, learning corners, learning online, learning corner ideas, learning corner activities, what is learning corner, empoweryouth learning corner, learning center ideas';
$description = 'Learning corner is a great platform which is provided by Empower Youth to maximize your learning, moreover boost your knowledge and intelligence.';
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/themes/ey/images/backgrounds/share-lc.png');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Url::canonical(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouth2',
        'twitter:creator' => '@EmpowerYouth2',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Url::canonical(),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
    ],
];
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

<?php
if (Yii::$app->session->hasFlash('success')):
    ?>

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
        $('.fader, .light-box-outer, .light-box-inner').fadeOut(500);
        $('#careers-form')[0].reset();
        $('#url').val('');
        $('#video_type').val('');
        
    ");
endif;
?>

<?php
$form = ActiveForm::begin([
    'id' => 'careers-form',
    'options' => [
        'class' => 'clearfix',
    ],
    'fieldConfig' => [
        'template' => '<div class="row"><div class="col-md-12"><div class="form-group">{input}{error}</div></div></div>',
        'labelOptions' => ['class' => ''],
    ],
]);
?>

<?=
$form->field($learningCornerFormModel, 'video_type')->dropDownList([
    'Education' => 'Education',
    'Film & Animation' => 'Film & Animation',
    'Music' => 'Music',
    'Nonprofits & Activism' => 'Nonprofits & Activism',
    'People & Blogs' => 'People & Blogs',
    'Science & Technology' => 'Science & Technology',
    'Sports' => 'Sports',
    'Others' => 'Others',
], [
    'id' => 'video_type',
    'prompt' => 'Video Type',
]);
?>

    <div id="field-hidden" class="row">
        <div class="col-md-12">
            <?= $form->field($learningCornerFormModel, 'type_input')->textInput(['autocomplete' => 'off', 'placeholder' => $learningCornerFormModel->getAttributeLabel('type_input')]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($learningCornerFormModel, 'category')->textInput(['autocomplete' => 'off', 'placeholder' => $learningCornerFormModel->getAttributeLabel('category'), 'id' => 'categories']); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($learningCornerFormModel, 'sub_category')->textInput(['autocomplete' => 'off', 'placeholder' => $learningCornerFormModel->getAttributeLabel('sub_category'), 'id' => 'sub-cat']); ?>
        </div>
    </div>

<?=
$form->field($learningCornerFormModel, 'video_url', ['enableAjaxValidation' => true])->textInput(['autocomplete' => 'off', 'placeholder' => $learningCornerFormModel->getAttributeLabel('video_url'), 'id' => 'url']);
?>

<?= $form->field($learningCornerFormModel, 'video_id', ['enableAjaxValidation' => true])->hiddenInput(['autocomplete' => 'off', 'placeholder' => $learningCornerFormModel->getAttributeLabel('video_id'), 'id' => 'video-id']); ?>

<?= $form->field($learningCornerFormModel, 'video_duration')->hiddenInput(['autocomplete' => 'off', 'placeholder' => $learningCornerFormModel->getAttributeLabel('video_duration'), 'id' => 'video-duration']); ?>

<?=
$form->field($learningCornerFormModel, 'tags')->textInput(['autocomplete' => 'off', 'placeholder' => $learningCornerFormModel->getAttributeLabel('tags'), 'id' => 'skills', 'data-role' => 'tagsinput']);
?>

    <div class="row title">
        <div class="col-md-12">
            <div id="tooltip">
                Video Title.
            </div>
            <?= $form->field($learningCornerFormModel, 'video_title')->textInput(['autocomplete' => 'off', 'placeholder' => $learningCornerFormModel->getAttributeLabel('video_title'), 'id' => 'youtube-title', 'readonly' => true]); ?>
        </div>
    </div>

    <div class="row description">
        <div class="col-md-12">
            <div id="tooltip" class="tooltip1">
                Video Description.
            </div>
            <?= $form->field($learningCornerFormModel, 'description')->textArea(['rows' => 6, 'autocomplete' => 'off', 'placeholder' => $learningCornerFormModel->getAttributeLabel('description'), 'id' => 'youtube-description', 'readonly' => true]); ?>
        </div>
    </div>

    <div class="row ci">
        <div class="col-md-12">
            <?= $form->field($learningCornerFormModel, 'cover_image')->hiddenInput(['autocomplete' => 'off', 'placeholder' => $learningCornerFormModel->getAttributeLabel('cover_image'), 'id' => 'cover-image']); ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-lg btn-block mt-15', 'name' => 'register-button']); ?>
        </div>
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
                <h5>This is a small form that would help in a very big way we hope all of you can fill this up and also pass it along to your friends and family.</h5>
            </div>
            <a type="button" id="change" class="btn btn-collapse btn-" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-down"></i> <span id="change-text">Close</span></a>
        </div>
    </div>

<?php
$this->registerCss('
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
.effect {
  /*display: flex; !!!uncomment this line !!!*/
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
    /* 3 columns */
  }
  .row-offcanvas.active .content {
    width: 100%;
    /* 12 columns */
  }
  .row-offcanvas .content {
    width: 75%;
    /* 9 columns */
    float: right;
    -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
  }
  .row-offcanvas .sidebar-offcanvas {
    position: absolute;
    top: 0;
    width: 25%;
    /* 3 columns */
    right: -25%;
    /* 3 columns */
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
    /* 6 columns */
  }
  .sidebar-offcanvas {
    position: absolute;
    top: 0;
    width: 50%;
    /* 6 columns */
    right: -50%;
    /* 6 columns */
  }
}
/* styling the sidebar and the toggle button */
.content {
  position: relative;
}
.sidebar {
  background: rgba(51, 122, 183, 0.09);
  padding: 10px 15px;
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
//    padding: 11px 6px;
    border-radius: 0px;
    display:flex;
}
.bootstrap-tagsinput .tag{
    padding: 0px 12px;
    font-size: 85%;
    line-height: 3;
}
.bootstrap-tagsinput input:focus{
    box-shadow:none !important;
}
#tooltip{
    display: none;
    position: absolute;
//    cursor: pointer;
    right: -210px;
    top: 0px;
    border: solid 1px #eee;
    background-color: #ffffd3;
    padding: 10px;
    z-index: 1000;
}
.tooltip1{
    right:-258px !important;
}
.label-info + input::-webkit-input-placeholder {
   color:transparent !important;
}
.label-info + input:-moz-placeholder { /* Firefox 18- */
   color:transparent !important;
}
.label-info + input::-moz-placeholder {  /* Firefox 19+ */
   color:transparent !important;
}
.label-info + input:-ms-input-placeholder {  
   color:transparent !important;
}
.ci{
    display:none;
}
');
$script = <<< JS
  
    $('[data-toggle=offcanvas]').click(function () {
        $('.row-offcanvas').toggleClass('active');
    });
        
    $('#change').click(function(){
        $('#change-text').toggleText('Close', 'Open');
    });
        
    $.fn.toggleText = function(t1, t2){
      if (this.text() == t1) 
          this.text(t2); 
      else 
          this.text(t1);
      return this;
    };
    $(".title").hide();
    
    $(".description").hide();
    
    $('#url').blur(geturl);
    
    function geturl(){
        var link = $('#url').val();
        var videoid = link.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
        $.ajax({
            url: 'https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id='+videoid[1]+'&key=AIzaSyCdo0IpmiavCbEIY_BGb8O0XCqKpbxPVIk',
            contentType: "application/json",
            dataType: "json",
            success: function(data){
                $("#youtube-title").val(data.items[0].snippet.title);
                $("#youtube-description").val(data.items[0].snippet.description);
                $("#cover-image").val(data.items[0].snippet.thumbnails.high.url);
                $("#video-id").val(videoid[1]);
                $("#video-duration").val(data.items[0].contentDetails.duration);
            }
        });
        $(".title").show();
        $(".description").show();
        $("#tooltip").show();
        $(".tooltip1").show();
    }
        
        
    $("#field-hidden").hide();
    $(document).on('change', '#video_type', function () {
        var value = $(this).val();
        if (value == "Others"){
            $("#field-hidden").show();
        } else {
            $("#field-hidden").hide();
        }
    });
    
    $('#categories, #sub-cat').tagsinput({
        maxTags: 1,
        trimValue: true
    });
JS;
$this->registerJs($script);
$this->registerJsFile('//platform-api.sharethis.com/js/sharethis.js#property=5aab8e2735130a00131fe8db&product=sticky-share-buttons', ['depends' => [\yii\web\JqueryAsset::className()], 'async' => 'async']);
$this->registerCssFile('https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css');
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);