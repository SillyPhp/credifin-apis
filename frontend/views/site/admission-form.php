<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use borales\extensions\phoneInput\PhoneInput;
use kartik\widgets\Select2;
$degrees = ['Diploma' => 'Diploma','Graduation' => 'Graduation','Post Graduation' => 'Post Graduation','Professional Course' =>'Professional Course','Others' => 'Others']
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
                    <h4 class="mt10">Get Interest Free <span class="colorOrange">Education Loans</span> both in
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
                    <h3>Only on
                        <a href="/education-loans">
                            <span class="colorBlue">Empower</span><span class="colorOrange">Youth</span>.com
                        </a>
                    </h3>
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
//                                'options' => ['class' => ''],
                                'template' => '',
                                'labelOptions' => ['class' => ''],
                            ],
                        ]); ?>
                        <form>
                            <div class="form-group" id="step1">
                                <div class="form-flex">
                                    <?= $form->field($model, 'first_name', ['template' => '<div class="ff-input">{input}{error}</div>'])->textInput(['class' => 'form-control', 'placeholder' => 'First Name'])->label(false); ?>
                                    <?= $form->field($model, 'last_name', ['template' => '<div class="ff-input">{input}{error}</div>'])->textInput(['class' => 'form-control', 'placeholder' => 'Last Name'])->label(false); ?>
                                </div>

                                <div class="form-flex">
                                    <?= $form->field($model, 'email', ['enableAjaxValidation' => true, 'template' => '<div class="ff-input">{input}{error}</div>'])->textInput(['class' => 'form-control', 'placeholder' => 'Email'])->label(false); ?>
                                    <?= $form->field($model, 'phone', ['enableAjaxValidation' => true, 'template' => '<div class="ff-input">{input}{error}</div>'])->textInput(['class' => 'form-control', 'placeholder' => 'Contact Number (WhatsApp)'])->label(false); ?>
                                </div>

                                <div class="form-flex">
                                    <?= $form->field($model, 'degree', ['template' => '<div class="ff-input">{label}{input}{error}</div>'])->dropDownList($degrees, ['prompt' => 'Select Degree'])->label(false); ?>
                                    <?= $form->field($model, 'course', ['template' => '<div class="ff-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize', 'placeholder' => 'Course Name', 'autocomplete' => 'off', 'id' => 'course_name'])->label(false); ?>
                                </div>

                                <div class="form-flex-2">
                                    <div class="font14">Have You Already Taken Admission In College</div>
                                    <div class="radio-container">
                                        <input class="already_admission" type="radio" name="field" id="Uno" data-id="1"/>
                                        <label for="Uno">
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
                                        <input class="already_admission" type="radio" name="field" id="Dos" data-id="0"/>
                                        <label for="Dos">
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
                                <div id="college">
                                    <div class="form-flex">
                                        <?= $form->field($model, 'college', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize college_name', 'placeholder' => 'College Or University Name', 'autocomplete' => 'off', 'id' => 'college_name'])->label(false); ?>
                                    </div>
                                </div>
                                <div id="college_preference">
                                    <div class="form-flex">
                                        <?= $form->field($model, 'preference_college1', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize college_name', 'placeholder' => 'College Or University Name Preference 1', 'autocomplete' => 'off', 'id' => 'college_preference1'])->label(false); ?>
                                    </div>
                                    <div class="form-flex">
                                        <?= $form->field($model, 'preference_college2', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize college_name', 'placeholder' => 'College Or University Name Preference 2', 'autocomplete' => 'off', 'id' => 'college_preference2'])->label(false); ?>
                                    </div>
                                    <div class="form-flex">
                                        <?= $form->field($model, 'preference_college3', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize college_name', 'placeholder' => 'College Or University Name Preference 3', 'autocomplete' => 'off', 'id' => 'college_preference3'])->label(false); ?>
                                    </div>
                                </div>

                                <div class="form-flex">
                                    <?= $form->field($model, 'amount', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'form-control','placeholder' => 'Loan Amount Required (Optional)','autocomplete' => 'off','id' => 'amount'])->label(false); ?>
                                </div>
                            </div>
                            <div class="form-group" id="step2">
                                <div class="form-flex">
                                     <?= $form->field($model, 'username', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'form-control','placeholder' => 'Username','autocomplete' => 'off','id' => 'username'])->label(false); ?>
                                </div>
                                <div class="form-flex">
                                    <?= $form->field($model, 'new_password', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'form-control','placeholder' => 'New Password','autocomplete' => 'off','id' => 'password'])->label(false); ?>
                                </div>
                                <div class="form-flex">
                                    <?= $form->field($model, 'confirm_password', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'form-control','placeholder' => 'confirm_password','autocomplete' => 'off','id' => 'confirm_password'])->label(false); ?>
                                </div>
                            </div>

                            <div class="button-form">
                                <button type="button" class="btn-frm" id="nextBtn" name="submitButton">Next</button>
                                <?= Html::submitButton('Submit', ['class' => 'btn-frm','id' => 'submitBtn', 'onclick' => "return Validate()"]) ?>
                            </div>

                        </form>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
