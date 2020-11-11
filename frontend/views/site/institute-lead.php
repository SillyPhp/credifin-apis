<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use borales\extensions\phoneInput\PhoneInput;

$image = Url::to('@eyAssets/images/pages/education-loans/edu-loan-p1.png', 'https');
$this->title = "Education Institution Funding";
$keywords = "empower youth, college, university, admission, education loan";
$description = "Funding for educational institutions";
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouthin',
        'twitter:creator' => '@EmpowerYouthin',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl(),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];

?>

    <section class="admission-form">
        <div class="oa-container">
            <div class="ey-logo">
                <a href="/"> <img src="<?= Url::to('@commonAssets/logos/logo.svg') ?>"></a>
            </div>
            <div class="flex-main">
                <div class="left-sec">
                    <p class="il-heading">Are Your Students Facing Problem <br> Of <span class="colorOrange">Raising Funds</span> For Their <span class="colorOrange">Education</span>?</p>
                    <div class="ls-divider"></div>
                    <p class="font-20">If Yes, Then We With Our <br>
                        <span class="colorBlue">Education Institution Funding</span> <br>
                        Are Here To Help You To <span class="colorOrange">Raise Funds</span> <br> For Your <span class="colorOrange">Students</span>.</p>
                </div>
                <div class="right-sec">
                    <div class="ls-box-shadow">
                        <p id="headingText">Please Fill The Following Details</p>
                        <form>
                            <div class="form-group">
                                <input type="text" id="companyName" name="companyName" class="form-control" placeholder="Organization Name">
                            </div>
                            <div class="form-group">
                                <p>Organization Type</p>
                                <div class="radio-toolbar">
                                    <input type="radio" id="radioSchool" name="radioType" value="school" checked>
                                    <label for="radioSchool">School</label>

                                    <input type="radio" id="radioCollege" name="radioType" value="college">
                                    <label for="radioCollege">College</label>

                                    <input type="radio" id="radioEI" name="radioType" value="educational institute">
                                    <label for="radioEI">Educational Institute</label>

                                    <input type="radio" id="radioOC" name="radioType" value="overseas consultant">
                                    <label for="radioOC">Overseas Consultant</label>

                                </div>
                            </div>
                            <div class="form-group">
                                <select class="form-control">
                                    <option>Ownership Type</option>
                                    <option>Partnership</option>
                                </select>
                            </div>

                            <div class="form-flex">
                                <div class="form-group mr5">
                                    <input type="text" id="loanAmount" name="loanAmount" class="form-control" placeholder="Loan Amount Required">
                                </div>
                                <div class="form-group ml5">
                                    <input type="text" id="annualTurnover" name="annualTurnover" class="form-control" placeholder="Annual Turnover">
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="button" id="prevBtn" class="btn-frm">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.text-center{
    text-align: center;
}
#headingText{
    text-align: left;
    margin-bottom: 0px;
    margin-top: 10px
}
.il-heading{
    font-size: 20px;
}
.font-20{
    font-size: 18px;
    line-height: 28px;
}
.mr5{
    margin-right: 5px;
    width: 100%;
}
.ml5{
    margin-left: 5px;
    width: 100%;
}
.cpd{
    margin-top: 5px;
    margin-bottom: 0px;
    text-align: left !important;
    font-size: 18px;
    color: #00a0e3;
}
.intl-tel-input, .phoneInput {
    width:100% !important;
}
.intl-tel-input{
    padding-top:10px !important;
}
.flag-container{
    top:10px !important;
}
#submitBtn{
display:none;
}
.twitter-typeahead{width:100%}
.typeahead,
.tt-query,
 {
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
  margin: 0;
  top:90% !important;
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
.help-block-error{
    font-size: 13px !important;
    margin: 0 !important;
    text-align: left !important;
    color: #800000 !important;
}
body{
    margin: 0px;
    padding:0px; 
    font-family: roboto;
}
.oa-container{
    max-width: 85vw;
    margin: 0 auto;
}
.admission-form{
    background: url(' . Url::to('@eyAssets/images/pages/custom/form-bg1.png') . ');
    background-attachment: fixed;
    background-size: cover;
    min-height: 100vh;
}
.ey-logo {
    text-align: center;
    padding-top:50px;
    padding-bottom: 20px;
}
.ey-logo img{
    max-width: 200px;
}
.flex-main{
    display: flex;
    height: calc(100vh - 60px);
    align-items: center;
}
.left-sec{
    flex-basis: 50%;
    padding-left: 50px;
}
.left-sec h2{
    font-size: 30px;
    color: #333;
    line-height: 45px;
    margin-top: 0px;
}
.left-sec h2 span{
    font-size: 45px;
    color: #00a0e3
}   
.right-sec{
    flex-basis: 50%;
}
.left-sec p{
    margin:0
}
.ls-box-shadow{
    box-shadow: 0 0 10px rgba(0,0,0,.2);
    background: #fff;
    padding: 15px 20px 30px;
    max-width: 500px
}
.ls-box-shadow p{
    font-size: 21px;
    color: #333;
    text-align: center;
    font-family: roboto;
    font-weight: 500;
}
.right-sec form .form-group{
//    display: flex;
//    flex-direction: column;
    width:100%;
}
.ls-divider{
    height: 2px; 
    background: #666;
    max-width: 150px;
    margin: 15px 0;
}
.el-icons-flex{
    display: flex;
}
.el-icons{
    text-align: center;
    margin: 0 30px 0 0px;
}
.el-icons p{
    font-size: 15px;
}
.left-sec h4{
    color: #333;
}
.left-sec h3 a{
    text-decoration: none;
    color: #333;
}
.form-control{
    margin: 10px auto;
    padding: 12px 12px;
    background-color: #fff;
    border: 1px solid #c2cad8;
    width: calc(100% - 25px);
}
.form-control:focus{
//    border: 1px solid #c2cad8;
    box-shadow: 0 0 5px rgba(0,0,0,.2);
    outline: none;
}
.colorOrange{
    color: #ff7803;
}
.colorBlue{
    color: #00a0e3;
    font-size: 25px;
   
}
.button-form{
    text-align: center;
    display: flex;
    justify-content: center;
}
.btn-frm{
    width:100px;
    height:40px;
    background-color: #00a0e3;
    border: 0px solid #c2cad8;
    color: #fff;
    border-radius: 6px;
    margin: 10px 5px 0;
    cursor:pointer;
}
.btn-frm:hover{
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}
.btn-frm:focus{
    outline: none;
}
.form-flex{
    display: flex;
    width: 100%;
    justify-content: center;
    align-content: center;
    margin: 0 auto;
} 

.form-flex-2{
    display: flex;
    width: 100%;
    flex-direction: column; 
    padding: 10px 10px 0;  
} 
.font14{
    font-size: 15px;
} 
.ff-input{
    margin: 0 5px;
    flex-basis: 50%;
}
.ff-input select{
    display: block;
    width: 100%;
}
.fw-input{
    margin: 0 5px;
    flex-basis: 100%;
}
.radio-toolbar {
  margin: 0px;
}

.radio-toolbar input[type="radio"] {
  opacity: 0;
  position: fixed;
  width: 0;
}

.radio-toolbar label {
    display: inline-block;
    background-color: #fff;
    padding: 10px 20px;
    font-family: sans-serif, Arial;
    font-size: 14px;
    border: 2px solid #eee;
    border-radius: 4px;
}

.radio-toolbar label:hover {
  background-color: #00a0e3;
  border-color: #00a0e3;
  color: #fff;
}

.radio-toolbar input[type="radio"]:focus + label {
    border: 2px solid #00a0e3;
}

.radio-toolbar input[type="radio"]:checked + label {
    background-color: #00a0e3;
    border-color: #00a0e3;
    color:#fff
}

label {
  position: relative;
  margin: 0.35rem 0.35rem 0.35rem 0;
  display: flex;
  width: auto;
  align-items: center;
  cursor: pointer;
}
.check {
  margin-right: 7px;
  width: 1.35rem;
  height: 1.35rem;
}
.check #border, .check #border2 {
  fill: none;
  stroke: #7a7a8c;
  stroke-width: 3;
  stroke-linecap: round;
}
.check #dot, .check #dot2 {
  fill: url(#gradient);
  transform: scale(0);
  transform-origin: 50% 50%;
}
.check #dot2{
  fill: url(#gradient2);
}

