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
                                        <div class="col-md-4 col-sm-4 padd-20">
                                            <div class="userPic">
                                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/dummyModel1.jpg')?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Name of Applicant</p>
                                            <h3>Shshank Vasisht</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Email</p>
                                            <h3>vasishtshshank@gmail.com</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>DOB</p>
                                            <h3>28-09-1993</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Mobile Number</p>
                                            <h3>7837394734</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Degree Applied</p>
                                            <h3>Under Graduation</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Course Applied</p>
                                            <h3>B.Tech</h3>
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
                                                <div class="loan-info-box">
                                                    <p>ID Proof/Address Proof</p>
                                                    <h3>PAN</h3>
                                                </div>
                                            </div>
                                            <div class="col-md-6 padd-20">
                                                <div class="loan-info-box">
                                                    <p>Id Proof Number</p>
                                                    <h3>1234 5678 9123</h3>
                                                </div>
                                            </div>
                                            <div class="col-md-6 padd-20">
                                                <div class="proof-pic">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/dummy-adhar.jpeg')?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 padd-20">
                                                <div class="proof-pic">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/dummy-adhar.jpeg')?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mt10">
                                            <div class="col-md-6 padd-20">
                                                <div class="loan-info-box">
                                                    <p>ID Proof/Address Proof</p>
                                                    <h3>Adhar Card</h3>
                                                </div>
                                            </div>
                                            <div class="col-md-6 padd-20">
                                                <div class="loan-info-box">
                                                    <p>Id Proof Number</p>
                                                    <h3>1234 5678 9123</h3>
                                                </div>
                                            </div>
                                            <div class="col-md-6 padd-20">
                                                <div class="proof-pic">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/dummy-adhar.jpeg')?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 padd-20">
                                                <div class="proof-pic">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/dummy-adhar.jpeg')?>">
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
                                    <div class="col-md-12">
                                        <div class="radio-heading input-group-text">
                                            Permanent Address
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Residence Type</p>
                                            <h3>Owned</h3>
                                        </div>
                                   </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Address</p>
                                            <h3>123/4 Abc Nagar</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>City</p>
                                            <h3>Ludhiana</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>State</p>
                                            <h3>Punjab</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-12">
                                        <div class="radio-heading input-group-text">
                                            Current Address
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Residence Type</p>
                                            <h3>Owned</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Address</p>
                                            <h3>123/4 Abc Nagar</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>City</p>
                                            <h3>Ludhiana</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>State</p>
                                            <h3>Punjab</h3>
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
                                        <div class="loan-info-box">
                                            <p>Qualification</p>
                                            <h3>10th</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Name Of Institution</p>
                                            <h3>GNIMT</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Marks Obtained</p>
                                            <h3>70%</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Qualification</p>
                                            <h3>+2</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Name Of Institution</p>
                                            <h3>GNIMT</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Marks Obtained</p>
                                            <h3>70%</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Qualification</p>
                                            <h3>Bachelors In Computer Applications</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Name Of Institution</p>
                                            <h3>GNIMT</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Marks Obtained</p>
                                            <h3>70%</h3>
                                        </div>
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
                                        <div class="userPic">
                                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/dummyModel1.jpg')?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Name</p>
                                            <h3>Mr. Ashwini Kumar Vasisht</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Email</p>
                                            <h3>vasishtshshank@gmail.com</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>DOB</p>
                                            <h3>02-07-1956</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Mobile Number</p>
                                            <h3>9876451233</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt10" id="fAddress">
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Residence Type</p>
                                            <h3>Owned</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Address</p>
                                            <h3>123/4 Abc Nagar</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>City</p>
                                            <h3>Ludhiana</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>State</p>
                                            <h3>Punjab</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>ID Proof/Address Proof</p>
                                            <h3>Adhar Card</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Id Proof Number</p>
                                            <h3>1234 5678 9123</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="proof-pic">
                                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/dummy-adhar.jpeg')?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="proof-pic">
                                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/dummy-adhar.jpeg')?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Years Of Occupancy In Current House</p>
                                            <h3>20</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Occupation</p>
                                            <h3>Government Employee</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Monthly Income</p>
                                            <h3>1,00,000</h3>
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
                                        <div class="userPic">
                                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/dummyModel.jpg')?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Name</p>
                                            <h3>Mrs. Nisha Vasisht</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Email</p>
                                            <h3>vasishtshshank@gmail.com</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>DOB</p>
                                            <h3>04-01-1960</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Mobile Number</p>
                                            <h3>7837394374</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10" id="mAddress">
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Residence Type</p>
                                            <h3>Owned</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Address</p>
                                            <h3>123/4 Abc Nagar</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>City</p>
                                            <h3>Ludhiana</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>State</p>
                                            <h3>Punjab</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Occupation</p>
                                            <h3>Salaried</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Family Income(Monthly)</p>
                                            <h3>2,00,000</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>ID Proof/Address Proof</p>
                                            <h3>Adhar Card</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Id Proof Number</p>
                                            <h3>1234 5678 9123</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="proof-pic">
                                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/dummy-adhar.jpeg')?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="proof-pic">
                                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/dummy-adhar.jpeg')?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10" id="siblingInfo">
                                    <div class="col-md-12">
                                        <p class="cd-heading-2">Sibling Information</p>
                                    </div>
                                    <div class="col-md-4 padd-20">
                                        <div class="loan-info-box">
                                            <p>Name</p>
                                            <h3>Saurabh Vasisht</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-2 padd-20">
                                        <div class="loan-info-box">
                                            <p>Age</p>
                                            <h3>30</h3>
                                       </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Occupation</p>
                                            <h3>Charted Accountant</h3>
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
                                        <div class="loan-info-box">
                                            <p>Name</p>
                                            <h3>Saurabh Vasisht</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Email</p>
                                            <h3>vasishtshshank@gmail.com</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>DOB</p>
                                            <h3>20-09-1993</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Mobile Number</p>
                                            <h3>7837794374</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10" id="gAddress1">
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Residence Type</p>
                                            <h3>Owned</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Address</p>
                                            <h3>123/4 Abc Nagar</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>City</p>
                                            <h3>Ludhiana</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>State</p>
                                            <h3>Punjab</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>ID Proof/Address Proof</p>
                                            <h3>Adhar Card</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Id Proof Number</p>
                                            <h3>1234 5678 9123</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="proof-pic">
                                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/dummy-adhar.jpeg')?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="proof-pic">
                                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/dummy-adhar.jpeg')?>">
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
                                        <div class="loan-info-box">
                                            <p>Name</p>
                                            <h3>Saurabh Vasisht</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Email</p>
                                            <h3>vasishtshshank@gmail.com</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>DOB</p>
                                            <h3>20-09-1993</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Mobile Number</p>
                                            <h3>7837794374</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10" id="gAddress2 ">
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Residence Type</p>
                                            <h3>Owned</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Address</p>
                                            <h3>123/4 Abc Nagar</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>City</p>
                                            <h3>Ludhiana</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>State</p>
                                            <h3>Punjab</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>ID Proof/Address Proof</p>
                                            <h3>Adhar Card</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="loan-info-box">
                                            <p>Id Proof Number</p>
                                            <h3>1234 5678 9123</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="proof-pic">
                                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/dummy-adhar.jpeg')?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="proof-pic">
                                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/dummy-adhar.jpeg')?>">
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
.proof-pic, .userPic{
    width: 200px;
    height: 150px;
    border: 1px solid #eee;
    margin-bottom: 10px;
}
.userPic{
    width: 150px;
 }
.proof-pic img, .userPic img{
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.userPic img{
    object-fit: cover;
}
.loan-info-box{
    margin-bottom: 30px
}
.loan-info-box p{
    font-size: 14px;
    color: #333;
    margin-bottom: 5px;
}
.loan-info-box h3{
    padding: 5px 0px;
    width: 100%;
    color: #000;
    font-size: 18px;
    margin:0;
    font-weight: bold;
}
.activeLi{
    color: #00a0e3 !important;
}
#siblingInfo{
    display: block;
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
        window.scrollTo(0,0);
    }

</script>
