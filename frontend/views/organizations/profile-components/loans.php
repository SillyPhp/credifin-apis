<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use borales\extensions\phoneInput\PhoneInput;
?>
    <div class="container">
        <div class="set-sticky">
            <h3 class="heading-style">Education Loan Options</h3>
            <div class="table-view loan-table">
                <table>
                    <thead>
                    <tr>
                        <th class="w15">Bank/Financier</th>
                        <th class="w15">Rate of Interest</th>
                        <th class="w18">Loan Amount Available</th>
                        <th class="w22">Collateral</th>
                        <th class="w18">Processing Fee</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="loanProviderIcon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png') ?>">
                            </div>
                        </td>
                        <td>12% to 16% p.a.</td>
                        <td>Rs.40 lakh</td>
                        <td>Loan With & Without Collateral <br>Available + Moratorium period</td>
                        <td>2 % of Loan Amount + GST</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="loanProviderIcon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/incred_logo.png') ?>">
                            </div>
                        </td>
                        <td>12% - 16% p.a.</td>
                        <td>Rs.1 crore (With Collateral) <br>
                            Rs. 40 Lakhs (Without Collateral)
                        </td>
                        <td>Loan With & Without Collateral <br> Available + Moratorium period</td>
                        <td>1% to 1.25% + GST</td>
                    </tr>
                    </tr>
                    <tr>
                        <td>
                            <div class="loanProviderIcon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/wepay.png') ?>">
                            </div>
                        </td>
                        <td>14% to 16% p.a.</td>
                        <td>7 Lakh</td>
                        <td>With Collateral - <br>Without Moratorium</td>
                        <td>4% + GST</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="loanProviderIcon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png') ?>">
                            </div>
                        </td>
                        <td>8% to 12% p.a.</td>
                        <td>7 Lakh</td>
                        <td>With Collateral - <br>Without Moratorium</td>
                        <td>4% + GST</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="loanProviderIcon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/ezcapital.png') ?>">
                            </div>
                        </td>
                        <td>12% Flat</td>
                        <td>2 Lakh</td>
                        <td>Without Collateral - <br> 10 Months Repayment</td>
                        <td>Up To - 5% + GST</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="displayFlex">
                <div>*Terms&conditionsapplicable</div>
                <div>**Processingfeedependentonbank/nbfc</div>
            </div>
        </div>
        <div class="set-sticky">
            <div class="row">
                <div class="col-md-5 tc">
                    <div class="le-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/call-us1.png') ?>">
                    </div>
                </div>
                <div class="col-md-7">
                    <h3 class="heading-style">Get In Touch With Our Loan Expert</h3>
                    <div class="right-sec">
                        <div class="ls-box-shadow">
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
                                    <?= $form->field($model, 'first_name', ['template' => '<div class="ff-input">{input}{error}</div>'])->textInput(['class' => 'form-control req_field blurInput', 'placeholder' => 'First Name', 'data-field' => 'first_name', 'data-type' => 'leadApplication'])->label(false); ?>
                                    <?= $form->field($model, 'last_name', ['template' => '<div class="ff-input">{input}{error}</div>'])->textInput(['class' => 'form-control req_field blurInput', 'placeholder' => 'Last Name', 'data-field' => 'last_name', 'data-type' => 'leadApplication'])->label(false); ?>
                                </div>

                                <div class="form-flex">
                                    <?= $form->field($model, 'email', ['template' => '<div class="ff-input">{input}{error}</div>'])->textInput(['class' => 'form-control req_field blurInput', 'placeholder' => 'Email', 'data-field' => 'student_email', 'data-type' => 'leadApplication'])->label(false); ?>
                                    <?= $form->field($model, 'phone', ['template' => '<div class="ff-input">{input}{error}</div>'])->textInput()->widget(PhoneInput::className(), [
                                        'jsOptions' => [
                                            'allowExtensions' => true,
                                            'preferredCountries' => ['in'],
                                            'nationalMode' => true,
                                        ],
                                        'options' => [
                                            'class' => 'form-control req_field blurInput phoneInput',
                                            'data-field' => 'student_mobile_number',
                                            'data-type' => 'leadApplication'
                                        ]
                                    ])->label(false); ?>
                                </div>

                                <div class="form-flex">
                                    <?= $form->field($model, 'course', ['template' => '<div class="ff-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize blurInput', 'placeholder' => 'Course Name', 'autocomplete' => 'off', 'id' => 'course_name', 'data-field' => 'course_name', 'data-type' => 'leadApplication'])->label(false); ?>
                                </div>
                            </div>

                            <section data-for="step2">
                                <div class="form-group tab" data-id="step2">
                                    <section data-type="loan_interest">
                                        <div class="form-flex-2">
                                            <div class="font14">Would you like to take education loan for :</div>
                                            <div class="radio-container">
                                                <input type="radio" name="interestLoanFor" id="uni_college"
                                                       data-field="loan_for" value="1">
                                                <label for="uni_college">
                                                    <svg class="check" viewbox="0 0 40 40">
                                                        <defs>
                                                            <linearGradient id="gradient" x1="0" y1="0" x2="0"
                                                                            y2="100%">
                                                                <stop offset="0%" stop-color="#0db6fc"></stop>
                                                                <stop offset="100%" stop-color="#00a0e3"></stop>
                                                            </linearGradient>
                                                        </defs>
                                                        <circle id="border" r="18px" cx="20px" cy="20px"></circle>
                                                        <circle id="dot" r="8px" cx="20px" cy="20px"></circle>
                                                    </svg>
                                                    University/College
                                                </label>
                                                <input type="radio" name="interestLoanFor" id="school"
                                                       data-field="loan_for" value="2">
                                                <label for="school">
                                                    <svg class="check" viewbox="0 0 40 40">
                                                        <defs>
                                                            <linearGradient id="gradient" x1="0" y1="0" x2="0"
                                                                            y2="100%">
                                                                <stop offset="0%" stop-color="#0db6fc"></stop>
                                                                <stop offset="100%" stop-color="#00a0e3"></stop>
                                                            </linearGradient>
                                                        </defs>
                                                        <circle id="border" r="18px" cx="20px" cy="20px"></circle>
                                                        <circle id="dot" r="8px" cx="20px" cy="20px"></circle>
                                                    </svg>
                                                    School
                                                </label>
                                                <input type="radio" name="interestLoanFor" id="otherInstitute"
                                                       data-field="loan_for" value="3">
                                                <label for="otherInstitute">
                                                    <svg class="check" viewbox="0 0 40 40">
                                                        <defs>
                                                            <linearGradient id="gradient" x1="0" y1="0" x2="0"
                                                                            y2="100%">
                                                                <stop offset="0%" stop-color="#0db6fc"></stop>
                                                                <stop offset="100%" stop-color="#00a0e3"></stop>
                                                            </linearGradient>
                                                        </defs>
                                                        <circle id="border" r="18px" cx="20px" cy="20px"></circle>
                                                        <circle id="dot" r="8px" cx="20px" cy="20px"></circle>
                                                    </svg>
                                                    Other Institute
                                                </label>
                                            </div>
                                        </div>
                                        <section data-type="collegeApplied" class="hideRow">
                                            <div class="form-flex-2">
                                                <div class="font14">Have You Already Taken Admission?</div>
                                                <div class="radio-container">
                                                    <input type="radio" name="appliedCollege" id="yes"
                                                           data-field="admission_taken" value="1">
                                                    <label for="yes">
                                                        <svg class="check" viewbox="0 0 40 40">
                                                            <defs>
                                                                <linearGradient id="gradient" x1="0" y1="0" x2="0"
                                                                                y2="100%">
                                                                    <stop offset="0%" stop-color="#0db6fc"></stop>
                                                                    <stop offset="100%" stop-color="#00a0e3"></stop>
                                                                </linearGradient>
                                                            </defs>
                                                            <circle id="border" r="18px" cx="20px" cy="20px"></circle>
                                                            <circle id="dot" r="8px" cx="20px" cy="20px"></circle>
                                                        </svg>
                                                        Yes
                                                    </label>
                                                    <input type="radio" name="appliedCollege" id="no"
                                                           data-field="admission_taken" value="0">
                                                    <label for="no">
                                                        <svg class="check" viewbox="0 0 40 40">
                                                            <defs>
                                                                <linearGradient id="gradient" x1="0" y1="0" x2="0"
                                                                                y2="100%">
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
                                            <div class="form-group hideRow" id="appliedYes">
                                                <div class="form-flex">
                                                    <?= $form->field($model, 'college', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize college_name blurInput', 'placeholder' => 'College Or University Name', 'autocomplete' => 'off', 'id' => 'college_name', 'data-field' => 'college_name', 'data-type' => 'leadApplication'])->label(false); ?>
                                                </div>
                                            </div>

                                            <div class="form-group hideRow" id="appliedNo">
                                                <p>Please Mention Your Three Preferred Colleges</p>
                                                <div class="form-flex">
                                                    <?= $form->field($model, 'preference_college1[]', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize college_name blurInput', 'placeholder' => 'College Or University Name Preference 1', 'autocomplete' => 'off', 'id' => 'college_preference1', 'data-field' => 'college_name', 'data-type' => 'leadCollegePreference', 'data-sequence' => 'first'])->label(false); ?>
                                                </div>
                                                <div class="form-flex">
                                                    <?= $form->field($model, 'preference_college1[]', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize college_name blurInput', 'placeholder' => 'College Or University Name Preference 2', 'autocomplete' => 'off', 'id' => 'college_preference2', 'data-field' => 'college_name', 'data-type' => 'leadCollegePreference', 'data-sequence' => 'second'])->label(false); ?>
                                                </div>
                                                <div class="form-flex">
                                                    <?= $form->field($model, 'preference_college1[]', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'typeahead form-control text-capitalize college_name blurInput', 'placeholder' => 'College Or University Name Preference 3', 'autocomplete' => 'off', 'id' => 'college_preference3', 'data-field' => 'college_name', 'data-type' => 'leadCollegePreference', 'data-sequence' => 'third'])->label(false); ?>
                                                </div>
                                            </div>
                                        </section>
                                    </section>


                                    <div class="form-group">
                                        <div class="form-flex-2">
                                            <div class="font14">Do You want to apply for Education Loan Now?</div>
                                            <div class="radio-container">
                                                <input type="radio" name="loan" id="LoanYes" value="Loanyes">
                                                <label for="LoanYes">
                                                    <svg class="check" viewbox="0 0 40 40">
                                                        <defs>
                                                            <linearGradient id="gradient2" x1="0" y1="0" x2="0"
                                                                            y2="100%">
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
                                                            <linearGradient id="gradient2" x1="0" y1="0" x2="0"
                                                                            y2="100%">
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
                                        <div id="loanFields" class="hideRow">
                                            <div class="form-flex">
                                                <?= $form->field($model, 'amount', ['template' => '<div class="fw-input">{input}{error}</div>'])->textInput(['class' => 'form-control blurInput', 'placeholder' => 'Loan Amount', 'type' => 'text', 'autocomplete' => 'off', 'id' => 'amount', 'data-field' => 'loan_amount', 'data-type' => 'leadApplication'])->label(false); ?>
                                                <input type="text" name="amountValidation" style="display:none;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
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
        </div>
    </div>
<?php
$this->registerCss('
.loan-table table { 
    width: 100%; 
    border-collapse: collapse; 
    margin-bottom: 0px !important;
}
/* Zebra striping */
.loan-table tr{
    padding: 5px 0; 
}
.loan-table tr:nth-child(odd) { 
    background: #fbfbfb; 
}
.loan-table th { 
    background: #00a0e3; 
    color: #fff; 
    font-weight: bold; 
}
.loan-table td, .loan-table th { 
    padding: 15px 6px; 
    border-left: 1px solid #f1f1f1; 
    border-right: 1px solid #f1f1f1; 
    text-align: center;
    height: 70px;
    
}
.loan-table td p{
    margin-bottom: 0px !important;
    text-align: center !
    important;
}
.loanProviderIcon{
    max-width: 100px;
    max-height: 100px;
    margin: 0 auto;
}
.loanProviderIcon img{
    width: 100%;
    object-fit: contain;
    max-height: 40px;
}
.displayFlex{
    display: flex;
    justify-content: space-between;
    background: #ff7803;
    padding: 5px 10px;
    color: #fff;    
    flex-wrap: wrap;
}
.intl-tel-input, .phoneInput {
    width:100% !important;
}
.intl-tel-input{
    padding-top:10px !important;
//    padding-left: 14px;
//    padding-right: 13px;
}
.flag-container{
    top:10px !important;
//    left: 15px !important;
}
#submitBtn{
display:none;
}
.twitter-typeahead{
    width:100%
}

.typeahead {
  background-color: #fff;
//  margin-left: 15px !important; 
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

.form-control{
    margin: 10px auto;
    padding: 12px 12px;
    background-color: #fff;
    border: 1px solid #c2cad8;
//    width: calc(100% - 25px);
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
.form-group{
    width: 100%;
    margin-bottom: 0px ;
}
.form-group input{
    border: 1px solid #eee;
}
.sendQuery{
    background: #ff7803;
    color: #fff;
    border:1px solid #ff7803;
    text-transform: uppercase;
    font-family: roboto;
    font-size: 14px;
    width: 100%;
    height: 43px;
}
.tc{
    text-align:center;
}

@media only screen and (max-width: 767px) {
    .h-point1 {
        width: 50%;
    }
    .course-box{
        width:100%;
    }
    .course-box:nth-child(3n+0){
        margin-right:1%;
    }
    .loanProviderIcon{
        float: right;
        margin: unset;
    }
    .loan-table table,
    .loan-table thead, 
    .loan-table tbody, 
    .loan-table th, 
    .loan-table td, 
    .loan-table tr { 
        display: block; 
    }
            
    /* Hide table headers (but not display: none;, for accessibility) */
    .loan-table thead tr { 
        position: absolute;
        top: -9999px;
        left: -9999px;
    }
    .loan-table tr {
        border: 1px solid #ccc; 
        margin-bottom: 10px;
    }
    .loan-table td { 
        /* Behave  like a "row" */
        border: none;
        border-bottom: 1px solid #eee; 
        position: relative;
        padding-left: 50% !important;
        min-height: 70px;
        height: auto; 
    }
    .loan-table td:last-child{
        border-bottom: none;
    }
    .loan-table td:before { 
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 3px;
        width: 45%; 
        padding-right: 10px;
    }
    .loan-table td:nth-of-type(1):before { 
        content: "Bank/Financier"; 
    }
    .loan-table td:nth-of-type(2):before { 
        content: "ROI"; 
    }
    .loan-table td:nth-of-type(3):before { 
        content: "Loan Amount Available"; 
    }
    .loan-table td:nth-of-type(4):before { 
        content: "Collateral"; 
    }
    .loan-table td:nth-of-type(5):before { 
        content: "Processing Fees"; 
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
            url: '/site/college-loan-enquiry',
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
                url: '/site/college-loan-enquiry',
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
function initializePosSticky() {
  var mainHeight = $('#integration-main').height();
  $('#side-bar-main').css('height',mainHeight);
}
$(document).on('click', '.scroll-to-sec', function(e) {
    e.preventDefault();
    var sectionId = $(this).attr('href');
    var offsetHeight = $(sectionId).offset().top - 135 ;
    $('html, body').animate({scrollTop: offsetHeight}, 0);
});
setTimeout(function() {
  initializePosSticky();
},700);
JS;
$this->registerJS($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