.mb0{
    margin-bottom: 0px;
}
.mt10{
    margin-top: 10px;
}
.hideRow {
    display: none;
}

.tab {
  display: none;
}
.formActive{
    display: block !important;
}
#appliedNo p{
    font-size: 14px;
    text-align: left;
    margin-bottom: 0px;
    padding-left: 6px;
}
.ff-input .iti, .phoneInput {
    width:100% !important;
}
.ff-input .iti{
    padding-top:10px !important;
}
.iti__flag-container{
    top:10px !important;
}
.form-group p{
    font-size: 15px;
    text-align: left !important;
    margin-top: 0px;
    margin-bottom: 0px;
}
select{
    width: 100% !important;
}
@media screen and (max-width: 1030px){
    .flex-main {
        height: calc(100vh - 150px);
    }
}
@media screen and (max-width: 768px){
    .flex-main{
        flex-direction: column;
        height: unset;
        padding-bottom: 30px;
    }
    .left-sec {
        flex-basis: 100%;
        padding-left: 00px;
        text-align: center;
        width: 100%;
        padding-top: 30px
    }
    .right-sec{
        flex-basis: 100%;
        width: 100%;
    }
    .ls-box-shadow{
        max-width: unset;
        width: auto;
    }
    .ls-divider{
        margin: 0 auto;
    }
    .el-icons-flex{
        justify-content: center;
        flex-wrap: wrap;
    }
    .el-icons{
        margin: 10px 15px 0 15px;
    }
    .admission-form{
        min-height: unset;
        
    }
}
.errorBox{
    border: 1px solid indianred;
}
@media screen and (max-width: 500px){
    .left-sec h2{
        font-size: 22px;
        line-height: 32px;
    }
    .left-sec h2 span{
        font-size: 30px;
    }
}
');
$script = <<<JS
$("input[name='amount']").on("keyup", function() {
    $("input[name='amountValidation']").val(destroyMask(this.value));
    this.value = createMask($("input[name='amountValidation']").val());
})

