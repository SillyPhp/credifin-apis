<?php
use yii\helpers\Url;
?>
    <section class="bg-blue">
        <div class="sign-up-details bg-white" id="sd">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-start">
                        <form action="" id="myForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="heading-style">School Fee Loan</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="number" class="input-group-text">
                                            Name
                                        </label>
                                        <input type="text" class="form-control text-capitalize" id="applicant_name" name="applicant_name" placeholder="Enter Full Name">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                        <div class="form-group">
                                            <label class="input-group-text" for="inputGroupSelect02">
                                                Current City Where You Live
                                            </label>
                                            <input type="text" name="location" id="location" class="form-control text-capitalize"
                                                   autocomplete="off" placeholder="City"/>
                                        </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="annulIncome" class="input-group-text">
                                            Salary (Income)
                                        </label>
                                        <input type="text" class="form-control" id="loanamount" name="loanamount"
                                               placeholder="Enter Loan Amount">
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="input-group-text" for="inputGroupSelect02">
                                           Number Of Children (Applying Loan For)
                                        </label>
                                        <input type="text" class="form-control" id="noChild" name="noChild"
                                            onkeyup="checkChildInfo(this)" maxlength="1"  placeholder="Enter Email Address">
                                        <p class="errorMsg"></p>
                                   </div>
                                </div>
                            </div>
                            <div class="child-info-div"></div>
                            <div class="row">
                                <div class="col-md-12 padd-20">
                                <div class="input-group padd-20">
                                    <div class="btn-center">
                                        <button type="button" class="button-slide" id="subBtn">
                                            Submit
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
<!--                                <li>- Loan will be <span>repaid</span> with in the Year</li>-->
                            </ul>
                            <div class="cl-icon">
                                <p>Our Lenders</p>
                                <ul>
                                    <li>
                                        <div class="lender-icon">
                                            <span>
                                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png')?>">
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="lender-icon">
                                            <span>
                                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/incred_logo.png')?>">
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="lender-icon">
                                            <span>
                                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/wepay.png')?>">
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="lender-icon">
                                            <span>
                                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png')?>">
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="lender-icon">
                                            <span>
                                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/ezcapital.png')?>">
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="lender-icon">
                                            <span>
                                                <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png')?>">
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="lender-icon">
                                            <span class="li-text">+10 More</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
#loadBtn{
    display:none;
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
            for(let i = 0; i <= schoolNameField.length; i++){
                schoolNameField[i+1].classList.add('displayNone');
            }
        }else {
            for(let i = 0; i <= schoolNameField.length; i++){
                schoolNameField[i+1].classList.remove('displayNone');
            }
        };
    }
    checkChildInfo = (event) => {
        let num = parseInt(event.value);
        console.log(typeof num);
        let parentElem = event.parentElement;
        let childFormBox = document.querySelectorAll('.childFormBox');
        if (!/^\+?([0-9]{1}){1}$/.test(num) || num > 9 || num == '') {
            parentElem.querySelector('.errorMsg').style.display = "block";
            parentElem.querySelector('.errorMsg').innerHTML = errorMsgText(num);
            removeChildFormBox(num, childFormBox)
        } else  {
            parentElem.querySelector('.errorMsg').style.display = "none";
            let childDiv = document.querySelector('.child-info-div');
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
            for(let i=0; i<=childFormBox.length; i++){
                childFormBox[i].remove()
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
                    <input type="text" class="form-control text-capitalize" id="applicant_name_${count}"
                     name="applicant_name_${count}" placeholder="Enter Full Name">
                </div>
            </div>
            <div class="col-md-12 padd-20 schoolNameField">
                <div class="form-group">
                    <label for="school_name_${count}" class="input-group-text">
                        School Name
                    </label>
                    <input type="text" class="form-control text-capitalize" id="school_name_${count}"
                        name="school_name_${count}" placeholder="Enter Full Name">
                </div>
                ${num > 1 && count == 1 ? `
                <div class="form-group" id="schoolAttend" >
                    <label class="check-container">All Attend The Same School
                      <input type="checkbox" onchange="showSchoolField()">
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
                    <input type="text" class="form-control text-capitalize" id="class_name_${count}"
                        name="class_name_${count}" placeholder="Enter Full Name">
                </div>
            </div>
        </div>`
        return childInfoForm;
    }
</script>
