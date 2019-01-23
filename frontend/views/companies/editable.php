<?php
$this->title = Yii::t('frontend', $organization['name']);
$this->params['header_dark'] = false;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

$keywords = '';
$description = substr($organization['description'], 0, 150);
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
        'twitter:image' => $cover_image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Url::canonical(),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $cover_image,
    ],
];

$industries = Json::encode($industries);
if ($organization['logo']) {
    $image_path = Yii::$app->params->upload_directories->organizations->logo_path . $organization['logo_location'] . DIRECTORY_SEPARATOR . $organization['logo'];
    $image = Yii::$app->params->upload_directories->organizations->logo . $organization['logo_location'] . DIRECTORY_SEPARATOR . $organization['logo'];
    if (!file_exists($image_path)) {
        $image = "https://ui-avatars.com/api/?name=" . $organization['name'] . '&size=200&rounded=true&background=' . str_replace("#", "", $organization['initials_color']) . '&color=ffffff';
    }
} else {
    $image = "https://ui-avatars.com/api/?name=" . $organization['name'] . '&size=200&rounded=true&background=' . str_replace("#", "", $organization['initials_color']) . '&color=ffffff';
}
if ($organization['cover_image']) {
    $cover_image_path = Yii::$app->params->upload_directories->organizations->cover_image_path . $organization['cover_image_location'] . DIRECTORY_SEPARATOR . $organization['cover_image'];
    $cover_image = Yii::$app->params->upload_directories->organizations->cover_image . $organization['cover_image_location'] . DIRECTORY_SEPARATOR . $organization['cover_image'];
    if (!file_exists($cover_image_path)) {
        $cover_image = "/assets/themes/ey/images/pages/jobs/default-cover.png";
    }
} else {
    $cover_image = "/assets/themes/ey/images/pages/jobs/default-cover.png";
}
$no_image = "https://ui-avatars.com/api/?name=" . $organization['name'] . '&size=200&rounded=true&background=' . str_replace("#", "", $organization['initials_color']) . '&color=ffffff';
$no_cover = "/assets/themes/ey/images/pages/jobs/default-cover.png";
?>

<div class="loader-aj-main">
    <div class="loader-aj">
        <div class="dot first"></div>
        <div class="dot second"></div>
    </div>
</div>
<div id="fab-message-open" class="fab-message" style="">
    <img src="<?= Url::to('@eyAssets/images/pages/company-profile/CVbox2.png') ?>">
    <!--<i class="fa fa-envelope"></i>-->
    <div class="fab-hover-message" style="">
        <div class="fab-hover-image">
            <img src="<?= Url::to('@eyAssets/images/pages/company-profile/cv.png') ?>">
        </div>
    </div>
    <!--<div class="fab-hover-message" style="">Want to post your CV</div>-->
