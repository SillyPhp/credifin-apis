<?php
use yii\helpers\Url;
use kartik\widgets\Select2;
$this->title = 'Education Loan';
$this->params['header_dark'] = true;
if (Yii::$app->params->paymentGateways->mec->icici) {
    $configuration = Yii::$app->params->paymentGateways->mec->icici;
    if ($configuration->mode === "production") {
        $access_key = $configuration->credentials->production->access_key;
        $secret_key = $configuration->credentials->production->secret_key;
        $url = $configuration->credentials->production->url;
    } else {
        $access_key = $configuration->credentials->sandbox->access_key;
        $secret_key = $configuration->credentials->sandbox->secret_key;
        $url = $configuration->credentials->sandbox->url;
    }
}
Yii::$app->view->registerJs('var access_key = "' .$access_key. '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var userID = "' .Yii::$app->user->identity->user_enc_id. '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var default_country = "' .$india. '"', \yii\web\View::POS_HEAD);
?>
    <script id="context" type="text/javascript" src="https://payments.open.money/layer"></script>
    <section class="bg-blue">
        <div class="sign-up-details bg-white" id="sd">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-start">
                        <form action="" id="myForm">
                            <div class="tab" id="step1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="heading-style">Education Loan</h1>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="number" class="input-group-text">
                                            Name of Applicant (Student Name)
                                        </label>
                                        <input type="text" class="form-control text-capitalize" id="applicant_name" name="applicant_name" placeholder="Enter Full Name">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="number" class="input-group-text">
                                            Date Of Birth (mm/dd/yyyy)
                                        </label>
                                        <div class="input-group date" data-provide="datepicker" class="datepicker3">
                                            <input type="text" class="form-control" name="dob" id="dob" placeholder="Date Of Birth">
                                            <div class="input-group-addon">
                                                <span class=""><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label class="input-group-text" for="inputGroupSelect01">
                                            Choose Country where you want to study
                                        </label>
                                        <ul class="displayInline">
                                            <li>
                                                <label class="container-radio">India
                                                    <input type="radio" checked="checked" id="india" value="1" onclick="showCountry(this)" name="countryRadio">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="container-radio">Outside India
                                                    <input type="radio" id="othercountry" value="0" onclick="showCountry(this)" name="countryRadio">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20" id="countryName">
                                    <div class="form-group">
                                        <div class="radio-heading input-group-text">
                                            Select Country
                                        </div>
                                        <select class="form-control" name="country_name" id="country_name">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label class="input-group-text" for="inputGroupSelect02">
                                            Current city where you live
                                        </label>
                                        <input type="text" name="location" id="location" class="form-control text-capitalize"
                                               autocomplete="off" placeholder="City"/>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <div class="radio-heading input-group-text">
                                            Which degree do you want to pursue
                                        </div>
                                        <select class="form-control" name="degree" id="degree">
                                            <option value="Diploma">Diploma</option>
                                            <option value="Graduation">Graduation</option>
                                            <option value="Post Graduation">Post Graduation</option>
                                            <option value="Professional Course">Professional Course</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="college_name" class="input-group-text">
                                            College / University Name
                                        </label>
                                        <select class="form-control" id="college_name" name="college_name">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="course_name" class="input-group-text">
                                            Course Name
                                        </label>
                                        <div id="the-basics">
                                            <input type="text" placeholder="Enter Course Name" class="typeahead form-control text-capitalize" id="course_name_text" name="course_name_text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 padd-20">
                                    <div class="form-group">
                                        <div class="radio-heading input-group-text">
                                            Year
                                        </div>
                                        <select class="form-control" name="years" id="years">
                                            <option value="1">1st Year</option>
                                            <option value="2">2st Year</option>
                                            <option value="3">3rd Year</option>
                                            <option value="4">4th Year</option>
                                            <option value="5">5th Year</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 padd-20">
                                    <div class="form-group">
                                        <div class="radio-heading input-group-text">
                                            Semester
                                        </div>
                                        <select class="form-control" value="semesters" id="semesters">
                                            <option value="1">1st Semester</option>
                                            <option value="2">2st Semester</option>
                                            <option value="3">3rd Semester</option>
                                            <option value="4">4th Semester</option>
                                            <option value="5">5th Semester</option>
                                            <option value="6">6th Semester</option>
                                            <option value="7">7th Semester</option>
                                            <option value="8">8th Semester</option>
                                            <option value="9">9th Semester</option>
                                            <option value="10">10th Semester</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="number" class="input-group-text">
                                            Phone Number (WhatsApp & Call)
                                        </label>
                                        <input type="text" class="form-control" id="mobile" name="mobile"
                                               placeholder="Enter Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="email" class="input-group-text">
                                            Email Address
                                        </label>
                                        <input type="text" class="form-control" id="email" name="email"
                                               placeholder="Enter Email Address">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="input-group padd-20">
                                        <div class="btn-center">
                                            <button type="button" class="button-slide" id="nextBtn">
                                                Next
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab" id="step2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="heading-style">Additional Details</h1>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group ">
                                        <div class="radio-heading input-group-text">
                                            Gender
                                        </div>
                                        <ul class="displayInline">
                                            <li>
                                                <label class="container-radio">Male
                                                    <input type="radio" checked="checked" name="genderRadio" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="container-radio">Female
                                                    <input type="radio" name="genderRadio" value="2">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="annulIncome" class="input-group-text">
                                            Loan Amount Required
                                        </label>
                                        <input type="text" class="form-control" id="loanamount" name="loanamount"
                                               placeholder="Enter Loan Amount">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="aadhaarnumber" class="input-group-text">
                                            Aadhaar Card Number
                                        </label>
                                        <input type="text" class="form-control" id="aadhaarnumber" name="aadhaarnumber"
                                               placeholder="Enter 12 digits Aadhaar Card Number">
                                    </div>
                                </div>
