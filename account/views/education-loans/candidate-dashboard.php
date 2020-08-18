<?php
    use yii\helpers\Url;
?>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light nd-shadow">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Loan Profile<span data-toggle="tooltip" title="" data-original-title="Here you will find all companies that you are following">
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
                            <li><button data-id="applicantProfile" class="topTab activeLi" onclick="activeTab(event)">Applicant Profile</button></li> /
                            <li><button data-id="parentsProfile" class="topTab" onclick="activeTab(event)">Parents Profile</button></li> /
                            <li><button data-id="guarantorProfile" class="topTab" onclick="activeTab(event)">Guarantor's Profile</button></li>
                        </ul>
                        <form id="regForm">
                            <div class="tab tabActive" id="applicantProfile">
<!--                                <div class="row">-->
<!--                                    <div class="col-md-12">-->
<!--                                        <h4 class="cd-heading">Applicant Profile</h4>-->
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 padd-20">
                                        <div class="form-group disFlex">
                                            <label for="yourPic" class="input-group-text">
                                               <div class="uploadPic">
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
                                            <input type="text" class="form-control" id="applicantName" placeholder="Enter Full Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="form-group">
                                            <label for="applicantEmail" class="input-group-text">
                                                Email
                                            </label>
                                            <input type="text" class="form-control" id="applicantEmail" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="form-group">
                                            <label for="applicantDob" class="input-group-text">
                                                DOB
                                            </label>
                                            <input type="text" class="form-control" id="applicantDob" placeholder="--/--/----">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="form-group">
                                            <label for="applicantNumber" class="input-group-text">
                                                Mobile Number
                                            </label>
                                            <input type="text" class="form-control" id="applicantNumber" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label class="radio-heading input-group-text" for="degreeApplied">
                                                Degree Applied
                                            </label>
                                            <select class="form-control field-req"  name="years" id="degreeApplied">
                                                <option value="1">Under Graduation</option>
                                                <option value="2">Graduation</option>
                                                <option value="3">Post Graduation</option>
                                                <option value="4">Integrated</option>
                                                <option value="5">Diploma</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="courseApplied" class="input-group-text">
                                                Course Applied
                                            </label>
                                            <input type="text" class="form-control" id="courseApplied" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-12">
                                        <p class="cd-heading-2">2 ID or Residential Proofs Required</p>
                                    </div>
                                    <div class="col-md-6 boder-left-1">
                                        <div class="row mt10">
                                            <div class="col-md-6 padd-20">
                                                <div class="form-group">
                                                    <label class="radio-heading input-group-text" for="applicantID">
                                                        ID Proof/Address Proof
                                                    </label>
                                                    <select class="form-control field-req" name="years" id="applicantID">
                                                        <option value="1">PAN</option>
                                                        <option value="2">Adhaar Card</option>
                                                        <option value="3">Passport</option>
                                                        <option value="4">Voter ID</option>
                                                        <option value="5">Driving License</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 padd-20">
                                                <div class="form-group">
                                                    <label for="applicantIDnumber" class="input-group-text">
                                                        Id Proof Number
                                                    </label>
                                                    <input type="text" class="form-control" id="applicantIDnumber" placeholder="Number">
                                                </div>
                                            </div>
                                            <div class="col-md-12 padd-20 text-center">
                                                <div class="form-group">
                                                    <label for="applicantIDpic" class="">
                                                        <div class="idPhoto">
                                                            <i class="fa fa-cloud-upload"></i>
                                                            Upload Photo
                                                        </div>
                                                    </label>
                                                    <input type="file" class="form-control idProof-input" id="applicantIDpic" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mt10">
                                            <div class="col-md-6 padd-20">
                                                <div class="form-group">
                                                    <label class="radio-heading input-group-text" for="applicantIDtwo">
                                                        ID Proof/Address Proof
                                                    </label>
                                                    <select class="form-control field-req" name="years" id="applicantIDtwo">
                                                        <option value="1">PAN</option>
                                                        <option value="2">Adhaar Card</option>
                                                        <option value="3">Passport</option>
                                                        <option value="4">Voter ID</option>
                                                        <option value="5">Driving License</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 padd-20">
                                                <div class="form-group">
                                                    <label for="applicantIDTwoNum" class="input-group-text">
                                                        Id Proof Number
                                                    </label>
                                                    <input type="text" class="form-control" id="applicantIDTwoNum" placeholder="Number">
                                                </div>
                                            </div>
                                            <div class="col-md-12 padd-20 text-center">
                                                <div class="form-group">
                                                    <label for="applicantIDTwoPic" class="">
                                                        <div class="idPhoto">
                                                            <i class="fa fa-cloud-upload"></i>
                                                            Upload Photo
                                                        </div>
                                                    </label>
                                                    <input type="file" class="form-control idProof-input" id="applicantIDTwoPic" placeholder="">
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
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group ">
                                            <div class="radio-heading input-group-text">
                                                Permanent Address
                                            </div>
                                            <ul class="displayInline">
                                                <li>
                                                    <label class="container-radio">Rented
                                                        <input type="radio" checked="checked" id="PA-rented" name="address1">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="container-radio">Owned
                                                        <input type="radio" name="address1" id="PA-owned">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="houseNo" class="input-group-text">
                                                Address
                                            </label>
                                            <input type="text" class="form-control" id="houseNo" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="PA-city" class="input-group-text">
                                                City
                                            </label>
                                            <input type="text" class="form-control" id="PA-city" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="PA-state" class="input-group-text">
                                                State
                                            </label>
                                            <input type="text" class="form-control" id="PA-state" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group ">
                                            <div class="radio-heading input-group-text">
                                                Current Address
                                            </div>
                                            <ul class="displayInline">
                                                <li>
                                                    <label class="container-radio">Rented
                                                        <input type="radio" checked="checked" name="address2" id="CA-rented">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="container-radio">Owned
                                                        <input type="radio" name="address2" id="CA-owned">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label class="input-group-text" for="CA-houseNo">
                                                Address
                                            </label>
                                            <input type="text" class="form-control" id="CA-houseNo" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="CA-city" class="input-group-text">
                                                City
                                            </label>
                                            <input type="text" class="form-control" id="CA-city" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="CA-state" class="input-group-text">
                                                State
                                            </label>
                                            <input type="text" class="form-control" id="CA-state" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="FormDivider"></div>
                                <div class="row mt10">
                                    <div class="col-md-12">
                                        <h4 class="cd-heading-3">Education</h4>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="class10" class="input-group-text">
                                                Qualification
                                            </label>
                                            <input type="text" class="form-control" id="class10" placeholder="10th" value="10th">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="instituteName" class="input-group-text">
                                                Name Of Institution
                                            </label>
                                            <input type="text" class="form-control" id="instituteName" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="10thmarksObtained" class="input-group-text">
                                                Marks Obtained
                                            </label>
                                            <input type="text" class="form-control" id="10thmarksObtained" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="class12" class="input-group-text">
                                                Qualification
                                            </label>
                                            <input type="text" class="form-control" id="class12" placeholder="+2" value="+2">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="class12Institution" class="input-group-text">
                                                Name Of Institution
                                            </label>
                                            <input type="text" class="form-control" id="class12Institution" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="class12marks" class="input-group-text">
                                                Marks Obtained
                                            </label>
                                            <input type="text" class="form-control" id="class12marks" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div id="eduFields">

                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="button" class="eduBtn2" onclick="addEduField()">Add More</button>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="eduBtn" data-id="parentsProfile" onclick="activeTab(event)">Next</button>
                                </div>
                            </div>
                            <div class="tab" id="parentsProfile">
