<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;
use yii\helpers\ArrayHelper;

$statesModel = new \common\models\States();
$states = ArrayHelper::map($statesModel->find()->alias('z')->select(['z.state_enc_id', 'z.name'])->joinWith(['countryEnc a'], false)->where(['a.name' => 'India'])->orderBy(['z.name' => SORT_ASC])->asArray()->all(), 'state_enc_id', 'name');

$primaryfields = \common\models\Categories::find()
    ->alias('a')
    ->select(['a.name', 'a.category_enc_id'])
    ->innerJoin(\common\models\AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
    ->orderBy([new \yii\db\Expression('FIELD (a.name, "Others") ASC, a.name ASC')])
    ->where(['b.assigned_to' => 'Jobs', 'b.parent_enc_id' => NULL])
    ->andWhere(['b.status' => 'Approved'])
    ->andWhere([
        'or',
        ['!=', 'a.icon', NULL],
        ['!=', 'a.icon', ''],
    ])
    ->asArray()
    ->all();
?>

<div id="completeProfileModal" class="modal fade-scale plModal" role="dialog">
    <div class="modal-dialog lp-dialog-main">
        <!-- Modal content-->
        <div class="modal-content half-bg-color">
            <button type="button" class="close-lp-modal" onclick="setCookie()" data-dismiss="modal" aria-hidden="true">✕</button>
            <div class="row margin-0">
                <div class="col-md-4 col-sm-4">
                    <div class="lp-modal-text half-bg half-bg-color">
                        <div class="lp-text-box ">
                            <p>Why Complete<br> Your Profile</p>
                            <ul>
                                <li>It improves your visibility in search results.</li>
                                <li>You are 50% more likely to get the right job matches.</li>
                                <li>You get more accurate job descriptions.</li>
                            </ul>
                            <div class="lp-icon-top">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                    <circle class="path circle" fill="none" stroke="#00a0e3" stroke-width="8"
                                            stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                    <polyline class="path check" fill="none" stroke="#00a0e3" stroke-width="8"
                                              stroke-linecap="round" stroke-miterlimit="10"
                                              points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                </svg>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-8 col-sm-8 padding-0 lp-bg-log">
                    <div class="lp-fom">
                        <div class="lp-icon-bottom"><i class="fas fa-id-card-alt"></i></div>
                        <h3>Complete Your Profile</h3>
                        <form class="completeProfileForm">
                            <?php
                            if (!$userData['image']) {
                                ?>
                                <div class="row dis-none showField">
                                    <div class="col-md-12">
                                        <div class="uploadUserImg lp-form posRel">
                                            <div class="displayImg">
                                                <img id="output"
                                                     src="https://via.placeholder.com/350x350?text=Profile+Image">
                                            </div>
                                            <input type="file" accept="image/jpeg, image/png, image/jpg"
                                                   data-name="userImg" class="userImg form-control tg-fileinput"
                                                   id="userImg">
                                            <label for="userImg" class="upload-icon">
                                                <i class="fas fa-pencil-alt"></i>
                                            </label>
                                            <p class="errorMsg"></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if (!$userData['dob']) {
                                ?>
                                <div class="row dis-none showField" data-id="dob">
                                    <div class="col-md-12">
                                        <div class="form-group lp-form posRel">
                                            <label>Date Of Birth</label>
                                            <div class="input-group date datepicker3" data-provide="datepicker">
                                                <input type="text" class="form-control text-capitalize" data-name="dob"
                                                       id="dob">
                                                <div class="input-group-addon">
                                                    <span class=""><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <div>
                                                    <p class="errorMsg doberror"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if (!$userData['job_function']) {
                                ?>
                                <div class="row dis-none showField" data-id="job-prfile-and-title">
                                    <div class="col-md-12 mb10">
                                        <div class="form-group lp-form posRel">
                                            <label>Choose Job Profile</label>
                                            <select id="category_drp" data-name="category"
                                                    class="chosen form-control text-capitalize">
                                                <option>Select Profile</option>
                                                <?php
                                                if ($primaryfields) {
                                                    foreach ($primaryfields as $pf) {
                                                        ?>
                                                        <option value="<?= $pf['category_enc_id'] ?>"><?= $pf['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <p class="errorMsg"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group lp-form posRel">
                                            <div>
                                                <label>Select Job Title</label>
                                            </div>
                                            <div class="cat_wrapper">
                                                <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                                <input type="text" data-name="job_title"
                                                       class="form-control text-capitalize " id="job_title">
                                                <p class="errorMsg"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if (!$userData['experience']) {
                                ?>
                                <div class="row dis-none showField" data-id="experience">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group lp-form posRel">
                                            <label>Experience(Y)</label>
                                            <input type="text" class="form-control text-capitalize"
                                                   data-name="exp_year" onkeyup="formValidations(event)" id="year">
                                            <p class="errorMsg"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group lp-form posRel">
                                            <label>Experience(M)</label>
                                            <input type="text" data-name="exp_month"
                                                   class="form-control text-capitalize" id="month">
                                            <p class="errorMsg"></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if (!$userData['userSpokenLanguages']) {
                                ?>
                                <div class="row dis-none showField" data-id="languages">
                                    <div class="col-md-12">
                                        <div class="pf-field no-margin form-group lp-form posRel">
                                            <label>Pick Some Languages You Can Read,Write,Speak</label>
                                            <ul class="tags languages_tag_list">
                                                <li class="tagAdd taglist">
                                                    <div class="language_wrapper">
                                                        <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                                        <input type="text" id="search-language" data-name="language"
                                                               class="skill-input text-capitalize lp-skill-input lang-input">
                                                    </div>
                                                </li>
                                            </ul>
                                            <p class="errorMsg doberror"></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if (!$userData['gender']) {
                                ?>
                                <div class="row dis-none showField" data-id="gender">
                                    <div class="col-md-12">
                                        <div class="form-group lp-form posRel">
                                            <label>Gender</label>
                                            <select id="gender" data-name="gender" class="form-control" name="gender"
                                                    aria-required="true">
                                                <option value="">Select Gender</option>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                                <option value="3">Transgender</option>
                                                <option value="4">Rather not to say</option>
                                            </select>
                                            <p class="errorMsg"></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if (!$userData['city_enc_id']) {
                                ?>
                                <div class="row dis-none showField" data-id="state-city">
                                    <div class="col-md-12">
                                        <p class="textLabel">Where do you currently live?</p>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group lp-form posRel">
                                            <label>State</label>
                                            <select id='states_drp' data-name="state" value=""
                                                    class="form-control text-capitalize chosen">
                                                <?php
                                                if ($states) {
                                                    foreach ($states as $key => $state) {
                                                        ?>
                                                        <option value="<?= $key ?>"><?= $state ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <p class="errorMsg"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group lp-form posRel">
                                            <label>City</label>
                                            <select id="cities_drp" data-name="city" value=""
                                                    class="form-control text-capitalize chosen">

                                            </select>
                                            <p class="errorMsg selectError"></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if (!$userData['userSkills']) {
                                ?>
                                <div class="row dis-none showField" data-id="skills">
                                    <div class="col-md-12">
                                        <div class="form-group lp-form posRel">
                                            <div class="pf-field no-margin">
                                                <label>Pick the Skills You Have</label>
                                                <ul class="tags skill_tag_list">
                                                    <li class="tagAdd taglist">
                                                        <div class="skill_wrapper">
                                                            <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                                            <input type="text" id="search-skill" class="skill-input">
                                                        </div>
                                                    </li>
                                                </ul>
                                                <p class="errorMsg doberror"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if (!$userData['is_available'] && $userData['is_available'] != 0) {
                                ?>
                                <div class="row dis-none showField" data-id="availability">
                                    <div class="col-md-12">
                                        <div class="form-group lp-form posRel">
                                            <label>Availability</label>
                                            <select id="availability" data-name="availability" class="form-control"
                                                    name="availability" aria-required="true">
                                                <option value="">Select Availability</option>
                                                <option value="1">Available</option>
                                                <option value="2">Open</option>
                                                <option value="3">Actively Looking</option>
                                                <option value="4">Exploring Possibilities</option>
                                                <option value="0">Not Available</option>
                                            </select>
                                            <p class="errorMsg"></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if (!$userData['description']) {
                                ?>
                                <div class="row dis-none <?= $userData['description'] ? '' : 'showField' ?>"
                                     data-id="about">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="form-group lp-form posRel">
                                            <label>About You</label>
                                            <textarea class="aboutTextarea form-control text-capitalize"
                                                      data-name="description" id="aboutYou"></textarea>
                                            <p class="errorMsg"></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" onclick="showNextQues()" class="saveBtn">Save</button>
                                    <button type="button" onclick="skipToNextQues()" class="skipBtn">Skip</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
                    <button type="button" class="btn btn-default mr-10" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.lp-skill-input{
    position: relative;
    vertical-align: top;
    background-color: transparent;
    padding: 5px 10px !important;
    font-size: 15px;
    border-radius: 7px;
}

.lang-input{
    margin-top: 0px !important;    
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
.tags > .addedTag{
    margin-bottom:10px;
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
.tags > .addedTag > span {
    position: absolute;
    right: -6px;
    top: -5px;
    width: 16px;
    height: 16px;
    font-style: normal;
    background: #fb236a;
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
.tags li {
    margin: 0;
}
.taglist {
    float: left !important;
}
.posRel{
    position: relative;
}
.displayImg{
    width: 100%;
    height: 100%;
    overflow: hidden;
    padding-bottom: 10px;
}
.displayImg img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 2px solid #e8ecec;
    border-radius: 10px;
}
.userImg{
    position: absolute;
    visibility: hidden;
    top:0;
    right:0;
    height: 100%;   
}
.upload-icon{
    position: absolute;
    top: -18px;
    right: -17px;
    background: #00a0e3;
    padding: 7px 12px;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
}
.mb10{
    margin-bottom: 10px;
}
.completeProfileForm{
    max-width: 350px;
    width: 100%;
    margin: 0 auto;
    text-align: center
}
.aboutTextarea{
    min-height: 130px;
    resize: none;
}
.lp-modal-text{
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 450px !important;
}
.lp-fom h3{
    color: #000;  
    margin-top: 0px; 
    margin-bottom: 30px;
}
.lp-icon-top{
    text-align: center;
    font-size: 30px;
    color: #00a0e3    
}
.lp-icon-bottom{
    color: #00a0e3;   
    font-size: 35px;
}
.lp-text-box{
    background: #fff;
    padding: 10px 8px;
    border-radius: 10px;
    color: #000;
}
.lp-text-box p{
    color: #00a0e3;
    font-size: 18px;
    line-height: 22px;
    margin-bottom: 10px;  
}
.lp-text-box ul{
    padding-inline-start: 0px;
}
.lp-text-box ul li{
    position: relative;
    margin-left: 15px;
    line-height: 18px;
    padding: 0;
    margin-bottom: 10px;
    font-family: roboto;
    text-align: left;
    list-style-type: none;
}
.lp-text-box ul li:before{
    content:"\f111";
    margin-left: -11px;
    position: absolute;
    top: 1px;
    font-size: 7px;
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    color: #00a0e3;
}
.saveBtn{
    background: #00a0e3;
    padding: 10px 15px;
    border: 1px solid #00a0e3;
    font-size: 14px;
    border-radius: 4px;
    margin-top: 20px;
    color: #fff
}
.skipBtn{
    background: transparent;
    padding: 10px 15px;
    border: 1px solid #00a0e3;
    font-size: 14px;
    border-radius: 4px;
    margin-top: 20px;
    color: #00a0e3;
}
.relationList{
    padding:0px;
}
.dis-none{
    display: none;
    margin-bottom: 15px;
}
.disShow{
    display: block;
}
.lp-radio {
    display: inline-block;
    min-width: 90px;
    text-align: center;
    margin: 0px 10px 0 0;
}

.lp-radio > label {
    width: 100%;
    display: inline-block;
    box-shadow: 0 0 5px rgba(0,0,0,.1);
    border: 2px solid transparent;
    min-width: 150px;
    padding: 18px 0 10px;
    color: #333;
    font-weight:normal;
    border-radius: 4px;
    white-space: nowrap;
    margin: 3px 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all .2s; 
    cursor: pointer;
}
.lp-radio > label p{
    margin-bottom: 0px;
    font-size: 16px;
    font-family: roboto;  
}
.lp-radio > label img{
    max-width: 50px;
}
.lp-radio > input[type="radio"]:checked + label, .lp-radio > label:hover {
        box-shadow: 2px 2px 10px rgb(0 0 0 / 10%);
        color: #000;
        transition:.3s ease;
//       border: 2px solid #00a0e3;
}
.lp-radio > input {
    position: absolute;
    opacity: 0;
}
.lp-form{
    text-align: left;
    max-width: 350px;
    margin: 0 auto;
    float: left;
    width: 100%;
}

.lp-form input,
.lp-form select,
.lp-form textarea{
    height: auto !important;
    background: #fff;
    border: 2px solid #e8ecec;
    font-family: roboto;
    font-size: 13px;
    color: #101010;
    line-height: 24px;
    border-radius: 8px;
    margin-bottom: 10px;
}
.lp-form .chosen-container-single .chosen-single{
    padding: 6px 12px !important;
}
.lp-form .chosen-container-single .chosen-single div::before{
    position: absolute;
    content: "\f078";
    font-family: "Font Awesome 5 Free";
    font-size: 13px;
    right: 15px;
    top: 50%;
    margin-top: -13px;
    font-weight: 900;
}
.lp-form label, 
.lp-form p, .textLabel{
    margin-bottom: 0px;
    font-family: roboto;
    font-size: 14px;
    font-weight: 500;
}
.lp-form .input-group-addon{
    border: none !important;
    border-radius: 0 8px 8px 0 !important;
}
.uploadUserImg{
    position: relative;
    height: 150px;
    width: 150px !important;
    margin: 0 auto;
    float: unset;
}
.textLabel{
    text-align: left;
}
.weekDays-selector input {
    display: none!important;
}
.weekDays-selector input[type=checkbox]:checked + label {
    background: #00a0e3;
    color: #ffffff;
}
.weekDays-selector input[type=checkbox] + label {
    display: inline-block;
    border-radius: 14px;
    background: #dddddd;
    height: 25px;
    width: 25px;
    margin-right: 3px;
    line-height: 25px;
    text-align: center;
    cursor: pointer;
}

.half-bg-color{
    background: #00a0e3;
}
.half-bg{
    background-size:cover;
    height:100%;
    border-radius: 5px 0 0 5px;
}
.lp-fom{
    padding:50px 0;
    text-align:center;
    white-space: nowrap;
    height: 450px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
.lp-text{
   height: 450px; 
 }
 .margin-0{
    margin-left:0px !important;
    margin-right: 0px !important
 }
 .errorMsg{
    display: none;
    color: #CA0B00;
    font-size: 13px !important;
    position: absolute;
    bottom: -10px;
    left: 0;
    font-size: 13px;
    font-weight: 400 !important;
    margin-bottom: 0px;
 }
.doberror, .selectError{
     bottom: -20px;
}
.showError{
    display: block;
}
 .skill_wrapper,
 .language_wrapper{
    position:relative;
        
}
.skill_wrapper .Typeahead-spinner,
.language_wrapper .Typeahead-spinner{
    position: absolute;
    right: 5px;
    top: 13px;
    z-index: 9;
    display:none;
}
.tagAdd.taglist input {
    float: left;
    width: auto;
    background: #ffffff;
    border: 1px solid #e8ecec;
    margin-left: 10px;
    padding: 5px;
//    height: 19px;
    margin: 5px 0;
//    margin-left: 15px;
    padding-left: 15px;
}
.cat_wrapper .Typeahead-spinner{
    position: absolute;
    right: 8px;
    top: 47%;
    font-size: 18px;
    display:none;
}
.twitter-typeahead input{
    padding-right:0px !important;
}
.lp-icon-top svg {
  width: 30px;
  display: block;
  margin: 0px auto 0;
}
.path {
  stroke-dasharray: 1000;
  stroke-dashoffset: 0;
}
.path.circle {
  -webkit-animation: dash 1.9s ease-in-out infinite;
  animation: dash 1.9s ease-in-out infinite;
}
.path.line {
  stroke-dashoffset: 1000;
  -webkit-animation: dash 0.9s 0.35s ease-in-out forwards infinite;
  animation: dash 0.9s 0.35s ease-in-out forwards infinite;
}
.path.check {
  stroke-dashoffset: -100;
  -webkit-animation: dash-check 1.9s 1.35s ease-in-out forwards infinite;
  animation: dash-check 1.9s 1.35s ease-in-out forwards infinite;
}
@-webkit-keyframes dash {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}
@keyframes dash {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}
@-webkit-keyframes dash-check {
  0% {
    stroke-dashoffset: -100;
  }
  100% {
    stroke-dashoffset: 900;
  }
}
@keyframes dash-check {
  0% {
    stroke-dashoffset: -100;
  }
  100% {
    stroke-dashoffset: 900;
  }
}

/*---- ----*/
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
#job_title{
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
/*---old---*/

.individual-form::-webkit-scrollbar { 
    width: 0 !important 
}
.individual-form { 
    overflow: -moz-scrollbars-none; 
}
.individual-form { 
    -ms-overflow-style: none; 
}
.individual-form{
    overflow: hidden;
    overflow-y: scroll;
    padding-top:50px;
    max-height:76vh; 
}
.intl-tel-input{
    display:block !important;
}
::placeholder{
    color:#999;
}
.login-heading{
    text-align:left;
    padding-left:40px;
}
.fade-scale {
  transform: scale(0);
  opacity: 0;
  -webkit-transition: all .25s linear;
  -o-transition: all .25s linear;
  transition: all .25s linear;
}
.fade-scale.in {
  opacity: 1;
  transform: scale(1);
}
.lp-bg-log{
    background:#fff;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 0 5px 5px 0;
    min-height:365px;
}
.loginModal.modal.in{
    display:flex !important;
}
.lp-dialog-main{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
    z-index: 10049 !important;
}
.lp-dialog-main .modal-content{
    max-width: 60vw;
    height: auto;
}
.close-lp-modal{
    position: absolute;
    right: 0px;
    font-size: 17px;
    color: #FFF;
    opacity: 1;
    top: 0px;
    font-weight: 100;
    background: #00a0e3;
    border: 0;
    outline: 0;
    z-index: 99;
    padding: 0px 5px 5px 9px;
    font-family: "Roboto";
    border-radius: 0 4px 0 10px;
}
.languages_tag_list,
.skill_tag_list{
    list-style-type: none;
}
@media screen and (max-width: 992px){
    .half-bg{
        border-radius:5px 5px 0 0;
    }
    .lp-bg-log{
        border-radius:0px 5px 5px 0px;
    }
    .rem-input input{
        margin-left:0px;
    }
}
@media screen and (max-width: 767px){
    .rem-input{
        padding-right:15px !important;
    }
    .half-bg{
        display:none;
    }
    .lp-bg-log{
        min-width:300px;
    }
    .f-mail{
        white-space: normal !important;
    }
}
@media screen and(max-width: 550px){
    .lp-bg-log{
        max-width:280px;
    }
}
@media screen and (min-width: 768px){
    .lp-dialog-main {
        width: auto !important;
        margin: 0px auto;
    }
}
body.modal-open{
    padding-right:0px !important;
}
.modal-open{
    overflow-y: hidden !important;
}

.error-occcur{color:red;}

.rem-input .checkbox{
    padding-left: 20px;
    margin: 0px;
    color: inherit;
}
.rem-input .checkbox label{
    font-size: 14px;
}
@media only screen and (max-width: 450px) {
    .close-lg-modal{
        right: -5px;
        color: #777;
    }
}
');
$script = <<< JS
function setCookie() {
    let date = new Date();
    date.setTime(date.getTime() + (24 * 60 * 60 * 1000));
    let maxAge = 24 * 60 * 60 * 1000;
    const expires = "expires=" + date.toUTCString();
    document.cookie = "ModalisViewed=modalViewed; expires="+expires+"; max-age="+maxAge+"; path=/";
}


$(document).on('keyup','#search-language',function(e){
    if(e.which==13){
        add_tags($(this),'languages_tag_list','languages');
    }
});
$(document).on('keyup','#search-skill',function(e){
    if(e.which==13){
        add_tags($(this),'skill_tag_list','skills');  
    }
});

function add_tags(thisObj,tag_class,name,duplicates){
    var duplicates = [];
    $.each($('.'+tag_class+' input[type=hidden]'),function(index,value){
        duplicates.push($.trim($(this).val()).toUpperCase());
    });
    if(thisObj.val() == '' || jQuery.inArray($.trim(thisObj.val()).toUpperCase(), duplicates) != -1) {
        thisObj.val('');
    } else {
         $('<li class="addedTag">' + thisObj.val() + '<span class="tagRemove" onclick="$(this).parent().remove();">x</span><input type="hidden" class="form-control" data-name="'+name+'" value="' + thisObj.val() + '" name="'+name+'[]"></li>').insertBefore('.'+tag_class+' .tagAdd');
         thisObj.val('');
    }
}
var global = [];

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
}).on('typeahead:selected',function(e, datum){
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
  }).on('typeahead:selected',function(e, datum){
      add_tags($(this),'languages_tag_list','languages');
   }).blur(validateSelection);

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
function countFields(){
    let fieldsArr = [];
    let cpForm = document.querySelector('.completeProfileForm')
    let formFields = cpForm.querySelectorAll('.showField');
    for(let i = 0; i<formFields.length; i++){
        fieldsArr.push(formFields[i]);      
    }
    if(fieldsArr.length){
        fieldsArr[0].classList.add('disShow');
        fieldsArr[0].classList.remove('showField')
        if(fieldsArr.length == 1){
            cpForm.querySelector('.skipBtn').style.display = "none";
        }
    }else if(fieldsArr.length == 0){
         $('#completeProfileModal').modal('hide');
    }else{
       
    }
}
countFields()
showNextQues = () =>{
    let fieldsArr = [];
    let cpForm = document.querySelector('.completeProfileForm')
    let formFields = cpForm.querySelectorAll('.showField');
    for(let i = 0; i<formFields.length; i++){
        fieldsArr.push(formFields[i]);      
    }
    if(fieldsArr.length == 1){
        cpForm.querySelector('.skipBtn').style.display = "none";
    }
    let disShow = cpForm.querySelector('.disShow');
    let indexOfDisShow = fieldsArr.indexOf(disShow);
    let nxtIndex = (indexOfDisShow + 1) % fieldsArr.length;
    let toActive = fieldsArr[nxtIndex]; 
     if(toActive){
        toActive.classList.remove('showField');
    }
    let inputVal = disShow.querySelectorAll('.form-control');
    let val = {};
    let valObj = [];
    if(inputVal.length > 0){
        for(let i = 0; i < inputVal.length; i++){
            let inputParent = getParentUntillLpForm(inputVal[i]);
            let errorMsg = inputParent.querySelector('.errorMsg');
            let field_Name =  inputVal[i].getAttribute('data-name');
            if(inputVal[i].value == '' && !inputVal[i].classList.contains('tt-hint')){
                errorMsg.classList.add('showError');
                errorMsg.innerHTML = "This field can not Be empty";
                return false;
            }else{
                if(field_Name != 'userImg' && field_Name != 'state' && field_Name != 'skills' && field_Name != 'languages'){
                    val[field_Name] = inputVal[i].value;
                }else if(field_Name == 'skills' || field_Name == 'languages'){
                    valObj.push(inputVal[i].value);
                    val[field_Name] = valObj;
                }else if(field_Name == 'userImg'){
                    if(disShow){
                        disShow.classList.remove('disShow')
                    }
                    toActive.classList.add('disShow');
                    return false;
                }  
            }
        }
    }else{
        let errorMsg = disShow.querySelector('.errorMsg');
        errorMsg.classList.add('showError');
        errorMsg.innerHTML = "This field can not Be empty";
        return false;
    }
    sendData(disShow, toActive, val);
}
function getParentUntillLpForm(elem){
    let parElem = $(elem).parentsUntil('.lp-form').parent();
    if (parElem.length > 0){
        return parElem[0];
    }else{
        parElem = $(elem).parent();
        return parElem[0];
    }
}
sendData = (disShow, toActive, val) => {
    $.ajax({
        url: '/users/update-basic-detail',
        method: 'POST',
        data: val,
        success: function (response){
            if(response.title == 'Success'){
               if(disShow && toActive){
                    disShow.classList.remove('disShow')
                    if(disShow.classList.contains('showField')){
                        disShow.classList.remove('showField')
                    }
                    toActive.classList.add('disShow');
                }else{
                    console.log('empty');
                    $('#completeProfileModal').modal('hide');
                }
            }else{
                // toastr.error(response.message, 'error');
                disShow.classList.add('showField')
                console.log('error occured')
            }
        }
    })
}
skipToNextQues = () => {
    let fieldsArr = [];
    let cpForm = document.querySelector('.completeProfileForm')
    let formFields = cpForm.querySelectorAll('.showField');
    for(let i = 0; i<formFields.length; i++){
        fieldsArr.push(formFields[i]);      
    }
    let disShow = cpForm.querySelector('.disShow');
    disShow.classList.add('showField');
    let indexOfDisShow = fieldsArr.indexOf(disShow);
    let nxtIndex = (indexOfDisShow + 1) % fieldsArr.length;
    let toActive = fieldsArr[nxtIndex]; 
    if(disShow){
        disShow.classList.remove('disShow')
    }
    toActive.classList.add('disShow');
}

if($('.datepicker3')){
    $('.datepicker3').datepicker({
        endDate: '0',
        todayHighlight: true
    });
}
formValidations = (event) => {
    let elem = event.currentTarget;
    let elemValue = elem.value;
    let elemId = elem.id;
    let parElem = elem.parentElement;
    let errorMsg = parElem.querySelector('.errorMsg');
    
    if(elemId == 'min_salary' || elemId == 'max_salary'){
        var z1 = /^[0-9]*$/;
        if (!z1.test(elemValue)) {
            errorMsg.classList.add('showError');
            errorMsg.innerHTML = 'Please enter a number';
        }else{
            errorMsg.classList.remove('showError');
            errorMsg.innerHTML = '';
        }   
    }
}

$(document).on('change','#states_drp',function() {
   $("#cities_drp").empty().append($("<option>", { 
         value: "",
         text : "Select City" 
     }));
   $.ajax({
        url: '/cities/get-cities-by-state',
        type: 'POST',
        data: {id: $(this).val(),_csrf: $("meta[name=csrf-token]").attr("content")},
        success: function(response) {
            if (response.status == 200) {
                drp_down("cities_drp", response.cities);
                $("#cities_drp").trigger("chosen:updated");
            }
        },
    });
})
function drp_down(id, data) {
    var selectbox = $('#' + id + '');
    $.each(data, function () {
        selectbox.append($('<option>', {
            value: this.id,
            text: this.name
        }));
    });
}
var el = document.getElementById('demo');
var vanilla = new Croppie(el, {
    viewport: { width: 400, height: 400 },
    boundary: { width: 500, height: 500 },
    enforceBoundary: false,
    showZoomer: true,
    enableZoom: true,
    // enableExif: true,
    mouseWheelZoom: true,
    maxZoomedCropWidth: 10,
    // enableOrientation: true
});
function readURL(input) {
    console.log('enter');
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
        $('#cropImagePop').modal('show');
        var rawImg = e.target.result;
        setTimeout(function() {
            renderCrop(rawImg);
        }, 500);
      $('#output').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
    
  }
}
function renderCrop(img){
    console.log('render')
    vanilla.bind({
        url: img,
        points: [20,20,20,20]
        // orientation: 4
    });
}
$(".tg-fileinput").change(function() {
    console.log('hello');
  readURL(this);
});

document.querySelector('.vanilla-result').addEventListener('click', function (ev) {
    vanilla.result({
        type: 'base64',
        // format:'jpeg',
    }).then(function (data) {
        $.ajax({
            url: "/users/update-profile-picture",
            method: "POST",
            data: {data:data},
            beforeSend:function(){
                $('.vanilla-result').html("<i class='fas fa-circle-notch fa-spin fa-fw'></i>");
                $('.vanilla-result').prop('disabled', true);
            },
            success: function (response) {
                $('.vanilla-result').html('Done');
                $('.vanilla-result').prop('disabled', false);
                $('#cropImagePop').modal('hide');
                if (response.title == 'Success') {
                    // toastr.success(response.message, response.title);
                    $('#output').attr('src', data);
                } else {
                    // toastr.error(response.message, response.title);
                }
            }
        });
    });
});
$(document).on('change','#category_drp',function() {
      $('#job_title').val('');
      $('#job_title').typeahead('destroy');
      fetchJobProfile($(this).val());
  if($(this).val()==''){
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

fetchJobProfile(null);

function fetchJobProfile(parent){
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
      }).on('typeahead:selected',function(e, datum){
            console.log(datum.value);
            $('#job_title').val(datum.value)
    })
}

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
$this->registerCssFile("/assets/themes/jobhunt/css/chosen.css");
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("/assets/themes/jobhunt/js/select-chosen.js", ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($script2);
$this->registerJs($script);
?>