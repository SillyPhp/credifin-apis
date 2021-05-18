<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;

?>

<div id="plModal" class="modal fade-scale plModal" role="dialog">
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
                        <h3>Update Your Preferences</h3>
                        <form class="updatePreferenceForm">
<!--                            <div class="row dis-none disShow" data-id="job-prfile-and-title">-->
<!--                                <div class="col-md-12 mb10">-->
<!--                                    <div class="form-group lp-form">-->
<!--                                        <label>Choose Job Profile</label>-->
<!--                                        <input type="text" class="form-control text-capitalize" id="profiles">-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="row dis-none disShow" data-id="industry">
                                <div class="col-md-12">
                                    <div class="form-group lp-form with-load">
                                        <div class="load-suggestions Typeahead-spinner" style="display: none;">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <label>Industry you prefer to work in?</label>
                                        <input type="text" class="form-control text-capitalize" name="industry" id="industry_data">
                                    </div>
                                </div>
                            </div>
                            <div class="row dis-none" data-id="salary">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group lp-form">
                                        <label>Min Salary(p.a)</label>
                                        <input type="text" class="form-control text-capitalize" id="min_salary">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group lp-form">
                                        <label>Max Salary(p.a)</label>
                                        <input type="text" class="form-control text-capitalize" id="max_salary">
                                    </div>
                                </div>
                            </div>




                            <div class="row dis-none" data-id="job-type">
                                <div class="col-md-12">
                                    <div class="form-group lp-form">
                                        <label>Job Type</label>
                                        <select id="candidatepreferenceform-job_type" class="form-control edited"
                                                name="CandidatePreferenceForm[job_type]" aria-required="true">
                                            <option value="">Select Job Type</option>
                                            <option value="Full Time">Full Time</option>
                                            <option value="Part Time">Part Time</option>
                                            <option value="Work from Home">Work From Home</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row dis-none" data-id="working-days">
                                <div class="col-md-12">
                                    <div class="weekDays-selector">
                                        <div class="form-group field-intern_weekdays required has-success">
                                            <p>Select the working days</p>
                                            <div>
                                                <input type="hidden" name="CandidateInternshipPreferenceForm[weekdays]"
                                                       value="">
                                                <div id="intern_weekdays" aria-required="true" aria-invalid="false">
                                                    <input type="checkbox"
                                                           name="CandidateInternshipPreferenceForm[weekdays][]"
                                                           value="1" id="intern_weekday-0" class="weekday" checked="">
                                                    <label for="intern_weekday-0">M</label>
                                                    <input type="checkbox"
                                                           name="CandidateInternshipPreferenceForm[weekdays][]"
                                                           value="2" id="intern_weekday-1" class="weekday" checked="">
                                                    <label for="intern_weekday-1">T</label>
                                                    <input type="checkbox"
                                                           name="CandidateInternshipPreferenceForm[weekdays][]"
                                                           value="3" id="intern_weekday-2" class="weekday" checked="">
                                                    <label for="intern_weekday-2">W</label>
                                                    <input type="checkbox"
                                                           name="CandidateInternshipPreferenceForm[weekdays][]"
                                                           value="4" id="intern_weekday-3" class="weekday" checked="">
                                                    <label for="intern_weekday-3">T</label>
                                                    <input type="checkbox"
                                                           name="CandidateInternshipPreferenceForm[weekdays][]"
                                                           value="5" id="intern_weekday-4" class="weekday" checked="">
                                                    <label for="intern_weekday-4">F</label>
                                                    <input type="checkbox"
                                                           name="CandidateInternshipPreferenceForm[weekdays][]"
                                                           value="6" id="intern_weekday-5" class="weekday">
                                                    <label for="intern_weekday-5">S</label>
                                                    <input type="checkbox"
                                                           name="CandidateInternshipPreferenceForm[weekdays][]"
                                                           value="7" id="intern_weekday-6" class="weekday">
                                                    <label for="intern_weekday-6">S</label></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row dis-none" data-id="intern-timing">
                                <div class="col-md-6">
                                    <div class="form-group lp-form">
                                        <label>Job Timing From</label>
                                        <input type="text" class="form-control text-capitalize" id="profile">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group lp-form">
                                        <label>Upto</label>
                                        <input type="text" class="form-control text-capitalize" id="profile">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" onclick="showNextQues()" class="saveBtn">Save</button>
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
    border: none;
    font-size: 14px;
    border-radius: 4px;
    margin-top: 20px;
    color: #fff
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
    margin: 0 auto;
}
.lp-form label, .lp-form p{
    margin-bottom: 0px;
    font-family: roboto;
    font-size: 14px;
    font-weight: 500;
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
var city = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: '',
    cache: true, 
    remote: {
        url: '/cities/get-location?q=%QUERY',
        wildcard: '%QUERY'
    }
});
city.initialize();

var city_name = $('#city_data,#intern_city_data');
city_name.materialtags({
    itemValue: 'id',
    itemText: 'text',
    typeaheadjs: {
        name: 'city',
        displayKey: 'city_name',
        source: city.ttAdapter()
    }
});

var industries = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    cache: true, 
    prefetch:{
        url: '/account/preferences/get-industry?q=com',
    },
    remote: {
        url: '/account/preferences/get-industry?q=%QUERY',
        wildcard: '%QUERY',
    }
});
industries.initialize();

var industry_name = $('#industry_data');
industry_name.materialtags({
    itemValue: 'id',
    itemText: 'text',
    typeaheadjs: {
        name: 'industry',
        displayKey: 'text',
        source: industries.ttAdapter()
    }
});

showNextQues = () =>{
    let fieldsArr = [];
    let cpForm = document.querySelector('.updatePreferenceForm')
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
JS;
$this->registerJs($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<script>
    function showValForm(e) {
        let sRadio = e.currentTarget
        let valInput = e.currentTarget.value
        let plform = sRadio.closest('form')
        plform.querySelector('#show' + valInput).classList.add('showDiv');
        plform.querySelector('#preftype').classList.add('hideDiv');
    }
</script>
