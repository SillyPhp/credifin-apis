<?php

use yii\helpers\Url;

?>
<div class="col-md-12">
    <div class="widget-row">
        <div class="col-md-3 col-sm-6">
            <a href="#">
                <div class="box-des box1 mt">
                    <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/company.png') ?>">
                    <span class="count">10</span>
                    <span class="box-text">New Leads</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="#">
                <div class="box-des box3 mt">
                    <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/internship.png') ?>">
                    <span class="count">100+</span>
                    <span class="box-text">All Applications</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="#">
                <div class="box-des box6 mt">
                    <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/intrnship.png') ?>">
                    <span class="count">100+</span>
                    <span class="box-text">Accepted</span>
                </div>
            </a>
        </div>
        <!--            <div class="col-md-3 col-sm-6">-->
        <!--                <a href="#">-->
        <!--                    <div class="box-des box2 mt">-->
        <!--                        <img src="-->
        <?//= Url::to('@eyAssets/images/pages/hr-recruiters/applicationr.png') ?><!--">-->
        <!--                        <span class="count">50</span>-->
        <!--                        <span class="box-text">Candidates Under Review</span>-->
        <!--                    </div>-->
        <!--                </a>-->
        <!--            </div>-->
        <div class="col-md-3 col-sm-6">
            <a href="#">
                <div class="box-des box4 mt box2set">
                    <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/candidates.png') ?>">
                    <span class="count">20</span>
                    <span class="box-text">Pre Verification</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="#">
                <div class="box-des box5 mt">
                    <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/candidateplaced.png') ?>">
                    <span class="count">100+</span>
                    <span class="box-text">Under Process</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="#">
                <div class="box-des box7 mt">
                    <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/jobopportunities.png') ?>">
                    <span class="count">100+</span>
                    <span class="box-text">Sanctioned</span>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="#">
                <div class="box-des box7 mt">
                    <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/jobopportunities.png') ?>">
                    <span class="count">100+</span>
                    <span class="box-text">Disbursed</span>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="col-xs-12 col-sm-12">
    <div class="portlet light ">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <i class=" icon-social-twitter font-dark hide"></i>
                <span class="caption-subject font-dark bold uppercase">Company Profiles</span>
            </div>
            <div class="actions">
                <div class="btn-group dashboard-button">
                    <button title="" class="viewall-jobs" onclick="countryHide()">India</button>
                    <button title="" class="viewall-jobs" onclick="countryShow()">Other Country</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="statusFilters">
                        <li>
                            <input id="lists[all]" type="checkbox" name="lists[all]" />
                            <label for="lists[all]">All</label>
                        </li>
                        <li>
                            <input id="lists[new_lead]" type="checkbox" name="lists[new_lead]" />
                            <label for="lists[new_lead]"> New Lead</label>
                        </li>
                        <li>
                            <input id="lists[accepted]" type="checkbox" name="lists[accepted]" />
                            <label for="lists[accepted]"> Accepted</label>
                        </li>
                        <li>
                            <input id="lists[pre_verification]" type="checkbox" name="lists[pre_verification]" />
                            <label for="lists[pre_verification]"> Pre Verification</label>
                        </li>
                        <li>
                            <input id="lists[under_process]" type="checkbox" name="lists[under_process]" />
                            <label for="lists[under_process]"> Under Process</label>
                        </li>
                        <li>
                            <input id="lists[sanctioned]" type="checkbox" name="lists[sanctioned]" />
                            <label for="lists[sanctioned]"> Sanctioned</label>
                        </li>
                        <li>
                            <input id="lists[disbursed]" type="checkbox" name="lists[disbursed]" />
                            <label for="lists[disbursed]"> Disbursed</label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <div class="tab-content">
                <div class="tab-pane active pos-rel" id="tab_actions_pending">
                    <div id="overflowScroll">
                        <div class="row">
                            <div class="mt-actions " style="">
                                <div class="col-md-12">
                                    <table>
                                        <thead class="positionSticky">
                                        <tr>
                                            <th class="dateApplied">Date Applied</th>
                                            <th class="loanAction">Move To Next Phase</th>
                                            <th class="moveToNext">Current Phase</th>
                                            <th class="applicantName">Applicant Name</th>
                                            <th class="dobwidth">DOB</th>
                                            <th class="country">Country</th>
                                            <th class="city">City</th>
                                            <th class="degree">Degree</th>
                                            <th class="courseName">Course Name</th>
                                            <th class="collegeName">College/University Name</th>
                                            <th class="startDate">Start Date</th>
                                            <th class="endDate">End Date</th>
                                            <th class="phoneNumber">Phone Number</th>
                                            <th class="applicantEmail">Email Address</th>
                                            <th class="applicantGender">Gender</th>
                                            <th class="loanAmount">Loan Amount</th>
                                            <th class="coApplicantWidth">Co-Applicant</th>
                                            <th class="coName">Co-Applicant's Name</th>
                                            <th class="coEmployment">Co-Applicant's employment type</th>
                                            <th class="coAnnual">Co-Applicant's Annual Income</th>
                                            <th class="coApplicantWidth">2nd Co-Applicant</th>
                                            <th class="coName">2nd Co-Applicant's Name</th>
                                            <th class="coEmployment">2nd Co-Applicant's employment type</th>
                                            <th class="coAnnual">2nd Co-Applicant's Annual Income</th>
                                            <th class="coApplicantWidth">3rd Co-Applicant</th>
                                            <th class="coName">3rd Co-Applicant's Name</th>
                                            <th class="coEmployment">3rd Co-Applicant's employment type</th>
                                            <th class="coAnnual">3rd Co-Applicant's Annual Income</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>22 Aug 2020</td>
                                            <td class="actionColoum">
                                                <div class="dropdown">
                                                    <button onclick="actionStats(this)" class="dropbtn"><i
                                                                class="fa fa-ellipsis-v"></i></button>
                                                    <div class="dropdown-content myDropdown">
                                                        <button class="actionBtn" onclick="nextRound(this)">Accepted</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Pre Verification</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Under Process</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Sanctioned</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Disbursed</button>
                                                        <button class="actionBtn ab-last-btn">Reject</button>
                                                    </div>
                                                </div>
                                                <button class="nextState">Pre Verification</button>
                                            </td>
                                            <td>
                                                <span class="currentState">Accepted</span>
                                            </td>
                                            <td>Shshank Vasisht</td>
                                            <td>28-Sept-1993</td>
                                            <td class="country">India</td>
                                            <td>Ludhiana</td>
                                            <td>Professional Course</td>
                                            <td>Charted Accountant</td>
                                            <td>Guru Nanak Institute of Management And Technology</td>
                                            <td>28-sept-2020</td>
                                            <td>28-sept-2022</td>
                                            <td>+91 7837394374</td>
                                            <td>vasishtshshank@gmail.com</td>
                                            <td>Male</td>
                                            <td>5,00,000</td>
                                            <td>Father</td>
                                            <td>Ashiwini Kumar Vasisht</td>
                                            <td>Salaried</td>
                                            <td>13,00,000</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                        </tr>
                                        <tr>
                                            <td>22 Aug 2020</td>
                                            <td class="actionColoum">
                                                <div class="dropdown">
                                                    <button onclick="actionStats(this)" class="dropbtn"><i
                                                                class="fa fa-ellipsis-v"></i></button>
                                                    <div class="dropdown-content myDropdown">
                                                        <button class="actionBtn" onclick="nextRound(this)">Accepted</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Pre Verification</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Under Process</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Sanctioned</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Disbursed</button>
                                                        <button class="actionBtn ab-last-btn">Reject</button>
                                                    </div>
                                                </div>
                                                <button class="nextState">Pre Verification</button>
                                            </td>
                                            <td>
                                                <span class="currentState">Accepted</span>
                                            </td>
                                            <td>Shshank Vasisht</td>
                                            <td>28-Sept-1993</td>
                                            <td class="country">India</td>
                                            <td>Ludhiana</td>
                                            <td>Professional Course</td>
                                            <td>Charted Accountant</td>
                                            <td>Guru Nanak Institute of Management And Technology</td>
                                            <td>28-sept-2020</td>
                                            <td>28-sept-2022</td>
                                            <td>+91 7837394374</td>
                                            <td>vasishtshshank@gmail.com</td>
                                            <td>Male</td>
                                            <td>5,00,000</td>
                                            <td>Father</td>
                                            <td>Ashiwini Kumar Vasisht</td>
                                            <td>Salaried</td>
                                            <td>13,00,000</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                        </tr>
                                        <tr>
                                            <td>22 Aug 2020</td>
                                            <td class="actionColoum">
                                                <div class="dropdown">
                                                    <button onclick="actionStats(this)" class="dropbtn"><i
                                                                class="fa fa-ellipsis-v"></i></button>
                                                    <div class="dropdown-content myDropdown">
                                                        <button class="actionBtn" onclick="nextRound(this)">Accepted</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Pre Verification</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Under Process</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Sanctioned</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Disbursed</button>
                                                        <button class="actionBtn ab-last-btn">Reject</button>
                                                    </div>
                                                </div>
                                                <button class="nextState">Pre Verification</button>
                                            </td>
                                            <td>
                                                <span class="currentState">Accepted</span>
                                            </td>
                                            <td>Shshank Vasisht</td>
                                            <td>28-Sept-1993</td>
                                            <td class="country">India</td>
                                            <td>Ludhiana</td>
                                            <td>Professional Course</td>
                                            <td>Charted Accountant</td>
                                            <td>Guru Nanak Institute of Management And Technology</td>
                                            <td>28-sept-2020</td>
                                            <td>28-sept-2022</td>
                                            <td>+91 7837394374</td>
                                            <td>vasishtshshank@gmail.com</td>
                                            <td>Male</td>
                                            <td>5,00,000</td>
                                            <td>Father</td>
                                            <td>Ashiwini Kumar Vasisht</td>
                                            <td>Salaried</td>
                                            <td>13,00,000</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                        </tr>
                                        <tr>
                                            <td>22 Aug 2020</td>
                                            <td class="actionColoum">
                                                <div class="dropdown">
                                                    <button onclick="actionStats(this)" class="dropbtn"><i
                                                                class="fa fa-ellipsis-v"></i></button>
                                                    <div class="dropdown-content myDropdown">
                                                        <button class="actionBtn" onclick="nextRound(this)">Accepted</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Pre Verification</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Under Process</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Sanctioned</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Disbursed</button>
                                                        <button class="actionBtn ab-last-btn">Reject</button>
                                                    </div>
                                                </div>
                                                <button class="nextState">Pre Verification</button>
                                            </td>
                                            <td>
                                                <span class="currentState">Accepted</span>
                                            </td>
                                            <td>Shshank Vasisht</td>
                                            <td>28-Sept-1993</td>
                                            <td class="country">India</td>
                                            <td>Ludhiana</td>
                                            <td>Professional Course</td>
                                            <td>Charted Accountant</td>
                                            <td>Guru Nanak Institute of Management And Technology</td>
                                            <td>28-sept-2020</td>
                                            <td>28-sept-2022</td>
                                            <td>+91 7837394374</td>
                                            <td>vasishtshshank@gmail.com</td>
                                            <td>Male</td>
                                            <td>5,00,000</td>
                                            <td>Father</td>
                                            <td>Ashiwini Kumar Vasisht</td>
                                            <td>Salaried</td>
                                            <td>13,00,000</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                        </tr>
                                        <tr>
                                            <td>22 Aug 2020</td>
                                            <td class="actionColoum">
                                                <div class="dropdown">
                                                    <button onclick="actionStats(this)" class="dropbtn"><i
                                                                class="fa fa-ellipsis-v"></i></button>
                                                    <div class="dropdown-content myDropdown">
                                                        <button class="actionBtn" onclick="nextRound(this)">Accepted</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Pre Verification</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Under Process</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Sanctioned</button>
                                                        <button class="actionBtn" onclick="nextRound(this)">Disbursed</button>
                                                        <button class="actionBtn ab-last-btn">Reject</button>
                                                    </div>
                                                </div>
                                                <button class="nextState">Pre Verification</button>

                                            </td>
                                            <td>
                                                <span class="currentState">Accepted</span>
                                            </td>
                                            <td>Shshank Vasisht</td>
                                            <td>28-Sept-1993</td>
                                            <td class="country">India</td>
                                            <td>Ludhiana</td>
                                            <td>Professional Course</td>
                                            <td>Charted Accountant</td>
                                            <td>Guru Nanak Institute of Management And Technology</td>
                                            <td>28-sept-2020</td>
                                            <td>28-sept-2022</td>
                                            <td>+91 7837394374</td>
                                            <td>vasishtshshank@gmail.com</td>
                                            <td>Male</td>
                                            <td>5,00,000</td>
                                            <td>Father</td>
                                            <td>Ashiwini Kumar Vasisht</td>
                                            <td>Salaried</td>
                                            <td>13,00,000</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                            <td> -</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
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
.statusFilters li{
    display:inline;
}
.statusFilters{
    padding-inline-start: 0px !important;
}
.dropbtn, .nextState{
    background: transparent;
    border:none;
}
.ab-last-btn{
    border-bottom: none !important;
    border-top: 1px solid #eee !important;
}
.actionBtn{
    width:100%;
    background: transparent;
    border:none;
    border-bottom: 1px solid #eee;
    padding: 10px 0;
}
.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f6f6f6;
  min-width: 200px;
  overflow: auto;
  border: 1px solid #ddd;
  z-index: 1;
  padding:0px !important;
}


