<?php
//echo '<pre>';
//print_r($user);print_r()
//echo '</pre>';

//exit;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\TimePicker;
use kartik\widgets\DatePicker;
use yii\widgets\Pjax;


function random_color_part()
{
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}

function random_color()
{
    return random_color_part() . random_color_part() . random_color_part();
}

//print_r($user);
//exit();
if ($user['image']) {
    $image_path = Yii::$app->params->upload_directories->users->image_path . $user['image_location'] . DIRECTORY_SEPARATOR . $user['image'];
    $image = Yii::$app->params->upload_directories->users->image . $user['image_location'] . DIRECTORY_SEPARATOR . $user['image'];
    if (!file_exists($image_path)) {
        $image = "https://ui-avatars.com/api/?name=" . $user['first_name'] . "+" . $user['last_name'] . '&size=450';
    }
} else {
    $image = "https://ui-avatars.com/api/?name=" . $user['first_name'] . "+" . $user['last_name'] . '&size=450&background=' . random_color() . '&color=ffffff';
}
$no_image = "https://ui-avatars.com/api/?name=" . $user['first_name'] . "+" . $user['last_name'] . '&size=450&background=' . random_color() . '&color=ffffff';
?>
    <div class="row" xmlns="http://www.w3.org/1999/html">
        <!-- <div class="col-md-2 col-sm-4">-->
        <!-- <div class="col-md-12 bg-theme-colored round">
            <img width="100%" id="img_id" src="<? /*= Url::to($image); */ ?>"/>-->
        <!--<input type="file" name="photo" id="upload-photo" />-->
        <?php
        $form = ActiveForm::begin(['id' => 'form-profile', 'class' => 'form-body',
            'options' => ['enctype' => 'multipart/form-data'],
            'fieldConfig' => [
                'template' => "{input}"
            ],
        ]);
        ?>
        <!-- <div id="open-pop" class="avatar-edit">
             <i class="fa fa-pencil dropdown-toggle full_width" data-toggle="dropdown"></i>
             <ul class="dropdown-menu">
                 <li>
                     <a href="#">-->
        <!--    --><? /*= $form->field($individualImageFormModel, 'image')->fileInput(['id' => 'profile_pic'])->label(false) */ ?>
        <!--<input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />-->
        <!--  <label class="profile-label" for="profile_pic">Change Profile Picture</label>
      </a>
  </li>
  <li><a href="#" class="remove-image">Remove</a></li>
  <li><a href="#">Cancel</a></li>
