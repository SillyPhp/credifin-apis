<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

if ($organization['logo']) {
    $image_path = Yii::$app->params->upload_directories->organizations->logo_path . $organization['logo_location'] . DIRECTORY_SEPARATOR . $organization['logo'];
    $image = Yii::$app->params->upload_directories->organizations->logo . $organization['logo_location'] . DIRECTORY_SEPARATOR . $organization['logo'];
    if (!file_exists($image_path)) {
        $image = "https://ui-avatars.com/api/?name=" . $organization['name'] . '&size=200&rounded=false&background=' . str_replace("#", "", $organization['initials_color']) . '&color=ffffff';
    }
} else {
    $image = "https://ui-avatars.com/api/?name=" . $organization['name'] . '&size=200&rounded=false&background=' . str_replace("#", "", $organization['initials_color']) . '&color=ffffff';
}

if ($organization['cover_image']) {
    $cover_image_path = Yii::$app->params->upload_directories->organizations->cover_image_path . $organization['cover_image_location'] . DIRECTORY_SEPARATOR . $organization['cover_image'];
    $cover_image = Yii::$app->params->upload_directories->organizations->cover_image . $organization['cover_image_location'] . DIRECTORY_SEPARATOR . $organization['cover_image'];
    if (!file_exists($cover_image_path)) {
        $cover_image = "@eyAssets/images/pages/jobs/default-cover.png";
    }
} else {
    $cover_image = "@eyAssets/images/pages/jobs/default-cover.png";
}
$no_image = "https://ui-avatars.com/api/?name=" . $organization['name'] . '&size=200&rounded=false&background=' . str_replace("#", "", $organization['initials_color']) . '&color=ffffff';
//print_r($organization);
//exit();
?>
    <section>
        <div class="header-bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="h-inner">
                            <div class="logo-absolute">
                                <div class="logo-box">
                                    <div class="logo">
                                        <!--                                        <input type="hidden" value="-->
                                        <?php //?><!--">-->
                                        <img id="logo-img" src="<?= Url::to($image); ?>">
                                        <!--                                            <canvas class="user-icon img-circle img-thumbnail " name="-->
                                        <?//= $image; ?><!--"-->
                                        <!--                                                    color="-->
                                        <?//= $organization['initials_color'] ?><!--" width="200"-->
                                        <!--                                                    height="200" font="85px"></canvas>-->
                                        <?php
                                        if (Yii::$app->user->identity->organization->slug === $organization['slug']) {
                                            $form = ActiveForm::begin([
                                                'id' => 'upload-logo',
                                                'options' => ['enctype' => 'multipart/form-data'],
                                            ])
                                            ?>
                                            <div id="open-pop" class="avatar-edit">
                                                <i class="fa fa-pencil dropdown-toggle full_width"
                                                   data-toggle="dropdown"></i>
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
                                                <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i>', ['class' => 'btn-primary btn-sm editable-submit']) ?>
                                                <button id="cancel_image" type="button"
                                                        class="btn-default btn-sm editable-cancel">
                                                    <i class="glyphicon glyphicon-remove"></i>
                                                </button>
                                            </div>
                                            <div id="pop-content1_2" class="hiden">
                                                <h5>Are you sure want to remove Logo?</h5>
                                                <button id="confirm_remove_logo" type="button" value="logo"
                                                        class="btn-primary btn-sm editable-submit">
                                                    <i class="glyphicon glyphicon-ok"></i>
                                                </button>
                                                <button id="cancel_remove" type="button"
                                                        class="btn-default btn-sm editable-cancel">
                                                    <i class="glyphicon glyphicon-remove"></i>
                                                </button>
                                            </div>
                                            <?php
                                            ActiveForm::end();
                                        } ?>
                                        <!--                                        <img src="-->
                                        <? //= Url::to('@eyAssets/images/pages/review/dummy-logo.png') ?><!--">-->
                                    </div>
                                </div>
                                <div class="com-details">
                                    <div class="com-name"><?= Html::encode($organization['name']) ?></div>
                                    <div class="com-establish"><span class="detail-title">Tagline:</span> <span
                                                class="model" id="tag_line" data-type="text" data-pk="tag_line"
                                                data-name="tag_line"
                                                data-value="<?= Html::encode($organization['tag_line']); ?>"></span> <?php if (Yii::$app->user->identity->organization->slug === $organization['slug']) { ?>
                                            <span data-for="tag_line" class="edit-box"><i
                                                        class="fa fa-pencil"></i></span><?php } ?></div>
                                    <div class="com-establish"><span class="detail-title">Industry:</span> <span
                                                class="model" id="industry"
                                                data-value="Information Technology"></span> <?php if (Yii::$app->user->identity->organization->slug === $organization['slug']) { ?>
                                            <span data-for="industry" class="edit-box"><i
                                                        class="fa fa-pencil"></i></span><?php } ?></div>
                                    <!--                                    <div class="com-establish"><span>Business Activity:</span> Business</div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container padd-top-0">
            <div class="row">
                <div class="col-md-6 col-md-offset-2 col-sm-10 col-sm-offset-2 col-xs-12">
                    <ul class="nav nav-tabs nav-padd-20">
                        <li class="active"><a data-toggle="tab" href="#home">Overview</a></li>
                        <li><a data-toggle="tab" href="#menu1">Opportunities</a></li>
                        <li><a data-toggle="tab" href="#tab4">Location</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <?php
                    if (Yii::$app->user->identity->organization->slug === $organization['slug']) {
                        ?>
                        <div class="follow-btn">
                            <button id="enable" class="follow">Edit Profile</button>
                        </div>
                        <?php
                    } elseif (Yii::$app->user->identity->user_enc_id) {
                        ?>
                        <div class="follow-btn">
                            <button class="follow">Follow</button>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="social-btns">
                        <a href="javascript:;" data-pk="facebook" data-name="facebook" data-type="url"
                           data-value="<?= Html::encode($organization['facebook']) ?>" class="facebook model-link"><i
                                    class="fa fa-facebook"></i> </a>
                        <!--                        <a href="-->
                        <? //= Html::encode($organization['facebook']) ?><!--" class="facebook"><i class="fa fa-facebook"></i> </a>-->
                        <a href="javascript:;" data-pk="twitter" data-name="twitter" data-type="url"
                           data-value="<?= Html::encode($organization['twitter']) ?>" class="twitter model-link"><i
                                    class="fa fa-twitter"></i> </a>
                        <a href="javascript:;" data-pk="linkedin" data-name="linkedin" data-type="url"
                           data-value="<?= Html::encode($organization['linkedin']) ?>" class="linkedin model-link"><i
                                    class="fa fa-linkedin"></i> </a>
                        <a href="javascript:;" data-pk="website" data-name="website" data-type="url"
                           data-value="<?= Html::encode($organization['website']) ?>" class="web model-link"><i
                                    class="fa fa-link"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="row">
                        <div class="heading-style">
                            About Empower
                            Youth <?php if (Yii::$app->user->identity->organization->slug === $organization['slug']) { ?>
                                <span data-for="description" class="edit-box"><i
                                            class="fa fa-pencil"></i></span><?php } ?>
                        </div>
                        <div class="divider"></div>

                        <div class="col-md-7 col-xs-12">
                            <div class="com-description">
                                <span href="#" class="model" id="description" data-pk="description"
                                      data-name="description" data-type="textarea"
                                      data-value="<?= Html::encode($organization['description']) ?>"></span>

                                <!--                                <ul class="com-des-list">-->
                                <!--                                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>-->
                                <!--                                    <li>Pellentesque augue dignissim venenatis, turpis vestibulum lacinia dignissim-->
                                <!--                                        venenatis.-->
                                <!--                                    </li>-->
                                <!--                                    <li>Mus arcu euismod ad hac dui, vivamus platea netus.Neque per nisl posuere-->
                                <!--                                        sagittis,-->
                                <!--                                        id platea-->
                                <!--                                        dui.-->
                                <!--                                    </li>-->
                                <!--                                    <li>A enim magnis dapibus, nullam odio porta, nisl class.</li>-->
                                <!--                                    <li>Turpis leo pellentesque per nam, nostra fringilla id.</li>-->
                                <!--                                </ul>-->
                            </div>
                        </div>
                        <div class="col-md-5 col-xs-12">
                            <div class="a-boxs">
                                <div class="row margin-0">
                                    <div class="col-md-4 col-sm-4 col-xs-12 about-box">
                                        <span data-for="employees" class="edit-box"><i class="fa fa-pencil"></i></span>
                                        <div class="">
                                            <div class="about-det">
                                                <div class="det">
                                                    <span class="model" id="employees" data-pk="number_of_employees"
                                                          data-name="number_of_employees" data-type="number"
                                                          data-value="<?= Html::encode($organization['number_of_employees']) ?>"></span>
                                                    <!--                                                    --><?//= $organization['number_of_employees']; ?>
                                                </div>
                                                <div class="det-heading">Employees</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    <div class="col-md-4 col-sm-4 col-xs-12 about-box">-->
                                    <!--                                        <div class="">-->
                                    <!--                                            <div class="about-det">-->
                                    <!--                                                <div class="det">50</div>-->
                                    <!--                                                <div class="det-heading">Reviews</div>-->
                                    <!--                                            </div>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <div class="col-md-4 col-sm-4 col-xs-12 about-box">
                                        <div class="">
                                            <div class="about-det">
                                                <div class="det">50</div>
                                                <div class="det-heading">Opportunities</Opper></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    <div class="col-md-4 col-sm-4 col-xs-12 about-box">-->
                                    <!--                                        <div class="">-->
                                    <!--                                            <div class="about-det">-->
                                    <!--                                                <div class="det">20</div>-->
                                    <!--                                                <div class="det-heading">Views</div>-->
                                    <!--                                            </div>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <!--                                    <div class="col-md-4 col-sm-4 col-xs-12 about-box">-->
                                    <!--                                        <div class="">-->
                                    <!--                                            <div class="about-det">-->
                                    <!--                                                <div class="det">4.5</div>-->
                                    <!--                                                <div class="det-heading">Rating</div>-->
                                    <!--                                            </div>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <div class="col-md-4 col-sm-4 col-xs-12 about-box">
                                        <span data-for="establishment_year" class="edit-box"><i
                                                    class="fa fa-pencil"></i></span>
                                        <div class="">
                                            <div class="about-det">
                                                <div class="det">
                                                    <span href="#" id="establishment_year" data-type="combodate" data-format="YYYY" data-pk="establishment_year" data-template="YYYY" data-viewformat="YYYY" data-name="establishment_year"><?= $organization['establishment_year']; ?></span>
                                                    <!--                                                    --><?//= $organization['establishment_year']; ?>
                                                </div>
                                                <div class="det-heading">Established</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mv-box">
                            <div class="heading-style">Mission & Vision</div>
                            <div class="divider"></div>
                            <div class="col-md-12">
                                <div class="mv-heading">
                                    Mission <?php if (Yii::$app->user->identity->organization->slug === $organization['slug']) { ?>
                                        <span data-for="mission" class="edit-box"><i
                                                    class="fa fa-pencil"></i></span><?php } ?></div>
                                <div class="mv-text">
                                    <span href="#" class="model" id="mission" data-pk="mission" data-name="mission"
                                          data-type="textarea"
                                          data-value="<?= Html::encode($organization['mission']) ?>"></span>
                                    <?= Html::encode($organization['mission']) ?>
                                </div>
                                <div class="vission-box">
                                    <div class="mv-heading">
                                        Vision <?php if (Yii::$app->user->identity->organization->slug === $organization['slug']) { ?>
                                            <span data-for="vision" class="edit-box"><i
                                                        class="fa fa-pencil"></i></span><?php } ?></div>
                                    <div class="mv-text">
                                        <span href="#" class="model" id="vision" data-pk="vision" data-name="vision"
                                              data-type="textarea"
                                              data-value="<?= Html::encode($organization['vision']) ?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    Pjax::begin(['id' => 'pjax_benefits']);
                    //                    if ($benefit) {
                    ?>
                    <div class="row">
                        <div class="company-benefits">
                            <div class="heading-style">Employee Benefits
                                <div class="button_location pull-right">
                                    <button type="submit" class="i-review-nx modal-load-class"
                                            value="/account/employee-benefits/create-benefit">
                                            <span class="i-review-button-tx">
                                                Add New <span class="fa fa-long-arrow-right"></span>
                                            </span>
                                    </button>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div class="com-benefits no-padd">
                                <?php
                                foreach ($benefit as $benefits) {
                                    ?>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <div class="benefit-box">
                                            <div id="confirmation_benefit" class="confirm_hiden">
                                                <button id="confirm_remove_benefit" type="button"
                                                        value="<?= $benefits['organization_benefit_enc_id'] ?>"
                                                        class="btn btn-danger btn-sm editable-submit">
                                                    Delete
                                                </button>
                                                <button id="cancel_remove_benefit" type="button"
                                                        class="btn btn-default btn-sm editable-cancel">
                                                    Cancel
                                                </button>
                                            </div>
                                            <a class="remove-benefit-item"><i class="fa fa-times"></i></a>
                                            <div class="bb-icon">
                                                <?php
                                                if (!empty($benefits['icon'])) {
                                                    $benefit_icon = Url::to('/assets/icons/' . $benefits['icon_location'] . DIRECTORY_SEPARATOR . $benefits['icon']);
                                                } else {
                                                    $benefit_icon = Url::to('@commonAssets/employee-benefits/plus-icon.svg');
                                                }
                                                ?>
                                                <img src="<?= Url::to($benefit_icon) ?>">
                                            </div>
                                            <div class="bb-text">
                                                <?= $benefits['benefit'] ?>
                                                <!--                                                    Flexible Hour-->
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                    <?php
                    //                    }
                    Pjax::end()
                    ?>
                    <div class="row">
                        <div class="office-view">
                            <div class="heading-style">Inside Empower Youth</div>
                            <div class="divider"></div>
                            <div class="office-pics">
                                <div class="col-md-3 col-sm-3 col-xs-12 no-padd">
                                    <div class="img1">
                                        <a href="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-1.jpg') ?>"
                                           data-fancybox="image">
                                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-1.jpg') ?>"
                                                 alt="company image 1">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12 no-padd">
                                    <div class="img1">
                                        <a href="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-2.jpg') ?>"
                                           data-fancybox="image">
                                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-2.jpg') ?>"
                                                 alt="company image 2">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12 no-padd">
                                    <div class="img1">
                                        <a href="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-3.jpg') ?>"
                                           data-fancybox="image">
                                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-3.jpg') ?>"
                                                 alt="company image 3">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12 no-padd">
                                    <div class="img1">
                                        <a href="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-4.jpg') ?>"
                                           data-fancybox="image">
                                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-4.jpg') ?>"
                                                 alt="company image 4">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12 no-padd">
                                    <div class="img1">
                                        <a href="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-5.jpg') ?>"
                                           data-fancybox="image">
                                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-5.jpg') ?>"
                                                 alt="company image 5">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12 no-padd">
                                    <div class="img1">
                                        <a href="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-6.jpg') ?>"
                                           data-fancybox="image">
                                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-6.jpg') ?>"
                                                 alt="company image 6">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12 no-padd">
                                    <div class="img1">
                                        <a href="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-7.jpg') ?>"
                                           data-fancybox="image">
                                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-7.jpg') ?>"
                                                 alt="company image 7">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12 no-padd">
                                    <div class="img1">
                                        <a href="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-8.jpg') ?>"
                                           data-fancybox="image">
                                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/office-pic-8.jpg') ?>"
                                                 alt="company image 8">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="company-team">
                            <div class="heading-style">Meet The Team</div>
                            <div class="divider"></div>
                            <div class="team-box">
                                <div class="col-md-3 col-sm-6">
                                    <div class="team-container">
                                        <a href="">
                                            <div class="team-icon">
                                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-03.jpg') ?>">
                                                <div class="team-overlay">
                                                    <div class="team-text">
                                                        <div class="know-bet">Know me better</div>
                                                        <a href=""><i class="fa fa-facebook t-fb"></i> </a>
                                                        <a href=""><i class="fa fa-linkedin t-ln"></i> </a>
                                                        <a href=""><i class="fa fa-twitter t-tw"></i> </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="t-member">
                                                <div class="t-name">Mr. Tarry</div>
                                                <div class="t-post">CTO</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="team-container">
                                        <a href="">
                                            <div class="team-icon">
                                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-02.jpg') ?>">
                                                <div class="team-overlay">
                                                    <div class="team-text">
                                                        <div class="know-bet">Know me better</div>
                                                        <a href=""><i class="fa fa-facebook t-fb"></i> </a>
                                                        <a href=""><i class="fa fa-linkedin t-ln"></i> </a>
                                                        <a href=""><i class="fa fa-twitter t-tw"></i> </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="t-member">
                                                <div class="t-name">Incognito Man</div>
                                                <div class="t-post">Database Manager</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="team-container">
                                        <a href="">
                                            <div class="team-icon">
                                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/solution-tile-stream.png') ?>">
                                                <div class="team-overlay">
                                                    <div class="team-text">
                                                        <div class="know-bet">Know me better</div>
                                                        <a href=""><i class="fa fa-facebook t-fb"></i> </a>
                                                        <a href=""><i class="fa fa-linkedin t-ln"></i> </a>
                                                        <a href=""><i class="fa fa-twitter t-tw"></i> </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="t-member">
                                                <div class="t-name">Tarandeep Singh Rakhra</div>
                                                <div class="t-post">Director, CTO</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="team-container">
                                        <a href="">
                                            <div class="team-icon">
                                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-01.jpg') ?>">
                                                <div class="team-overlay">
                                                    <div class="team-text">
                                                        <div class="know-bet">Know me better</div>
                                                        <a href=""><i class="fa fa-facebook t-fb"></i> </a>
                                                        <a href=""><i class="fa fa-linkedin t-ln"></i> </a>
                                                        <a href=""><i class="fa fa-twitter t-tw"></i> </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="t-member">
                                                <div class="t-name">Tarry Bro</div>
                                                <div class="t-post">Sr. Web Developer</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <div class="row">
                        <div class="heading-style">Available Jobs</div>
                        <div class="divider"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4 col-sm-12 pt-5">
                                    <div class="application-card-main">
                                        <span class="application-card-type"><i class="fa fa-inr"></i></span>
                                        <span class="application-card-type"></span>
                                        <div class="col-md-12 application-card-border-bottom">
                                            <div class="application-card-img">
                                                <a href="">
                                                    <img src="">
                                                    <canvas class="user-icon" name="" width="80" height="80"
                                                            color="" font="35px"></canvas>
                                                </a>
                                            </div>
                                            <div class="application-card-description">
                                                <a href=""><h4 class="application-title"></h4></a>
                                                <h5 class="location" data-lat="" data-long="" data-locations=""><i
                                                            class="fa fa-map-marker"></i>&nbsp;</h5>
                                                <h5><i class="fa fa-clock-o"></i>&nbsp;</h5>
                                            </div>
                                        </div>
                                        <h6 class="col-md-5 pl-20 custom_set2 text-center">
                                            Last Date to Apply
                                            <br>
                                        </h6>
                                        <h4 class="col-md-7 org_name text-right pr-10">
                                        </h4>
                                        <div class="col-md-12">
                                            <h4 class="org_name text-right"></h4>
                                        </div>
                                        <div class="application-card-wrapper">
                                            <a href="" class="application-card-open">View Detail</a>
                                            <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="internships-block">
                            <div class="heading-style">Available Internships</div>
                            <div class="divider"></div>
                            <div class="internship">
                                No Internships available.
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab4" class="tab-pane fade">
                    <div class="row">
                        <div class="address-division">
                            <div class="heading-style">
                                Address
                                <div class="button_location pull-right">
                                    <button type="button" class="i-review-nx modal-load-class"
                                            value="/account/locations/create">
                                            <span class="i-review-button-tx">
                                                Add New <span class="fa fa-long-arrow-right"></span>
                                            </span>
                                    </button>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="head-office">
                                        <!--                                        --><?php
                                        //                                            foreach ($locations as $info) {
                                        //                                                ?>
                                        <!--                                                <div class="office-heading">-->
                                        <!--                                                    <img src="-->
                                        <? //= Url::to('@eyAssets/images/pages/company-and-candidate/head-office.png') ?><!--">-->
                                        <!--                                                    --><? //= $info['location_name']; ?>
                                        <!--                                                </div>-->
                                        <!--                                                <div class="office-loc">-->
                                        <!--                                                    <div class="off-add">-->
                                        <!--                                                        --><? //= $info['address'] ?>
                                        <!--                                                    </div>-->
                                        <!--                                                    <div class="off-city">-->
                                        <? //= $info['city'] . ', ' . $info['state'] . ', ' . $info['country'] . ', ' . $info['postal_code']; ?><!--</div>-->
                                        <!--                                                </div>-->
                                        <!--                                                --><?php
                                        //                                            }
                                        //                                                ?>
                                        <!--                                        <div class="office-heading o-h2">-->
                                        <!--                                            <img src="-->
                                        <? //= Url::to('@eyAssets/images/pages/company-and-candidate/branch-office.png') ?><!--">-->
                                        <!--                                            Branch Office-->
                                        <!--                                        </div>-->
                                        <!--                                        <div class="office-loc">-->
                                        <!--                                            <div class="off-add">BXX-3360, Lower Ground Floor, Capital Small Finance Bank,-->
                                        <!--                                                Near-->
                                        <!--                                                Aarti Chowk, Ferozepur Road-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="off-city">Ludhiana, Punjab</div>-->
                                        <!--                                        </div>-->
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div id="map"></div>
                                </div>
                            </div>
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
                         alt="<?= Yii::t('frontend', 'Loading'); ?>" class="loading">
                    <span> &nbsp;&nbsp;<?= Yii::t('frontend', 'Loading'); ?>... </span>
                </div>
            </div>
        </div>
    </div>
<?php
echo $this->render('/widgets/mustache/organization_locations');
$this->registerCss('
/*----jobs and internships----*/
.internships-block{
    padding-top:30px;
}
/*----jobs and internships ends----*/
/*----review----*/
.viewbtn a{
    border: 1px solid #ebefef;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    -ms-box-shadow: none;
    -o-box-shadow: none;
    box-shadow: none;
    padding: 15px 44px;
    font-size: 15px;
    color: #111111;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px
}
.viewbtn a:hover{
    background-color: #00a0e3;
    color: #fff;
    border-color: transparent;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
}
.re-box{
    margin: 60px 0 0 0;
}
.refirst{
   margin:0 0 0 0 !important; 
}
.viewbtn{
    text-align:center;
    margin:60px 0 0 0 ;
}
.uicon{
    text-align:center;
}
.uicon img{
    max-height:80px;
    max-width:80px;
}
.uname{
    text-align:center;
    text-transform:uppercase;
    font-weight:bold;
    padding-top:10px;
    line-height:15px;
    color:#00a0e3;
}
.user-saying{
    padding-top:20px;
}
.user-rating{
    display:flex;
    justify-content:center; 
    text-align:center;
    padding-top:20px;
}
.uheading{
    font-weight:bold;
    
}
.utext{
    text-align:justify;
}
.publish-date{
    text-align:right;
//    font-style:italic;
    font-size: 14px;
}
.view-detail-btn button{
    background:transparent;
    border:none;
    font-size:14px;
    padding:0px
}
.view-detail-btn button:hover, .re-btns button:hover{
    color:#00a0e3;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
    transition:.3s all;
}
.num-rate{
    
}
.re-btns{
    text-align:right;
    padding-top: 5px;
}
.re-btns button{
    background:none;
    border:none;
    font-size:19px;
    color:#ccc;
}
.re-btns button:hover{
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.re-btns button:hover i.fa-flag{
    color:#d72a2a;
}
.re-btns button i.fa-thumbs-down{
    margin-left:-8px;
}
.utitle{
    font-size:20px;
    font-weight:bold;
    padding-top:8px;
    color:#00a0e3;
}
.user-review-main{
    border-left:2px solid #ccc;
}
.ur-bg{
   background:#edecec;
    color: #000;
    border-radius: 5px;
    padding: 10px 5px;
    border-right: 1px solid #fff;
    height: 95px;
}
.uratingtitle{
    font-size:12px;
    line-height:15px;
}
.urating{
    font-size:25px;
}
.emp-duration{
    text-align:right;
//    line-height:18px;
//    padding-top:20px;
}
.ushare i{
   font-size:20px;
    color:#ccc; 
}
.ushare i.fa-facebook-square:hover{
    color:#4267B2; 
    cursor: pointer;
}
.ushare i.fa-twitter-square:hover{
    color:#38A1F3; 
    cursor: pointer;
}
.ushare i.fa-linkedin-square:hover{
    color:#0077B5;
    cursor: pointer; 
}
.ushare i.fa-google-plus-square:hover{
    color:#CC3333;
    cursor: pointer;
}
.ushare-heading{
    font-size:14px;
    padding-top:20px;
    line-height:23px;
    font-weight:bold;
}
.usefull-bttn{
    padding-top:33px;
    display:flex;
}
.re-bttn{
    text-align:right
}
.use-bttn button, .notuse-bttn button, .re-bttn button{
    background: transparent !important;
    border:1px solid #ccc;
    color:#ccc;
    padding:5px 15px;
    margin-left:10px;
    border-radius:10px;
    font-size:14px;
    transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
}
.re-bttn{
    padding-bottom:5px;
}
.use-bttn button:hover{
    color:#00a0e3;
    border-color:#00a0e3;
    transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
}
.re-bttn button:hover, .notuse-bttn button:hover{
    color:#d72a2a;
    border-color:#d72a2a;
     transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
}
.review-summary{
    text-align:left;
    padding-left:50px
}
.oa-review{
    font-size:30px;
    font-family:lobster;
    padding-bottom:22px;
}
.rs1{
    padding-top:20px;
}
.re-heading{
    font-size: 17px;
    text-transform: capitalize;
    font-weight: bold;
}
.com-rating i{
    font-size:16px;
    background:#ccc;
    color:#fff;
    padding:7px 5px;
    border-radius:5px;
}
.com-rating i.active{
    background:#ff7803;
    color:#fff;
}
/*----review ends----*/
/*----company benefits----*/
.company-benefits{
    padding:30px 0 0 0;
}
.benefit-box{
    text-align:center;
    border:1px solid rgba(221, 216, 216, 0.1);
    padding:25px 10px;
    margin:0 0 15px 0;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.3);
    padding-bottom: 0px;
    min-height: 165px;
    position:relative;
}
.bb-icon img{
    width:75px;
    height:75px;
}
.bb-text{
    padding-top:10px;
    text-transform:uppercase;
    font-size:15px;
    font-weight:bold;
}
/*----company benefits ends----*/
/*----mission & vission----*/
.mv-heading{
    font-size:20px;
    font-weight:bold;
    text-transform:uppercase;
}
.vission-box{
    padding-top:20px;
}
.mv-box{
    padding-top:20px;
}
/*----mission & vission end----*/
/*----team----*/
.company-team{
    padding-top:20px;
}
.team-container{
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    border-radius:10px;
    height:100%;
    position:relative;
    margin: 0 0 20px 0;
}
.t-fb:hover{
    color:#3C5A99
}
.t-ln:hover{
    color:#0077B5;
}
.t-tw:hover{
    color:#1DA1F2;
}
.team-container:hover{
    box-shadow:0 0 15px rgba(0,0,0,0.3);
    -o-transition:.3s all;
    -ms-transition:.3s all;
    -moz-transition:.3s all;
    -webkit-transition:.3s all;
    transition:.3s all;
}
.know-bet{
    font-size:14px;
    text-transform:uppercase;
    color:#00a0e3;
}
.team-container:hover .team-overlay {
  height: 100%;
}
.team-text {
  color: #000;
  font-size: 20px;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  text-align: center;
}
.team-text a{
    padding:0 5px;
}
.team-icon{
    width:100%;
    height:186px;
    overflow:hidden;
    object-fit:cover;
    position:relative;
}
.team-icon img{
    border-radius:10px 10px 0 0; 
    width:100%;
    height:100%;
}
.team-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(255,255,255,.9);
  overflow: hidden;
  width: 100%;
  height: 0;
  border-radius:10px 10px 0 0 ;
  transition: .5s ease;
}
.t-member{
    padding:5px 10px 10px 10px;
    text-align:center;
}
.t-name{
    font-size:16px;
    font-weight:bold;
}
.t-post{
//    padding-top:10px;
}
/*----team ends----*/
/*----office view-----*/
.img1 img{
    width:285px;
    height:200px;
    object-fit:cover;
}
.office-view{
    padding:40px 0 0 0;
}
.no-padd{
    padding-left:0px !important;
    padding-right:0px !important;
}
/*----office view ends----*/
/*----address----*/
.office-heading{
    font-weight:bold;
    font-size:18px;
    text-transform:uppercase;
}
.office-heading img{
    max-width:25px;
    margin-top:-5px;
}
.office-loc{
    padding:10px 20px;
}
.o-h2 img{
    max-width:15px;
    margin:0 5px 0 5px;
    margin-top:-5px;
}
#map{
    height: 300px; 
}
/*----address ends----*/
/*----about us-----*/
.com-description{
    font-size:15px;
    text-align:justify;
    line-height:22px;
}
.com-des-list{
    padding:10px 25px;
}
.com-des-list li{
  list-style-image:url(' . Url::to('@eyAssets/images/pages/company-and-candidate/next.png') . ');  
}
.divider{
    border-top:1px solid #eee;
    padding:0 0 20px 0;
}
/*----about us ends----*/
/*----grid box----*/
.a-boxs{
//        box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.3);
        box-shadow: 2px 5px 24px rgba(221, 216, 216, 0.5);
}
.about-box{
    height:100px;
    border:1px solid rgba(238, 238, 238, .5);;
    text-align:center;
    position:relative;
}
.margin-0{
    margin-left:0px;
    margin-right:0px;
}
.about-det{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%); 
}
.det-heading{
    font-size:13px;
    font-weight:bold;
}
.det{
    font-size:16px;
    color:#00a0e3;
}
/*----grid box ends*/
/*----follow btn----*/
.follow-btn,.social-btns{
    text-align:center
}
.social-btns{
   margin-top:15px;
}
.social-btns a{
    margin:0 5px;
    padding:8px 0;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
}
a.twitter{
    padding:8px 6px 8px 10px;
      color:#1DA1F2;
}
.twitter:hover{
    background:#1da1f2;
    color:#fff;
}
a.facebook{
    padding:8px 9px 8px 12px;
    color:#3C5A99;   
}
.facebook:hover{
    background:#3c5a99;
    color:#fff;
}
a.linkedin{
    padding:8px 9px 8px 11px;
     color:#0077B5;
}
.linkedin:hover{
    background:#0077b5;
    color:#fff;
}
a.web{
    padding:8px 11px 8px 11px;
    color:#ff7803; 
}
.web:hover{
    background:#ff7803;
    color:#fff;
}
.follow{
    padding:10px 60px;
     background: transparent;
//    border: 1px solid #00a0e3;
    border:none;
    font-size: 16px;
    text-transform: capitalize;
    color: #00a0e3;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
}
.follow:hover{
    background:#00a0e3;
    color:#fff;
}
.follow, .follow:hover, a.facebook, .facebook:hover,
a.twitter, .twitter:hover, a.linkedin, .linkedin:hover, a.web, .web:hover{
    transition:.3s all;
}
/*----follow btn ends----*/
/*----tabs----*/
.nav-tabs > li.active a, .nav-tabs > li.active a:hover, .nav-tabs > li.active a:focus{
    color: #fff;
    background-color: #00a0e3 !important;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
     transition:.2s all;
     
}
.nav-tabs > li > a:hover{
   box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
   color:#00a0e3;
}
.nav-tabs>li>a{
    border:none;
}
.nav-tabs>li>a:hover{
    border:none;
}
/*----tabs end----*/
.header-bg{
    background:url(' . Url::to('@eyAssets/images/backgrounds/default_cover.png') . ');
    background-repeat: no-repeat;
    background-size: cover;
}
.h-inner{
    position:relative;
    min-height:300px;
    display: -webkit-box;
}
.logo-absolute{
    position:absolute;
    bottom:-60px;
    display:inherit;
    width:100%;
}
.com-details{width:100%;}
.logo-box{
    height:200px;
    width:200px;
    padding:0px;
    background:#fff;
    display:table; 
    text-align:center;
    border-radius:4px;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.3);
    position:relative;
}
.logo{
    display:table-cell;
    vertical-align: middle;     
}
.logo img{
    border-radius:4px;
}
#upload-logo{
    margin-bottom:0px;
}
.com-name{
    font-size:40px;
    font-family:lobster;
    color:#fff;
    padding: 0 0 0 30px; 
}
.com-establish{
    color:#fff;
    padding: 0 0 0 30px; 
    font-size:15px;
}
.com-establish .detail-title{
    font-weight:bold;
    color:#fafafa;
}
.nav-padd-20{
    padding-left:50px;
}