<!--                                <div class="row">-->
<!--                                    <div class="col-md-12">-->
<!--                                        <h4 class="cd-heading">Parents Profile</h4>-->
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="row mt10">
                                    <div class="col-md-12">
                                        <h4 class="cd-heading-3">Father's Information</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 padd-20">
                                        <div class="form-group disFlex">
                                            <label for="fatherPic" class="input-group-text">
                                                <div class="uploadPic">
                                                    <i class="fa fa-cloud-upload"></i>
                                                </div>
                                            </label>
                                            <div class="ml20"> Upload Photo</div>
                                            <input type="file" class="form-control pic idProof-input" id="fatherPic" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="fatherName" class="input-group-text">
                                                Name
                                            </label>
                                            <input type="text" class="form-control" id="fatherName" placeholder="Enter Full Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="fatherEmail" class="input-group-text">
                                                Email
                                            </label>
                                            <input type="text" class="form-control" id="fatherEmail" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="fatherDob" class="input-group-text">
                                                DOB
                                            </label>
                                            <input type="text" class="form-control" id="dob" placeholder="--/--/----">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="fatherNumber" class="input-group-text">
                                                Mobile Number
                                            </label>
                                            <input type="text" class="form-control" id="fatherNumber" placeholder="">
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
                                                    <label class="checkcontainer">Same As Above
                                                        <input type="checkbox" data-id="fAddress" id="fSame" onchange="hideAddress()">
                                                        <span class="Ch-checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10" id="fAddress">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group ">
                                            <div class="radio-heading input-group-text">
                                                Residence Type
                                            </div>
                                            <ul class="displayInline">
                                                <li>
                                                    <label class="container-radio">Rented
                                                        <input type="radio" checked="checked" name="FRT-rented" id="FRT-rented">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="container-radio">Owned
                                                        <input type="radio" name="address1" id="FRT-owned">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="fHouseNo" class="input-group-text">
                                                Address
                                            </label>
                                            <input type="text" class="form-control" id="fHouseNo" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="fCity" class="input-group-text">
                                                City
                                            </label>
                                            <input type="text" class="form-control" id="fCity" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="fState" class="input-group-text">
                                                State
                                            </label>
                                            <input type="text" class="form-control" id="fState" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label class="radio-heading input-group-text" for="fIDproof">
                                                ID Proof/Address Proof
                                            </label>
                                            <select class="form-control field-req" name="years" id="fIDproof">
                                                <option value="1">PAN</option>
                                                <option value="2">Adhaar Card</option>
                                                <option value="3">Passport</option>
                                                <option value="4">Voter ID</option>
                                                <option value="5">Driving License</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="fIDproofnumber" class="input-group-text">
                                                Id Proof Number
                                            </label>
                                            <input type="text" class="form-control" id="fIDproofnumber" placeholder="Number">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group text-center">
                                            <label for="idProofFather" class="">
                                                <div class="idPhoto">
                                                    <i class="fa fa-cloud-upload"></i>
                                                    Upload ID Proof's Photo
                                                </div>
                                            </label>
                                            <input type="file" class="form-control idProof-input" id="idProofFather" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="yearsOFoccu" class="input-group-text">
                                                Years Of Occupancy In Current House
                                            </label>
                                            <input type="text" class="form-control" id="yearsOFoccu" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="fOccupation" class="input-group-text">
                                                Occupation
                                            </label>
                                            <input type="text" class="form-control" id="fOccupation" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="fIncome" class="input-group-text">
                                                Monthly Income
                                            </label>
                                            <input type="text" class="form-control" id="fIncome" placeholder="">
                                        </div>
                                    </div>
                                </div>


                                <div class="FormDivider"></div>
                                <div class="row mt10">
                                    <div class="col-md-12">
                                        <h4 class="cd-heading-3">Mother's Information</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 padd-20">
                                        <div class="form-group disFlex">
                                            <label for="MPic" class="input-group-text">
                                                <div class="uploadPic">
                                                    <i class="fa fa-cloud-upload"></i>
                                                </div>
                                            </label>
                                            <div class="ml20"> Upload Photo</div>
                                            <input type="file" class="form-control pic idProof-input" id="MPic" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="MName" class="input-group-text">
                                                Name
                                            </label>
                                            <input type="text" class="form-control" id="MName" placeholder="Enter Full Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="MEmail" class="input-group-text">
                                                Email
                                            </label>
                                            <input type="text" class="form-control" id="MEmail" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="MDob" class="input-group-text">
                                                DOB
                                            </label>
                                            <input type="text" class="form-control" id="MDob" placeholder="--/--/----">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="number" class="input-group-text" for="M-mobile">
                                                Mobile Number
                                            </label>
                                            <input type="text" class="form-control" id="M-mobile" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group ">
                                            <div class="radio-heading input-group-text">
                                                Address
                                            </div>
                                            <ul class="displayInline">
                                                <li>
                                                    <label class="checkcontainer">Same As Above
                                                        <input type="checkbox" data-id="mAddress" onchange="hideAddress()">
                                                        <span class="Ch-checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10" id="mAddress">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group ">
                                            <div class="radio-heading input-group-text">
                                                Residence Type
                                            </div>
                                            <ul class="displayInline">
                                                <li>
                                                    <label class="container-radio">Rented
                                                        <input type="radio" checked="checked" name="MRT-rented" id="MRT-rented">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="container-radio">Owned
                                                        <input type="radio" name="MRT-owned" id="MRT-owned">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="MHouseNo" class="input-group-text">
                                                Address
                                            </label>
                                            <input type="text" class="form-control" id="MHouseNo" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="MCity" class="input-group-text">
                                                City
                                            </label>
                                            <input type="text" class="form-control" id="MCity" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="MState" class="input-group-text">
                                                State
                                            </label>
                                            <input type="text" class="form-control" id="MState" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label class="radio-heading input-group-text" for="MIdProof">
                                                ID Proof/Address Proof
                                            </label>
                                            <select class="form-control field-req" name="years" id="MIdProof">
                                                <option value="1">PAN</option>
                                                <option value="2">Adhaar Card</option>
                                                <option value="3">Passport</option>
                                                <option value="4">Voter ID</option>
                                                <option value="5">Driving License</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="MIdProofNo" class="input-group-text">
                                                Id Proof Number
                                            </label>
                                            <input type="text" class="form-control" id="MIdProofNo" placeholder="Number">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group text-center">
                                            <label for="idProofMother" class="">
                                                <div class="idPhoto">
                                                    <i class="fa fa-cloud-upload"></i>
                                                    Upload ID Proof's Photo
                                                </div>
                                            </label>
                                            <input type="file" class="form-control idProof-input" id="idProofMother" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="mOccupation" class="input-group-text">
                                                Occupation
                                            </label>
                                            <select class="form-control field-req" name="mOccupation">
                                                <option value="1">Salaried</option>
                                                <option value="2">Self-employed</option>
                                                <option value="3">Home-maker</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="familyIncome" class="input-group-text">
                                                Family Income(Monthly)
                                            </label>
                                            <input type="text" class="form-control" id="familyIncome" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                        <div class="radio-heading input-group-text">
                                            Siblings
                                        </div>
                                        <ul class="displayInline">
                                            <li>
                                                <label class="checkcontainer">Yes, I have Sibligs.
                                                    <input type="checkbox" data-id="siblingInfo" onchange="ShowSibling()">
                                                    <span class="Ch-checkmark"></span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    </div>
                                </div>
                                <div class="row mt10" id="siblingInfo">
                                    <div class="col-md-12">
                                        <p class="cd-heading-2">Sibling Information</p>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="siblingName" class="input-group-text">
                                               Name
                                            </label>
                                            <input type="text" class="form-control" id="siblingName" placeholder="Number">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="siblingAge" class="input-group-text">
                                                Age
                                            </label>
                                            <input type="text" class="form-control" id="siblingAge" placeholder="Number">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="siblingOccupation" class="input-group-text">
                                                Occupation
                                            </label>
                                            <input type="text" class="form-control" id="siblingOccupation" placeholder="Number">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="button" class="eduBtn eduBtnLight" data-id="applicantProfile" onclick="activeTab(event)">Previous</button>
                                    <button type="button" class="eduBtn" data-id="guarantorProfile" onclick="activeTab(event)">Next</button>
                                </div>
                            </div>
                            <div class="tab" id="guarantorProfile">