.actionBtn:hover {background-color: #ddd;}

.show {display: block;}

.viewall-jobs{
    border:none;
}
.applicantName, .courseName, .applicantEmail, .coName, .coAnnual{
    min-width:200px;
    max-width:200px;
}
.startDate, .endDate, .applicantGender, .loanAmount, .country, .coApplicantWidth{
    min-width:100px;
    max-width:100px;
}
.dateApplied, .dobwidth, .degree, .phoneNumber, .coEmployment, .city, .loanAction, .moveToNext{
    min-width:150px;
    max-width:150px;
}
.collegeName{
    min-width:300px;
    max-width:300px;
}
#overflowScroll{
    position:relative;
    overflow-y: hidden;
    min-height:100vh;
}

table { 
  width: 100%; 
  border-collapse: collapse; 
}
/* Zebra striping */
tr:nth-of-type(odd) { 
  background: #eee; 
}
th { 
  background: #333; 
  color: white; 
  font-weight: bold; 
}
td, th { 
  padding: 6px; 
  border: 1px solid #ccc; 
  text-align: left; 
}
    
.overflowScroll{
    width:100%;
    overflow-y:hidden;
    
}
.hide{
    display: none;
}
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
	/*
	Label the data
	*/
	td:nth-of-type(1):before { content: "Move To Next Phase "; }
	td:nth-of-type(2):before { content: "Current Phase"; }
	td:nth-of-type(3):before { content: "Applicant Name"; }
	td:nth-of-type(4):before { content: "Date of Birth"; }
	td:nth-of-type(5):before { content: "Country?"; }
	td:nth-of-type(6):before { content: "City"; }
	td:nth-of-type(7):before { content: "Degree"; }
	td:nth-of-type(8):before { content: "Course Name"; }
	td:nth-of-type(9):before { content: "College/University Name"; }
	td:nth-of-type(10):before { content: "Start Date"; }
	td:nth-of-type(11):before { content: "End Date"; }
	td:nth-of-type(12):before { content: "Phone Number"; }
	td:nth-of-type(13):before { content: "Email Address"; }
	td:nth-of-type(14):before { content: "Loan Amount"; }
	td:nth-of-type(15):before { content: "Co-Applicant"; }
	td:nth-of-type(16):before { content: "Co-Applicant\'s Name"; }
	td:nth-of-type(17):before { content: "Co-Applicant\'s employment type"; }
	td:nth-of-type(18):before { content: "Co-Applicant\'s Annual Income"; }
	td:nth-of-type(19):before { content: "2nd Co-Applicant"; }
	td:nth-of-type(20):before { content: "2nd Co-Applicant\'s Name"; }
	td:nth-of-type(21):before { content: "2nd Co-Applicant\'s employment type"; }
	td:nth-of-type(22):before { content: "2nd Co-Applicant\'s Annual Income"; }
    td:nth-of-type(23):before { content: "3rd Co-Applicant"; }
	td:nth-of-type(24):before { content: "3rd Co-Applicant\'s Name"; }
	td:nth-of-type(25):before { content: "3rd Co-Applicant\'s employment type"; }
	td:nth-of-type(26):before { content: "3rd Co-Applicant\'s Annual Income"; }
}
 /*--- input checkbox ---*/
