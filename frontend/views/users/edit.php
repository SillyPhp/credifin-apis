<?php

use yii\helpers\Html;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

$this->title = Yii::t('frontend', 'My Profile');
$this->params['header_dark'] = true;
$states = ArrayHelper::map($statesModel->find()->select(['state_enc_id', 'name'])->where(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMoGM2K3loZz09'])->orderBy(['name' => SORT_ASC])->asArray()->all(), 'state_enc_id', 'name');
?>
    <div class="wrapper-bg">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="padding-left set-overlay">
                    <?= $this->render("@common/widgets/candidate-actions-navbar");?>
                    <?php Pjax::begin(['id' => 'profile_icon_pjax']) ?>
                    <?php $form = ActiveForm::begin(['id' => 'userProfilePicture', 'action' => '/users/update-profile-picture']) ?>
                    <div class="profile-title" id="mp">
                        <h3>My Profile</h3>
                        <a class="view_profile_btn pull-right" href="javascript:;" target="_blank">
                            View Profile
                        </a>
                        <div class="upload-img-bar">
                            <span>
                            <?php if (!empty(Yii::$app->user->identity->image)) {
                                $image = Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image; ?>
                                <img src="<?= $image ?>" class="preview_img" alt="" width="200" height="150">
                            <?php } else {
                                $first = Yii::$app->user->identity->first_name;
                                $last = Yii::$app->user->identity->last_name;
                                $name = strtoupper($first[0] . '' . $last[0]);
                                $color = ltrim(Yii::$app->user->identity->initials_color, '#');
                                $image = "https://dummyimage.com/150x150/{$color}/fafafa&text={$name}";
                                ?>
                                <img src="<?= $image ?>" class="preview_img" alt="" width="200" height="150">
                            <?php } ?>
                            <label class="tg-fileuploadlabel" for="tg-photogallery">
                                <span><i class="fas fa-pencil-alt"></i> </span>
                                <?= $form->field($userProfilePicture, 'profile_image', ['template' => '{input}{error}', 'options' => []])->fileInput(['id' => 'tg-photogallery', 'class' => 'tg-fileinput', 'accept' => 'image/*'])->label(false) ?>
                            </label>
                            </span>
                            <div class="upload-info">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <?php
                                        $uname = Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name;
                                        ?>
                                        <h3 class="capitalize mt-0"><?= $uname;?></h3>
                                        <?= Html::submitButton('Update Picture', ['class' => 'btn_pink btn_submit_picture', 'id' => 'picture_submit']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <?php Pjax::end(); ?>
                    <?php $form = ActiveForm::begin(['id' => 'basicDetailForm', 'action' => '/users/update-basic-detail']) ?>
                    <div class="row">
                        <div class="profile-form-edit col-md-12">
                            <div class="row">
                                <?php $basicDetails->gender = ((Yii::$app->user->identity->gender) ? Yii::$app->user->identity->gender : ''); ?>
                                <?= $form->field($basicDetails, 'gender', ['template' => '<div class="col-lg-4"><span class="pf-title">Gender</span><div class="pf-field">{input}{error}</div></div>', 'options' => []])->dropDownList(
                                    [1 => 'Male', 2 => 'Female', 3 => 'Transgender', 4 => 'Rather not to say'], [
                                    'prompt' => 'Select Gender',
                                    'id' => 'gender_drp',
                                    'class' => 'chosen'])->label(false); ?>
                                <?php $basicDetails->category = (($getName) ? $getName['parent_enc_id'] : ''); ?>
                                <?= $form->field($basicDetails, 'category', ['template' => '<div class="col-lg-4"><span class="pf-title">Choose Job Profile</span><div class="pf-field">{input}{error}</div></div>', 'options' => []])->dropDownList(
                                    $industry, [
                                    'prompt' => 'Select Category',
                                    'id' => 'category_drp',
                                    'class' => 'chosen'])->label(false); ?>
                                <?= $form->field($basicDetails, 'job_title', ['template' => '<div class="col-lg-4"><span class="pf-title">Select Job Title</span><div class="pf-field"><div class="cat_wrapper">
                                        <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>{input}{error}</div></div></div>', 'options' => []])->textInput(['placeholder' => 'Select Job Profile', 'value' => (($getName) ? $getName['title'] : ''), 'class' => 'valid_input form-control'])->label(false) ?>
                            </div>
                            <div class="row">
                                <?= $form->field($basicDetails, 'exp_year', ['template' => '<div class="col-lg-2"><span class="pf-title">Experience(Y)</span><div class="pf-field">{input}{error}</div></div>', 'options' => []])->textInput(['placeholder' => 'Year', 'class' => 'valid_input form-control', 'maxLength' => '2', 'value' => (($getExperience) ? $getExperience[0] : '')])->label(false) ?>
                                <?= $form->field($basicDetails, 'exp_month', ['template' => '<div class="col-lg-2"><span class="pf-title">Experience(M)</span><div class="pf-field">{input}{error}</div></div>', 'options' => []])->textInput(['placeholder' => 'Month', 'class' => 'valid_input form-control', 'maxLength' => '2', 'value' => (($getExperience) ? $getExperience[1] : '')])->label(false) ?>
                                <?php $basicDetails->state = (($getCurrentCity) ? $getCurrentCity['state_enc_id'] : ''); ?>
                                <?= $form->field($basicDetails, 'state', ['template' => '<div class="col-lg-4"><span class="pf-title">Current State</span><div class="pf-field">{input}{error}</div></div>', 'options' => []])->dropDownList(
                                    $states, [
                                    'prompt' => 'Select State',
                                    'id' => 'states_drp',
                                    'class' => 'chosen',
                                    'onchange' => '
                            $("#cities_drp").empty().append($("<option>", {
                                value: "",
                                text : "Select City"
                                }));
                                $.post(
                                "' . Url::toRoute("cities/get-cities-by-state") . '",
                                {id: $(this).val(),_csrf: $("input[name=_csrf]").val()},
                                function(res){
                                if(res.status === 200) {
                                drp_down("cities_drp", res.cities);
                                }
                                }
                                );',
                                ])->label(false); ?>
                                <?=
                                $form->field($basicDetails, 'city', ['template' => '<div class="col-lg-4"><span class="pf-title">Current City</span><div class="pf-field">{input}{error}</div></div>', 'options' => []])->label(false)->dropDownList(
                                    [], [
                                    'prompt' => 'Select City',
                                    'id' => 'cities_drp',
                                    'class' => 'chosen',
                                ])->label(false);
                                ?>
                            </div>
                            <div class="row">
                                <?=
                                $form->field($basicDetails, 'dob', ['template' => '<div class="col-lg-4"><span class="pf-title">D.O.B</span><div class="pf-field">{input}{error}</div></div>', 'options' => []])->widget(DatePicker::classname(), [
                                    'options' => ['class' => 'valid_input form-control', 'placeholder' => 'Date Of Birth', 'value' => ((Yii::$app->user->identity->dob) ? date("d-M-Y", strtotime(Yii::$app->user->identity->dob)) : '')],
                                    'readonly' => true,
                                    'type' => DatePicker::TYPE_INPUT,
                                    'name' => 'dob',
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'dd-M-yyyy',
                                        'endDate' => "0d"
                                    ]])->label(false);
                                ?>
                                <div class="col-lg-8">
                                    <span class="pf-title">Pick Some Languages You Can Read,Write,Speak</span>
                                    <div class="pf-field no-margin">
                                        <ul class="tags languages_tag_list">
                                            <?php if (!empty($userLanguage)) {
                                                foreach ($userLanguage as $language) { ?>
                                                    <li class="addedTag"><?= $language['language'] ?><span
                                                                onclick="$(this).parent().remove();"
                                                                class="tagRemove">x</span><input type="hidden"
                                                                                                 name="languages[]"
                                                                                                 value="<?= $language['language'] ?>">
                                                    </li>
                                                <?php }
                                            } ?>
                                            <li class="tagAdd taglist">
                                                <div class="language_wrapper">
                                                    <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                                    <input type="text" id="search-language"
                                                           class="skill-input lang-input">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <span class="pf-title">Pick a few tags that You Have Skills</span>
                                    <div class="pf-field no-margin">
                                        <ul class="tags skill_tag_list">
                                            <?php if (!empty($userSkills)) {
                                                foreach ($userSkills as $skill) { ?>
                                                    <li class="addedTag"><?= $skill['skill'] ?><span
                                                                onclick="$(this).parent().remove();"
                                                                class="tagRemove">x</span><input type="hidden"
                                                                                                 name="skills[]"
                                                                                                 value="<?= $skill['skill'] ?>">
                                                    </li>
                                                <?php }
                                            } ?>
                                            <li class="tagAdd taglist">
                                                <div class="skill_wrapper">
                                                    <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                                    <input type="text" id="search-skill" class="skill-input">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <span class="pf-title">Availability</span>
                            <p class="remember-label">
                                <?php $basicDetails->availability = ((Yii::$app->user->identity->is_available) ? Yii::$app->user->identity->is_available : 1); ?>
                                <?= $form->field($basicDetails, 'availability')->inline()->radioList([
                                    1 => 'Available',
                                    2 => 'Open',
                                    3 => 'Actively Looking',
                                    4 => 'Exploring Possibilities',
                                    0 => 'Not Available',
                                ], [
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        $return = '<input type="radio" name="' . $name . '" value="' . $value . '" id="availability-' . $index . '" ' . (($checked) ? 'checked' : '') . '/>';
                                        $return .= '<label for="availability-' . $index . '" class="custom_label">' . $label . '</label>';
                                        return $return;
                                    }
                                ])->label(false);
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <?= $form->field($basicDetails, 'description', ['template' => '<div class="col-lg-12"><span class="pf-title">About You</span><div class="pf-field">{input}{error}</div></div>', 'options' => []])->textArea(['class' => 'perfect_scroll', 'placeholder' => 'Enter Description', 'value' => ((Yii::$app->user->identity->description) ? Yii::$app->user->identity->description : '')])->label(false) ?>
                        <?php Pjax::begin(['id' => 'pjax_resume']) ?>
                        <div class="col-md-12">
                            <?= $form->field($basicDetails, 'resume', ['template' => '<div class="file-upload-wrapper" data-text="Select your file!">{input}{error}</div>', 'options' => []])->fileInput(['id' => 'resume_upload', 'class' => 'resume_upload'])->label(false) ?>
                        </div>
                        <?php Pjax::end(); ?>
                        <div class="col-lg-12">
                            <?= Html::submitButton('Update', ['class' => 'btn_pink btn_submit_basic', 'id' => 'basic_detail_submit']); ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
                <div class="social-edit" id="sn">
                    <h3>Social Edit</h3>
                    <?php ActiveForm::begin(['id' => 'socialDetailForm', 'action' => '/users/update-social-detail']) ?>
                    <div class="row">
                        <?= $form->field($socialDetails, 'facebook', ['template' => '<div class="col-lg-6"><span class="pf-title">Facebook</span><div class="pf-field fb">{input}{error}<i class="fab fa-facebook-f"></i></div></div>', 'options' => []])->textInput(['placeholder' => 'Facebook Username', 'maxLength' => 50, 'value' => ((Yii::$app->user->identity->facebook) ? Yii::$app->user->identity->facebook : '')])->label(false) ?>
                        <?= $form->field($socialDetails, 'twitter', ['template' => '<div class="col-lg-6"><span class="pf-title">Twitter</span><div class="pf-field twitter">{input}{error}<i class="fab fa-twitter"></i></div></div>', 'options' => []])->textInput(['placeholder' => 'Twitter Username', 'maxLength' => 50, 'value' => ((Yii::$app->user->identity->twitter) ? Yii::$app->user->identity->twitter : '')])->label(false) ?>
                        <?= $form->field($socialDetails, 'skype', ['template' => '<div class="col-lg-6"><span class="pf-title">Skype</span><div class="pf-field fb">{input}{error}<i class="fab fa-skype"></i></div></div>', 'options' => []])->textInput(['placeholder' => 'Skype Username', 'maxLength' => 50, 'value' => ((Yii::$app->user->identity->skype) ? Yii::$app->user->identity->skype : '')])->label(false) ?>
                        <?= $form->field($socialDetails, 'linkedin', ['template' => '<div class="col-lg-6"><span class="pf-title">Linkedin</span><div class="pf-field linkedin">{input}{error}<i class="fab fa-linkedin-in"></i></div></div>', 'options' => []])->textInput(['placeholder' => 'Linkedin Username', 'maxLength' => 50, 'value' => ((Yii::$app->user->identity->linkedin) ? Yii::$app->user->identity->linkedin : '')])->label(false) ?>
                        <div class="col-lg-12">
                            <?= Html::submitButton('Update', ['class' => 'btn_pink btn_submit_contact', 'id' => 'contact_submit']); ?>
                        </div>
                    </div>
                    <input type="hidden" name="current_city" id="current_city"
                           value="<?= (($getCurrentCity) ? $getCurrentCity['city_enc_id'] : '') ?>">
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss("
.taglist
{
float:left !important;
}
.btn_remove_picture
{
 margin-left:5px;
}
 .cat_wrapper .Typeahead-spinner{
    position: absolute;
    right: 8px;
    top: 18px;
    font-size: 22px;
    display:none;
    }
.twitter-typeahead input{
    padding-right:35px !important;
}
.social-edit > form{
    padding-left:0px;
}
.add_loader
{
background-color: #ffffff;
background-image: url('http://loadinggif.com/images/image-selection/3.gif');
background-size: 25px 25px;
background-position:right center;
background-repeat: no-repeat;
}

.fb i{
    color:#3b5998 !important;
}
.twitter i{
    color:#1DA1F2 !important;
}
.gplus i{ 
    color:#CC3333 !important;
}
.linkedin i{
    color:#0077B5 !important;
}
.wrapper-bg{
    background:url(' . Url::to('@eyAssets/images/pages/index2/get-hired-bg.jpg') . ');
}
.skill-input{
    position: relative;
    vertical-align: top;
    background-color: transparent;
    padding: 15px 10px !important;
    font-size: 15px;
    border-radius: 7px;
}
.lang-input{
    margin-top: 0px !important;    
}
.help-block{
    font-weight: 500 !important;
    font-size: 14px;
    margin-bottom: 30px;
    line-height: 15px;
}
.tags > .addedTag{
    margin-bottom:10px;
}
.pf-title{
    margin-bottom: 5px;
    font-weight:bold;
}
.profile-title > h3{
    margin-top:0px;
}
.chosen-container .chosen-drop {
    background:#fff !important;
}
.highlighted{
    color:#00a0e3 !important;
}
/*-----------------*/
.tags > .addedTag > span{
    background: #00a0e3;
}
.typeahead,.tt-query{
  width: 396px;
  height: 30px;
  padding: 8px 12px;
  font-size: 18px;
  line-height: 30px;
  border: 2px solid #ccc;
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  outline: none;
}
.form-wizard .steps>li.done>a.step .number {
    background-color: #ffac64 !important;
    color: #fff;
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
#job_title
{
    height: 56px;
    background: #fff;
    border: 2px solid #e8ecec;
    font-family: Open Sans;
    font-size: 13px;
    color: #101010;
    line-height: 24px;
    border-radius: 8px;
    margin-bottom: 10px;
}

.twitter-typeahead{
width:100%;
}

.form-control.tt-hint {
  color: #999;
  opacity: 0 !important;
}
.tt-menu {
  width: 98%;
  margin: 12px 0;
  padding: 8px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
              margin-top: 0px;
}
.tt-suggestion {
  padding: 3px 20px;
  font-size: 14px;
  line-height: 24px;
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
.custom_label{
   font-size: 13px !important;
   font-weight: 100 !important;
}
.padding-left{
margin-top:20px;
}
.set-overlay{
    background-color: #ffffffd9;
    padding: 15px 30px 40px 30px;
    box-shadow: 0px 0px 16px 6px rgba(179, 179, 179, 0.1);
    border-radius: 6px;
}
input[type=radio] + label::after{
    border: 3px solid #00a0e3;
}
.btn_pink{
float: right;
    background: #ffffff;
    border: 2px solid #00a0e3;
    color: #00a0e3;
    font-size: 15px;
    padding: 12px 30px;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    margin-top: 10px;
    letter-spacing: 0px;
}
.btn_pink:hover{
    background:#00a0e3;
color:#fff;
}
.tg-fileinput{
  display:none !important;  
}  
.tg-fileuploadlabel::before{
border:none !important;
}
.tg-fileuploadlabel{
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    padding: 0;
    padding-top: 150px;
}
.tg-fileuploadlabel span i{
    background-color: #fff;
    color: #000;
    box-shadow: 0px 0px 10px 1px #bbb;
    width: 30px;
    height: 30px;
    line-height: 30px;
}
.tg-btn{
    display: block !important;
    color: #ff7803 !important;
    position: relative;
    text-align: center;
    border-radius: 8px;
    display: inline-block;
    vertical-align: middle;
    text-transform: capitalize;
    background: rgba(0,0,0,0.00);
    padding:10px 0 0 0 ;
    font-weight: 500;
    cursor: pointer;
    font-size:15px;
    width: 150px !important;
   height: 45px;
    border: 2px solid #ff7803;
}
.view_profile_btn
{
    padding: 4px 12px;
    margin-top: 3px;
    background: #ffffff !important;
    border: 1px solid #ff7803 !important;
    color: #ff7803 !important;
    border-radius: 4px;
    font-size: 13px;
}
.tg-btn:hover{
color: #fff !important;
    background:#ff7803;
}
.has-error .form-control {
    border: 2px solid #e73d4a !important;
    }
#picture_submit{
margin-top:0px;
float:left;
}    
.label_element{
font-weight:100;
font-size:15px;
}
.pf-field > input{
height:56px;
}  
#dob{
background-color: #fff;
}
.skill_wrapper,.language_wrapper{position:relative;}
.skill_wrapper .Typeahead-spinner,.language_wrapper .Typeahead-spinner{
    position: absolute;
    right: 5px;
    top: 13px;
    z-index: 9;
    display:none;
}
/* file-chosen css ends */
.file-upload-wrapper {
    position: relative;
    width: 330px;
    height: 50px;
}
.file-upload-wrapper:after {
content: attr(data-text);
    font-size: 14px;
    position: absolute;
    top: 0;
    left: 0;
    background: #fff;
    padding: 10px 15px;
    display: block;
    width: calc(100% - 40px);
    pointer-events: none;
    z-index: 20;
    height: 48px;
    line-height: 27px;
    border: 2px solid #e8ecec;
    color: #999;
    border-radius: 10px 0px 0px 10px;
}
.file-upload-wrapper:before {
    content: 'Upload Resume';
    position: absolute;
    top: 0;
    right: 0;
    display: inline-block;
    height: 48px;
    background: #fff;
    color: #555;
    z-index: 25;
    font-size: 13px;
    border: 2px solid #e8ecec;
    line-height: 45px;
    padding: 0 15px;
    pointer-events: none;
    border-radius: 0 10px 10px 0;
}
.file-upload-wrapper:hover:before {
  background: #ff7803;
  color:#fff;
  border-color: #ff7803;
}
.file-upload-wrapper input {
  opacity: 0;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 99;
  height: 60px;
  margin: 0;
  padding: 0;
  display: block;
  cursor: pointer;
  width: 100%;
}
.file-upload-wrapper p.help-block.help-block-error{
    position: absolute;
    margin-top: 55px;
}
/* file-chosen css ends */
.chosen{
    float: left;
    width: 100%;
    background: no-repeat;
    border: 2px solid #e8ecec;
    font-size: 13px;
    color: #888888;
    margin: 0;
    padding: 0 70px 0 30px;
    height: 61px;
    line-height: 61px;
    background-color: #FFF;
    border-radius: 8px;
}
.upload-img-bar > span{
    height: 154px;
    margin-bottom: 45px;
}
.tg-fileuploadlabel .field-tg-photogallery{
    width:300px;
}
@media screen and (max-width: 767px){
    .tg-fileuploadlabel, .upload-img-bar{
        padding-left:0px;
    }
}
@media screen and (max-width: 425px){
    .upload-img-bar > span{
        display:block;
        margin: auto;
        margin-bottom: 45px;
    }
    .upload-info{
        display:block;
    }
    .upload-info{
        padding-left:0px;
        text-align: center;
    }
    .tg-fileuploadlabel .field-tg-photogallery {
        width: 290px;
        margin-left: -63px;
        text-align: center;
    }
    #picture_submit{float:none;}
}
");
$url = Url::to('/' . Yii::$app->user->identity->username);
$script = <<< JS
var parent = null;
$(document).on('click', '.view_profile_btn', function(e){ 
    e.preventDefault(); 
    var url = $(this).attr('href'); 
    window.open("$url", '_blank');
});
$(document).on('change','#category_drp',function() {
      $('#job_title').val('');
      $('#job_title').typeahead('destroy');
      fetchJobProfile($(this).val());
  if($(this).val()=='')
      {
          $('#job_title').val('');
          $('#job_title').closest('.field-job_title').removeClass('has-error');
          $('#job_title').closest('.field-job_title').find('.help-block').remove();
          $('#job_title').closest('.field-job_title').addClass('has-success');
      }
  else {
      $('#job_title').closest('.field-job_title').removeClass('has-success');
      $('#job_title').closest('.field-job_title').addClass('has-error');
  }
});
$(document).on('keypress','input',function(e)
{
    if(e.which==13)
        {
            return false;
        }
});
$(document).on('keyup','#search-skill',function(e)
{
    if(e.which==13)
        {
          add_tags($(this),'skill_tag_list','skills');  
        }
});
$(document).on('keyup','#search-language',function(e)
{
    if(e.which==13)
        {
          add_tags($(this),'languages_tag_list','languages');
        }
});
 $("#exp_year, #exp_month").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
function setCity()
{
    if(!$('#current_city').val()=='')
        {
            $("#cities_drp").empty().append($("<option>", {
                value: "",
                text : "Select City"
                }));
                $.post(
                "/cities/get-cities-by-state",
                {id: $('#states_drp').val(),_csrf: $("input[name=_csrf]").val()},
                function(res){
                if(res.status === 200) {
                drp_down("cities_drp", res.cities);
                var currnt_city = $('#current_city').val();
                $("#cities_drp").val(currnt_city);
                $("#cities_drp").trigger("chosen:updated");
                }
                }
                );
        }
}
setCity();
$.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});

    $('#addTagBtn').on('click', function(){
        $('#tags option:selected').each(function() { 
            $(this).appendTo($('#selectedTags'));
        });
    });
    $('#removeTagBtn').on('click', function(){
        $('#selectedTags option:selected').each(function(el) {
            $(this).appendTo($('#tags'));
        });
    });
    $('.tagRemove').on('click', function(event){
        event.preventDefault();
        $(this).parent().remove();
    });
    $('ul.tags').on('click', function(){
        $('#search-field').focus();
    });
    var tag_class;
    
function add_tags(thisObj,tag_class,name,duplicates)
{
    var duplicates = [];
    $.each($('.'+tag_class+' input[type=hidden]'),function(index,value)
                        {
                         duplicates.push($.trim($(this).val()).toUpperCase());
                        });
    if(thisObj.val() == '' || jQuery.inArray($.trim(thisObj.val()).toUpperCase(), duplicates) != -1) {
                thisObj.val('');
                    } else {
                     $('<li class="addedTag">' + thisObj.val() + '<span class="tagRemove" onclick="$(this).parent().remove();">x</span><input type="hidden" value="' + thisObj.val() + '" name="'+name+'[]"></li>').insertBefore('.'+tag_class+' .tagAdd');
                     thisObj.val('');
                }
}    
$(document).on('submit','#basicDetailForm',function(event)
{
    event.preventDefault();
    data = new FormData(this);
    var btn = $('.btn_submit_basic');
    runAjax($(this),data,btn);
});
    
$(document).on('submit','#socialDetailForm',function(event)
{
    event.preventDefault();
    data = new FormData(this);
    var btn = $('.btn_submit_contact');
    runAjax($(this),data,btn);
});
var global = [];
$(document).on('submit','#userProfilePicture',function(event)
{
    event.preventDefault();
    data = new FormData(this);
    var btn = $('.btn_submit_picture');
    runAjax($(this),data,btn);
});   

function runAjax(thisObj,data,btn) {
  if(btn.attr("disabled") == "disabled")
            {
               return false;
            } 
  $.each(thisObj.find('.has-error'),function() {
          $(this).find('.valid_input').focus();
           })
  var chk = thisObj.find('.has-error').length;
  if(!chk)
  {
   $.ajax({
     url:thisObj.attr('action'),
     data:data,
     method:'post',
     contentType: false,
     cache:false,
     processData: false,
     beforeSend:function() {
       btn.append('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
       btn.attr("disabled","true");
     },
     success:function(response) {
       btn.html('Update');
       btn.removeAttr("disabled");
        if (response.status == 'success') {
                    toastr.success(response.message, response.title);
                    $.pjax.reload({container: '#profile_icon_pjax', async: false});
                    $.pjax.reload({container: '#pjax_profile_icon', async: false});
                    $.pjax.reload({container: '#pjax_profile_icon_sidebar', async: false});
                    $.pjax.reload({container: '#pjax_resume', async: false});
                    }
        else 
            {
                toastr.error(response.message, response.title);
            }
     }
  })
 }
}
var skills = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote: {
    url:'/account/categories-list/skills-data',
    prepare: function (query, settings) {
             settings.url += '?q=' +$('#search-skill').val();
             return settings;
        },   
    cache: false,    
    filter: function(list) {
             return list;
        }
  }
});    
            
$('#search-skill').typeahead(null, {
  name: 'skill',
  display: 'value',
  source: skills,
   limit: 6,
}).on('typeahead:asyncrequest', function() {
     $('.skill_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
     $('.skill_wrapper .Typeahead-spinner').hide();
  }).on('typeahead:selected',function(e, datum)
  {
      add_tags($(this),'skill_tag_list','skills');
   }).blur(validateSelection);

var languages = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote: {
    url:'/account/categories-list/languages',
    prepare: function (query, settings) {
             settings.url += '?q=' +$('#search-language').val();
             return settings;
        },   
    cache: false,    
    filter: function(list) {
             return list;
        }
  }
});    
            
