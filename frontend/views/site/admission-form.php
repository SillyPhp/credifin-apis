<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use borales\extensions\phoneInput\PhoneInput;
?>

    <section class="admission-form">
        <div class="oa-container">
            <div class="ey-logo">
                <a href="/"> <img src="<?= Url::to('@commonAssets/logos/logo.svg') ?>"></a>
            </div>
            <div class="flex-main">
                <div class="left-sec">
                    <h2>Get Admission In Your <br><span>Dream Colleges</span> <br>Without Any Hassle</h2>
                    <div class="ls-divider"></div>
                    <h4 class="mb0">Don’t Let Money Stop You From Getting into Your Dream College!</h4>
                    <h4 class="mt10"><span class="colorOrange">Education Loans</span> available for
                        <span class="colorOrange">India</span> and <span class="colorOrange">Abroad</span>.</h4>
                    <div class="el-icons-flex">
                        <div class="el-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/loan-application.png') ?>">
                            <p>Online <br>Application</p>
                        </div>
                        <div class="el-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/quick-sanction.png') ?>">
                            <p>Quick <br>Sanction</p>
                        </div>
                        <div class="el-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/collateral.png') ?>">
                            <p>Collateral Free <br>Loans</p>
                        </div>
                    </div>
                    <h4>Interest Free Loans available for select Colleges/Universities</h4>
                    <h4>Loan Starting from as low as 9% p.a.</h4>
                </div>
                <div class="right-sec">
                    <div class="ls-box-shadow">
                        <p id="headingText">Fill Me For Your Bright Future</p>
                        <?php $form = ActiveForm::begin([
                            'id' => 'application_form',
                            'options' => [
                                'class' => 'clearfix',
                            ],
                            'fieldConfig' => [
                                'template' => '',
                                'labelOptions' => ['class' => ''],
                            ],
                        ]); ?>
                        <div class="form-group tab" data-id="step1">
                            <div class="form-flex">
                                <?= $form->field($model, 'first_name', ['template' => '<div class="ff-input">{input}{error}</div>'])->textInput(['class' => 'form-control req_field', 'placeholder' => 'First Name'])->label(false); ?>
                                <?= $form->field($model, 'last_name', ['template' => '<div class="ff-input">{input}{error}</div>'])->textInput(['class' => 'form-control req_field', 'placeholder' => 'Last Name'])->label(false); ?>
                            </div>

                            <div class="form-flex">
                                <?= $form->field($model, 'email', ['template' => '<div class="ff-input">{input}{error}</div>'])->textInput(['class' => 'form-control req_field', 'placeholder' => 'Email'])->label(false); ?>
                                <?= $form->field($model, 'phone', ['template' => '<div class="ff-input">{input}{error}</div>'])->textInput()->widget(PhoneInput::className(), [
                                    'jsOptions' => [
                                        'allowExtensions' => false,
                                        'preferredCountries' => ['in'],
                                        'nationalMode' => false,
                                    ],
                                    'options' => [
                                        'class' => 'form-control req_field phoneInput'
                                    ]
                                ])->label(false); ?>
                            </div>

                            <div class="form-flex">
                                <?= $form->field($model, 'course', ['template' => '<div class="ff-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize req_field', 'placeholder' => 'Course Name', 'autocomplete' => 'off', 'id' => 'course_name'])->label(false); ?>
                            </div>
                        </div>

                        <div class="form-group tab" data-id="step2">
                            <div class="form-flex-2">
                                <div class="font14">Have You Already Taken Admission In College?</div>
                                <div class="radio-container">
                                    <input type="radio" name="appliedCollege" id="yes" value="yes">
                                    <label for="yes">
                                        <svg class="check" viewbox="0 0 40 40">
                                            <defs>
                                                <linearGradient id="gradient" x1="0" y1="0" x2="0" y2="100%">
                                                    <stop offset="0%" stop-color="#0db6fc"></stop>
                                                    <stop offset="100%" stop-color="#00a0e3"></stop>
                                                </linearGradient>
                                            </defs>
                                            <circle id="border" r="18px" cx="20px" cy="20px"></circle>
                                            <circle id="dot" r="8px" cx="20px" cy="20px"></circle>
                                        </svg>
                                        Yes
                                    </label>
                                    <input type="radio" name="appliedCollege" id="no" value="no">
                                    <label for="no">
                                        <svg class="check" viewbox="0 0 40 40">
                                            <defs>
                                                <linearGradient id="gradient" x1="0" y1="0" x2="0" y2="100%">
                                                    <stop offset="0%" stop-color="#0db6fc"></stop>
                                                    <stop offset="100%" stop-color="#00a0e3"></stop>
                                                </linearGradient>
                                            </defs>
                                            <circle id="border" r="18px" cx="20px" cy="20px"></circle>
                                            <circle id="dot" r="8px" cx="20px" cy="20px"></circle>
                                        </svg>
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="form-group" id="appliedYes">
                                <div class="form-flex">
                                    <?= $form->field($model, 'college', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize college_name', 'placeholder' => 'College Or University Name', 'autocomplete' => 'off', 'id' => 'college_name'])->label(false); ?>
                                </div>
                            </div>

                            <div class="form-group" id="appliedNo">
                                <p>Please Mention Your Three Preferred Colleges</p>
                                <div class="form-flex">
                                    <?= $form->field($model, 'preference_college1[]', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize college_name', 'placeholder' => 'College Or University Name Preference 1', 'autocomplete' => 'off', 'id' => 'college_preference1'])->label(false); ?>
                                </div>
                                <div class="form-flex">
                                    <?= $form->field($model, 'preference_college1[]', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize college_name', 'placeholder' => 'College Or University Name Preference 2', 'autocomplete' => 'off', 'id' => 'college_preference2'])->label(false); ?>
                                </div>
                                <div class="form-flex">
                                    <?= $form->field($model, 'preference_college1[]', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize college_name', 'placeholder' => 'College Or University Name Preference 3', 'autocomplete' => 'off', 'id' => 'college_preference3'])->label(false); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-flex-2">
                                    <div class="font14">Do You want to apply for Education Loan Now?</div>
                                    <div class="radio-container">
                                        <input type="radio" name="loan" id="LoanYes" value="Loanyes">
                                        <label for="LoanYes">
                                            <svg class="check" viewbox="0 0 40 40">
                                                <defs>
                                                    <linearGradient id="gradient2" x1="0" y1="0" x2="0" y2="100%">
                                                        <stop offset="0%" stop-color="#0db6fc"></stop>
                                                        <stop offset="100%" stop-color="#00a0e3"></stop>
                                                    </linearGradient>
                                                </defs>
                                                <circle id="border2" r="18px" cx="20px" cy="20px"></circle>
                                                <circle id="dot2" r="8px" cx="20px" cy="20px"></circle>
                                            </svg>
                                            Yes
                                        </label>
                                        <input type="radio" name="loan" id="LoanNo" value="LoanNo">
                                        <label for="LoanNo">
                                            <svg class="check" viewbox="0 0 40 40">
                                                <defs>
                                                    <linearGradient id="gradient2" x1="0" y1="0" x2="0" y2="100%">
                                                        <stop offset="0%" stop-color="#0db6fc"></stop>
                                                        <stop offset="100%" stop-color="#00a0e3"></stop>
                                                    </linearGradient>
                                                </defs>
                                                <circle id="border2" r="18px" cx="20px" cy="20px"></circle>
                                                <circle id="dot2" r="8px" cx="20px" cy="20px"></circle>
                                            </svg>
                                            No, I am Just Inquiring.
                                        </label>
                                    </div>
                                </div>
                                <div id="loanFields">
                                    <div class="form-flex">
                                        <?= $form->field($model, 'amount', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'form-control', 'placeholder' => 'Loan Amount', 'type' => 'text','autocomplete' => 'off', 'id' => 'amount'])->label(false); ?>
                                        <input type="text" name="amountValidation" style="display:none;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="button-form">
                            <button type="button" id="prevBtn" class="btn-frm">Previous</button>
                            <button type="button" id="nextBtn" class="btn-frm">Next</button>
                            <?= Html::button('Submit', ['class' => 'btn-frm', 'id' => 'submitBtn']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
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
.radio-container{
    display: flex;
    
}
.radio-container svg {
  width: 1.35rem;
  height: 1.35rem;
}
.radio-container svg.gear {
  order: 1;
  margin-left: 1.35rem;
  cursor: help;
}
.radio-container svg.gear:hover ~ h4 {
  transform: scale(1);
}
label {
  position: relative;
  margin: 0.675rem 1.35rem 0.675rem 0;
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
.radio-container input {
  display: none;
}
.radio-container input:checked + label {
    background: linear-gradient(180deg, #0db6fc, #00a0e3);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.radio-container input:checked + label svg #border,
.radio-container input:checked + label svg #border2{
    stroke: url(#gradient);
    stroke-dasharray: 145;
    stroke-dashoffset: 145;
    animation: checked 500ms ease forwards;
}
.radio-container input:checked + label svg #border2{
    stroke: url(#gradient2);
}
.radio-container input:checked + label svg #dot,
.radio-container input:checked + label svg #dot2{
    transform: scale(1);
    transition: transform 500ms cubic-bezier(0.57, 0.21, 0.69, 3.25);
}

@keyframes checked {
  to {
    stroke-dashoffset: 0;
  }
}

.mb0{
    margin-bottom: 0px;
}
.mt10{
    margin-top: 10px;
}
#appliedNo, #appliedYes, #loanFields {
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
//java script start //

$("input[name='amount']").on("keyup", function(){
    $("input[name='amountValidation']").val(destroyMask(this.value));
    this.value = createMask($("input[name='amountValidation']").val());
})

function createMask(string){
	return string.replace(/(\d{2})(\d{3})(\d{2})/,"$1$2$3");
}

function destroyMask(string){
	return string.replace(/\D/g,'').substring(0, 8);
}

  $(document).on('click','input[name = "appliedCollege"]',function (){
      var t = $(this);
      var id = t.attr('id');
      if(id == 'yes'){
          $('#appliedYes').show();
          $('#appliedNo').hide();
          $('#college_name').addClass('require_data');
      } else {
          $('#appliedYes').hide();
          $('#appliedNo').show();
          $('#college_name').removeClass('require_data');
      }
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
       $(document).on('click','#prevBtn',function ()
       {
           nextPrev(-1);
       });
       $(document).on('click','#LoanNo',function ()
       {
           $('#loanFields').show();
           $('#submitBtn').show();
       });
        $(document).on('click','#nextBtn',function ()
       {
           var isValid = true;
           var errorMsg = $('.help-block').text();
           var reqFields = $('input.req_field');
           $.each(reqFields, function(i, v) {
                var id = v.getAttribute('id');
                if(id){
                    if(v.value == ""){
                        isValid = false;
                    }
                }
           });
           if(errorMsg == "" && isValid){
                nextPrev(1);
           }
       });
        
//java script end //
    getCourses(); 
    getCollegeList(); 
function getCourses()
    {
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
            url : '/api/v3/education-loan/course-pool-list', 
            method : 'GET',
            success : function(res) {
            if (res.response.status==200){
                 res = res.response.course;
                $.each(res,function(index,value) 
                  {   
                   _courses.push(value.value);
                  }); 
               } else
                {
                   console.log('courses could not fetch');
                }
            } 
        });
        $('#course_name').typeahead({
             hint: true, 
             highlight: true,
             minLength: 1
            },
        {
         name: '_courses',
         source: substringMatcher(_courses)
        }); 
    }
    function getCollegeList()
    {
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
            url : '/api/v3/companies/organization-list', 
            method : 'GET',
            success : function(res) {
            if (res.response.status==200){
                 res = res.response.results;
                $.each(res,function(index,value) 
                  {   
                   _colleges.push(value.text);
                  }); 
               } else
                {
                   console.log('Colleges could not fetch');
                }
            } 
        });
        $('.college_name').typeahead({
             hint: true, 
             highlight: true,
             minLength: 1
            },
        {
         name: '_colleges',
         source: substringMatcher(_colleges)
        }); 
    }
    
    $(document).on('click','#LoanYes',function (event)
       { 
       var btn = $("#submitBtn");
        var firstRadio = $('input[name = "appliedCollege"]').is(":checked");
        var inputData = true;
        var chkRequire = $('.require_data').length;
        
       if(!firstRadio){
            return false;
       } else {
            if(chkRequire > 0){
                if($('.require_data').val() == ""){
                   return false;
                }
            }
       }
        var secondRadio = $('input[name = "loan"]').is(":checked");
        if(firstRadio && secondRadio){
            if(chkRequire > 0){
                inputData = false;
                if($('.require_data').val() != ""){
                    inputData = true;
                }
            }
           if (inputData){
               var form = $('#application_form');
               var data = form.serialize();
               $.ajax({
                    type: 'POST',
                    data: data,
                    beforeSend: function (){
                        btn.prop('disabled', 'disabled');
                        swal({
                            title: 'Processing',
                            type: "success",
                            showCancelButton: false,
                            confirmButtonText: false,
                            showConfirmButton: false,
                        });
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if (response.status == 200) {
                            window.location.pathname = "/education-loans/apply";
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

    $(document).on('click', '#submitBtn', function (event) {
        var btn = $(this);
        var firstRadio = $('input[name = "appliedCollege"]').is(":checked");
        var secondRadio = $('input[name = "loan"]').is(":checked");
        if(firstRadio && secondRadio){
            var inputData = true;
            var chkRequire = $('.require_data').length;
           if(chkRequire > 0){
                inputData = false;
                if($('.require_data').val() != ""){
                    inputData = true;
                }
           }
           if (inputData){
               var form = $('#application_form');
               var data = form.serialize();
               $.ajax({
                    type: 'POST',
                    data: data,
                    beforeSend: function (){
                        btn.prop('disabled', 'disabled');
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        form[0].reset();
                        if (response.status == 200) {
                            swal({
                                title: response.title,
                                text: response.message,
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: false,
                                confirmButtonText: false,
                                closeOnConfirm: false,
                                closeOnCancel: false
                            });
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
