<?php

use yii\helpers\Url;

$userDetail = \common\models\Users::findOne(['user_enc_id' => Yii::$app->user->identity->user_enc_id]);
$this->params['header_dark'] = true;
Yii::$app->view->registerJs('var access_key = "' .Yii::$app->params->razorPay->prod->apiKey. '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var getLender = "' .$getLender. '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var userID = "' .Yii::$app->user->identity->user_enc_id. '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var default_country = "' .$india. '"', \yii\web\View::POS_HEAD);
$cookies = Yii::$app->request->cookies;
$ref_id = $cookies->get('ref_loan_id');
Yii::$app->view->registerJs('var refferal_id = "' . $ref_id->value . '"', \yii\web\View::POS_HEAD);
?>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <section class="bg-blue">
        <div class="sign-up-details bg-white" id="sd">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-start">
                        <form action="" id="myForm" autocomplete="off">
                            <div class="tab" id="step1">
                                <div class="row m-0">
                                    <div class="col-md-12 mt-40">
                                        <h1 class="heading-style"><?php
                                            if ($action_name == 'interest-free') {
                                                echo 'Interest Free Education Loan';
                                            } else if ($action_name == 'study-abroad') {
                                                echo 'StudyAbroad Education Loan';
                                            } else {
                                                echo 'Education Loan';
                                            } ?></h1>
                                    </div>
                                </div>
                                <!--Loan Type start-->
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label class="input-group-text" for="inputGroupSelect01">
                                            Looking For Education Loan ?
                                        </label>
                                        <div class="wrapper-tabs">
                                            <ul class="displayInline tab-menu">
                                                <li href="#schoolloan">
                                                    <label class="container-radio">
                                                        <input type="radio" id="TypeSchool" value="1"
                                                               onclick="showChildren(this)" name="applicantTypeRadio">
                                                        <span class="checkmark">School Fee Loan</span>
                                                    </label>
                                                </li>
                                                <li href="#collegesloan">
                                                    <label class="container-radio">
                                                        <input type="radio" id="TypeCollege" value="0"
                                                               onclick="hideChildren(this)" name="applicantTypeRadio">
                                                        <span class="checkmark">College/University Fee Loan</span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <span id="applicantTypeRadio"></span>
                                </div>
                                <!--Loan Type end-->
                                <!--parent co borower details start-->
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label class="input-group-text" for="inputGroupSelect01">
                                            Filling Application As ?
                                        </label>
                                        <ul class="displayInline">
                                            <li>
                                                <label class="container-radio">
                                                    <input type="radio" id="parent" value="1"
                                                           onclick="showRelation(this)" name="applicantRadio"> <span
                                                            class="checkmark">Parent / Guardian</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="container-radio">
                                                    <input type="radio" id="applicant" value="0"
                                                           onclick="hideRelation(this)" name="applicantRadio"> <span
                                                            class="checkmark">Student</span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <span id="applicantRadio"></span>
                                </div>
                                <div id="parent_co_borrower">
                                    <div class="coapplicant">
                                        <div class="col-md-12 padd-20">
                                            <div class="form-group">
                                                <div class="radio-heading input-group-text">
                                                    Relation With Student
                                                </div>
                                                <ul id="co-relation-ul-1" class="displayInline">
                                                    <li>
                                                        <label for="co-father-1" class="container-radio-second">
                                                            <input type="radio" value="Father" checked="checked"
                                                                   name="co-relation[1]" id="co-father-1"
                                                                   class="checkbox-input services" checked>
                                                            <svg width="1.3em" height="1.3em" viewBox="0 0 20 20">
                                                                <circle cx="10" cy="10" r="9"></circle>
                                                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                                                      class="inner"></path>
                                                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                                                      class="outer"></path>
                                                            </svg>
                                                            <span class="checkmarked">Father</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label for="co-mother-1" class="container-radio-second">
                                                            <input type="radio" value="Mother" name="co-relation[1]"
                                                                   id="co-mother-1" class="checkbox-input services">
                                                            <svg width="1.3em" height="1.3em" viewBox="0 0 20 20">
                                                                <circle cx="10" cy="10" r="9"></circle>
                                                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                                                      class="inner"></path>
                                                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                                                      class="outer"></path>
                                                            </svg>
                                                            <span class="checkmarked">Mother</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label for="co-brother-1" class="container-radio-second">
                                                            <input type="radio" value="Brother" name="co-relation[1]"
                                                                   id="co-brother-1" class="checkbox-input services">
                                                            <svg width="1.3em" height="1.3em" viewBox="0 0 20 20">
                                                                <circle cx="10" cy="10" r="9"></circle>
                                                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                                                      class="inner"></path>
                                                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                                                      class="outer"></path>
                                                            </svg>
                                                            <span class="checkmarked">Brother</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label for="co-sister-1" class="container-radio-second">
                                                            <input type="radio" value="Sister" name="co-relation[1]"
                                                                   id="co-sister-1" class="checkbox-input services">
                                                            <svg width="1.3em" height="1.3em" viewBox="0 0 20 20">
                                                                <circle cx="10" cy="10" r="9"></circle>
                                                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                                                      class="inner"></path>
                                                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                                                      class="outer"></path>
                                                            </svg>
                                                            <span class="checkmarked">Sister</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label for="co-guardian-1" class="container-radio-second">
                                                            <input type="radio" value="Guardian" name="co-relation[1]"
                                                                   id="co-guardian-1" class="checkbox-input services">
                                                            <svg width="1.3em" height="1.3em" viewBox="0 0 20 20">
                                                                <circle cx="10" cy="10" r="9"></circle>
                                                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                                                      class="inner"></path>
                                                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                                                      class="outer"></path>
                                                            </svg>
                                                            <span class="checkmarked">Guardian</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-12 padd-20">
                                            <div class="form-group">
                                                <label for="co-name[]" class="input-group-text">
                                                    Your Name
                                                </label>
                                                <input type="text" name="co-name[1]"
                                                       class="form-control text-capitalize" id="co-name"
                                                       placeholder="Enter Your Full Name">
                                            </div>
                                        </div>
                                        <div class="col-md-12 padd-20">
                                            <div class="form-group">
                                                <div class="radio-heading input-group-text">
                                                    Employment type ?
                                                </div>
                                                <ul class="displayInline">
                                                    <li>
                                                        <label for="sal-1" class="container-radio">
                                                            <input type="radio" value="1" checked="checked" id="sal-1"
                                                                   name="co-emptype[1]" class="checkbox-input services"
                                                                   checked>
                                                            <span class="checkmark">Salaried</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label for="self-1" class="container-radio">
                                                            <input type="radio" value="2" id="self-1"
                                                                   name="co-emptype[1]" class="checkbox-input services">
                                                            <span class="checkmark">Self-Employed</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label for="non-1" class="container-radio">
                                                            <input type="radio" value="3" id="non-1"
                                                                   name="co-emptype[1]" class="checkbox-input services">
                                                            <span class="checkmark">Non-Working</span>
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
                                                <input type="text" name="co-anualincome[1]" minlength="3" maxlength="7"
                                                       class="form-control" id="co-anualincome"
                                                       placeholder="Enter Annual Income">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--                                parent co borower details end-->
                                <div id="student_name_col">
                                    <div class="col-md-12 padd-20">
                                        <div class="form-group">
                                            <label for="number" class="input-group-text">
                                                Student Name
                                            </label>
                                            <input value="<?= ($userDetail->first_name) ? $userDetail->first_name . " " . $userDetail->last_name : "" ?>"
                                                   type="text" class="form-control text-capitalize" id="applicant_name"
                                                   name="applicant_name" placeholder="Enter Full Name">
                                        </div>
                                    </div>
                                </div>
                                <!--                                College Informaton start-->
                                <div id="collegeLoanBox">
                                    <div class="col-md-12 padd-20">
                                        <div class="form-group">
                                            <label class="input-group-text" for="inputGroupSelect01">
                                                Choose Country where you want to study
                                            </label>
                                            <ul class="displayInline tab-menu">
                                                <li href="#setindia">
                                                    <label class="container-radio">
                                                        <input type="radio" checked="checked" id="india" value="1"
                                                               onclick="showCountry(this)" name="countryRadio">
                                                        <span class="checkmark">India</span>
                                                    </label>
                                                </li>
                                                <li href="#setabroad">
                                                    <label class="container-radio">
                                                        <input type="radio" id="othercountry" value="0"
                                                               onclick="showCountry(this)" name="countryRadio">
                                                        <span class="checkmark">Outside India</span>
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
                                            <select class="form-control js-example-basic-multiple"
                                                    name="country_name" id="country_name" multiple="multiple">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 padd-20">
                                        <div class="form-group">
                                            <label for="course_name" class="input-group-text">
                                                Field Of Study / Course Name
                                            </label>
                                            <div id="the-basics">
                                                <input type="text" placeholder="Enter Field / Course Name"
                                                       class="typeahead form-control text-capitalize"
                                                       id="course_name_text" name="course_name_text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="radio-heading input-group-text">
                                                Have You Taken The Addmission?
                                            </div>
                                            <ul class="displayInline">
                                                <li>
                                                    <label for="yc" class="container-radio">
                                                        <input type="radio" value="1" id="yc" name="college_taken"
                                                               class="checkbox-input services">
                                                        <span class="checkmark">Yes</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="nc" class="container-radio">
                                                        <input type="radio" value="0" id="nc" name="college_taken"
                                                               class="checkbox-input services">
                                                        <span class="checkmark">No</span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <span id="college_taken_error"></span>
                                        </div>
                                    </div>
                                    <div id="college_box">
                                        <div class="col-md-12 padd-20">
                                            <label for="course_name" class="input-group-text">
                                                College / University Name (You Can Add Custom If Not Available in List)
                                            </label>
                                            <select id="college_name" name="college_name">

                                            </select>
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
                                                    <option value="2">2nd Semester</option>
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
                                    </div>
                                </div>
                                <!--                                College Informaton end-->

                                <!--                                School Informaton start-->
                                <div id="schooInfo">

                                </div>
                                <div id="hideDiveChild">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="input-group-text" for="inputGroupSelect02">
                                                Number Of Children (Applying Loan For)
                                            </label>
                                            <input type="text" class="form-control" id="noChild" name="noChild"
                                                   onkeyup="checkChildInfo(this)" maxlength="1"
                                                   placeholder="Enter Number Of Children">
                                            <p class="errorMsg"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="child-info-div"></div>
                                <!--                                School Informaton end-->
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="annulIncome" class="input-group-text">
                                            <span id="total_sec" style="display: none;">Total</span> Loan Amount
                                            Required (<i class="fa fa-inr" id="rp_symbol" aria-hidden="true"></i>)
                                        </label>
                                        <input type="text" class="form-control" minlength="3" maxlength="7"
                                               id="loanamount" name="loanamount"
                                               placeholder="Enter Loan Amount">
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
                                <div class="row m-0">
                                    <div class="col-md-12">
                                        <h1 class="heading-style">Contact Details</h1>
                                    </div>
                                </div>
                                <!--                                contact details start-->
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label class="input-group-text" for="inputGroupSelect02">
                                            Current city where you live
                                        </label>
                                        <div id="the-basics-city">
                                            <input value="<?= ($userDetail->cityEnc->name) ? $userDetail->cityEnc->name : "" ?>"
                                                   type="text" name="location" id="location"
                                                   class="typeahead form-control text-capitalize"
                                                   autocomplete="off" placeholder="City"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="number" class="input-group-text">
                                            Phone Number (WhatsApp & Call)
                                        </label>
                                        <input value="<?= ($userDetail->phone) ? substr($userDetail->phone, -10) : "" ?>"
                                               type="text" class="form-control" id="mobile" name="mobile"
                                               placeholder="Enter Phone Number">
                                    </div>
                                </div>

                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="email" class="input-group-text">
                                            Email Address
                                        </label>
                                        <input value="<?= ($userDetail->email) ? $userDetail->email : "" ?>" type="text"
                                               class="form-control" id="email" name="email"
                                               placeholder="Enter Email Address">
                                    </div>
                                </div>
                                <!--                                contact details end-->
                                <div class="row m-0">
                                    <div class="col-md-12">
                                        <h1 class="heading-style">Borrowers Details</h1>
                                    </div>
                                </div>
                                <!--                                Borrowers details start-->
                                <div class="row">
                                    <div class="col-md-12 padd-20">
                                        <div id="addAnotherCo">
                                            <div id="parent_student_borrower">
                                                <div class="coapplicant">
                                                    <div class="col-md-12 padd-20 display-flex"><span
                                                                class="input-group-text">Borrower's Details</span>
                                                    </div>
                                                    <div class="col-md-12 padd-20">
                                                        <div class="form-group">
                                                            <label for="co-name" class="input-group-text">
                                                                Name
                                                            </label>
                                                            <input type="text" name="co-name[1]"
                                                                   class="form-control text-capitalize" id="co-name"
                                                                   placeholder="Enter Full Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 padd-20">
                                                        <div class="form-group">
                                                            <div class="radio-heading input-group-text">
                                                                Relation
                                                            </div>
                                                            <ul id="co-relation-ul-1" class="displayInline">
                                                                <li>
                                                                    <label for="co-father-z" class="container-radio">
                                                                        <input type="radio" value="Father"
                                                                               checked="checked" name="co-relation[1]"
                                                                               id="co-father-z"
                                                                               class="checkbox-input services">
                                                                        <span class="checkmark">Father</span>
                                                                    </label>
                                                                </li>
                                                                <li>
                                                                    <label for="co-mother-z" class="container-radio">
                                                                        <input type="radio" value="Mother"
                                                                               name="co-relation[1]" id="co-mother-z"
                                                                               class="checkbox-input services">
                                                                        <span class="checkmark">Mother</span>
                                                                    </label>
                                                                </li>
                                                                <li>
                                                                    <label for="co-brother-z" class="container-radio">
                                                                        <input type="radio" value="Brother"
                                                                               name="co-relation[1]" id="co-brother-z"
                                                                               class="checkbox-input services">
                                                                        <span class="checkmark">Brother</span>
                                                                    </label>
                                                                </li>
                                                                <li>
                                                                    <label for="co-sister-z" class="container-radio">
                                                                        <input type="radio" value="Sister"
                                                                               name="co-relation[1]" id="co-sister-z"
                                                                               class="checkbox-input services">
                                                                        <span class="checkmark">Sister</span>
                                                                    </label>
                                                                </li>
                                                                <li>
                                                                    <label for="co-guardian-z" class="container-radio">
                                                                        <input type="radio" value="Guardian"
                                                                               name="co-relation[1]" id="co-guardian-z"
                                                                               class="checkbox-input services">
                                                                        <span class="checkmark">Guardian</span>
                                                                    </label>
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
                                                                    <label for="sal-z" class="container-radio">
                                                                        <input type="radio" value="1" checked="checked"
                                                                               id="sal-z" name="co-emptype[1]"
                                                                               class="checkbox-input services">
                                                                        <span class="checkmark">Salaried</span>
                                                                    </label>
                                                                </li>
                                                                <li>
                                                                    <label for="self-z" class="container-radio">
                                                                        <input type="radio" value="2" id="self-z"
                                                                               name="co-emptype[1]"
                                                                               class="checkbox-input services">
                                                                        <span class="checkmark">Self-Employed</span>
                                                                    </label>
                                                                </li>
                                                                <li>
                                                                    <label for="non-z" class="container-radio">
                                                                        <input type="radio" value="3" id="non-z"
                                                                               name="co-emptype[1]"
                                                                               class="checkbox-input services">
                                                                        <span class="checkmark">Non-Working</span>
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
                                                            <input type="text" name="co-anualincome[1]" minlength="3"
                                                                   maxlength="7" class="form-control"
                                                                   id="co-anualincome"
                                                                   placeholder="Enter Annual Income">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 padd-20 displayFlex" id="addAnotherButton">
                                            <button type="button" class="addAnotherCo input-group-text"
                                                    onclick="addAnotherCo(randomVal())"><i
                                                        class="fas fa-plus-square"></i> Add Another Co-Borrower
                                                (Optional, You Can Add Multiple If You Want)
                                            </button>
                                        </div>
                                        <!--                                Borrowers details end-->

                                        <div class="col-md-12 padd-20">
                                            <p class="termsText">By clicking submit you agree to our <a
                                                        href="<?= Url::to('terms-and-conditions') ?>">terms and
                                                    conditions</a></p>
                                        </div>
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
            <?php
            if ($action_name == 'interest-free') {
                echo $this->render('/widgets/education-loan/interest-free-loan-content');
            } else {
                echo $this->render('/widgets/education-loan/loan-form-content');
            }
            ?>
        </div>
    </section>
    <input type="hidden" name="colg_text" id="colg_text">
    <input type="hidden" name="colg_id" id="colg_id">
    <input type="hidden" name="pulled_from" id="pulled_from">
