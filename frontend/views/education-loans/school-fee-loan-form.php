<?php
use yii\helpers\Url;
$this->params['header_dark'] = true;
$this->title = '';
$keywords = '';
$description = '';
$image = Url::to('@eyAssets/images/pages/education-loans/school-student-loan.png', 'https');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Url::to(Yii::$app->request->url,'https'),
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
        'og:url' => Url::to(Yii::$app->request->url,'https'),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
Yii::$app->view->registerJs('var access_key = "' .Yii::$app->params->razorPay->prod->apiKey. '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var userID = "' .Yii::$app->user->identity->user_enc_id. '"', \yii\web\View::POS_HEAD);
?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <section class="bg-blue">
        <div class="sign-up-details bg-white" id="sd">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-start">
                        <form action="" id="myForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="heading-style">School Fee Finance</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label class="input-group-text" for="inputGroupSelect01">
                                            Filling Application As ?
                                        </label>
                                        <ul class="displayInline">
                                            <li>
                                                <label class="container-radio">
                                                    <input type="radio" checked="checked" id="parent" value="1" onclick="showChildren(this)" name="applicantRadio">
                                                    Parent
                                                </label>
                                            </li>
                                            <li>
                                                <label class="container-radio">
                                                    <input type="radio" id="applicant" value="0" onclick="hideChildren(this)" name="applicantRadio">
                                                    Student
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="number" class="input-group-text">
                                            Name
                                        </label>
                                        <input type="text" class="form-control text-capitalize" id="applicant_name" name="applicant_name" placeholder="Enter Full Name">
                                    </div>
                                </div>
                                <div id="schooInfo">

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
                                        <span id="dob-error"></span>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                        <div class="form-group">
                                            <label class="input-group-text" for="inputGroupSelect02">
                                                Current City Where You Live
                                            </label>
                                            <div id="the-basics">
                                            <input type="text" name="location" id="location" class="typeahead form-control text-capitalize"
                                                   autocomplete="off" placeholder="City"/>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="annulIncome" class="input-group-text">
                                            Annual Income Of Family (<i class="fa fa-inr" id="rp_symbol" aria-hidden="true"></i>)
                                        </label>
                                        <input type="text" class="form-control" minlength="4" maxlength="8" id="salary" name="salary"
                                               placeholder="Enter Salary">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="annulIncome" class="input-group-text">
                                           Loan Amount Required (<i class="fa fa-inr" id="rp_symbol" aria-hidden="true"></i>)
                                        </label>
                                        <input type="text" class="form-control" minlength="4" maxlength="8" id="loanamount" name="loanamount"
                                               placeholder="Enter Loan Amount">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="number" class="input-group-text">
                                            Phone Number (WhatsApp & Call)
                                        </label>
                                        <input type="text" class="form-control" minlength="10" maxlength="10" id="mobile" name="mobile"
                                               placeholder="Enter Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="email" class="input-group-text">
                                            Email Address
                                        </label>
                                        <input type="text" class="form-control" maxlength="50" id="email" name="email"
                                               placeholder="Enter Email Address">
                                    </div>
                                </div>
                                <div id="hideDiveChild">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="input-group-text" for="inputGroupSelect02">
                                                Number Of Children (Applying Loan For)
                                            </label>
                                            <input type="text" class="form-control" id="noChild" name="noChild"
                                                   onkeyup="checkChildInfo(this)" maxlength="1"  placeholder="Enter Number Of Children">
                                            <p class="errorMsg"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="child-info-div"></div>