<!--                                <div class="col-md-12 padd-20">-->
<!--                                    <div class="form-group">-->
<!--                                        <div class="radio-heading input-group-text">-->
<!--                                            Purpose Of Loan (You Can Select Multiple)-->
<!--                                        </div>-->
<!--                                        <ul id="loan-purpose">-->
<!---->
<!--                                        </ul>-->
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="col-md-12 padd-20">
                                    <div id="addAnotherCo">
                                        <div class="coapplicant"><div class="col-md-12 padd-20 display-flex"><span class="input-group-text">Borrower's Details</span>
                                            </div>
                                            <div class="col-md-12 padd-20">
                                                <div class="form-group">
                                                    <label for="co-name[]" class="input-group-text">
                                                        Name
                                                    </label>
                                                    <input type="text" name="co-name[1]" class="form-control text-capitalize" id="co-name" placeholder="Enter Full Name">
                                                </div>
                                            </div>
                                            <div class="col-md-12 padd-20">
                                                <div class="form-group">
                                                    <div class="radio-heading input-group-text">
                                                        Relation
                                                    </div>
                                                    <ul id="co-relation-ul-1">
                                                        <li class="service-list">
                                                            <input type="radio" value="Father" checked="checked" name="co-relation[1]" id="co-father-1" class="checkbox-input services">
                                                            <label for="co-father-1">Father</label>
                                                        </li>
                                                        <li class="service-list">
                                                            <input type="radio" value="Mother" name="co-relation[1]" id="co-mother-1" class="checkbox-input services">
                                                            <label for="co-mother-1">Mother</label>
                                                        </li>
                                                        <li class="service-list">
                                                            <input type="radio" value="Brother" name="co-relation[1]" id="co-brother-1" class="checkbox-input services">
                                                            <label for="co-brother-1">Brother</label>
                                                        </li>
                                                        <li class="service-list">
                                                            <input type="radio" value="Sister" name="co-relation[1]" id="co-sister-1" class="checkbox-input services">
                                                            <label for="co-sister-1">Sister</label>
                                                        </li>
                                                        <li class="service-list">
                                                            <input type="radio" value="Guardian" name="co-relation[1]" id="co-guardian-1" class="checkbox-input services">
                                                            <label for="co-guardian-1">Guardian</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-12 padd-20">
                                                <div class="form-group">
                                                    <div class="radio-heading input-group-text">
                                                        Employment type ?
                                                    </div>
                                                    <ul class="displayInline">
                                                        <li>
                                                            <label class="container-radio">Salaried
                                                                <input type="radio" value="1" checked="checked" name="co-emptype[1]">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="container-radio">Self-Employed
                                                                <input type="radio" value="2" name="co-emptype[1]">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="container-radio">Non-Working
                                                                <input type="radio" value="0" name="co-emptype[1]">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-12 padd-20">
                                                <div class="form-group">
                                                    <label for="co-anualincome" class="input-group-text">
                                                        Annual Income
                                                    </label>
                                                    <input type="text" name="co-anualincome[1]" class="form-control" id="co-anualincome" placeholder="Enter Annual Income">
                                                </div>
                                            </div>
                                            <div class="col-md-12 padd-20">
                                                <div class="form-group">
                                                    <label for="co-pancard" class="input-group-text">
                                                        Pan Card Number
                                                    </label>
                                                    <input type="text" name="co-pancard[1]" class="form-control" id="co-pancard" placeholder="Enter 10 Digit Pan Card Number">
                                                </div>
                                            </div>
                                            <div class="col-md-12 padd-20">
                                                <div class="form-group">
                                                    <label for="coaadhaarnumber" class="input-group-text">
                                                        Aadhaar Number
                                                    </label>
                                                    <input type="text" name="co-aadhaarnumber[1]" class="form-control" id="coaadhaarnumber" placeholder="Enter 12 Digit Aadhaar Number">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 padd-20 displayFlex" id="addAnotherButton">
                                        <button type="button" class="addAnotherCo input-group-text" onclick="addAnotherCo(value = randomVal())"> <i class="fas fa-plus-square"></i> Add Another Co-Borrower (You Can Add Multiple If You Want)</button>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="input-group padd-20">
                                        <div class="btn-center">
                                            <button type="button" class="button-slide" id="prevBtn">
                                                Previous
                                            </button>
                                            <button type="button" class="button-slide" id="subBtn">
                                                Submit
                                            </button>
                                            <button type="button" class="button-slide btn btn-block" id="loadBtn">
                                                Processing <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="college-logo" id="cl">
            <div class="row">
                <div class="col-md-12">
                    <div class="el-pos-rel">
                        <div class="max-300">
                            <div class="cl-heading">Get the Best Education Loan</div>
                            <ul class="loan-benefits">
                                <li>- <span>No Security</span> Loans upto 2 Lakhs.</li>
                                <li>- <span>100% Financing</span> will be provided which includes all expenses borne by
                                    the students in a particular <span>academic year</span>.</li>
                                <li>- Loan will be <span>repaid</span> with in the semester</li>
                            </ul>
                            <div class="cl-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/edu-loan-icon.png') ?>"
                                     alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<input type="hidden" name="colg_text" id="colg_text">
