<?php
$this->title = Yii::t('frontend', 'Contact Us');

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
$keywords = 'Jobs services in india,Apply for Internship in India,Best Career sites in India,Top 50 job portals in india,Summer internships,Paid internships,Online jobs,Best job portal in India,Jobs services in india,Jobs services in ludhiana';
$description = 'Empower Youth is a career development platform where the candidate can apply for their desired job and internship.';
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/logos/empower_fb.png');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Url::canonical(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouth__',
        'twitter:creator' => '@EmpowerYouth__',
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
        'fb:app_id' => '973766889447403'
    ],
];
$data = [
    'title' => $this->title,
    'background' => Url::to('@eyAssets/images/backgrounds/contact-us.png'),
    'links' => [
        [
            'label' => $this->title,
            'url' => 'contact-us',
            'class' => 'active text-gray-silver',
        ]
    ]
];
echo $this->render('/widgets/breadcrumbs', [
    'data' => $data,
]);
?>

<!-- Section: Contact -->
<section data-bg-img="<?= Url::to('@eyAssets/images/backgrounds/vector1.jpg'); ?>" id="contact">
    <div class="container pb-60">
        <div class="section-title mb-10">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-uppercase text-theme-colored title line-bottom line-height-1 mt-0">Contact <span class="text-theme-color-2 font-weight-400">Us</span></h2>
                </div>
            </div>
        </div>
        <div class="section-content">
            <div class="row">
                <div class="col-md-5">
                    <!-- Google Map HTML Codes -->
                    <div
                        data-address="<?= Yii::t('frontend', Yii::$app->params->contact_address); ?>"
                        data-popupstring-id="#popupstring1"
                        class="map-canvas autoload-map"
                        data-mapstyle="style8"
                        data-height="420"
                        data-latlng="30.899420,75.824230"
                        data-title="<?= Yii::$app->params->site_name; ?>"
                        data-zoom="12"
                        data-marker="/assets/images/map-marker.png">
                    </div>
                    <div class="map-popupstring hidden" id="popupstring1">
                        <div class="text-center">
                            <h3><?= Yii::$app->params->site_name; ?></h3>
                            <p><?= Yii::t('frontend', 'BXX-3360-Basement, Ferozepur Road, Ludhiana-141001'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <h4 class="line-bottom mt-0 mb-30 mt-sm-20">SEND US A MESSAGE</h4>            
                    <!-- Contact Form -->
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'contact-us-form',
                                'options' => [
                                    'class' => 'clearfix',
                                ],
                                'fieldConfig' => [
                                    'template' => '{input}{error}',
                                    'labelOptions' => ['class' => ''],
                                ],
                    ]);
                    ?>
                    <?php if (Yii::$app->session->hasFlash('success')): ?>
                        <div class="alert alert-success alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <h4><i class="fa fa-check-circle-o"></i> Thank you :)</h4>
                            <?= Yii::$app->session->getFlash('success'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (Yii::$app->session->hasFlash('error')): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <h4><i class="fa fa-check-circle-o"></i> OOPS :(</h4>
                            <?= Yii::$app->session->getFlash('error'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($contactFormModel, 'first_name')->textInput(['autofocus' => true, 'autocomplete' => 'off', 'placeholder' => $contactFormModel->getAttributeLabel('first_name')]); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($contactFormModel, 'last_name')->textInput(['autocomplete' => 'off', 'placeholder' => $contactFormModel->getAttributeLabel('last_name')]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($contactFormModel, 'email')->textInput(['autocomplete' => 'off', 'placeholder' => $contactFormModel->getAttributeLabel('email')]); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($contactFormModel, 'phone')->textInput(['autocomplete' => 'off', 'placeholder' => $contactFormModel->getAttributeLabel('phone')]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($contactFormModel, 'subject')->textInput(['autocomplete' => 'off', 'placeholder' => $contactFormModel->getAttributeLabel('subject')]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($contactFormModel, 'message')->textarea(['rows' => 6, 'autocomplete' => 'off', 'placeholder' => $contactFormModel->getAttributeLabel('message')]); ?>
                        </div>
                    </div>
                    <?=
                    $form->field($contactFormModel, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ])
                    ?>
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerJsFile(
        '//maps.google.com/maps/api/js?key=AIzaSyAYWE4mHmR9GyPsHSOVZrSCOOljk8DU9B4', ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
        Yii::getAlias('@web') . '@eyAssets/js/google-map-init.js', ['depends' => [\yii\web\JqueryAsset::className()]]
);

$script = <<<JS
$("#contact_us_form").validate({
    submitHandler: function (form) {
        var form_btn = $(form).find('button[type="submit"]');
        var form_result_div = '#form-result';
        $(form_result_div).remove();
        form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
        var form_btn_old_msg = form_btn.html();
        form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
        $(form).ajaxSubmit({
            dataType: 'json',
            success: function (data) {
                if (data.status == 'true') {
                    $(form).find('.form-control').val('');
                }
                form_btn.prop('disabled', false).html(form_btn_old_msg);
                $(form_result_div).html(data.message).fadeIn('slow');
                setTimeout(function () {
                    $(form_result_div).fadeOut('slow')
                }, 6000);
            }
        });
    }
});
JS;
$this->registerJS($script);