</div>
<div class="sections">
    <section id="home">
        <div class="coverpic">
            <img id="cover_img" src="<?= Url::to($cover_image); ?>" class="img-fluid">
            <?php
            $formm = ActiveForm::begin([
                        'id' => 'change-cover-image',
                        'options' => ['enctype' => 'multipart/form-data'],
                    ])
            ?>
            <div class="cover-edit">
                <a class="fa fa-pencil dropdown-toggle edits" data-toggle="dropdown"> Edit</a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#">
                            <?=
                            $formm->field($companyCoverImageForm, 'image', [
                                'template' => '{input}',
                                'options' => ['tag' => false]])->fileInput(['class' => '', 'id' => 'coverImageUpload', 'accept' => '.png, .jpg, .jpeg']);
                            ?>
                            <label for="coverImageUpload">Change Cover Picture</label>

                        </a>
                    </li>
                    <li><a href="#" class="remove_cover_image">Remove</a></li>
                    <li><a href="#">Cancel</a></li>
                </ul>
                <div id="pop-content2" class="hiden2">
                    <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i>', ['class' => 'btn btn-primary btn-sm editable-submit']) ?>
                    <button id="cancel_cover" type="button" class="btn btn-default btn-sm editable-cancel">
                        <i class="glyphicon glyphicon-remove"></i>
                    </button>
                </div>
                <div id="pop-content2_2" class="hiden2">
                    <h5>Are you sure want to remove Cover Image?</h5>
                    <button id="confirm_remove_cover" type="button" value="cover"
                            class="btn btn-primary btn-sm editable-submit">
                        <i class="glyphicon glyphicon-ok"></i>
                    </button>
                    <button id="cancel_cover_remove" type="button" class="btn btn-default btn-sm editable-cancel">
                        <i class="glyphicon glyphicon-remove"></i>
                    </button>
                </div>
            </div>
            <?php ActiveForm::end() ?>
        </div>

        <!-- Page Content  -->
        <div class="modal fade bs-modal-lg in" id="modal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>"
                             alt="<?= Yii::t('frontend', 'Loading'); ?>" class="loading">
                        <span> &nbsp;&nbsp;<?= Yii::t('frontend', 'Loading'); ?>... </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <div class="home">
                            <div class="home-heading">
                                <div class="c-logo col-md-2 col-sm-3">
                                    <img id="logo-img" src="<?= Url::to($image); ?>" alt=""
                                         class="img-circle img-thumbnail "/>
                                    <?php
                                    $form = ActiveForm::begin([
                                        'id' => 'upload-logo',
                                        'options' => ['enctype' => 'multipart/form-data'],
                                    ])
                                    ?>
                                    <div id="open-pop" class="avatar-edit">
                                        <i class="fa fa-pencil dropdown-toggle full_width" data-toggle="dropdown"></i>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="#">
                                                    <?=
                                                    $form->field($companyLogoFormModel, 'logo', [
                                                        'template' => '{input}',
                                                        'options' => ['tag' => false]])->fileInput(['class' => '', 'id' => 'logoUpload', 'accept' => '.png, .jpg, .jpeg']);
                                                    ?>
                                                    <label for="logoUpload">Change Profile Picture</label>
                                                </a>
                                            </li>
                                            <li><a href="#" class="remove-logo">Remove</a></li>
                                            <li><a href="#">Cancel</a></li>
                                        </ul>
                                    </div>
                                    <div id="pop-content" class="hiden">
                                        <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i>', ['class' => 'btn btn-primary btn-sm editable-submit']) ?>
                                        <button id="cancel_image" type="button"
                                                class="btn btn-default btn-sm editable-cancel">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </button>
                                    </div>
                                    <div id="pop-content1_2" class="hiden">
                                        <h5>Are you sure want to remove Logo?</h5>
                                        <button id="confirm_remove_logo" type="button" value="logo"
                                                class="btn btn-primary btn-sm editable-submit">
                                            <i class="glyphicon glyphicon-ok"></i>
                                        </button>
                                        <button id="cancel_remove" type="button"
                                                class="btn btn-default btn-sm editable-cancel">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </button>
                                    </div>
                                    <?php ActiveForm::end() ?>
                                </div>
                                <div class="col-md-5 col-sm-9">
                                    <div class="cname"><?= $organization['name']; ?></div>
                                    <!--                                    <div>-->
                                    <!--                                        <div class="tagline" id="tagline1" >-->
                                    <!--                                            <span href="#" class="select-industries" data-pk="industry_enc_id" data-name="industry_enc_id" data-type="select" data-title="Select feild of working"></span>-->
                                    <!--                                            <span id="controller" class="pen"><i class="fa fa-pencil"></i></span>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <div>
                                        <div class="tagline" id="tagline2">
                                            <span href="#" class="model" data-type="text" data-pk="tag_line"
                                                  data-name="tag_line"
                                                  data-value="<?= $organization['tag_line']; ?>"></span>
                                            <span id="controller" class="pen"><i class="fa fa-pencil"></i></span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="tagline" id="tagline2">
                                            <span>Establishment in </span>
                                            <span href="#" id="establishment_year" data-type="combodate"
                                                  data-format="YYYY" data-pk="establishment_year" data-viewformat="YYYY"
                                                  data-template="YYYY" data-name="establishment_year"
                                                  data-value="Establishment in <?= $organization['establishment_year']; ?>"></span>
                                            <span id="controller" class="pen"><i class="fa fa-pencil"></i></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-5 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="social-btns">
                                                <div class="social-inner">
                                                    <a class="btns facebook model-link" data-pk="facebook"
                                                       data-name="facebook" data-type="url"
                                                       data-value="<?= $organization['facebook']; ?>"
                                                       href="<?= $organization['facebook']; ?>">
                                                        <i class="fa fa-facebook"></i>
                                                    </a>
                                                    <span id="controller" class="pen"><i
                                                                class="fa fa-pencil"></i></span>
                                                </div>
                                                <div class="social-inner">
                                                    <a class="btns twitter model-link" data-pk="twitter"
                                                       data-name="twitter" data-type="url"
                                                       data-value="<?= $organization['twitter']; ?>"
                                                       href="<?= $organization['twitter']; ?>">
                                                        <i class="fa fa-twitter"></i>
                                                    </a>
                                                    <span id="controller" class="pen"><i
                                                                class="fa fa-pencil"></i></span>
                                                </div>
                                                <div class="social-inner">
                                                    <a class="btns google model-link" data-pk="google"
                                                       data-name="google" data-type="url"
                                                       data-value="<?= $organization['google']; ?>"
                                                       href="<?= $organization['google']; ?>">
                                                        <i class="fa fa-google"></i>
                                                    </a>
                                                    <span id="controller" class="pen"><i
                                                                class="fa fa-pencil"></i></span>
                                                </div>
                                                <div class="social-inner">
                                                    <a class="btns instagram model-link" data-pk="instagram"
                                                       data-name="instagram" data-type="url"
                                                       data-value="<?= $organization['instagram']; ?>"
                                                       href="<?= $organization['instagram']; ?>">
                                                        <i class="fa fa-instagram"></i>
                                                    </a>
                                                    <span id="controller" class="pen"><i
                                                                class="fa fa-pencil"></i></span>
                                                </div>
                                                <div class="social-inner">
                                                    <a class="btns youtube model-link" data-pk="youtube"
                                                       data-name="youtube" data-type="url"
                                                       data-value="<?= $organization['youtube']; ?>"
                                                       href="<?= $organization['youtube']; ?>">
                                                        <i class="fa fa-youtube"></i>
                                                    </a>
                                                    <span id="controller" class="pen"><i
                                                                class="fa fa-pencil"></i></span>
                                                </div>
                                                <div class="social-inner">
                                                    <a class="btns linkedin model-link" data-pk="linkedin"
                                                       data-name="linkedin" data-type="url"
                                                       data-value="<?= $organization['linkedin']; ?>"
                                                       href="<?= $organization['linkedin']; ?>">
                                                        <i class="fa fa-linkedin"></i>
                                                    </a>
                                                    <span id="controller" class="pen"><i
                                                                class="fa fa-pencil"></i></span>
                                                </div>
                                                <div class="social-inner">
                                                    <a class="btns website model-link" data-pk="website"
                                                       data-name="website" data-type="url"
                                                       data-value="<?= $organization['website']; ?>"
                                                       href="<?= $organization['website']; ?>">
                                                        <i class="fa fa-globe"></i>
                                                    </a>
                                                    <span id="controller" class="pen"><i
                                                                class="fa fa-pencil"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about">
        <div id="vision" class="vision ">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="t-heading">Who We Are</div>
                                    <div id="whoWe" class="a-details">
                                        <p>
                                            <span href="#" class="model" data-pk="description" data-name="description"
                                                  data-type="textarea"
                                                  data-value="<?= $organization['description']; ?>"></span>
                                            <span id="controller" class="pen pen_top2"><i
                                                        class="fa fa-pencil"></i></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="t-heading">Our Vision</div>
                                    </i>
                                    <div id="ourVision" class="a-details">
                                        <p>
                                            <span href="#" class="model" data-pk="vision" data-name="vision"
                                                  data-type="textarea"
                                                  data-value="<?= $organization['vision']; ?>"></span>
                                            <span id="controller" class="pen pen_top"><i
                                                        class="fa fa-pencil"></i></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="t-heading">Our Mission</div>
                                    <div id="ourMission" class="a-details">
                                        <p>
                                            <span href="#" class="model" data-pk="mission" data-name="mission"
                                                  data-type="textarea"
                                                  data-value="<?= $organization['mission']; ?>"></span>
                                            <span id="controller" class="pen pen_ttop"><i
                                                        class="fa fa-pencil"></i></span>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="clearfix"></div>

    <section id="video">
        <div class="video">
            <div class="container">
                <div class="content">
                    <div class="t-heading">Video Gallery
                        <div class="button_location pull-right">
                            <!--<= Html::button('Add New Video', ['value' => URL::to('/site/companys1'), 'class' => 'btn modal-load-class btn-primary btn-circle custom_color-set2']); ?>-->
                            <button type="submit" class="i-review-nx modal-load-class" value="/companies/add-video">
                                <span class="i-review-button-tx">Add New <span
                                            class="fa fa-long-arrow-right"></span></span></button>
                        </div>
                    </div>
                    <?php
                    Pjax::begin(['id' => 'pjax_locations3']);
                    if (!empty($videos)) {
                        $rows = ceil(count($videos) / 3);
                        $next = 0;
                        for ($i = 0; $i < $rows; $i++) {
                            ?>
                            <div class="row videorow">
                                <?php
                                for ($j = 0; $j < 3; $j++) {
                                    ?>
                                    <div class="col-md-4">
                                        <div id="remove_video_confirm" class="confirm_hiden">
                                            Are you Sure want to remove?<br/>
                                            <button id="confirm_video" type="button"
                                                    value="<?= $videos[$next]['video_enc_id'] ?>"
                                                    class="btn btn-primary btn-sm editable-submit">
                                                <i class="glyphicon glyphicon-ok"></i>
                                            </button>
                                            <button id="cancel_video" type="button"
                                                    class="btn btn-default btn-sm editable-cancel">
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </button>
                                        </div>
                                        <a href="#" class="remove_video">
                                            <i class="fa fa-times-circle"></i>
                                        </a>
                                        <a href="#<?= $videos[$next]['video_enc_id'] ?>" class="videoLink">
                                            <img src="<?= $videos[$next]['cover_image']; ?>"
                                                 alt="<?= $videos[$next]['name']; ?>" class="img-fluid"/>
                                        </a>
                                        <div id="<?= $videos[$next]['video_enc_id'] ?>" class="mfp-hide video-container"
                                             style="max-width: 75%; margin: 0 auto;">
                                            <iframe width="100%" height="480px"
                                                    src="https://www.youtube.com/embed/<?= $videos[$next]['link']; ?>"
                                                    frameborder="0" allow="autoplay; encrypted-media"
                                                    allowfullscreen></iframe>
                                        </div>
                                    </div>
                                    <?php
                                    $next++;
                                }
                                ?>
                            </div>
                            <?php
                        }
                    } else {
                        echo "no video found";
                    }
                    Pjax::end();
                    ?>
                </div>
            </div>
        </div>

    </section>
    <section>
        <div class="container">
            <div class="content">
                <div class="t-heading">
                    Employee Benefits
                    <div class="button_location pull-right">
                        <button type="submit" class="i-review-nx modal-load-class" value="/companies/add-benefit">
                            <span class="i-review-button-tx">Add New <span class="fa fa-long-arrow-right"></span></span>
                        </button>
                    </div>
                </div>
                <?php
                Pjax::begin(['id' => 'pjax_benefit']);
                if (!empty($benefit)) {
                    $rows = ceil(count($benefit) / 4);
                    $next = 0;
                    for ($i = 0; $i < $rows; $i++) {
                        ?>
                        <div class="cat-sec">
                            <div class="row no-gape">
                                <?php
                                for ($j = 0; $j < 4; $j++) {
                                    if (!empty($benefit[$next]['benefit'])) {
                                        ?>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="p-category">
                                                <div class="p-category-view">
                                                    <?php
                                                    if (empty($benefit[$next]['icon'])) {
                                                        $benefit[$next]['icon'] = 'plus-icon.svg';
                                                    }
                                                    ?>
                                                    <img src="<?= Url::to('@commonAssets/employee_benefits/' . $benefit[$next]['icon']) ?>"/>
                                                    <span><?= $benefit[$next]['benefit'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    $next++;
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "no benefits found";
                }
                Pjax::end();
                ?>
            </div>
        </div>
    </section>
<!--    <section id="image1">-->
<!--        <div class="image">-->
<!--            <div class="container">-->
<!--                <div class="content">-->
<!--                    <div class="t-heading">Image Gallery</div>-->
<!--                    <div class="row imgrows">-->
<!--                        <div class="row imgrow">-->
<!--                            <div class="col-md-2 video1">-->
<!--                                <a href="--><?//= Url::to('@eyAssets/images/pages/company-profile/img-thumbnail.jpg'); ?><!--"-->
<!--                                   data-fancybox="image">-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/company-profile/img-thumbnail.jpg'); ?><!--"-->
<!--                                         class="img-fluid img-thumbnail">-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="col-md-2 video1">-->
<!--                                <a href="--><?//= Url::to('@eyAssets/images/pages/company-profile/img-thumbnail.jpg'); ?><!--"-->
<!--                                   data-fancybox="image">-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/company-profile/img-thumbnail.jpg'); ?><!--"-->
<!--                                         class="img-fluid img-thumbnail">-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="col-md-2 video1">-->
<!--                                <a href="--><?//= Url::to('@eyAssets/images/pages/company-profile/img-thumbnail.jpg'); ?><!--"-->
<!--                                   data-fancybox="image">-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/company-profile/img-thumbnail.jpg'); ?><!--"-->
<!--                                         class="img-fluid img-thumbnail">-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="col-md-2 video1">-->
<!--                                <a href="--><?//= Url::to('@eyAssets/images/pages/company-profile/img-thumbnail.jpg'); ?><!--"-->
<!--                                   data-fancybox="image">-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/company-profile/img-thumbnail.jpg'); ?><!--"-->
<!--                                         class="img-fluid img-thumbnail">-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="col-md-2 video1">-->
<!--                                <a href="--><?//= Url::to('@eyAssets/images/pages/company-profile/img-thumbnail.jpg'); ?><!--"-->
<!--                                   data-fancybox="image">-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/company-profile/img-thumbnail.jpg'); ?><!--"-->
<!--                                         class="img-fluid img-thumbnail">-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="col-md-2 video1">-->
<!--                                <a href="--><?//= Url::to('@eyAssets/images/pages/company-profile/img-thumbnail.jpg'); ?><!--"-->
<!--                                   data-fancybox="image">-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/company-profile/img-thumbnail.jpg'); ?><!--"-->
<!--                                         class="img-fluid img-thumbnail">-->
<!--                                </a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="view-main">-->
<!--                    <a id="loadmore">View More</a>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
    <section id="jobs">
        <div class="about">
            <div class="container">
                <div class="content">
                    <div class="t-heading">Available Opportunities</div>
                    <?php
                    Pjax::begin(['id' => 'pjax_jobs_cards']);

                    echo $this->render('/widgets/application-card', [
                        'type' => 'card',
                        'cards' => $jobcards,
                    ]);
                    ?>
                </div>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </section>

    <section id="offices">
        <div class="offices">
            <div class="container">
                <div class="row content">
                    <div class="t-heading col-md-12">Our Offices
                        <div class="button_location">
                            <!--<i class="fa fa-pencil" ></i>-->
                            <!--<= Html::button('Add New Location', ['value' => URL::to('/account/locations/add'), 'class' => 'btn modal-load-class btn-primary btn-circle custom_color-set2']); ?>-->
                            <button type="submit" class="i-review-nx modal-load-class"
                                    value="/account/locations/create"><span
                                        class="i-review-button-tx">Add Location <span
                                            class="fa fa-long-arrow-right"></span></span></button>
                            <!--<button type="submit" class="i-review-next"><span class="i-review-button-text" style="margin-right:0;">Add Location</span></button>-->
                        </div>
                    </div>
                    <?php Pjax::begin(['id' => 'pjax_locations1']); ?>
                    <div class="col-md-6 ">
                        <div id="map" style="height:400px"></div>
                    </div>
                    <div class="col-md-6 content loc">

                        <ul class="loc-list">
                            <?php
                            $i = 1;
                            foreach ($locations as $info) {
                                ?>
                                <li>
                                    <span><?= $info['location_name']; ?>:-</span> <?= $info['address'] . ', ' . $info['city'] . ', ' . $info['state'] . ', ' . $info['country'] . ' ' . $info['postal_code']; ?>
                                    <a href="#" class="remove_location"><i class="fa fa fa-times-circle"></i></a>
                                    <div id="remove_location_confirm" class="confirm_remove_loc">
                                        <button id="confirm_loc" type="button" value="<?= $info['location_enc_id']; ?>"
                                                class="btn btn-primary btn-sm editable-submit"><i
                                                    class="glyphicon glyphicon-ok"></i></button>
                                        <button id="cancel_loc" type="button"
                                                class="btn btn-default btn-sm editable-cancel"><i
                                                    class="glyphicon glyphicon-remove"></i></button>
                                    </div>
                                </li>
                                <?php
                                $locations_loc .= "['" . $info['location_name'] . "', " . $info['latitude'] . ", " . $info['longitude'] . ", " . $i . "],";
                                $i++;
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                    Pjax::end();
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>
<section>
    <div class="container">
        <div class="empty-field">
            <input type="hidden" id="loggedIn" value="<?= (!Yii::$app->user->isGuest) ? 'yes' : '' ?>">
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <p>Please Login to your empower youth profile or Sign Up </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

    </div>

</section>
<?php $this->registerCss("
.fab-message{
    position:fixed;
    bottom: 20px;
    cursor:pointer;
    right:20px;
    z-index:9999;
    color: #fff;
    font-size: 20px;
    border-radius: 50%;
    width:100px;
    height:80px;
    line-height: 60px;
    text-align: center;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
}
#fab-message-open:hover .fab-hover-message{
  -webkit-animation-name: example1; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 4s; /* Safari 4.0 - 8.0 */
    -webkit-animation-iteration-count: infinite; /* Safari 4.0 - 8.0 */
    animation-name: example1;
    opacity:1;
    animation-duration: 2s;
    animation-iteration-count: 2;
}
@-webkit-keyframes example1 {
  0%   { right:6px; bottom:120px;}
  100%  { right:6px; bottom:55px;}
}
@keyframes example1{
  0%   {right:6px; bottom:120px;}
  100%  {right:6px; bottom:55px;}
}
.fab-hover-message{
    bottom: 120px;
    right: 6px;
    color:#222;
    opacity: 0; 
//  display: none;
    position: absolute;
    font-size: 18px; 
    padding: 15px;
     border-radius: 3px;
     z-index:9; 
}

.fab-hover-image img{
    width:85px;
    height:85px;
}

.coverpic{
    text-align: center;
    position:relative;
}
.i-review-question-title{
    color:#fff;
}
.i-review-box{
    color:#fff;
}


.apply-job-btn {
    background: #ffffff;
    -webkit-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
    -moz-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
    -ms-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
    -o-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
    box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
    -webkit-border-radius: 40px;
    -moz-border-radius: 40px;
    -ms-border-radius: 40px;
    -o-border-radius: 40px;
    border-radius: 40px;
    font-family: Open Sans;
    font-size: 14px;
    color: #ef7706;
    width: 200px;
    height: auto;
    padding: 15px 30px;
    text-align: center;
    margin: auto;
}    

.button_location{
    padding: 14px 0px;
    float:right;
}

.videoLink > .img-fluid{
    float: right;
}

.img-circle{height: 200px;width: 200px;box-shadow: 0px 0px 25px rgb(0,0,0,.3); }
.remove_video{
    position: absolute;
    display:none;
    color: red;
    background-color: #fff;
    width: 20px;
    height: 20px;
    right: 22px;
    top: 6px;
    border-radius: 50%;
    line-height: 20px;
    text-align: center;
    font-size: 26px;
}
.remove_location{
    display:none;
    color: red;
    float: right;
    line-height: 26px;
    font-size: 24px;
}
.confirm_hiden{
    position: absolute;
    display:none;
    width: 92.5%;
    height: 100%;
    background-color: #0000009e;
    text-align: center;
    color: #fff;
    font-size: 16px;
    padding-top: 100px;
}
.loc-list li{
    position:relative;
}
.confirm_remove_loc{
    position: absolute;
    right: 0;
    top: 0;
    display:none;
}
.avatar-edit {
    position: absolute;
    right: 35px;
    z-index: 1;
    top: 10px;
    display: inline-block;
    width: 34px;
    height: 34px;
    text-align: center;
    line-height: 31px;
    margin-bottom: 0;
    border-radius: 100%;
    background: #FFFFFF;
    border: 1px solid transparent;
    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
    cursor: pointer;
    font-weight: normal;
    transition: all 0.2s ease-in-out;
}
.avatar-edit input, .cover-edit input {
  display: none;
}
.avatar-edit:hover {
  background: #f1f1f1;
  border-color: #d6d6d6;
}
.full_width{
    width:100%;
    height:100%;
}
.cover-edit{
    position: absolute;
    right: 0;
    bottom: 0px;
    width:190px;
}
.cover-edit .edits{
    position: absolute;
    right: 0;
    bottom: 0px;
    background-color: #f1f1f1;
    padding: 10px 15px;
    border-radius: 8px 0px 0px;
}
.hiden{
    display:none;
    position: absolute;
    width: 100%;
    background-color: #f9f9f9;
    padding: 10px 5px;
    box-shadow: 0px 0px 12px 2px #cecece;
    border-radius: 6px;
    text-align: center;
    top: 42px;
    left: 159px;
    z-index: 999;
}
.hiden:before{
    content: '';
    left: -15px;
    top: 15px;
    position: absolute;
    border-top: 10px solid transparent;
    border-right: 15px solid #f9f9f9;
    border-bottom: 10px solid transparent;
}
.hiden2{
    display:none;
    position: absolute;
    width: 100%;
    background-color: #f9f9f9;
    padding: 10px 5px;
    box-shadow: 0px 0px 12px 2px #cecece;
    border-radius: 6px;
    text-align: center;
    top: 12px;
    left: 0px;
    z-index: 999;
}
.hiden2:before{
    content: '';
    right: 36px;
    top: -13px;
    position: absolute;
    border-left: 10px solid transparent;
    border-bottom: 15px solid #f9f9f9;
    border-right: 10px solid transparent;
}
.social-inner{
    position:relative;
    float:left;
}
.social-inner .pen{
    position: absolute;
    display: block;
    top: -4px;
    right: 3px;
    z-index: 99;
    font-size: 15px;
}
/*Bootstrap editable css starts */
.pen{
    cursor: pointer;
    color:#222;
}
.editableform .control-group{
    width: auto;
    height: auto;
    padding: 0;
    margin: 2px;
}
.editable-input .form-control{
    height:auto;
    width:50vh;
}
.editable-buttons .btn-sm{
    padding: 5px 10px;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 3px;
}
.editable-click, a.editable-click, a.editable-click:hover{
    border-bottom:0px;
}
.editable-unsaved{
    font-weight:normal;
}
.popover .arrow, .popover .arrow:after{
    display: block !important;
}
.pen_top{
    position: absolute;
    top: 8px;
    left: 140px;
}
.pen_ttop{
    position: absolute;
    top: 8px;
    left: 160px;
}
.pen_top2{
    position: absolute;
    left: 162px;
    top: 8px;
}
/*Bootstrap editable css ends */
/*Loader css starts */
.loader-aj-main{
    display:none;
    position:fixed;
    background-color:#f9f9f9b0;
    top:0;
    left:0;
    width:100%;
    height:100%;
    z-index:99999;
}
.loader-aj {
    display: flex;
    animation: rotate 1s ease-in-out infinite;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
}
.loader-aj .dot {
    width: 50px;
    height: 50px;
    background: #4aa1e3;
    border-radius: 50%;
  }
.loader-aj .dot.first {
    animation: dot-1 1s ease-in-out infinite;
  }
.loader-aj .dot.second {
    animation: dot-2 1s ease-in-out infinite;
  }
@keyframes rotate {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
@keyframes dot-1 {
  0% {
    transform: translate(0px, 0) rotate(0deg);
  }
  50% {
    transform: translate(-50px, 0) rotate(180deg);
  }
  100% {
    transform: translate(0px, 0) rotate(360deg);
  }
}
@keyframes dot-2 {
  0% {
    transform: translate(0px, 0) rotate(0deg);
  }
  50% {
    transform: translate(50px, 0) rotate(180deg);
  }
  100% {
    transform: translate(0px, 0) rotate(360deg);
  }
}
/*Loader css ends */
.dropdown-menu{
    padding:0px;
}
.dropdown-menu li a{
    line-height: 28px;
    border-bottom: 1px solid #eee;
}
.dropdown-menu li a:hover{
    background-color: #4aa1e3;
    color: #fff;
    border-color:transparent;
}
.dropdown-menu li a label{
    font-weight:normal;
    font-size:14px;
    margin:0px;
}

/* Feature, categories css starts */
.checkbox-input {
  display: none;
}
.checkbox-label {
/*   display: inline-block; */
/*   position: relative; */
  vertical-align: top;
  width: 100%;
  cursor: pointer;
  font-weight: 400;
  margin-bottom:0px;
}
.checkbox-label:before {
  content: '';
  position: absolute;
  top: 80px;
  right: 16px;
  width: 40px;
  height: 40px;
  opacity: 0;
  background-color: #2196F3;
  background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
  background-position: 80% 80%;
  background-repeat: no-repeat;
  background-size: 30px;
  border-radius: 50%;
  -webkit-transform: translate(0%, -50%);
  transform: translate(0%, -50%);
  transition: all 0.4s ease;
}
.checkbox-input:checked + .checkbox-label:before {
  top: 0;
  opacity: 1;
}
.checkbox-input:checked + .checkbox-label .checkbox-text span {
  -webkit-transform: translate(0, -8px);
  transform: translate(0, -8px);
}

.cat-sec {
    float: left;
    width: 100%;
}
.p-category {
    float: left;
    width: 100%;
    z-index: 1;
    position: relative;
}
.p-category, .p-category *{
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}
.p-category .p-category-view, .p-category .checkbox-text {
    float: left;
    width: 100%;
    text-align: center;
    padding-bottom: 30px;
    border-bottom: 1px solid #e8ecec;
    border-right: 1px solid #e8ecec;
}
.p-category .p-category-view img, .p-category .checkbox-text span i {
    color: #4aa1e3;
    font-size: 70px;
    margin-top: 30px;
    line-height: initial !important;
}
.p-category .p-category-view span, .p-category .checkbox-text span {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 15px;
    color: #202020;
    margin-top: 18px;
}
.p-category img, .checkbox-text--title img{
    width: 80px;
    height: 50px;
}
.p-category:hover {
    background: #ffffff;
    -webkit-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -moz-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -ms-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -o-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    width: 104%;
    margin-left: -2%;
    height: 102%;
    z-index: 10;
}
.p-category:hover a, .p-category:hover .checkbox-text {
    border-color: #ffffff;
}
.p-category:hover i, .p-category:hover .checkbox-label i{
    color: #f07d1d;
}
.row.no-gape > div, .row.no-gape .p-category-main {
    padding: 0;
}
.cat-sec .row > div:last-child .p-category-view, .cat-sec .row .p-category-main:nth-child(4n+0) .checkbox-text {
    border-right-color: #ffffff;
}
/* Feature, categories css ends */
") ?>

<?php
$script = <<<JS
$('.model').editable({
    placement: 'top',
    url: '/companies/update-profile',
    toggle: 'manual',
});
$('.model-link').editable({
    placement: 'top',
    url: '/companies/update-profile',
    toggle: 'manual',
    display: function(value) {
        $(this).attr('href',value);
    }
});
$('#establishment_year').editable({
    placement: 'top',
    url: '/companies/update-profile',
    toggle: 'manual',
    combodate: {
        minYear: 1956,
        maxYear: 2019,
    }
});

$('.pen').click(function(e){
    e.stopPropagation();
    $(this).prev().editable('toggle');
});

$(document).on('click', '.modal-load-class', function() {
    $('#modal').modal('show').find('.modal-body').load($(this).attr('value'));   
});

$(document).on("click", "#open-modal", function () {
    $(".modal-body").load($(this).attr("url"));
});
        
var image_path = $('#logo-img').attr('src');
var logo_name_path = "$no_image";
var default_cover_path = "$no_cover";
var cover_path = $('#cover_img').attr('src');
        
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#logo-img').attr('src', e.target.result);
            $('#logo-img').hide();
            $('#logo-img').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#cover_img').attr('src', e.target.result);
            $('#cover_img').fadeTo(1000, 0.4);
            $('#cover_img').fadeTo(1000, 1);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
      
$("#logoUpload").change(function() {
    readURL(this);
});
$("#coverImageUpload").change(function() {
    readURL2(this);
});
        
$('#logo-img').on('load', function () {
    if($("#logo-img").attr('src') != image_path && $("#logo-img").attr('src') != logo_name_path){
        $('#pop-content').fadeIn(1000);
   }
});
$('#cover_img').on('load', function () {
    if($("#cover_img").attr('src') != cover_path ){
        $('#pop-content2').fadeIn(1000);
   }
});
        
$(document).on('click', '#cancel_image', function() {
    $('#pop-content').fadeOut(1000);
    $('#logo-img').attr('src', image_path);
});
$(document).on('click', '#cancel_remove', function() {
    $('#pop-content1_2').fadeOut(1000);
});
$(document).on('click', '#cancel_cover', function() {
    $('#pop-content2').fadeOut(1000);
    $('#cover_img').attr('src', cover_path);
});
$(document).on('click', '#cancel_cover_remove', function() {
    $('#pop-content2_2').fadeOut(1000);
});
$(document).on('click', '.remove-logo', function(a) {
    a.preventDefault();
    $('#pop-content1_2').fadeIn(1000);
});
$(document).on('click', '.remove_cover_image', function(a) {
    a.preventDefault();
    $('#pop-content2_2').fadeIn(1000);
});
        
$(document).on('submit', '#upload-logo', function(event) {
    event.preventDefault();
    $('#pop-content').fadeOut(1000);
    $.ajax({
        url: "/companies/update-logo",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache:false,
        processData: false,
        beforeSend:function(){     
            $('#page-loading').fadeIn(1000);  
        },
        success: function (response) {
        $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
                $.pjax.reload({container: '#pjax_jobs_cards', async: false});
                hide_remove_logo();
            } else {
                toastr.error(response.message, response.title);
            }
            
        }
    });
});
        
$(document).on('click', '#confirm_remove_logo', function(event) {
    event.preventDefault();
    $('#pop-content1_2').fadeOut(1000);
    var type = $(this).val();
    $.ajax({
        url: "/companies/remove-image",
        method: "POST",
        data: {type:type},
        beforeSend:function(){
            $('#page-loading').fadeIn(1000);  
        },
        success: function (response) {
        $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
                $.pjax.reload({container: '#pjax_jobs_cards', async: false});
                $('#logo-img').attr('src',logo_name_path);
                hide_remove_logo();
            } else {
                toastr.error(response.message, response.title);
            }
        }
    });
});

function hide_remove_logo(){
    var img_path = $('#logo-img').attr('src');
    if(img_path == logo_name_path){
        $('.remove-logo').parent('li').css('display', 'none');
    } else{
        $('.remove-logo').parent('li').css('display', 'block');
    }
}
hide_remove_logo();

$(document).on('submit', '#change-cover-image', function(event) {
    event.preventDefault();
    $('#pop-content2').fadeOut(1000);
    $.ajax({
        url: "/companies/update-cover-image",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache:false,
        processData: false,
        beforeSend:function(){     
            $('#page-loading').fadeIn(1000);  
        },
        success: function (response) {
        $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                hide_remove_cover();
                toastr.success(response.message, response.title);
            } else {
                toastr.error(response.message, response.title);
            }
            
        }
    });
});
       
$(document).on('click', '#confirm_remove_cover', function(event) {
    event.preventDefault();
    $('#pop-content2_2').fadeOut(1000);
    var type = $(this).val();
    $.ajax({
        url: "/companies/remove-image",
        method: "POST",
        data: {type:type},
        beforeSend:function(){
            $('#page-loading').fadeIn(1000);  
        },
        success: function (response) {
        $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                $('#cover_img').attr('src',default_cover_path);
                toastr.success(response.message, response.title);
                $.pjax.reload({container: '#pjax_jobs_cards', async: false});
                hide_remove_cover();
            } else {
                toastr.error(response.message, response.title);
            }
        }
    });
});

function hide_remove_cover(){
    var cover_img_path = $('#cover_img').attr('src');
    if(cover_img_path == default_cover_path){
        $('.remove_cover_image').parent('li').css('display', 'none');
    } else{
        $('.remove_cover_image').parent('li').css('display', 'block');
    }
}
hide_remove_cover();

$(document).on('mouseover', '.videoLink img', function(){
    $(this).parent().prev().show();
});
$(document).on('mouseout', '.videoLink img', function(){
    $(this).parent().prev().hide();
});
$(document).on('mouseover', '.loc-list li', function(){
    $(this).children('a').show();
});
$(document).on('mouseout', '.loc-list li', function(){
    $(this).children('a').hide();
});
$(document).on('mouseover', '.remove_video', function(){
    $(this).css('display', 'block');
});
$(document).on('mouseout', '.remove_video', function(){
    $(this).css('display', 'none');
});
$(document).on('mouseover', '.remove_location', function(){
    $(this).css('display', 'inline');
});
$(document).on('mouseout', '.remove_location', function(){
    $(this).css('display', 'none');
});
$(document).on('click', '.remove_video', function(e) {
    e.preventDefault();
    $(this).prev().fadeIn();
});
$(document).on('click', '.remove_location', function(e) {
    e.preventDefault();
    $(this).next().fadeIn();
});
$(document).on('click', '#cancel_video', function() {
    $(this).parent().fadeOut();
});
$(document).on('click', '#cancel_loc', function() {
    $(this).parent().fadeOut();
});
        
$(document).on('click', '#confirm_video', function(event) {
    event.preventDefault();
    $('#remove_video_confirm').fadeOut(1000);
    var id = $(this).val();
    $.ajax({
        url: "/companies/video-delete",
        method: "POST",
        data: {id:id},
        beforeSend:function(){     
            $('#page-loading').fadeIn(1000);  
        },
        success: function (response) {
        $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
                $.pjax.reload({container: '#pjax_locations3', async: false});
            } else {
                toastr.error(response.message, response.title);
            }
            
        }
    });
});
$(document).on('click', '#confirm_loc', function(event) {
    event.preventDefault();
    $('#remove_video_confirm').fadeOut(1000);
    var id = $(this).val();
    $.ajax({
        url: "/companies/location-delete",
        method: "POST",
        data: {id:id},
        beforeSend:function(){     
            $('#page-loading').fadeIn(1000);  
        },
        success: function (response) {
        $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
                $.pjax.reload({container: '#pjax_locations1', async: false});
                $.pjax.reload({container: '#location_map', async: false});
            } else {
                toastr.error(response.message, response.title);
            }
            
        }
    });
}); 

        
    $('.videoLink').magnificPopup({
            type: 'inline',
            midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
        })
        
    
        // JavaScript Document
      $(document).ready(function(){
	$('.edit').click(function(){
		$(this).hide();
		$(this).prev().hide();
		$(this).next().show();
		$(this).next().select();
	});
	$('input[type="text"]').blur(function() {  
         if ($.trim(this.value) == ''){  
			 this.value = (this.defaultValue ? this.defaultValue : '');  
		 }
		 else{
			 $(this).prev().prev().html(this.value);
		 }
		 $(this).hide();
		 $(this).prev().show();
		 $(this).prev().prev().show();
     });
	  $('input[type="text"]').keypress(function(event) {
		  if (event.keyCode == '13') {
			  if ($.trim(this.value) == ''){  
				 this.value = (this.defaultValue ? this.defaultValue : '');  
			 }
			 else
			 {
				 $(this).prev().prev().html(this.value);
			 }
			 
			 $(this).hide();
			 $(this).prev().show();
			 $(this).prev().prev().show();
		  }
	  });
		  
  });
  

    
    var popup = new ideaboxPopup({
        background: '#234b8f',
        popupView: 'full',
        endPage: {
            msgTitle : 'Profile has been updated',
            msgDescription : 'Thanks for submitting your profile',
            showCloseBtn: true,
            closeBtnText : 'Close All',
            inAnimation: 'zoomIn'
        },
        data: [
           {
                    question 	: 'Select Job Profile',
                    answerType	: 'radio2',
                    //database field name
                    formName	: 'job_profile',
                    //values from database
                    choices		: [
                            { label : 'Information Technology', value : 'Information Technology' },
                            { label : 'Marketing', value : 'Marketing' },
                            { label : 'Green', value : 'GREEN' },
                            { label : 'Yellow', value : 'YELLOW' }
                    ],
                    description	: 'Please select your job profile',
                    required	: true,
                    errorMsg	: '<b style="color:#900;">Select the choices.</b>'
            },
           {
                    question 	: 'Select Job Title',
                    answerType	: 'checkbox2',
                    formName	: 'job_title',
                    choices		: [
                            { label : 'Frontend Developer', value : 'Frontend Developer' },
                            { label : 'Backend Developer', value : 'Backend Developer' },
                            { label : 'Graphic Designer', value : 'Graphic Designer' },
                            { label : 'SEO', value : 'SEO' }
                    ],
                    description	: 'Please select job titles that you are interested in and press next button',
                    required	: true,
                    errorMsg	: '<b style="color:#900;">Select between 1-2 choices.</b>'
            },
          {
                    question 	: 'Preffered Location',
                    answerType	: 'checkbox2',
                    formName	: 'locations',
                    choices		: [
                            { label : 'Ludhiana', value : 'Ludhiana' },
                            { label : 'Jalandhar', value : 'Jalandhar' },
                            { label : 'Chandigarh', value : 'Chandigarh' },
                            { label : 'Amritsar', value : 'Amritsar' },
                            { label : 'United States', value : 'USA' },
                            { label : 'England', value : 'EN' },
                            { label : 'Spain', value : 'ESP' },
                            { label : 'Turkey', value : 'TUR' },
                            { label : 'Argentina', value : 'ARG' },
                            { label : 'India', value : 'END' },
                            { label : 'Brazi', value : 'BRA' },
                            { label : 'French', value : 'FRA' },
                            { label : 'Germany', value : 'DEU' },
                            { label : 'Greece', value : 'GRC' },
                            { label : 'Hong Kong', value : 'HKG' },
                            { label : 'Italy', value : 'ITA' },
                            { label : 'South Korea', value : 'KOR' },
                            { label : 'United Kingdom', value : 'GBR' },
                            { label : 'Russia', value : 'RUS' }
                    ],
                    description	: 'Please select your preffered location and press next button',
                    required	: true,
                    errorMsg	: '<b style="color:#900;">Select the location to proceed.</b>'
            },
            {
                question 	: 'Experience',
                answerType	: 'radio2',
                formName	: 'experience',
                choices		: [
                        { label : 'No Experince', value : 'No' },
                        { label : '<1 Year', value : '0' },
                        { label : '1 Year', value : '1' },
                        { label : '2-3 Years', value : '2-3' },
                        { label : '3-5 Years', value : '3-5' },
                        { label : '5-10 Years', value : '5-10' }, 
                        { label : '10+ Years', value : '10+' },
                ],
                description	: 'How much experience do you have?',
                nextLabel : 'Apply Now',
                required	: true,
                errorMsg	: '<b style="color:#900;">Select the location to proceed.</b>'
            
             },
            {
                question: '<h2 style="color: #fff; font-weight: 900;">You have applied with your empower youth profile </h2>',
                answerType: 'updatebtn',
                formName : 'is_applied',
                 choices		: [
                     {label: 'http://www.eygb.me/user/ajay'}
                 ],
                description: '',
                nextLabel : 'Finish',
            },

        ]
    });
    
    document.getElementById("fab-message-open").addEventListener("click", function (e) {
        if($('#loggedIn').val())
            popup.open();
        else
            $('#myModal').modal('toggle');
    });
    