<input type="hidden" name="colg_id" id="colg_id">
<input type="hidden" name="course_text" id="course_text">
<input type="hidden" name="pulled_from" id="pulled_from">
<?php
$this->registerCss('
#loadBtn{
display:none;
}

.padd-20{
    padding-bottom: 20px;
}
.loan-benefits li{
    color:#f3f3f2;
    font-size: 16px;    
}
.loan-benefits{list-style:none}
.loan-benefits li span{
    font-weight: bold;
    color:#fff;
}
button{
border: 1px solid #ddd !important;
}
#countryName{
    display: none;
}
#relationInput{
    display: none;
    margin-top: 10px; 
}
.form-heading{
    font-weight: bold;
    font-size: 20px;
    color:#000;
    padding-bottom: 5px;
    font-family: lora;
    border-bottom: 2px solid #eee;
    margin-bottom: 10px;
}
.form-heading span{
    float: right;
    color: #00a0e3
}
.thankyou-text{
    text-align: center;
    font-size: 20px;
    text-transform: capitalize;
}
.float-right{
    float:right;
    padding-top: 3px;
    color: #333 !important;
}
.addAnotherCo{
    background: none;
    border:none;
    margin-bottom:20px;
}
.addAnotherCo:hover{
    color:#00a0e3;
    transition: .3s ease;
}
.displayInline li{
    display:inline-block;
    padding-right:20px;
}
.cl-icon img{
    margin-top: 30px;
    max-height: 300px;
}
.form-start{
    max-width:400px;
    margin: 0 auto;
}
.custom-select:active{
    border:none;
}
.btn-center{
    text-align:center;
    display: flex;
    justify-content: center;
}
.btn-center button{
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    padding: 13px 32px;
    border-radius: 4px;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
    color: #222;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    margin-left: 5px;
    background: #fff;
    border:none;
}
.btn-center button:hover{
    background-color: #00a0e3;
    color: #fff;
}
.max-300{
    max-width:350px;
    margin:0 auto;
}
.sign-up-details {
    padding: 60px 25px 0 25px;
    background: linear-gradient(to bottom, #e9f5f5 0%, #fefefe 100%);
    min-height: 100%;
    width:50vw;
    position:absolute;
    min-height:100vh;
}
.college-logo {
    margin-left:50vw;
    padding:60px 25px 0 25px;
    text-align:center;
    color:#000;
    width:50vw;
    min-height:100vh;
    position:fixed;
    background:#00a0e3;
}
@media only screen and (max-width: 500px){
    .sign-up-details{
        width:70vw;
    }
    .college-logo{
        width:30vw;
        margin-left:70vw;
    }
    .cl-heading{
        font-size:10px;
        display:none;
    }
    .cl-text{
        font-size: 8px;
        display:none;
    }
    .cl-icon img{
        margin-top:35vh
    }
}
#footer{
    display:none;
}
.pro-btn{
    background:#ff7803;
    border:#ff7803;
    padding:10px 20px;
    color:#fff;
}
.cl-text{
    font-size:16px;
    color:#fff
}
.cl-heading{
    color:#fff;
    font-size:20px;
    padding-top:30px;
    font-weight:bold;
}
.footer{
    margin-top:0px !important;
}
.bg-white{
    background:#fff;
}
//.bg-blue{
//    background:#00a0e3;
//}
.input-group-text{
    font-weight: bold;
    font-family: lora;
    color: #000;
    font-size: 15px;
}
.head-padding{
    padding-top:50px;
}
.radio-heading{
    padding-bottom:10px;
}
form label {
    font-family: lora, sans-serif;
    font-size: 14px;
    font-weight: normal;
    margin-bottom: 0px;
}
.input-group{
    width:100%;
}
.custom-select{
    padding:10px 5px;
    width:100%;
    border-top: none;
    border-left: none;
    border-right: none;
    border-bottom:1px solid #eee;
    font-size:14px;
    color:#999;
}
.container-radio {
  display: block;
  position: relative;
  padding-left: 29px;
  margin-bottom: 5px;
  cursor: pointer;
  font-size: 16px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.container-radio input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}