<!--                            <div class="col-md-12 padd-20">-->
<!--                                <p class="termsText">By clicking submit you agree to our-->
<!--                                    <a href="--><?//= Url::to('/education-loans/terms-and-conditions')?><!--">terms and conditions</a> </p>-->
<!--                            </div>-->
                            <div class="row">
                                <div class="col-md-12 padd-20">
                                <div class="input-group padd-20">
                                    <div class="btn-center">
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
                            <div class="cl-heading">School Fee Loan</div>
                            <ul class="loan-benefits">
                                <li>Being a parent, you would like to provide the best education facilities to your children.
                                    With the rise in school tuition expenses and overall cost of learning, we’re left seeking
                                    quality education without soaring education fees. Now, with our <span>School Fee Loan</span>
                                    you can conveniently pay your child’s school fees without any worry.</li>

                            </ul>
                            <p class="lenders">More Than <span>20+</span> Lenders</p>
                            <div class="cl-icon">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="widget-benfit">
                                            <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/widget-minimal-paper-work.png') ?>">
                                            <p>Minimal Paper Work</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="widget-benfit">
                                            <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/widget-faster-processing-time.png') ?>">
                                            <p>Faster Processing Time</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="widget-benfit">
                                            <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/widget-approval-in-minutes.png') ?>">
                                            <p>Approval In Minutes</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="widget-benfit">
                                            <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/widget-quick-disbursement.png') ?>">
                                            <p>Quick Disbursement</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
<!--                            <div class="cl-icon">-->
<!--                                <p>Our Lenders</p>-->
<!--                                <ul>-->
<!--                                    <li>-->
<!--                                        <div class="lender-icon">-->
<!--                                            <span>-->
<!--                                                <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png')?><!--">-->
<!--                                            </span>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <div class="lender-icon">-->
<!--                                            <span>-->
<!--                                                <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/incred_logo.png')?><!--">-->
<!--                                            </span>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <div class="lender-icon">-->
<!--                                            <span>-->
<!--                                                <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/wepay.png')?><!--">-->
<!--                                            </span>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <div class="lender-icon">-->
<!--                                            <span>-->
<!--                                                <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png')?><!--">-->
<!--                                            </span>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <div class="lender-icon">-->
<!--                                            <span>-->
<!--                                                <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/ezcapital.png')?><!--">-->
<!--                                            </span>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <div class="lender-icon">-->
<!--                                            <span>-->
<!--                                                <img src="--><?//= Url::to('@eyAssets/images/pages/index2/AG-logo.png')?><!--">-->
<!--                                            </span>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                    <li>-->
<!--                                        <div class="lender-icon">-->
<!--                                            <span class="li-text">+10 More</span>-->
<!--                                        </div>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.widget-benfit{
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin-top: 30px;
}
.widget-benfit img{
    max-width: 60px;
    margin-bottom: 10px;
}
.widget-benfit p{
    color: #fff;
    font-size: 16px !important;
    line-height: 20px;
    font-weight: 400 !important;
} 
.lenders{
    margin-top: 20px;
    color: #f3f3f2;
    font-size: 16px;
}
.lenders span{
    font-weight: 600;
}
#loadBtn{
    display:none;
}
.termsText{
    font-size: 12px;
    font-family: roboto;
    text-align: center;
}
.termsText a{
    color: #00a0e3;
}
.termsText a:hover{
    color: #ff7803;
    transition: .3s ease;
}
.padd-20{
    padding-bottom: 10px;
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
#childTwo{
    diaplay: none;
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
    padding-right:15px;
}
.cl-icon{
    margin-top: 20px;
}
.cl-icon p{
    color:#fff;
    font-size:20px;
    padding-top:10px;
    font-weight:bold;
    padding-bottom:10px;
}
.cl-icon ul li{
    display: inline-grid;
    background: #fff;
    height: 100px;
    width: 100px; 
    border-radius: 10px; 
    margin:0 5px 15px;
    box-shadow: 0 0 10px rgba(149,139,139, .3);
}
.cl-icon ul li img{
    max-width: 80px;
    max-height: 60px;
}
.lender-icon{
    display: flex;
    height: 100%;
    align-items: center;
    justify-content: center;
    font-size: 16px;
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
    max-width:auto;
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
.displayNone{
    display: none;
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
    padding-bottom: 10px;
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
    border : 0px solid !important;
}
#rp_symbol{
    font-size: 11px;
    font-weight: 800;
}
#college_box{
display:none;
}
#college_preference_box{
display:none;
}
.select2-selection__arrow
{
top:6px !important;
}
 .select2-selection--single
{
    height: 45px !important;
   padding: 5px !important;
   border-radius: 0px !important;
   border-color: #aaa !important;
}
.select2-container--default{
    width:100% !important;
}
.errorMsg{
    display: none;
    color: #CA0B00;
}
.form-group{
    margin-bottom: 10px;
}
.check-container {
  display: block;
  position: relative;
  padding-left: 30px;
//  margin-bottom: 12px;
  cursor: pointer;
  font-size: 16px;
  color: #000;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.check-container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 23px;
  width: 23px;
  background-color: #fff;
  border: 1px solid #c2cad8;
}

