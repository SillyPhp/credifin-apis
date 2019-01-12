<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\slider\Slider;
use yii\widgets\Pjax;

$this->params['header_dark'] = false;

function random_color_part()
{
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}

function random_color()
{
    return random_color_part() . random_color_part() . random_color_part();
}

if ($user['image']) {
    $image_path = Yii::$app->params->upload_directories->users->image_path . $user['image_location'] . DIRECTORY_SEPARATOR . $user['image'];
    $image = Yii::$app->params->upload_directories->users->image . $user['image_location'] . DIRECTORY_SEPARATOR . $user['image'];
    if (!file_exists($image_path)) {
        $image = "https://ui-avatars.com/api/?name=" . $user['first_name'] . "+" . $user['last_name'] . '&size=200&rounded=true&background=' . str_replace("#","",Yii::$app->user->identity->initials_color) .'&color=ffffff';
    }
} else {
    $image = "https://ui-avatars.com/api/?name=" . $user['first_name'] . "+" . $user['last_name'] . '&size=200&rounded=true&background=' . str_replace("#","",Yii::$app->user->identity->initials_color) . '&color=ffffff';
}

$cover_image_path = Yii::$app->params->upload_directories->users->cover_image_path . $user['cover_image_location'] . DIRECTORY_SEPARATOR . $user['cover_image'];
$cover_image = Yii::$app->params->upload_directories->users->cover_image . $user['cover_image_location'] . DIRECTORY_SEPARATOR . $user['cover_image'];
if (!file_exists($cover_image_path)) {
    $cover_image = "http://www.placehold.it/1500x500/EFEFEF/AAAAAA&amp;text=No+Cover+Image";
}
$no_image = "https://ui-avatars.com/api/?name=" . $user['first_name'] . "+" . $user['last_name'] . '&size=200&rounded=true&background=' . str_replace("#","",Yii::$app->user->identity->initials_color) . '&color=ffffff';
?>

    <!--    <nav class="min-nav" id="min-nav">-->
    <!--        <ul class="nav nav-stacked navbar-fixed-top">-->
    <!--            <li><a href="#home" data-toggle="tooltip" data-placement="right" title="About Me" class="active"><i class="fa fa-home"></i></a></li>-->
    <!--            <li><a href="#exp" data-toggle="tooltip" data-placement="right" title="Experience"><i class="fa fa-briefcase"></i></a></li>-->
    <!--            <li><a href="#edu" data-toggle="tooltip" data-placement="right" title="Education"><i class="fa fa-graduation-cap"></i></a></li>-->
    <!--            <li><a href="#skills" data-toggle="tooltip" data-placement="right" title="Skills"><i class="fa fa-cogs" ></i></a></li>-->
    <!--           <li><a href="#portfolio" data-toggle="tooltip" data-placement="right" title="Portfolio"><i class="fa fa-folder-open"></i></a></li>-->
    <!--        </ul>-->
    <!--    </nav>-->
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="loader-aj-main">
        <div class="loader-aj">
            <div class="dot first"></div>
            <div class="dot second"></div>
        </div>
    </div>
    <div class="sections">
        <section id="home">
            <div style="background-image: url('<?= Url::to($cover_image); ?>');" class="jumbo">
                <?php
                $formm = ActiveForm::begin([
                    'id' => 'upload-user-cover-image',
                    'options' => ['enctype' => 'multipart/form-data'],
                ])
                ?>
                <div class="cover-edit">
                    <a class="fa fa-pencil dropdown-toggle edits" data-toggle="dropdown"> Edit</a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#">
                                <?=
                                $formm->field($individualCoverImageFormModel, 'cover_image', [
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
            <div class="large-container">
                <div class="bdy-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="can-user-icon">
                                <img id="profile-img" src="<?= Url::to($image); ?>" alt=""
                                     class="img-circle img-thumbnail "/>
                                <?php
                                $form = ActiveForm::begin([
                                    'id' => 'upload-user-image',
                                    'options' => ['enctype' => 'multipart/form-data'],
                                ])
                                ?>
                                <div id="open-pop" class="avatar-edit">
                                    <i class="fa fa-pencil dropdown-toggle full_width" data-toggle="dropdown"></i>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#">
                                                <?=
                                                $form->field($individualImageFormModel, 'image', [
                                                    'template' => '{input}',
                                                    'options' => ['tag' => false]])->fileInput(['class' => '', 'id' => 'imageUpload', 'accept' => '.png, .jpg, .jpeg']);
                                                ?>
                                                <!--<input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />-->
                                                <label for="imageUpload">Change Profile Picture</label>
                                            </a>
                                        </li>
                                        <li><a href="#" class="remove-image">Remove</a></li>
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
                                    <h5>Are you sure want to remove Profile Image?</h5>
                                    <button id="confirm_remove_image" type="button" value="image"
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
                        </div>
                        <div class="row">
                            <div class="bdy-content">
                                <div class="col-md-12 can-name-heading">
                                    <?= $user['first_name']; ?> <?= $user['last_name']; ?>
                                    <!--                            <span href="#" class="model" data-pk="first_name" data-name="first_name" data-type="text" data-value=""></span>
                                                                <span id="controller" class="pen"><i class="fa fa-pencil"></i></span>
                                                                <span href="#" class="model ml-15" data-pk="last_name" data-name="last_name" data-type="text" data-value=""> </span>
                                                                <span id="controller" class="pen"><i class="fa fa-pencil"></i></span>-->
                                </div>

                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="personal-info col-md-12">
                                <div class="personal-detail col-md-6">
                                    <div class="heading-style ">About Me</div>
                                    <div class="per-discription">
                                        <span href="#" class="model" data-pk="description" data-name="description"
                                              data-type="textarea" data-value="<?= $user['description']; ?>"
                                              data-url="/users/update-profile"></span>
                                        <span id="controller" class="pen"><i class="fa fa-pencil"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6 per">
                                    <div class="per-det col-md-12 row">
                                        <div class="heading-style col-md-12">Personal Details</div>
                                        <div class="per-ped">
                                            <div class="can-name">Nationality:</div>
                                            <div class="can-name-fill">
                                                <span href="#" class="model" data-type="text"
                                                      data-value="Indian"></span>
                                                <span id="controller" class="pen"><i class="fa fa-pencil"></i></span>
                                            </div>
                                        </div>
                                        <!--                                <div class="per-ped">
                                                                            <div class="can-name">Skype:</div>
                                                                            <div class="can-name-fill">
                                                                                <span href="#" class="model2" data-type="text" data-value="YourSkype"></span>
                                                                                <span id="controller" class="pen"><i class="fa fa-pencil"></i></span>
                                                                            </div>
                                                                        </div>-->

                                        <div class="per-ped">
                                            <div class="can-name">Marital:</div>
                                            <div class="can-name-fill">
                                                <span href="#" class="marital-status" data-type="select"></span>
                                                <span id="controller" class="pen"><i class="fa fa-pencil"></i></span>
                                            </div>
                                        </div>
                                        <!--                                    <div class="per-ped">
                                                                            <div class="can-name">Phone:</div>
                                                                            <div class="can-name-fill">
                                    <?= $user['phone']; ?>
                                                                                <span href="#" id="phone" class="model2" data-pk="phone" data-name="phone" data-type="text" data-value="" data-url="/users/update-profile"></span>
                                                                                <span id="controller" class="pen"><i class="fa fa-pencil"></i></span>
                                                                            </div>
                                                                        </div>-->

                                        <!--                                    <div class="per-ped">
                                                                                <div class="can-name">DOB:</div>
                                                                                <div class="can-name-fill">
                                                                                    <span href="#" class="model2" data-type="combodate" data-format="YYYY-MM-DD" data-value="1993-09-28" data-viewformat="DD/MM/YYYY" data-template="D / MMM / YYYY" data-title="Select Date of birth"></span>
                                                                                    <span id="controller" class="pen"><i class="fa fa-pencil"></i></span>
                                                                                </div>
                                                                            </div>-->
                                        <!--                                    <div class="per-ped">
                                                                            <div class="can-name">Email:</div>
                                                                            <div class="can-name-fill">
                                    <?= $user['email']; ?>
                                                                            </div>
                                                                        </div>-->
                                        <div class="col-md-12 col-sm-12">
                                            <div class="wrap">
                                                <div class="social">

                                                    <a class="model-link" data-pk="facebook" data-name="facebook"
                                                       data-type="text" data-value="<?= $user['facebook']; ?>"
                                                       href="<?= $user['facebook']; ?>"><i
                                                                class="fa fa-facebook fb"></i></a>
                                                    <span id="controller" class="pen"><i
                                                                class="fa fa-pencil"></i></span>
                                                    <a class="model-link" data-pk="twitter" data-name="twitter"
                                                       data-type="text" data-value="<?= $user['twitter']; ?>"
                                                       href="<?= $user['twitter']; ?>"><i class="fa fa-twitter tw"></i></a>
                                                    <span id="controller" class="pen"><i
                                                                class="fa fa-pencil"></i></span>
                                                    <a class="model-link" data-pk="youtube" data-name="youtube"
                                                       data-type="text" data-value="<?= $user['youtube']; ?>"
                                                       href="<?= $user['youtube']; ?>"><i class="fa fa-youtube yt"></i></a>
                                                    <span id="controller" class="pen"><i
                                                                class="fa fa-pencil"></i></span>
                                                    <a class="model-link" data-pk="linkedin" data-name="linkedin"
                                                       data-type="text" data-value="<?= $user['linkedin']; ?>"
                                                       href="<?= $user['linkedin']; ?>"><i
                                                                class="fa fa-linkedin lk"></i></a>
                                                    <span id="controller" class="pen"><i
                                                                class="fa fa-pencil"></i></span>
                                                    <a class="model-link" data-pk="skype" data-name="skype"
                                                       data-type="text" data-value="<?= $user['skype']; ?>"
                                                       href="<?= $user['skype']; ?>"><i class="fa fa-skype sk"></i></a>
                                                    <span id="controller" class="pen"><i
                                                                class="fa fa-pencil"></i></span>
                                                    <a class="model-link" data-pk="instagram" data-name="instagram"
                                                       data-type="text" data-value="<?= $user['instagram']; ?>"
                                                       href="<?= $user['instagram']; ?>"><i
                                                                class="fa fa-instagram db"></i></a>
                                                    <span id="controller" class="pen"><i
                                                                class="fa fa-pencil"></i></span>
                                                    <a class="model-link" data-pk="google" data-name="google"
                                                       data-type="text" data-value="<?= $user['google']; ?>"
                                                       href="<?= $user['google']; ?>"><i class="fa fa-google apple"></i></a>
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
        </section>
        <!--<div class="clearfix"></div>-->
        <!-- experience -->
        <section id="exp">
            <div class="large-container">
                <div class="row">
                    <div class="exp col-md-12">
                        <?php
                        Pjax::begin(['id' => 'pjax_experience']);
                        ?>
                        <div class="bdy-content">
                            <div class="col-md-10">
                                <div class="heading-style">Work Experience</div>
                            </div>
                            <div class="col-md-2">
                                <?=
                                Html::button('<i class="fa fa-plus"></i> Add Work Experience', [
                                    'class' => 'btn btn-primary btn-circle btn-md pull-right mt-20',
//                                'url' => Url::to('/' . Yii::$app->controller->id . '/' . 'add-experience'),
                                    'id' => 'open-modal',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#myModal2',
                                ]);
                                ?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="exp-box1 ">
                                <div class="minus-padding col-md-1">
                                    <div class="com-mark"> <!---com-line class for line  -->
                                        <i class="fa fa-bullseye"></i>
                                    </div>
                                    <div class="com-mark-img">
                                    </div>
                                </div>
                                <div class="exp-time col-md-3">
                                    <div class="com-name"><?= $experience['company']; ?></div>
                                    <div class="com-loc"><?= $experience['city']; ?></div>
                                    <div class="com-time">
                                        <div class="col-md-6">
                                            <div class="com-t">From</div>
                                            <div class="com-due"><?= date('F-Y', strtotime($experience['from_date'])); ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="com-t">To</div>
                                            <div class="com-due"><?= date('F-Y', strtotime($experience['to_date'])); ?></div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <?php $interval = date_diff(date_create($experience['from_date']), date_create($experience['to_date'])); ?>
                                    <div class="time-du"><?= $interval->format('%y years %m months'); ?></div>
                                </div>
                                <div class="exp-post col-md-8">
                                    <div class="post"><?= $experience['title']; ?></div>
                                    <div class="role">Tasks Performed</div>
                                    <div class="duty"><?= $experience['description']; ?></div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </section>

        <div class="clearfix"></div>
        <!-- education -->
        <section id="edu">
            <div class="large-container">
                <div class="edu">
                    <div class="bdy-content">
                        <?php
                        Pjax::begin(['id' => 'pjax_qualification']);
                        ?>
                        <div class="col-md-10">
                            <div class="heading-style ">Qualification</div>
                        </div>
                        <div class="col-md-2">
                            <?=
                            Html::button('<i class="fa fa-plus"></i> Add Qualification', [
                                'class' => 'btn btn-primary btn-circle btn-md pull-right mt-20',
                                'id' => 'qualification-modal',
                                'data-toggle' => 'modal',
                                'data-target' => '#open-qualification-modal',
                            ]);
                            ?>
                        </div>
                        <?php foreach ($education as $e) { ?>
                            <div class="col-md-offset-1 col-md-5">
                                <div class="edubox1">
                                    <div class="edu-icon"><i class="fa fa-graduation-cap"></i></div>
                                    <div class="h-school-name"><?= $e['degree']; ?></div>
                                    <div class="bord-name"><?= $e['institute']; ?></div>
                                    <div class="h-year">
                                        <?php
                                        $from = strtotime($e['from_date']);
                                        $to = strtotime($e['to_date']);
                                        ?>
                                        <?= date('Y', $from) ?> to <?= date('Y', $to) ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>

        </section>
        <div class="clearfix"></div>

        <!--Skills-->
        <section id="skills">
            <div class="large-container">
                <div class="row">
                    <div class="skills col-md-12">
                        <div class="bdy-content">
                            <?php
                            Pjax::begin(['id' => 'pjax_skills']);
                            ?>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="heading-style">Skills & Language</div>
                                </div>
                                <div class="col-md-2">
                                    <?=
                                    Html::button('<i class="fa fa-plus"></i> Add Skills', [
                                        'class' => 'btn btn-primary btn-circle btn-md pull-right mt-20',
                                        'id' => 'skill-modal',
                                        'data-toggle' => 'modal',
                                        'data-target' => '#open-skill-modal',
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="skill-tags">
                                        <ul>
                                            <?php foreach ($skills as $sk) { ?>
                                                <li><?= $sk['skills']; ?></li>
                                            <?php } ?>
                                            <!--                                            <li>CSS</li>-->
                                            <!--                                            <li>Javascript</li>-->
                                            <!--                                            <li>Photoshop</li>-->
                                            <!--                                            <li>CoralDraw</li>-->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php Pjax::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="clearfix"></div>

    </div>
    <div class="modal fade" id="myModal2" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= Yii::t('frontend', 'Add Work Experience'); ?></h4>
                </div>
                <?php
                $fform = ActiveForm::begin([
                    'id' => 'add-experience-form',
                    'action' => '/users/add-experience',
                    'fieldConfig' => [
                        'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
                    ],
                ]);
                ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $fform->field($AddExperienceForm, 'title')->textInput(['autocomplete' => 'off'])->label(true); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $fform->field($AddExperienceForm, 'company')->textInput(['autocomplete' => 'off'])->label(true); ?>
                        </div>

                        <div class="col-md-6">
                            <?= $fform->field($AddExperienceForm, 'location')->textInput(['id' => 'cities', 'placeholder' => 'Location', 'autocomplete' => 'off'])->label(false); ?>
                            <?= $fform->field($AddExperienceForm, 'city_id', ['template' => '{input}'])->hiddenInput(['id' => 'city_id'])->label(false); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=
                            $fform->field($AddExperienceForm, 'exp_from')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Work Experience From'],
                                'readonly' => true,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd',
                                    'name' => 'exp_from',
                                    'todayHighlight' => true,
                                ]])->label(false);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <div class="check_exp">
                                <?=
                                $fform->field($AddExperienceForm, 'exp_to')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Work Experience To'],
                                    'readonly' => true,
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd',
                                        'name' => 'earliestjoiningdate',
                                        'todayHighlight' => true,
                                    ]])->label(false);
                                ?>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="md-checkbox-inline">
                                <?=
                                $fform->field($AddExperienceForm, 'present')->checkBoxList([
                                    1 => 'I currently work here',
                                ], [
                                    'item' => function ($index, $label, $name, $checked) {
                                        $return = '<div class="md-checkbox check_this">';
                                        $return .= '<input type="checkbox" id="exp_present" value="0" name="' . $name . '"  class="md-check" ' . $checked . ' >';
                                        $return .= '<label for="exp_present">';
                                        $return .= '<span></span>';
                                        $return .= '<span class="check"></span>';
                                        $return .= '<span class="box"></span> ' . $label . ' </label>';
                                        $return .= '</div>';
                                        return $return;
                                    }
                                ])->label(false);
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?=
                            $fform->field($AddExperienceForm, 'description')->textarea(['rows' => 6,])->label('Description');
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-circle']); ?>
                    <?= Html::button('Close', ['class' => 'btn default btn-circle', 'data-dismiss' => 'modal']); ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="open-qualification-modal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= Yii::t('frontend', 'Add Qualification'); ?></h4>
                </div>
                <?php
                $fforms = ActiveForm::begin([
                    'id' => 'add-education-form',
                    'action' => '/users/add-qualification',
                    'fieldConfig' => [
                        'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
                    ],
                ]);
                ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $fforms->field($addQualificationForm, 'school')->textInput(['autocomplete' => 'off'])->label(true); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $fforms->field($addQualificationForm, 'degree')->textInput(['autocomplete' => 'off'])->label(true); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $fforms->field($addQualificationForm, 'field')->textInput(['autocomplete' => 'off'])->label(true); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=
                            $fforms->field($addQualificationForm, 'qualification_from')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'From Year'],
                                'readonly' => true,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd',
                                    'name' => 'qualification_from',
                                    'todayHighlight' => true,
                                ]])->label(false);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <div class="check_exp">
                                <?=
                                $fforms->field($addQualificationForm, 'qualification_to')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'To Year'],
                                    'readonly' => true,
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd',
                                        'name' => 'qualification_to',
                                        'todayHighlight' => true,
                                    ]])->label(false);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-circle']); ?>
                    <?= Html::button('Close', ['class' => 'btn default btn-circle', 'data-dismiss' => 'modal']); ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="open-skill-modal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= Yii::t('frontend', 'Add Skills'); ?></h4>
                </div>
                <?php
                $forms = ActiveForm::begin([
                    'id' => 'add-skill-form',
                    'action' => '/users/add-skill',
                    'fieldConfig' => [
                        'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
                    ],
                ]);
                ?>
                <div class="modal-body">
                    <div class="col-md-10 col-md-offset-1">
                        <?= $forms->field($addSkillForm, 'name')->textInput(['id' => 'skills-input', 'autocomplete' => 'off', 'placeholder' => 'Enter name of skills'])->label(false); ?>
                        <?= $forms->field($addSkillForm, 'skills_id')->hiddenInput(['id' => 'skills-main'])->label(false); ?>
                    </div>