.checkmark {
    position: absolute;
    top: 3px;
    left: 0;
    height: 22px;
    width: 22px;
    background-color: #eee;
    border-radius: 50%;
}
.container-radio:hover input ~ .checkmark {
  background-color: #ccc;
}
.container-radio input:checked ~ .checkmark {
  background-color: #2196F3;
}
.checkmark:after {
  content: "";
  position: absolute;
  display: none;    
}
/* Show the indicator (dot/circle) when checked */
.container-radio input:checked ~ .checkmark:after {
  display: block;
}
/* Style the indicator (dot/circle) */
.container-radio .checkmark:after {
 	top: 6px;
    left: 6px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: white;
}
.service-list{
     display: inline-block;
     min-width: 110px;
     margin-left:3px;
}
.service-list label{
   width: 100%;
   display: inline-block;
   background-color: rgba(255, 255, 255, .9);
   border: 1px solid rgba(139, 139, 139, .3);
   color: #333;
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
}
.service-list label {
   padding: 8px 12px;
   cursor: pointer;
   text-align: center;
}
.service-list label::before {
   display: inline-block;
   font-style: normal;
   font-variant: normal;
   text-rendering: auto;
   -webkit-font-smoothing: antialiased;
   font-family: Font Awesome 5 Free ;
   font-weight: 900;
   font-size: 12px;
   padding: 2px 6px 2px 2px;
   content: "067";
   transition: transform .3s ease-in-out;
}
.service-list input[type="radio"]:checked + label::before,
 .service-list input[type="checkbox"]:checked + label::before {
   content: "00c";
   transform: rotate(-360deg);
   transition: transform .3s ease-in-out;
}
.service-list input[type="radio"]:checked + label, .service-list label:hover,
 .service-list input[type="checkbox"]:checked + label{
   border: 1px solid #00a0e3;
   background-color: #00a0e3;
   color: #fff;
   transition: all .2s;
}
.service-list input[type="radio"],
 .service-list input[type="checkbox"]{
 display: absolute;
}
.service-list input[type="radio"],
 .service-list input[type="checkbox"]{
 position: absolute;
 opacity: 0;
}
.service-list input[type="radio"]:focus + label,
 .service-list input[type="checkbox"]:focus + label{
 border: 1px solid #00a0e3;
}
#step2{
	display:none;
}
.help-block-error
{
color:#e65332;
}
#dob-error{
    position:absolute;
    bottom: -30px;
}
#loan_purpose_checkbox-error{
    position: absolute;
    bottom: 0px   
}
.help-block{
    margin-top: 0px !important;
}
.loan-purpose{
    padding-inline-start: 0px;
}
.lead text-muted
{
font-family: auto !important;
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
.select2-selection__clear{
    padding-right: revert !important;
}
');
$script = <<< JS
    getCourses(); 
    getCountries();    
    getCollegeList(datatype=0,source=3,type=['College']);
    function getCollegeList(datatype, source, type) { 
        $.ajax({ 
            url : '/api/v3/companies/organization-list',
            method : 'GET',  
            data:{
                datatype:datatype,
                source:source, 
                type:type
                },   
            success : function(res) { 
            var res = res.response.results;
            $('#college_name').prepend('<option selected=""></option>').select2({
                data:res,
                placeholder: "Select College, Univerity",
                allowClear: true,
                tags:true,
                createTag: function (params) {
                var term = $.trim(params.term);
                if (term === '') {
                 return null;
                }
                return {  
                id: 'self',
                text: term,
                pulled_from:'unclaim',
                newTag: true // add additional parameters
            }
            },
            insertTag: function (data, tag) {
                data.push(tag);
             }, 
             maximumInputLength: 100 // only allow terms up to 20 characters long
             }).on('select2:select', function (e) {
                    var data = e.params.data;
                    if (data.id!='self'&&data.pulled_from==='claim')
                        {
                            getCourseList(data.id);
                            $('#pulled_from').val('claim');
                            $('#colg_text').val(data.text);
                            $('#colg_id').val(data.id);
                        }
                    else if (data.id==='self'&&data.pulled_from==='unclaim')
                        {
                            $('#pulled_from').val('unclaim');
                            $('#colg_text').val(data.text);
                            $('#colg_id').val(data.id);
                        }
                    else if (data.id!='self'&&data.pulled_from==='unclaim')
                        {
                            $('#pulled_from').val('unclaim');
                            $('#colg_text').val(data.text);
                            $('#colg_id').val(data.id);
                        }
                }); 
            }
        });
    }
    function getCountries() { 
        $.ajax({     
            url : '/api/v3/countries-list/get-countries-list', 
            method : 'POST',
            success : function(res) { 
            if (res.response.status==200){
                var html = [];
                 res = res.response.countries;
                $.each(res,function(index,value) 
                  {   
                   html.push('<option value="'+value.country_enc_id+'">'+value.name+'</option>');
                  }); 
                    $('#country_name').html(html);   
                    $('#country_name').val(default_country);
               } else
                {
                    toastr.error(res.response.message, 'Error');
                }
            } 
        });
    }
    function getFeeComponents(id) {
        $.ajax({
            url : '/api/v3/education-loan/get-fee-components',
            method : 'POST',
            data : {id: id},
            success : function(res) {
            var html = []; 
            var res = res.response.fee_components;
            $.each(res,function(index,value) 
                  {
                   html.push('<li class="service-list"><input type="checkbox" name="loan_purpose_checkbox[]" id="'+value.fee_component_enc_id+'" value="'+value.fee_component_enc_id+'" class="checkbox-input services"/><label for="'+value.fee_component_enc_id+'">'+value.name+'</label></li>');
                 }); 
            $('#loan-purpose').html(html);   
            }
        });
    } 
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
                console.log
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
        $('#the-basics .typeahead').typeahead({
             hint: true, 
             highlight: true,
             minLength: 1
            },
        {
         name: '_courses',
         source: substringMatcher(_courses)
        }); 
    } 
    $('#mobile, #aadhaarnumber').mask("#", {reverse: true}); 
    $('input[name="co-aadhaarnumber[1]"]').mask("#", {reverse: true});
    $('input[name="co-aadhaarnumber[2]"]').mask("#", {reverse: true});
    $("#nextBtn, #subBtn").click(function(){
       var form = $("#myForm");  
       var error = $('.alert-danger', form);
       var success = $('.alert-success', form);
       form.validate({ 
       errorElement: 'span', //default input error message container
       errorClass: 'help-block help-block-error', // default input error message class
       focusInvalid: true, // do not focus the last invalid input 
			rules: {
				'applicant_name': {
					required: true,
				},
				'course_name':{
				    required:true,
				},
				'dob':{
				    required:true,
				},
				'mobile':{
				    required:true,
				    minlength: 10,
				    maxlength: 10,
				},
				'email':{
				    required:true,
				    email:true
				},
				'location':{
				    required:true,
				},
				'college_name':{
				    required:true,
				},
				'course_name_text':{
				    required:true,
				},
				'country_name':{
				    required:true,
				},
				'aadhaarnumber':{
				    required:true,
				    minlength: 12,
				    maxlength: 12,
				},
				'loanamount':{ 
				    required:true,
				    min:500
				},
				'loan_purpose_checkbox[]':{
				    required:false,
				},
				'co-name[1]':{
				    required:true,
				},
				'co-anualincome[1]':{
				    required:true,
				    min:500 
				},
				'co-pancard[1]':{
				    required:false,
				    minlength: 10,
				    maxlength: 10,
				},
				'co-aadhaarnumber[1]':{
				    required:true,
				    minlength: 12,
				    maxlength: 12,
				    number:true
				},
				'co-relation[1]':{ 
				    required:true,
				},
				'co-name[2]':{
				    required:true,
				},
				'co-anualincome[2]':{
				    required:true,
				    min:500
				},
				'co-pancard[2]':{
				    required:false,
				    minlength: 10,
				    maxlength: 10,
				},
				'co-aadhaarnumber[2]':{
				    required:true,
				    minlength: 12,
				    maxlength: 12,
				    number:true
				},
				'co-relation[2]':{ 
				    required:true,
				}
			},
			messages: {
				'applicant_name': {
					required: "Applicant Name Required",
				},
				'course_name_text': {
					required: "Course Name Cannot Be Blank",
				},
				'dob': {
					required: "Enter Date Of Birth",
				},
				'mobile':{
				    required:'Mobile Number Cannot Be Blank',
				},
				'email':{
				    required:'Email Cannot Be Blank',
				},
				'location':{
				    required:'Current City Cannot Be Blank',
				},
				'loanamount':{
				    required:'Laon Amount Cannot Be Blank',
				},
				'college_name':
				{
				     required:'College Name Cannot Be Blank',
				},
				'country_name':
				{
				     required:'Country Name Cannot Be Blank',
				}, 
				'aadhaarnumber':{
				    required:'Aadhaar Number Cannot Be Blank',
				},
				'loan_purpose_checkbox[]':{
				    required:'Select Purpose of Loan',
				},
				'co-name[1]':{
				    required:'Enter Full Name',
				},
				'co-anualincome[1]':{
				    required:'Enter Annual income',
				},
				'co-pancard[1]':{
				    required:'Enter 10 Digit Pan Card',
				},
				'co-relation[1]':{
				    required:'Select Relation',
				}, 
				'co-aadhaarnumber[1]':{
				    required:'Aadhaar Number Cannot Be Blank',
				},
				'co-name[2]':{
				    required:'Enter Full Name',
				},
				'co-anualincome[2]':{
				    required:'Enter Annual income',
				},
				'co-pancard[2]':{
				    required:'Enter 10 Digit Pan Card',
				},
				'co-relation[2]':{
				    required:'Select Relation',
				}, 
				'co-aadhaarnumber[2]':{
				    required:'Aadhaar Number Cannot Be Blank',
				}
			}, 
			 invalidHandler: function (event, validator) { //display error alert on form submit   
                   $('html,body').animate({
                    scrollTop: 0
                    }, 'slow');
                },
           errorPlacement: function (error, element) { 
                    if (element.attr("name") == "loan_purpose_checkbox[]") 
                    { 
                        error.insertAfter("#loan-purpose");
                    }    
                    else if(element.attr("name")=="co-relation[1]")
                        {
                             error.insertAfter("#co-relation-ul-1");
                        }
                    else if(element.attr("name")=="co-relation[2]")
                        {
                             error.insertAfter("#co-relation-ul-2");
                        } 
                    else if (element.attr("name") == element.attr("name"))
                    { 
                         error.insertAfter(element);   
                    }
                    },
      }); 
       if (form.valid() == true){
            current_fs = $('#step1');
			next_fs = $('#step2');
			if (next_fs.is(':visible'))
			    {
			        ajaxSubmit();
			    }
			else if (current_fs.is(':visible')) {
			    next_fs.show(); 
			    current_fs.hide(); 
			    $('html,body').animate({
                    scrollTop: 0
                    }, 'slow');
			}
       }
   });
   
	$('#prevBtn').click(function(){
		current_fs = $('#step2');
		next_fs = $('#step1');
		next_fs.show();
		current_fs.hide();
	});
    
    $('.datepicker, .datepicker2, .datepicker3').datepicker({
    format: 'mm/dd/yyyy',
    startDate: '-3d'
});
    
