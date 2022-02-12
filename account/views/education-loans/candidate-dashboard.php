<?php

use yii\helpers\Url;
use kartik\date\DatePicker;

$user_id = Yii::$app->user->identity->user_enc_id;
Yii::$app->view->registerJs('var user_enc_id = "' . $user_id . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var loan_app_id = "' . $loan_app_id . '"', \yii\web\View::POS_HEAD);
$documentOptions = ['PAN', 'Passport', 'Voter ID', 'Driving License'];
$financeDocumentOptions = ['ITR', 'Bank Statement'];
$occupationOptions = ['Salaried', 'Self Employed', 'None of above'];
$relationOptions = ['Father', 'Mother', 'Brother', 'Sister', 'Sibling', 'Guardian'];
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
                            <?php
                                if($data['ask_guarantor_info'] == 1){
                                    ?>
                                /
                                <li>
                                    <button data-id="guarantorProfile" class="topTab" onclick="activeTab(event)">Guarantor's
                                        Profile
                                    </button>
                                </li>
                            <?php
                                }
                            ?>
                        </ul>
                        <div class="tab tabActive" id="applicantProfile">
                            <section id="applicantBasicInformation" data-key="" data-type="applicant">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 padd-20">
                                        <div class="form-group disFlex">
                                            <div id="applicantImage">
                                                <label for="yourPic" class="input-group-text posRel pull-left">
                                                    <div class="uploadPic">
                                                        <i class="fa fa-cloud-upload"></i>
                                                    </div>
                                                </label>
                                                <div class="ml20">Upload Photo</div>
                                            </div>
                                            <input type="file" class="form-control pic idProof-input"
                                                   id="yourPic"
                                                   placeholder="">
                                        </div>

                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="form-group">
                                            <label for="applicantName" class="input-group-text">
                                                Name of Applicant
                                            </label>
                                            <input value="<?= $data['applicant_name'] ?>" type="text"
                                                   class="form-control" id="applicantName"
                                                   placeholder="Enter Full Name" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="form-group">
                                            <label for="applicantEmail" class="input-group-text">
                                                Email
                                            </label>
                                            <input value="<?= $data['email'] ?>" type="text" class="form-control"
                                                   id="applicantEmail"
                                                   placeholder="" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="form-group">
                                            <label for="applicantDob" class="input-group-text">
                                                DOB
                                            </label>
                                            <input value="<?= date('d/m/Y', strtotime($data['applicant_dob'])) ?>"
                                                   type="text" class="form-control" id="applicantDob"
                                                   placeholder="--/--/----" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-4 padd-20">
                                        <div class="form-group">
                                            <label for="applicantNumber" class="input-group-text" data-field="phone">
                                                Mobile Number (WhatsApp)
                                            </label>
                                            <input value="<?= $data['phone'] ?>" type="text" class="form-control"
                                                   id="applicantNumber"
                                                   placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt10">
                                    <div class="col-md-4 padd-20" hidden>
                                        <div class="form-group">
                                            <label class="radio-heading input-group-text" for="degreeApplied">
                                                Degree Applied
                                            </label>
                                            <select class="form-control field-req" name="years" id="degreeApplied">
                                                <option value="">Select One</option>
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
                                    <div class="col-md-4 padd-20">
                                        <div class="form-group">
                                            <div class="radio-heading input-group-text">
                                                Gender
                                            </div>
                                            <ul class="displayInline applicantGender" id="applicant_gender">
                                                <li>
                                                    <label class="container-radio" data-field="gender">Male
                                                        <input type="radio" name="applicant_gender" class="acnt_gender"
                                                               value="1">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="container-radio" data-field="gender">Female
                                                        <input type="radio" name="applicant_gender" class="acnt_gender"
                                                               value="2">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="container-radio" data-field="gender">Other
                                                        <input type="radio" name="applicant_gender" class="acnt_gender"
                                                               value="3">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
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
                                                        <option value="">Select One</option>
                                                        <?php
                                                        foreach ($documentOptions as $opt) {
                                                            ?>
                                                            <option value="<?= $opt ?>"><?= $opt ?></option>
                                                            <?php
                                                        }
                                                        ?>
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
                                                        <label for="applicantIDpic" class="docLabel">
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
                                                        <option value="">Select One</option>
                                                        <?php
                                                        foreach ($documentOptions as $opt) {
                                                            ?>
                                                            <option value="<?= $opt ?>"><?= $opt ?></option>
                                                            <?php
                                                        }
                                                        ?>
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
                                                        <label for="applicantIDTwoPic" class="docLabel">
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
                            <section id="permanentAddressInformation" data-key="" data-type="address"
                                     data-address-type="0" hidden>
                                <div class="row mt10">
                                    <div class="col-md-12">
                                        <h4 class="cd-heading-3">Residential Information</h4>
                                    </div>
                                </div>
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
                                            <label for="paState" class="input-group-text" data-field="state_id">
                                                State
                                            </label>
                                            <input type="text" class="form-control typeInput" id="paState"
                                                   placeholder="" data-url="states" autocomplete="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="paCity" class="input-group-text" data-field="city_id">
                                                City
                                            </label>
                                            <input type="text" class="form-control typeInput" id="paCity"
                                                   placeholder="" data-url="cities"
                                                   autocomplete="off"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group ">
                                            <div class="radio-heading input-group-text">
                                                Current Address
                                            </div>
                                            <ul class="displayInline">
                                                <li>
                                                    <label class="checkcontainer" data-field="is_sane_cur_addr">
                                                        Same As Permanent Address
                                                        <input class="same_address acntPerAddr" type="checkbox"
                                                               data-id="currentAddressInformation"
                                                               id="addrSamePermanent"
                                                               onchange="hideAddress()">
                                                        <span class="Ch-checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="currentAddressInformation" data-key="" data-type="address"
                                     data-address-type="1" class="hidden">
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
                                            <label class="input-group-text" for="caHouseNo" data-field="address">
                                                Address
                                            </label>
                                            <input type="text" class="form-control" id="caHouseNo" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="caState" class="input-group-text" data-field="state_id">
                                                State
                                            </label>
                                            <input type="text" class="form-control typeInput" id="caState"
                                                   placeholder="" data-url="states">
                                        </div>
                                    </div>
                                    <div class="col-md-3 padd-20">
                                        <div class="form-group">
                                            <label for="caCity" class="input-group-text" data-field="city_id">
                                                City
                                            </label>
                                            <input type="text" class="form-control typeInput" id="caCity"
                                                   placeholder="" data-url="cities"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <div class="FormDivider"></div>
                            <div id="eduFields">
                                <div class="row mt10">
                                    <div class="col-md-12">
                                        <h4 class="cd-heading-3">Education</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="button" id="addEduBtn" class="eduBtn2" onclick="addEduField(this)"
                                            data-count="0">Add More
                                    </button>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary custom-buttons2 eduBtn" data-id="parentsProfile"
                                        onclick="activeTab(event)">Next <i class="fa fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="tab" id="parentsProfile">
                            <?php
                            for ($i = 0; $i < 2; $i++) {
                                ?>
                                <div class="row mt10">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="co_borrower_<?= $i ?>" class="input-group-text"
                                                   data-field="co_borrower">
                                                Co Borrower <?= $i + 1 ?>
                                            </label>
                                            <select class="form-control field-req" name="co_borrower_<?= $i ?>"
                                                    id="co_borrower_<?= $i ?>">
                                                <option value="">Select One</option>
                                                <?php
                                                foreach ($relationOptions as $opt) {
                                                    ?>
                                                    <option value="<?= $opt ?>"><?= $opt ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <section id="co_borrower_info_<?= $i ?>" data-key="" data-type="co_applicant"
                                         data-relation="" style="display: none">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 padd-20">
                                            <div class="form-group disFlex">
                                                <div id="co_borrower_image_<?= $i ?>">
                                                    <label for="co_borrower_pic_<?= $i ?>" class="input-group-text posRel pull-left">
                                                        <div class="uploadPic">
                                                            <i class="fa fa-cloud-upload"></i>
                                                        </div>
                                                    </label>
                                                    <div class="ml20">Upload Photo</div>
                                                </div>
                                                <input type="file" class="form-control pic idProof-input"
                                                       id="co_borrower_pic_<?= $i ?>"
                                                       placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt10">
                                        <div class="col-md-3 padd-20">
                                            <div class="form-group">
                                                <label for="co_borrower_name_<?= $i ?>" class="input-group-text"
                                                       data-field="name">
                                                    Name
                                                </label>
                                                <input type="text" class="form-control" id="co_borrower_name_<?= $i ?>"
                                                       placeholder="Enter Full Name">
                                            </div>
                                        </div>
                                        <div class="col-md-3 padd-20">
                                            <div class="form-group">
                                                <label for="co_borrower_email_<?= $i ?>" class="input-group-text"
                                                       data-field="email">
                                                    Email
                                                </label>
                                                <input type="text" class="form-control" id="co_borrower_email_<?= $i ?>"
                                                       placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-3 padd-20">
                                            <div class="form-group">
                                                <label for="co_borrower_dob_<?= $i ?>" class="input-group-text"
                                                       data-field="co_applicant_dob">
                                                    DOB
                                                </label>
                                                <?php
                                                echo DatePicker::widget([
                                                    'name' => 'check_issue_date',
                                                    'type' => DatePicker::TYPE_INPUT,
                                                    'id' => 'co_borrower_dob_' . $i,
                                                    'options' => [
                                                        'placeholder' => 'Select Birth Date',
                                                    ],
                                                    'readonly' => true,
                                                    'pluginOptions' => [
                                                        'format' => 'dd-M-yyyy',
                                                        'todayHighlight' => true,
                                                        'autoclose' => true,
                                                    ],
                                                    'pluginEvents' => [
                                                        "changeDate" => "function(e) { 
                                                        var elem = $(this);
                                                        var value = elem.val();
                                                        updateValue(elem, value);
                                                     }",
                                                    ]
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3 padd-20">
                                            <div class="form-group">
                                                <label for="co_borrower_number_<?= $i ?>" class="input-group-text"
                                                       data-field="phone">
                                                    Mobile Number
                                                </label>
                                                <input type="text" class="form-control"
                                                       id="co_borrower_number_<?= $i ?>"
                                                       placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt10">
                                        <div class="col-md-4 padd-20 hidden">
                                            <div class="form-group">
                                                <label for="co_borrower_year_occupancy_<?= $i ?>"
                                                       class="input-group-text"
                                                       data-field="years_in_current_house">
                                                    Years Of Occupancy In Current House
                                                </label>
                                                <input type="text" class="form-control"
                                                       id="co_borrower_year_occupancy_<?= $i ?>"
                                                       placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4 padd-20">
                                            <div class="form-group">
                                                <label for="co_borrower_occupation_<?= $i ?>" class="input-group-text"
                                                       data-field="occupation">
                                                    Occupation
                                                </label>
                                                <select class="form-control field-req"
                                                        name="co_borrower_occupation_<?= $i ?>"
                                                        id="co_borrower_occupation_<?= $i ?>">
                                                    <option value="">Select One</option>
                                                    <?php
                                                    foreach ($occupationOptions as $opt) {
                                                        ?>
                                                        <option value="<?= $opt ?>"><?= $opt ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 padd-20">
                                            <div class="form-group">
                                                <label for="co_borrower_income_<?= $i ?>" class="input-group-text"
                                                       data-field="annual_income">
                                                    Annual Income
                                                </label>
                                                <input type="text" class="form-control"
                                                       id="co_borrower_income_<?= $i ?>"
                                                       placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 padd-20 hidden">
                                            <div class="form-group ">
                                                <div class="radio-heading input-group-text">
                                                    Address
                                                </div>
                                                <ul class="displayInline">
                                                    <li>
                                                        <label class="checkcontainer" data-field="address">Same As
                                                            Applicant
                                                            <input class="same_address" type="checkbox"
                                                                   data-id="co_borrower_other_info_<?= $i ?>"
                                                                   id="co_borrower_same_<?= $i ?>"
                                                                   onchange="hideAddress()">
                                                            <span class="Ch-checkmark"></span>
                                                        </label>

                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="co_borrower_other_info_<?= $i ?>" class="co-borrower-other-info">
                                        <article id="co_borrower_address_info_<?= $i ?>" data-key=""
                                                 data-type="address">
                                            <div class="row mt10" id="co_borrower_address_<?= $i ?>">
                                                <div class="col-md-3 padd-20">
                                                    <div class="form-group ">
                                                        <div class="radio-heading input-group-text">
                                                            Residence Type
                                                        </div>
                                                        <ul class="displayInline residenceType" data-field="res_type"
                                                            id="co_borrower_resident_info_<?= $i ?>">
                                                            <li>
                                                                <label class="container-radio">Rented
                                                                    <input type="radio" checked="checked"
                                                                           name="co_borrower_address_<?= $i ?>"
                                                                           value="0"
                                                                           id="FRT-rented">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <label class="container-radio">Owned
                                                                    <input type="radio"
                                                                           name="co_borrower_address_<?= $i ?>"
                                                                           id="FRT-owned"
                                                                           value="1">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 padd-20">
                                                    <div class="form-group">
                                                        <label for="co_borrower_houseNo_<?= $i ?>"
                                                               class="input-group-text"
                                                               data-field="address">
                                                            Address
                                                        </label>
                                                        <input type="text" class="form-control"
                                                               id="co_borrower_houseNo_<?= $i ?>"
                                                               placeholder="" data-id="coResidentInfo">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 padd-20">
                                                    <div class="form-group">
                                                        <label for="co_borrower_state_<?= $i ?>"
                                                               class="input-group-text"
                                                               data-field="state_id">
                                                            State
                                                        </label>
                                                        <input type="text" class="form-control typeInput"
                                                               id="co_borrower_state_<?= $i ?>"
                                                               data-url="states"
                                                               placeholder="" data-id="coResidentInfo">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 padd-20">
                                                    <div class="form-group">
                                                        <label for="co_borrower_city_<?= $i ?>" class="input-group-text"
                                                               data-field="city_id">
                                                            City
                                                        </label>
                                                        <input type="text" class="form-control typeInput"
                                                               id="co_borrower_city_<?= $i ?>"
                                                               placeholder="" data-id="coResidentInfo" data-url="cities"
                                                               disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                        <article id="co_borrower_certificationEncId_<?= $i ?>" data-key=""
                                                 data-type="id_proof">
                                            <div class="row mt10">
                                                <div class="col-md-4 padd-20">
                                                    <div class="form-group">
                                                        <label class="radio-heading input-group-text"
                                                               for="co_borrower_IDproof_<?= $i ?>"
                                                               data-field="proof_name">
                                                            ID Proof/Address Proof
                                                        </label>
                                                        <select class="form-control field-req" name="years"
                                                                id="co_borrower_IDproof_<?= $i ?>"
                                                                data-id="coProofInfo">
                                                            <option value="">Select One</option>
                                                            <?php
                                                            foreach ($documentOptions as $opt) {
                                                                ?>
                                                                <option value="<?= $opt ?>"><?= $opt ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 padd-20 hidden">
                                                    <div class="form-group">

                                                        <label for="co_borrower_IDproofnumber_<?= $i ?>"
                                                               class="input-group-text"
                                                               data-field="number">
                                                            Id Proof Number
                                                        </label>
                                                        <input type="text" class="form-control"
                                                               id="co_borrower_IDproofnumber_<?= $i ?>"
                                                               placeholder="Number" data-id="coProofInfo">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 padd-20">
                                                    <div class="form-group text-center">
                                                        <div id="co_borrower_IDproofimage_<?= $i ?>">
                                                            <label for="idProof_co_borrower_<?= $i ?>" class="posRel pull-left">
                                                                <div class="idPhoto">
                                                                    <i class="fa fa-cloud-upload"></i>
                                                                    Upload ID Proof's Photo
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <input type="file" class="form-control idProof-input"
                                                               id="idProof_co_borrower_<?= $i ?>"
                                                               placeholder="" data-id="coProofInfo">
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                        <article id="co_borrower_financeEncId_<?= $i ?>" data-key=""
                                                 data-type="id_proof">
                                            <div class="row mt10">
                                                <div class="col-md-4 padd-20">
                                                    <div class="form-group">
                                                        <label class="radio-heading input-group-text"
                                                               for="co_borrower_finance_<?= $i ?>"
                                                               data-field="proof_name">
                                                            Finance Proof
                                                        </label>
                                                        <select class="form-control field-req" name="years"
                                                                id="co_borrower_finance_<?= $i ?>"
                                                                data-id="coProofInfo">
                                                            <option value="">Select One</option>
                                                            <?php
                                                            foreach ($financeDocumentOptions as $opt) {
                                                                ?>
                                                                <option value="<?= $opt ?>"><?= $opt ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 padd-20 hidden">
                                                    <div class="form-group">

                                                        <label for="co_borrower_finance_number_<?= $i ?>"
                                                               class="input-group-text"
                                                               data-field="number">
                                                            Proof Number
                                                        </label>
                                                        <input type="text" class="form-control"
                                                               id="co_borrower_finance_number_<?= $i ?>"
                                                               placeholder="Number" data-id="coProofInfo">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 padd-20">
                                                    <div class="form-group text-center">
                                                        <div id="co_borrower_finance_image_<?= $i ?>">
                                                            <label for="finance_co_borrower_<?= $i ?>" class="posRel pull-left">
                                                                <div class="idPhoto">
                                                                    <i class="fa fa-cloud-upload"></i>
                                                                    Upload Proof's Photo
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <input type="file" class="form-control idProof-input"
                                                               id="finance_co_borrower_<?= $i ?>"
                                                               placeholder="" data-id="coProofInfo">
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                </section>
                                <div class="FormDivider"></div>
                                <?php
                            }
                            ?>
                            <div class="text-center">
                                <button type="button" class="btn custom-buttons3 eduBtn eduBtnLight" data-id="applicantProfile"
                                        onclick="activeTab(event)"><i class="fa fa-angle-left"></i> Previous
                                </button>
                                <?php
                                if($data['ask_guarantor_info'] == 1){
                                    ?>
                                    <button type="button" class="btn btn-primary custom-buttons2 eduBtn" data-id="guarantorProfile"
                                            onclick="activeTab(event)">Next <i class="fa fa-angle-right"></i>
                                    </button>
                                <?php
                                } else {
                                    ?>
                                    <button id="sbt2ndForm" type="button" class="btn btn-primary custom-buttons2 eduBtn">Update</button>
                                <?php
                                }
                                ?>
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
                                            <?php
                                            echo DatePicker::widget([
                                                'name' => 'check_issue_date',
                                                'type' => DatePicker::TYPE_INPUT,
                                                'id' => 'G1Dob',
                                                'options' => [
                                                    'placeholder' => 'Select Birth Date',
                                                ],
                                                'readonly' => true,
                                                'pluginOptions' => [
                                                    'format' => 'dd-M-yyyy',
                                                    'todayHighlight' => true,
                                                    'autoclose' => true,
                                                ],
                                                'pluginEvents' => [
                                                    "changeDate" => "function(e) { 
                                                        var elem = $(this);
                                                        var value = elem.val();
                                                        updateValue(elem, value);
                                                     }",
                                                ]
                                            ]);
                                            ?>
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
                                                        <option value="">Select One</option>
                                                        <?php
                                                        foreach ($documentOptions as $opt) {
                                                            ?>
                                                            <option value="<?= $opt ?>"><?= $opt ?></option>
                                                            <?php
                                                        }
                                                        ?>
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
                                            <?php
                                            echo DatePicker::widget([
                                                'name' => 'check_issue_date',
                                                'type' => DatePicker::TYPE_INPUT,
                                                'id' => 'G2Dob',
                                                'options' => [
                                                    'placeholder' => 'Select Birth Date',
                                                ],
                                                'readonly' => true,
                                                'pluginOptions' => [
                                                    'format' => 'dd-M-yyyy',
                                                    'todayHighlight' => true,
                                                    'autoclose' => true,
                                                ],
                                                'pluginEvents' => [
                                                    "changeDate" => "function(e) { 
                                                        var elem = $(this);
                                                        var value = elem.val();
                                                        updateValue(elem, value);
                                                     }",
                                                ]
                                            ]);
                                            ?>
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
                                                        <option value="">Select One</option>
                                                        <?php
                                                        foreach ($documentOptions as $opt) {
                                                            ?>
                                                            <option value="<?= $opt ?>"><?= $opt ?></option>
                                                            <?php
                                                        }
                                                        ?>
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
                                <button type="button" class="btn custom-buttons3 eduBtn eduBtnLight" data-id="parentsProfile"
                                        onclick="activeTab(event)"><i class="fa fa-angle-left"></i> Previous
                                </button>
                                <button id="sbt2ndForm" type="button" class="btn btn-primary custom-buttons2 eduBtn">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="fadder" style="display: none">
    <i class="fa fa-spinner fa-spin"></i>
</div>
<?php
$this->registerCss('
#fadder{
    background: #0000001c;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index:999999;
    display: flex;
    justify-content: center;
    align-items: center;
}
#fadder i{
    font-size: 50px;
}
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
    padding: 8px 20px;
    margin-top: 30px;
    border-radius: 6px;
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
#Guarantor1-other-info, #Guarantor2-other-info{
    display:none;
}
.form-control[readonly]{
    background-color: #fff;
}
.docLabel{
    position: relative;
}
.docEditIcon{
    cursor: pointer;
    position: absolute;
    right: -10px;
    top: -7px;
    background-color: #fff;
    width: 27px;
    height: 27px;
    box-shadow: 0px 0px 5px 3px #eee;
    padding: 6px;
    font-size: 16px;
    border-radius: 50%;
}
.file-outer-main,.docLabel{
    float:left;
}
.previewDocument, .file-outer-main img, .file-outer-main i.fa-file-pdf-o{
    cursor: pointer;
    float: left;
    border: 5px solid #fff;
    box-shadow: 0px 0px 5px 3px #eee;
    margin-bottom: 15px;
    border-radius:4px;
}
i.previewDocument, .file-outer-main i.fa-file-pdf-o{
    width: 95px;
    height: 105px;
    padding: 40px 10px;
    font-size: 73px !important;
}
img.previewDocument, .file-outer-main img{
    width: 140px;
    height: auto;
    padding: 5px;
}
.custom-buttons2 {
    font-size: 12px !important;
    padding: 8px 10px !important;
    -webkit-border-radius: 6px !important;
    -moz-border-radius: 6px !important;
    -ms-border-radius: 6px !important;
    -o-border-radius: 6px !important;
    border-radius: 6px !important;
}
.custom-buttons3 {
    background: #ddd !important;
    font-size: 12px !important;
    padding: 8px 10px !important;
    color: #000 !important;
    border-color: #ddd !important;
    -webkit-border-radius: 6px !important;
    -moz-border-radius: 6px !important;
    -ms-border-radius: 6px !important;
    -o-border-radius: 6px !important;
    border-radius: 6px !important;
}
span.twitter-typeahead{
    width:100%;
}
ul > .process_icon, ul > .done_icon{
    position:unset;
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
.twitter-typeahead .done_icon, .twitter-typeahead .process_icon{
    top:38%;
}
');
$script = <<<JS
var apiUrl = '/';
var docEditIcon = '<i class="fa fa-pencil docEditIcon"></i>';
if(document.domain != 'empoweryouth.com'){
    apiUrl = 'https://ravinder.eygb.me/';
}
function showImage(input, inp_id, file_extension, fileUrl) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        $('#'+inp_id).find('label').html(docEditIcon);
        var imgSource = $('#'+inp_id).find('.previewDocument');
        var tag_name = imgSource.prop("tagName");
        reader.onload = function (e) {
            switch (tag_name){
                case "IMG" :
                    if(file_extension == "pdf"){
                        imgSource.remove();
                        $('<i class="fa fa-file-pdf-o previewDocument" data-source="'+fileUrl+'" style="font-size: 30px;"></i>').insertBefore($('#'+inp_id).find('label'));
                    } else {
                        imgSource.attr('src',fileUrl);
                        imgSource.attr('data-source',fileUrl);
                    }
                    break;
                case "I" :
                    if(file_extension == "pdf"){
                        imgSource.attr('data-source', fileUrl);
                    } else {
                        imgSource.remove();
                        $('<img class="previewDocument"  data-source="'+fileUrl+'" src="'+fileUrl+'" height="50px" width="50px">').insertBefore($('#'+inp_id).find('label'));
                    }
                    break;
                default :
                    if(file_extension == "pdf"){
                        $('<i class="fa fa-file-pdf-o previewDocument" data-source="'+fileUrl+'" style="font-size: 30px;"></i>').insertBefore($('#'+inp_id).find('label'));
                    } else {
                        $('<img class="previewDocument"  data-source="'+fileUrl+'" src="'+fileUrl+'" height="50px" width="50px">').insertBefore($('#'+inp_id).find('label'));
                    }
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).on('click','#sbt2ndForm', function() {
    toastr.success("Updated Successfully...", "Success");
    setTimeout(function() {
        window.open('/account/education-loans/candidate-loan-dashboard', '_self');
    }, 1500);
})
$(document).on('click','.previewDocument', function() {
    var previewLink = $(this).attr("data-source");
    window.open(previewLink);
})

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

function documentSelectionDisable(value, slc_id, type){
    $("#"+slc_id+" option:contains()").prop("disabled", false);
    if(value != ""){
        $("#"+slc_id+" option:contains('"+value+"')").prop("disabled", true);
    }
}

$(document).on('change','#applicantID0', function() {
    var elem = $(this);
    var value = elem.val();
    documentSelectionDisable(value, "applicantID1","onChange");
});

$(document).on('change','#applicantID1', function() {
    var elem = $(this);
    var value = elem.val();
    documentSelectionDisable(value, "applicantID0","onChange");
});

function chngCoBorrowerType(value, section) {
    section.attr("data-relation", value);
    if(value){
        section.show();
    } else {
        section.hide();
    }
}
$(document).on('change','#co_borrower_0', function() {
    var value = $(this).val();
    var section = $('#co_borrower_info_0');
    chngCoBorrowerType(value, section);
});

$(document).on('change','#co_borrower_1', function() {
    var value = $(this).val();
    var section = $('#co_borrower_info_1');
    chngCoBorrowerType(value, section);
});

$(document).on('change','#co_borrower_finance_0, #co_borrower_finance_1, #co_borrower_IDproof_0, #co_borrower_IDproof_1, #co_borrower_occupation_0, #co_borrower_occupation_1', function() {
    var elem = $(this);
    var value = elem.val();
    updateValue(elem, value);
});

$(document).on('change','.same_address', function() {
    var elem = $(this);
    var value = "";
    if(elem.hasClass('acntPerAddr')){
        value = (elem.is(":checked"))?2:1;
    } else {
        value = (elem.is(":checked"))?1:0;
    }
    updateValue(elem, value);
});

$(document).on('change','#applicant_gender', function() {
    var elem = $(this);
    var value = "";
    $.each(elem.find('li'), function(k,v) {
        var inpt = $(this).find('input');
        var chk = inpt.is(":checked");
        if(chk){
            value = inpt.val();
            elem = inpt;
        }
    });
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
            url = apiUrl+'api/v3/education-loan/get-'+url+'?search='+ q; 
            break;
        case 'cities' :
            var state_id = elem.attr('data-state-id');
            url = apiUrl+'api/v3/education-loan/get-'+url+'?search='+ q + '&state_id=' + state_id; 
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

function frontInptValidation(x, type) {
    var regexp = "";
    switch (type){
        case "obtained_marks" :
            regexp=/^\d{1,2}(\.\d{1,2})?$/;
            break;
        case "years_in_current_house" :
            regexp=/^[0-9]{1,3}$/;
            break;
        case "annual_income" :
            regexp=/^\d{4,7}(\.\d{1,2})?$/;
            break;
        case "Aadhaar Card" :
            regexp=/^[2-9]{1}[0-9]{3}\s{0}[0-9]{4}\s{0}[0-9]{4}$/;
            break;
        case "PAN" :
            regexp=/^[A-Z]{5}[0-9]{4}\s{0}[A-Z]{1}$/;
            break;
        case "Passport" :
            regexp=/^[A-PR-WY]{1}[1-9]{1}[0-9]{5}[1-9]{1}$/;
            break;
        case "phone" :
            regexp=/^[5-9]{1}[0-9]{9}$/;
            break;
        case "email" :
            regexp=/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            break;
        case "allOthers" :
            // regexp=/^(?=.*[A-Za-z])[A-Za-z0-9]{1,5}$/;
            regexp=/^[a-zA-Z0-9!@#$%\^&*)(+=._-\s]{1,255}$/;
            break;
        default :
            regexp=/^[a-zA-Z0-9!@#$%\^&*)(+=._-\s]{3,20}$/;
    }
    if(regexp.test(x)) {
        return true;
    }
    return false;
}

function validate_fileupload(file, type){
    var extValidate = false;
    var fileName = file.name;
    var size=(file.size);
    if(size > 5000000) {
        toastr.error("File should be less than 5MB", "Large File");
        return false;
    }
    let allowed_extensions = new Array("jpg","jpeg","png","pdf");
  
    var file_extension = fileName.split('.').pop().toLowerCase(); // split function will split the filename by dot(.), and pop function will pop the last element from the array which will give you the extension as well. If there will be no extension then it will return the filename.
    for(var i = 0; i <= allowed_extensions.length; i++)
    {
        if(allowed_extensions[i]==file_extension)
        {
            extValidate = file_extension; // valid file extension
            break;
        }
    }

    if(extValidate == false){
        toastr.error('This extension is not allowed', "File Type Error");
    }
    return extValidate;
}

$(document).on('blur','input:text', function() {
    var elem = $(this);
    var value = elem.val();
    var labelName = elem.prev('label').attr('data-field');
    if(!elem.hasClass('typeInput') && labelName != 'co_applicant_dob'){
        updateValue(elem, value);
    }
});

function updateValue(elem, value){
    var inptId = elem.attr("id");
    if(value != objData[inptId] && value !== ""){
        var data = {};
        var label_name = "";
        if(elem.hasClass('same_address') || elem.hasClass('acnt_gender') || elem.hasClass('tt-input')){
            label_name = elem.closest('label').attr('data-field');
        } else {
            label_name = elem.prev('label').attr('data-field');
        }
        if(typeof label_name === "undefined" && elem.hasClass('tt-input')){
            label_name = elem.parent().parent().prev().attr('data-field');
        }
        if (frontInptValidation(value, "allOthers") == false){
            toastr.error("characters should be upto 255, allowed characters !@#$%\^&*)(+=._-", "Limit exceeded");
            elem.focus();
            return false;
        }
        if(label_name == "annual_income"){
            if (frontInptValidation(value, label_name) == false){
                toastr.error("Please enter a valid annual income between 1000 to 9999999", "Annual Income");
                elem.focus();
                return false;
            }
        }
        if(label_name == "obtained_marks"){
            if (frontInptValidation(value, label_name) == false){
                toastr.error("Please enter a valid marks in percentage upto 99.99", "Obtained Marks");
                elem.focus();
                return false;
            }
        }
        if(label_name == "years_in_current_house"){
            var chkLivingYear = frontInptValidation(value, label_name);
            if (chkLivingYear == false){
                toastr.error("Please enter a valid year upto 999", "Current Year");
                elem.focus();
                return false;
            }
        }
        if(label_name == "phone"){
            var chkNum = frontInptValidation(value, label_name);
            if (chkNum == false){
                toastr.error("Please enter a valid phone number", label_name);
                elem.focus();
                return false;
            }
        }
        if(label_name == "email"){
            value = String(value).toLowerCase();
            var chkEmail = frontInptValidation(value, label_name);
            if (chkEmail == false){
                toastr.error("Please enter a valid email id", label_name);
                elem.focus();
                return false;
            }
        }
        if(label_name == "number"){
            var docChilds = elem.closest('.row').children().children();
            var docFieldName = docChilds.children('label').attr('data-field');
            var docName = docChilds.children('select').val();
            var chkDoc = "";
            if (docFieldName == "proof_name"){
                chkDoc = frontInptValidation(value, docName);
                if (chkDoc == false){
                    toastr.error("Please enter a valid id", docName);
                    elem.focus();
                    return false;
                }
            }
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
        // riccy
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
        if(value != "" || key != ""){
            $.ajax({
                url: apiUrl+'api/v3/education-loan/loan-second-form',
                method: 'POST',
                data: data,
                beforeSend:function(){
                    removeIcons();
                    if(data['id'] == "" || typeof data['id'] === "undefined" ){
                        $('#fadder').fadeIn();
                    } else {
                        if(elem.attr('type') == 'radio'){
                            $('<i class="fa fa-spinner fa-spin process_icon"></i>').insertAfter(elem.parent().parent());
                        } else{
                            $('<i class="fa fa-spinner fa-spin process_icon"></i>').insertAfter(elem);
                        }
                    }
                },
                success: function(res) {
                    removeIcons();
                    if(res.response.status == 200){
                        if(elem.attr('type') == 'radio'){
                            $('<i class="fa fa-check done_icon"></i>').insertAfter(elem.parent().parent());
                        } else{
                            $('<i class="fa fa-check done_icon"></i>').insertAfter(elem);
                        }
                        setTimeout(function() {
                            removeIcons();
                        }, 3000);
                        objData[inptId] = value;
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
                    $('#fadder').fadeOut();
                }
            });
        }
    }
}
var objData = {};
$(document).ready(function() {
    var data = "";
    var guarantorCount = 0;
    $.ajax({
        url: apiUrl+'api/v3/education-loan/get-loan',
        method: 'POST',
        data:{loan_app_enc_id:loan_app_id},
        success: function(res) {
            res = res.response;
            if(res.status == 200){
                data = res.data;
                $('#applicantBasicInformation').attr('data-key',data.loan_app_enc_id);
                if(data.image){
                    $('#applicantImage').children('label').html(docEditIcon);
                    $('<img class="previewDocument" height="50px" width="50px" src="'+ data.image +'" data-source="'+ data.image +'" />').insertBefore($('#applicantImage').children('label'));
                }
                $('#applicantName').val(data.applicant_name);
                objData.applicantName = data.applicant_name;
                if(data.gender && data.gender < 4){
                    $('#applicant_gender').find("input[value='"+data.gender+"']").prop('checked',true);
                    objData.applicant_gender = data.gender;
                }
                $('#applicantEmail').val(data.email);
                objData.applicantEmail = data.email;
                $('#applicantDob').val(data.applicant_dob);
                objData.applicantDob = data.applicant_dob;
                $('#applicantNumber').val(data.phone);
                objData.applicantNumber = data.phone;
                $('#degreeApplied').val(data.degree);
                objData.degreeApplied = data.degree;
                $('#courseApplied').val(data.course_name);
                objData.courseApplied = data.course_name;
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
                    if(per_addr.is_sane_cur_addr == 2){
                        $('#addrSamePermanent').prop('checked',true);
                        $('#currentAddressInformation').hide();
                    }
                    objData.houseNo = per_addr.address;
                    if(per_addr.state_name){
                        $('#paState').val(per_addr.state_name);
                        objData.paState = per_addr.state_enc_id;
                        $('#paCity').attr('data-state-id',per_addr.state_enc_id);
                        $('#paCity').attr('disabled',false);
                    }
                    $('#paCity').val(per_addr.city_name);
                    objData.paCity = per_addr.city_enc_id;
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
                    $('#caHouseNo').val(cur_addr.address);
                    objData.caHouseNo = cur_addr.address;
                    if(cur_addr.state_name){
                        $('#caState').val(cur_addr.state_name);
                        objData.caState = cur_addr.state_enc_id;
                        $('#caCity').attr('data-state-id',cur_addr.state_enc_id);
                        $('#caCity').attr('disabled',false);
                    }
                    $('#caCity').val(cur_addr.city_name);
                    objData.caCity = cur_addr.city_enc_id;
                    if(cur_addr.type){
                        $('#cur_res_type').find('input:radio').each(function(){
                            if($(this).val() == cur_addr.type){
                                $(this).prop("checked",true);
                            }
                        });
                    }
                }
                var loanCertificates = data.loanCertificates;
                var acntIdName = "";
                var acntIDNum = "";
                var acntIDImg = "";
                var acntChangeElem = "";
                $.each(loanCertificates,function(i, v) {
                    $('#idProofInformation' + i).attr('data-key',v.certificate_enc_id);
                    acntIdName =  "applicantID" + i;
                    if(i == 1){
                        acntChangeElem = "applicantID0";
                    } else {
                        acntChangeElem = "applicantID1";
                    }
                    if($("#"+ acntIdName +" option:contains('"+v.name+"')").prop("disabled") != true){
                        documentSelectionDisable(v.name, acntChangeElem,"onReady");
                        $('#' + acntIdName).val(v.name);
                    } else {
                        v.number = "";
                    }
                    objData[acntIdName] = v.name;
                    acntIDNum =  "applicantIDnumber" + i;
                    $('#' + acntIDNum).val(v.number);
                    objData[acntIDNum] = v.number;
                    if(v.image){
                        acntIDImg =  "applicantIDimage" + i;
                        var fileName = v.image;
                        var file_extension = fileName.split('.').pop().toLowerCase();
                        $('#' + acntIDImg).children('label').html(docEditIcon);
                        if(file_extension == "pdf"){
                            $('<i class="fa fa-file-pdf-o previewDocument" data-source="'+v.image+'"  style="font-size: 30px;"></i>').insertBefore($('#' + acntIDImg).children('label'));
                        } else {
                            $('<img class="previewDocument" height="50px" width="50px" src="'+v.image+'" data-source="'+v.image+'" />').insertBefore($('#' + acntIDImg).children('label'));
                        }
                        objData[acntIDImg] = v.image;
                    }
                });
                var qualifications = data.loanCandidateEducations;
                var acntEduImg = "";
                var acntEduName = "";
                var acntInsName = "";
                var acntMarksObt = "";
                if(qualifications.length > 0){
                    $.each(qualifications, function(i, v) {
                        $('#addEduBtn').click();
                        $('#qualificationInformation' + i).attr('data-key',v.loan_candidate_edu_enc_id);
                        acntEduName =  "eduName" + i;
                        $('#' + acntEduName).typeahead('val', v.name);
                        objData[acntEduName] = v.name;
                        acntInsName =  "instituteName" + i;
                        $('#' + acntInsName).val(v.institution);
                        objData[acntInsName] = v.institution;
                        acntMarksObt =  "marksObtained" + i;
                        $('#' + acntMarksObt).val(v.obtained_marks);
                        objData[acntMarksObt] = v.obtained_marks;
                        if(v.image){
                            acntEduImg =  "educationCertFile" + i;
                            var fileName = v.image;
                            var file_extension = fileName.split('.').pop().toLowerCase();
                            if(file_extension == "pdf"){
                                $('#' + acntEduImg).children('label').html(docEditIcon + '<i class="fa fa-file-pdf-o" style="font-size: 30px;"></i>');;
                            } else {
                                $('#' + acntEduImg).children('label').html(docEditIcon + '<img height="50px" width="50px" src="'+v.image+'" />');;
                            }
                            objData[acntEduImg] = v.image;
                        }
                    });
                } else {
                    $('#addEduBtn').click();
                }
                $.each(data.loanCoApplicants, function(k,v) {
                    var residenceInfo = v.loanApplicantResidentialInfos[0];
                    if(typeof residenceInfo === "undefined"){
                        residenceInfo = {};
                    }
                    var coAppLoanCertificateArray = v.loanCertificates;
                    if(typeof coAppLoanCertificateArray === "undefined"){
                        coAppLoanCertificateArray = {};
                    }
                            
                    switch (v.relation) {
                        case 'Father' :
                        case 'Mother' :
                        case 'Sibling' :
                        case 'Brother' :
                        case 'Sister' :
                        case 'Guardian' :
                            var co_borrower = "co_borrower_" + k;
                            var co_borrower_info = "co_borrower_info_" + k;
                            var co_borrower_other_info = "co_borrower_other_info_" + k;
                            var co_borrower_image = "co_borrower_image_" + k;
                            var co_borrower_name = "co_borrower_name_" + k;
                            var co_borrower_email = "co_borrower_email_" + k;
                            var co_borrower_number = "co_borrower_number_" + k;
                            var co_borrower_dob = "co_borrower_dob_" + k;
                            var co_borrower_year_occupancy = "co_borrower_year_occupancy_" + k;
                            var co_borrower_occupation = "co_borrower_occupation_" + k;
                            var co_borrower_income = "co_borrower_income_" + k;
                            var co_borrower_same = "co_borrower_same_" + k;
                            var co_borrower_address = "co_borrower_address_" + k;
                            var co_borrower_other_info = "co_borrower_other_info_" + k;
                            var co_borrower_address_info = "co_borrower_address_info_" + k;
                            var co_borrower_houseNo = "co_borrower_houseNo_" + k;
                            var co_borrower_certificationEncId = "co_borrower_certificationEncId_" + k;
                            var co_borrower_IDproof = "co_borrower_IDproof_" + k;
                            var co_borrower_IDproofnumber = "co_borrower_IDproofnumber_" + k;
                            var co_borrower_IDproofimage = "co_borrower_IDproofimage_" + k;
                            var co_borrower_financeEncId = "co_borrower_financeEncId_" + k;
                            var co_borrower_finance = "co_borrower_finance_" + k;
                            var co_borrower_finance_number = "co_borrower_finance_number_" + k;
                            var co_borrower_finance_image = "co_borrower_finance_image_" + k;
                            var co_borrower_resident_info = "co_borrower_resident_info_" + k;
                            var co_borrower_state = "co_borrower_state_" + k;
                            var co_borrower_city = "co_borrower_city_" + k;
                            $('#' + co_borrower).val(v.relation);
                            var sect = $('#' + co_borrower_info);
                            chngCoBorrowerType(v.relation, sect);
                            sect.attr('data-key',v.loan_co_app_enc_id);
                            $('#'+ co_borrower_other_info).show();
                            if(v.image){
                                $('#' + co_borrower_image).children('label').html(docEditIcon);
                                $('<img class="previewDocument"  data-source="'+v.image+'" src="'+v.image+'" height="50px" width="50px">').insertBefore($('#' + co_borrower_image).children('label'));
                                objData[co_borrower_image] = v.image;
                            }
                            $('#' + co_borrower_name).val(v.name);
                            objData[co_borrower_name] = v.name;
                            $('#' + co_borrower_email).val(v.email);
                            objData[co_borrower_email] = v.email;
                            $('#' + co_borrower_number).val(v.phone);
                            objData[co_borrower_number] = v.phone;
                            $('#' + co_borrower_dob).val(v.co_applicant_dob);
                            objData[co_borrower_dob] = v.co_applicant_dob;
                            $('#' + co_borrower_year_occupancy).val(v.years_in_current_house);
                            objData[co_borrower_year_occupancy] = v.years_in_current_house;
                            $('#' + co_borrower_occupation).val(v.occupation);
                            objData[co_borrower_occupation] = v.occupation;
                            $('#' + co_borrower_income).val(v.annual_income);
                            objData[co_borrower_income] = v.annual_income;
                            if(v.address == 1){
                                $('#' + co_borrower_same).prop('checked',true);
                                objData[co_borrower_same] = 1;
                                $('#' + co_borrower_other_info).hide();
                            }
                            $('#' + co_borrower_address_info).attr('data-key', residenceInfo.loan_app_res_info_enc_id);
                            objData[co_borrower_address_info] = residenceInfo.loan_app_res_info_enc_id;
                            $('#' + co_borrower_houseNo).val(residenceInfo.address);
                            objData[co_borrower_houseNo] = residenceInfo.address;
                            if(coAppLoanCertificateArray.length > 0){
                                $.each(coAppLoanCertificateArray, function(i, coAppLoanCertificate){
                                    switch (coAppLoanCertificate.name){
                                        case 'Bank Statement' :
                                        case 'ITR' :
                                            $('#' + co_borrower_financeEncId).attr('data-key', coAppLoanCertificate.certificate_enc_id);
                                            objData[co_borrower_financeEncId] = coAppLoanCertificate.certificate_enc_id;
                                            $('#' + co_borrower_finance).val(coAppLoanCertificate.name);
                                            objData[co_borrower_finance] = coAppLoanCertificate.name;
                                            $('#' + co_borrower_finance_number).val(coAppLoanCertificate.number);
                                            objData[co_borrower_finance_number] = coAppLoanCertificate.number;
                                            if(coAppLoanCertificate.image){
                                                $('#' + co_borrower_finance_image).children('label').html(docEditIcon);
                                                var fileName = coAppLoanCertificate.image;
                                                var file_extension = fileName.split('.').pop().toLowerCase();
                                                $('#' + co_borrower_finance_image).children('label').html(docEditIcon);
                                                if(file_extension == "pdf"){
                                                    $('<i class="fa fa-file-pdf-o previewDocument" data-source="'+fileName+'"  style="font-size: 30px;"></i>').insertBefore($('#' + co_borrower_finance_image).children('label'));
                                                } else {
                                                    $('<img class="previewDocument" height="50px" width="50px" src="'+fileName+'" data-source="'+fileName+'" />').insertBefore($('#' + co_borrower_finance_image).children('label'));
                                                }
                                                
                                                objData[co_borrower_finance_image] = coAppLoanCertificate.image;
                                            }
                                            break;
                                        default :
                                            $('#' + co_borrower_certificationEncId).attr('data-key', coAppLoanCertificate.certificate_enc_id);
                                            objData[co_borrower_certificationEncId] = coAppLoanCertificate.certificate_enc_id;
                                            $('#' + co_borrower_IDproof).val(coAppLoanCertificate.name);
                                            objData[co_borrower_IDproof] = coAppLoanCertificate.name;
                                            $('#' + co_borrower_IDproofnumber).val(coAppLoanCertificate.number);
                                            objData[co_borrower_IDproofnumber] = coAppLoanCertificate.number;
                                            if(coAppLoanCertificate.image){
                                                $('#' + co_borrower_IDproofimage).children('label').html(docEditIcon);
                                                var fileName = coAppLoanCertificate.image;
                                                var file_extension = fileName.split('.').pop().toLowerCase();
                                                $('#' + co_borrower_IDproofimage).children('label').html(docEditIcon);
                                                if(file_extension == "pdf"){
                                                    $('<i class="fa fa-file-pdf-o previewDocument" data-source="'+fileName+'"  style="font-size: 30px;"></i>').insertBefore($('#' + co_borrower_IDproofimage).children('label'));
                                                } else {
                                                    $('<img class="previewDocument" height="50px" width="50px" src="'+fileName+'" data-source="'+fileName+'" />').insertBefore($('#' + co_borrower_IDproofimage).children('label'));
                                                }
                                                objData[co_borrower_IDproofimage] = coAppLoanCertificate.image;
                                            }
                                    }       
                                })
                            }
                            if(residenceInfo.type){
                                $('#' + co_borrower_resident_info).find('input:radio').each(function(){
                                    if($(this).val() == residenceInfo.type){
                                        $(this).prop("checked",true);
                                    }
                                });
                            }
                            if(residenceInfo.state_name){
                                $('#' + co_borrower_state).val(residenceInfo.state_name);
                                objData[co_borrower_state] = residenceInfo.state_enc_id;
                                $('#' + co_borrower_city).attr('data-state-id',residenceInfo.state_enc_id);
                                $('#' + co_borrower_city).attr('disabled',false);
                            }
                            $('#' + co_borrower_city).val(residenceInfo.city_name);
                            objData[co_borrower_city] = residenceInfo.city_enc_id;
                            break;
                        case 'Guarantor' :
                            var coAppLoanCertificate = v.loanCertificates[0];
                            if(typeof coAppLoanCertificate === "undefined"){
                                coAppLoanCertificate = {};
                            }
                            guarantorCount++;
                            if(guarantorCount <= 2){
                                var gName = "";
                                var gEmail = "";
                                var gDob = "";
                                var gPhone = "";
                                var gAddress = "";
                                var gCertName = "";
                                var gCertNum = "";
                                var gCertImg = "";
                                var gState = "";
                                var gStateEncId = "";
                                var gCity = "";
                                $('#guarantor'+guarantorCount+'Information').attr('data-key',v.loan_co_app_enc_id);
                                $('#'+ v.relation + guarantorCount +'-other-info').show();
                                gName = "G"+ guarantorCount + "Name";
                                $('#' + gName).val(v.name);
                                objData[gName] = v.name;
                                gEmail = "G"+ guarantorCount + "Email";
                                $('#'+ gEmail).val(v.email);
                                objData[gEmail] = v.email;
                                gDob = "G"+ guarantorCount + "Dob";
                                $('#'+ gDob).val(v.co_applicant_dob);
                                objData[gDob] = v.co_applicant_dob;
                                gPhone = "G"+ guarantorCount + "number";
                                $('#'+gPhone).val(v.phone);
                                objData[gPhone] = v.phone;
                                if(v.address == 1){
                                    $('#g'+guarantorCount+'Same').prop('checked',true);
                                    $('#gAddress'+guarantorCount).hide();
                                }
                                $('#Guarantor'+guarantorCount+'-address-info').attr('data-key', residenceInfo.loan_app_res_info_enc_id);
                                gAddress = "G"+ guarantorCount + "Address";
                                $('#'+gAddress).val(residenceInfo.address);
                                objData[gAddress] = residenceInfo.address;
                                
                                $('#Guarantor'+guarantorCount+'-identity-info').attr('data-key', coAppLoanCertificate.certificate_enc_id);
                                gCertName = "G"+ guarantorCount + "ID";
                                $('#'+gCertName).val(coAppLoanCertificate.name);
                                objData[gCertName] = coAppLoanCertificate.name;
                                gCertNum = "G"+ guarantorCount + "IDnumber";
                                $('#'+gCertNum).val(coAppLoanCertificate.number);
                                objData[gCertNum] = coAppLoanCertificate.number;
                                if(coAppLoanCertificate.image){
                                    gCertImg = "G"+ guarantorCount + "IDimage";
                                    $('#'+gCertImg).children('label').html('<img height="50px" width="50px" src="'+coAppLoanCertificate.image+'" />');
                                    objData[gCertImg] = coAppLoanCertificate.image;
                                }
                                if(residenceInfo.type){
                                    $('#Guarantor'+guarantorCount+'_Resident_Info').find('input:radio').each(function(){
                                        if($(this).val() == residenceInfo.type){
                                            $(this).prop("checked",true);
                                        }
                                    });
                                }
                                if(residenceInfo.state_name){
                                    gState = "g"+ guarantorCount + "state";
                                    $('#'+gState).val(residenceInfo.state_name);
                                    objData[gState] = residenceInfo.state_enc_id;
                                    gCity = "g"+ guarantorCount + "city";
                                    gStateEncId = "g"+ guarantorCount + "stateEncId";
                                    $('#'+gCity).attr('data-state-id',residenceInfo.state_enc_id);
                                    $('#'+gCity).attr('disabled',false);
                                }
                                gCity = "g"+ guarantorCount + "city";
                                $('#'+gCity).val(residenceInfo.city_name);
                                objData[gCity] = residenceInfo.city_enc_id;
                            }
                            break;
                        default:
                    }
                });
            }
        }
    });
});

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

let base_uri = '';
async function readFileAsDataURL(file) {
    let result_base64 = await new Promise((resolve) => {
        let fileReader = new FileReader();
        fileReader.onload = (e) => resolve(fileReader.result);
        fileReader.readAsDataURL(file);
    });
    
    base = result_base64;
    base_uri = base;
    return result_base64;
}
async function getUri(file) {
    let result_base64 = await new Promise((resolve) => {
        new Compressor(file, {
            quality: 0.6,
            success(result) {
                let dataURL = readFileAsDataURL(result).then(data => {
                    resolve(data);
                });
            },
        });
    });
    return result_base64;
}
let Pagewidth;
let doc;
let Pageheight;
let pdf_uri;
async function createPDF(imgData) {
    if (imgData.length=="undefined" || imgData.length==0){
        alert("select image");
        return false;
    }
    let result_base64 = await new Promise((resolve) => {
        doc = new jsPDF('p', 'pt', 'a4');
        Pagewidth = doc.internal.pageSize.width;
        Pageheight = doc.internal.pageSize.height;
        
        const img = new Image();
        img.src = imgData;
        img.length = imgData.length;
        img.onload = function() {
            img.imgWidth = img.naturalWidth;
            img.imgHeight = img.naturalHeight;
            callback(img.imgWidth,img.imgHeight,img.src,img.i,img.length).then(data => {
                resolve(true);
            });
        };
    });
    return result_base64;
}

async function callback(width,height,src,i,fileLength){
    let result_base64 = await new Promise((resolve) => {
        const widthRatio = Pagewidth / width;
        const heightRatio = Pageheight / height;
        const ratio = widthRatio > heightRatio ? heightRatio : widthRatio;
        const canvasWidth = width * ratio;
        const canvasHeight = height * ratio;
        const marginX = (Pagewidth - canvasWidth) / 2;
        const marginY = (Pageheight - canvasHeight) / 2;
        doc.addImage(src, 'JPEG', marginX, marginY, canvasWidth, canvasHeight, i);
        
        pdf_uri = doc.output('blob');
        resolve(true);
    });
    return result_base64;
}

 $(document).on('change','input:file', function(e) {
    var elem = $(this);
    var elem_id = elem.attr('id');
    var cnum = elem_id.replace(/\D/g,'');
    var cid = elem_id.replace(/[0-9]/g,'');
    var slctId = slctVal = ""; 
    switch (cid){
        case 'idProof_co_borrower_' :
            slctId = "co_borrower_IDproof_" + cnum;
            break;
        case 'finance_co_borrower_' :
            slctId = "co_borrower_finance_" + cnum;
            break;
        default :
    }
    if(slctId != ""){
        slctVal = $('#' + slctId).val();
        if(slctVal == ""){
            toastr.warning("Please select document type first", "Alert");
            return false;
        }
    }
    var section = elem.closest('section');
    var relation = section.attr('data-relation');
    var key = section.attr('data-key');
    var type = section.attr('data-type');
    var file_extension = validate_fileupload(e.target.files[0], type);
    
    if(file_extension == false){
        elem.val("");
        return false;
    }
     var files = e.target.files;
     if(files.length){
         var formData = new FormData();
         formData.append("upload_file", 'test');
         formData.append("user_enc_id", user_enc_id);
         formData.append("loan_app_id", loan_app_id);
         formData.append("image_name", files[0].name.split('.')[0]);
         if(typeof relation !== "undefined"){
            formData.append("relation", relation);
         }
        
         var co_app_other_info = elem.attr('data-id');
         var mainSection = section;
         if(typeof co_app_other_info !== "undefined"){
             var articalTag = elem.closest('article');
             type = articalTag.attr('data-type');
             key = articalTag.attr('data-key');
             mainSection = articalTag;
         }
        
         if(type){
             formData.append("type", type);
         }
         if(key){
             formData.append("id", key);
         }
         var section = elem.closest('section');
         
         if(file_extension != 'pdf'){
             getUri(files[0]).then(data => {
                 createPDF(base_uri).then(data => {
                     formData.append("image", pdf_uri); 
                     file_extension = 'pdf'
                     uploadImage(formData,mainSection,elem,file_extension)
                 })
             });
         }else{
             formData.append("image", files[0]); 
             uploadImage(formData,mainSection,elem,file_extension)
         }
         
     }
 });

function uploadImage(formData,mainSection,elem,file_extension){
    $.ajax({
             url: apiUrl+'api/v3/education-loan/upload-image',
             method: 'POST',
             data: formData,
             processData: false,
             contentType: false,
             beforeSend:function(){
                removeIcons();
                $('#fadder').fadeIn();
                // if(key == "" || typeof key === "undefined" ){
                //      $('#fadder').fadeIn();
                // } else {
                //     $('<i class="fa fa-spinner fa-spin process_icon"></i>').insertAfter(elem);
                // }
            },
             success: function(res) {
                removeIcons();
                if(res.response.status == 200){
                    mainSection.attr('data-key', res.response.id);
                    var inp_id = elem.prev().attr('id');
                    showImage(elem[0], inp_id, file_extension, res.response.fileUrl);
                    $('<i class="fa fa-check done_icon"></i>').insertAfter(elem);
                    setTimeout(function() {
                        removeIcons();
                    }, 3000);
                } else {
                     $('<i class="fa fa-exclamation-triangle error_icon"></i>').insertAfter(elem);
                }
                 $('#fadder').fadeOut();
             }
         });
}

 function removeIcons() {
    $('.process_icon').remove();
    $('.done_icon').remove();
    $('.error_icon').remove();
 }
JS;
$this->registerJS($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJSFile('https://cdnjs.cloudflare.com/ajax/libs/compressorjs/1.1.1/compressor.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJSFile('https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.1/jspdf.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    var apiUrl = '/';
    if(document.domain != 'empoweryouth.com'){
        apiUrl = 'https://sneh.eygb.me/';
    }
    function eduTemp(edu_count) {
        // return '<div class="row mt10"> <div class="col-md-4 padd-20"><div class="form-group"><label for="eduName' + edu_count + '" class="input-group-text" data-field="name">Qualification </label><input type="text" class="form-control" id="eduName' + edu_count + '" placeholder="Degree Name"></div></div><div class="col-md-4 padd-20"><div class="form-group"><label for="instituteName' + edu_count + '" class="input-group-text" data-field="institution">Name Of Institution</label><input type="text" class="form-control" id="instituteName' + edu_count + '" placeholder=""></div></div><div class="col-md-4 padd-20 hidden"><div class="form-group"><label for="marksObtained' + edu_count + '" class="input-group-text" data-field="obtained_marks">Marks Obtained</label><input type="text" class="form-control" id="marksObtained' + edu_count + '" placeholder=""></div></div></div>';
        return '<div class="row mt10">' +
            '<div class="col-md-4 padd-20">' +
            '<div class="form-group">' +
            '<label for="eduName' + edu_count + '" class="input-group-text" data-field="name">Qualification </label>' +
            '<div id="the-basics-' + edu_count + '">' +
            '<input type="text" placeholder="Degree Name" class="typeahead form-control text-capitalize" id="eduName' + edu_count + '" name="eduName' + edu_count + '">' +
            '</div>' +
            '</div>' +
            '</div>' +
            // '<div class="col-md-4 padd-20">' +
            // '<div class="form-group">' +
            // '<label for="eduName' + edu_count + '" class="input-group-text" data-field="name">Qualification </label>' +
            // '<input type="text" class="form-control" id="eduName' + edu_count + '" placeholder="Degree Name">' +
            // '</div>' +
            // '</div>' +
            '<div class="col-md-4 padd-20 hidden">' +
            '<div class="form-group">' +
            '<label for="instituteName' + edu_count + '" class="input-group-text" data-field="institution">Name Of Institution</label>' +
            '<input type="text" class="form-control" id="instituteName' + edu_count + '" placeholder="">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4 padd-20 hidden">' +
            '<div class="form-group">' +
            '<label for="marksObtained' + edu_count + '" class="input-group-text" data-field="obtained_marks">Marks Obtained</label>' +
            '<input type="text" class="form-control" id="marksObtained' + edu_count + '" placeholder="">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4 padd-20 text-center">' +
            '<div class="form-group">' +
            '<div class="file-outer-main" id="educationCertFile' + edu_count + '">' +
            '<label for="eduCertificateFile' + edu_count + '" class="docLabel">' +
            '<div class="idPhoto">' +
            '<i class="fa fa-cloud-upload"></i>Upload Photo ' +
            '</div>' +
            '</label>' +
            '</div>' +
            '<input type="file" class="form-control idProof-input" id="eduCertificateFile' + edu_count + '" placeholder="">' +
            '</div>' +
            '</div></div>';
    }

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
    }

    var courseList = "";
    function getCourses(id, count)
    {
        if(count <= 0){
            var _courses = [];
            $.ajax({
                url : apiUrl + 'api/v3/education-loan/course-pool-list',
                method : 'GET',
                success : function(res) {
                    if (res.response.status==200){
                        res = res.response.course;
                        $.each(res,function(index,value){
                            _courses.push(value.value);
                        });
                    } else {
                        console.log('courses could not fetch');
                    }
                }
            });
            courseList = _courses;
        }
        $('#'+id+' .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },{
            name: '_courses',
            source: substringMatcher(courseList)
        });
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
        var inptId = 'the-basics-' + count;
        getCourses(inptId, count);
        count++;
        ths.setAttribute('data-count', count);
        if (count >= 3) {
            ths.setAttribute('style', 'display:none');
        }
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
        let activeTab = document.getElementById(activeID);
        activeTab.classList.add('tabActive');
        let selectedTp = document.querySelector('[data-id="' + activeID + '"]');
        selectedTp.classList.add('activeLi');
        window.scrollTo(0, 0);
    }

</script>