<!--                                <div class="row">-->
<!--                                    <div class="col-md-12">-->
<!--                                        <h4 class="cd-heading">Guarantor's Profile</h4>-->
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="row mt10">
                                    <div class="col-md-12">
                                        <h4 class="cd-heading-3">Guarantor 1</h4>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G1Name" class="input-group-text">
                                                Name
                                            </label>
                                            <input type="text" class="form-control" id="G1Name" placeholder="Enter Full Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G1Email" class="input-group-text">
                                                Email
                                            </label>
                                            <input type="text" class="form-control" id="G1Email" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G1Dob" class="input-group-text">
                                                DOB
                                            </label>
                                            <input type="text" class="form-control" id="G1Dob" placeholder="--/--/----">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G1number" class="input-group-text">
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
                                                    <label class="checkcontainer">Same As Above
                                                        <input type="checkbox" data-id="gAddress1" onchange="hideAddress()">
                                                        <span class="Ch-checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10" id="gAddress1">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group ">
                                            <div class="radio-heading input-group-text">
                                                Residence Type
                                            </div>
                                            <ul class="displayInline">
                                                <li>
                                                    <label class="container-radio">Rented
                                                        <input type="radio" checked="checked" name="G1-RT" id="G1-rented">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="container-radio">Owned
                                                        <input type="radio" name="G1-RT" id="G1-owned">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G1Address" class="input-group-text">
                                                Address
                                            </label>
                                            <input type="text" class="form-control" id="G1Address" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G1City" class="input-group-text">
                                                City
                                            </label>
                                            <input type="text" class="form-control" id="G1City" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G1state" class="input-group-text">
                                                State
                                            </label>
                                            <input type="text" class="form-control" id="G1state" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label class="radio-heading input-group-text" for="G1ID">
                                                ID Proof/Address Proof
                                            </label>
                                            <select class="form-control field-req" name="" id="G1ID">
                                                <option value="1">PAN</option>
                                                <option value="2">Adhaar Card</option>
                                                <option value="3">Passport</option>
                                                <option value="4">Voter ID</option>
                                                <option value="5">Driving License</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="G1IDnumber" class="input-group-text">
                                                Id Proof Number
                                            </label>
                                            <input type="text" class="form-control" id="G1IDnumber" placeholder="Number">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group text-center">
                                            <label for="G1IDpic" class="">
                                                <div class="idPhoto">
                                                    <i class="fa fa-cloud-upload"></i>
                                                    Upload ID Proof's Photo
                                                </div>
                                            </label>
                                            <input type="file" class="form-control idProof-input" id="G1IDpic" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="FormDivider"></div>
                                <div class="row mt10">
                                    <div class="col-md-12">
                                        <h4 class="cd-heading-3">Guarantor 2</h4>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G2name" class="input-group-text">
                                                Name
                                            </label>
                                            <input type="text" class="form-control" id="G2name" placeholder="Enter Full Name">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G2email" class="input-group-text">
                                                Email
                                            </label>
                                            <input type="text" class="form-control" id="G2email" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G2Dob" class="input-group-text">
                                                DOB
                                            </label>
                                            <input type="text" class="form-control" id="G2Dob" placeholder="--/--/----">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G2number" class="input-group-text">
                                                Mobile Number
                                            </label>
                                            <input type="text" class="form-control" id="G2number" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group ">
                                            <div class="radio-heading input-group-text">
                                                Address
                                            </div>
                                            <ul class="displayInline">
                                                <li>
                                                    <label class="checkcontainer">Same As Above
                                                        <input type="checkbox" data-id="gAddress2" onchange="hideAddress()">
                                                        <span class="Ch-checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10" id="gAddress2">
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group ">
                                            <div class="radio-heading input-group-text">
                                                Residence Type
                                            </div>
                                            <ul class="displayInline">
                                                <li>
                                                    <label class="container-radio">Rented
                                                        <input type="radio" checked="checked" name="G2address">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="container-radio">Owned
                                                        <input type="radio" name="G2address">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G2houseNo" class="input-group-text">
                                                Address
                                            </label>
                                            <input type="text" class="form-control" id="G2houseNo" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G2city" class="input-group-text">
                                                City
                                            </label>
                                            <input type="text" class="form-control" id="G2city" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="G2state" class="input-group-text">
                                                State
                                            </label>
                                            <input type="text" class="form-control" id="G2state" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label class="radio-heading input-group-text" for="G2ID">
                                                ID Proof/Address Proof
                                            </label>
                                            <select class="form-control field-req" name="years" id="G2ID">
                                                <option value="1">PAN</option>
                                                <option value="2">Adhaar Card</option>
                                                <option value="3">Passport</option>
                                                <option value="4">Voter ID</option>
                                                <option value="5">Driving License</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <label for="G2IDnumber" class="input-group-text">
                                                Id Proof Number
                                            </label>
                                            <input type="text" class="form-control" id="G2IDnumber" placeholder="Number">
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group text-center">
                                            <label for="G2IDpic" class="">
                                                <div class="idPhoto">
                                                    <i class="fa fa-cloud-upload"></i>
                                                    Upload ID Proof's Photo
                                                </div>
                                            </label>
                                            <input type="file" class="form-control idProof-input" id="G2IDpic" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="eduBtn eduBtnLight"data-id="parentsProfile" onclick="activeTab(event)">Previous</button>
                                    <button type="button" class="eduBtn" onclick="">Update</button>
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
');
$script = <<<JS

