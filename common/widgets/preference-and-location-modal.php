<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;

$primaryfields = \common\models\Categories::find()
    ->alias('a')
    ->select(['a.name', 'a.icon', 'a.category_enc_id'])
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

<div id="preferenceLocation" class="modal fade-scale plModal" role="dialog">
    <div class="modal-dialog lp-dialog-main">
        <!-- Modal content-->
        <div class="modal-content half-bg-color">
            <button type="button" class="close-lp-modal" onclick="setCookie()" data-dismiss="modal" aria-hidden="true">✕</button>
            <div class="row margin-0">
                <div class="col-md-4 col-sm-4">
                    <div class="lp-modal-text half-bg half-bg-color">
                        <div class="lp-text-box ">
                            <p>Why Update <br> Your Preferences</p>
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
                            <?php
                                if(!$userPref['userPreferredJobProfiles']){
                            ?>
                            <div class="row dis-none showField posRel" data-id="job-prfile-and-title">
                                <div class="col-md-12 mb10 lp-error">
                                    <div class="form-group lp-form ">
                                        <label>Choose Job Profile</label>
                                        <select id="category_drp" data-id="Jobs" data-name="profiles"
                                                name="job_profiles[]"
                                                multiple="multiple"
                                                class="form-control js-example-basic-multiple js-states">
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
                                    </div>
                                    <p class="errorMsg"></p>
                                </div>
                            </div>
                            <?php
                                }
                                if(!$userPref['userPreferredIndustries']){
                            ?>
                            <div class="row dis-none showField posRel" data-id="industry">
                                <div class="col-md-12 lp-error">
                                    <div class="form-group lp-form with-load">
                                        <div class="load-suggestions Typeahead-spinner" style="display: none;">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <label>Industry you prefer to work in?</label>
                                        <input type="text" data-id="Jobs" data-name="industries"
                                               class="form-control lp-skill-input text-capitalize"
                                               name="industry" id="industry_data">
                                    </div>
                                    <p class="errorMsg"></p>
                                </div>

                            </div>
                            <?php
                                }
                                if(!$userPref['userPreferredLocations']){
                            ?>
                            <div class="row dis-none showField posRel" data-id="location">
                                <div class="col-md-12 lp-error">
                                    <div class="form-group lp-form with-load">
                                        <div class="load-suggestions Typeahead-spinner" style="display: none;">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <label>Preferred Locations</label>
                                        <input type="text" data-id="Jobs" data-name="locations"
                                               class="form-control lp-skill-input text-capitalize"
                                               name="location" id="city_data">
                                    </div>
                                    <p class="errorMsg"></p>
                                </div>
                            </div>
                                <?php } ?>
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
.mb10{
    margin-bottom: 10px;
}
.updatePreferenceForm{
    max-width: 350px;
    width: 100%;
    margin: 0 auto;
    text-align: center
}
.select2-container--open{
    z-index:99999 ;
}
.select2-container--default {
    width: 100% !important;
}
.chip{
    display: inline-block;
    position: relative;
    height: 32px;
    font-size: 13px;
    font-weight: 500;
    line-height: normal;
    padding: 7px 17px;
    border-radius: 8px;
    background-color: #e4e4e4;
    margin-right: 5px;
    margin-top: 3px;
    margin-bottom: 3px;
    color: #333;
}
.select2-selection__choice,
.select2-selection__choice__display{
//    float: left;
    background-color: #f4f5fa;
    font-size: 13px;
    font-weight: 500;
    position: relative !important;
    border-radius: 8px;
    margin-right: 5px;
    margin-bottom: 5px;
}
.select2-selection__choice__display{
    padding: 5px !important;

}
.select2-container .select2-search--inline .select2-search__field{
    margin-top: 0px;
    margin-left: 0px;
}
.chip i, .select2-selection__choice__remove{
    cursor:pointer;
    position: absolute !important;
    background-color: #00a0e3 !important;
    padding: 1px;
    border-radius: 100% !important;
    top: -4px !important;
    right: -4px !important;
    left: unset !important;
    width: 16px !important;
    height: 16px !important;
    text-align: center !important;
    color: #fff !important;
    font-weight: 100;
    font-size: 11px;
}
.select2-selection__choice__remove{
    border: none !important;
    margin-right: 0px !important;
    font-size: 14px;
    line-height: 0px;
     top: -6px;
    right: -4px;
    z-index: 9;
}
.select2-results__option--highlighted{
    background: #00a0e3;
    color: #fff;
}
.select2-selection.select2-selection--multiple{
    display:inline-block;
    width:100%;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice{
    padding-left: 0px;
    background: transparent;
    border: none;
    overflow: visible;
}
.select2-selection{
    border: 2px solid #e8ecec !important;
    border-radius: 8px !important;
    box-shadow: none;
    padding: 6px 5px;
    display: inline-block;
}
.select2-container .select2-search--inline .select2-search__field{
    margin-top: 0px;
    margin-left: 0px;
}
.select2-container{
    display: block
}

.lp-modal-text{
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 450px !important;
}
.lp-dialog-main .modal-content{
    max-width: 60vw;
    height: auto;
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
    margin-bottom: 25px;
}
.lp-text-box{
    background: #fff;
    padding: 20px 10px;
    border-radius: 10px;
    color: #000;
}
.lp-text-box p{
    color: #00a0e3;
    font-size: 18px;
    line-height: 25px;
    margin-bottom: 10px !important;  
}
.lp-text-box ul{
    padding-inline-start: 0px;
}
.lp-text-box ul li{
    position: relative;
    margin-left: 15px;
    line-height: 18px;
    padding: 0;
    margin-bottom: 15px;
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
.lp-skill-input{
    position: relative;
    vertical-align: top;
    background-color: transparent;
    padding: 5px 10px !important;
    font-size: 15px;
    border-radius: 7px;
}
.select2-results__options {
    list-style: none;
    margin: 0;
    padding: 0;
    height: 200px;
    overflow-y: scroll;
}
.updatePreferenceForm .materialize-tags{
    float: left;
    width: 100%;
    border: 2px solid #e8ecec;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    padding: 8px;
    margin-bottom: 0px;
}
.updatePreferenceForm .materialize-tags.active{
    box-shadow: none;
}
.updatePreferenceForm .materialize-tags input[type], 
.updatePreferenceForm .materialize-tags textarea.materialize-textarea{
    margin-top: 0px; 
}
.saveBtn, .skipBtn{
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
    border: 1px solid #00a0e3;
    color: #00a0e3;
}
.relationList{
    padding:0px;
}
.dis-none{
    display: none;
}
.posRel{
    position: relative;
}
.lp-error .errorMsg{
    display: none;
    color: #CA0B00;
    font-size: 13px !important;
    position: absolute;
    bottom: -18px;
    left: 15px;
    font-size: 13px;
    font-weight: 400 !important;
    margin-bottom: 0px;
 }
.disShow, .lp-error .showError{
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

.bootstrap-tagsinput{
    width: 100%;
    min-height: 40px;
    border-radius: 0;
    border-top: 0px;
    border-left: 0px;
    border-right: 0px;
}
.bootstrap-tagsinput.focus{
    border-color:#4aa1e3;
    -webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
.bootstrap-tagsinput .tag{
    line-height: 2;
}
.bootstrap-tagsinput input{
    border: 0px !important;
    margin-bottom: 0px !important;
    width: auto !important;
}
.bootstrap-tagsinput input:focus{
    box-shadow:none !important;
}
span.select2-search.select2-search--inline, .select2-container--default .select2-selection--multiple .select2-selection__choice{
    float: left;
}
@media only screen and (max-width: 450px) {
    .close-lg-modal{
        right: -5px;
        color: #777;
    }
}
');
$script = <<< JS
setCookie = () => {
    let date = new Date();
    date.setTime(date.getTime() + (24 * 60 * 60 * 1000));
    let maxAge = 24 * 60 * 60 * 1000;
    const expires = "expires=" + date.toUTCString();
    document.cookie = "PreferenceisViewed=PreferenceisViewed; expires="+expires+"; max-age="+maxAge+"; path=/";
}
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
function countFields(){
    let fieldsArr = [];
    let cpForm = document.querySelector('.updatePreferenceForm')
    let formFields = cpForm.querySelectorAll('.showField');
    // console.log(formFields);
    for(let i = 0; i<formFields.length; i++){
        fieldsArr.push(formFields[i]);      
    }
    if(fieldsArr.length){
        fieldsArr[0].classList.add('disShow');
        fieldsArr[0].classList.remove('showField')
        if(fieldsArr.length == 1){
            cpForm.querySelector('.skipBtn').style.display = "none";
        }
    }
}
countFields()
showNextQues = () =>{
    let fieldsArr = [];
    let cpForm = document.querySelector('.updatePreferenceForm')
    let formFields = cpForm.querySelectorAll('.showField');
    for(let i = 0; i<formFields.length; i++){
        fieldsArr.push(formFields[i]);
    }
    let disShow = cpForm.querySelector('.disShow');
    let indexOfDisShow = fieldsArr.indexOf(disShow);
    let nxtIndex = (indexOfDisShow + 1) % fieldsArr.length;
    let toActive = fieldsArr[nxtIndex];
    if(toActive){
        toActive.classList.remove('showField');
    }
    let inputVal =  disShow.querySelectorAll('.form-control')
    let val = {};
    let valObj = [];
     if(inputVal.length > 0){
         for(let i = 0; i < inputVal.length; i++){
            let inputParent = getParentUntillLpForm(inputVal[i]);
            let errorMsg = inputParent.querySelector('.errorMsg');
            let app_type = inputVal[i].getAttribute('data-id');
            let field_data_name = inputVal[i].getAttribute('data-name');
            if(inputVal[i].value != '' || ($('#category_drp').select2('data') != '')){
                if(field_data_name == 'profiles'){
                    let str = $('#category_drp').select2('data')
                    for(let i = 0; i < str.length; i++){
                        valObj.push(str[i].id)
                    }
                }else{
                    let str = inputVal[i].value
                    valObj = str.split(',');
                }
                val[field_data_name] = valObj;
                val['type'] = app_type
                console.log(val);     
            }else{
                errorMsg.classList.add('showError');
                errorMsg.innerHTML = "This field can not Be empty";
                return false;    
            }
        }
     }
       sendData(disShow, toActive, val);
}
function getParentUntillLpForm(elem){
    let parElem = $(elem).parentsUntil('.lp-error').parent();
    if (parElem.length > 0){
        return parElem[0];
    }else{
        parElem = $(elem).parent();
        return parElem[0];
    }
}
sendData = (disShow, toActive, val) => {
    $.ajax({
        url: '/account/preferences/save-preference',
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
                    $('#preferenceLocation').modal('hide');
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
    let cpForm = document.querySelector('.updatePreferenceForm')
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
$('.js-example-basic-multiple').select2({
    placeholder: 'Select Job Profile',  
});
$('.select2-search__field').css('width',$(".select2-selection__rendered").width());
// if($('.select2-selection').length > 0){
//     var ps = new PerfectScrollbar('.select2-selection.select2-selection--multiple');
// }

JS;
$this->registerJsFile('@root/assets/common/select2Plugin/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@root/assets/common/select2Plugin/select2.min.css');
$this->registerCssFile('@eyAssets/materialized/materialize-tags/css/materialize-tags.css');
$this->registerJsFile('@eyAssets/materialized/materialize-tags/js/materialize-tags.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($script);
?>