label {
    display:inline-block;
    border:solid 1px #999;
    line-height:35px;
    height:35px;
    border-radius: 5px;
    padding: 0 20px;
    -webkit-font-smoothing: antialiased; 
    margin-top:10px;
    font-family:Arial,Helvetica,sans-serif;
    color:#999;
    text-align:center;
}

input[type=checkbox] {
    display: none;
}

input:checked + label {
    border: solid 1px #00a0e3;
    color: #fff;
    border-radius:5px;
    background: #00a0e3;
}

//input:checked + label:before {
//    content: "\2713 ";
//}


/* new stuff */
.check {
    visibility: hidden;
}

input:checked + label .check {
    visibility: visible;
}

input.checkbox:checked + label:before {
    content: "";
}   
/*--- stats ---*/
.box1{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1job.png");}
.box2{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1company.png");}
.box3{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1internship.png");}
.box4{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1institute.png");}
.box5{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1school.png");}
.box6{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/college.png");}
.box7{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/g.png");}
.box-des {
   background-size: 100% 100%;
   background-repeat: no-repeat;
   position: relative;
   height: 160px;
}
.mt{margin-bottom:15px;}
.box-des img{
   position: absolute;
   max-width: 63px;
   right: 25px;
   top: 15px;
}
.box2set img{
    max-width: 80px !important;
}
.box-text {
   position: absolute;
   bottom: 3px;
   left: 16px;
   color: white;
   font-size: 21px;
   font-family: roboto;
}
.count {
   position: absolute;
   bottom: 28px;
   left: 16px;
   color: white;
   font-size: 30px;
   font-family: roboto;
}
                                       
');

$script = <<<JS

var ps = new PerfectScrollbar('#overflowScroll');

JS;
$this->registerJS($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    window.onclick = function() {
        var x = document.querySelector('.show');
        if( x.classList.contains('show')){
            // x.classList.remove('show');
        }
    }
    function actionStats(ths) {
        let dropdownShow = ths.nextElementSibling.classList;
        if (dropdownShow.contains('show')) {
            ths.nextElementSibling.classList.remove('show');
        } else {
            ths.nextElementSibling.classList.add('show');
        }
    }

    function nextRound(e) {
        let currentRoundName = e.innerHTML;
        let nextRoundName = e.nextElementSibling.innerHTML;
        e.closest('.actionColoum').nextElementSibling.firstElementChild.innerHTML = currentRoundName;
        e.closest('.dropdown').nextElementSibling.innerHTML =  nextRoundName;
        e.closest('.dropdown-content').classList.remove('show');
    }

    function countryHide() {
        var z = document.getElementsByClassName('country');
        for(var i = 0; i < z.length; i++){

            z[i].classList.toggle('hide');
        }
    }

    function countryShow(){
        var z = document.getElementsByClassName('country');
        for(var i = 0; i < z.length; i++){
            z[i].classList.remove('hide');
        }
    }
</script>
