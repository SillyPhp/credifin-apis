<?php

use yii\helpers\Url;

?>
<div class="row">
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
</div>
<div class="col-xs-12 col-sm-12">
    <div class="portlet light ">
        <div class="portlet-title tabbable-line">
            <div class="row">
                <div class="col-md-12">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Company Profiles</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <ul class="statusFilters">
                        <li>
                            <input id="lists[all]" type="checkbox" name="lists[all]"/>
                            <label for="lists[all]">All</label>
                        </li>
                        <li>
                            <input id="lists[new_lead]" type="checkbox" name="lists[new_lead]"/>
                            <label for="lists[new_lead]"> New Lead</label>
                        </li>
                        <li>
                            <input id="lists[accepted]" type="checkbox" name="lists[accepted]"/>
                            <label for="lists[accepted]"> Accepted</label>
                        </li>
                        <li>
                            <input id="lists[pre_verification]" type="checkbox" name="lists[pre_verification]"/>
                            <label for="lists[pre_verification]"> Pre Verification</label>
                        </li>
                        <li>
                            <input id="lists[under_process]" type="checkbox" name="lists[under_process]"/>
                            <label for="lists[under_process]"> Under Process</label>
                        </li>
                        <li>
                            <input id="lists[sanctioned]" type="checkbox" name="lists[sanctioned]"/>
                            <label for="lists[sanctioned]"> Sanctioned</label>
                        </li>
                        <li>
                            <input id="lists[disbursed]" type="checkbox" name="lists[disbursed]"/>
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
                            <div class="mt-actions mainTable" style="">
                                <div class="col-md-12">
                                    <table class="">
                                        <thead class="positionSticky">
                                        <tr>
                                            <th class="dateApplied">Date Applied</th>
                                            <th class="loanAction">Loan Status</th>
                                            <th class="applicantName">Applicant Name</th>
                                            <th class="loanAmount">Loan Amount</th>
                                            <th class="degree">Degree</th>
                                            <th class="courseName">Course Name</th>
                                            <th class="collegeName">College/University Name</th>
                                            <th class="startDate">Semester</th>
                                            <th class="endDate">Year</th>
                                            <th class="phoneNumber">Phone Number</th>
                                            <th class="applicantEmail">Email Address</th>
                                            <th class="city">City</th>
                                            <th class="applicantGender">Gender</th>
                                            <th class="dobwidth">DOB</th>
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
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="New Lead">New Lead
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Accepted">Accepted
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Pre Verification">Pre
                                                            Verification
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Under Process">Under
                                                            Process
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Sanctioned">Sanctioned
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Disbursed">Disbursed
                                                        </button>
                                                        <button class="actionBtn ab-last-btn"
                                                                onclick="nextRound(this)" value="Rejected">Reject
                                                        </button>
                                                    </div>
                                                </div>
                                                <span class="currentState">New Lead</span>
                                                <button class="nextState" onclick="nextPhase()" data-toggle="tooltip"
                                                        data-placement="top" title="Move to Next Phase">
                                                    <i class="fa fa-arrow-circle-right"></i>
                                                </button>
                                                <button class="viewStatus" onclick="viewStatus()">View Status</button>
                                                <button class="reconsider" onclick="reconsider()">Reconsider</button>
                                            </td>
                                            <td>Shshank Vasisht</td>
                                            <td>5,00,000</td>
                                            <td>Professional Course</td>
                                            <td>Charted Accountant</td>
                                            <td>Guru Nanak Institute of Management And Technology</td>
                                            <td>6</td>
                                            <td>3</td>
                                            <td>+91 7837394374</td>
                                            <td>vasishtshshank@gmail.com</td>
                                            <td>Ludhiana</td>
                                            <td>Male</td>
                                            <td>28-Sept-1993</td>
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
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="New Lead">New Lead
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Accepted">Accepted
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Pre Verification">Pre
                                                            Verification
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Under Process">Under
                                                            Process
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Sanctioned">Sanctioned
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Disbursed">Disbursed
                                                        </button>
                                                        <button class="actionBtn ab-last-btn"
                                                                onclick="nextRound(this)" value="Rejected">Reject
                                                        </button>
                                                    </div>
                                                </div>
                                                <span class="currentState">New Lead</span>
                                                <button class="nextState" onclick="nextPhase()" data-toggle="tooltip"
                                                        data-placement="top" title="Move to Next Phase">
                                                    <i class="fa fa-arrow-circle-right"></i>
                                                </button>
                                                <button class="viewStatus" onclick="viewStatus()">View Status</button>
                                            </td>
                                            <td>Shshank Vasisht</td>
                                            <td>5,00,000</td>

                                            <td>Professional Course</td>
                                            <td>Charted Accountant</td>
                                            <td>Guru Nanak Institute of Management And Technology</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>+91 7837394374</td>
                                            <td>vasishtshshank@gmail.com</td>
                                            <td>Ludhiana</td>
                                            <td>Male</td>
                                            <td>28-Sept-1993</td>
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
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="New Lead">New Lead
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Accepted">Accepted
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Pre Verification">Pre
                                                            Verification
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Under Process">Under
                                                            Process
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Sanctioned">Sanctioned
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Disbursed">Disbursed
                                                        </button>
                                                        <button class="actionBtn ab-last-btn"
                                                                onclick="nextRound(this)" value="Rejected">Reject
                                                            .modal-content         </button>
                                                    </div>
                                                </div>
                                                <span class="currentState">New Lead</span>
                                                <button class="nextState" onclick="nextPhase()" data-toggle="tooltip"
                                                        data-placement="top" title="Move to Next Phase">
                                                    <i class="fa fa-arrow-circle-right"></i>
                                                </button>
                                                <button class="viewStatus" onclick="viewStatus()">View Status</button>
                                            </td>
                                            <td>Shshank Vasisht</td>
                                            <td>5,00,000</td>
                                            <td>Professional Course</td>
                                            <td>Charted Accountant</td>
                                            <td>Guru Nanak Institute of Management And Technology</td>
                                            <td>6</td>
                                            <td>3</td>
                                            <td>+91 7837394374</td>
                                            <td>vasishtshshank@gmail.com</td>
                                            <td>Ludhiana</td>
                                            <td>Male</td>
                                            <td>28-Sept-1993</td>
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
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="New Lead">New Lead
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Accepted">Accepted
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Pre Verification">Pre
                                                            Verification
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Under Process">Under
                                                            Process
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Sanctioned">Sanctioned
                                                        </button>
                                                        <button class="actionBtn"
                                                                onclick="nextRound(this)" value="Disbursed">Disbursed
                                                        </button>
                                                        <button class="actionBtn ab-last-btn"
                                                                onclick="nextRound(this)" value="Rejected">Reject
                                                        </button>
                                                    </div>
                                                </div>
                                                <span class="currentState">New Lead</span>
                                                <button class="nextState" onclick="nextPhase()" data-toggle="tooltip"
                                                        data-placement="top" title="Move to Next Phase">
                                                    <i class="fa fa-arrow-circle-right"></i>
                                                </button>
                                                <button class="viewStatus" onclick="viewStatus()">View Status</button>
                                            </td>
                                            <td>Shshank Vasisht</td>
                                            <td>5,00,000</td>

                                            <td>Professional Course</td>
                                            <td>Charted Accountant</td>
                                            <td>Guru Nanak Institute of Management And Technology</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td>+91 7837394374</td>
                                            <td>vasishtshshank@gmail.com</td>
                                            <td>Ludhiana</td>
                                            <td>Male</td>
                                            <td>28-Sept-1993</td>
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
<div id="loanDetailModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Installment Schedule</h2>
        <div class="loanModalDetails">
            <div id="loanDetailScroll">
                <table>
                    <thead>
                    <tr>
                        <th class='tInstall'>S.No</th>
                        <th class='aInstall'>Due Date</th>
                        <th class='dueDate'>Amount</th>
                        <th class='installPaid'>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>01-08-2020</td>
                        <td>5726</td>
                        <td>Due</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>01-09-2020</td>
                        <td>5726</td>
                        <td>Due</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>01-10-2020</td>
                        <td>5726</td>
                        <td>Due</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>01-11-2020</td>
                        <td>5726</td>
                        <td>Due</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>01-10-2020</td>
                        <td>5726</td>
                        <td>Due</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>01-11-2020</td>
                        <td>5726</td>
                        <td>Due</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>01-10-2020</td>
                        <td>5726</td>
                        <td>Due</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>01-11-2020</td>
                        <td>5726</td>
                        <td>Due</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="sanctionModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content loanModal">
        <span class="close">&times;</span>
        <div class="loanModalDetails">
            <div class="row">
                <div class="col-md-3 col-sm-12 noPadd">
                    <div class="loan-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/loan-sanction-icon.png') ?>">
                        <p>Sanction Loan</p>
                    </div>
                </div>
                <div class="col-md-9 col-sm-12 noPadd">
                    <div id="loanModalScroll">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 padd-20">
                                <div class="form-group">
                                    <label for="number" class="input-group-text">
                                        File Number
                                    </label>
                                    <input type="text" class="form-control" id="fileNumber">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 padd-20">
                                <div class="form-group">
                                    <label for="number" class="input-group-text">
                                        Loan Amount
                                    </label>
                                    <input type="text" class="form-control" id="loanAmount">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 padd-20">
                                <div class="form-group">
                                    <label for="number" class="input-group-text">
                                        Processing Fee
                                    </label>
                                    <input type="text" class="form-control" id="processing">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 padd-20">
                                <div class="form-group">
                                    <label for="number" class="input-group-text">
                                        Total Installments
                                    </label>
                                    <input type="text" class="form-control" id="installments">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 padd-20">
                                <div class="form-group">
                                    <label for="number" class="input-group-text">
                                        Discounting
                                    </label>
                                    <input type="text" class="form-control" id="discounting">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 padd-20">
                                <div class="form-group">
                                    <label for="number" class="input-group-text">
                                        Approved By
                                    </label>
                                    <input type="text" class="form-control" id="approved">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 padd-20">
                                <div class="form-group">
                                    <label for="number" class="input-group-text">
                                        FLDG
                                    </label>
                                    <input type="text" class="form-control" id="FLDG">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 padd-20">
                                <div class="certificate-list">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th>Certificate Name</th>
                                            <th>Collected</th>
                                            <th>Yet To Be Collected</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Birth Certificate</td>
                                            <td><input type="radio" id="male" name="Certificate" value="Collected"
                                                       checked></td>
                                            <td><input type="radio" id="male" name="Certificate" value="Pending"></td>
                                        </tr>
                                        <tr>
                                            <td>Residence Proof</td>
                                            <td><input type="radio" id="male" name="Residence" value="Collected"></td>
                                            <td><input type="radio" id="male" name="Residence" value="Pending" checked>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Proof of Identity</td>
                                            <td><input type="radio" id="male" name="Identity" value="Collected" checked>
                                            </td>
                                            <td><input type="radio" id="male" name="Identity" value="Pending"></td>
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
.form-group{
    margin-bottom: 5px;
}
tr{
    position: relative;
}
.viewStatus, .reconsider{
    display: none;
    position: absolute;
    border: none;
    padding: 0;
    bottom: 0;
    right: 5px;
    font-size: 12px;
    background: transparent;
}
.viewStatus:hover, .reconsider:hover{
    color: #00a0e3;
    transition: .3s ease;
}
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
.actionColoum{
    position: relative;
}
.nextState{
    position: absolute;
    bottom: 0px;
    right: 0px;
}
.nextState:hover, .dropbtn:hover{
    color:#00a0e3;
    transition: .3s ease;
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
.loanAction{
    min-width:180px;
    max-width:180px;
}
.startDate, .endDate, .applicantGender, .loanAmount, .country, .coApplicantWidth{
    min-width:100px;
    max-width:100px;
}
.dateApplied, .dobwidth, .degree, .phoneNumber, .coEmployment, .city, .moveToNext{
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
    max-height:70vh;
    padding: 0 0 30px 0;
}

.mainTable table { 
  border-collapse: collapse; 
}
/* Zebra striping */
.mainTable tr:nth-of-type(odd),
.loanModalDetails tr:nth-of-type(odd){ 
  background: #eee; 
}
.mainTable th { 
  background: #333; 
  color: white; 
  font-weight: bold; 
}
.mainTable td, .mainTable th,
.loanModalDetails td, .loanModalDetails th { 
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
.installPaid, .installDue{
    min-width: 125px;
    max-width: 125px;
} 
.installPaid, .tInstall, .aInstall, .dueDate, .installBtn{
    min-width: 100px;
    max-width: 100px;
}
.loanDetails{
    position: absolute;
    z-index: 1;   
   
}
.loanDetails table{
    box-shadow: 0 0 10px rgba(0, 0, 0, .3);
    position: relative;
}
.loanModalDetails table{
    width:100%;
    border: 1px;
    position: relative
} 
.loanDetails table th,
.loanModalDetails table th{
   background: #f7f7f7;
   color: #333;
   padding: 5px; 
}
.loanModalDetails table th{
    width: 25%;
}
.loanDetails table td,
.loanModalDetails table td{
    background: #fff;
    color:#000;
    padding: 5px; 
}                                     
.loanDetails table td button{
    background: none;
    border: none;
    padding: 0;
    font-size: 13px;
}

.loanDetails table td button:hover{
    color:#00a0e3;
}
.close-icon{
    position: absolute;
    right: 5px;
    top: 5px;
    z-index: 1;
    color:#000;
}
.close-icon:hover{
    color:#00a0e3;
}

#sanctionModal.modal,
#loanDetailModal.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 9999; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

#sanctionModal .modal-content,
#loanDetailModal .modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 70vw;
  height: 70vh;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  
}

.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.loan-icon img{
    max-width: 150px;
}
.loan-icon{
    height: 60vh;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column
}
.loan-icon p{
    color: #fff;
    font-family: lora;
    font-size: 20px;
}
.loanModal{
    background: linear-gradient(to right, #00a0e3 25%, #fff 25%)    
}
.modal-open {
    overflow: hidden !important;
}
.loanModalDetails{
    height: 60vh;
}
.loanModalDetails label{
    border: none;
    height: auto;
    display: block;
    padding: 0 5px;
    color:#333;
    font-family: roboto;
    line-height: 18px;
    text-align: left;
}
.modal-content h2{
    font-family: lora;
    font-size: 20px;
    text-align: center;
}
#loanModalScroll{
    position: relative;
    height: 60vh;
    padding: 0 10px;
}
.certificate-list{
    margin-top: 15px;
}
.noPadd{
    padding:0px;
}
#loanDetailScroll{
    position: relative;
    height: 60vh;
}
#loanModalScroll .ps__thumb-x,
#loanModalScroll .ps__rail-x,
#loanModalScroll .ps--active-x > .ps__rail-x{
    display: none !important;
}
@media screen and (max-width: 992px){
    .loan-icon img{
      display: none;
    }
    .loan-icon p{
        color: #333;
        font-size: 20px;
        margin: 0px 0 0 0;
    }
    .loan-icon{
        height: auto;
    }
    #loanModalScroll{
        height: 60vh;
    }
    .loanModal {
        background: linear-gradient(to bottom, #00a0e3 5%, #fff 5%);
    }
    #sanctionModal .modal-content{
        height: 80vh
    }
}
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	.mainTable table, .mainTable thead, .mainTable tbody, .mainTable th, .mainTable td, .mainTable tr, 
	.loanDetails table, .loanDetails thead, .loanDetails tbody, .loanDetails th, .loanDetails td, .loanDetails tr,
	.loanModalDetails table, .loanModalDetails thead, .loanModalDetails tbody, .loanModalDetails th, .loanModalDetails td,
	 .loanModalDetails tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	.mainTable thead tr,
	.loanModalDetails thead tr,
	.loanDetails thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	.mainTable tr,
	 .loanModalDetails tr{ border: 1px solid #ccc; }
	
	.mainTable td, 
	.loanDetails td ,
	.loanModalDetails td { 
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50% !important; 
	}
	
	.mainTable td:before, 
	.loanDetails td:before,
	.loanModalDetails td:before { 
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
	.mainTable td:nth-of-type(1):before { content: "Move To Next Phase "; }
	.mainTable td:nth-of-type(2):before { content: "Current Phase"; }
	.mainTable td:nth-of-type(3):before { content: "Applicant Name"; }
	.mainTable td:nth-of-type(4):before { content: "Date of Birth"; }
	.mainTable td:nth-of-type(5):before { content: "Country?"; }
	.mainTable td:nth-of-type(6):before { content: "City"; }
	.mainTable td:nth-of-type(7):before { content: "Degree"; }
	.mainTable td:nth-of-type(8):before { content: "Course Name"; }
	.mainTable td:nth-of-type(9):before { content: "College/University Name"; }
	.mainTable td:nth-of-type(10):before { content: "Start Date"; }
	.mainTable td:nth-of-type(11):before { content: "End Date"; }
	.mainTable td:nth-of-type(12):before { content: "Phone Number"; }
	.mainTable td:nth-of-type(13):before { content: "Email Address"; }
	.mainTable td:nth-of-type(14):before { content: "Loan Amount"; }
	.mainTable td:nth-of-type(15):before { content: "Co-Applicant"; }
	.mainTable td:nth-of-type(16):before { content: "Co-Applicant\'s Name"; }
	.mainTable td:nth-of-type(17):before { content: "Co-Applicant\'s employment type"; }
	.mainTable td:nth-of-type(18):before { content: "Co-Applicant\'s Annual Income"; }
	.mainTable td:nth-of-type(19):before { content: "2nd Co-Applicant"; }
	.mainTable td:nth-of-type(20):before { content: "2nd Co-Applicant\'s Name"; }
	.mainTable td:nth-of-type(21):before { content: "2nd Co-Applicant\'s employment type"; }
	.mainTable td:nth-of-type(22):before { content: "2nd Co-Applicant\'s Annual Income"; }
    .mainTable td:nth-of-type(23):before { content: "3rd Co-Applicant"; }
	.mainTable td:nth-of-type(24):before { content: "3rd Co-Applicant\'s Name"; }
	.mainTable td:nth-of-type(25):before { content: "3rd Co-Applicant\'s employment type"; }
	.mainTable td:nth-of-type(26):before { content: "3rd Co-Applicant\'s Annual Income"; }
	
	
	.loanModalDetails td:nth-of-type(1):before { content: "S.No "; }
	.loanModalDetails td:nth-of-type(2):before { content: "Due Date "; }
	.loanModalDetails td:nth-of-type(3):before { content: "Amount "; }
	.loanModalDetails td:nth-of-type(4):before { content: "Status"; }

    .loanDetails td:nth-of-type(1):before{content: "Total Installments"}
    .loanDetails td:nth-of-type(2):before{content: "Amount Per Installment"}
    .loanDetails td:nth-of-type(3):before{content: "Next Due Date"}
    .loanDetails td:nth-of-type(4):before{content: "Installments Paid"}
    .loanDetails td:nth-of-type(5):before{content: "Installments Due"}
    .loanDetails td:nth-of-type(6):before{content: "View All"}

    .loanDetails{
        position: absolute;
        z-index: 1;
        width: 90%;   
    }
}

');

$script = <<<JS

var ps = new PerfectScrollbar('#overflowScroll');
var ps = new PerfectScrollbar('#loanModalScroll');
var ps = new PerfectScrollbar('#loanDetailScroll');

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

JS;
$this->registerJS($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    window.onclick = function () {
        var x = document.querySelector('.show');
        if (x.classList.contains('show')) {
            // x.classList.remove('show');
        }
    }
    let sanctionModal = document.getElementById('sanctionModal');

    function actionStats(ths) {
        let dropdownShow = ths.nextElementSibling.classList;
        if (dropdownShow.contains('show')) {
            ths.nextElementSibling.classList.remove('show');
        } else {
            ths.nextElementSibling.classList.add('show');
        }
    }

    function nextRound(e) {
        let currentRoundName = e.value;
        let parElement = e.closest('.actionColoum');
        let currentState = parElement.querySelector('.currentState');
        currentState.innerText = currentRoundName;

        if (currentRoundName == 'Sanctioned') {
            sanctionModal.style.display = "block"
        }
        if (currentRoundName == 'Disbursed') {
            parElement.querySelector('.nextState').style.display = "none";
            parElement.querySelector('.dropdown').style.display = "none";
            parElement.querySelector('.viewStatus').style.display = "block";
        }

        if (currentRoundName == 'Rejected') {
            parElement.querySelector('.nextState').style.display = "none";
            parElement.querySelector('.dropdown').style.display = "none";
            parElement.querySelector('.reconsider').style.display = "block";
        }
    }

    function nextPhase() {
        let parElement = event.currentTarget.parentElement;
        let curElement = parElement.getElementsByClassName('currentState');
        let curPhase = curElement[0].innerHTML;

        let phases = parElement.getElementsByClassName('actionBtn');
        let pVal = [];
        for (let i = 0; i < phases.length; i++) {
            pVal.push(phases[i].value);
            let nextIndex = pVal.indexOf(curPhase) + 1;
            let nextElem = pVal[nextIndex];
            curElement[0].innerHTML = nextElem;

            if (nextElem == 'Sanctioned') {
                sanctionModal.style.display = "block"
            }

            if (nextElem == 'Disbursed') {
                parElement.querySelector('.nextState').style.display = "none";
                parElement.querySelector('.dropdown').style.display = "none";
                parElement.querySelector('.viewStatus').style.display = "block";
            }

        }

    }

    function template() {
        let temp = "<table><div onclick='closeDetail()' class='close-icon'><i class='fa fa-times'></div><thead><tr><th class='tInstall'>Total Installments</th><th class='aInstall'>Amount Per Installment</th><th class='dueDate'>Next Due Date</th><th class='installPaid'>Installments Paid</th><th class='installDue'>Installments Due</th><th class='installBtn'>View All</th></tr></thead><tbody><tr><td>15</td><td>5726</td><td>12-08-2020</td><td>10</td><td>5</td><td><button id='ld-btn' type='button'>View Complete Details</button></td></tr></tbody></table>";
        return temp;
    }

    function insertAfter(referenceNode, newNode) {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    }

    function viewStatus() {
        let parentElem = event.currentTarget.parentElement;
        let rootTr = parentElem.parentElement;

        let div = document.createElement('div');
        div.setAttribute('class', 'loanDetails');
        div.innerHTML = template();
        insertAfter(rootTr, div);
        showModal();
    }

    function closeDetail() {
        let parElem = event.currentTarget.parentElement;
        parElem.remove();
    }

    var modal = document.getElementById("loanDetailModal");

    function showModal() {
        var ldBtn = document.getElementById("ld-btn");
        ldBtn.onclick = function () {
            modal.style.display = "block";
        }
    }

    var span = document.getElementsByClassName("close");
    for (let i = 0; i < span.length; i++) {
        span[i].onclick = function () {
            modal.style.display = "none";
            sanctionModal.style.display = "none";
        }
    }


    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        if (event.target == sanctionModal) {
            sanctionModal.style.display = "none";
        }
    }


</script>