.check-container:hover input ~ .checkmark {
  background-color: #ccc;
}

.check-container input:checked ~ .checkmark {
  background-color: #2196F3;
  border: 1px solid #2196F3;
}

.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

.check-container input:checked ~ .checkmark:after {
  display: block;
}

.check-container .checkmark:after {
  left: 8px;
  top: 4px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
@media screen and (max-width: 500px){
    .select2{
        width: 100% !important;
    }
    .bg-blue{
        display:flex;
        flex-direction: column;
    }
    .sign-up-details{
        position: relative;
        width: 100vw;
        min-height: unset;
        order:2;
        padding-bottom: 30px;
    }
    .college-logo{
        width: 100vw;
        position: relative;
        margin-left: 0px;
        min-height: unset;
        height: auto !important;
        order: 1;
        padding-top: 50px; 
    }
    .cl-heading{
        font-size:10px;
        display:none;
    }
    .cl-text{
        font-size: 14px;
//        display:none;
    }
    .cl-icon img{
        max-width: 100px;
        margin: 20px auto;
    }
    .loan-benefits{
        padding-inline-start: 0px;
    }
}

');
?>
<?php
$script = <<< JS
function getCities()
    {
        var _cities = [];
         $.ajax({     
            url : '/api/v3/countries-list/get-cities', 
            method : 'GET',
            data:{'country':'India'},
            success : function(res) {
            if (res.response.status==200){
                 res = res.response.cities;
                $.each(res,function(index,value) 
                  {   
                   _cities.push(value.value);
                  }); 
               } else
                {
                   console.log('cities could not fetch');
                }
            } 
        });
        $('#the-basics .typeahead').typeahead({
             hint: true, 
             highlight: true,
             minLength: 1
            },
        {
         name: '_cities',
         source: substringMatcher(_cities)
        }); 
    }
getCities();  
function substringMatcher (strs) {
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
jQuery.validator.addClassRules('child_name', {
        required: true
    });
jQuery.validator.addClassRules('child_class', {
        required: true 
    });
jQuery.validator.addClassRules('child_school', {
        required: true 
    });
$.validator.addMethod("check_date_of_birth", function (value, element) {
   var dateOfBirth = value;
    var arr_dateText = dateOfBirth.split("/");
    day = arr_dateText[1];
    month = arr_dateText[0];
    year = arr_dateText[2];
    var mydate = new Date();
    mydate.setFullYear(year, month - 1, day);
    
    var maxDate = new Date();
    if ((maxDate.getFullYear()-year) <= 1) {
        $.validator.messages.check_date_of_birth = "Sorry, only persons above or equal the age of 1 can be covered";
        return false;
    }
    return true;
});
function _razoPay(ptoken,loan_id,education_loan_id){
    var options = {
    "key": access_key, 
    "name": "Empower Youth",
    "description": "Application Login Fee",
    "image": "/assets/common/logos/logo.svg",
    "order_id": ptoken, 
    "handler": function (response){
        updateStatus(education_loan_id,loan_id,response.razorpay_payment_id,"captured",response.razorpay_signature);
    },
    "prefill": {
        "name": $('#applicant_name').val(),
        "email": $('#email').val(),
        "contact": $('#mobile').val()
    },
    "theme": {
        "color": "#ff7803"
    }
};
     var rzp1 = new Razorpay(options);
     rzp1.open();
     rzp1.on('payment.failed', function (response){
         updateStatus(education_loan_id,loan_id,null,"failed");
      swal({
      title:"Error",
      text: response.error.description,
      });
});
}
function updateStatus(education_loan_id,loan_app_enc_id,payment_id=null,status,signature=null)
{
    $.ajax({
            url : '/api/v3/education-loan/update-widget-loan-application',
            method : 'POST', 
            data : {
              loan_payment_id:education_loan_id,
              loan_app_id:loan_app_enc_id,
              payment_id:payment_id, 
              status:status, 
              signature:signature,
            },
            beforeSend:function(e){
                $('#subBtn').hide();
                $('#loadBtn').show();   
            },
            success:function(e)
            {
                if (status=="captured"){
                    if (e.response.status=='200'){
                       swal({
                        title: "",
                        text: "Your Application Is Submitted Successfully",
                        type:'success',
                        showCancelButton: false,  
                        showConfirmButton: false,  
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "Close",
                        closeOnConfirm: true, 
                        closeOnCancel: true
                         },
                            function (isConfirm) { 
                             location.reload(true);
                         });
                     }else{
                        swal({
                         title:"Payment Error",
                         text: 'Your Payment Status Will Be Update In 1-2 Business Day',
                      });
                     }
                }
                $('#subBtn').show();     
                $('#loadBtn').hide();
            }
    })
}
function ajaxSubmit()
{
    var applicantRadio = $('input[name="applicantRadio"]:checked').val();
    let child_information = [];
    var obj = {};
    if (applicantRadio=='1'){
        for (var i= 0; i<$('#noChild').val();i++){
        obj['child_name'] = $('.child_name:eq('+i+')').val();
        obj['child_class'] = $('.child_class:eq('+i+')').val();
        if (document.getElementById("checkmark")){
            if (document.getElementById("checkmark").checked===true){
                obj['child_school'] = $('.child_school:eq(0)').val();
            }else{
                obj['child_school'] = $('.child_school:eq('+i+')').val();
            }
        }else{
            obj['child_school'] = $('.child_school:eq('+i+')').val();
        }
        child_information.push(obj);
        obj = {};
    }
    }else{
        obj['child_name'] = $('#applicant_name').val();
        obj['child_class'] = $('.child_class:eq(0)').val();
        obj['child_school'] = $('.child_school:eq(0)').val();
        child_information.push(obj);
    }
    $.ajax({
            url : '/api/v3/education-loan/save-school-fee-loan',
            method : 'POST', 
            data : {
                applicant_name:$('#applicant_name').val(),
                applicant_dob:$('#dob').val(),
                is_applicant:applicantRadio,
                applicant_current_city:$('#location').val(),
                phone:$('#mobile').val(),
                email:$('#email').val(),
                amount:$('#loanamount').val(),   
                yearly_income:$('#salary').val(),   
                child_information:child_information,
                userID:userID
                },  
            beforeSend:function(e)
            {  
                $('#subBtn').hide();   
                $('#loadBtn').show();  
            },
            success : function(res) {
                if (res.response.status=='200')
                {
                    let ptoken = res.response.data.payment_id; 
                    let loan_id = res.response.data.loan_app_enc_id;
                    let education_loan_id = res.response.data.education_loan_payment_enc_id;
                    if (ptoken!=null || ptoken !=""){
                        _razoPay(ptoken,loan_id,education_loan_id);
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
                $('#subBtn').show();     
                $('#loadBtn').hide();
            }
        });
}
       $("#subBtn").click(function(){
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
					maxlength: 100
				},
				'dob':{
				     required: true,
                     check_date_of_birth: true
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
				'loanamount':{ 
				    required:true,
				    min:5000,
				    max:5000000
				},
				'noChild':{ 
				    required:true,
				    min:1,
				    max:9
				},
				'salary':{ 
				    required:true,
				    min:5000,
				    max:5000000
				},
			},
			messages: {
				'applicant_name': {
					required: "Parent Name Required",
				},
				'dob':{
				    required:'Date Of Birth Cannot Be Blank',
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
				'salary':{
				    required:'Salary Amount Cannot Be Blank',
				},
				'noChild':{
				    required:'No. Of Child Cannot Be Blank',
				    min:'',
				    max:'',
				},
			}, 
			 invalidHandler: function (event, validator) { //display error alert on form submit   
                   $('html,body').animate({
                    scrollTop: 0
                    }, 'slow');
                },
           errorPlacement: function (error, element) {
           if (element.attr("name") == "dob"){
               error.appendTo($("#dob-error"));
           }
           else if (element.attr("name") == element.attr("name"))
                    { 
                         error.insertAfter(element);   
                    }
                    },
      }); 
       if (form.valid() == true){
           ajaxSubmit();
       }
   })
   $('.datepicker3').datepicker({
            todayHighlight: true
        });
       $('#mobile, #loanamount').mask("#", {reverse: true});
       $('#salary').mask("#", {reverse: true});
JS;
$this->registerJs($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js');
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/additional-methods.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
?>
<script>
    showChildInfo = (event) =>{
        let eventValue  = event.currentTarget.value;
        if(eventValue == 1){
            document.querySelector('.child-info-div').style.display = 'block';
            document.querySelector('#childTwo').style.display = 'none';
            document.querySelector('#schoolAttend').style.display = 'none';
        }else if(eventValue == 2){
            document.querySelector('.child-info-div').style.display = 'block';
            document.querySelector('#childTwo').style.display = 'block';
            document.querySelector('#schoolAttend').style.display = 'block';
        }
    }
    showSchoolField = () => {
        let schoolNameField = document.querySelectorAll('.schoolNameField')
        if(event.target.checked){
            for(let i = 0; i < schoolNameField.length; i++){
                schoolNameField[i].classList.add('displayNone');
            }
            schoolNameField[0].classList.remove('displayNone');
        }else {
            for(let i = 0; i < schoolNameField.length; i++){
                schoolNameField[i].classList.remove('displayNone');
            }
        };
    }
    checkChildInfo = (event) => {
        let num = parseInt(event.value);
        let parentElem = event.parentElement;
        let childFormBox = document.querySelectorAll('.childFormBox');
        if (!/^\+?([0-9]{1}){1}$/.test(num) || num > 9 || num == '') {
            parentElem.querySelector('.errorMsg').style.display = "block";
            parentElem.querySelector('.errorMsg').innerHTML = errorMsgText(num);
            removeChildFormBox(num, childFormBox)
        } else  {
            parentElem.querySelector('.errorMsg').style.display = "none";
            let childDiv = document.querySelector('.child-info-div');
            childDiv.innerHTML = '';
            let count = 1;
            for (let i = 1; i <= num; i++) {
                let childForm = childrenInfoForm(count, num);
                childDiv.innerHTML += childForm;
                count++
             }
        }
    }
    errorMsgText = (num) => {
        switch (num){
            case (num > 9):
                return 'Number Should Be Less Than 9';
                break;
            case 0:
                return 'Number Should Be Greater Than 0';
                break;
            case NaN:
                return 'This Field Can Not Be Empty';
                break;
            default:
                return 'Please Enter A Number';
        }
    }
    removeChildFormBox = (num, childFormBox) => {
        if(childFormBox.length > 0){
            for(let i=0; i<childFormBox.length; i++){
                childFormBox[i].remove();
            }
        }
    }
    childrenInfoForm = (count, num) => {
        let childInfoForm = `<div class="row childFormBox">
            <div class="col-md-12">
                <h6 class="heading-style">${count}${count == 1 ? 'st' : count == 2 ? 'nd' : count == 3 ? 'rd' : 'th'} Child's Information</h6>
            </div>
            <div class="col-md-12 padd-20">
                <div class="form-group">
                    <label for="applicant_name_${count}" class="input-group-text">
                        Name
                    </label>
                    <input type="text" minlength="3" minlength="50" class="form-control text-capitalize child_name" id="applicant_name_${count}"
                     name="applicant_name_${count}" placeholder="Full Name">
                </div>
            </div>
            <div class="col-md-12 padd-20 schoolNameField">
                <div class="form-group">
                    <label for="school_name_${count}" class="input-group-text">
                        School Name
                    </label>
                    <input type="text" minlength="3" minlength="255" class="form-control text-capitalize child_school" id="school_name_${count}"
                        name="school_name_${count}" placeholder="School Name">
                </div>
                ${num > 1 && count == 1 ? `
                <div class="form-group" id="schoolAttend" >
                    <label class="check-container">All Attend The Same School
                      <input id="checkmark" name="checkmark" type="checkbox" onchange="showSchoolField()">
                      <span class="checkmark"></span>
                    </label>
                </div>
                `: ''}
            </div>
            <div class="col-md-12 padd-20">
                <div class="form-group">
                    <label for="class_name_${count}" class="input-group-text">
                        Class
                    </label>
                    <input type="text" minlength="3" minlength="255" class="form-control text-capitalize child_class" id="class_name_${count}"
                        name="class_name_${count}" placeholder="Class Name">
                </div>
            </div>
        </div>`
        return childInfoForm;
    }
function createChild()
{
    let child = '<div class="col-md-12 padd-20 schoolNameField">\n' +
        '                                        <div class="form-group">\n' +
        '                                            <label for="school_name_1" class="input-group-text">\n' +
        '                                                School Name\n' +
        '                                            </label>\n' +
        '                                            <input type="text" minlength="3" class="form-control text-capitalize child_school" id="school_name_1" name="school_name_1" placeholder="School Name">\n' +
        '                                        </div>\n' +
        '                                    </div>\n' +
        '                                    <div class="col-md-12 padd-20">\n' +
        '                                        <div class="form-group">\n' +
        '                                            <label for="class_name_1" class="input-group-text">\n' +
        '                                                Class\n' +
        '                                            </label>\n' +
        '                                            <input type="text" minlength="3" class="form-control text-capitalize child_class" id="class_name_1" name="class_name_1" placeholder="Class Name">\n' +
        '                                        </div>\n' +
        '                                    </div>'
    return child;
}
function removeChild() {

}
    function showChildren(ths){
        let radioValue = ths.value;
        const countryName = document.getElementById('hideDiveChild');
        const schoolInfo = document.getElementById('schooInfo');
        if(radioValue == '1'){
            countryName.style.display = "block";
            schoolInfo.innerHTML = "";
            document.getElementById('noChild').value = "";
        }else{
            countryName.style.display = "none";
            schoolInfo.innerHTML = createChild();
            let childFormBox = document.querySelectorAll('.childFormBox');
            let num = 1;
            removeChildFormBox(num, childFormBox);
        }
    }

    function hideChildren(ths){
        let radioValue = ths.value;
        const countryName = document.getElementById('hideDiveChild');
        const schoolInfo = document.getElementById('schooInfo');
        if(radioValue == '0'){
            countryName.style.display = "none";
            schoolInfo.innerHTML = createChild();
            let childFormBox = document.querySelectorAll('.childFormBox');
            let num = 1;
            removeChildFormBox(num, childFormBox);
        }else{
            countryName.style.display = "block";
            schoolInfo.innerHTML = "";
            document.getElementById('noChild').value = "";
        }
    }
</script>