#college{
display:none;
}
#college_preference{
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
    display: flex;
    flex-direction: column;
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
.check #border {
  fill: none;
  stroke: #7a7a8c;
  stroke-width: 3;
  stroke-linecap: round;
}
.check #dot {
  fill: url(#gradient);
  transform: scale(0);
  transform-origin: 50% 50%;
}

.radio-container input {
  display: none;
}
.radio-container input:checked + label {
  background: linear-gradient(180deg, #0db6fc, #00a0e3);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.radio-container input:checked + label svg #border {
  stroke: url(#gradient);
  stroke-dasharray: 145;
  stroke-dashoffset: 145;
  animation: checked 500ms ease forwards;
}
.radio-container input:checked + label svg #dot {
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
#step2, #submitBtn{
    display: none;
}
.help-block-error{
    font-size: 13px !important;
    margin: 0 !important;
    text-align: left !important;
    color: #800000 !important;
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
.select2-selection__clear{
    padding-right: revert !important;
}
');
$script = <<<JS
$(document).on('click','.already_admission', function() {
   var ths = $(this);
   var id = ths.attr('data-id');
   var college = $('#college');
   var preference = $('#college_preference');
   if(id == 1){
       college.show(); 
       preference.hide();
   } else if(id == 0){
       college.hide(); 
       preference.show();
   }
}); 
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
        function Validate() {
        var new_password = document.getElementById("new_password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        if (new_password != confirmPassword) {
            swal({
            title:"",
            text: "Passwords do not match !!",
        });
            return false;
        }
        return true;
    }
    $(document).on('click', '#submitBtn', function (event) {
        event.stopImmediatePropagation();
        event.preventDefault();
        var btn = $(this);
        var form = $('#application_form');
        var data = form.serialize();
        $.ajax({
            url: '/site/admission',
            type: 'POST',
            data: data,
            beforeSend: function (){
                btn.prop('disabled', 'disabled');
            },
            success: function (response) {
                if (response.status == 'success') {
                    // toastr.success(response.message, response.title);
                } else {
                    toastr.error(response.message, response.title);
                }
            }
        });
    });
JS;
$this->registerJs($script);
?>
    <script>
        let nextBtn = document.getElementById('nextBtn');
        nextBtn.onclick = function () {
            let step1 = document.getElementById('step1');
            let step2 = document.getElementById('step2');
            let headingText = document.getElementById('headingText');
            let submitBtn = document.getElementById('submitBtn');

            let stepActive = document.getElementsByClassName('stepActive');
            if (stepActive.length == 1) {
                step1.style.display = "block";
                step2.style.display = "none";
                step2.classList.remove('stepActive');

                submitBtn.style.display = "none";
                nextBtn.innerHTML = "Next";
                headingText.innerHTML = "Fill Me For Your Bright Future";
            } else {
                step1.style.display = "none";
                step2.style.display = "block";
                step2.classList.add('stepActive');

                submitBtn.style.display = "block";
                headingText.innerHTML = "Please Sign Up";
                nextBtn.innerHTML = "Previous";

            }
        }
    </script>
<?php
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@root/assets/common/select2Plugin/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@root/assets/common/select2Plugin/select2.min.css');