@media screen and (min-width: 992px) and (max-width:1200px){
       .nav-padd-20{
        padding-left:90px;
    }
}
@media screen and (max-width: 992px){
    .img1 img{
        width:180px;
        height:125px;
        object-fit:cover;
    }
    .nav-padd-20{
        padding-left:120px;
        padding-bottom:20px;
    }
    .follow-btn,.social-btns{
        text-align:right
    }
}
@media screen and (max-width: 768px){
    .img1 img{
        width:100%;
        height:100%;   
    }
    .logo-box{
        margin:0 auto;
    }
    .padd-top-0{
        padding-top: 0px!important;
        margin-top:-20px !important;
    }
    .h-inner{
        display: block;
        min-height:500px;
    }
    .follow-btn, .social-btns{
        text-align:center;
    }
    .logo-absolute{
        position:absolute;
        top:50%;
        left:50%;
        transform:translate(-50%, -50%);
    }
    .nav-padd-20{
        text-align:center;
        padding-left:0px;
    }
    .header-inner{
        height:100%;
        width:100%;
        padding:50px 0;
    }
    
}
.editableform .control-group {
    width: auto;
    height: auto;
    padding: 0;
    margin: 2px;
}
.editable-input .form-control {
    height: auto;
    width: 50vh;
}
.editable-buttons .btn-sm {
    padding: 5px 10px;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 3px;
}
.avatar-edit {
    position: absolute;
    right: 1px;
    z-index: 1;
    top: 1px;
    display: inline-block;
    width: 34px;
    height: 34px;
    text-align: center;
    line-height: 31px;
    margin-bottom: 0;
    border-radius: 100%;
    background: #FFFFFF;
    border: 1px solid transparent;
    box-shadow: 0px 1px 10px 3px rgba(0, 0, 0, 0.13);
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
.hiden button.btn-sm{
    border:1px solid #ddd;
}
.hiden, .hiden2{
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
.hiden:before, .hiden2:before{
    content: \'\';
    left: -15px;
    top: 15px;
    position: absolute;
    border-top: 10px solid transparent;
    border-right: 15px solid #f9f9f9;
    border-bottom: 10px solid transparent;
}
.hiden2{
    top: 12px;
    left: 0px;
}
.hiden2:before{
    right: 36px;
    top: -13px;
}
.full_width{
    width:100%;
    height:100%;
}
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
.edit-box{
    cursor: pointer;
    color:#222;
    font-size: 18px;
    position: absolute;
    margin-left: 15px;
}
.com-establish .edit-box {
    font-size: 16px;
    margin-left: 10px;
    margin-top: -3px;
}
.button_location{
    padding: 14px 0px;
    float:right;
    font-family: "Open Sans", sans-serif;
}
/* Feature, categories css starts */
.checkbox-input {
  display: none;
}
.checkbox-label-v2 {
/*   display: inline-block; */
/*   vertical-align: top; */
/*   position: relative; */
  width: 100%;
  cursor: pointer;
  font-weight: 400;
  margin-bottom:0px;
}
.p-category img, .checkbox-text--title img{
    width: 80px;
    height: 50px;
}
.checkbox-label-v2:before {
  content: \'\';
  position: absolute;
  top: 80px;
  right: 16px;
  width: 40px;
  height: 40px;
  opacity: 0;
  background-color: #00A0E3;
  background-image: url("data:image/svg+xml,%3Csvg width=\'32\' height=\'32\' viewBox=\'0 0 32 32\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z\' fill=\'%23fff\' fill-rule=\'nonzero\'/%3E%3C/svg%3E ");
  background-position: 80% 80%;
  background-repeat: no-repeat;
  background-size: 30px;
  border-radius: 50%;
  -webkit-transform: translate(0%, -50%);
  transform: translate(0%, -50%);
  transition: all 0.4s ease;
}
.checkbox-input:checked + .checkbox-label-v2:before {
  top: 0;
  opacity: 1;
}
.checkbox-input:checked + .checkbox-label-v2 .checkbox-text span {
  -webkit-transform: translate(0, -8px);
  transform: translate(0, -8px);
}
#fixed_stip,#min_max
{
 display:none;
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
    display:flex;
}
.p-category, .p-category *{
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}
.p-category .checkbox-text {
    float: left;
    width: 100%;
    text-align: center;
    padding-bottom: 30px;
    border-bottom: 1px solid #e8ecec;
    border-right: 1px solid #e8ecec;
}
.p-category .checkbox-text span i {
    float: left;
    width: 100%;
    color: #00A0E3;
    font-size: 70px;
    margin-top: 15px;
    line-height: initial !important;
}
.p-category .checkbox-text span {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 15px;
    color: #202020;
    margin-top: 10px;
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
.p-category:hover .checkbox-text {
    border-color: #ffffff;
}
.p-category:hover .checkbox-label-v2 i{
    color: #f07d1d;
}
.row.no-gape .p-category-main {
    padding: 0;
}
.cat-sec .row .p-category-main:last-child .checkbox-text {
    border-right-color: #ffffff;
}
/* Feature, categories css ends */
/* Benefit remove css starts */
.benefit-box:before{
    content: \'\';
    position: absolute;
    top: 0;
    right: 0;
    border-style: solid;
    border-width: 0 0px 0px 0;
    border-color: transparent #ff0000;
    transition: all ease .3s;
}
.benefit-box:hover:before {
    border-width: 0 50px 50px 0;
    border-color: transparent #ff0000;
}
.remove-benefit-item{
    display:none;
    right: 0;
    position: absolute;
    top: 0;
    width: 40px;
    line-height: 28px;
    height: 40px;
    text-align: right;
    padding-right: 8px;
    font-size: 17px;
    opacity:0;
    transition: opacity 500ms;
    cursor:pointer;
}
.remove-benefit-item i{
    color:#fff !important;
}
.benefit-box:hover .remove-benefit-item{
    display:block;
    opacity:1;
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
    top: 0;
    left: 0;
}
.benefit-box .confirm_hiden{
    padding-top: 65px;
    width: 100%;
    background-color: #dedede5c;
    z-index:999;
}
/* Benefit remove css ends */
.about-box .edit-box{
    right:8px;
}
.det .popover .editable-input input{width: 80px !important;}
');
$script = <<<JS



$('.model-link').editable({
    placement: 'bottom',
    url: '/companies/update-profile',
    toggle: 'manual',
    display: function(value) {
        $(this).attr('href',value);
    }
});
$('.model').editable({
    placement: 'top',
    url: '/companies/update-profile',
    toggle: 'manual',
});

$('.model-link').click(function(e){
    e.preventDefault();
    e.stopPropagation();
    $(this).editable('toggle');
});
$('.edit-box').click(function(e){
    e.stopPropagation();
    var edit_main = $(this).attr('data-for');
    $('#' + edit_main).editable('toggle');
});
$('#establishment_year').editable({
    placement: 'top',
    url: '/companies/update-profile',
    toggle: 'manual',
    // display: true,
    // format: 'YYYY',    
    // viewformat: 'YYYY',    
    // template: 'YYYY',    
    combodate: {
        minYear: 1900,
        maxYear: 2019,
        // minuteStep: 1
   }
});
$('#enable').click(function() {
   $('.editable').editable('toggleDisabled');
}); 
var image_path = $('#logo-img').attr('src');
var logo_name_path = "$no_image";
        
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
$("#logoUpload").change(function() {
    readURL(this);
});
$('#logo-img').on('load', function () {
    if($("#logo-img").attr('src') != image_path && $("#logo-img").attr('src') != logo_name_path){
        $('#pop-content').fadeIn(1000);
   }
});
$(document).on('click', '#cancel_image', function() {
    $('#pop-content').fadeOut(1000);
    $('#logo-img').attr('src', image_path);
});
$(document).on('click', '#cancel_remove', function() {
    $('#pop-content1_2').fadeOut(1000);
});
$(document).on('click', '.remove-logo', function(a) {
    a.preventDefault();
    $('#pop-content1_2').fadeIn(1000);
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
                // $.pjax.reload({container: '#pjax_jobs_cards', async: false});
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
                // $.pjax.reload({container: '#pjax_jobs_cards', async: false});
                utilities.initials();
                $('#logo-img').attr('src',logo_name_path);
                hide_remove_logo();
            } else {
                toastr.error(response.message, response.title);
            }
        }
    });
});
$(document).on('click', '.remove-benefit-item', function(e){
    e.preventDefault();
    $(this).prev("#confirmation_benefit").fadeIn(500);
});
$(document).on('click', '#cancel_remove_benefit', function(){
    $(this).parent("#confirmation_benefit").fadeOut(500);
});
$(document).on('click', '#confirm_remove_benefit', function(event) {
    event.preventDefault();
    $(this).parent("#confirmation_benefit").fadeOut(500);
    var type = $(this).val();
    $.ajax({
        url: "/companies/remove-benefit",
        method: "POST",
        data: {type:type},
        beforeSend:function(){
            $('#page-loading').fadeIn(1000);  
        },
        success: function (response) {
        $('#page-loading').fadeOut(1000);
            if (response.status == 200) {
                toastr.success(response.message, response.title);
                $.pjax.reload({container: '#pjax_benefits', async: false});
            } else {
                toastr.error(response.message, response.title);
            }
        }
    });
});
$(document).on('click', '.modal-load-class', function() {
    $('#modal').modal('show').find('.modal-body').load($(this).attr('value'));   
});
 var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });
      }
      initMap();

JS;
Pjax::begin(['id' => 'pjax_locations2']);
$this->registerJs("
getLocations();
");
Pjax::end();
$this->registerJs($script);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/css/jquery.fancybox.min.css');
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@eyAssets/js/jquery.fancybox.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('http://vitalets.github.io/combodate/combodate.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
//$this->registerJsFile('http://vitalets.github.io/combodate/momentjs/moment.min.2.5.0.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