JS;

$this->registerJs("
$('.select-industries').editable({
    url: '/companies/update-profile',
    value: '" . $organization['industry_enc_id'] . "',
    source: " . $industries . "
});
");

Pjax::begin(['id' => 'location_map']);
$i = 1;
foreach ($locations as $info) {
    $locations_loc .= "['" . $info['location_name'] . "', " . $info['latitude'] . ", " . $info['longitude'] . ", " . $i . "],";
    $i++;
}
$this->registerJs("
    var locations = [" . $locations_loc . "];
//var locations = [
//        ['Bondi Beach', 30.899014, 75.853180, 4],
//      ['Coogee Beach', 30.905644, 75.861589, 1],
//      ['Cronulla Beach', 30.913589, 75.828808, 3],
//      ['Manly Beach', 30.916534, 75.858664, 2],
//    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 4,
      center: new google.maps.LatLng(30.900965, 75.857277),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

//    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) { 
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

//      google.maps.event.addListener(marker, 'click', (function(marker, i) {
//        return function() {
//          infowindow.setContent(locations[i]);
//          infowindow.open(map, marker);
//        }
//      })(marker, i));
    }
    
    
  
");
$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c', ['depends' => [\yii\web\JqueryAsset::className()]]);
Pjax::end();
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/company-profile.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerCssFile('@eyAssets/css/jquery.fancybox.min.css');
$this->registerCssFile('@eyAssets/css/magnific-popup.min.css');
$this->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css');
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/scripts/app.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.0.0/jquery.magnific-popup.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@eyAssets/ideapopup/ideabox-popup_add_resume.js');
?>