</ul>
</div>-->
        <!-- <div id="pop-content" class="hiden">
                <? /*= Html::submitButton('<i class="glyphicon glyphicon-ok"></i>', ['class' => 'btn btn-primary btn-sm editable-submit']) */ ?>
                <button id="cancel_image" type="button" class="btn btn-default btn-sm editable-cancel">
                    <i class="glyphicon glyphicon-remove"></i>
                </button>
            </div>-->
        <!-- <div id="pop-content1_2" class="hiden">
             <h5>Are you sure want to remove Profile Image?</h5>
             <button id="confirm_remove_image" type="button" value="image" class="btn btn-primary btn-sm editable-submit">
                 <i class="glyphicon glyphicon-ok"></i>
             </button>
             <button id="cancel_remove" type="button" class="btn btn-default btn-sm editable-cancel">
                 <i class="glyphicon glyphicon-remove"></i>
             </button>
         </div>-->
        <!-- </div>-->
        <?php ActiveForm::end(); ?>
        <?php
        Pjax::begin(['id' => 'pjax_des']);
        ?>
        <!-- <div class="col-sm-12 col-md-12 bg-theme-colored round">-->
        <!-- <div class="round-info-upper text-center">
             <label>
                 <h4 style="color:white"> About Me</h4>
             </label>
         </div>-->
        <!--  <div style="color:#000" class="col-md-12">--><!--- align="center"--->
        <!--<p id="about_me"><? /*= $user['description']; */ ?></p>
                <div align="center" class="col-md-12">
                    <icon class="fa fa-edit"></icon>
                    <a href="#" data-toggle = "modal" data-target = "#about_me_modal">Edit</a>
                </div>-->
        <!--</div>-->
        <!--</div>-->
        <?php Pjax::end(); ?>
        <div id="about_me_modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $form_description = ActiveForm::begin(['id' => 'form-description', 'class' => 'form-body',
                            'options' => ['enctype' => 'multipart/form-data'],
                            'action' => '/account/resume-builder/change-description',
                            'fieldConfig' => [
                                'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{error}{hint}</div>"
                            ],
                        ]);
                        ?>
                        <?= $form_description->field($ResumeAboutMe, 'about_me')->textarea(['id' => 'description-value', 'value' => $user['description'], 'row' => '6', 'cols' => 60])->label('Write A Short Note About Yourself '); ?>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-md']); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

        <div id="contact_me_modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <?php
                        $form_info = ActiveForm::begin(['id' => 'form-contact-info', 'class' => 'form-body',
                            'options' => ['enctype' => 'multipart/form-data'],
                            'action' => '/account/resume-builder/change-information',
                            'fieldConfig' => [
                                'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{error}{hint}</div>"
                            ],
                        ]);
                        ?>
                        <!--< $form_info->field($ResumeContactInfo, 'contact_mobile')->textInput(['id' => 'contact_mobile'])->label('Mobile No'); ?>-->
                        <!--< $form_info->field($ResumeContactInfo, 'contact_email')->textInput(['id' => 'contact_email'])->label('Email'); ?>-->
                        <?= $form_info->field($ResumeContactInfo, 'contact_address')->textInput(['id' => 'contact_address', 'value' => $user['address']])->label('Address'); ?>
                        <?= $form_info->field($ResumeContactInfo, 'city')->textInput(['id' => 'contact_city', 'placeholder' => 'City'])->label(false); ?>
                        <?= $form_info->field($ResumeContactInfo, 'city_id', ['template' => '{input}'])->hiddenInput(['id' => 'city_id'])->label(false); ?>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-md']); ?>

                    </div>

                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

        <div id="other_info_modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <?php
                        $form = ActiveForm::begin(['id' => 'form-other_info', 'class' => 'form-body',
                            'options' => ['enctype' => 'multipart/form-data'],
                            'fieldConfig' => [
                                'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{error}{hint}</div>"
                            ],
                        ]);
                        ?>

                        <?= $form->field($ResumeOtherInfo, 'dob')->widget(DatePicker::classname())->label('Date of Birth'); ?>
                        <?= $form->field($ResumeOtherInfo, 'preference')->textInput(['id' => 'Preference']); ?>
                        <?= $form->field($ResumeOtherInfo, 'gender')->dropDownlist(['1' => 'Male', '2' => 'Female'], ['prompt' => 'Select'])->label(false); ?>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-md']); ?>
                    </div>

                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

        <!-- <div class="col-md-12 col-sm-12 round-info-lower">-->
        <!-- <div class="row" align="center">-->
        <!-- <div class="col-md-10 col-sm-10 col-xs-9" align="center">-->
        <!-- <label>
             <h4>Contact Information</h4>
         </label>-->
        <!-- </div>-->
        <!-- <div class="col-md-2 col-sm-2 col-xs-3" align="center">
             <h4>
                 <a href="#" data-toggle = "modal" data-target = "#contact_me_modal"><icon class="fa fa-edit text-theme-color-2"></icon></a>
             </h4>
         </div>-->
        <!-- </div>-->
        <?php
        Pjax::begin(['id' => 'pjax_contact_info']);
        ?>
        <!--  <ul>
                <li>
                    <label><h5><strong>Phone : <? /*= $user['phone']; */ ?></strong></h5></label>
                    <label id="contact_label"></label>
                </li>
                <li>
                    <label><h5><strong>Email : <? /*= $user['email']; */ ?></strong></h5></label>
                    <label id="email_label"></label>
                </li>
                <li>
                    <label><h5><strong>Address : <? /*= $user['address']; */ ?></strong></h5></label>
                    <label id="address_label"></label>
                </li>
                <li>
                    <label><h5><strong>City : <? /*= $user['city_enc_id']; */ ?></strong></h5></label>
                    <label id="address_label"></label>
                </li>
            </ul>-->
        <?php Pjax::end(); ?>
        <!--</div>-->
        <!-- <div class="col-md-12 col-sm-12 round-info-lower">-->
        <!-- <div class="row">
             <div class="col-md-10 col-sm-10 col-xs-9" align="center">
                 <label>
                     <h4>Other Information</h4>
                 </label>
             </div>
             <div class="col-md-2 col-sm-2 col-xs-3" align="center">
                 <h4>
                     <a href="#" data-toggle = "modal" data-target = "#other_info_modal"><icon class="fa fa-edit text-theme-color-2"></icon></a>
                 </h4>
             </div>
         </div>-->
        <!--<ul>
            <li>
                <label><h5><strong>Date Of Birth :</strong></h5></label>
                <label id="dob_label"></label>
            </li>
            <li>
                <label><h5><strong>Preferences :</strong></h5></label>
                <label id="preference_label"></label>
            </li>
            <li>
                <label><h5><strong>Gender :</strong></h5></label>
                <label id="gender_label"></label>
            </li>
        </ul>-->
        <!-- </div>-->
        <!--</div>-->
        <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
            <div class="col-md-12 col-sm-12">
                <!--<div class="row">
                    <div class="col-md-6 col-sm-6 pull-left">
                        <button class="btn btn-primary btn-lg btn-block">
                            <icon class="fa fa-download"></icon>
                            Download
                        </button>
                    </div>
                    <div class="col-md-6 col-sm-6 pull-right">
                        <button class="btn btn-primary btn-lg btn-block">
                            <icon class="fa fa-save"></icon>
                            Save
                        </button>

                    </div>
                </div>
    -->
                <div class="row bg-lighter shadow round working">
                    <div class="col-md-8 col-sm-8">
                        <h4>
                            <icon class="fa fa-graduation-cap"></icon>
                            Education
                        </h4>

                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="modal fade " id="add-education-modal" tabindex="-1" role="dialog"
                             aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 id="eduTitle"
                                            class="modal-title"><?= Yii::t('account', 'Add Education'); ?></h4>
                                    </div>
                                    <?php
                                    $fforms = ActiveForm::begin([
                                        'id' => 'add-education-form',
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
                                        <?= Html::submitButton('Submit', ['class' => 'btn btn-success  eduSave']); ?>
                                        <?= Html::button('Close', ['class' => 'btn default ', 'data-dismiss' => 'modal']); ?>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade " id="update-education-modal" tabindex="-1" role="dialog"
                             aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 id="eduTitle"
                                            class="modal-title"><?= Yii::t('account', 'Update Education'); ?></h4>
                                    </div>
                                    <?php
                                    $fforms = ActiveForm::begin([
                                        'id' => 'update-education-form',
                                        'fieldConfig' => [
                                            'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
                                        ],
                                    ]);
                                    ?>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?= $fforms->field($addQualificationForm, 'school')->textInput(['autocomplete' => 'off', 'id' => 'update_school'])->label(true); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?= $fforms->field($addQualificationForm, 'degree')->textInput(['autocomplete' => 'off', 'id' => 'update_degree'])->label(true); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?= $fforms->field($addQualificationForm, 'field')->textInput(['autocomplete' => 'off', 'id' => 'update_field'])->label(true); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?=
                                                $fforms->field($addQualificationForm, 'qualification_from')->widget(DatePicker::classname(), [
                                                    'options' => ['placeholder' => 'From Year', 'id' => 'update_qualification_from'],
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
                                                        'options' => ['placeholder' => 'To Year', 'id' => 'update_qualification_to'],
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
                                        <?= Html::submitButton('Update', ['class' => 'btn btn-success  eduUpdate']); ?>
                                        <?= Html::button('Close', ['class' => 'btn default ', 'data-dismiss' => 'modal']); ?>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>

                        <button id="addEdu" class="btn btn-primary btn-lg btn-block" data-toggle="modal">
                            <icon class="fa fa-plus"></icon>
                            Add Education
                        </button>
                    </div>
                    <?php
                    Pjax::begin(['id' => 'pjax_qualification']);
                    ?>
                    <div class="col-md-10 col-md-offset-1">
                        <?php
                        if (!empty($education)) {
                            foreach ($education as $e) { ?>
                                <div class="row" style="margin-top: 40px; margin-bottom: 40px;">
                                    <hr class="gradient_line"/>
                                    <div class="col-md-3 col-sm-3 col-xs-4">
                                        <div class="text-right">
                                            <h4 class="colored"><strong><?= $e['degree']; ?></strong></h4>
                                            <?php
                                            $from = strtotime($e['from_date']);
                                            $to = strtotime($e['to_date']);
                                            ?>
                                            <?= date('Y', $from) ?> to <?= date('Y', $to) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-8">
                                        <div class="experience-detail">
                                            <h4><strong><?= $e['institute']; ?></strong></h4>
                                            <p><?= $e['field']; ?></p>
                                        </div>
                                        <div class="avatar-edit edu-pen" id="<?= $e['education_enc_id']; ?>">
                                            <i class="fa fa-pencil"></i>
                                        </div>
                                        <div class="avatar-edit edu-del" id="<?= $e['education_enc_id']; ?>">
                                            <i class="fa fa-times"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo 'No data found';
                        }
                        ?>
                    </div>
                    <?php Pjax::end(); ?>
                </div>

                <div class="row bg-lighter shadow round working">

                    <div class="col-md-8 col-sm-8">
                        <h4>
                            <icon class="fa fa-graduation-cap"></icon>
                            Work Experience
                        </h4>
                    </div>
                    <div class="experiences">
                        <div class="col-md-4  col-sm-4">
                            <div class="modal fade" id="add-experience-modal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 id="expTitle"
                                                class="modal-title"><?= Yii::t('account', 'Add Work Experience'); ?></h4>
                                        </div>
                                        <?php
                                        $fform = ActiveForm::begin([
                                            'id' => 'add-experience-form',
                                            'fieldConfig' => [
                                                'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
                                            ],
                                        ]);
                                        ?>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <?= $fform->field($addExperienceForm, 'title')->textInput(['autocomplete' => 'off'])->label(true); ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?= $fform->field($addExperienceForm, 'company')->textInput(['autocomplete' => 'off'])->label(true); ?>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="load-suggestions Typeahead-spinner" style="display: none;">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </div>
                                                    <?= $fform->field($addExperienceForm, 'location')->textInput(['id' => 'cities', 'placeholder' => 'Location', 'autocomplete' => 'off'])->label(false); ?>
                                                    <?= $fform->field($addExperienceForm, 'city_id', ['template' => '{input}'])->hiddenInput(['id' => 'city_id_exp'])->label(false); ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?=
                                                    $fform->field($addExperienceForm, 'exp_from')->widget(DatePicker::classname(), [
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
                                                <div class="col-md-6 experience">
                                                    <div class="check_exp">
                                                        <?=
                                                        $fform->field($addExperienceForm, 'exp_to')->widget(DatePicker::classname(), [
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
                                                        $fform->field($addExperienceForm, 'present')->checkBoxList([
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
                                                <div class="col-md-12 ">
                                                    <?=
                                                    $fform->field($addExperienceForm, 'description')->textarea(['rows' => 6,])->label('Description');
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary  expSave']); ?>
                                            <?= Html::button('Close', ['class' => 'btn default ', 'data-dismiss' => 'modal']); ?>
                                        </div>
                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="update-experience-modal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 id="expTitle"
                                                class="modal-title"><?= Yii::t('account', 'Add Work Experience'); ?></h4>
                                        </div>
                                        <?php
                                        $fform = ActiveForm::begin([
                                            'id' => 'update-experience-form',
                                            'fieldConfig' => [
                                                'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
                                            ],
                                        ]);
                                        ?>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <?= $fform->field($addExperienceForm, 'title')->textInput(['autocomplete' => 'off','id'=>'update_exp_title'])->label(true); ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?= $fform->field($addExperienceForm, 'company')->textInput(['autocomplete' => 'off','id'=>'update_exp_company'])->label(true); ?>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="load-suggestions Typeahead-spinner" style="display: none;">
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </div>
                                                    <?= $fform->field($addExperienceForm, 'location')->textInput(['id' => 'update_cities', 'placeholder' => 'Location', 'autocomplete' => 'off'])->label(false); ?>
                                                    <?= $fform->field($addExperienceForm, 'city_id', ['template' => '{input}'])->hiddenInput(['id' => 'update_city_id_exp'])->label(false); ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?=
                                                    $fform->field($addExperienceForm, 'exp_from')->widget(DatePicker::classname(), [
                                                        'options' => ['placeholder' => 'Work Experience From','id'=>'update_exp_from'],
                                                        'readonly' => true,
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'yyyy-mm-dd',
                                                            'name' => 'exp_from',
                                                            'todayHighlight' => true,
                                                        ]])->label(false);
                                                    ?>
                                                </div>
                                                <div class="col-md-6 update_experience">
                                                    <div class="check_exp">
                                                        <?=
                                                        $fform->field($addExperienceForm, 'exp_to')->widget(DatePicker::classname(), [
                                                            'options' => ['placeholder' => 'Work Experience To','id'=>'update_exp_to'],
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
                                                        $fform->field($addExperienceForm, 'present')->checkBoxList([
                                                            1 => 'I currently work here',
                                                        ], [
                                                                'id'=>'update_present',
                                                            'item' => function ($index, $label, $name, $checked) {
                                                                $return = '<div class="md-checkbox check_this">';
                                                                $return .= '<input type="checkbox" id="update_exp_present" value="0" name="' . $name . '"  class="md-check" ' . $checked . ' >';
                                                                $return .= '<label for="update_exp_present">';
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
                                                <div class="col-md-12 ">
                                                    <?=
                                                    $fform->field($addExperienceForm, 'description')->textarea(['rows' => 6,'id'=>'update_description'])->label('Description');
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <?= Html::submitButton('Update', ['class' => 'btn btn-success  expUpdate']); ?>
                                            <?= Html::button('Close', ['class' => 'btn default ', 'data-dismiss' => 'modal']); ?>
                                        </div>
                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                            </div>

                            <button id="addExp" class="btn btn-primary btn-lg btn-block" data-toggle="modal"
                            <!--data-target="#add-experience-modal-->">
                            <icon class="fa fa-plus"></icon>
                            Add Work Experience
                            </button>
                        </div>
                    </div>

                    <?php
                    Pjax::begin(['id' => 'pjax_experience']);
                    ?>
                    <div class="col-md-10 col-md-offset-1 col-sm-12">
                        <?php
                        if (!empty($experience)) {
                            foreach ((array)$experience as $ex) { ?>
                                <div class="row" style="margin-top: 30px;">
                                    <hr class="gradient_line"/>
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <div class="rounded-experience-period">
                                            <?= $ex['from_date']; ?><br/>
                                            -<br/>
                                            <?php if ($ex['is_current']) {
                                                echo 'I am currently work here';
                                            } else {
                                                echo $ex['to_date'];
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-sm-8 col-xs-12">
                                        <div class="experience-detail">
                                            <h4><?= $ex['company']; ?></h4>
                                            <h4 class="colored"><?= $ex['title']; ?></h4>
                                            <p><?= $ex['description']; ?></p>
                                        </div>

                                        <div class="avatar-edit exp-pen" id="<?= $ex['experience_enc_id']; ?>">
                                            <i class="fa fa-pencil"></i>
                                        </div>

                                        <div class="avatar-edit exp-del" id="<?= $ex['experience_enc_id']; ?>">
                                            <i class="fa fa-times"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo 'No data found';
                        }
                        ?>
                    </div>
                    <?php Pjax::end(); ?>

                    <!--                <div id="h" class="bg-light media border-bottom">
                                        <div class="media-left">
                                            <i class="pe-7s-pen text-theme-colored"></i>
                                        </div>
                                        <div class="media-body">
                                            <h5><strong>Experience : <p id="years_a"></p> Years</strong></h5>

                                        </div>
                                    </div>-->


                </div>
                <!-- <div class="row bg-lighter shadow round working">
                <div class="col-md-8 col-sm-8">
                    <h4>
                        <icon class="fa fa-graduation-cap"></icon> Certificates
                    </h4>
                </div>
                <div class="col-md-4 col-sm-4">
                    <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#certificates">Add Certificates</button>
                    <div class="modal fade" id="certificates" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel3">Certificates</h4>
                                </div>
                                <div class="modal-body">
                                    <?php
                /*                                    $form = ActiveForm::begin(['id' => 'form-certificates', 'class' => 'form-body',
                                                                'options' => ['enctype' => 'multipart/form-data'],
                                                                'fieldConfig' => [
                                                                    'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{error}{hint}</div>"
                                                                ],
                                                    ]);
                                                    */ ?>

                                    <? /*= $form->field($ResumeCertificates, 'certificates')->label('Certificates') */ ?>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
                                    <? /*= Html::submitButton('Save', ['class' => 'btn btn-success btn-md certificatesave']); */ ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            --><?php /*ActiveForm::end(); */ ?>


                <!-- <div class="col-md-4 col-sm-4">-->


                <!--  <div class="row bg-lighter shadow round working">
        <div class="col-md-8 col-sm-8">
                <h4>
                    <icon class="fa fa-graduation-cap"></icon> Social Links
                </h4>
                <hr>

            <ul class="widget-todo-list">
           <?php
                /*                if(!empty($user)){
                           {

                           */ ?>
                <li>
                    <div class="checkbox-custom checkbox-default">
                        <label class="todo-label" for="<? /*= $user['user_enc_id']; */ ?>">
                            <span><? /*= $user['facebook']; */ ?></span>


                        </label>
                    </div>

                    <div class="todo-actions" id="<? /*= $user['user_enc_id']; */ ?>">
                        <a class="todo-remove" href="">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </li>
                <?php
                /*                }
                                    }
                                else{
                                    echo 'No Social link Add Yet';
                                }
                                */ ?>

            </ul>


            <ul class="widget-todo-list">
                <?php
                /*                if(!empty($user)){
                                    {

                                        */ ?>
                        <li>
                            <div class="checkbox-custom checkbox-default">
                                <label class="todo-label" for="<? /*= $user['user_enc_id']; */ ?>">
                                    <span><? /*= $user['instagram']; */ ?></span>


                                </label>
                            </div>

                            <div class="todo-actions" id="<? /*= $user['user_enc_id']; */ ?>">
                                <a class="todo-remove" href="">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </li>
                        <?php
                /*                    }
                                }
                                else{
                                    echo 'No Social link Add Yet';
                                }
                                */ ?>

            </ul>

            <ul class="widget-todo-list">
                <?php
                /*                if(!empty($user)){
                                    {

                                        */ ?>
                        <li>
                            <div class="checkbox-custom checkbox-default">
                                <label class="todo-label" for="<? /*= $user['user_enc_id']; */ ?>">
                                    <span><? /*= $user['linkedin']; */ ?></span>


                                </label>
                            </div>

                            <div class="todo-actions" id="<? /*= $user['user_enc_id']; */ ?>">
                                <a class="todo-remove" href="">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </li>
                        <?php
                /*                    }
                                }
                                else{
                                    echo 'No Social link Add Yet';
                                }
                                */ ?>

            </ul>

--><!--
            <ul class="widget-todo-list">
                <?php
                /*                if(!empty($user)){
                                    {

                                        */ ?>
                        <li>
                            <div class="checkbox-custom checkbox-default">
                                <label class="todo-label" for="<? /*= $user['user_enc_id']; */ ?>">
                                    <span><? /*= $user['google']; */ ?></span>


                                </label>
                            </div>

                            <div class="todo-actions" id="<? /*= $user['user_enc_id']; */ ?>">
                                <a class="todo-remove" href="">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </li>
                        <?php
                /*                    }
                                }
                                else{
                                    echo 'No Social link Add Yet';
                                }
                                */ ?>

            </ul>


            <ul class="widget-todo-list">
                <?php
                /*                if(!empty($user)){
                                    {

                                        */ ?>
                        <li>
                            <div class="checkbox-custom checkbox-default">
                                <label class="todo-label" for="<? /*= $user['user_enc_id']; */ ?>">
                                    <span><? /*= $user['twitter']; */ ?></span>


                                </label>
                            </div>

                            <div class="todo-actions" id="<? /*= $user['user_enc_id']; */ ?>">
                                <a class="todo-remove" href="">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </li>
                        <?php
                /*                    }
                                }
                                else{
                                    echo 'No Social link Add Yet';
                                }
                                */ ?>

            </ul>

-->
                <!-- <ul class="widget-todo-list">
                <?php
                /*                if(!empty($user)){
                                    {

                                        */ ?>
                        <li>
                            <div class="checkbox-custom checkbox-default">
                                <label class="todo-label" for="<? /*= $user['user_enc_id']; */ ?>">
                                    <span><? /*= $user['youtube']; */ ?></span>


                                </label>
                            </div>

                            <div class="todo-actions" id="<? /*= $user['user_enc_id']; */ ?>">
                                <a class="todo-remove" href="">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </li>
                        <?php
                /*                    }
                                }
                                else{
                                    echo 'No Social link Add Yet';
                                }
                                */ ?>

            </ul>
-->
                <!-- <ul class="widget-todo-list">
                <?php
                /*                if(!empty($user)){
                                    {

                                        */ ?>
                        <li>
                            <div class="checkbox-custom checkbox-default">
                                <label class="todo-label" for="<? /*= $user['user_enc_id']; */ ?>">
                                    <span><? /*= $user['skype']; */ ?></span>


                                </label>
                            </div>

                            <div class="todo-actions" id="<? /*= $user['user_enc_id']; */ ?>">
                                <a class="todo-remove" href="">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </li>
                        <?php
                /*                    }
                                }
                                else{
                                    echo 'No Social link Add Yet';
                                }
                                */ ?>

            </ul>



-->


                <!--  </div>
                  <div class="col-md-4 col-sm-4">

                      <button type="button" class="btn btn-info btn-lg open-modal" data-toggle="modal" data-target="#myModal">Social Links</button>

                          <!-- Modal -->
                <!--  <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                          <!-- Modal content-->
                <!-- <div class="modal-content">
                     <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                         <h4 class="modal-title">Social Links</h4>
                     </div>
                     <div class="modal-body">-->
                <?php /*$form = ActiveForm::begin(['id'=>'social-links']); */ ?>

                <? /*= $form->field($sociallinks, 'facebook')->textInput(['value' => $user['facebook']]) */ ?>

                <? /*= $form->field($sociallinks, 'instagram')->textInput(['value' => $user['instagram']]) */ ?>

                <? /*= $form->field($sociallinks, 'linkedin')->textInput(['value' => $user['linkedin']]) */ ?>
                <? /*= $form->field($sociallinks,'google')->textInput(['value' => $user['google']]) */ ?>
                <? /*= $form->field($sociallinks,'twitter')->textInput(['value' => $user['twitter']]) */ ?>
                <? /*=  $form->field($sociallinks,'youtube')->textInput(['value' => $user['youtube']])*/ ?>
                <? /*= $form->field($sociallinks,'skype')->textInput(['value' => $user['skype']]) */ ?>


                <!-- --><?php /*/*ActiveForm::end(); */ ?><!--


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
                                <? /*= Html::submitButton('Save', ['class' => 'btn btn-success btn-md socialsave' ]); */ ?>

                            </div>
                        </div>

                    </div>


                </div>
        </div>
    </div>
-->


                <div class="row bg-lighter shadow round  working">

                    <div class="col-md-12 col-sm-12">
                        <h4>
                            <icon class="fa fa-graduation-cap"></icon>
                            Skills
                        </h4>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pf-field no-margin">
                                    <?php
                                    Pjax::begin([
                                        'id' => 'pjax_skills',
                                    ]);
                                    ?>
                                    <ul class="tags skill_tag_list">
                                        <?php

                                        if (!empty($skills)) {
                                            foreach ($skills as $skill) { ?>
                                                <li class="addedTag"><?= $skill['skill'] ?>
                                                    <span id="<?= $skill['user_skill_enc_id'] ?>"
                                                          class="skill_remove">x</span>
                                                </li>
                                            <?php }
                                        }
                                        ?>
                                        <li class="tagAdd taglist">
                                            <div class="skill_wrapper">
                                                <input type="text" id="skill_input"
                                                       class="skill_search input_search"
                                                       placeholder="skills">
                                            </div>
                                        </li>
                                    </ul>
                                    <?php
                                    Pjax::end();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!--<div class="row bg-lighter shadow round working">
                <div class="col-md-8 col-sm-8">
                    <h4>
                        <icon class="fa fa-graduation-cap"></icon> Projects List
                    </h4>
                </div>
                <div class="col-md-4 col-sm-4">


                    <div class="modal fade" id="projects" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel3">Add Projects</h4>
                                </div>
                                <div class="modal-body">
                                    <?php
                /*                                    $form = ActiveForm::begin(['id' => 'form-projects', 'class' => 'form-body',
                                                                'options' => ['enctype' => 'multipart/form-data'],
                                                                'fieldConfig' => [
                                                                    'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{error}{hint}</div>"
                                                                ],
                                                    ]);
                                                    */ ?>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <? /*= $form->field($ResumeProject, 'project_name')->label('Project Name') */ ?>
                                        </div>

                                        <div class="col-sm-4">
                                            <? /*= $form->field($ResumeProject, 'project_start_date')->widget(DatePicker::classname())->label('Start Date'); */ ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <? /*= $form->field($ResumeProject, 'project_end_date')->widget(DatePicker::classname())->label('End Date'); */ ?>
                                        </div>
                                        <div class="col-sm-12">
                                            <? /*= $form->field($ResumeProject, 'project_associate')->label('Project Associate') */ ?>
                                        </div>
                                        <div class="col-sm-12">
                                            <? /*= $form->field($ResumeProject, 'project_url')->label('Project URL') */ ?>
                                        </div>
                                        <div class="col-sm-12">
                                            <? /*= $form->field($ResumeProject, 'project_desc')->label('Project Description') */ ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
                                    <? /*= Html::submitButton('Save', ['class' => 'btn btn-success btn-md ']); */ ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php /*ActiveForm::end(); */ ?>
                    <button class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#projects">
                        <icon class="fa fa-plus"></icon>
                        Add Projects
                    </button>
                </div>
            </div> -->


                <div class="row bg-lighter shadow round working">
                    <div class="col-md-12 col-sm-12">
                        <h4>
                            <icon class="fa fa-graduation-cap"></icon>
                            Achievements
                        </h4>

                        <hr>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pf-field no-margin">
                                    <?php
                                    Pjax::begin([
                                        'id' => 'pjax_achievements',
                                    ]);
                                    ?>
                                    <ul class="tags skill_tag_list">
                                        <?php

                                        if (!empty($achievements)) {
                                            foreach ($achievements as $achievement) { ?>
                                                <li class="addedTag"><?= $achievement['achievement'] ?>
                                                    <span id="<?= $achievement['user_achievement_enc_id'] ?>"
                                                          class="achievement_remove">x</span>
                                                </li>
                                            <?php }
                                        }
                                        ?>
                                        <li class="tagAdd taglist">
                                            <div class="skill_wrapper">
                                                <input type="text" id="achievement_input"
                                                       class="achievement_search input_search"
                                                       placeholder="Achievements">
                                            </div>
                                        </li>
                                    </ul>
                                    <?php
                                    Pjax::end();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row bg-lighter shadow round working">
                    <div class="col-md-12 col-sm-12">
                        <h4>
                            <icon class="fa fa-graduation-cap"></icon>
                            Hobbies
                        </h4>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pf-field no-margin">
                                    <?php
                                    Pjax::begin([
                                        'id' => 'pjax_hobby',
                                    ]);
                                    ?>
                                    <ul class="tags skill_tag_list">
                                        <?php

                                        if (!empty($hobbies)) {
                                            foreach ($hobbies as $hobby) { ?>
                                                <li class="addedTag"><?= $hobby['hobby'] ?>
                                                    <span id="<?= $hobby['user_hobby_enc_id'] ?>"
                                                          class="hobby_remove">x</span>
                                                </li>
                                            <?php }
                                        }
                                        ?>
                                        <li class="tagAdd taglist">
                                            <div class="skill_wrapper">
                                                <input type="text" id="hobby_input" class="hobby_search input_search"
                                                       placeholder="Hobbies">
                                            </div>
                                        </li>
                                    </ul>
                                    <?php
                                    Pjax::end();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row bg-lighter shadow round working">
                    <div class="col-md-12 col-sm-12">
                        <h4>
                            <icon class="fa fa-graduation-cap"></icon>
                            Interests
                        </h4>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pf-field no-margin">
                                    <?php
                                    Pjax::begin([
                                        'id' => 'pjax_interest',
                                    ]);
                                    ?>
                                    <ul class="tags skill_tag_list">
                                        <?php

                                        if (!empty($interests)) {
                                            foreach ($interests as $interest) { ?>
                                                <li class="addedTag"><?= $interest['interest'] ?>
                                                    <span id="<?= $interest['user_interest_enc_id'] ?>"
                                                          class="interest_remove">x</span>
                                                </li>
                                            <?php }
                                        }
                                        ?>
                                        <li class="tagAdd taglist">
                                            <div class="skill_wrapper">
                                                <input type="text" id="interest_input"
                                                       class="interest_search input_search" placeholder="interest">
                                            </div>
                                        </li>
                                    </ul>
                                    <?php
                                    Pjax::end();
                                    ?>
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
    <section>
        <div class="row" style="margin-top: 40px;">
            <!--        <div class="col-md-offset-1 col-md-2">-->
            <!--            <div class="rounded-experience-period experience-title">-->
            <!--                <i class="fa fa-briefcase"></i>-->
            <!--            </div>-->
        </div>
        <!--        <div class="col-md-8">-->
        <!--            <div class="experience-detail">-->
        <!--                <h2>Work Experience</h2>-->
        <!--                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio repudiandae, sit quo.</p>-->
        <!--            </div>-->
        <!--        </div>-->
        </div>

    </section>
    <div class="loader-aj-main">
        <div class="loader-aj">
            <div class="dot first"></div>
            <div class="dot second"></div>
        </div>
    </div>
    <input type="hidden" id="skill_id">
    <script>

    </script>
<?php
$script = <<< JS

function floatingLabel() {
   $('.form-md-floating-label .form-control').each(function(){
       if ($(this).val().length > 0) {
           $(this).addClass('edited');
       } else{
           $(this).removeClass('edited');
       }
   });
}
$(document).on('click','.exp-pen, .edu-pen, #addEdu, #addExp',function(e){
    setTimeout(function(){
      floatingLabel();}
      ,1000
  );
});

var image_path = $('#img_id').attr('src');
var profile_name_path = "$no_image";
        
        
        
    var about = $('#resumeaboutme-about_me').val();
    var contact = $('#contact_mobile').val();
    var email =   $('#contact_email').val();
    var address = $('#contact_address').val();
    var preference = $('#Preference').val();
    var gender = $('#resumeotherinfo-gender option:selected').text();
    $('#preference_label').html(preference);
    $('#gender_label').html(gender);
    $('#about_me').html(about);


    $('#contact_label').html(contact);
    $('#email_label').html(email);
    $('#address_label').html(address);
     
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img_id').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#profile_pic").change(function () {
        readURL(this);
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
     $('#skill_id').val(suggestion.skill);
     
});
        
$(document).on('click', '.remove-image', function(a) {
    a.preventDefault();
    $('#pop-content1_2').fadeIn(1000);
});

$(document).on('click', '#cancel_remove', function() {
    $('#pop-content1_2').fadeOut(1000);
});
        
$('#img_id').on('load', function () {
    if($("#img_id").attr('src') != image_path && $("#img_id").attr('src') != profile_name_path){
        console.log(1);
        $('#pop-content').fadeIn(1000);
   }
});
        
$(document).on('click', '#cancel_image', function() {
    $('#pop-content').fadeOut(1000);
    $('#img_id').attr('src', image_path);
});
        
$(document).on('submit', '#form-profile', function(event) {
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
        $('.loader-aj-main').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
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
                $('#img_id').attr('src',profile_name_path);
            } else {
                toastr.error(response.message, response.title);
            }
        }
    });
});
        
$(document).on('submit', '#form-description', function (event) {
    event.preventDefault();
    var des_method = $(this).attr('method');
    var des_url = $(this).attr('action');
    var des_data = $('#description-value').val();
    var before = function () {
        $('.loader-aj-main').fadeIn(1000);
    };
    var req = function () {
        var result = ajax(des_method, des_url, {des_data:des_data});
        var resp = result["responseJSON"];
        $('.loader-aj-main').fadeOut(1000);
        if (resp.status == 200) {
            $('#about_me_modal').modal('hide');
//            $("#description-value").val(des_data);
            toastr.success(resp.message, resp.title);
            $.pjax.reload({container: '#pjax_des', async: false});
        } else {
            toastr.error(resp.message, resp.title);
        }
    }
    order(before, req);
});

function order(before, req) {
    before();
    req();
}
        
$(document).on('submit', '#form-contact-info', function (event) {
    event.preventDefault();
    var info_method = $(this).attr('method');
    var info_url = $(this).attr('action');
    var data = $(this).serialize();
//    var info_address = $('#contact_address').val();
//    var info_state = $('#contact_state').val();
//    var info_city = $('#contact_city').val();
    var before = function () {
        $('.loader-aj-main').fadeIn(1000);
    };
    var req = function () {
//        var result = ajax(info_method, info_url, {info_address:info_address, info_state:info_state, info_city:info_city});
        var result = ajax(info_method, info_url, data);
        var resp = result["responseJSON"];
        $('.loader-aj-main').fadeOut(1000);
        if (resp.status == 200) {
            $('#contact_me_modal').modal('hide');
            toastr.success(resp.message, resp.title);
            $.pjax.reload({container: '#pjax_contact_info', async: false});
        } else {
            toastr.error(resp.message, resp.title);
        }
    }
    order(before, req);
});

    $('#exp_present').click(function(){
        if (this.checked) {
            $(this).val('1');
            $('.experience').hide();
        }else{
            $(this).val('0');
            $('.experience').show();
            $('#addexperienceform-exp_to').val('');
        }
    }) ;
    
    $('#update_exp_present').click(function(){
        if (this.checked) {
            $(this).val('1');
            $('.update_experience').hide();
        }else{
            $(this).val('0');
            $('.update_experience').show();
            $('#update_exp_to').val('');
            $('#update_exp_to').focus();
        }
    }) ;
    
    $(document).on('submit','#add-experience-form',function(e){
    e.preventDefault();
        var title = $('#addexperienceform-title').val();
        var company = $('#addexperienceform-company').val();
        var city = $('#city_id_exp').val();
       
        var from = $('#addexperienceform-exp_from').val();
        if($('#exp_present').prop("checked")){
                var checkbox = 1;
                $('#addexperienceform-exp_to').val('');
            }else{
                var checkbox = 0;
                if($('#addexperienceform-exp_to').val() == ''){
                     return false;
                }else{
                    var to = $('#addexperienceform-exp_to').val();
                }
            }
        var description = $('#addexperienceform-description').val();
        $.ajax({
           url: '/account/resume-builder/experience',
           method: 'POST',
           data : {title:title,company:company,city:city,from:from,to:to,checkbox:checkbox,description:description},
            beforeSend:function(){     
                      $('.loader-aj-main').fadeIn(1000);  
                },
           success : function(response){
               $('.loader-aj-main').fadeOut(1000);
               var res = JSON.parse(response);
               if(res.status == 200)
               {
                   toastr.success(res.message, res.title);
                   $('#add-experience-modal').modal('toggle');
                   $.pjax.reload({container: '#pjax_experience', async: false});
               } else {
                   toastr.error('something went wrong.Try Again', 'error');
               }
            }
        });
    });
    
    
    $(document).on('click','.certificatesave',function(e)
    {
        e.preventDefault();
        var certificate = $('#resumecertificates-certificates').val();
        //console.log(certificate);
        $.ajax({
            
            url:'/acount/resume/certificate',
            method:'POST',
            data:{certificate:certificate},
            success:function(res)
            {
                console.log(res);
            }
        });
    });
        
        
        $(document).on('click','.socialsave',function(e)
        {
            e.preventDefault();
          
            
            var data = $('#social-links').serialize();
            
            $.ajax({
                url:'/account/resume-builder/social',
                method: 'POST',
                data : data,
                beforeSend:function(){
                   $('.socialsave').prop('disabled','disabled');
                   $('.socialsave').html('<i class="fa fa-spinner" aria-hidden="true"></i>');
                 },
                success:function(res)
                
                {
                    if(res==true)
                    {
                         $('.socialsave').prop('disabled',false);
                        
                         $('#myModal').modal('toggle');
                         $('.socialsave').html('save');
                     }
                     else
                     {
                         alert('data not update');
                     }
                     
                }
                
            });
            
        });
        
        
        $(document).on('keyup','#achievement_input',function(e)
        {   
        e.preventDefault();
        if(e.which==13){
        var achievement_name = $('#achievement_input').val();
        if(achievement_name == ''){
            toastr.error('please enter something', 'error');
        }else {
        $.ajax({
            url: '/account/resume-builder/achievements',
            method : 'POST',
            data : {achievement_name:achievement_name},
            beforeSend:function(){     
                      $('.loader-aj-main').fadeIn(1000);  
                },
            success : function(response)
            {
                $('.loader-aj-main').fadeOut(1000);
                 var res = JSON.parse(response);
                 if(res.status == 200){
                     $('#achievement_input').val('');
                    $.pjax.reload({container: '#pjax_achievements', async: false});
                 }
                 else if(res.status == 201){
                     toastr.error(res.message, res.title);
                 }
                 else if(res.status == 203){
                     toastr.error(res.message, res.title);
                 }
                 
            } 
            });
          }
        }
        });
        
        
        $(document).on('click','.achievement_remove', function(e) {
            e.preventDefault();
            var tag_main = $(this).parent();
            tag_main.hide();
                var id = e.target.id;
            $.ajax({
                url: "/account/resume-builder/achievement-remove",
                method: "POST",
                data: {id:id},
               
                success: function (response) {
                    var data = JSON.parse(response);
                    if(data.status == 200){
                        $.pjax.reload({container: '#pjax_achievements', async: false});
                    }else{
                        tag_main.show();
                        toastr.error(data.message, data.title);
                    }
                }
            });
        });
        
        $(document).on('keyup','#hobby_input',function(e)
        {   
        e.preventDefault();
        if(e.which==13){
        var hobby_name = $('#hobby_input').val();
        
        if(hobby_name == ''){
            toastr.error('please enter something', 'error');
        }else {        
        $.ajax({
            url: '/account/resume-builder/hobbies',
            method : 'POST',
            data : {hobby_name:hobby_name},
            beforeSend:function(){     
                      $('.loader-aj-main').fadeIn(1000);  
                },
            success : function(response)
            {
                $('.loader-aj-main').fadeOut(1000);
                 var res = JSON.parse(response);
                 if(res.status == 200){
                     $('#hobby_input').val('');
                    $.pjax.reload({container: '#pjax_hobby', async: false});
                 }
                 else if(res.status == 201){
                     toastr.error(res.message, res.title);
                 }
                 else if(res.status == 203){
                     toastr.error(res.message, res.title);
                 }
                 
            } 
            });
          }
        }
        });
        
        
        
        $(document).on('keyup','#skill_input',function(e)
        {   
        e.preventDefault();
        if(e.which==13){
        var skill_name = $('#skill_input').val();
        
        if(skill_name == ''){
            toastr.error('please enter something', 'error');
        }else {        
        $.ajax({
            url: '/account/resume-builder/skills',
            method : 'POST',
            data : {skill_name:skill_name},
            beforeSend:function(){     
                      $('.loader-aj-main').fadeIn(1000);  
                },
            success : function(response)
            {
                $('.loader-aj-main').fadeOut(1000);
                 var res = JSON.parse(response);
                 if(res.status == 200){
                     $('#skill_input').val('');
                    $.pjax.reload({container: '#pjax_skills', async: false});
                 }
                 else if(res.status == 201){
                     toastr.error(res.message, res.title);
                 }
                 else if(res.status == 203){
                     toastr.error(res.message, res.title);
                 }
                 
            } 
            });
          }
        }
        });
        
        
        $(document).on('click','.hobby_remove', function(e) {
            e.preventDefault();
            var tag_main = $(this).parent();
            tag_main.hide();
                var id = e.target.id;
            $.ajax({
                url: "/account/resume-builder/hobby-remove",
                method: "POST",
                data: {id:id},
               
                success: function (response) {
                    var data = JSON.parse(response);
                    if(data.status == 200){
                        $.pjax.reload({container: '#pjax_hobby', async: false});
                    }else{
                        tag_main.show();
                        toastr.error(data.message, data.title);
                    }
                }
            });
        });
        
        $(document).on('click','.skill_remove', function(e) {
            e.preventDefault();
            var tag_main = $(this).parent('li');
            tag_main.hide();
                var id = e.target.id;
            $.ajax({
                url: "/account/resume-builder/skill-remove",
                method: "POST",
                data: {id:id},
                
                success: function (response) {
                    var data = JSON.parse(response);
                    if(data.status == 200){
                        $.pjax.reload({container: '#pjax_skills', async: false});
                    }else{
                        tag_main.show();
                        toastr.error(data.message, data.title);
                    }
                }
            });
        });
        
        
        
        $(document).on('keyup','#interest_input',function(e)
        {   
        e.preventDefault();
        if(e.which==13){
        var interest_name = $('#interest_input').val();
        
        if(interest_name == ''){
            toastr.error('please enter something', 'error');
        }else {        
        $.ajax({
            url: '/account/resume-builder/interests',
            method : 'POST',
            data : {interest_name:interest_name},
            beforeSend:function(){     
                      $('.loader-aj-main').fadeIn(1000);  
                },
            success : function(response)
            {
                $('.loader-aj-main').fadeOut(1000);
                 var res = JSON.parse(response);
                 if(res.status == 200){
                     $('#interest_input').val('');
                    $.pjax.reload({container: '#pjax_interest', async: false});
                 }
                 else if(res.status == 201){
                     toastr.error(res.message, res.title);
                 }
                 else if(res.status == 203){
                     toastr.error(res.message, res.title);
                 }
                 
            } 
            });
        }
        
        }
        });
        
        
        $(document).on('click','.interest_remove', function(e) {
            e.preventDefault();
            var tag_main = $(this).parent();
            tag_main.hide();
                var id = e.target.id;
            $.ajax({
                url: "/account/resume-builder/interest-remove",
                method: "POST",
                data: {id:id},
                
                success: function (response) {
                    var data = JSON.parse(response);
                    if(data.status == 200){
                        $.pjax.reload({container: '#pjax_interest', async: false});
                    }else{
                        tag_main.show();
                        toastr.error(data.message, data.title);
                    }
                }
            });
        });
        
        
        $(document).on('submit','#add-education-form',function(e)
        {   
        e.preventDefault();
        var data = $('#add-education-form').serialize();
        $.ajax({
            url: '/account/resume-builder/education',
            method : 'POST',
            data : data,
            beforeSend:function(){     
                      $('.loader-aj-main').fadeIn(1000);
            },
            success : function(res)
            {
                $('.loader-aj-main').fadeOut(1000);
                 if(res == true){
                    $('#add-education-modal').modal('toggle');
                    $.pjax.reload({container: '#pjax_qualification', async: false});
                }else{
                     toastr.error('something went wrong.Try Again', 'error');
                }
            } 
            });
        
        });
        
        $(document).on('submit','#update-education-form',function(e)
        {   
        e.preventDefault();
        var id = $('.eduUpdate').attr('id');
        var school = $('#update_school').val();
        var degree = $('#update_degree').val();
        var field = $('#update_field').val();
        var from = $('#update_qualification_from').val();
        var to = $('#update_qualification_to').val();
        $.ajax({
            url: '/account/resume-builder/update-education',
            method : 'POST',
            data : {school:school,degree:degree,field:field,from:from,to:to,id:id},
            beforeSend:function(){     
                      $('.loader-aj-main').fadeIn(1000);
            },
            success : function(res)
            {
                $('.loader-aj-main').fadeOut(1000);
                 if(res==true){
                    $('#update-education-modal').modal('toggle');
                    $.pjax.reload({container: '#pjax_qualification', async: false});
                }
            } 
            });
        
        });
        
        
        $(document).on('submit','#update-experience-form',function(e)
        {
            e.preventDefault();
           
            var id = $('.expUpdate').attr('id');
            var title = $('#update_exp_title').val();
            var company = $('#update_exp_company').val();
            var city = $('#update_city_id_exp').val();
            var from = $('#update_exp_from').val();
            if($('#update_exp_present').prop("checked")){
                var checkbox = 1;
                $('#update_exp_to').val('');
            }else{
                var checkbox = 0;
                if($('#update_exp_to').val() == ''){
                     return false;
                }else{
                    var to = $('#update_exp_to').val();
                }
            }
            var description = $('#update_description').val();
            
             $.ajax({
            url: '/account/resume-builder/update-experience',
            method : 'POST',
            data: {id:id,title:title,company:company,city:city,from:from,to:to,check:checkbox,description:description},
            beforeSend:function(){     
                      $('.loader-aj-main').fadeIn(1000);
            },
            success:function(res)
            {
                $('.loader-aj-main').fadeOut(1000);
                if(res==true){
                    $('#update-experience-modal').modal('toggle');
                    $.pjax.reload({container: '#pjax_experience', async: false});
                }else {
                  toastr.error('An error occured.try again', 'error');  
                }
            }
            });
        });
        
        
        $(document).on('click', '.edu-pen', function(a) {
            a.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
            url: '/account/resume-builder/edit-education',
            method : 'POST',
            data : {id:id},
            beforeSend:function(){
                    $('.loader-aj-main').fadeIn(100);
                 },
            success : function(res)
            {   
                 $('.loader-aj-main').fadeOut(50);
                $('#update-education-modal').modal('show');
                var obj = JSON.parse(res);
                $('#update_school').val(obj.institute);
                $('#update_degree').val(obj.degree);
                $('#update_field').val(obj.field);
                $('#update_qualification_from').val(obj.from_date);
                $('#update_qualification_to').val(obj.to_date);
                $('.eduUpdate').attr('id',obj.education_enc_id);
            } 
            });
        });
        
        
        $(document).on('click','.exp-del',function(e){
           e.preventDefault();
           
           var  id = $(this).attr('id');
           
           $.ajax({
                url: '/account/resume-builder/delete-experience',
                 method : 'POST',
                 data : {id:id},
                 beforeSend:function(){
                    $('.loader-aj-main').fadeIn(100);
                 },
                  success : function(response)
                  {
                      $('.loader-aj-main').fadeOut(50);
                      var res = JSON.parse(response);
                      
                      if(res.status == 200){
                          $.pjax.reload({container: '#pjax_experience', async: false});
                      }else if(res.status == 201){
                          toastr.error(res.message, res.title);
                      }
                      
                  }
            });
        });
        
        $(document).on('click','.edu-del',function(e){
           e.preventDefault();
           
           var  id = $(this).attr('id');
           
           $.ajax({
                url: '/account/resume-builder/delete-education',
                 method : 'POST',
                 data : {id:id},
                 beforeSend:function(){
                    $('.loader-aj-main').fadeIn(100);
                 },
                  success : function(response)
                  {
                      $('.loader-aj-main').fadeOut(50);
                      var res = JSON.parse(response);
                      
                      if(res.status == 200){
                          $.pjax.reload({container: '#pjax_qualification', async: false});
                      }else if(res.status == 201){
                          toastr.error(res.message, res.title);
                      }
                      
                  }
            });
        });
        
        $(document).on('click','.exp-pen',function(e)
        {
            e.preventDefault();
            
            var id = $(this).attr('id');
            $.ajax({
                url: '/account/resume-builder/edit-experience',
                 method : 'POST',
                 data : {id:id},
                 beforeSend:function(){
                    $('.loader-aj-main').fadeIn(100);
                 },
                  success : function(res)
                  {
                      $('.loader-aj-main').fadeOut(50);
                      $('#update-experience-modal').modal('show');
                      var obj = JSON.parse(res);
                      $('#update_exp_title').val(obj.title);
                      $('#update_exp_company').val(obj.company);
                      $('#update_city_id_exp').val(obj.city_enc_id);
                      $('#update_cities').val(obj.name);
                      $('#update_exp_from').val(obj.from_date);
                      $('#update_exp_to').val(obj.to_date);
                      if(obj.is_current == 1){
                          $('#update_exp_present').prop('checked', true);
                          $('.update_experience').hide();
                      }
                      $('#update_description').val(obj.description );
                      $('.expUpdate').attr('id',obj.experience_enc_id);
                  }
            });
        });
        
        $(document).on('click','#addEdu',function(e)
        {   
            e.preventDefault();
            $('#add-education-modal').modal('toggle');
            $('#addqualificationform-school').val('');
            $('#addqualificationform-degree').val('');
            $('#addqualificationform-field').val('');
            $('#addqualificationform-qualification_from').val('');
            $('#addqualificationform-qualification_to').val('');
        });
        
        $(document).on('click','#addExp',function(event)
        {
            event.preventDefault();
            $('#add-experience-modal').modal('toggle');
            
             $('#addexperienceform-title').val('');
             $('#addexperienceform-company').val('');
             $('#city_id_exp').val('');
             $('#cities').val('');
             $('#addexperienceform-exp_from').val('');
            $('#addexperienceform-exp_to').val('');
            if($('#exp_present').prop("checked")){
                $('#exp_present').prop('checked', false);
                $('.experience').show();
            }
             $('#addexperienceform-description').val('');
            
        });
        
        
        
        $(document).on('click', '.todo-remove', function(e) {
            e.preventDefault();
                var id = $(this).closest('.todo-actions').attr('id');
                var remove = $(this).closest('li');
            $.ajax({
                url: "/account/resume-builder/skillrmv",
                method: "POST",
                data: {id:id},
                success: function (response) {
                    $(remove).remove();
                }
            });
        });
        
        $(document).on('click', '.open-modal', function(){
            var data;
            $.ajax({
                url : '/account/resume-builder/get-social',
                method : 'POST',
                data : data ,
                success : function(res){
                    console.log(res);
                } 
            });
        });
        
        
        
        
// $(document).on('submit', '#add-education-form', function(event) {
//     event.preventDefault();
//     var education_method = $(this).attr('method');
//     var education_url = $(this).attr('action');
//     var education_data = $(this).serialize();
//     var before = function(){     
//         $('.loader-aj-main').fadeIn(1000);  
//     };
//     var req = function(){
//         var result = ajax(education_method, education_url, education_data);
//         var resp = result["responseJSON"];
//         $('.loader-aj-main').fadeOut(1000);
//         if(resp.status == 200){
//             toastr.success(resp.message, resp.title);
//             $("#add-education-form")[0].reset();
//             $.pjax.reload({container: '#pjax_qualification', async: false});
//             $('#add-education-modal').modal('hide');
//         }else{
//             toastr.error(resp.message, resp.title);
//         }
//     }
//     order(before, req);
// });
// $(document).on('submit', '#add-experience-form', function(event) {
//     event.preventDefault();
//     var experience_method = $(this).attr('method');
//     var experience_url = $(this).attr('action');
//     var experience_data = $(this).serialize();
//     var before = function(){     
//         $('.loader-aj-main').fadeIn(1000);  
//     };
//     var req = function(){
//         var result = ajax(experience_method, experience_url, experience_data);
//         var resp = result["responseJSON"];
//         $('.loader-aj-main').fadeOut(1000);
//         if(resp.status == 200){
//             toastr.success(resp.message, resp.title);
//             $("#add-experience-form")[0].reset();
//             $.pjax.reload({container: '#pjax_experience', async: false});
//             $('#add-experience-modal').modal('hide');
//         }else{
//             toastr.error(resp.message, resp.title);
//         }
//     }
//     order(before, req);
// });
        
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
            
$('#contact_city').typeahead(null, {
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
        $('#city_id_exp').val(datum.id);
     });

$('#update_cities').typeahead(null, {
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
        $('#update_city_id_exp').val(datum.id);
     });

JS;
$this->registerJs($script);
$this->registerCss("
ul.widget-todo-list {
    list-style: none;
    padding: 0 20px;
    margin: 0;
    position: relative;
    height: 300px;
    display: block;
    overflow-x: scroll;
}
ul.widget-todo-list li {
    border-bottom: 1px dotted #ddd;
    padding: 15px 15px 15px 0;
    position: relative;
}
.checkbox-custom label {
    cursor: pointer;
    margin-bottom: 0;
    text-align: left;
    line-height: 1.5;
}
ul.widget-todo-list li .todo-actions  {
    position: absolute;
    top: 14px;
    right: 0;
    bottom: 14px;
}
ul.widget-todo-list li .todo-actions .todo-remove  {
    font-size: 10px;
    vertical-align: middle;
    color: #999;
}


ul.widget-todo-list li label.line-through span {
    text-decoration: line-through;
}

//ricky/

.round{
    border-radius: 10px;
}
.working{
    padding: 20px 0px !important;
    margin-bottom: 15px;
    margin-top:8px;
    background-color:#FFF;
   
}
.working .col-md-8{
     color: black;
}
.working .col-md-4 .btn-primary{
    font-size: 15px ;
    padding: 12px 15px 10px !important;
}
.round-info-upper{
    border-radius: 10px 10px 0px 0px;
    background: orange;
}
.bg-theme-colored{
    border-radius: 10px;
    background-color:#FFF;
    margin-bottom:10px;
}
.round-info-lower{
    border:1px;
    border-radius: 10px 10px 10px 10px;
    box-shadow: 0 1px 3px 0px #797979;
    margin:5px 0px;
    background-color:#fff;
}
.info{
    background:#f9f9f9;
}
.shadow{
    box-shadow: 0 1px 3px 0px #797979;
}
#school_info{
    display:none;
}
#h{
    display:none;
}
.active{
    color:white !important;
}
.change-pic{
    position:absolute;
    top:0;
    right:0;
    height:22px;
    background-color:#DDD;
    border-radius:0px 6px;
}
.change-pic label{
    background-color:#DDD;
    border-radius: 0px 6px;
    padding: 4px 10px 5px !important;
}
.label {
   cursor: pointer;
   color:#000;
}
#profile_pic {
   opacity: 0;
   position: absolute;
   z-index: -1;
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

.rounded-experience-period{
    width: 150px;
    height: 150px;
    border-radius: 100%;
    background-color: #4aa1e3;
    text-align: center;
    color: #fff;
    margin: auto;
    margin-top: 20px;
    line-height: 20px;
    padding: 30px 0px;
    font-weight: 700;
    display: table-cell;
    vertical-align: middle;
    background: rgba(0,0,0,0) -webkit-linear-gradient(left,#00c6ff,#0072ff);
    background: rgba(0,0,0,0) linear-gradient(to right,#00c6ff,#0072ff);
    box-shadow: 2px 2px 6px #333;
}
.experience-title{
    font-size: 58px;
    line-height: 125px;
    padding:0px;
}
//.experience-detail{
//    margin-top:20px;
//}
.experience-detail h2{
    font-weight: 500;
    margin-top: 20px;
    color: #222;
    text-transform: uppercase;
}
.experience-detail h4{
    font-weight:700;
}
h4.colored{
    color:#4aa1e3;
}
.experience-detail p{
    color:#777;
    margin:0px;
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
    box-shadow:0px 1px 4px 1px rgba(0, 0, 0, 0.12);
    cursor: pointer;
    font-weight: normal;
    transition: all 0.2s ease-in-out;
}
.avatar-edit input {
  display: none;
}
.avatar-edit:hover {
  background: #f1f1f1;
  border-color: #d6d6d6;
}
.profile-label{
    display: block;
    text-align: left;
    box-shadow: none;
    margin: 0px;
    font-size: 14px;
    font-weight: normal;
    color: #6f6f6f;
    padding: 0;
}
.dropdown-menu{
    padding:0px;
}
.dropdown-menu li a .form-group{
    margin-bottom:0px;
}
.dropdown-menu li a{
    line-height: 28px;
    border-bottom: 1px solid #eee;
}
.dropdown-menu li a:hover, .dropdown-menu li a:hover label{
    background-color: #4aa1e3;
    color: #fff;
    border-color:transparent;
}
.dropdown-menu li a label{
    font-weight:normal;
    font-size:14px;
    margin:0px;
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
    z-index:9;
}
.hiden:before{
    content: '';
    left: 34%;
    top: -14px;
    position: absolute;
    border-left: 10px solid transparent;
    border-bottom: 15px solid #f9f9f9;
    border-right: 10px solid transparent;
}
.round #img_id{
    border-radius: 10px;
}
.round:first-child{
    padding:0px;
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
.edu-pen{
    right:10px;
    top:0;
}

.edu-del{
    right:10px;
    top:0;
}

.exp-pen
{
top:0;
}

.exp-del
{
top:0;
}


.gradient_line{ 
    margin: 0 0 20px 0;
    display: block;
    border: none;
    height: 1px;
    background: #4aa1e3;
    background: linear-gradient(to right, white, #4aa1e3, white);
}

@media screen and (min-width: 480px) {
  .experiences{
    text-align:left;
  }
}

@media screen and (min-width: 480px) {
  .edu-pen{
    right:90px;
    top:0;
    }
    
  .edu-del{
    right:40px;
    top:0;
    }  
}


@media screen and (min-width: 480px) {
  .exp-pen{
    right:90px;
    top:0;
    }
    
  .exp-del{
    right:40px;
    top:0;
    }
}

.expSave
{

font-size:10px !important;
}
/*-- skills tags input css starts --*/
.tags > .addedTag{
    margin-bottom:10px;
}
.tags > .addedTag > span{
    background: #00a0e3;
}
.taglist{
    float:left !important;
}
.input_search{
    position: relative;
    vertical-align: top;
    background-color: transparent;
    padding: 15px 10px !important;
    font-size: 15px;
    border-radius: 7px;
}
.skill_wrapper{position:relative;}
.no-margin {
    margin: 0 !important;
}
.pf-field {
    float: left;
    width: 100%;
    position: relative;
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

.tags li {
    margin: 0;
}
.tags > .addedTag > span {
    position: absolute;
    right: -6px;
    top: -5px;
    width: 16px;
    height: 16px;
    font-style: normal;
    background: #00a0e3;
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
    border: 1px solid #e8ecec !important;
    height: 19px;
    margin: 5px 0;
    margin-left: 15px;
    font-size: 12px;
    font-weight: 400;
}
ul.tags.skill_tag_list {
    list-style: outside none none;
    margin: 0 0 30px;
}
/*-- skills tags input css starts --*/
.has-error .form-group .help-block.help-block-error{
    opacity: 1 !important;
    color: #e73d4a !important;
    filter: alpha(opacity=100);
}
");
$this->registerCssFile("@root/assets/themes/jobhunt/css/icons.css");
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