function ajaxSubmit()
{
    console.log($('input[name="countryRadio"]:checked').val());
    console.log($('#country_name').val());
    $('#course_text').val($('#course_name_text').val());
    let co_applicants = [];
    let college_course_info = [];
    var obj = {};
    var object = {};  
    object['pulled_from'] = $('#pulled_from').val();
    object['course_text'] = $('#course_text').val();
    object['colg_text'] = $('#colg_text').val();
    object['colg_id'] = $('#colg_id').val();
    college_course_info.push(object);
    obj['name'] = $('input[name="co-name[1]"]').val()
    obj['relation'] = $('input[name="co-relation[1]"]:checked').val();
    obj['employment_type'] = $('input[name="co-emptype[1]"]:checked').val();
    obj['annual_income'] = $('input[name="co-anualincome[1]"]').val(); 
    obj['pan_number'] = $('input[name="co-pancard[1]"]').val();
    obj['aadhaar_number'] = $('input[name="co-aadhaarnumber[1]"]').val();
    co_applicants.push(obj);
    if ($('input[name="co-name[2]"]').length>0&&$('input[name="co-aadhaarnumber[2]"]').length>0){
        if ($('input[name="co-name[2]"]').val().length!=0&&$('input[name="co-aadhaarnumber[2]"]').val().length!=0)
        {
        var objCoBorrower = {};
        objCoBorrower['name'] = $('input[name="co-name[2]"]').val()
        objCoBorrower['relation'] = $('input[name="co-relation[2]"]:checked').val();
        objCoBorrower['employment_type'] = $('input[name="co-emptype[2]"]:checked').val();
        objCoBorrower['annual_income'] = $('input[name="co-anualincome[2]"]').val(); 
        objCoBorrower['pan_number'] = $('input[name="co-pancard[2]"]').val();
        objCoBorrower['aadhaar_number'] = $('input[name="co-aadhaarnumber[2]"]').val();
        co_applicants.push(objCoBorrower);
        }
    }
    // let purpose = [];
    // $('input[name="loan_purpose_checkbox[]"]:checked').each(function() {
    //   purpose.push(this.value);
    // });
    $.ajax({
            url : '/api/v3/education-loan/save-application',
            method : 'POST', 
            data : {
                applicant_name:$('#applicant_name').val(),
                applicant_dob:$('#dob').val(),
                applicant_current_city:$('#location').val(),
                degree:$('#degree').val(),
                years:$('#years').val(),
                semesters:$('#semesters').val(),
                phone:$('#mobile').val(),
                email:$('#email').val(),
                amount:$('#loanamount').val(),  
                gender:$('input[name="genderRadio"]:checked').val(),
                aadhaar_number:$('#aadhaarnumber').val(),
                co_applicants:co_applicants,
                college_course_info:college_course_info,
                userID:userID, 
                is_india:$('input[name="countryRadio"]:checked').val(),
                country_enc_id:$('#country_name').val(),
                },  
            beforeSend:function(e)
            {  
                $('#subBtn').hide();     
                $('#prevBtn').hide();     
                $('#loadBtn').show();  
            },
            success : function(res) {
                if (res.response.status=='200')
                {
                    let ptoken = res.response.data.payment_id; 
                    let loan_id = res.response.data.loan_app_enc_id;
                    let education_loan_id = res.response.data.education_loan_payment_enc_id;
                    if (ptoken!=null || ptoken !=""){
                        processPayment(ptoken,loan_id,education_loan_id);
                    } else{
                        swal({
                            title:"Error",
                            text: "Payment Gatway Is Unable to Process Your Payment At The Moment, Please Try After Some Time",
                            });
                    }
                } 
                else if (res.response.status=='401'||res.response.status=='422'||res.response.status=='500')
                {
                      swal({
                            title:"Error",
                            text: res.response.message,
                            });
                } 
                else if(res.response.status=='409')
                    {
                        swal({ 
                            title:"Error",
                            text: "Some Internal Server Error, Please Try After Some Time",
                            });
                    }
            }
        });
    }