<!--                    <div class="skill-tags">-->
<!--                        <div class="additionalskills">Additional Skills</div>-->
<!--                        <ul>-->
<!--                            <li>HTML</li>-->
<!--                            <li>CSS</li>-->
<!--                            <li>Javascript</li>-->
<!--                            <li>Photoshop</li>-->
<!--                            <li>CoralDraw</li>-->
<!--                        </ul>-->
<!--                    </div>-->
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-circle']); ?>
                    <?= Html::button('Close', ['class' => 'btn default btn-circle', 'data-dismiss' => 'modal']); ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.large-container{
   max-width: 1400px !important;
   padding-left: 15px;
   padding-right: 15px;
   margin:auto;
}
.bdy-content{margin:0 100px;  }
.jumbo{background: no-repeat fixed;width: 100%; height: 100%; min-height: 350px;
       border-bottom:3px solid #eee;position: relative;background-size: 100% 100%;}
.nav{background: #00a0e3; max-width: 60px; top:15%; left:0%; box-shadow: 0px 0px 35px rgb(0,0,0,.3);}
.min-nav li a{background: #00a0e3; color: #fff; text-align: center; font-size: 25px; padding: 10px 0 ;  }
.min-nav > .nav >li a.active {color:#00a0e3 !important; background: #fff !important;}
.min-nav li a:hover {color:#00a0e3; background: #fff; transition:.3s ease-in-out; }
.tooltip{background: transparent;}
.tooltip-inner{background: #00a0e3; font-size: 16px; padding: 10px 10px; min-width: 100px; } 
.tooltip.right .tooltip-arrow {
  top: 50%;
  left: 0;
  margin-top: -6px;
  border-width: 6px 6px 6px 0;
  border-right-color: #00a0e3;
}
.can-name-heading{margin: 0 auto; text-align: center;font-size: 28pt; color: #00a0e3; font-family: lobster;}
.can-name-heading .pen{
    color: #222;
    font-size: 15px;
    margin-left: 2px;
    margin-top: 12px;
    position: absolute;
    cursor: pointer;
}
.pen{
    cursor: pointer;
    color:#222;
}
.social .pen{
    font-size:14px;
    height:19px;
    float:left;
    margin-left: -16px;
    width: 20px;
}
.social .pen .fa:hover {
    top: 12px;
}
.can-user-icon{position:relative;max-height: 200px; max-width: 200px; margin: 0 auto; z-index: 999;margin-top: -105px;}
.can-user-icon img{height: 200px;width: 200px;box-shadow: 0px 0px 25px rgb(0,0,0,.3); }
.set-four-tabs{
    margin-top: -100px;

}
.about{padding-bottom: 20px; }
.text-right{ text-align: right; }
.head-btns {margin-top:30px; padding:0 0 20px 0; text-align: center;  }
.head-btn1,.head-btn2{ max-width: 200px;} 
.head-btn1 a{  padding: 10px 0px; font-size: 14px; display: flex; justify-content: center;
             border-left: 2px solid #00a0e3; border-right: 2px solid #00a0e3; border-radius: 30px 0px 30px 0px;
             filter:gray; -webkit-filter: grayscale(1);  filter: grayscale(1);  }
.head-btn1 i, .head-btn2 i{font-size: 20px; padding: 0 5px 0 0; text-align: center; justify-content: center;  line-height: 18px !important; }
.head-btn1 a:hover,.head-btn2 a:hover {text-decoration: none; background: #00a0e3; color: #fff; transition: .3s ease-in-out;    
                                            filter:none; -webkit-filter: grayscale(0);}
.head-btn2 a{  padding: 10px 0px; font-size: 14px; display: flex; justify-content: center; 
                border-left: 2px solid #00a0e3; border-right: 2px solid #00a0e3; border-radius: 30px 0px 30px 0px;
                  filter:gray; -webkit-filter: grayscale(1);  filter: grayscale(1); }
.btn-txt{margin-top:0px;}
.btn-txt2{margin-top:0px;}
.personal-info{padding-top: 30px;}
.pi-heading{ font-size: 25px; }
.per-discription{ font-size: 15px; line-height: 20px; text-align: justify;}
.per-det{margin-top: 0px;
      border-left: 1px solid rgb(238, 238, 238, .4);}
.per-heading{font-size: 20px; font-family:  Open Sans; font-weight: Bold; padding-bottom: 20px;}
.can-name{padding: 0px 0 0 0; font-weight: bold;width:30%;float:left;}
.can-name-fill{padding: 0px 0 0 15px;width:70%;float:left;}
.per-ped{padding-top: 5px;width:50%;float:left;}
.social a{width:auto;float:left;}


/*Experience Section*/
.com-mark{ background: #00a0e3;  font-size: 25px; text-align: center; color:#fff; margin-top:55px; border-top-left-radius: 50px; 
           border-bottom-left-radius: 50px; padding: 20px 0 20px 15px;}
.com-line:before{ content: "";
   position: absolute;
   width: 0;
   height: 150%;
   margin: 55px 0 0 10px;
   border-style: solid;
   border-width: 50px 0px 5px 3px;
   border-color: #00a0e3; }
.com-mark:last-child{
    background-color:red !important;
}
.com-mark-img{ margin: -2px 0 0 20px; background: none;}
.minus-padding{padding-right :0px !important;}
.exp{ background: #ecf1f7; padding: 20px 0 50px 0; box-shadow: 0 0 25px rgb(0,0,0,.3)}
.exp-box1{padding: 5px; margin-top: 30px;}
.exp-time{ height:240px;padding: 30px; text-align: center; background: #00a0e3; color:#fff;
         box-shadow: inset 0px 0px 15px rgb(0, 0, 0, .1)}
.com-name{font-size: 20px; font-weight: bold; font-family: open sans;}
.com-loc{font-size: 15px; font-weight: bold; font-family: open sans; font-style: oblique;}
.com-time{padding:20px 0; font-size:15px; font-family: open sans;   }
.com-due{font-weight: bold; font-size: 16px;}
.com-t{font-size:13px;}
.time-du{text-transform: uppercase; font-size: 12px; padding-top: 5px; font-style: oblique; font-weight: bold; 
        font-family: open sans;}
.exp-post{padding: 20px; background: #fff; height: 240px; }
.post{font-size: 20px; font-family: open sans; text-transform: uppercase; font-weight: bold;}
.role{text-transform: uppercase; font-family: open sans; font-weight: bold; padding:10px; }
.duty{font-size:14px;}

/*education section*/
.edu{padding: 30px 0 50px 0;}
.edubox1{ text-align: center; padding: 20px 0; box-shadow: 0 0 10px rgb(0,0,0,.5); border-radius: 0px 10% ;
         background: #eee; margin-bottom: 20px; border:1px solid #fff;} 
.h-school-name{font-size: 16px; font-family: open sans; padding-top: 10px; font-weight: bold; }
.bord-name{font-size: 16px; font-family: open sans;  font-weight: bold;}
.h-year{font-size: 16px; font-family: open sans; font-weight: bold;}
.edu-icon{font-size: 65px; color: #00a0e3; }
.edu-icon{margin: 0 auto; background:  rgb(255,255,255,.3); border: 1px solid #fff; max-height: 125px; max-width:125px;
         border-radius: 50% }

/*Skills Section*/
.skills{background: #ecf1f7; padding: 30px 0; margin-top:30px; box-shadow: 0 0 25px rgb(0,0,0,.3);   }
.skill-tags{display: inline; padding-top:10px; }
.skill-tags ul li span{color:#333339; font-size:16px; text-transform: uppercase; font-weight: bold; background: none; }
.skill-tags ul{padding-left: 10px;}
.skill-tags ul li{ display: inline-block; background: rgba(220, 220, 220, 0.85); padding: 5px 10px; border-radius: 10px; font-size: 14px; 
                  font-style: oblique; margin: 3px;}
.progress , .progress-bar{height: 15px; font-size: 10px; line-height: 15px;}
.progress{margin: 15px 0 0px 0;}
.custom-bg{background: #00a3e0; }
.keyheading, .additionalskills{font-size: 18px; font-family: open sans; font-weight: bold; padding-left: 15px;}
.additionalskills{padding: 15px 0 15px 15px;}
.margin-top-0{margin-top: 0px !important;}
.communication-lvl{font-size: 12px; color: #333;}
.communication-lvl span{padding-left:62px; }
.com-prog{margin-top: 10px;}

/*contact section*/
.contact{padding: 30px 30px; margin-bottom: 30px;}
.c-padding{padding: 20px;}
.contact-btn{text-align: center; }
.contact-btn a{border:1px solid #00a0e3;padding: 10px 20px; background: #00a0e3; color:#fff; text-transform: uppercase; 
                letter-spacing: .5px;}
.contact-btn a:hover{border:1px solid #ff7803; background: #ff7803; color:#fff; transition: .3s ease-in-out; 
      text-decoration:none;  }
.textarea{resize: none;}
@media (min-width:992px) and (max-width:1100px){
    .head-btn1 i, .head-btn2 i{display:none;}
    .head-btn1,.head-btn2{ max-width: 150px;} 
    .can-user-icon img{margin-left: 0px;}
    .head-btn1 a, .head-btn2 a{ padding-left: 5px; padding-right: 5px;}
}
@media screen and (max-width:992px){
    
    .can-name-heading{margin-top: 0px; margin-left: -30px;}
    .head-btn11{margin-top:20px; }
    /*.btn-txt, .btn-txt2{display:none;}*/
    .head-btn1 a, .head-btn2 a{text-align: center;}
    .bdy-content{margin:0 50px 0 100px; }
    .can-user-icon img{margin-left: 20px;}
    .per-det{border: none; padding: 0 0 0 0;}
    .per{padding-top: 20px;}
    .com-mark{display: none;}
}

@-webkit-keyframes wiggle {
  0% {
    -webkit-transform: rotateZ(5deg);
            transform: rotateZ(2deg);
  }
  50% {
    -webkit-transform: rotateZ(-2deg);
            transform: rotateZ(-2deg);
  }
  100% {
    -webkit-transform: rotateZ(2deg);
            transform: rotateZ(2deg);
  }
}
.wrap {
  width: 100%;
  text-align: center;
}
.social {
  font-size: 3em;
  height: 55px;
  overflow: hidden;
}
.social .fa {
  position: relative;
  top: 12px;
  margin: 0 10px;
  transition: all 100ms cubic-bezier(0.42, 0, 0.58, 1);
}
.social .fa:hover {
  top: 1px;
}
.fb {
  color: #3B5998;
}
.tw {
  color: #09AEEC;
}
.yt {
  color: #AA2A25;
}
.lk {
  color: #0077B5;
}
.sk {
  color: #00A5E6;
}
.db {
  color: #000;
}
.apple {
  color: #dd4b39;
}
.gallary .fa.fa-plus {
    height: 30px;
    width: 30px;
    border: 1px solid #FCAC45;
    font-size: 20px;
    padding: 5px;
    border-radius: 50%;
    color: #FCAC45;
}
.gallary ul {
	padding: 10px 0;
}
.gallary ul li {
	display: inline-block;
	margin-top: 10px;
}
.gallary ol li {
	display: inline-block;
	margin-left: 20px;
}
.gallary ol li:last-child a:after {
	content: "";
}
.gallary ol li a {
	color: #00a0e3;
        font-size: 18px;
        font-weight: 500;
        border: 1px solid #00a0e3;
        padding: 5px 10px;
        background: #00a0e3;
        color:#fff;
        border-radius: 15px;
}
.gallary ol li a:hover{
    text-decoration: none;
    color: #fff;
    background: #ff7803;
    border: 1px solid #ff7803;       
}
.gallary ol li a.active {
        color: #ff7803;
        text-decoration: none;
         border: 1px solid #ff7803;
         background: #ff7803;
         color: #fff;
}
.gallary .gallary-item {
    margin-bottom: 20px !important;
    display: block;
    position: relative;
    margin: 0 auto;
    max-width: 400px;
}
.gallary .gallary-item img{
    max-width: 300px;
    max-height: 250px;
}
.gallary .gallary-item .hover-bg {
	overflow: hidden;
	position: relative;
}
.gallary .hover-bg .hover-text {
	position: absolute;
	text-align: center;
	margin: 0 auto;
	color: #ffffff;
	background: rgba(0, 0, 0, 0.66);
	padding: 25% 0;
	height: 100%;
	width: 100%;
	opacity: 0;
	transition: all 0.5s;
}
.gallary .hover-bg .hover-text>h4 {
	opacity: 0;
	-webkit-transform: translateY(100%);
	transform: translateY(100%);
	transition: all 0.3s;
}

.gallary .hover-bg:hover .hover-text>h4 {
	opacity: 1;
	-webkit-backface-visibility: hidden;
	-webkit-transform: translateY(0);
	transform: translateY(0);
}
.gallary .hover-bg .hover-text>i {
	opacity: 0;
	-webkit-transform: translateY(0);
	transform: translateY(0);
	transition: all 0.3s;
}
.gallary .hover-bg:hover .hover-text>i {
	opacity: 1;
	-webkit-backface-visibility: hidden;
	-webkit-transform: translateY(100%);
	transform: translateY(100%);
}
.isotope-item { 
    z-index: 2;
}
.isotope-hidden.isotope-item { 
	z-index: 1;
}
.isotope,
.isotope .isotope-item {
    -webkit-transition-duration: 0.8s;
    -moz-transition-duration: 0.8s;
    transition-duration: 0.8s;
}
.isotope-item {
    margin-right: -1px;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
}
.isotope {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transition-property: height, width;
    -moz-transition-property: height, width;
    transition-property: height, width;
}
.isotope .isotope-item {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transition-property: -webkit-transform, opacity;
    -moz-transition-property: -moz-transform, opacity;
    transition-property: transform, opacity;
}

@media (max-width: 767px) {
    .isotope {
        height: auto !important;
    }
    .isotope-item {
    	text-align: center;
    	transform: none !important;
    	position: relative !important;
    }
}
.progress-bar .percent{
    display:none;
}
.avatar-edit {
    position: absolute;
    right: 12px;
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
.tree_widget-sec > ul > li > a i{
    line-height:41px !important;
}
/*Bootstrap editable css starts */
.editableform .control-group{
    width: auto;
    height: auto;
    padding: 0;
    margin: 2px;
}
.editable-input .form-control{
    height:auto;
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
/*Bootstrap editable css ends */

.full_width{
    width:100%;
    height:100%;
}
.datepicker .datepicker-days {
    display: block;
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
    top: 75px;
    left: 212px;
}
.hiden:before{
    content: "";
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
    z-index: 9;
}
.hiden2:before{
    content: "";
    right: 36px;
    top: -13px;
    position: absolute;
    border-left: 10px solid transparent;
    border-bottom: 15px solid #f9f9f9;
    border-right: 10px solid transparent;
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
#upload-user-cover-image{
    margin:0px !important;
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
//  padding: 8px 0;
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
    width:100%;
}


/*Range slider css starts */
*, *::after, *::before {
  -ms-box-sizing: border-box;
  -o-box-sizing: border-box;
  box-sizing: border-box;
}

.wrap .holder .demo {
  display: block;
  min-height: 60px;
  padding: 10px 0;
}

.rkmd-slider {
  display: block;
  position: relative;
  font-size: 16px;
  margin-top: 15px;
}
.rkmd-slider input[type="range"] {
  overflow: hidden;
  position: absolute;
  width: 1px;
  height: 1px;
  opacity: 0;
}
.slider {
  display: block;
  position: relative;
  width: 100%;
  height: 4px;
  background-color: #bebebe;
}
.slider .slider-fill {
  display: block;
  position: absolute;
  width: 0%;
  height: 100%;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  z-index: 1;
}
.slider .slider-handle {
  cursor: pointer;
  position: absolute;
  top: -5.5px;
  left: 0%;
  width: 15px;
  height: 15px;
  margin-left: -8px;
  border-radius: 50%;
  transition: all .2s ease;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  z-index: 2;
}
.rkmd-slider.slider-continuous.slider-scale .slider-handle:active {
  -webkit-transform: scale(1.4);
          transform: scale(1.4);
}
.rkmd-slider.slider-continuous.slider-shadow.slider-lightBlue .slider-handle:active {
  box-shadow: 0 0 0 10px rgba(3, 169, 244, 0.26);
}


.rkmd-slider.slider-discrete .slider .slider-handle {
  position: relative;
  z-index: 1;
}
.rkmd-slider.slider-discrete .slider .slider-handle .slider-label {
  position: absolute;
  top: -17.5px;
  left: -2px;
  width: 30px;
  height: 30px;
  -webkit-transform-origin: 50% 100%;
          transform-origin: 50% 100%;
  border-radius: 50%;
  -webkit-transform: scale(0.5) rotate(-45deg);
          transform: scale(0.5) rotate(-45deg);
  transition: all .2s ease;
}
.rkmd-slider.slider-discrete .slider .slider-handle .slider-label span {
  position: absolute;
  top: 7px;
  left: 0px;
  width: 100%;
  color: #fff;
  font-size: 12px;
  text-align: center;
  -webkit-transform: rotate(45deg);
          transform: rotate(45deg);
  opacity: 0;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}
.rkmd-slider.slider-discrete .slider .slider-handle.is-active {
  top: 0px;
  margin-left: -2px;
  width: 4px;
  height: 4px;
}
.rkmd-slider.slider-discrete .slider .slider-handle.is-active .slider-label {
  top: -15px;
  left: -2px;
  border-radius: 15px 15px 15px 0;
  -webkit-transform: rotate(-45deg) translate(23px, -25px);
          transform: rotate(-45deg) translate(23px, -25px);
}
.rkmd-slider.slider-discrete .slider .slider-handle.is-active .slider-label span {
  opacity: 1;
}
.rkmd-slider.slider-discrete.slider-lightBlue .slider-label {
  background-color: #03a9f4;
}
.rkmd-slider.slider-lightBlue .slider-fill,
.rkmd-slider.slider-lightBlue .slider-handle {
  background-color: #03a9f4;
}
.slider-horizontal{
    display:none;
}
/*Range slider css ends */



');
$script = <<< JS
document.body.scrollTop = 0;
document.documentElement.scrollTop = 0;

$('.model').editable({
    placement: 'right',
    url: '/users/update-profile',
    toggle: 'manual',
});
$('.model2').editable({
    placement: 'top',
    url: '/users/update-profile',
    toggle: 'manual',
});
$('.model-link').editable({
    placement: 'top',
    url: '/users/update-profile',
    toggle: 'manual',
    display: function(value) {
        $(this).attr('href',value);
    }
});
$('.marital-status').editable({
    value: 2,
    source: [
          {value: 1, text: 'Married'},
          {value: 2, text: 'Un-married'},
       ]
});
$('.pen').click(function(e){
    e.stopPropagation();
    $(this).prev().editable('toggle');
});
        
$(document).on('click', '.remove-image', function(a) {
    a.preventDefault();
    $('#pop-content1_2').fadeIn(1000);
});
$(document).on('click', '#cancel_remove', function() {
    $('#pop-content1_2').fadeOut(1000);
});
        
$(document).on('click', '.remove_cover_image', function(a) {
    a.preventDefault();
    $('#pop-content2_2').fadeIn(1000);
});
$(document).on('click', '#cancel_cover_remove', function() {
    $('#pop-content2_2').fadeOut(1000);
});
        
var image_path = $('#profile-img').attr('src');
var profile_name_path = "$no_image";
var cover_image_path = $('.jumbo').css('background-image');
        
        
$(document).on('click', '.check_this', function(){
    var isChecked = $("#exp_present").is(":checked");
    if (isChecked) {
        $('.check_exp').hide();
        $('#exp_present').val('1');
    } else {
        $('.check_exp').show();
        $('#exp_present').val('0');
    }
});
        
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#profile-img').attr('src', e.target.result);
            $('#profile-img').hide();
            $('#profile-img').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.jumbo').css('background-image', 'url(' + e.target.result + ')');
            $('.jumbo').fadeTo(1000, 0.4);
            $('.jumbo').fadeTo(1000, 1);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});
$("#coverImageUpload").change(function() {
    readURL2(this);
});

$('#profile-img').on('load', function () {
    if($("#profile-img").attr('src') != image_path && $("#profile-img").attr('src') != profile_name_path){
        $('#pop-content').fadeIn(1000);
   }
});
$('.jumbo').on('change', function () {
    if($(".jumbo").css('background-image') != image_path ){
        $('#pop-content2').fadeIn(1000);
   }
});
        
$(document).on('submit', '#upload-user-image', function(event) {
    event.preventDefault();
    $('#pop-content').fadeOut(1000);
    $.ajax({
        url: "/users/update-profile-image",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache:false,
        processData: false,
        beforeSend:function(){     
            $('.loader-aj-main').fadeIn(1000);  
        },
        success: function (response) {
//        console.log(response);
        $('.loader-aj-main').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
//                console.log('okkk');
            } else {
                toastr.error(response.message, response.title);
            }
            
        }
    });
});
        
$(document).on('submit', '#upload-user-cover-image', function(event) {
    event.preventDefault();
    $('#pop-content2').fadeOut(1000);
    $.ajax({
        url: "/users/update-cover-image",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache:false,
        processData: false,
        beforeSend:function(){     
            $('.loader-aj-main').fadeIn(1000);  
        },
        success: function (response) {
        $('.loader-aj-main').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
            } else {
                toastr.error(response.message, response.title);
            }
            
        }
    });
});
        
$(document).on('submit', '#add-experience-form', function(event) {
    event.preventDefault();
        var data = $('#add-experience-form').serialize();
    var url = $(this).attr('action');
    var method = $(this).attr('method');
    $.ajax({
        url: url,
        method: method,
        data: data,
        beforeSend:function(){     
            $('.loader-aj-main').fadeIn(1000);  
        },
        success: function (response) {
        console.log(response);
        $('.loader-aj-main').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
                $("#add-experience-form")[0].reset();
                $.pjax.reload({container: '#pjax_experience', async: false});
                $('#myModal2').modal('hide');
            } else {
                toastr.error(response.message, response.title);
            }
            
        }
    });
});
        
$(document).on('click', '#confirm_remove_image', function(event) {
    event.preventDefault();
    $('#pop-content1_2').fadeOut(1000);
    var type = $(this).val();
    $.ajax({
        url: "/users/remove-image",
        method: "POST",
        data: {type:type},
        beforeSend:function(){
            $('.loader-aj-main').fadeIn(1000);  
        },
        success: function (response) {
        $('.loader-aj-main').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
                $('#profile-img').attr('src',profile_name_path);
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
        url: "/users/remove-image",
        method: "POST",
        data: {type:type},
        beforeSend:function(){
            $('.loader-aj-main').fadeIn(1000);  
        },
        success: function (response) {
        $('.loader-aj-main').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
            } else {
                toastr.error(response.message, response.title);
            }
        }
    });
});
        
        
$(document).on('click', '#cancel_image', function() {
    $('#pop-content').fadeOut(1000);
    $('#profile-img').attr('src', image_path);
});
$(document).on('click', '#cancel_cover', function() {
    $('#pop-content2').fadeOut(1000);
    $('.jumbo').css('background-image', cover_image_path);
});

$(document).on('submit', '#add-education-form', function(event) {
    event.preventDefault();
    var education_method = $(this).attr('method');
    var education_url = $(this).attr('action');
    var education_data = $(this).serialize();
    var before = function(){     
        $('.loader-aj-main').fadeIn(1000);  
    };
    var req = function(){
        var result = ajax(education_method, education_url, education_data);
        var resp = result["responseJSON"];
        $('.loader-aj-main').fadeOut(1000);
        if(resp.status == 200){
            toastr.success(resp.message, resp.title);
            $("#add-education-form")[0].reset();
            $.pjax.reload({container: '#pjax_qualification', async: false});
            $('#open-qualification-modal').modal('hide');
        }else{
            toastr.error(resp.message, resp.title);
        }
    }
    order(before, req);
});
$(document).on('submit', '#add-skill-form', function(event) {
    event.preventDefault();
    var skills_method = $(this).attr('method');
    var skills_url = $(this).attr('action');
    var skills_data = $(this).serialize();
    var before = function(){
        $('.loader-aj-main').fadeIn(1000);
    };
    var req = function(){
        var result = ajax(skills_method, skills_url, skills_data);
        var resp = result["responseJSON"];
        $('.loader-aj-main').fadeOut(1000);
        if(resp.status == 200){
            toastr.success(resp.message, resp.title);
            $('#skills-main').val('');
            $("#add-skill-form")[0].reset();
            $.pjax.reload({container: '#pjax_skills', async: false});
            $('#open-skill-modal').modal('hide');
        }else{
            toastr.error(resp.message, resp.title);
        }
    }
    order(before, req);
});
        
        function order(before, req){
            before();
            req();
        }
        
        
var city = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '',
  remote: {
    url:'/cities/city-list?q=%QUERY',  
    wildcard: '%QUERY',
    filter: function(list) {
             return list;
        }
  }
});    
            
$('#cities').typeahead(null, {
  name: 'cities',
  highlight: true,       
  display: 'text',
  source: city,
   limit: 15,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.Typeahead-spinner').hide();
  }).on('typeahead:selected typeahead:completed',function(e,datum)
      {
        $('#city_id').val(datum.id);
     });
        
        
var accountBloodhound = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,

    remote: {
        url: '/account/skills/get-skills#%QUERY',
        wildcard: '%QUERY',
        transport: function (opts, onSuccess, onError) {
            var url = opts.url.split("#")[0];
            var query = opts.url.split("#")[1];
            $.ajax({
                url: url,
                data: "q=" + query,
                type: "POST",
                success: onSuccess,
                error: onError,
            })
        }
    }
});

$('#skills-input').typeahead(null, {
    name: 'skills',
    display: 'skill',
    source: accountBloodhound 
}).bind('typeahead:select', function (ev, suggestion) {
    $('#skills-main').val(suggestion.skill_enc_id);
});        
        
        
$('[data-toggle="tooltip"]').tooltip();
var objectPositionTop = $('#skills').offset().top;   
 var sections = $('section')
                        , nav = $('nav')
                        , nav_height = nav.outerHeight();

                $(window).on('scroll', function () {
                    var currentPosition = $(document).scrollTop();

                    sections.each(function () {
                        var top = $(this).offset().top - nav_height,
                                bottom = top + $(this).outerHeight();

                        if (currentPosition >= top && currentPosition <= bottom) {
                            nav.find('a').removeClass('active');
                            sections.removeClass('active');

                            $(this).addClass('active');
                            nav.find('a[href="#' + $(this).attr('id') + '"]').addClass('active');
                        }
                    });
                    
                    if (currentPosition >= objectPositionTop) {
                        $('.progress .progress-bar').css("width",
                                function () {
                                    return $(this).attr("aria-valuenow") + "%";
                                }
                        )
                    }
                });

                nav.find('li a').on('click', function () {
                    var el = $(this)
                            , id = el.attr('href');

                    $('html, body').animate({
                        scrollTop: $(id).offset().top - nav_height
                    }, 500);

                    return false;
                });
        
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/jquery.fancybox.min.css');
//$this->registerCssFile('http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/css/bootstrap-combined.min.css');
$this->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/jquery.fancybox.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
//$this->registerJsFile('@eyAssets/js/candidates-list/modernizr-2.8.3-respond-1.4.2.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@eyAssets/js/jquery.isotope.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('http://vitalets.github.io/x-editable/assets/mockjax/jquery.mockjax.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