function createMask(string) {
    return string.replace(/(\d{2})(\d{3})(\d{2})/, "$1$2$3");
}

function destroyMask(string) {
    return string.replace(/\D/g, '').substring(0, 8);
}

$(document).on('change', 'input[name = "appliedCollege"]', function() {
    var t = $(this);
    var parent = t.parent();
    var value = t.val();
    if (value == "1") {
        $('#appliedYes').show();
        $('#appliedNo').hide();
        $('#college_name').addClass('require_data');
    } else {
        $('#appliedYes').hide();
        $('#appliedNo').show();
        $('#college_name').removeClass('require_data');
    }
    parent.find('label').removeAttr('style');
    parent.find('circle').removeAttr('style');
    updateValue(t);
});

$(document).on('change', 'input[name = "interestLoanFor"]', function() {
    var t = $(this);
    var parent = t.parent();
    var val = t.val();
    var placeholderCol = "";
    switch (val) {
        case '1' :
            placeholderCol = 'College Or University Name';
            break;
        case '2' :
            placeholderCol = 'School Name';
            break;
        case '3' :
            placeholderCol = 'Other Institute Name';
            break;
            default :
    }
    $('#college_name').attr('placeholder', placeholderCol);
    $.each($('#appliedNo').find('input[id]'), function(k,v) {
        $(this).attr('placeholder', placeholderCol + ' Preference ' + (k+1));
    });
    $('[data-type=collegeApplied]').show();
    parent.find('label').removeAttr('style');
    parent.find('circle').removeAttr('style');
    updateValue(t);
});

