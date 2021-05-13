<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;

?>

<div id="completeProfileModal" class="modal fade-scale plModal" role="dialog">
    <div class="modal-dialog lp-dialog-main">
        <!-- Modal content-->
        <div class="modal-content half-bg-color">
            <button type="button" class="close-lp-modal" data-dismiss="modal" aria-hidden="true">✕</button>
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
                                <!--                                <i class="far fa-check-circle"></i>-->
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
                            <div class="row dis-none disShow">
                                <div class="col-md-12">
                                    <div class="uploadUserImg posRel">
                                        <div class="displayImg">
                                            <img id="output" src="https://via.placeholder.com/350x350?text=Cover+Image">
                                        </div>
                                        <input type="file" class="userImg form-control" id="userImg" onchange="loadFile(event)">
                                        <label for="userImg" class="upload-icon">
                                            <i class="fas fa-pencil-alt"></i>
                                        </label>
                                        <p class="errorMsg"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row dis-none" data-id="dob">
                                <div class="col-md-12">
                                    <div class="form-group lp-form posRel">
                                        <label>Date Of Birth</label>
                                        <div class="input-group date" data-provide="datepicker" class="datepicker3">
                                            <input type="text" class="form-control text-capitalize" data-name="dob" id="dob">
                                            <div class="input-group-addon">
                                                <span class=""><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                            <div>
                                                <p class="errorMsg"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row dis-none" data-id="job-prfile-and-title">
                                <div class="col-md-12 mb10">
                                    <div class="form-group lp-form posRel">
                                        <label>Choose Job Profile</label>
                                        <input type="text" data-name="profile" class="form-control text-capitalize" id="profile">
                                        <p class="errorMsg"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group lp-form posRel">
                                        <label>Select Job Title</label>
                                        <input type="text" data-name="job_title" class="form-control text-capitalize" id="job_title">
                                        <p class="errorMsg"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row dis-none" data-id="experience">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group lp-form posRel">
                                        <label>Experience(Y)</label>
                                        <input type="text" class="form-control text-capitalize"
                                              data-name="exp_year" onkeyup="formValidations(event)" id="min_salary">
                                        <p class="errorMsg"></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group lp-form posRel">
                                        <label>Experience(M)</label>
                                        <input type="text" data-name="month" class="form-control text-capitalize" id="max_salary">
                                        <p class="errorMsg"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row dis-none" data-id="languages">
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
                                        <p class="errorMsg"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row dis-none" data-id="gender">
                                <div class="col-md-12">
                                    <div class="form-group lp-form posRel">
                                        <label>Gender</label>
                                        <select id="gender" class="form-control" name="gender" aria-required="true">
                                            <option value="">Select Gender</option>
                                            <option value="0">Male</option>
                                            <option value="1">Female</option>
                                            <option value="2">Transgender</option>
                                            <option value="3">Rather not to say</option>
                                        </select>
                                        <p class="errorMsg"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row dis-none" data-id="state-city">
                                <div class="col-md-12">
                                    <p class="textLabel">Where do you currently live?</p>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group lp-form posRel">
                                        <label>State</label>
                                        <input type="text" class="form-control text-capitalize" id="min_salary">
                                        <p class="errorMsg"></p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group lp-form posRel">
                                        <label>City</label>
                                        <input type="text" class="form-control text-capitalize" id="max_salary">
                                        <p class="errorMsg"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row dis-none" data-id="skills">
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
                                            <p class="errorMsg"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row dis-none" data-id="availability">
                                <div class="col-md-12">
                                    <div class="form-group lp-form posRel">
                                        <label>Availability</label>
                                        <select id="gender" class="form-control"
                                                name="availability" aria-required="true">
                                            <option value="">Select Availability</option>
                                            <option value="0">Available</option>
                                            <option value="1">Open</option>
                                            <option value="2">Actively Looking</option>
                                            <option value="3">Exploring Possibilities</option>
                                            <option value="4">Not Available</option>
                                        </select>
                                        <p class="errorMsg"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row dis-none" data-id="about">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group lp-form posRel">
                                        <label>About You</label>
                                        <textarea class="aboutTextarea form-control text-capitalize"
                                                  id="aboutYou"></textarea>
                                        <p class="errorMsg"></p>
                                    </div>
                                </div>
                            </div>

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
</div>
<?php
$this->registerCss('
.uploadUserImg{
    position: relative;
    height: 150px;
    width: 150px;
    margin: 0 auto;
}
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
}
.userImg{
    position: absolute;
    visibility: hidden;
    top:0;
    right:0;   
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
    line-height: 0;
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
.lp-text-box ul li{
    position: relative;
    margin-left: 15px;
    line-height: 18px;
    padding: 0;
    margin-bottom: 10px;
    font-family: roboto;
    text-align: left;
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
    margin: 0 auto 20px;
}
.lp-form label, .lp-form p, .textLabel{
    margin-bottom: 0px;
    font-family: roboto;
    font-size: 14px;
    font-weight: 500;
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
    bottom: -22px;
    left: 0;
    font-size: 13px;
    font-weight: 400 !important;
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
    top: 18px;
    font-size: 22px;
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
        width: 750px !important;
        margin: 0px auto;
    }
}
body.modal-open{
    padding-right:0px !important;
    overflow:visible;
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
loadFile = (event) => {
	var image = document.getElementById('output');
	image.src = URL.createObjectURL(event.target.files[0]);
};
$(document).on('keyup','#search-language',function(e)
{
    if(e.which==13)
        {
          add_tags($(this),'languages_tag_list','languages');
        }
});
$(document).on('keyup','#search-skill',function(e)
{
    if(e.which==13)
        {
          add_tags($(this),'skill_tag_list','skills');  
        }
});
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
             $('<li class="addedTag">' + thisObj.val() + '<span class="tagRemove" onclick="$(this).parent().remove();">x</span><input type="hidden" class="form-control" data-name="'+name+'" value="' + thisObj.val() + '" name="'+name+'[]"></li>').insertBefore('.'+tag_class+' .tagAdd');
             thisObj.val('');
        }
}
var global = [];
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
showNextQues = () =>{
    let fieldsArr = [];
    let cpForm = document.querySelector('.completeProfileForm')
    let formFields = cpForm.querySelectorAll('.dis-none');
    for(let i = 0; i<formFields.length; i++){
        fieldsArr.push(formFields[i]);      
    }
    let disShow = cpForm.querySelector('.disShow');
    let indexOfDisShow = fieldsArr.indexOf(disShow);
    let nxtIndex = (indexOfDisShow + 1) % fieldsArr.length;
    let toActive = fieldsArr[nxtIndex]; 
    let inputVal = disShow.querySelectorAll('.form-control');
    let val = [];
    if(inputVal.length > 0){
        console.log('hello')
        for(let i = 0; i < inputVal.length; i++){
            let valObj = {};
            let inputParent = inputVal[i].parentElement;
            let errorMsg = inputParent.querySelector('.errorMsg');
            let field_Name =  inputVal[i].getAttribute('data-name');
            if(inputVal[i].value == ''){
                errorMsg.classList.add('showError');
                errorMsg.innerHTML = "This field can not Be empty";
                return false;
            }else{
                valObj['field_name'] = field_Name;
                valObj['value'] = inputVal[i].value;            
                errorMsg.classList.remove('showError');
                errorMsg.innerHTML = "";
            }
          val.push(valObj);
        }
    }
        console.log(val);
    if(disShow){
        disShow.classList.remove('disShow')
    }
    toActive.classList.add('disShow');

    return false;
    $.ajax({
        url: 'profile/update-profile',
        method: 'POST',
        data: {},
        success: function (response){
            if(response.status == 200){
               if(disShow){
                    disShow.classList.remove('disShow')
                }
                toActive.classList.add('disShow');
            }else{
                toastr.error(response.message, 'error');
            }
        }
    })
}
skipToNextQues = () => {
    let fieldsArr = [];
    let cpForm = document.querySelector('.completeProfileForm')
    let formFields = cpForm.querySelectorAll('.dis-none');
    for(let i = 0; i<formFields.length; i++){
        fieldsArr.push(formFields[i]);      
    }
    let disShow = cpForm.querySelector('.disShow');
    let indexOfDisShow = fieldsArr.indexOf(disShow);
    let nxtIndex = (indexOfDisShow + 1) % fieldsArr.length;
    let toActive = fieldsArr[nxtIndex]; 
    if(disShow){
        disShow.classList.remove('disShow')
    }
    toActive.classList.add('disShow');
}
$('.datepicker3').datepicker({
    todayHighlight: true
});

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
JS;
$this->registerJs($script);
$this->registerCssFile("@web/assets/themes/jobhunt/css/chosen.css");
$this->registerCssFile('https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
