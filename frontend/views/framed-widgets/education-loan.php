<form action="action_page.php">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="form-start">
                    <form action="">
                        <div class="tab">
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
                                    <input type="text" class="form-control" id="number" placeholder="Enter Full Name">
                                </div>
                            </div>
                            <div class="col-md-12 padd-20">
                                <div class="form-group">
                                    <label for="number" class="input-group-text">
                                        Date Of Birth
                                    </label>
                                    <div class="input-group date" data-provide="datepicker" class="datepicker3">
                                        <input type="text" class="form-control">
                                        <div class="input-group-addon">
                                            <span class=""><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 padd-20" id="countryName">
                                <div class="form-group">
                                    <label for="duration" class="input-group-text">
                                        Enter Country Name
                                    </label>
                                    <input type="text" class="form-control" id="country"
                                           placeholder="Enter Country Name">
                                </div>
                            </div>
                            <div class="col-md-12 padd-20">
                                <div class="form-group">
                                    <label class="input-group-text" for="inputGroupSelect02">
                                        Current city where you live
                                    </label>
                                    <input type="text" id="cities" name="location" class="form-control"
                                           autocomplete="off" placeholder="City or State"/>
                                </div>
                            </div>
                            <div class="col-md-12 padd-20">
                                <div class="form-group">
                                    <div class="radio-heading input-group-text">
                                        Which degree do you want to pursue
                                    </div>
                                    <select class="form-control">
                                        <option>Diploma</option>
                                        <option>Graduation</option>
                                        <option>Post Graduation</option>
                                        <option>Professional Course</option>
                                        <option>Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 padd-20">
                                <div class="form-group">
                                    <label for="number" class="input-group-text">
                                        Course Name
                                    </label>
                                    <input type="text" class="form-control" id="number"
                                           placeholder="Enter Course Name">
                                </div>
                            </div>
                            <div class="col-md-6 padd-20">
                                <div class="form-group">
                                    <div class="radio-heading input-group-text">
                                        Year
                                    </div>
                                    <select class="form-control">
                                        <option>1st Year</option>
                                        <option>2st Year</option>
                                        <option>3rd Year</option>
                                        <option>4th Year</option>
                                        <option>5th Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 padd-20">
                                <div class="form-group">
                                    <div class="radio-heading input-group-text">
                                        Semester
                                    </div>
                                    <select class="form-control">
                                        <option>1st Semester</option>
                                        <option>2st Semester</option>
                                        <option>3rd Semester</option>
                                        <option>4th Semester</option>
                                        <option>5th Semester</option>
                                        <option>6th Semester</option>
                                        <option>7th Semester</option>
                                        <option>8th Semester</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 padd-20">
                                <div class="form-group">
                                    <label for="number" class="input-group-text">
                                        Phone Number (WhatsApp & Call)
                                    </label>
                                    <input type="text" class="form-control" id="number"
                                           placeholder="Enter Phone Number">
                                </div>
                            </div>
                            <div class="col-md-12 padd-20">
                                <div class="form-group">
                                    <label for="email" class="input-group-text">
                                        Email Address
                                    </label>
                                    <input type="text" class="form-control" id="email"
                                           placeholder="Enter Email Address">
                                </div>
                            </div>
                        </div>

                        <div class="tab">
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
                                                <input type="radio" checked="checked" name="genderRadio">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="container-radio">Female
                                                <input type="radio" name="genderRadio">
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
                                    <input type="text" class="form-control" id="annulIncome"
                                           placeholder="Enter Loan Amount">
                                </div>
                            </div>
                            <div class="col-md-12 padd-20">
                                <div class="form-group">
                                    <div class="radio-heading input-group-text">
                                        Purpose Of Loan
                                    </div>
                                    <ul>
                                        <li class="service-list">
                                            <input type="checkbox" name="name" id="tuition"
                                                   class="checkbox-input services"/>
                                            <label for="tuition">Tuition Fee</label>
                                        </li>
                                        <li class="service-list">
                                            <input type="checkbox" name="name" id="hostel"
                                                   class="checkbox-input services"/>
                                            <label for="hostel">Hostel</label>
                                        </li>
                                        <li class="service-list">
                                            <input type="checkbox" name="name" id="busFee"
                                                   class="checkbox-input services"/>
                                            <label for="busFee">Bus Fee</label>
                                        </li>
                                        <li class="service-list">
                                            <input type="checkbox" name="name" id="mess"
                                                   class="checkbox-input services"/>
                                            <label for="mess">Mess</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-12 padd-20">
                                <div class="form-heading">
                                    Borrower Details
                                </div>
                            </div>
                            <div class="col-md-12 padd-20">
                                <div class="form-group">
                                    <label for="email" class="input-group-text">
                                        Name
                                    </label>
                                    <input type="text" class="form-control" id="email"
                                           placeholder="Enter Full Name">
                                </div>
                            </div>
                            <div class="col-md-12 padd-20">
                                <div class="form-group">
                                    <div class="radio-heading input-group-text">
                                        Relation
                                    </div>
                                    <ul>
                                        <li class="service-list">
                                            <input type="radio" name="name" id="father"
                                                   class="checkbox-input services"/>
                                            <label for="father">Father</label>
                                        </li>
                                        <li class="service-list">
                                            <input type="radio" name="name" id="mother"
                                                   class="checkbox-input services"/>
                                            <label for="mother">Mother</label>
                                        </li>
                                        <li class="service-list">
                                            <input type="radio" name="name" id="brother"
                                                   class="checkbox-input services"/>
                                            <label for="brother">Brother</label>
                                        </li>
                                        <li class="service-list">
                                            <input type="radio" name="name" id="sister"
                                                   class="checkbox-input services"/>
                                            <label for="sister">Sister</label>
                                        </li>
                                        <!--                                            <li class="service-list">-->
                                        <!--                                                <input type="radio" name="name" id="guardian"-->
                                        <!--                                                       class="checkbox-input services"/>-->
                                        <!--                                                <label for="guardian">Guardian</label>-->
                                        <!--                                            </li>-->
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
                                                <input type="radio" checked="checked" name="borrowRadio">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="container-radio">Self-Employed
                                                <input type="radio" name="borrowRadio">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="container-radio">Non-Working
                                                <input type="radio" name="borrowRadio">
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-12 padd-20">
                                <div class="form-group">
                                    <label for="panNumber" class="input-group-text">
                                        Pan Card Number
                                    </label>
                                    <input type="text" class="form-control co-field" id="panNumber"
                                           name="panNumber" data-name="panNumber"
                                           placeholder="Enter Pan Number">
                                </div>
                            </div>
                            <div class="col-md-12 padd-20">
                                <div class="form-group">
                                    <label for="annulIncome" class="input-group-text">
                                        Annual Income
                                    </label>
                                    <input type="text" class="form-control" id="annulIncome"
                                           placeholder="Enter Annual Income">
                                </div>
                            </div>
                            <div class="applicantsMultiple">
                                <div class="col-md-12 padd-20">
                                    <div class="form-heading">
                                        Co-Borrower Details <span>Female Only</span>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="coBorrowerFemale" class="input-group-text">
                                            Name
                                        </label>
                                        <input type="text" class="form-control co-field" id="coBorrowerFemale"
                                               placeholder="Enter Full Name" name="name" data-name="name">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <div class="radio-heading input-group-text">
                                            Relation
                                        </div>
                                        <ul>

                                            <li class="service-list">
                                                <input type="radio" name="relation" id="coMother"
                                                       class="checkbox-input services co-field" value="Mother"
                                                       data-name="relation"/>
                                                <label for="coMother">Mother</label>
                                            </li>
                                            <li class="service-list">
                                                <input type="radio" name="relation" id="coSister"
                                                       class="checkbox-input services co-field" value="Sister"
                                                       data-name="relation"/>
                                                <label for="coSister">Sister</label>
                                            </li>
                                            <li class="service-list">
                                                <input type="radio" name="relation" id="coOther"
                                                       class="checkbox-input services co-field" value="Sister"
                                                       data-name="relation" onchange="showRelation()"/>
                                                <label for="coOther">Other</label>
                                            </li>
                                            <!--<li class="service-list">-->
                                            <!--<input type="radio" name="relation" id="guardian"-->
                                            <!--class="checkbox-input services co-field" value="Guardian"-->
                                            <!--data-name="relation"/>-->
                                            <!--<label for="guardian">Guardian</label>-->
                                            <!--</li>-->
                                        </ul>
                                        <div class="">
                                            <input type="text" class="form-control co-field" id="relationInput"
                                                   name="relationInput" data-name="relationInput"
                                                   placeholder="Relation">
                                        </div>
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
                                                    <input type="radio" checked="checked" name="employment_type"
                                                           value="1" class="co-field"
                                                           data-name="employment_type">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="container-radio">Self-Employed
                                                    <input type="radio" name="employment_type" value="2"
                                                           class="co-field" data-name="employment_type">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="container-radio">Non-Working
                                                    <input type="radio" name="employment_type" value="0"
                                                           class="co-field" data-name="employment_type">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="panNumberTwo" class="input-group-text">
                                            Pan Card Number
                                        </label>
                                        <input type="text" class="form-control co-field" id="panNumberTwo"
                                               name="panNumber" data-name="panNumber"
                                               placeholder="Enter Pan Number">
                                    </div>
                                </div>
                                <div class="col-md-12 padd-20">
                                    <div class="form-group">
                                        <label for="coAnnual_income" class="input-group-text">
                                            Annual Income
                                        </label>
                                        <input type="text" class="form-control co-field" id="coAnnual_income"
                                               name="annual_income" data-name="annual_income"
                                               placeholder="Enter Annual Income">
                                    </div>
                                </div>
                            </div>
                            <!--                                <div id="addAnotherCo">-->
                            <!---->
                            <!--                                </div>-->
                            <!--                                <div class="col-md-12 padd-20 displayFlex" id="addAnotherButton">-->
                            <!--                                    <button type="button" class="addAnotherCo input-group-text" onclick="addAnotherCo()"> <i class="fas fa-plus-square"></i> Add Another Co-Applicant</button>-->
                            <!--                                </div>-->
                        </div>
                        <div class="input-group padd-20">
                            <div class="btn-center">
                                <button type="button" class="button-slide" id="prevBtn" onclick="nextPrev(-1)">
                                    Previous
                                </button>
                                <button type="button" class="button-slide" id="nextBtn" onclick="nextPrev(1)">
                                    Next
                                </button>
                                <button type="button" class="button-slide" id="subBtn">
                                    Submit
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</form>
<?php
$this->registerCss("

");