function updateValue(t){
    var data = {};
    var value = t.val();
    if (value != "") {
        var sequence = t.attr('data-sequence');
        data['fieldName'] = t.attr('data-field');
        data['type'] = t.attr('data-type');
        data['value'] = t.val();
        data['lead_app_id'] = localStorage.getItem('lead_app_id');
        if (data['type'] == 'leadCollegePreference') {
            data['sequence'] = sequence;
        }
        $.ajax({
            url: '/leads/update-application',
            method: 'POST',
            data: data,
            'success': function(res) {
                if (res.status == 200) {
                    localStorage.setItem('lead_app_id', res.enc_id);
                }
            }
        });
    }
}

$(document).on('blur', '.blurInput', function() {
    var t = $(this);
    t.removeClass('errorBox');
    updateValue(t);
});

var currentTab = 0;
showTab(currentTab);
function showTab(n) {
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").style.display = "none";
    } else {
        document.getElementById("nextBtn").style.display = "block";
    }
}

function nextPrev(n) {
    var x = document.getElementsByClassName("tab");
    x[currentTab].style.display = "none";
    currentTab = currentTab + n;
    if (currentTab >= x.length) {
        document.getElementById("regForm").submit();
        return false;
    }
    showTab(currentTab);
}
$(document).on('click', '#prevBtn', function() {
    nextPrev(-1);
});
// $(document).on('click', '#LoanNo', function() {
//     $('#loanFields').show();
//     $('#submitBtn').show();
// });
$(document).on('click', '#nextBtn', function() {
    var isValid = true;
    var errorMsg = $('.help-block').text();
    var reqFields = $('input.req_field');
    $.each(reqFields, function(i, v) {
        var id = v.getAttribute('id');
        if (id) {
            if (v.value == "") {
                isValid = false;
            }
        }
    });
    if (errorMsg == "" && isValid) {
        nextPrev(1);
    }
});

//java script end //
getCourses();
getCollegeList(datatype = 0, source = 3, type = ['College']);

function getCourses() {
    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });
            cb(matches);
        };
    };
    var _courses = [];
    $.ajax({
        url: '/api/v3/education-loan/course-pool-list',
        method: 'GET',
        success: function(res) {
            if (res.response.status == 200) {
                res = res.response.course;
                $.each(res, function(index, value) {
                    _courses.push(value.value);
                });
            } else {
                console.log('courses could not fetch');
            }
        }
    });
    $('#course_name').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: '_courses',
        source: substringMatcher(_courses)
    });
}

function getCollegeList(datatype, source, type) {
    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });
            cb(matches);
        };
    };
    var _colleges = [];
    $.ajax({
        url: '/api/v3/companies/organization-list',
        method: 'GET',
        data: {
            datatype: datatype,
            source: source,
            type: type
        },
        success: function(res) {
            if (res.response.status == 200) {
                res = res.response.results;
                $.each(res, function(index, value) {
                    _colleges.push(value.text);
                });
            } else {
                console.log('Colleges could not fetch');
            }
        }
    });
    $('.college_name').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: '_colleges',
        source: substringMatcher(_colleges)
    });
}

function errorHandle(input, type, fieldType){
    var loop = false;
    if(type){
        input.find('label').css('color','indianred');
        input.find('circle#border').css('stroke','indianred');
    } else {
        if(fieldType){
            loop = true;
        } else {
            input.find('label').removeAttr('style');
            input.find('circle#border').removeAttr('style');
        }
    }
    if(loop){
        $.each(input, function() {
            $(this).addClass('errorBox');
        })
    }
}