function processPayment(ptoken,loan_id,education_loan_id)
{
    Layer.checkout({ 
        token: ptoken,
        accesskey: access_key
    }, 
    function(response) {
          // response.payment_token_id
           // response.payment_id  
        if (response.status == "captured") {
            updateStatus(education_loan_id,loan_id,response.payment_id,response.status);
               swal({
                        title: "",
                        text: "Your Application Is Submitted Successfully",
                        type:'success',
                        showCancelButton: false,  
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "Close",
                        closeOnConfirm: true, 
                        closeOnCancel: true
                         },
                            function (isConfirm) { 
                             location.reload(true);
                         }
                        );
        } else if (response.status == "created") {
            updateStatus(education_loan_id,loan_id,response.payment_id,response.status);
        } else if (response.status == "pending") {
          updateStatus(education_loan_id,loan_id,response.payment_id,response.status);
        } else if (response.status == "failed") { 
           updateStatus(education_loan_id,loan_id,response.payment_id,response.status);
        } else if (response.status == "cancelled") {
          updateStatus(education_loan_id,loan_id,response.payment_id,response.status);
        }
    },
    function(err) { 
                    swal({ 
                            title:"Error",
                            text: "Some Internal Server Error, Please Try After Some Time",
                     });
    }
);
} 

function updateStatus(education_loan_id,loan_app_enc_id,payment_id=null,status)
{
    $.ajax({
            url : '/api/v3/education-loan/update-widget-loan-application',
            method : 'POST', 
            data : {
              loan_payment_id:education_loan_id,
              loan_app_id:loan_app_enc_id,
              payment_id:payment_id, 
              status:status, 
            },
            success:function(e)
            {
                //console.log(e);
            }
    })
}
JS;
$this->registerJs($script);
?>
    <script>
        function randomVal() {
            return Math.floor(Math.random() * (100000 - 1 + 1) + 57);
        }
        function matchHeight() {
            var divHeight = document.getElementById('sd').offsetHeight;
            document.getElementById('cl').style.height = (divHeight + "px");
        }

        window.onload = matchHeight();

        var currentTab = 0; // Current tab is set to be the first tab (0)
        //showTab(currentTab);

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
                x[n + 1].style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").style.display = "none";
                document.getElementById("subBtn").style.display = "block";
            } else {
                document.getElementById("nextBtn").style.display = "block";
                document.getElementById("subBtn").style.display = "none";
            }
        }

        function nextPrev(n) {
            var x = document.getElementsByClassName("tab");
            x[currentTab].style.display = "none";
            currentTab = currentTab + n;
            matchHeight();

            if (currentTab >= x.length) {
                document.getElementById("regForm").submit();
                return false;
            }
            showTab(currentTab);
        }
        function addAnotherCo(randomVal){
            var coApplicant = ['<div class="col-md-12 padd-20 display-flex"><span class="input-group-text">Other Co-Borrower\'s Details (Optional)</span><button type="button" class="addAnotherCo input-group-text float-right" onclick="RemoveAnotherCo(this)"> Remove</button>\n' +
            '                                    </div>\n' +
            '                                    <div class="col-md-12 padd-20">\n' +
            '                                        <div class="form-group">\n' +
            '                                            <label for="co-name-'+randomVal+'" class="input-group-text">\n' +
            '                                                Name\n' +
            '                                            </label>\n' +
            '                                            <input type="text" name="co-name[2]" class="form-control" id="co-name-'+randomVal+'"\n' +
            '                                                   placeholder="Enter Full Name">\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                    <div class="col-md-12 padd-20">\n' +
            '                                        <div class="form-group">\n' +
            '                                            <div class="radio-heading input-group-text">\n' +
            '                                                Relation\n' +
            '                                            </div>\n' +
            '                                            <ul id="co-relation-ul-2">\n' +
            '                                                <li class="service-list">\n' +
            '                                                    <input type="radio" value="Father" checked="checked" name="co-relation[2]" id="co-father-'+randomVal+'"\n' +
            '                                                           class="checkbox-input services"/>\n' +
            '                                                    <label for="co-father-'+randomVal+'">Father</label>\n' +
            '                                                </li>\n' +
            '                                                <li class="service-list">\n' +
            '                                                    <input type="radio" value="Mother" name="co-relation[2]" id="co-mother-'+randomVal+'"\n' +
            '                                                           class="checkbox-input services"/>\n' +
            '                                                    <label for="co-mother-'+randomVal+'">Mother</label>\n' +
            '                                                </li>\n' +
            '                                                <li class="service-list">\n' +
            '                                                    <input type="radio" value="Brother" name="co-relation[2]" id="co-brother-'+randomVal+'"\n' +
            '                                                           class="checkbox-input services"/>\n' +
            '                                                    <label for="co-brother-'+randomVal+'">Brother</label>\n' +
            '                                                </li>\n' +
            '                                                <li class="service-list">\n' +
            '                                                    <input type="radio" value="Sister" name="co-relation[2]" id="co-sister-'+randomVal+'"\n' +
            '                                                           class="checkbox-input services"/>\n' +
            '                                                    <label for="co-sister-'+randomVal+'">Sister</label>\n' +
            '                                                </li>\n' +
            '                                                <li class="service-list">\n' +
            '                                                    <input type="radio" value="Guardian" name="co-relation[2]" id="co-sister-'+randomVal+'"\n' +
            '                                                           class="checkbox-input services"/>\n' +
            '                                                    <label for="co-sister-'+randomVal+'">Guardian</label>\n' +
            '                                                </li>\n' +
            '                                            </ul>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                    <div class="col-md-12 padd-20">\n' +
            '                                        <div class="form-group">\n' +
            '                                            <div class="radio-heading input-group-text">\n' +
            '                                               Employment type ?\n' +
            '                                            </div>\n' +
            '                                            <ul class="displayInline">\n' +
            '                                                <li>\n' +
            '                                                    <label class="container-radio">Salaried\n' +
            '                                                        <input type="radio" value="1" checked="checked" name="co-emptype[2]">\n' +
            '                                                        <span class="checkmark"></span>\n' +
            '                                                    </label>\n' +
            '                                                </li>\n' +
            '                                                <li>\n' +
            '                                                    <label class="container-radio">Self-Employed\n' +
            '                                                        <input type="radio" value="2" name="co-emptype[2]">\n' +
            '                                                        <span class="checkmark"></span>\n' +
            '                                                    </label>\n' +
            '                                                </li>\n' +
            '                                                <li>\n' +
            '                                                    <label class="container-radio">Non-Working\n' +
            '                                                        <input type="radio" value="0" name="co-emptype[2]">\n' +
            '                                                        <span class="checkmark"></span>\n' +
            '                                                    </label>\n' +
            '                                                </li>\n' +
            '                                            </ul>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                    <div class="col-md-12 padd-20">\n' +
            '                                        <div class="form-group">\n' +
            '                                            <label for="annulIncome" class="input-group-text">\n' +
            '                                               Annual Income\n' +
            '                                            </label>\n' +
            '                                            <input type="text" name="co-anualincome[2]" class="form-control" id="co-anualincome-'+randomVal+'"\n' +
            '                                                   placeholder="Enter Annual Income">\n' +
            '                                        </div>\n' +
            '                                    </div>' +
            '                                    <div class="col-md-12 padd-20">\n' +
            '                                        <div class="form-group">\n' +
            '                                            <label for="co-pancard-'+randomVal+'" class="input-group-text">\n' +
            '                                               Pan Card Number\n' +
            '                                            </label>\n' +
            '                                            <input type="text" name="co-pancard[2]" class="form-control" id="co-pancard-'+randomVal+'"\n' +
            '                                                   placeholder="Enter 10 Digit Pan Card Number">\n' +
            '                                        </div>\n'+
            '                                    </div>'+
            '                                         <div class="col-md-12 padd-20">\n' +
            '                                        <div class="form-group">\n' +
            '                                            <label for="co-aadhaar-'+randomVal+'" class="input-group-text">\n' +
            '                                                 Aadhaar Number\n' +
            '                                            </label>\n' +
            '                                            <input type="text" name="co-aadhaarnumber[2]" class="form-control" id="co-aadhaar-'+randomVal+'"\n' +
            '                                                   placeholder="Enter 12 Digit Aadhaar Number">\n' +
            '                                        </div>\n' +
            '                                    </div>'];
            var textnode = document.createElement("div");
            textnode.setAttribute('class', 'coapplicant');
            textnode.innerHTML = coApplicant;
            document.getElementById('addAnotherCo').appendChild(textnode);
            let coapplicants = document.getElementsByClassName('coapplicant');
            if(coapplicants.length > 1){
                document.getElementById('addAnotherButton').style.display = "none"
            }
        }
        function RemoveAnotherCo(ths) {
            $('html,body').animate({
                scrollTop: 0
            }, 'slow');
            ths.closest('.coapplicant').remove();
            let coapplicants = document.getElementsByClassName('coapplicant');
            if(coapplicants.length < 2){
                document.getElementById('addAnotherButton').style.display = "block"
            }
        }

        function showCountry(ths){
            let radioValue = ths.value;
            const countryName = document.getElementById('countryName');
            if(radioValue == '0'){
                countryName.style.display = "block";
            }else{
                countryName.style.display = "none";
            }
        }
    </script>
<?php
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@root/assets/common/select2Plugin/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@root/assets/common/select2Plugin/select2.min.css');
$this->registerCssFile('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerCssFile('https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://code.jquery.com/ui/1.10.4/jquery-ui.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/additional-methods.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
