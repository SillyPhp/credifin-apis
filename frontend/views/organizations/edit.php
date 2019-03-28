<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Json;

$this->params['disablefacebookMessenger'] = true;

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
        $cover_image = "/assets/themes/ey/images/backgrounds/default_cover.png";
    }
} else {
    $cover_image = "/assets/themes/ey/images/backgrounds/default_cover.png";
}
$no_image = "https://ui-avatars.com/api/?name=" . $organization['name'] . '&size=200&rounded=false&background=' . str_replace("#", "", $organization['initials_color']) . '&color=ffffff';
$no_cover = 'url("/assets/themes/ey/images/backgrounds/default_cover.png")';
$industries = Json::encode($industries);
?>
    <section>
        <div id="cover_img" class="header-bg" style='background-image:url("<?= Url::to($cover_image); ?>");'>
            <div class="cover-bg-color"></div>
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
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="h-inner">
                            <div class="logo-absolute">
                                <div class="logo-box">
                                    <div class="logo">
                                        <img id="logo-img" src="<?= Url::to($image); ?>">
                                        <?php
                                        $form = ActiveForm::begin([
                                            'id' => 'upload-logo',
                                            'options' => ['enctype' => 'multipart/form-data'],
                                        ])
                                        ?>
                                        <div id="open-pop" class="avatar-edit">
                                            <i class="fa fa-camera dropdown-toggle full_width"
                                               data-toggle="dropdown"></i>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="#">
                                                        <?=
                                                        $form->field($companyLogoFormModel, 'logo', [
                                                            'template' => '{input}',
                                                            'options' => ['tag' => false]])->fileInput(['class' => '', 'id' => 'logoUpload', 'accept' => '.png, .jpg, .jpeg']);
                                                        ?>
                                                        <label for="logoUpload">
                                                            Change Profile Picture
                                                        </label>
                                                    </a>
                                                </li>
                                                <li><a href="#" class="remove-logo">Remove</a></li>
                                                <li><a href="#">Cancel</a></li>
                                            </ul>
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
                                        ActiveForm::end(); ?>
                                    </div>
                                </div>
                                <div class="com-details">
                                    <div class="com-name"><?= Html::encode($organization['name']) ?></div>
                                    <div class="com-establish"><span class="detail-title">Tagline:</span> <span
                                                class="model" id="tag_line" data-type="text" data-pk="tag_line"
                                                data-name="tag_line"
                                                data-value="<?= Html::encode($organization['tag_line']); ?>"></span>
                                        <span data-for="tag_line" class="edit-box"><i class="fa fa-pencil"></i></span>
                                    </div>
                                    <div class="com-establish"><span class="detail-title">Industry:</span> <span class="model" data-type="select" id="industry_enc_id"></span> <span data-for="industry_enc_id" class="edit-box"><i class="fa fa-pencil"></i></span></div>
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
                        <li><a data-toggle="tab" href="#tab4">Locations</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="follow-btn">
                        <button id="enable" class="follow">View Profile</button>
                    </div>
                    <div class="social-btns">
                        <a href="javascript:;" data-pk="facebook" data-name="facebook" data-type="url"
                           data-value="<?= Html::encode($organization['facebook']) ?>" class="facebook model-link"><i
                                    class="fa fa-facebook"></i> </a>
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
                            About <?= Html::encode($organization['name']) ?>
                            <span data-for="description" class="edit-box"><i
                                        class="fa fa-pencil"></i></span>
                        </div>
                        <div class="divider"></div>

                        <div class="col-md-7 col-xs-12">
                            <div class="com-description">
                                <span href="#" class="model" id="description" data-pk="description"
                                      data-name="description" data-type="textarea"
                                      data-value="<?= Html::encode($organization['description']) ?>"></span>
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
                                                </div>
                                                <div class="det-heading">Employees</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 about-box">
                                        <div class="">
                                            <div class="about-det">
                                                <div class="det"><?= $count_opportunities ?></div>
                                                <div class="det-heading">Opportunities</Opper></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 about-box">
                                        <span data-for="establishment_year" class="edit-box"><i
                                                    class="fa fa-pencil"></i></span>
                                        <div class="">
                                            <div class="about-det">
                                                <div class="det">
                                                    <span href="#" id="establishment_year" data-type="combodate"
                                                          data-format="YYYY" data-pk="establishment_year"
                                                          data-template="YYYY" data-viewformat="YYYY"
                                                          data-name="establishment_year"><?= $organization['establishment_year']; ?></span>
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
                                                <img src="<?= Url::to($benefits['icon']) ?>">
                                            </div>
                                            <div class="bb-text">
                                                <?= $benefits['benefit'] ?>
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
                    Pjax::end()
                    ?>
                    <div class="row">
                        <div class="office-view">
                            <div class="heading-style">
                                Inside <?= Html::encode($organization['name']) ?>
                                <div class="button_location pull-right">
                                    <button type="button" class="i-review-nx modal-load-class"
                                            value="/organizations/add-gallery-images">
                                            <span class="i-review-button-tx">
                                                Add New Images <span class="fa fa-long-arrow-right"></span>
                                            </span>
                                    </button>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <?php
                            Pjax::begin(['id' => 'image_gallery']);
                            ?>
                            <div class="office-pics">
                                <?php
                                foreach ($gallery as $g_image) {
                                    ?>
                                    <div class="col-md-3 col-sm-3 col-xs-12 no-padd">
                                        <div class="img1">
                                            <div id="remove_g_image_confirm" class="confirm_hiden">
                                                Are you Sure want to remove?<br/>
                                                <button id="confirm_g_image" type="button"
                                                        value="<?= $g_image['image_enc_id'] ?>"
                                                        class="btn btn-primary btn-sm editable-submit">
                                                    <i class="glyphicon glyphicon-ok"></i>
                                                </button>
                                                <button id="cancel_g_image" type="button"
                                                        class="btn btn-default btn-sm editable-cancel">
                                                    <i class="glyphicon glyphicon-remove"></i>
                                                </button>
                                            </div>
                                            <a href="#" class="remove_g_image">
                                                <i class="fa fa-times-circle"></i>
                                            </a>
                                            <a href="<?= Url::to(Yii::$app->params->upload_directories->organizations->image . $g_image['image_location'] . DIRECTORY_SEPARATOR . $g_image['image']) ?>"
                                               data-fancybox="image">
                                                <img src="<?= Url::to(Yii::$app->params->upload_directories->organizations->image . $g_image['image_location'] . DIRECTORY_SEPARATOR . $g_image['image']) ?>"
                                                     alt="company image 1">
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                            Pjax::end()
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="company-team">
                            <div class="heading-style">
                                Meet The Team
                                <div class="button_location pull-right">
                                    <button type="button" class="i-review-nx modal-load-class"
                                            value="/organizations/add-employee">
                                        <span class="i-review-button-tx">
                                            Add New Employee <span class="fa fa-long-arrow-right"></span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <?php
                            Pjax::begin(['id' => 'our_team']);
                            ?>
                            <div class="team-box">
                                <?php
                                foreach ($our_team as $team) {
                                    ?>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="team-container">
                                            <div id="remove_t_user_confirm" class="confirm_hiden">
                                                Are you Sure want to remove?<br/>
                                                <button id="confirm_t_user" type="button"
                                                        value="<?= $team['employee_enc_id'] ?>"
                                                        class="btn btn-primary btn-sm editable-submit">
                                                    <i class="glyphicon glyphicon-ok"></i>
                                                </button>
                                                <button id="cancel_t_user" type="button"
                                                        class="btn btn-default btn-sm editable-cancel">
                                                    <i class="glyphicon glyphicon-remove"></i>
                                                </button>
                                            </div>
                                            <a href="#" class="remove_t_user">
                                                <i class="fa fa-times-circle"></i>
                                            </a>
                                            <a href="#">
                                                <div class="team-icon">
                                                    <img src="<?= Url::to('/' . $team['image_location'] . DIRECTORY_SEPARATOR . $team['image']) ?>">
                                                    <?php if (!empty($team['facebook']) || !empty($team['linkedin']) || !empty($team['twitter'])) { ?>
                                                        <div class="team-overlay">
                                                            <div class="team-text">
                                                                <div class="know-bet">Know me better</div>
                                                                <?php if (!empty($team['facebook'])) { ?><a
                                                                    href="<?= $team['facebook']; ?>" target="_blank"><i
                                                                                class="fa fa-facebook t-fb"></i>
                                                                    </a><?php } ?>
                                                                <?php if (!empty($team['linkedin'])) { ?><a
                                                                    href="<?= $team['linkedin']; ?>" target="_blank"><i
                                                                                class="fa fa-linkedin t-ln"></i>
                                                                    </a><?php } ?>
                                                                <?php if (!empty($team['twitter'])) { ?><a
                                                                    href="<?= $team['twitter']; ?>" target="_blank"><i
                                                                                class="fa fa-twitter t-tw"></i>
                                                                    </a><?php } ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="t-member">
                                                    <div class="t-name"><?= $team['first_name'] . $team['last_name']; ?></div>
                                                    <div class="t-post"><?= $team['designation'] ?></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                            Pjax::end()
                            ?>
                        </div>
                    </div>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <div class="row">
                        <div class="heading-style">Available Jobs</div>
                        <div class="divider"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="blogbox"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="internships-block">
                            <div class="heading-style">Available Internships</div>
                            <div class="divider"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="internships_main"></div>
                                </div>
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
    <div class="modal fade" id="coverCropModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                </div>
                <div class="modal-body">
                    <div id="cover_crop"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary custom-buttons2 confirm_cover_croping">Done</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<?php
Pjax::begin(['id' => 'pjax_locations2']);
echo $this->render('/widgets/mustache/organization_locations', [
    'Edit' => true
]);
Pjax::end();
echo $this->render('/widgets/mustache/application-card');
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
    padding:10px 0px;
    width:167px;
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
    background-repeat: no-repeat !important;
    background-size: 100% 100% !important;
    min-height:400px;
}
.h-inner{
    position:relative;
    min-height:400px;
    display: -webkit-box;
}
.logo-absolute{
    position:absolute;
    bottom:-60px;
    display:inherit;
    width:100%;
}
.com-details{width:auto;}
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
    max-height: 200px;
    width: 100%;
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
    display:inline-block;
    position: absolute;
    margin-left: 15px;
}
.com-establish .edit-box {
    font-size: 16px;
    margin-left: 10px;
    margin-top: -3px;
    position:relative;
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
.benefit-box-border-removed:hover:before{
    border-width: 0px !important;
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
    width: 100%;
    height: 100%;
    background-color: #0000009e;
    text-align: center;
    color: #fff;
    font-size: 16px;
    padding-top: 70px;
    top: 0;
    left: 0;
    z-index: 99;
}
.benefit-box .confirm_hiden{
    padding-top: 65px;
    background-color: #dedede5c;
    z-index:999;
}
/* Benefit remove css ends */
.about-box .edit-box{
    right:8px;
}
.det .popover .editable-input input{width: 80px !important;}
.remove_g_image, .remove_t_user{
    position: absolute;
    display:none;
    color: red;
    background-color: #fff;
    width: 20px;
    height: 20px;
    right: 10px;
    top: 6px;
    border-radius: 50%;
    line-height: 20px;
    text-align: center;
    font-size: 26px;
    z-index:9;
}
.img1:hover .remove_g_image, .remove_g_image:hover{
    display:block;
}
.team-container:hover .remove_t_user, .remove_t_user:hover{
    display:block;
} 
.hide-remove-buttons{display:none !important;}
.org-location{position:relative;}
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
.cover-bg-color{
    height: 100%;
    width: 100%;
    position: absolute;
    background-color: #00000057;
}
#change-cover-image{margin:0px;}
');
$script = <<<JS
$('.model-link').editable({
    placement: 'bottom',
    url: '/organizations/update-profile',
    toggle: 'manual',
    display: function(value) {
        $(this).attr('href',value);
    }
});
$('.model').editable({
    placement: 'top',
    url: '/organizations/update-profile',
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
    url: '/organizations/update-profile',
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
   var edit_toggle = $('.edit-box').css('display');
   if(edit_toggle == 'block' || edit_toggle == 'inline-block'){
       $('.edit-box').css('display', 'none');
       $('#upload-logo, .modal-load-class, .remove-benefit-item, .remove_t_user, #change-cover-image').hide();
       $('.benefit-box').addClass('benefit-box-border-removed');
       $('.remove_g_image, .remove_location, .edit_location').addClass('hide-remove-buttons');
       $(this).text('Edit Profile');
   } else{
       $('.edit-box').css('display', 'inline-block');
       $('#upload-logo, .modal-load-class, .remove-benefit-item, .remove_t_user, #change-cover-image').show();
       $('.benefit-box').removeClass('benefit-box-border-removed');
       $('.remove_g_image, .remove_location, .edit_location').removeClass('hide-remove-buttons');
       $(this).text('View Profile');
   }
}); 
var image_path = $('#logo-img').attr('src');
var logo_name_path = "$no_image";
var default_cover_path = '$no_cover';
var cover_path = $('#cover_img').css('background-image');

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
function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#coverCropModal').modal('show');
            var rawCover = e.target.result;
            setTimeout(function() {
                renderCover(rawCover);
            }, 500);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
var el = document.getElementById('demo');
var vanilla = new Croppie(el, {
    viewport: { width: 200, height: 200 },
    boundary: { width: 300, height: 300 },
    enforceBoundary: false,
    showZoomer: true,
    enableZoom: true,
    // enableExif: true,
    mouseWheelZoom: true,
    maxZoomedCropWidth: 10,
    // enableOrientation: true
});
var cr = document.getElementById('cover_crop');
var cover_vanilla = new Croppie(cr, {
    viewport: { width: 750, height: 250 },
    boundary: { width: 850, height: 350 },
    enforceBoundary: false,
    showZoomer: true,
    enableZoom: true,
    mouseWheelZoom: true,
    maxZoomedCropWidth: 10,
});
function renderCrop(img){
    vanilla.bind({
        url: img,
        points: [20,20,20,20]
        // orientation: 4
    });
}
function renderCover(img){
    cover_vanilla.bind({
        url: img,
        points: [20,20,20,20]
        // orientation: 4
    });
}
$("#logoUpload").change(function() {
    readURL(this);
});
$("#coverImageUpload").change(function() {
    readURL2(this);
});
$(document).on('click', '#cancel_remove', function() {
    $('#pop-content1_2').fadeOut(1000);
});
$(document).on('click', '.remove-logo', function(a) {
    a.preventDefault();
    $('#pop-content1_2').fadeIn(1000);
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
function hide_remove_cover(){
    var cover_img_path = $('#cover_img').css('background-image');
    cover_imgss = cover_img_path.replace('url(','').replace(')','').replace(/\"/gi, "");
    // console.log(cover_imgss,default_cover_path);
    if(cover_img_path == default_cover_path){
        $('.remove_cover_image').parent('li').css('display', 'none');
    } else{
        $('.remove_cover_image').parent('li').css('display', 'block');
    }
}
hide_remove_cover();
$(document).on('click', '#confirm_remove_logo', function(event) {
    event.preventDefault();
    $('#pop-content1_2').fadeOut(1000);
    var type = $(this).val();
    $.ajax({
        url: "/organizations/remove-image",
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
        url: "/organizations/remove-benefit",
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
$(document).on('click', '.remove_g_image', function(e) {
    e.preventDefault();
    $(this).prev().fadeIn();
});
$(document).on('click', '#cancel_g_image', function() {
    $(this).parent().fadeOut();
});
$(document).on('click', '#confirm_g_image', function(event) {
    event.preventDefault();
    $('#remove_g_image_confirm').fadeOut(1000);
    var id = $(this).val();
    $.ajax({
        url: "/organizations/delete-images",
        method: "POST",
        data: {id:id},
        beforeSend:function(){     
            $('#page-loading').fadeIn(1000);  
        },
        success: function (response) {
        $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
                $.pjax.reload({container: '#image_gallery', async: false});
            } else {
                toastr.error(response.message, response.title);
            }
            
        }
    });
});
$(document).on('click', '.remove_t_user', function(e){
    e.preventDefault();
    $(this).prev("#remove_t_user_confirm").fadeIn(500);
});
$(document).on('click', '#cancel_t_user', function() {
    $(this).parent().fadeOut();
});
$(document).on('click', '#confirm_t_user', function(event) {
    event.preventDefault();
    $('#remove_t_user_confirm').fadeOut(1000);
    var id = $(this).val();
    $.ajax({
        url: "/organizations/delete-employee",
        method: "POST",
        data: {id:id},
        beforeSend:function(){     
            $('#page-loading').fadeIn(1000);  
        },
        success: function (response) {
        $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
                $.pjax.reload({container: '#our_team', async: false});
            } else {
                toastr.error(response.message, response.title);
            }
            
        }
    });
});
$(document).on('click', '.remove_cover_image', function(a) {
    a.preventDefault();
    $('#pop-content2_2').fadeIn(1000);
});
$(document).on('click', '#cancel_cover_remove', function() {
    $('#pop-content2_2').fadeOut(1000);
});
$(document).on('click', '.remove_cover_image', function(a) {
    a.preventDefault();
    $('#pop-content2_2').fadeIn(1000);
});
$(document).on('click', '#confirm_remove_cover', function(event) {
    event.preventDefault();
    $('#pop-content2_2').fadeOut(1000);
    var type = $(this).val();
    $.ajax({
        url: "/organizations/remove-image",
        method: "POST",
        data: {type:type},
        beforeSend:function(){
            $('#page-loading').fadeIn(1000);  
        },
        success: function (response) {
        $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                $('#cover_img').css('background-image',default_cover_path);
                toastr.success(response.message, response.title);
                hide_remove_cover();
            } else {
                toastr.error(response.message, response.title);
            }
        }
    });
});
$(document).on('click', '.modal-load-class', function() {
    $('#modal').modal('show').find('.modal-body').load($(this).attr('value'));   
});


document.querySelector('.vanilla-result').addEventListener('click', function (ev) {
    vanilla.result({
        type: 'base64',
        // format:'jpeg',
    }).then(function (data) {
        $.ajax({
            url: "/organizations/update-logo",
            method: "POST",
            data: {data:data},
            beforeSend:function(){
                $('#page-loading').fadeIn(1000);
            },
            success: function (response) {
                $('#page-loading').fadeOut(1000);
                $('#cropImagePop').modal('hide');
                if (response.title == 'Success') {
                    toastr.success(response.message, response.title);
                    $('#logo-img').attr('src', data);
                    // $.pjax.reload({container: '#pjax_jobs_cards', async: false});
                    hide_remove_logo();
                } else {
                    toastr.error(response.message, response.title);
                }
            }
        });
    });
});

document.querySelector('.confirm_cover_croping').addEventListener('click', function (ev) {
    cover_vanilla.result({
        type: 'base64',
        size: {
            width: 1300,
            height: 433
        }
        // format:'jpeg',
    }).then(function (data) {
        $.ajax({
            url: "/organizations/update-cover-image",
            method: "POST",
            data: {data:data},
            beforeSend:function(){
                $('#page-loading').fadeIn(1000);
            },
            success: function (response) {
                $('#page-loading').fadeOut(1000);
                $('#coverCropModal').modal('hide');
                if (response.title == 'Success') {
                    toastr.success(response.message, response.title);
                    $('#cover_img').css('background', 'url(' + data + ')');
                    hide_remove_logo();
                } else {
                    toastr.error(response.message, response.title);
                }
            }
        });
    });
});

JS;
$this->registerJs("
$('#industry_enc_id').editable({
    placement: 'bottom',
    url: '/organizations/update-profile',
    pk: 'industry_enc_id',
    toggle: 'manual',
    value: '" . $organization['industry_enc_id'] . "',
    source: " . $industries . "
});
getCards('Jobs','.blogbox','/organizations/organization-opportunities/?org=" . $organization['name'] . "');
getCards('Internships','.internships_main','/organizations/organization-opportunities/?org=" . $organization['name'] . "');
");
$this->registerJs($script);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/css/jquery.fancybox.min.css');
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
//$this->registerCssFile('http://foliotek.github.io/Croppie/bower_components/sweetalert/dist/sweetalert.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.css');
$this->registerJsFile('@eyAssets/js/jquery.fancybox.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('http://foliotek.github.io/Croppie/bower_components/sweetalert/dist/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('https://foliotek.github.io/Croppie/bower_components/exif-js/exif.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('http://vitalets.github.io/combodate/combodate.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
//$this->registerJsFile('http://vitalets.github.io/combodate/momentjs/moment.min.2.5.0.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