function highlightRequired(chkRequire){
    var loanForRadio = $('input[name = "interestLoanFor"]');
    var loanForParent = loanForRadio.parent();
    var firstRadio = $('input[name = "appliedCollege"]');
    var firstParent = firstRadio.parent();
    if(!loanForRadio.is(":checked") && !loanForRadio.closest('section').hasClass('hideRow')){
        errorHandle(loanForParent, true);
        return false;
    } else {
        errorHandle(loanForParent, false);
    }
    if (!firstRadio.is(":checked") && firstRadio.closest('section').is(':visible')) {
        errorHandle(firstParent, true);
        return false;
    } else {
        errorHandle(firstParent, false);
    }
    if (chkRequire > 0) {
        var reqValue = $('.require_data');
        if (reqValue.val() == "") {
            errorHandle(reqValue, false, true);
            return false;
        }
    }
    return true;
}
$(document).on('click', '#LoanNo', function(event) {
    var chkRequire = $('.require_data').length;
    var res = highlightRequired(chkRequire);
    if(!res){
        return false;
    }
    $('#loanFields').show();
    $('#submitBtn').show();
});
$(document).on('click', '#LoanYes', function(event) {
    var btn = $("#submitBtn");
    var inputData = type = true;
    var chkRequire = $('.require_data').length;
    var res = highlightRequired(chkRequire);
    if(!res){
        return false;
    }
    var secondRadio = $('input[name = "loan"]');
    if (secondRadio.is(":checked")) {
        if (chkRequire > 0) {
            inputData = false;
            if ($('.require_data').val() != "") {
                inputData = true;
            }
        }
        if (inputData) {
            var form = $('#application_form');
            var data = form.serializeArray();
            var lead_id = localStorage.getItem('lead_app_id');
            data.push({
                name: 'lead_id',
                value: lead_id
            });
            $.ajax({
                type: 'POST',
                data: data,
                beforeSend: function() {
                    btn.prop('disabled', 'disabled');
                    swal({
                        title: 'Processing',
                        type: "success",
                        showCancelButton: false,
                        confirmButtonText: false,
                        showConfirmButton: false,
                    });
                    localStorage.removeItem('lead_app_id');
                },
                success: function(response) {
                    btn.prop('disabled', false);
                    if (response.status == 200) {
                        window.location.href = "/education-loans/apply?lid=" + lead_id;
                    } else {
                        $("input[name = 'loan']").prop("checked", false);
                        swal({
                            title: response.title,
                            text: response.message,
                            type: "error",
                            showCancelButton: false,
                            confirmButtonText: "Ok!",
                        });
                    }
                }
            });
        }
    }
});

$(document).on('click', '#submitBtn', function(event) {
    var btn = $(this);
    var firstRadio = $('input[name = "appliedCollege"]').is(":checked");
    var secondRadio = $('input[name = "loan"]').is(":checked");
    if (firstRadio && secondRadio) {
        var inputData = true;
        var chkRequire = $('.require_data').length;
        if (chkRequire > 0) {
            inputData = false;
            if ($('.require_data').val() != "") {
                inputData = true;
            }
        }
        if (inputData) {
            var form = $('#application_form');
            var data = form.serializeArray();
            var lead_id = localStorage.getItem('lead_app_id');
            data.push({
                name: 'lead_id',
                value: lead_id
            });
            $.ajax({
                type: 'POST',
                data: data,
                beforeSend: function() {
                    btn.prop('disabled', 'disabled');
                },
                success: function(response) {
                    btn.prop('disabled', false);
                    if (response.status == 200) {
                        form[0].reset();
                        $('#submitBtn').hide();
                        swal({
                            title: response.title,
                            text: response.message,
                            type: "success",
                            showCancelButton: false,
                            showConfirmButton: false,
                            conFfirmButtonText: false,
                            closeOnConfirm: false,
                            closeOnCancel: false
                        });
                        localStorage.removeItem('lead_app_id');
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    } else {
                        swal({
                            title: response.title,
                            text: response.message,
                            type: "error",
                            showCancelButton: false,
                            confirmButtonText: "Ok!",
                        });
                    }
                }
            });
        }
    }
});
JS;
$this->registerJs($script);
?>
    <script>

    </script>
<?php
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