$('#search-language').typeahead(null, {
  name: 'languages',
  display: 'value',
  source: languages,
   limit: 6,
}).on('typeahead:asyncrequest', function() {
    $('.language_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
   $('.language_wrapper .Typeahead-spinner').hide();
  }).on('typeahead:selected',function(e, datum)
  {
      add_tags($(this),'languages_tag_list','languages');
   }).blur(validateSelection);

fetchJobProfile(null);

function fetchJobProfile(parent)
{
  var job_titles = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: '/account/categories-list/job-profiles?q=%QUERY&parent='+parent,  
    wildcard: '%QUERY',
    cache: true,     
        filter: function(list) {
            global = list;
            return list;
        }
  }
});   
        
$('#job_title').typeahead(null, {
  name: 'job_title',
  display: 'value',
   limit: 6,     
   hint:false, 
   minLength: 3,
  source: job_titles
}).on('typeahead:asyncrequest', function() {
    $('.cat_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    $('.cat_wrapper .Typeahead-spinner').hide();
  }).on('typeahead:selected',function(e, datum)
   {
   })
}


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

function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('.preview_img').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

$(".tg-fileinput").change(function() {
  readURL(this);
});
$(document).on("change", ".file-upload-wrapper input", function(){
    var file_val = document.getElementById("resume_upload").files[0].name;
    $(this).parent(".file-upload-wrapper").attr("data-text", file_val );
    var file_name = $('.file-upload-wrapper').attr('data-text');
    if(file_name == ""){
        $('.file-upload-wrapper').attr('data-text', 'No file chosed');
    }
});
var ps = new PerfectScrollbar('.perfect_scroll');
JS;
$script2 = <<< JS
function drp_down(id, data) {
    var data_chosen = $('#' + id + '');
    var selectbox = $('#' + id + '');
    $.each(data, function (index) {
        selectbox.append($('<option>', { 
            value: this.id,
            text : this.name 
        }));
        
    });
    data_chosen.trigger("chosen:updated");
};
JS;
$this->registerJs($script2, yii\web\View::POS_HEAD);
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerCssFile("@web/assets/themes/jobhunt/css/icons.css");
$this->registerCssFile("@web/assets/themes/jobhunt/css/style.css");
$this->registerCssFile("@web/assets/themes/jobhunt/css/chosen.css");
$this->registerCssFile("@web/assets/themes/jobhunt/css/colors/colors.css");
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("@web/assets/themes/jobhunt/js/select-chosen.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);