JS;
$this->registerJS($script);
?>
<script>
var eduTemp = ['<div class="col-md-4 padd-20">\n' +
'                                    <div class="form-group">\n' +
'                                        <label for="number" class="input-group-text">\n' +
'                                            Qualification \n' +
'                                        </label>\n' +
'                                        <input type="text" class="form-control" id="" placeholder="Degree Name" value="">\n' +
'                                    </div>\n' +
'                                </div>\n' +
'                                <div class="col-md-4 padd-20">\n' +
'                                    <div class="form-group">\n' +
'                                        <label for="number" class="input-group-text">\n' +
'                                            Name Of Institution\n' +
'                                        </label>\n' +
'                                        <input type="text" class="form-control" id="" placeholder="">\n' +
'                                    </div>\n' +
'                                </div>\n' +
'                                <div class="col-md-4 padd-20">\n' +
'                                    <div class="form-group">\n' +
'                                        <label for="number" class="input-group-text">\n' +
'                                            Marks Obtained\n' +
'                                        </label>\n' +
'                                        <input type="text" class="form-control" id="" placeholder="">\n' +
'                                    </div>\n' +
'                                </div>'];

function addEduField() {
    let eduFields = document.getElementById('eduFields');
    let newFields = document.createElement('div');
    newFields.setAttribute('class', 'row');
    newFields.innerHTML = eduTemp;

    eduFields.appendChild(newFields)
}

