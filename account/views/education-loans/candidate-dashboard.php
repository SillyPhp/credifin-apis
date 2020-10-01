<?php

use yii\helpers\Url;

$user_id = Yii::$app->user->identity->user_enc_id;
Yii::$app->view->registerJs('var user_enc_id = "' . $user_id . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var loan_app_id = "' . $loan_app_id . '"', \yii\web\View::POS_HEAD);
?>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light nd-shadow">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Loan Profile<span data-toggle="tooltip"
                                                                                             title=""
                                                                                             data-original-title="Here you will find all companies that you are following">
                            <i class="fa fa-info-circle"></i>
                        </span>
                    </span>
                </div>
                <div class="actions">
                    <!--                    <a href="/account/organization/shortlisted" title="" class="viewall-jobs">View All</a>-->
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="formNav">
                            <li>
                                <button data-id="applicantProfile" class="topTab activeLi" onclick="activeTab(event)">
                                    Applicant Profile
                                </button>
                            </li>
                            /
                            <li>
                                <button data-id="parentsProfile" class="topTab" onclick="activeTab(event)">Parents
                                    Profile
                                </button>
                            </li>
                            /
                            <li>
                                <button data-id="guarantorProfile" class="topTab" onclick="activeTab(event)">Guarantor's
                                    Profile
                                </button>
                            </li>
                        </ul>
                        <div class="tab tabActive" id="applicantProfile">
                            <section id="applicantBasicInformation" data-key="" data-type="applicant">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 padd-20">
                                        <div class="form-group disFlex">
                                            <label for="yourPic" class="input-group-text">
                                                <div class="uploadPic" id="applicantImage">
                                                    <i class="fa fa-cloud-upload"></i>
                                                </div>
                                            </label>
                                            <div class="ml20"> Upload Photo</div>
                                            <input type="file" class="form-control pic" id="yourPic" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="form-group">
                                            <label for="applicantName" class="input-group-text">
                                                Name of Applicant
                                            </label>
                                            <input type="text" class="form-control" id="applicantName"
                                                   placeholder="Enter Full Name" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="form-group">
                                            <label for="applicantEmail" class="input-group-text">
                                                Email
                                            </label>
                                            <input type="text" class="form-control" id="applicantEmail"
                                                   placeholder="" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="form-group">
                                            <label for="applicantDob" class="input-group-text">
                                                DOB
                                            </label>
                                            <input type="text" class="form-control" id="applicantDob"
                                                   placeholder="--/--/----" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="form-group">
                                            <label for="applicantNumber" class="input-group-text">
                                                Mobile Number
                                            </label>
                                            <input type="text" class="form-control" id="applicantNumber"
                                                   placeholder="" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label class="radio-heading input-group-text" for="degreeApplied">
                                                Degree Applied
                                            </label>
                                            <select class="form-control field-req" name="years" id="degreeApplied"
                                                    disabled>
                                                <option>Diploma</option>
                                                <option>Graduation</option>
                                                <option>Post Graduation</option>
                                                <option>Professional Course</option>
                                                <option>Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="courseApplied" class="input-group-text">
                                                Course Applied
                                            </label>
                                            <input type="text" class="form-control" id="courseApplied"
                                                   placeholder="" disabled>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <div class="row mt10">
                                <div class="col-md-12">
                                    <p class="cd-heading-2">2 ID or Residential Proofs Required</p>
                                </div>
                                <section id="idProofInformation0" data-key="" data-type="id_proof">
                                    <div class="col-md-6 boder-left-1">
                                        <div class="row mt10">
                                            <div class="col-md-6 padd-20">
                                                <div class="form-group">
                                                    <label class="radio-heading input-group-text" for="applicantID0"
                                                           data-field="proof_name">
                                                        ID Proof/Address Proof
                                                    </label>
                                                    <select class="form-control field-req" name="years"
                                                            id="applicantID0">
                                                        <option>Adhaar Card</option>
                                                        <option>PAN</option>
                                                        <option>Passport</option>
                                                        <option>Voter ID</option>
                                                        <option>Driving License</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 padd-20">
                                                <div class="form-group">
                                                    <label for="applicantIDnumber0" class="input-group-text"
                                                           data-field="number">
                                                        Id Proof Number
                                                    </label>
                                                    <input type="text" class="form-control"
                                                           id="applicantIDnumber0"
                                                           placeholder="Number">
                                                </div>
                                            </div>
                                            <div class="col-md-12 padd-20 text-center">
                                                <div class="form-group">
                                                    <div id="applicantIDimage0">
                                                        <label for="applicantIDpic" class="">
                                                            <div class="idPhoto">
                                                                <i class="fa fa-cloud-upload"></i>
                                                                Upload Photo
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <input type="file" class="form-control idProof-input"
                                                           id="applicantIDpic" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section id="idProofInformation1" data-key="" data-type="id_proof">
                                    <div class="col-md-6">
                                        <div class="row mt10">
                                            <div class="col-md-6 padd-20">
                                                <div class="form-group">
                                                    <label class="radio-heading input-group-text"
                                                           for="applicantID1" data-field="proof_name">
                                                        ID Proof/Address Proof
                                                    </label>
                                                    <select class="form-control field-req" name="years"
                                                            id="applicantID1">
                                                        <option>Adhaar Card</option>
                                                        <option>PAN</option>
                                                        <option>Passport</option>
                                                        <option>Voter ID</option>
                                                        <option>Driving License</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 padd-20">
                                                <div class="form-group">
                                                    <label for="applicantIDnumber1" class="input-group-text"
                                                           data-field="number">
                                                        Id Proof Number
                                                    </label>
                                                    <input type="text" class="form-control" id="applicantIDnumber1"
                                                           placeholder="Number">
                                                </div>
                                            </div>
                                            <div class="col-md-12 padd-20 text-center">
                                                <div class="form-group">
                                                    <div id="applicantIDimage1">
                                                        <label for="applicantIDTwoPic" class="">
                                                            <div class="idPhoto">
                                                                <i class="fa fa-cloud-upload"></i>
                                                                Upload Photo
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <input type="file" class="form-control idProof-input"
                                                           id="applicantIDTwoPic" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </div>

                            <div class="FormDivider"></div>
                            <div class="row mt10">
                                <div class="col-md-12">
                                    <h4 class="cd-heading-3">Residential Information</h4>
                                </div>
                            </div>
                            <section id="permanentAddressInformation" data-key="" data-type="address"
                                     data-address-type="0">
                                <div class="row mt10 addressType">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <div class="radio-heading input-group-text">
                                                Permanent Address
                                            </div>
                                            <ul class="displayInline residenceType" id="per_res_type"
                                                data-field="res_type">
                                                <li>
                                                    <label class="container-radio">Rented
                                                        <input type="radio" checked="checked" id="PA-rented" value="0"
                                                               name="address1">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="container-radio">Owned
                                                        <input type="radio" name="address1" id="PA-owned" value="1">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="houseNo" class="input-group-text" data-field="address">
                                                Address
                                            </label>
                                            <input type="text" class="form-control" id="houseNo" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group posRel">
                                            <label for="PA-state" class="input-group-text" data-field="state_id">
                                                State
                                            </label>
                                            <input type="text" class="form-control typeInput" id="PA-state"
                                                   placeholder="" data-url="states" autocomplete="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="PA-city" class="input-group-text" data-field="city_id">
                                                City
                                            </label>
                                            <input type="text" class="form-control typeInput" id="PA-city"
                                                   placeholder="" data-url="cities"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="currentAddressInformation" data-key="" data-type="address"
                                     data-address-type="1">
                                <div class="row mt10 addressType">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group ">
                                            <div class="radio-heading input-group-text">
                                                Current Address
                                            </div>
                                            <ul class="displayInline residenceType" id="cur_res_type"
                                                data-field="res_type">
                                                <li>
                                                    <label class="container-radio">Rented
                                                        <input type="radio" checked="checked" name="address2" value="0"
                                                               id="CA-rented">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="container-radio">Owned
                                                        <input type="radio" name="address2" id="CA-owned" value="1">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label class="input-group-text" for="CA-houseNo" data-field="address">
                                                Address
                                            </label>
                                            <input type="text" class="form-control" id="CA-houseNo" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="CA-state" class="input-group-text" data-field="state_id">
                                                State
                                            </label>
                                            <input type="text" class="form-control typeInput" id="CA-state"
                                                   placeholder="" data-url="states">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="CA-city" class="input-group-text" data-field="city_id">
                                                City
                                            </label>
                                            <input type="text" class="form-control typeInput" id="CA-city"
                                                   placeholder="" data-url="cities"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <div class="FormDivider"></div>
                            <div class="row mt10">
                                <div class="col-md-12">
                                    <h4 class="cd-heading-3">Education</h4>
                                </div>
                            </div>
                            <section id="qualificationInformation0" data-key="" data-type="qualification">
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="eduName0" class="input-group-text" data-field="name">
                                                Qualification
                                            </label>
                                            <input type="text" class="form-control" id="eduName0"
                                                   placeholder="10th">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="instituteName0" class="input-group-text"
                                                   data-field="institution">
                                                Name Of Institution
                                            </label>
                                            <input type="text" class="form-control" id="instituteName0"
                                                   placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="marksObtained0" class="input-group-text"
                                                   data-field="obtained_marks">
                                                Marks Obtained
                                            </label>
                                            <input type="text" class="form-control" id="marksObtained0"
                                                   placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="qualificationInformation1" data-key="" data-type="qualification">
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="eduName1" class="input-group-text" data-field="name">
                                                Qualification
                                            </label>
                                            <input type="text" class="form-control" id="eduName1" placeholder="+2">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="instituteName1" class="input-group-text"
                                                   data-field="institution">
                                                Name Of Institution
                                            </label>
                                            <input type="text" class="form-control" id="instituteName1"
                                                   placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="marksObtained1" class="input-group-text"
                                                   data-field="obtained_marks">
                                                Marks Obtained
                                            </label>
                                            <input type="text" class="form-control" id="marksObtained1"
                                                   placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <div id="eduFields"></div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="button" id="addEduBtn" class="eduBtn2" onclick="addEduField(this)"
                                            data-count="2">Add More
                                    </button>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button" class="eduBtn" data-id="parentsProfile"
                                        onclick="activeTab(event)">Next
                                </button>
                            </div>
                        </div>
                        <div class="tab" id="parentsProfile">
                            <section id="fatherInformation" data-key="" data-type="co_applicant"
                                     data-relation="Father">
                                <div class="row mt10">
                                    <div class="col-md-12">
                                        <h4 class="cd-heading-3">Father's Information</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 padd-20">
                                        <div class="form-group disFlex">
                                            <div id="fatherImage">
                                                <label for="fatherPic" class="input-group-text">
                                                    <div class="uploadPic">
                                                        <i class="fa fa-cloud-upload"></i>
                                                    </div>
                                                </label>
                                                <div class="ml20"> Upload Photo</div>
                                            </div>
                                            <input type="file" class="form-control pic idProof-input" id="fatherPic"
                                                   placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="fatherName" class="input-group-text" data-field="name">
                                                Name
                                            </label>
                                            <input type="text" class="form-control" id="fatherName"
                                                   placeholder="Enter Full Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="fatherEmail" class="input-group-text" data-field="email">
                                                Email
                                            </label>
                                            <input type="text" class="form-control" id="fatherEmail" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="fatherDob" class="input-group-text"
                                                   data-field="co_applicant_dob">
                                                DOB
                                            </label>
                                            <input type="text" class="form-control" id="dob"
                                                   placeholder="--/--/----">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="fatherNumber" class="input-group-text" data-field="phone">
                                                Mobile Number
                                            </label>
                                            <input type="text" class="form-control" id="fatherNumber"
                                                   placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="yearsOFoccu" class="input-group-text"
                                                   data-field="years_in_current_house">
                                                Years Of Occupancy In Current House
                                            </label>
                                            <input type="text" class="form-control" id="yearsOFoccu"
                                                   placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="fOccupation" class="input-group-text"
                                                   data-field="occupation">
                                                Occupation
                                            </label>
                                            <input type="text" class="form-control" id="fOccupation"
                                                   placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="fIncome" class="input-group-text"
                                                   data-field="annual_income">
                                                Annual Income
                                            </label>
                                            <input type="text" class="form-control" id="fIncome"
                                                   placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group ">
                                            <div class="radio-heading input-group-text">
                                                Address
                                            </div>
                                            <ul class="displayInline">
                                                <li>
                                                    <label class="checkcontainer" data-field="address">Same As
                                                        Applicant
                                                        <input class="same_address" type="checkbox" data-id="fAddress"
                                                               id="fSame"
                                                               onchange="hideAddress()">
                                                        <span class="Ch-checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="Father-other-info">
                                    <article id="Father-address-info" data-key="" data-type="address">
                                        <div class="row mt10" id="fAddress">
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group ">
                                                    <div class="radio-heading input-group-text">
                                                        Residence Type
                                                    </div>
                                                    <ul class="displayInline residenceType" data-field="res_type"
                                                        id="Father_Resident_Info">
                                                        <li>
                                                            <label class="container-radio">Rented
                                                                <input type="radio" checked="checked"
                                                                       name="faddress" value="0"
                                                                       id="FRT-rented">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="container-radio">Owned
                                                                <input type="radio" name="faddress" id="FRT-owned"
                                                                       value="1">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group">
                                                    <label for="fHouseNo" class="input-group-text"
                                                           data-field="address">
                                                        Address
                                                    </label>
                                                    <input type="text" class="form-control" id="fHouseNo"
                                                           placeholder="" data-id="coResidentInfo">
                                                </div>
                                            </div>
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group">
                                                    <label for="fState" class="input-group-text"
                                                           data-field="state_id">
                                                        State
                                                    </label>
                                                    <input type="text" class="form-control typeInput" id="fState"
                                                           data-url="states"
                                                           placeholder="" data-id="coResidentInfo">
                                                </div>
                                            </div>
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group">
                                                    <label for="fCity" class="input-group-text"
                                                           data-field="city_id">
                                                        City
                                                    </label>
                                                    <input type="text" class="form-control typeInput" id="fCity"
                                                           placeholder="" data-id="coResidentInfo" data-url="cities"
                                                           disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    <article id="Father-identity-info" data-key="" data-type="id_proof">
                                        <div class="row mt10">
                                            <div class="col-md-4 padd-20">
                                                <div class="form-group">
                                                    <label class="radio-heading input-group-text" for="fIDproof"
                                                           data-field="proof_name">
                                                        ID Proof/Address Proof
                                                    </label>
                                                    <select class="form-control field-req" name="years"
                                                            id="fIDproof" data-id="coProofInfo">
                                                        <option>PAN</option>
                                                        <option>Adhaar Card</option>
                                                        <option>Passport</option>
                                                        <option>Voter ID</option>
                                                        <option>Driving License</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 padd-20">
                                                <div class="form-group">

                                                    <label for="fIDproofnumber" class="input-group-text"
                                                           data-field="number">
                                                        Id Proof Number
                                                    </label>
                                                    <input type="text" class="form-control" id="fIDproofnumber"
                                                           placeholder="Number" data-id="coProofInfo">
                                                </div>
                                            </div>
                                            <div class="col-md-4 padd-20">
                                                <div class="form-group text-center">
                                                    <div id="fIDproofimage">
                                                        <label for="idProofFather" class="">
                                                            <div class="idPhoto">
                                                                <i class="fa fa-cloud-upload"></i>
                                                                Upload ID Proof's Photo
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <input type="file" class="form-control idProof-input"
                                                           id="idProofFather"
                                                           placeholder="" data-id="coProofInfo">
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </section>
                            <div class="FormDivider"></div>
                            <section id="motherInformation" data-key="" data-type="co_applicant"
                                     data-relation="Mother">
                                <div class="row mt10">
                                    <div class="col-md-12">
                                        <h4 class="cd-heading-3">Mother's Information</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 padd-20">
                                        <div class="form-group disFlex">
                                            <div id="motherImage">
                                                <label for="MPic" class="input-group-text">
                                                    <div class="uploadPic">
                                                        <i class="fa fa-cloud-upload"></i>
                                                    </div>
                                                </label>
                                                <div class="ml20"> Upload Photo</div>
                                            </div>
                                            <input type="file" class="form-control pic idProof-input" id="MPic"
                                                   placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="MName" class="input-group-text" data-field="name">
                                                Name
                                            </label>
                                            <input type="text" class="form-control" id="MName"
                                                   placeholder="Enter Full Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="MEmail" class="input-group-text" data-field="email">
                                                Email
                                            </label>
                                            <input type="text" class="form-control" id="MEmail" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="MDob" class="input-group-text"
                                                   data-field="co_applicant_dob">
                                                DOB
                                            </label>
                                            <input type="text" class="form-control" id="MDob"
                                                   placeholder="--/--/----">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label class="input-group-text" for="M-mobile" data-field="phone">
                                                Mobile Number
                                            </label>
                                            <input type="text" class="form-control" id="M-mobile" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="mOccupation" class="input-group-text"
                                                   data-field="occupation">
                                                Occupation
                                            </label>
                                            <select class="form-control field-req" name="mOccupation">
                                                <option>Home-maker</option>
                                                <option>Salaried</option>
                                                <option>Self-employed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="familyIncome" class="input-group-text"
                                                   data-field="annual_income">
                                                Family Income(Anually)
                                            </label>
                                            <input type="text" class="form-control" id="familyIncome"
                                                   placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group ">
                                            <div class="radio-heading input-group-text">
                                                Address
                                            </div>
                                            <ul class="displayInline">
                                                <li>
                                                    <label class="checkcontainer" data-field="address">Same As
                                                        Applicant
                                                        <input class="same_address" type="checkbox" data-id="mAddress"
                                                               id="mSame"
                                                               onchange="hideAddress()">
                                                        <span class="Ch-checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="Mother-other-info">
                                    <article id="Mother-address-info" data-key="" data-type="address">
                                        <div class="row mt10" id="mAddress">
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group ">
                                                    <div class="radio-heading input-group-text">
                                                        Residence Type
                                                    </div>
                                                    <ul class="displayInline residenceType" data-field="res_type"
                                                        id="Mother_Resident_Info">
                                                        <li>
                                                            <label class="container-radio">Rented
                                                                <input type="radio" checked="checked"
                                                                       name="maddress" value="0"
                                                                       id="MRT-rented">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="container-radio">Owned
                                                                <input type="radio" name="maddress" id="MRT-owned"
                                                                       value="1">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group">
                                                    <label for="MHouseNo" class="input-group-text"
                                                           data-field="address">
                                                        Address
                                                    </label>
                                                    <input type="text" class="form-control" id="MHouseNo"
                                                           placeholder="" data-id="coResidentInfo">
                                                </div>
                                            </div>
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group">
                                                    <label for="MState" class="input-group-text"
                                                           data-field="state_id">
                                                        State
                                                    </label>
                                                    <input type="text" class="form-control typeInput" id="MState"
                                                           data-url="states"
                                                           placeholder="" data-id="coResidentInfo">
                                                </div>
                                            </div>
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group">
                                                    <label for="MCity" class="input-group-text"
                                                           data-field="city_id">
                                                        City
                                                    </label>
                                                    <input type="text" class="form-control typeInput" id="MCity"
                                                           data-url="cities"
                                                           placeholder="" data-id="coResidentInfo" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    <article id="Mother-identity-info" data-key="" data-type="id_proof">
                                        <div class="row mt10">
                                            <div class="col-md-4 padd-20">
                                                <div class="form-group">
                                                    <label class="radio-heading input-group-text" for="MIdProof"
                                                           data-field="proof_name">
                                                        ID Proof/Address Proof
                                                    </label>
                                                    <select class="form-control field-req" name="years"
                                                            id="MIdProof" data-id="coProofInfo">
                                                        <option>PAN</option>
                                                        <option>Adhaar Card</option>
                                                        <option>Passport</option>
                                                        <option>Voter ID</option>
                                                        <option>Driving License</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 padd-20">
                                                <div class="form-group">
                                                    <label for="MIdProofNo" class="input-group-text"
                                                           data-field="number">
                                                        Id Proof Number
                                                    </label>
                                                    <input type="text" class="form-control" id="MIdProofNo"
                                                           placeholder="Number" data-id="coProofInfo">
                                                </div>
                                            </div>
                                            <div class="col-md-4 padd-20">
                                                <div class="form-group text-center">
                                                    <div id="MIdProofimage">
                                                        <label for="idProofMother" class="">
                                                            <div class="idPhoto">
                                                                <i class="fa fa-cloud-upload"></i>
                                                                Upload ID Proof's Photo
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <input type="file" class="form-control idProof-input"
                                                           id="idProofMother"
                                                           placeholder="" data-id="coProofInfo">
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <div class="radio-heading input-group-text">
                                                Siblings
                                            </div>
                                            <ul class="displayInline" data-field="has_sibling">
                                                <li>
                                                    <label class="checkcontainer">Yes, I have Sibligs.
                                                        <input type="checkbox" data-id="siblingInfo"
                                                               id="sibling-avail"
                                                               onchange="ShowSibling()">
                                                        <span class="Ch-checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="siblingInformation" data-key="" data-type="co_applicant"
                                     data-relation="Sibling">
                                <div class="row mt10" id="siblingInfo">
                                    <div class="col-md-12">
                                        <p class="cd-heading-2">Sibling Information</p>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="siblingName" class="input-group-text" data-field="name">
                                                Name
                                            </label>
                                            <input type="text" class="form-control" id="siblingName"
                                                   placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="siblingDob" class="input-group-text"
                                                   data-field="co_applicant_dob">
                                                DOB
                                            </label>
                                            <input type="text" class="form-control" id="siblingDob"
                                                   placeholder="--/--/----">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="siblingOccupation" class="input-group-text"
                                                   data-field="occupation">
                                                Occupation
                                            </label>
                                            <input type="text" class="form-control" id="siblingOccupation"
                                                   placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <div class="text-center">
                                <button type="button" class="eduBtn eduBtnLight" data-id="applicantProfile"
                                        onclick="activeTab(event)">Previous
                                </button>
                                <button type="button" class="eduBtn" data-id="guarantorProfile"
                                        onclick="activeTab(event)">Next
                                </button>
                            </div>
                        </div>
                        <div class="tab" id="guarantorProfile">
                            <section id="guarantor1Information" data-key="" data-type="co_applicant"
                                     data-relation="Guarantor"
                                     data-sequence="1">
                                <div class="row mt10">
                                    <div class="col-md-12">
                                        <h4 class="cd-heading-3">Guarantor 1</h4>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G1Name" class="input-group-text" data-field="name">
                                                Name
                                            </label>
                                            <input type="text" class="form-control" id="G1Name"
                                                   placeholder="Enter Full Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G1Email" class="input-group-text" data-field="email">
                                                Email
                                            </label>
                                            <input type="text" class="form-control" id="G1Email" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G1Dob" class="input-group-text"
                                                   data-field="co_applicant_dob">
                                                DOB
                                            </label>
                                            <input type="text" class="form-control" id="G1Dob"
                                                   placeholder="--/--/----">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G1number" class="input-group-text" data-field="phone">
                                                Mobile Number
                                            </label>
                                            <input type="text" class="form-control" id="G1number" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group ">
                                            <div class="radio-heading input-group-text">
                                                Address
                                            </div>
                                            <ul class="displayInline">
                                                <li>
                                                    <label class="checkcontainer" data-field="address">Same As Applicant
                                                        <input class="same_address" type="checkbox" data-id="gAddress1"
                                                               id="g1Same"
                                                               onchange="hideAddress()">
                                                        <span class="Ch-checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="Guarantor1-other-info">
                                    <article id="Guarantor1-address-info" data-key="" data-type="address">
                                        <div class="row mt10" id="gAddress1">
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group ">
                                                    <div class="radio-heading input-group-text">
                                                        Residence Type
                                                    </div>
                                                    <ul class="displayInline residenceType" data-field="res_type"
                                                        id="Guarantor1_Resident_Info">
                                                        <li>
                                                            <label class="container-radio">Rented
                                                                <input type="radio" checked="checked" name="g1address"
                                                                       value="0"
                                                                       id="G1-rented">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="container-radio">Owned
                                                                <input type="radio" name="g1address" id="G1-owned"
                                                                       value="1">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group">
                                                    <label for="G1Address" class="input-group-text"
                                                           data-field="address">
                                                        Address
                                                    </label>
                                                    <input type="text" class="form-control" id="G1Address"
                                                           placeholder="" data-id="coResidentInfo">
                                                </div>
                                            </div>
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group">
                                                    <label for="G1state" class="input-group-text"
                                                           data-field="state_id">
                                                        State
                                                    </label>
                                                    <input type="text" class="form-control typeInput" id="G1state"
                                                           data-url="states"
                                                           placeholder="" data-id="coResidentInfo">
                                                </div>
                                            </div>
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group">
                                                    <label for="G1city" class="input-group-text"
                                                           data-field="city_id">
                                                        City
                                                    </label>
                                                    <input type="text" class="form-control typeInput" id="G1city"
                                                           data-url="cities"
                                                           placeholder="" data-id="coResidentInfo" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    <article id="Guarantor1-identity-info" data-key="" data-type="id_proof">
                                        <div class="row mt10">
                                            <div class="col-md-4 padd-20">
                                                <div class="form-group">
                                                    <label class="radio-heading input-group-text" for="G1ID"
                                                           data-field="proof_name">
                                                        ID Proof/Address Proof
                                                    </label>
                                                    <select class="form-control field-req" name="" id="G1ID"
                                                            data-id="coProofInfo">
                                                        <option>PAN</option>
                                                        <option>Adhaar Card</option>
                                                        <option>Passport</option>
                                                        <option>Voter ID</option>
                                                        <option>Driving License</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 padd-20">
                                                <div class="form-group">
                                                    <label for="G1IDnumber" class="input-group-text"
                                                           data-field="number">
                                                        Id Proof Number
                                                    </label>
                                                    <input type="text" class="form-control" id="G1IDnumber"
                                                           placeholder="Number" data-id="coProofInfo">
                                                </div>
                                            </div>
                                            <div class="col-md-4 padd-20">
                                                <div class="form-group text-center">
                                                    <div id="G1IDimage">
                                                        <label for="G1IDpic" class="">
                                                            <div class="idPhoto">
                                                                <i class="fa fa-cloud-upload"></i>
                                                                Upload ID Proof's Photo
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <input type="file" class="form-control idProof-input"
                                                           id="G1IDpic"
                                                           placeholder="" data-id="coProofInfo">
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </section>
                            <div class="FormDivider"></div>
                            <section id="guarantor2Information" data-key="" data-type="co_applicant"
                                     data-relation="Guarantor"
                                     data-sequence="2">
                                <div class="row mt10">
                                    <div class="col-md-12">
                                        <h4 class="cd-heading-3">Guarantor 2</h4>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G2name" class="input-group-text" data-field="name">
                                                Name
                                            </label>
                                            <input type="text" class="form-control" id="G2Name"
                                                   placeholder="Enter Full Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G2email" class="input-group-text" data-field="email">
                                                Email
                                            </label>
                                            <input type="text" class="form-control" id="G2Email" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G2Dob" class="input-group-text"
                                                   data-field="co_applicant_dob">
                                                DOB
                                            </label>
                                            <input type="text" class="form-control" id="G2Dob"
                                                   placeholder="--/--/----">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G2number" class="input-group-text" data-field="phone">
                                                Mobile Number
                                            </label>
                                            <input type="text" class="form-control" id="G2number" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group ">
                                            <div class="radio-heading input-group-text" data-field="address">
                                                Address
                                            </div>
                                            <ul class="displayInline">
                                                <li>
                                                    <label class="checkcontainer" data-field="address">Same As Applicant
                                                        <input class="same_address" type="checkbox" data-id="gAddress2"
                                                               id="g2Same"
                                                               onchange="hideAddress()">
                                                        <span class="Ch-checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="Guarantor2-other-info">
                                    <article id="Guarantor2-address-info" data-key="" data-type="address">
                                        <div class="row mt10" id="gAddress2">
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group ">
                                                    <div class="radio-heading input-group-text">
                                                        Residence Type
                                                    </div>
                                                    <ul class="displayInline residenceType" data-field="res_type"
                                                        id="Guarantor2_Resident_Info">
                                                        <li>
                                                            <label class="container-radio">Rented
                                                                <input type="radio" checked="checked" value="0"
                                                                       name="g2address">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="container-radio">Owned
                                                                <input type="radio" name="g2address" value="1">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group">
                                                    <label for="G2Address" class="input-group-text"
                                                           data-field="address">
                                                        Address
                                                    </label>
                                                    <input type="text" class="form-control" id="G2Address"
                                                           placeholder="" data-id="coResidentInfo">
                                                </div>
                                            </div>
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group">
                                                    <label for="G2state" class="input-group-text"
                                                           data-field="state_id">
                                                        State
                                                    </label>
                                                    <input type="text" class="form-control typeInput" id="G2state"
                                                           data-url="states"
                                                           placeholder="" data-id="coResidentInfo">
                                                </div>
                                            </div>
                                            <div class="col-md-3 padd-20">
                                                <div class="form-group">
                                                    <label for="G2city" class="input-group-text"
                                                           data-field="city_id">
                                                        City
                                                    </label>
                                                    <input type="text" class="form-control typeInput" id="G2city"
                                                           data-url="cities"
                                                           placeholder="" data-id="coResidentInfo" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    <article id="Guarantor2-identity-info" data-key="" data-type="id_proof">
                                        <div class="row mt10">
                                            <div class="col-md-4 padd-20">
                                                <div class="form-group">
                                                    <label class="radio-heading input-group-text" for="G2ID"
                                                           data-field="proof_name">
                                                        ID Proof/Address Proof
                                                    </label>
                                                    <select class="form-control field-req" name="years" id="G2ID"
                                                            data-id="coProofInfo">
                                                        <option>PAN</option>
                                                        <option>Adhaar Card</option>
                                                        <option>Passport</option>
                                                        <option>Voter ID</option>
                                                        <option>Driving License</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 padd-20">
                                                <div class="form-group">
                                                    <label for="G2IDnumber" class="input-group-text"
                                                           data-field="number">
                                                        Id Proof Number
                                                    </label>
                                                    <input type="text" class="form-control" id="G2IDnumber"
                                                           placeholder="Number" data-id="coProofInfo">
                                                </div>
                                            </div>
                                            <div class="col-md-4 padd-20">
                                                <div class="form-group text-center">
                                                    <div id="G2IDimage">
                                                        <label for="G2IDpic" class="">
                                                            <div class="idPhoto">
                                                                <i class="fa fa-cloud-upload"></i>
                                                                Upload ID Proof's Photo
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <input type="file" class="form-control idProof-input"
                                                           id="G2IDpic"
                                                           placeholder="" data-id="coProofInfo">
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </section>
                            <div class="text-center">
                                <button type="button" class="eduBtn eduBtnLight" data-id="parentsProfile"
                                        onclick="activeTab(event)">Previous
                                </button>
                                <button type="button" class="eduBtn" onclick="">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.posRel{
    position:relative;
}
.searchNameList {
    position: absolute !important;
    border: 1px solid #c2cad8;
    border-top: none;
    max-height: 200px;
    width: 100%;
    z-index: 999;
    background: #fff;
    box-shadow: 0 7px 10px rgba(0,0,0,.1);
//    display: none;
    overflow-y: scroll;
    padding-inline-start: 0px;
}
.searchNameList li {
    padding: 6px 12px;
    background: #fff;
    border-bottom: 1px solid #c2cad8;
    cursor: pointer;
    list-style-type: none;
}
.search-names:hover {
    background: #00a0e3;
    color: #fff;
}
.activeLi{
    color: #00a0e3 !important;
}
#siblingInfo{
    display: none;
}
.mt10{
    margin-top: 10px;
}
.mt20{
    margin-top: 20px;
}
.boder-left-1{
    border-right:1px solid #eee; 
}
.cd-heading{
    font-size: 18px;
    font-weight: bold;
    color: #000;
}
.cd-heading-3{
    font-size: 16px;
    font-weight: bold;
    color: #00a0e3;
}
.uploadPic{
    height: 80px;
    width: 80px;
    border-radius: 50%;
    border: 1px solid #eee;
    display: flex;
    align-items:center;
    justify-content: center;
    margin-top: 20px;
}
#yourPic, #idProof, .idProof-input{
    display: none !important;
}
.disFlex{
    display: flex;
    align-items: center;
}
.uploadPic i{
    font-size: 30px;
    color: #00a0e3;
}
.ml20{
    margin-left: 10px; 
    font-weight: bold;
}
.idPhoto{
    display: flex;
    align-items: center;
    background: #00a0e3;
    color: #fff;
    font-weight: normal;
    padding: 5px 10px;
    margin-top: 33px;
}
.idPhoto i{
    font-size: 18px; 
    margin-right: 10px;
}
.eduBtn{
    
    background: #00a0e3;
    color: #fff;
    border: 1px solid #00a0e3;
    padding: 5px 15px;
    font-size: 16px;
    margin: 15px auto;
}
.eduBtnLight{
    background: #eee;
    color: #00a0e3;
    border: 1px solid #eee;
 
}
.eduBtn2{
    background: transparent;
    color: #00a0e3;
    border: none;
    padding: 0;
    font-size: 16px;
    margin: 5px auto;
    text-transform: uppercase;
}
.eduBtn:hover{
    background: #fff;
    color: #00a0e3;
}
.font-dark > span > i {
    font-size: 13px;
    margin-left: 5px;
    color: darkgray;
}
.input-group-text {
    font-weight: bold;
    font-family: lora;
    color: #000;
    font-size: 15px;
}
.form-control {
    border-radius: 0;
    box-shadow: none;
    height: 45px;
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
    top: 0px;
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
.displayInline{
    padding-inline-start: 0px;
}
.displayInline li {
    display: inline-block;
    padding-right: 20px;
    margin-top: 5px;
}
.FormDivider{
  height: 1px;
  background: #eee;
  max-width: 100%;
  margin: 20px auto; 
}
.cd-heading{
    font-weight: bold;
    font-family: roboto;
    color: #00a0e3;
    text-transform: uppercase;
}
/*chcekbox*/
.checkcontainer {
    display: block;
    position: relative;
    padding-left: 28px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 16px;
    font-family: roboto;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser\'s default checkbox */
.checkcontainer input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.Ch-checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 22px;
  width: 22px;
  background-color: transparent;
  border: 1px solid #c2cad8;
}

/* On mouse-over, add a grey background color */
.checkcontainer:hover input ~ .Ch-checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.checkcontainer input:checked ~ .Ch-checkmark {
  background-color: #2196F3;
  border: 1px solid #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.Ch-checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.checkcontainer input:checked ~ .Ch-checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.checkcontainer .Ch-checkmark:after {
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
.tab {
  display: none;
}
.tabActive{
    display: block;
}
.cd-heading-2{
    font-size: 18px;
    font-weight: bold;
    color: #333;
    font-family: lora;
    margin-bottom: 0px;
    margin-top: 5px;
}
.formNav{
    padding-inline-start: 0px;
}
.formNav li{
    display: inline;
    list-style-type: none;
}
.formNav li button{
    background: transparent;
    font-size: 18px;
    color: #666;
    border: none;
    
}
.process_icon{
    position: absolute;
    top: 50%;
    right: 24px;
    color: #00a0e3;
    font-size: 18px;
}
.done_icon{
    position: absolute;
    top: 50%;
    right: 24px;
    color: #07ad23;
    font-size: 18px;
}
.error_icon{
    position: absolute;
    top: 50%;
    right: 24px;
    color: #f4d03f;
    font-size: 18px;
}
#Father-other-info, #Mother-other-info, #Guarantor1-other-info, #Guarantor2-other-info{
    display:none;
}
');
$script = <<<JS
function showImage(input, inp_id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var img = $('#'+inp_id).find('img');
            if(img.length){
                img.attr('src',e.target.result);
            } else {
                $('#'+inp_id).find('label').html('<img src="'+e.target.result+'" height="50px" width="50px">')
            }
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(document).on('click','.search-names', function() {
    var ths = $(this);
    var key = ths.attr('id');
    var ul = ths.parent();
    var input = ul.parent().find('input.typeInput');
    var value = ths.text();
    // input.val(key)
    input.val(value);
    value = ths.attr('id');
    ul.remove();
    updateValue(input, value);
})

$(document).on('change','.same_address', function() {
    var elem = $(this);
    var value = (elem.is(":checked"))?1:0;
    updateValue(elem, value);
});
$(document).on('change','.residenceType', function() {
    var elem = $(this);
    var checkedBtn = elem.find('input:checked');
    var addrInput = elem.parent().parent().next().find('input');
    if(addrInput.val()){
        addrInput.focusin();
        addrInput.focusout();
    }
    return false;
    var ths = $(this);
    var key = ths.attr('id');
    var ul = ths.parent();
    var input = ul.parent().find('input.typeInput');
    var value = ths.text();
    // input.val(key)
    input.val(value);
    value = ths.attr('id');
    ul.remove();
    updateValue(input, value);
})

$(document).on('keyup','.typeInput', function() {
    var elem = $(this);
    var q = elem.val();
    var url = elem.attr('data-url');
    switch (url) {
        case 'states' :
            url = 'https://ravinder.eygb.me/api/v3/education-loan/get-'+url+'?search='+ q; 
            break;
        case 'cities' :
            var state_id = elem.attr('data-state-id');
            url = 'https://ravinder.eygb.me/api/v3/education-loan/get-'+url+'?search='+ q + '&state_id=' + state_id; 
            break;
        default :
            return false;
    }
    $.ajax({
        url: url,
        method: 'GET',
        beforeSend: function(){
            if($('#searchNameList').length == 0){
                $('<ul class="searchNameList" id="searchNameList"><li id="">Loading...</li></ul>').insertAfter(elem);  
            }
        },
        success: function(res) {
            var list = "";
            $.each(res, function(i,v) {
                if(v.state_enc_id){
                    list += '<li class="search-names" id="'+v.state_enc_id+'">'+v.name+'</li>';
                } else {
                    list += '<li class="search-names" id="'+v.city_enc_id+'">'+v.name+'</li>';
                }
            });
            $('#searchNameList').html(list);
        }
    });
});

$(document).on('blur','input:text', function() {
    var elem = $(this);
    var value = elem.val();
    if(!elem.hasClass('typeInput')){
        updateValue(elem, value);
    }
});

function updateValue(elem, value){
    var data = {};
    var label_name = "";
    if(elem.hasClass('same_address')){
        label_name = elem.closest('label').attr('data-field');
    } else {
        label_name = elem.prev('label').attr('data-field');
    }
    if(label_name == "number"){
        var docChilds = elem.closest('.row').children().children();
        var docFieldName = docChilds.children('label').attr('data-field');
        var docName = docChilds.children('select').val();
        data[docFieldName]= docName;
    }
    var section = elem.closest('section');
    var key = section.attr('data-key');
    var sequence = section.attr('data-sequence');
    var type = section.attr('data-type');
    var relation = section.attr('data-relation');
    var co_app_other_info = elem.attr('data-id');
    var mainSection = section;
    if(typeof co_app_other_info !== "undefined" && !elem.hasClass('same_address')){
        var articalTag = elem.closest('article');
        type = articalTag.attr('data-type');
        data['loan_co_app_id'] = key;
        key = articalTag.attr('data-key');
        mainSection = articalTag;
    }
    if(typeof relation !== "undefined"){
        data['relation'] = relation;
    }
    if(key != ""){
        data['id'] = key;
    }
    var address_type = "";
    if(type == 'address'){
        data['res_type'] = elem.parent().parent().prev().find('input:checked').val();
        address_type = section.attr('data-address-type');
    }
    if(type != ""){
        data['type'] = type;
    }
    if(address_type != ""){
        data['address_type'] = address_type;
    }
    data[label_name] = value;
    data['user_enc_id'] = user_enc_id;
    data['loan_app_id'] = loan_app_id;
    // console.log("key = "+key +" type= "+ type +" relation = "+ relation +" value = "+ value + " res type = " + address_type);
    if(value != "" || key != ""){
        $.ajax({
            url: 'https://ravinder.eygb.me/api/v3/education-loan/loan-second-form',
            method: 'POST',
            data: data,
            beforeSend:function(){
                removeIcons();
                $('<i class="fa fa-spinner fa-spin process_icon"></i>').insertAfter(elem);
            },
            success: function(res) {
                removeIcons();
                if(res.response.status == 200){
                    $('<i class="fa fa-check done_icon"></i>').insertAfter(elem);
                    mainSection.attr('data-key', res.response.id);
                    if(data['type'] == 'co_applicant'){
                        if(data['relation'] == 'Father'){
                            $('#Father-other-info').show();
                        }
                        if(data['relation'] == 'Mother'){
                            $('#Mother-other-info').show();
                        }
                        if(data['relation'] == 'Guarantor'){
                            $('#Guarantor'+sequence+'-other-info').show();
                        }
                    }
                } else {
                    $('<i class="fa fa-exclamation-triangle error_icon"></i>').insertAfter(elem);
                }
                if(elem.hasClass('typeInput') && elem.attr('data-url') == 'states'){
                    var cityElem = elem.parent().parent().next().find('input');
                    cityElem.attr('disabled',false);
                    cityElem.attr('data-state-id',value);
                    cityElem.val("");
                }
            }
        });
    }
}
$(document).ready(function() {
    var data = "";
    var guarantorCount = 0;
    $.ajax({
        url: 'https://ravinder.eygb.me/api/v3/education-loan/get-loan',
        method: 'POST',
        data:{loan_app_enc_id:loan_app_id},
        success: function(res) {
            res = res.response;
            if(res.status == 200){
                data = res.data;
                $('#applicantBasicInformation').attr('data-key',data.loan_app_enc_id);
                $('#applicantImage').html('<img height="50px" width="50px" src="'+ data.image +'" />');
                $('#applicantName').val(data.applicant_name);
                $('#applicantEmail').val(data.email);
                $('#applicantDob').val(data.applicant_dob);
                $('#applicantNumber').val(data.phone);
                $('#degreeApplied').val(data.degree);
                $('#courseApplied').val(data.course_name);
                var residentials = data.loanApplicantResidentialInfos;
                var cur_addr = "";
                var per_addr = "";
                $.each(residentials, function(i, v) {
                    if(i < 2){
                        switch (v.residential_type) {
                            case "0":
                                per_addr = data.loanApplicantResidentialInfos[i];
                            break;
                            case "1":
                                cur_addr = data.loanApplicantResidentialInfos[i];
                            break;
                            default:
                        }
                    }
                });
                if(per_addr != ""){
                    $('#permanentAddressInformation').attr('data-key',per_addr.loan_app_res_info_enc_id);
                    $('#houseNo').val(per_addr.address);
                    if(per_addr.state_name){
                        $('#PA-state').val(per_addr.state_name);
                        $('#PA-city').attr('data-state-id',per_addr.state_enc_id);
                        $('#PA-city').attr('disabled',false);
                    }
                    $('#PA-city').val(per_addr.city_name);
                    if(per_addr.type){
                        $('#per_res_type').find('input:radio').each(function(){
                            if($(this).val() == per_addr.type){
                                $(this).prop("checked",true);
                            }
                        });
                    }
                }
                if(cur_addr != ""){
                    $('#currentAddressInformation').attr('data-key',cur_addr.loan_app_res_info_enc_id);
                    $('#CA-houseNo').val(cur_addr.address);
                    if(cur_addr.state_name){
                        $('#CA-state').val(cur_addr.state_name);
                        $('#CA-city').attr('data-state-id',cur_addr.state_enc_id);
                        $('#CA-city').attr('disabled',false);
                    }
                    $('#CA-city').val(cur_addr.city_name);
                    if(cur_addr.type){
                        $('#cur_res_type').find('input:radio').each(function(){
                            if($(this).val() == cur_addr.type){
                                $(this).prop("checked",true);
                            }
                        });
                    }
                }
                var loanCertificates = data.loanCertificates;
                $.each(loanCertificates,function(i, v) {
                    $('#idProofInformation' + i).attr('data-key',v.certificate_enc_id);
                    $('#applicantID' + i).val(v.name);
                    $('#applicantIDnumber' + i).val(v.number);
                    if(v.image){
                        $('#applicantIDimage' + i).children('label').html('<img height="50px" width="50px" src="'+v.image+'" />');;
                    }
                });
                var qualifications = data.loanCandidateEducations;
                $.each(qualifications, function(i, v) {
                    if(i > 1){
                        $('#addEduBtn').click();
                    }
                    $('#qualificationInformation' + i).attr('data-key',v.loan_candidate_edu_enc_id);
                    $('#eduName' + i).val(v.name);
                    $('#instituteName' + i).val(v.institution);
                    $('#marksObtained' + i).val(v.obtained_marks);
                });
                $.each(data.loanCoApplicants, function(k,v) {
                    var residenceInfo = v.loanApplicantResidentialInfos[0];
                    if(typeof residenceInfo === "undefined"){
                        residenceInfo = {};
                    }
                    var coAppLoanCertificate = v.loanCertificates[0];
                    if(typeof coAppLoanCertificate === "undefined"){
                        coAppLoanCertificate = {};
                    }
                    switch (v.relation) {
                        case 'Father' :
                            $('#fatherInformation').attr('data-key',v.loan_co_app_enc_id);
                            $('#'+ v.relation +'-other-info').show();
                            if(v.image){
                                $('#fatherImage').children('label').html('<img height="50px" width="50px" src="'+v.image+'" />');
                            }
                            $('#fatherName').val(v.name);
                            $('#fatherEmail').val(v.email);
                            $('#fatherNumber').val(v.phone);
                            $('#dob').val(v.co_applicant_dob);
                            $('#yearsOFoccu').val(v.years_in_current_house);
                            $('#fOccupation').val(v.occupation);
                            $('#fIncome').val(v.annual_income);
                            if(v.address == 1){
                                $('#fSame').prop('checked',true);
                                $('#fAddress').hide();
                            }
                            $('#Father-address-info').attr('data-key', residenceInfo.loan_app_res_info_enc_id);
                            $('#fHouseNo').val(residenceInfo.address);
                            $('#Father-identity-info').attr('data-key', coAppLoanCertificate.certificate_enc_id);
                            $('#fIDproof').val(coAppLoanCertificate.name);
                            $('#fIDproofnumber').val(coAppLoanCertificate.number);
                            if(coAppLoanCertificate.image){
                                $('#fIDproofimage').children('label').html('<img height="50px" width="50px" src="'+coAppLoanCertificate.image+'" />');;
                            }
                            if(residenceInfo.type){
                                $('#Father_Resident_Info').find('input:radio').each(function(){
                                    if($(this).val() == residenceInfo.type){
                                        $(this).prop("checked",true);
                                    }
                                });
                            }
                            if(residenceInfo.state_name){
                                $('#fState').val(residenceInfo.state_name);
                                $('#fCity').attr('data-state-id',residenceInfo.state_enc_id);
                                $('#fCity').attr('disabled',false);
                            }
                            $('#fCity').val(residenceInfo.city_name);
                            break;
                        case 'Mother' :
                            $('#motherInformation').attr('data-key',v.loan_co_app_enc_id);
                            $('#'+ v.relation +'-other-info').show();
                            $('#MName').val(v.name);
                            if(v.image){
                                $('#motherImage').children('label').html('<img height="50px" width="50px" src="'+v.image+'" />');
                            }
                            $('#ME.mail').val(v.email);
                            $('#M-mobile').val(v.phone);
                            $('#MDob').val(v.co_applicant_dob);
                            $('#mOccupation').val(v.occupation);
                            $('#familyIncome').val(v.annual_income);
                            if(v.address == 1){
                                $('#mSame').prop('checked',true);
                                $('#mAddress').hide();
                            }
                            $('#Mother-address-info').attr('data-key', residenceInfo.loan_app_res_info_enc_id);
                            $('#MHouseNo').val(residenceInfo.address);
                            $('#Mother-identity-info').attr('data-key', coAppLoanCertificate.certificate_enc_id);
                            $('#MIdProof').val(coAppLoanCertificate.name);
                            $('#MIdProofNo').val(coAppLoanCertificate.number);
                            if(coAppLoanCertificate.image){
                                $('#MIdProofimage').children('label').html('<img height="50px" width="50px" src="'+coAppLoanCertificate.image+'" />');;
                            }
                            if(residenceInfo.type){
                                $('#Mother_Resident_Info').find('input:radio').each(function(){
                                    if($(this).val() == residenceInfo.type){
                                        $(this).prop("checked",true);
                                    }
                                });
                            }
                            if(residenceInfo.state_name){
                                $('#MState').val(residenceInfo.state_name);
                                $('#MCity').attr('data-state-id',residenceInfo.state_enc_id);
                                $('#MCity').attr('disabled',false);
                            }
                            $('#MCity').val(residenceInfo.city_name);
                            break;
                        case 'Sibling' :
                            $('#sibling-avail').prop('checked',true);
                            $('#siblingInfo').show();
                            $('#siblingInformation').attr('data-key',v.loan_co_app_enc_id);
                            $('#siblingName').val(v.name);
                            $('#siblingDob').val(v.co_applicant_dob);
                            $('#siblingOccupation').val();
                            break;
                        case 'Guarantor' :
                            guarantorCount++;
                            if(guarantorCount <= 2){
                                $('#guarantor'+guarantorCount+'Information').attr('data-key',v.loan_co_app_enc_id);
                                $('#'+ v.relation + guarantorCount +'-other-info').show();
                                $('#G'+guarantorCount+'Name').val(v.name);
                                $('#G'+guarantorCount+'Email').val(v.email);
                                $('#G'+guarantorCount+'Dob').val(v.co_applicant_dob);
                                $('#G'+guarantorCount+'number').val(v.phone);
                                if(v.address == 1){
                                    $('#g'+guarantorCount+'Same').prop('checked',true);
                                    $('#gAddress'+guarantorCount).hide();
                                }
                                $('#Guarantor'+guarantorCount+'-address-info').attr('data-key', residenceInfo.loan_app_res_info_enc_id);
                                $('#G'+guarantorCount+'Address').val(residenceInfo.address);
                                $('#Guarantor'+guarantorCount+'-identity-info').attr('data-key', coAppLoanCertificate.certificate_enc_id);
                                $('#G'+guarantorCount+'ID').val(coAppLoanCertificate.name);
                                $('#G'+guarantorCount+'IDnumber').val(coAppLoanCertificate.number);
                                if(coAppLoanCertificate.image){
                                    $('#G'+guarantorCount+'IDimage').children('label').html('<img height="50px" width="50px" src="'+coAppLoanCertificate.image+'" />');
                                }
                                if(residenceInfo.type){
                                    $('#Guarantor'+guarantorCount+'_Resident_Info').find('input:radio').each(function(){
                                        if($(this).val() == residenceInfo.type){
                                            $(this).prop("checked",true);
                                        }
                                    });
                                }
                                if(residenceInfo.state_name){
                                    $('#g'+guarantorCount+'state').val(residenceInfo.state_name);
                                    $('#g'+guarantorCount+'city').attr('data-state-id',residenceInfo.state_enc_id);
                                    $('#g'+guarantorCount+'city').attr('disabled',false);
                                }
                                $('#g'+guarantorCount+'city').val(residenceInfo.city_name);
                            }
                            break;
                        default:
                    }
                });
            }
        }
    });
});

 $(document).on('change','input:file', function(e) {
     var elem = $(this);
     var files = e.target.files;
     if(files.length){
         var formData = new FormData();
         formData.append("image", files[0]);
         // for(var i=0; i<files.length; i++){
             // console.log(files[i]);
             // formData.append("files[" + i + "]", files[i]);   
         // }
         var section = elem.closest('section');
         var key = section.attr('data-key');
         var type = section.attr('data-type');
         formData.append("upload_file", 'test');
         formData.append("user_enc_id", user_enc_id);
         formData.append("loan_app_id", loan_app_id);
        
         var co_app_other_info = elem.attr('data-id');
         var mainSection = section;
         if(typeof co_app_other_info !== "undefined"){
             var articalTag = elem.closest('article');
             type = articalTag.attr('data-type');
             formData.append("loan_co_app_id", key);
             key = articalTag.attr('data-key');
             mainSection = articalTag;
         }
        
         if(type){
             formData.append("type", type);
         }
         if(key){
             formData.append("id", key);
         }
        
         // var formm = elem.closest('form');
         var section = elem.closest('section');
         // console.log(key +" "+ type);
         // var formData = new FormData();
         // console.log(formm);
         $.ajax({
             url: 'https://ravinder.eygb.me/api/v3/education-loan/upload-image',
             method: 'POST',
             data: formData,
             processData: false,
             contentType: false,
             beforeSend:function(){
                removeIcons();
                $('<i class="fa fa-spinner fa-spin process_icon"></i>').insertAfter(elem);
            },
             success: function(res) {
                removeIcons();
                 if(res.response.status == 200){
                     var inp_id = elem.prev().attr('id');
                     showImage(elem[0], inp_id);
                     $('<i class="fa fa-check done_icon"></i>').insertAfter(elem);
                 } else {
                     $('<i class="fa fa-exclamation-triangle error_icon"></i>').insertAfter(elem);
                 }
             }
         });
     }
 });
 function removeIcons() {
    $('.process_icon').remove();
    $('.done_icon').remove();
    $('.error_icon').remove();
 }
JS;
$this->registerJS($script);
?>
<script>
    function eduTemp(edu_count) {
        return '<div class="row mt10"> <div class="col-md-4 padd-20"><div class="form-group"><label for="eduName' + edu_count + '" class="input-group-text" data-field="name">Qualification </label><input type="text" class="form-control" id="eduName' + edu_count + '" placeholder="Degree Name"></div></div><div class="col-md-4 padd-20"><div class="form-group"><label for="instituteName' + edu_count + '" class="input-group-text" data-field="institution">Name Of Institution</label><input type="text" class="form-control" id="instituteName' + edu_count + '" placeholder=""></div></div><div class="col-md-4 padd-20"><div class="form-group"><label for="marksObtained' + edu_count + '" class="input-group-text" data-field="obtained_marks">Marks Obtained</label><input type="text" class="form-control" id="marksObtained' + edu_count + '" placeholder=""></div></div></div>';
    }

    function addEduField(ths) {
        let count = ths.getAttribute('data-count');
        let eduFields = document.getElementById('eduFields');
        let newFields = document.createElement('section');
        newFields.setAttribute('id', 'qualificationInformation' + count);
        newFields.setAttribute('data-key', '');
        newFields.setAttribute('data-type', 'qualification');
        newFields.innerHTML = eduTemp(count);
        eduFields.appendChild(newFields)
        count++;
        ths.setAttribute('data-count', count);
    }

    function hideAddress() {
        let clickedElem = event.currentTarget;
        let addressCheck = event.currentTarget.getAttribute('data-id')
        let elemHide = document.getElementById(addressCheck);

        if (clickedElem.checked == true) {
            elemHide.style.display = 'none';
        } else {
            elemHide.style.display = 'block';
        }
    }

    function ShowSibling() {
        let clickedElem = event.currentTarget;
        let addressCheck = event.currentTarget.getAttribute('data-id')
        let elemHide = document.getElementById(addressCheck);
        if (clickedElem.checked == true) {
            elemHide.style.display = 'block';
        } else {
            elemHide.style.display = 'none';
        }
    }
</script>

<script>

    function activeTab(event) {
        let tabs = document.getElementsByClassName('tabActive');
        for (var i = 0; i < tabs.length; i++) {
            tabs[i].classList.remove('tabActive');
        }
        let activeLi = document.getElementsByClassName('activeLi');
        for (var j = 0; j < activeLi.length; i++) {
            activeLi[j].classList.remove('activeLi');
        }

        let activeID = event.currentTarget.getAttribute('data-id');
        console.log(activeID)
        let activeTab = document.getElementById(activeID);
        activeTab.classList.add('tabActive');
        let selectedTp = document.querySelector('[data-id="' + activeID + '"]');
        selectedTp.classList.add('activeLi');
        window.scrollTo(0, 0);
    }

</script>
