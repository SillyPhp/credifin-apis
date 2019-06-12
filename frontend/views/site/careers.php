<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

$this->title = 'Careers';
$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg-sign-up.jpg');
$keywords = 'Career, Future, Scope, Growth, Opportunities, Sales, Business Development, Marketing, Information Technology, Human Resource, Operation, Government Jobs, Accounts, Finance, Legal, Company Secretary';
$description = 'Empower Youth brings a visionary tool to help future generations to look ahead and create a road map for ultimate success in their careers.';

$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/themes/ey/images/backgrounds/fb-image.png');

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
<p class="text-gray">
    <strong>None of your personal information will be tracked. So please feel free to fill up the form.</strong>
</p>
<p class="text-gray">
    Most of the fields are not required but it will be helpful if you could fill them up.
</p>
<div class="row">
    <div class="col-md-12">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="fa fa-check-circle-o"></i> Thanks you!</h4>
                <?= Yii::$app->session->getFlash('success'); ?>
            </div>
        <?php endif; ?>
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
$form = ActiveForm::begin([
            'id' => 'careers-form',
            'enableAjaxValidation' => true,
            'options' => [
                'class' => 'clearfix',
            ],
            'fieldConfig' => [
                'template' => '<div class="row"><div class="col-md-12"><div class="form-group">{input}{error}</div></div></div>',
                'labelOptions' => ['class' => ''],
            ],
        ]);
?>
<?= $form->field($careerFormModel, 'job_title')->textInput(['autocomplete' => 'off', 'placeholder' => $careerFormModel->getAttributeLabel('job_title')]); ?>
<?= $form->field($careerFormModel, 'designation')->textInput(['autocomplete' => 'off', 'placeholder' => $careerFormModel->getAttributeLabel('designation')]); ?>
<?= $form->field($careerFormModel, 'job_profile')->dropDownList([
    'prompt' => 'Select Job Profile',
    'Accounts & Finance' => 'Accounts & Finance',
    'Business Development' => 'Business Development',
    'Human Resource' =>'Human Resource',
    'Government Jobs' =>'Government Jobs',
    'Information Technology' => 'Information Technology',
    'LC' => 'Legal/Chartered Accountants/Company Secretary etc.',
    'Marketing' => 'Marketing',
    'Operations' => 'Operations',
    'Sales' => 'Sales',
    'Others' => 'Others',
    ],[
    'id' => 'job_profile',
]);
?>
<?= $form->field($careerFormModel, 'job_profile2')->textInput(['autocomplete' => 'off', 'id' => 'hidden', 'placeholder' => $careerFormModel->getAttributeLabel('job profile')]); ?>
<?= $form->field($careerFormModel, 'salary')->textInput(['autocomplete' => 'off', 'placeholder' => 'Salary (per month)']); ?>
<?= $form->field($careerFormModel, 'ctc')->textInput(['autocomplete' => 'off', 'placeholder' => $careerFormModel->getAttributeLabel('ctc')]); ?>
<?=
$form->field($careerFormModel, 'city')->widget(Select2::classname(), [
    'initValueText' => NULL, // set the initial display text
    'options' => ['placeholder' => 'Enter city name...', 'multiple' => false],
    'pluginOptions' => [
        'allowClear' => false,
        'minimumInputLength' => 1,
        'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
            'url' => Url::to(['/cities/career-city-list']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(city) { return city.text; }'),
        'templateSelection' => new JsExpression('function (city) { return city.text; }'),
    ],
])->label(false);
?>
<?= $form->field($careerFormModel, 'experience')->textInput(['autocomplete' => 'off', 'placeholder' => 'Experience (in years)']); ?>
<?= $form->field($careerFormModel, 'company_name')->textInput(['autocomplete' => 'off', 'placeholder' => $careerFormModel->getAttributeLabel('company_name')]); ?>
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
      <a href="https://www.facebook.com/empower/" class="fb" target="_blank" title="Join us on Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
      <a href="https://twitter.com/EmpowerYouth2" class="tw" target="_blank" title="Join us on Twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>
      <a href="https://www.instagram.com/empoweryouth.in/" class="insta" target="_blank" title="Join us on Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
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
<!--<div class="rotated-text">
    <span class="rotated-text-inner"><a href="">Why we are doing this?</a></span>
</div>-->
<?php
$this->registerCss('
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
  }
  .row-offcanvas.active .content {
    width: 100%;
  }
  .row-offcanvas .content {
    width: 75%;
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
.tt-hint {
  color: #999
}
.tt-menu {
  width: 100%;
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
.Typeahead-spinner{
    position: absolute;
    color: #222;
    z-index: 999;
    right: 0;
    top: 10px;
    font-size: 25px;
    display: none;
}
.twitter-typeahead{
    float:left;
    width:100%;
}
/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    right: 20px;
    top:1px;
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

');

$script = <<< JS
        
$(document).ready(function () {
  $('[data-toggle=offcanvas]').click(function () {
    $('.row-offcanvas').toggleClass('active');
  });
        
    $('#change').click(function(){
        $('#change-text').toggleText('Close', 'Open');
    });
        
        $.fn.toggleText = function(t1, t2){
  if (this.text() == t1) this.text(t2);
  else                   this.text(t1);
  return this;
};
});

$(".field-hidden").hide();

$(document).on('change', '#job_profile', function () {
    var value = $(this).val();
    if (value == "Others" || value == "LC" || value == "Government Jobs"){
        $(".field-hidden").show();
    } else {
        $(".field-hidden").hide();
    }
});


JS;
$this->registerJs($script);
$this->registerJsFile('//platform-api.sharethis.com/js/sharethis.js#property=5aab8e2735130a00131fe8db&product=sticky-share-buttons', ['depends' => [\yii\web\JqueryAsset::className()], 'async' => 'async']);
$this->registerCssFile('https://use.fontawesome.com/releases/v5.8.2/css/all.css');