<?php
$this->registerCss('
.container-radio-second {
  cursor: pointer;
  display: inline-block;
  float: left;
  -webkit-user-select: none;
  user-select: none;
  font-family:roboto;
  font-size:16px;
  margin-bottom:5px;
  padding-left:0.375em;
}
.container-radio-second svg {
  fill: none;
  vertical-align: middle;
}
.container-radio-second svg circle {
  stroke-width: 2;
  stroke: #C8CCD4;
}
.container-radio-second svg path {
  stroke: #008FFF;
}
.container-radio-second svg path.inner {
  stroke-width: 6;
  stroke-dasharray: 19;
  stroke-dashoffset: 19;
}
.container-radio-second svg path.outer {
  stroke-width: 2;
  stroke-dasharray: 57;
  stroke-dashoffset: 57;
}
.container-radio-second input {
  display: none;
}
.container-radio-second input:checked + svg path {
  transition: all 0.4s ease;
}
.container-radio-second input:checked + svg path.inner {
  stroke-dashoffset: 38;
  transition-delay: 0.3s;
}
.container-radio-second input:checked + svg path.outer {
  stroke-dashoffset: 0;
}
.container-radio-second span {
  display: inline-block;
  vertical-align: middle;
}
.child-info-div{
    padding: 0px 15px;
}
.childFormBox > div:first-child{
    margin-top:20px;
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
.heading-style{
    font-size: 24px;
    margin-top: 0;
}
.heading-style:before {
    top: -4px;
}
.loan-benefits li{
    color:#f3f3f2;
    font-size: 16px; 
    text-align:left;
    list-style: outside;   
    font-family:roboto;
}
.loan-benefits{
    list-style:none; 
    margin-bottom:15px;
    }
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
    padding-right:15px;
}
.cl-icon{
    margin-top: 15px;
}
.cl-icon p{
    color:#fff;
    font-size:20px;
    padding-top:5px;
    font-weight:bold;
//    padding-bottom:10px;
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
    padding: 30px 25px 0 25px;
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
//    .cl-heading{
//        font-size:10px;
//        display:none;
//    }
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
    font-weight:bold;
    font-family:roboto;
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
    font-size: 16px;
    margin-bottom:10px;
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
  display: flex;
  position: relative;
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
  left:-9999px;
}
.checkmark {
    display: flex;
    align-items: center;
    padding: 3px 8px 3px 5px;
    border-radius: 99em;
    transition: 0.25s ease;
}
.checkmark:before {
    display: flex;
    flex-shrink: 0;
    content: "";
    background-color: #fff;
    width: 1.3em;
    height: 1.3em;
    border-radius: 50%;
    margin-right: 0.375em;
    transition: 0.25s ease;
    box-shadow: inset 0 0 0 0.125em #00a0e3;   
    font-family:roboto;
}
.container-radio:hover input ~ .checkmark {
  background-color:#f7f7ff;
}

.container-radio input:checked ~ .checkmark {
  background-color:#f7f7ff;
  font-weight:500;
}
.container-radio input:checked ~ .checkmark:before {
    box-shadow: inset 0 0 1px 5px #00a0e3;
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
.help-block-error,.errorMsg
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
.select2-container--default
{
width:100% !important;
}
.select2-selection__choice__remove{
    display: none;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice{
    padding-left: 0px;
    background: transparent;
    border: none;
}
.select2-selection{
    border: 1px solid #c2cad8 !important;
    border-radius: 0 !important;
    box-shadow: none;
    height: 45px;
    padding: 6px 12px;
}
.select2-container .select2-search--inline .select2-search__field{
    margin-top: 0px;
    margin-left: 0px;
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
//    .cl-heading{
//        font-size:10px;
//        display:none;
//    }
    .cl-text{
        font-size: 14px;
//        display:none;
    }
    .cl-icon img{
        margin: 20px auto;
    }
    .loan-benefits{
        padding-inline-start: 0px;
    }
}
#collegeLoanBox,#hideDiveChild,#parent_co_borrower{
display:none;
}
');
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
        $('#the-basics-city .typeahead').typeahead({
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
function timer(time,update,complete) {
    var start = new Date().getTime();
    var interval = setInterval(function() {
        var now = time-(new Date().getTime()-start);
        if( now <= 0) {
            clearInterval(interval);
            complete();
        }
        else update(Math.floor(now/1000));
    },100); // the smaller this number, the more accurate the timer will be
}
var global_r = false;
$(document).on('click','input[name="college_taken"]',function(e) {
  var val = $(this).val();
  if (val==1){
      $('#college_box').show();
  }else if (val==0){
      $('#college_box').hide();
  }
})
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
    getCourses(); 
    getCountries();    
    getCollegeList(datatype=0,source=3,type=['College']);
    getColleges(datatype=0,source=3,type=['College']);
     function getColleges(datatype, source, type) {
         var _colleges = [];
         $.ajax({ 
            url : '/api/v3/companies/organization-list',
            method : 'GET',  
            data:{
                datatype:datatype,
                source:source, 
                type:type
                },   
            success : function(res) {
             if (res.response.status==200){
                 var res = res.response.results;
              $.each(res,function(index,value) 
                  {   
                   _colleges.push(value.text);
                  });    
              }
               else
                {
                   console.log('colleges could not fetch');
                }
            }
            })
            
           $('#the-basics-college .typeahead').typeahead({
             hint: true, 
             highlight: true,
             minLength: 1
            },
             {
             name: '_colleges',
             source: substringMatcher(_colleges)
             }); 
       }
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
                placeholder: "Search Or Type Your College / Univerity",
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
    
    $('.js-example-basic-multiple').select2({
        maximumSelectionLength: 1,
        placeholder: 'Select Country',  
    });
    function getCountries() { 
        $.ajax({     
            url : 'https://www.empoweryouth.com/api/v3/countries-list/get-countries-list', 
            method : 'POST',
            success : function(res) { 
            if (res.response.status==200){
                var html = [];
                 res = res.response.countries;
                $.each(res,function(index,value) 
                  {
                    // html.push('<option value="">Select Country</option>')
                    html.push('<option value="'+value.country_enc_id+'">'+value.name+'</option>');
                  }); 
                    $('#country_name').html(html);   
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
    function getCourses(){
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
    $.validator.addMethod("check_date_of_birth", function (value, element) {
    
    var dateOfBirth = value;
    var arr_dateText = dateOfBirth.split("/");
    day = arr_dateText[1];
    month = arr_dateText[0];
    year = arr_dateText[2];
    var mydate = new Date();
    mydate.setFullYear(year, month - 1, day);
    
    var maxDate = new Date();
    if ((maxDate.getFullYear()-year) <= 3) {
        $.validator.messages.check_date_of_birth = "Sorry, only persons above the age of 3 can be covered";
        return false;
    }
    return true;
});
jQuery.validator.addClassRules('child_name', {
        required: true
    });
jQuery.validator.addClassRules('child_class', {
        required: true 
    });
jQuery.validator.addClassRules('child_school', {
        required: true 
    });
jQuery.validator.addClassRules('child_loan', {
        required: true 
    });
    $('#mobile, #loanamount').mask("#", {reverse: true});
    $('#co-anualincome').mask("#", {reverse: true});
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
				'college_taken':{
				    required:true,
				},
				'noChild':{
				    required:true,
				},
				'dob':{
				    required:true,
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
				'college_name':{
				    required:true,
				},
				'applicantRadio':{
				    required:true,
				},
				'course_name_text':{
				    required:true,
				},
				'country_name':{
				    required:true,
				},
				'loanamount':{ 
				    required:true,
				    min:1000,
				    max:5000000
				},
				'co-name[1]':{
				    required:true,
				},
				'co-relation':{
				    required:true,
				},
				'co-anualincome[1]':{
				    required:true,
				    min:1000,
				    max:5000000
				},
				'co-relation[1]':{ 
				    required:true,
				},
				'co-name[2]':{
				    required:true,
				},
				'co-anualincome[2]':{
				    required:true,
				    min:500,
				    max:5000000
				},
				'co-relation[2]':{ 
				    required:true,
				},
				'applicantTypeRadio':{ 
				    required:true,
				},
				'salary':{ 
				    required:true,
				    min:5000,
				    max:5000000
				},
			},
			messages: {
           'salary':{
				    required:'Salary Amount Cannot Be Blank',
				},
				'applicant_name': {
					required: "Applicant Name Required",
				},
				'applicantRadio': {
					required: "Please Select Option",
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
				'co-name[1]':{
				    required:'Enter Full Name',
				},
				'co-anualincome[1]':{
				    required:'Enter Annual income',
				},
			
				'co-relation[1]':{
				    required:'Select Relation',
				}, 
				
				'co-name[2]':{
				    required:'Enter Full Name',
				},
				'co-anualincome[2]':{
				    required:'Enter Annual income',
				},
				'applicantTypeRadio':{
				    required:'Please Select Loan Type',
				},
				'co-relation[2]':{
				    required:'Select Relation',
				}, 
				'co-relation':{
				    required:'Select Relation',
				}, 
				
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
                    else if (element.attr("name") == "college_taken")
                    { 
                         error.insertAfter("#college_taken_error");   
                    }
                    else if (element.attr("name") == "co-relation")
                    { 
                         error.insertAfter("#co-relation-ul");   
                    }
                    else if (element.attr("name") == "applicantRadio")
                    { 
                         error.insertAfter("#applicantRadio");   
                    } 
                    else if (element.attr("name") == "applicantTypeRadio")
                    { 
                         error.insertAfter("#applicantTypeRadio");   
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
    
    $('.datepicker3').datepicker({
     todayHighlight: true
});
    
function ajaxSubmit(){
    var applicantRadio = $('input[name="applicantRadio"]:checked').val();
    var loan_application_type = $('input[name="applicantTypeRadio"]:checked').val();
    let co_applicants = [];
    var obj = {};
    if (applicantRadio==0){
        obj['name'] = $.trim($('input[name="co-name[1]"]').not(':hidden').val());
    obj['relation'] = $('input[name="co-relation[1]"]:checked').not(':hidden').val();
    obj['employment_type'] = $('input[name="co-emptype[1]"]:checked').not(':hidden').val();
    obj['annual_income'] = $('input[name="co-anualincome[1]"]').not(':hidden').val(); 
    co_applicants.push(obj);
    if ($('input[name="co-name[2]"]').length>0){
        if ($.trim($('input[name="co-name[2]"]').val()).length!=0)
        {
        var objCoBorrower = {};
        objCoBorrower['name'] = $.trim($('input[name="co-name[2]"]').not(':hidden').val());
        objCoBorrower['relation'] = $('input[name="co-relation[2]"]:checked').not(':hidden').val();
        objCoBorrower['employment_type'] = $('input[name="co-emptype[2]"]:checked').not(':hidden').val();
        objCoBorrower['annual_income'] = $('input[name="co-anualincome[2]"]').not(':hidden').val();
        co_applicants.push(objCoBorrower);
        }
    }
    }else if (applicantRadio==1){
         obj['name'] = $.trim($('input[name="co-name[1]"]').val());
         obj['relation'] = $('input[name="co-relation[1]"]:checked').val();
         obj['employment_type'] = $('input[name="co-emptype[1]"]:checked').val();
         obj['annual_income'] = $('input[name="co-anualincome[1]"]').val(); 
         co_applicants.push(obj);
        if ($('input[name="co-name[2]"]').length>0){
        if ($.trim($('input[name="co-name[2]"]').val()).length!=0)
        {
        var objCoBorrower = {};
        objCoBorrower['name'] = $.trim($('input[name="co-name[2]"]').val());
        objCoBorrower['relation'] = $('input[name="co-relation[2]"]:checked').val();
        objCoBorrower['employment_type'] = $('input[name="co-emptype[2]"]:checked').val();
        objCoBorrower['annual_income'] = $('input[name="co-anualincome[2]"]').val();
        co_applicants.push(objCoBorrower);
        }
    }
    }
    var url = '';
    var data = {};
    if(loan_application_type==0){
        let college_course_info = [];
        var object = {};  
        object['pulled_from'] = $('#pulled_from').val();
        object['course_text'] = $('#course_name_text').val();
        object['colg_text'] = $('#colg_text').val();
        object['colg_id'] = $('#colg_id').val();
        college_course_info.push(object);
        url = '/api/v3/education-loan/save-application';
        data = {
                applicant_name:$.trim($('#applicant_name').val()),
                applicant_dob:$('#dob').val(),
                is_applicant:applicantRadio,                
                applicant_current_city:$('#location').val(),
                years:$('#years').val(),
                semesters:$('#semesters').val(),
                phone:$('#mobile').val(),
                email:$('#email').val(),
                amount:$('#loanamount').val(),   
                co_applicants:co_applicants,
                college_course_info:college_course_info,
                userID:userID, 
                getLender:getLender, 
                is_india:$('input[name="countryRadio"]:checked').val(),
                is_addmission_taken:$('input[name="college_taken"]:checked').val(),
                country_enc_id:$('#country_name').val()[0],
                refferal_id : refferal_id
                };
    }else if (loan_application_type==1){
        let child_information = [];
    var obj = {};
    if (applicantRadio=='1'){
        for (var i= 0; i<$('#noChild').val();i++){
        obj['child_loan_amount'] =  $('.child_loan:eq('+i+')').val();
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
        obj['child_loan_amount'] = $('#loanamount').val();
        child_information.push(obj);
    }
    if (applicantRadio==1){
        var applicant_name = $('input[name="co-name[1]"]').val();
    }else{
        var applicant_name = $('#applicant_name').val();
    }
         data = {
                applicant_name:applicant_name,
                co_applicants:co_applicants,
                applicant_dob:$('#dob').val(),
                is_applicant:applicantRadio,
                applicant_current_city:$('#location').val(),
                phone:$('#mobile').val(),
                email:$('#email').val(),
                amount:$('#loanamount').val(),   
                yearly_income:$('#salary').val(),   
                child_information:child_information,
                userID:userID,
                getLender:getLender
                }
        url = '/api/v3/education-loan/save-school-fee-loan';
    }
    $.ajax({
            url : url,
            method : 'POST', 
            data : data,  
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
                       //    processPayment(ptoken,loan_id,education_loan_id);
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
                $('#prevBtn').show();     
                $('#loadBtn').hide();
            }
        });
    }
    
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
function processPayment(ptoken,loan_id,education_loan_id){
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
function updateStatus(education_loan_id,loan_app_enc_id,payment_id=null,status,signature=null){
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
                $('#prevBtn').hide();     
                $('#loadBtn').show();   
            },
            success:function(e)
            {
                if (status=="captured"){
                    if (e.response.status=='200'){
                         if (userID==''){
                          swal({
                            title: "",
                            text: "Your Application Is Submitted Successfully Please Sign Up To Track and Process Your Application Further, You Can Then Check Status Of Your Application On Dashboard",
                            type:'success',
                            showCancelButton: false,  
                            confirmButtonClass: "btn-primary",
                            confirmButtonText: "Proceed To Sign Up",
                            closeOnConfirm: false, 
                        },
                            function (isConfirm) { 
                                 if (isConfirm==true){
                                     window.location.replace('/signup/individual?loan_id_ref='+loan_app_enc_id);
                                 }
                            }
                        );
                        } else {
                        timer(
                         8000, // milliseconds
                         function(timeleft) { // called every step to update the visible countdown
                         document.getElementById('timer').innerHTML = "<b style='color:#00A0E3 !important'>"+timeleft+"</b> second(s)";
                        },
                        function() { // what to do after
                     window.location.replace('/account/education-loans/candidate-dashboard/'+loan_app_enc_id);
                    }
                        );     
                          swal({
                                title: "",
                                html: true,  
                                text: "Your Application Is Submitted Successfully, You Will Redirected To Dashboard in <span id='timer'></span> For Document and Information Processing on Further Stage, Don't Close The Page",
                                type:'success',
                                showCancelButton: false,  
                                confirmButtonClass: "btn-primary",
                                confirmButtonText: "Proceed To Dashboard",
                                closeOnConfirm: false, 
                            },
                                function (isConfirm) { 
                                  if (isConfirm==true){
                                     window.location.replace('/account/education-loans/candidate-dashboard/'+loan_app_enc_id);
                                    }
                                  }
                            );
                        }
                    } else {
                        swal({
                         title:"Payment Error",
                         text: 'Your Payment Status Will Be Update In 1-2 Business Day',
                      });
                    }
                }
                $('#subBtn').show();     
                $('#prevBtn').show();     
                $('#loadBtn').hide();
            }
    })
}
$(document).on('keyup','.child_loan',function(e) {
   var sum = 0;
    $('.child_loan').each(function(){
    sum += !isNaN(parseFloat(this.value)) ? parseFloat(this.value) : 0;
    $('#loanamount').val(sum);
});
});
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

        function createChild() {
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
                '                                            <input type="text" minlength="2" class="form-control text-capitalize child_class" id="class_name_1" name="class_name_1" placeholder="Class Name">\n' +
                '                                        </div>\n' +
                '                                    </div>'
            return child;
        }

        function removeChild() {

        }

        showChildInfo = (event) => {
            let eventValue = event.currentTarget.value;
            if (eventValue == 1) {
                document.querySelector('.child-info-div').style.display = 'block';
                document.querySelector('#childTwo').style.display = 'none';
                document.querySelector('#schoolAttend').style.display = 'none';
            } else if (eventValue == 2) {
                document.querySelector('.child-info-div').style.display = 'block';
                document.querySelector('#childTwo').style.display = 'block';
                document.querySelector('#schoolAttend').style.display = 'block';
            }
        }
        showSchoolField = () => {
            let schoolNameField = document.querySelectorAll('.schoolNameField')
            if (event.target.checked) {
                for (let i = 0; i < schoolNameField.length; i++) {
                    schoolNameField[i].classList.add('displayNone');
                }
                schoolNameField[0].classList.remove('displayNone');
            } else {
                for (let i = 0; i < schoolNameField.length; i++) {
                    schoolNameField[i].classList.remove('displayNone');
                }
            }
            ;
        }
        checkChildInfo = (event) => {
            let num = parseInt(event.value);
            let parentElem = event.parentElement;
            let childFormBox = document.querySelectorAll('.childFormBox');
            if (!/^\+?([0-9]{1}){1}$/.test(num) || num > 9 || num == '') {
                parentElem.querySelector('.errorMsg').style.display = "block";
                parentElem.querySelector('.errorMsg').innerHTML = errorMsgText(num);
                removeChildFormBox(num, childFormBox)
            } else {
                parentElem.querySelector('.errorMsg').style.display = "none";
                let childDiv = document.querySelector('.child-info-div');
                childDiv.innerHTML = '';
                let count = 1;
                for (let i = 1; i <= num; i++) {
                    let childForm = childrenInfoForm(count, num);
                    childDiv.innerHTML += childForm;
                    count++;
                    $('.child_loan').mask("#", {reverse: true});
                }
            }
        }
        errorMsgText = (num) => {
            switch (num) {
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
            if (childFormBox.length > 0) {
                for (let i = 0; i < childFormBox.length; i++) {
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
                      Child Name
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

                ` : ''}
            </div>
            <div class="col-md-12 padd-20">
                <div class="form-group">
                    <label for="class_name_${count}" class="input-group-text">
                        Class
                    </label>
                    <input type="text" minlength="2" minlength="255" class="form-control text-capitalize child_class" id="class_name_${count}"
                        name="class_name_${count}" placeholder="Class Name">
                </div>
            </div>
         <div class="col-md-12 padd-20">
                <div class="form-group">
                    <label for="loan_amount_${count}" class="input-group-text">
                        Loan Amount For Student ${count}
                    </label>
                    <input type="text" min="1000" max="5000000" class="form-control text-capitalize child_loan" id="child_loan_${count}"
                        name="loan_amount_${count}" placeholder="Loan Amount">
                </div>
            </div>
        </div>`
            return childInfoForm;
        }

        function addAnotherCo(randomVal) {
            var coApplicant = ['<div class="col-md-12 padd-20 display-flex"><span class="input-group-text">Other Co-Borrower\'s Details (Optional)</span><button type="button" class="addAnotherCo input-group-text float-right" onclick="RemoveAnotherCo(this)"> Remove</button>\n' +
            '                                    </div>\n' +
            '                                    <div class="col-md-12 padd-20">\n' +
            '                                        <div class="form-group">\n' +
            '                                            <label for="co-name-' + randomVal + '" class="input-group-text">\n' +
            '                                                Name\n' +
            '                                            </label>\n' +
            '                                            <input type="text" name="co-name[2]" class="form-control" id="co-name-' + randomVal + '"\n' +
            '                                                   placeholder="Enter Full Name">\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                    <div class="col-md-12 padd-20">\n' +
            '                                        <div class="form-group">\n' +
            '                                            <div class="radio-heading input-group-text">\n' +
            '                                                Relation\n' +
            '                                            </div>\n' +
            '                                           <ul id="co-relation-ul-2" class="displayInline">' +
            '                                                 <li>\n' +
            '                                                 <input type="radio" value="Father" checked="checked" name="co-relation[2]" id="co-father-2" class="checkbox-input services">\n' +
            '                                                 <label for="co-father-2">Father</label>\n' +
            '                                                 </li>' +
            '                                                 <li>\n' +
            '                                                 <input type="radio" value="Mother"  name="co-relation[2]" id="co-mother-2" class="checkbox-input services">\n' +
            '                                                 <label for="co-mother-2">Mother</label>\n' +
            '                                                 </li>' +
            '                                                 <li>\n' +
            '                                                 <input type="radio" value="Brother"  name="co-relation[2]" id="co-brother-2" class="checkbox-input services">\n' +
            '                                                 <label for="co-brother-2">Brother</label>\n' +
            '                                                 </li>' +
            '                                                 <li>\n' +
            '                                                 <input type="radio" value="Sister"  name="co-relation[2]" id="co-sister-2" class="checkbox-input services">\n' +
            '                                                 <label for="co-sister-2">Sister</label>\n' +
            '                                                 </li>' +
            '                                                 <li>\n' +
            '                                                 <input type="radio" value="Guardian"  name="co-relation[2]" id="co-guardian-2" class="checkbox-input services">\n' +
            '                                                 <label for="co-guardian-2">Guardian</label>\n' +
            '                                                 </li>' +
            '                                       </ul>\n' +
            '                                  </div>\n' +
            '                                    </div>\n' +
            '                                    <div class="col-md-12 padd-20">\n' +
            '                                        <div class="form-group">\n' +
            '                                            <div class="radio-heading input-group-text">\n' +
            '                                               Employment type ?\n' +
            '                                            </div>\n' +
            '                                           <ul class="displayInline">\n' +
            '                                                       <li>\n' +
            '                                                            <input type="radio" value="1" checked="checked" id="sal-2" name="co-emptype[2]" class="checkbox-input services">\n' +
            '                                                            <label for="sal-2">Salaried</label>\n' +
            '                                                        </li>\n' +
            '                                                       <li>\n' +
            '                                                            <input type="radio" value="2"  id="self-2" name="co-emptype[2]" class="checkbox-input services">\n' +
            '                                                            <label for="self-2">Self-Employed</label>\n' +
            '                                                        </li>\n' +
            '                                                       <li>\n' +
            '                                                            <input type="radio" value="3"  id="non-2" name="co-emptype[2]" class="checkbox-input services">\n' +
            '                                                            <label for="non-2">Non-Working</label>\n' +
            '                                                        </li>\n' +
            '                                           </ul>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                    <div class="col-md-12 padd-20">\n' +
            '                                        <div class="form-group">\n' +
            '                                            <label for="annulIncome" class="input-group-text">\n' +
            '                                               Annual Income\n' +
            '                                            </label>\n' +
            '                                            <input type="text" name="co-anualincome[2]" class="form-control" id="co-anualincome-' + randomVal + '"\n' +
            '                                                   placeholder="Enter Annual Income">\n' +
            '                                        </div>\n' +
            '                                    </div>' +
            '                                    </div>'];
            var textnode = document.createElement("div");
            textnode.setAttribute('class', 'coapplicant');
            textnode.innerHTML = coApplicant;
            document.getElementById('addAnotherCo').appendChild(textnode);
            let coapplicants = document.getElementsByClassName('coapplicant');
            if (coapplicants.length > 1) {
                document.getElementById('addAnotherButton').style.display = "none"
            }
        }

        function RemoveAnotherCo(ths) {
            $('html,body').animate({
                scrollTop: 0
            }, 'slow');
            ths.closest('.coapplicant').remove();
            let coapplicants = document.getElementsByClassName('coapplicant');
            if (coapplicants.length < 2) {
                document.getElementById('addAnotherButton').style.display = "block"
            }
        }

        function showCountry(ths) {
            let radioValue = ths.value;
            const countryName = document.getElementById('countryName');
            if (radioValue == '0') {
                countryName.style.display = "block";
            } else {
                countryName.style.display = "none";
            }
        }

        function showChildren(ths) {
            const applicantRadio = $('input[name="applicantRadio"]:checked').val();
            // if (applicantRadio==null||applicantRadio==""||applicantRadio=='undefined'){
            //     swal({
            //         title:"Warning",
            //         text: 'Please Select Relation First !!'
            //     });
            //     ths.checked = false;
            //     return false;
            // }
            let radioValue = ths.value;
            const countryName = document.getElementById('hideDiveChild');
            const schoolInfo = document.getElementById('schooInfo');
            const collegeLoanBox = document.getElementById('collegeLoanBox');
            if (radioValue == '1') {
                collegeLoanBox.style.display = "none";
                if (applicantRadio == 1) {
                    //alert('parent as school');
                    $('#loanamount').attr('readonly', 'true');
                    $('#total_sec').show();
                    countryName.style.display = "block";
                    document.getElementById('student_name_col').style.display = "none";
                    schoolInfo.innerHTML = "";
                    document.getElementById('noChild').value = "";
                } else if (applicantRadio == 0) {
                    //alert('student as school');
                    $('#loanamount').removeAttr('readOnly');
                    $('#total_sec').hide();
                    countryName.style.display = "none";
                    document.getElementById('student_name_col').style.display = "block";
                    schoolInfo.innerHTML = createChild();
                    let childFormBox = document.querySelectorAll('.childFormBox');
                    let num = 1;
                    removeChildFormBox(num, childFormBox);
                }
            } else {
                schoolInfo.innerHTML = "";
                document.getElementById('noChild').value = "";
                countryName.style.display = "none";
                document.getElementById('student_name_col').style.display = "block";
                collegeLoanBox.style.display = "block";
            }
        }

        function hideChildren(ths) {
            const applicantRadio = $('input[name="applicantRadio"]:checked').val();
            // if (applicantRadio==null||applicantRadio==""||applicantRadio=='undefined'){
            //     swal({
            //         title:"Warning",
            //         text: 'Please Select Relation First !!'
            //     });
            //     ths.checked = false;
            //     return false;
            // }
            let radioValue = ths.value;
            const countryName = document.getElementById('hideDiveChild');
            const schoolInfo = document.getElementById('schooInfo');
            const collegeLoanBox = document.getElementById('collegeLoanBox');
            if (radioValue == '0') {
                $('#loanamount').removeAttr('readOnly');
                $('#total_sec').hide();
                schoolInfo.innerHTML = "";
                document.getElementById('noChild').value = "";
                countryName.style.display = "none";
                document.getElementById('student_name_col').style.display = "block";
                collegeLoanBox.style.display = "block";
                let childFormBox = document.querySelectorAll('.childFormBox');
                let num = 1;
                removeChildFormBox(num, childFormBox);
            } else {
                collegeLoanBox.style.display = "none";
                if (applicantRadio == 1) {
                    countryName.style.display = "block";
                    document.getElementById('student_name_col').style.display = "none";
                    schoolInfo.innerHTML = "";
                    document.getElementById('noChild').value = "";
                } else if (applicantRadio == 0) {
                    countryName.style.display = "none";
                    document.getElementById('student_name_col').style.display = "block";
                    schoolInfo.innerHTML = createChild();
                    let childFormBox = document.querySelectorAll('.childFormBox');
                    let num = 1;
                    removeChildFormBox(num, childFormBox);
                }
            }
        }

        function showRelation(ths) {
            const applicantRadio = $('input[name="applicantTypeRadio"]:checked').val();
            let radioValue = ths.value;
            const countryName = document.getElementById('hideDiveChild');
            const schoolInfo = document.getElementById('schooInfo');
            const collegeLoanBox = document.getElementById('collegeLoanBox');
            const ParentCoBorrower = document.getElementById('parent_co_borrower');
            if (radioValue == '1') {
                //alert('parent');
                $('#parent_student_borrower').css('display', 'none');
                ParentCoBorrower.style.display = "block";
                if (applicantRadio != '' || applicantRadio != null) {
                    if (applicantRadio == '0') {
                        // alert('parent college');
                        $('#loanamount').removeAttr('readOnly');
                        $('#total_sec').hide();
                        $('#parent_student_borrower').css('display', 'none');
                        schoolInfo.innerHTML = "";
                        document.getElementById('noChild').value = "";
                        countryName.style.display = "none";
                        document.getElementById('student_name_col').style.display = "block";
                        collegeLoanBox.style.display = "block";
                        let childFormBox = document.querySelectorAll('.childFormBox');
                        let num = 1;
                        removeChildFormBox(num, childFormBox);
                    } else if (applicantRadio == '1') {
                        //alert('parent school');
                        $('#loanamount').attr('readonly', 'true');
                        $('#total_sec').show();
                        $('#parent_student_borrower').css('display', 'none');
                        collegeLoanBox.style.display = "none";
                        countryName.style.display = "block";
                        document.getElementById('student_name_col').style.display = "none";
                        schoolInfo.innerHTML = "";
                        document.getElementById('noChild').value = "";
                    }
                }
            }
        }

        function hideRelation(ths) {
            const applicantRadio = $('input[name="applicantTypeRadio"]:checked').val();
            let radioValue = ths.value;
            const countryName = document.getElementById('hideDiveChild');
            const schoolInfo = document.getElementById('schooInfo');
            const collegeLoanBox = document.getElementById('collegeLoanBox');
            const ParentCoBorrower = document.getElementById('parent_co_borrower');
            if (radioValue == '0') {
                // alert('student');
                $('#parent_student_borrower').css('display', 'block');
                ParentCoBorrower.style.display = "none";
                if (applicantRadio != '' || applicantRadio != null) {
                    if (applicantRadio == '0') {
                        //alert('student college');
                        $('#parent_student_borrower').css('display', 'block');
                        schoolInfo.innerHTML = "";
                        document.getElementById('noChild').value = "";
                        countryName.style.display = "none";
                        document.getElementById('student_name_col').style.display = "block";
                        collegeLoanBox.style.display = "block";
                        let childFormBox = document.querySelectorAll('.childFormBox');
                        let num = 1;
                        removeChildFormBox(num, childFormBox);
                    } else if (applicantRadio == '1') {
                        //alert('student school');
                        $('#loanamount').removeAttr('readOnly');
                        $('#total_sec').hide();
                        $('#parent_student_borrower').css('display', 'block');
                        countryName.style.display = "none";
                        document.getElementById('student_name_col').style.display = "block";
                        schoolInfo.innerHTML = createChild();
                        let childFormBox = document.querySelectorAll('.childFormBox');
                        let num = 1;
                        removeChildFormBox(num, childFormBox);
                    }
                }
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
$this->registerJsFile('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