function hideAddress(){
    let clickedElem = event.currentTarget;
    let addressCheck = event.currentTarget.getAttribute('data-id')
    let  elemHide = document.getElementById(addressCheck);

    if(clickedElem.checked == true){
        elemHide.style.display = 'none';
    }else{
        elemHide.style.display = 'block';
    };
}

function ShowSibling() {
    let clickedElem = event.currentTarget;
    let addressCheck = event.currentTarget.getAttribute('data-id')
    let elemHide = document.getElementById(addressCheck);
    if(clickedElem.checked == true){
        elemHide.style.display = 'block';
    }else{
        elemHide.style.display = 'none';
    };
}
</script>

<script>

function activeTab(event) {
    let tabs = document.getElementsByClassName('tabActive');
    for(var i = 0; i < tabs.length; i++){
        tabs[i].classList.remove('tabActive');
    }
    let activeLi = document.getElementsByClassName('activeLi');
    for(var j = 0; j < activeLi.length; i++){
        activeLi[j].classList.remove('activeLi');
    }

    let activeID = event.currentTarget.getAttribute('data-id');
    console.log(activeID)
    let activeTab = document.getElementById(activeID);
    activeTab.classList.add('tabActive');
    let selectedTp = document.querySelector('[data-id="'+activeID+'"]');
    selectedTp.classList.add('activeLi');

}

</script>
