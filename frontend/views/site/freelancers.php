<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;

$this->title = 'Freelancers';
$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg-sign-up.jpg');
$keywords = 'freelance work at home jobs, freelance work from home, best freelance jobs 2018, freelance programming jobs, how to start freelancing, freelancer find work, freelance designer, freelance jobs, freelance writers, freelance jobs for beginners, freelance developer jobs, graphic design freelance, freelancing job, work opportunities from home, top freelance jobs, freelancers, freelance career';
$description = 'Empower Youth provides an online platform for various businesses to post freelancer projects and makes the freelancers self employed with limitless work opportunities across the world.';

$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/themes/ey/images/backgrounds/freelancer-share.png');

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
            ],
            'fieldConfig' => [
                'template' => '<div class="row"><div class="col-md-12"><div class="form-group">{input}{error}</div></div></div>',
                'labelOptions' => ['class' => ''],
            ],
        ]);
?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($freelancersFormModel, 'first_name')->textInput(['autocomplete' => 'off', 'placeholder' => $freelancersFormModel->getAttributeLabel('first_name')]); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($freelancersFormModel, 'last_name')->textInput(['autocomplete' => 'off', 'placeholder' => $freelancersFormModel->getAttributeLabel('last_name')]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($freelancersFormModel, 'email')->textInput(['autocomplete' => 'off', 'placeholder' => $freelancersFormModel->getAttributeLabel('email')]); ?>
    </div>
    <div class="col-md-6">
        <?=
        $form->field($freelancersFormModel, 'phone')->widget(PhoneInput::className(), [
            'jsOptions' => [
                'allowExtensions' => false,
                'nationalMode' => false,
                'preferredCountries' => ['in'],
            ]
        ]);
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?=
        $form->field($freelancersFormModel, 'job_profile')->dropDownList([
            'prompt' => 'Select Job Type',
            'Design & Creative' => 'Design & Creative',
            'Sales & Marketing' => 'Sales & Marketing',
            'IT & Networking' => 'IT & Networking',
            'Accounting & Consulting' => 'Accounting & Consulting',
            'Article & Blog Writing' => 'Article & Blog Writing',
            'Web Development' => 'Web Development',
            'Project Management' => 'Project Management',
            'Mobile App Development' => 'Mobile App Development',
            'Photography' => 'Photography',
            'Animation' => 'Animation',
            'Others' => 'Others',
                ], [
            'id' => 'job_profile',
        ]);
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($freelancersFormModel, 'job_profile2')->textInput(['autocomplete' => 'off', 'id' => 'hidden', 'placeholder' => $freelancersFormModel->getAttributeLabel('job_profile')]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($freelancersFormModel, 'portfolio')->textInput(['autocomplete' => 'off', 'placeholder' => $freelancersFormModel->getAttributeLabel('portfolio')]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($freelancersFormModel, 'skills')->textInput(['autocomplete' => 'off', 'placeholder' => $freelancersFormModel->getAttributeLabel('skillls'), 'id' => 'skills', 'data-role' => 'tagsinput']); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($freelancersFormModel, 'description')->textArea(['rows' => 6, 'autocomplete' => 'off', 'placeholder' => $freelancersFormModel->getAttributeLabel('description')]); ?>
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
            <h5>We are launching a new holistic career development platform where you will be able to find Freelancing Jobs and much more. Please Register on the form and we will notify you once the platform goes live.<br/>
                We currently have freelancing jobs available for Web Developers. If you are one we will be contact you soon.</h5>
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
      
$(".field-hidden").hide();

$(document).on('change', '#job_profile', function () {
    var value = $(this).val();
    if (value == "Others"){
        $(".field-hidden").show();
    } else {
        $(".field-hidden").hide();
    }
});
//$('#skills').materialtags({});
JS;
$this->registerJs($script);
$this->registerJsFile('//platform-api.sharethis.com/js/sharethis.js#property=5aab8e2735130a00131fe8db&product=sticky-share-buttons', ['depends' => [\yii\web\JqueryAsset::className()], 'async' => 'async']);
$this->registerCssFile('http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css');
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
