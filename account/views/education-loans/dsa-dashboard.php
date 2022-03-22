<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use borales\extensions\phoneInput\PhoneInput;

$filters = [];
if (isset($_GET['filter'])) {
    $filters = explode(',', $_GET['filter']);
}

$httpsAbsoluteHomeUrl = Url::home(true);
$fullUrl = explode('/', $httpsAbsoluteHomeUrl);
$baseUrl = $fullUrl[2];
if (Yii::$app->user->identity->organization->organization_enc_id) {
$org_id = Yii::$app->user->identity->organization->organization_enc_id;
$org_slug = Yii::$app->user->identity->organization->slug;

}
?>
<div class="row">
    <?php
    Pjax::begin([
        'id' => 'stat-container',
    ]);
    ?>
    <div class="<?= $org_slug == 'phfleasing' ? 'col-md-6' : 'col-md-9'?>">
        <div class="widget-row row">
            <div class="col-md-6 <?= $org_slug == 'phfleasing' ? '' : 'col-lg-3 inc-height' ?>">
                <a href="/account/education-loans/leads?filter=0" data-pjax="0">
                    <div class="box-des box1 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/company.png') ?>">
                        <span class="count"><?= $stats['new_leads'] ?></span>
                        <span class="box-text">New Leads</span>
                    </div>
                </a>
            </div>
            <div class="col-md-6 <?= $org_slug == 'phfleasing' ? '' : 'col-lg-3 inc-height' ?>">
                <a href="/account/education-loans/leads?filter=all" data-pjax="0">
                    <div class="box-des box3 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/internship.png') ?>">
                        <span class="count"><?= $stats['all_applications'] ?></span>
                        <span class="box-text">All Applications</span>
                    </div>
                </a>
            </div>
            <div class="col-md-6 <?= $org_slug == 'phfleasing' ? '' : 'col-lg-3 inc-height' ?>">
                <a href="/account/education-loans/leads?filter=3" data-pjax="0">
                    <div class="box-des box5 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/candidateplaced.png') ?>">
                        <span class="count"><?= $stats['under_process'] ?></span>
                        <span class="box-text">Under Process</span>
                    </div>
                </a>
            </div>
            <div class="col-md-6 <?= $org_slug == 'phfleasing' ? '' : 'col-lg-3 inc-height' ?>">
                <a href="/account/education-loans/leads?filter=4" data-pjax="0">
                    <div class="box-des box7 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/jobopportunities.png') ?>">
                        <span class="count"><?= $stats['sanctioned'] ?></span>
                        <span class="box-text">Sanctioned</span>
                    </div>
                </a>
            </div>
            <!--            <div class="col-md-offset-2 col-md-4 col-sm-6">-->
            <!--                <a href="javascript:;" data-pjax = "0">-->
            <!--                    <div class="box-des box6 mt">-->
            <!--                        <img src="-->
            <? //= Url::to('@eyAssets/images/pages/hr-recruiters/intrnship.png') ?><!--">-->
            <!--                        <span class="count">--><? //= "1,50000.00" ?><!--</span>-->
            <!--                        <span class="box-text">Total Sanctioned Amount</span>-->
            <!--                    </div>-->
            <!--                </a>-->
            <!--            </div>-->
            <!--            <div class="col-md-4 col-sm-6">-->
            <!--                <a href="javascript:;" data-pjax = "0">-->
            <!--                    <div class="box-des box4 mt box2set">-->
            <!--                        <img src="-->
            <? //= Url::to('@eyAssets/images/pages/hr-recruiters/candidates.png') ?><!--">-->
            <!--                        <span class="count">--><? //= "15,000.00" ?><!--</span>-->
            <!--                        <span class="box-text">Total Earning</span>-->
            <!--                    </div>-->
            <!--                </a>-->
            <!--            </div>-->
        </div>
    </div>
    <div class="col-md-3">
        <div class="effect thurio <?= $org_slug == 'phfleasing' ? 'tr-height' : '' ?>">
            <h3 class="text-white size-set">Invite Candidate <i data-toggle="tooltip"
                                                                title="This is your personalized invite link which is used to add referral leads direct into your account "
                                                                class="fa fa-question-circle tooltip-text"></i></h3>
            <div class="buttons">
                <?php
                $link = "https://www.empoweryouth.com/education-loans/apply?ref_id=" . $referrer_code;
                ?>
                <a href="javascript:;" class="facebook-f"
                   onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                    <i class="fa fa-facebook-f"></i>
                </a>
                <a href="javascript:;" class="twitter-t"
                   onclick="window.open('<?= Url::to('https://twitter.com/intent/tweet?text=' . $this->title . '&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                    <i class="fa fa-twitter"></i>
                </a>
                <a href="javascript:;" class="linked-l"
                   onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link . '&title=' . $this->title . '&summary=' . $this->title . '&source=' . Url::base(true)); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                    <i class="fa fa-linkedin"></i>
                </a>
                <a href="javascript:;" class="whatsapp-w"
                   onclick="window.open('<?= Url::to('https://api.whatsapp.com/send?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                    <i class="fa fa-whatsapp"></i>
                </a>
                <a href="javascript:;" class="enve-e"
                   onclick="window.open('<?= Url::to('mailto:?&body=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                    <i class="fa fa-envelope"></i>
                </a>
                <a href="javascript:;" class="enve-e"
                   onclick="copyToClipboard()">
                    <i class="fa fa-copy"></i>
                </a>
            </div>
            <div class="wts-ap">
                <!--                <h3>Invite on Whatsapp via Number</h3>-->
                <div class="col-md-12 p0 form-whats">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'whatsapp-form',
                        'fieldConfig' => [
                            'template' => '<div class="form-group">{input}{error}</div>',
                            'labelOptions' => ['class' => ''],
                        ],
                    ]);
                    ?>
                    <?=
                    $form->field($whatsAppmodel, 'phone')->widget(PhoneInput::className(), [
                        'options' => ['class' => 'wts-txt', 'placeholder' => '+91 98 XXXX XXXX'],
                        'jsOptions' => [
                            'allowExtensions' => false,
                            'preferredCountries' => ['in'],
                            'nationalMode' => false,
                        ]
                    ]);
                    ?>
                    <?php ActiveForm::end(); ?>
                    <div class="send"><i class="fa fa-arrow-right"></i></div>
                </div>
            </div>
            <div class="row m-0">
                <div class="col-lg-12">
                    <!--                    <h4 class="text-white">or</h4>-->
                    <div class="pf-field">
                        <input type="text" title="Click to Copy" id="share_manually" onclick="copyToClipboard()"
                               class="form-control hidden" value="<?= $link ?>" readonly>
                        <!--                        <i class="far fa-copy"></i>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        if($org_slug == 'phfleasing'){
    ?>
    <div class="col-md-3">
        <div class="dsa-box <?= $org_slug == 'phfleasing' ? 'tr-height' : '' ?>">
        <h3 class="text-white size-set">Invite DSA
            <i data-toggle="tooltip"  title="This is your personalized invite link which is used to add DSA direct into your account " class="fa fa-question-circle tooltip-text"></i></h3>
            <input type="text" class="link line-clamp" id="dsaLink"
                   value="https://<?= $baseUrl ?>/signup/individual?dsaRefId=<?= $org_id ?> ">
            <a href="" class="create-btn" onclick="copyToDsaLink()">Copy Link</a>
        </div>
    </div>
    <?php
        }
    ?>
    <?php Pjax::end(); ?>
</div>
<div class="row mt-5">
<div class="col-xs-12 col-sm-12">
    <div class="portlet light ">
        <div class="portlet-title tabbable-line">
            <div class="row">
                <div class="col-md-12">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Loan Applications</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?php
                    $filterList = [
                        'all' => 'All',
                        0 => 'New Lead',
                        1 => 'Accepted',
//                        2 => 'Pre Verification',
                        3 => 'Under Process',
                        4 => 'Sanctioned',
//                        5 => 'Disbursed',
                        10 => 'Rejected',
                    ];
                    $jsonFilterList = json_encode($filterList);
                    ?>
                    <ul class="statusFilters" id="status_filters">
                        <?php
                        foreach ($filterList as $key => $filter) {
                            $checked = "";
                            if ($key) {
                                if (!empty($filters)) {
                                    $checked = (in_array($key, $filters)) ? 'checked' : '';
                                } else {
                                    $checked = ($key == "all") ? 'checked' : '';
                                }
                            }
                            ?>
                            <li>
                                <input class="status_filters" id="list_<?= $key ?>" value="<?= $key ?>" type="checkbox"
                                       name="list-loan" <?= $checked ?>/>
                                <label for="list_<?= $key ?>"><?= $filter ?></label>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <div class="tab-content">
                <div class="tab-pane active pos-rel" id="tab_actions_pending">
                    <div id="overflowScroll">
                        <?php
                        Pjax::begin(['id' => 'list-container']);
                        ?>
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
                                            <th class="loanAmount">Lenders</th>
                                            <!--                                            <th class="amountReceived">Amount Received</th>-->
                                            <!--                                            <th class="amountDue">Amount Due</th>-->
                                            <!--                                            <th class="scholarship">Scholarship</th>-->
                                            <th class="degree">Degree</th>
                                            <th class="courseName">Course Name</th>
                                            <!--                                            <th class="collegeName">College/University Name</th>-->
                                            <!--                                            <th class="startDate">Semester</th>-->
                                            <!--                                            <th class="endDate">Year</th>-->
                                            <!--                                            <th class="phoneNumber">Phone Number</th>-->
                                            <!--                                            <th class="applicantEmail">Email Address</th>-->
                                            <th class="city">City</th>
                                            <th class="applicantGender">Gender</th>
                                            <!--                                            <th class="dobwidth">DOB</th>-->
                                            <!--                                            <th class="coApplicantWidth">Co-Applicant</th>-->
                                            <!--                                            <th class="coName">Co-Applicant's Name</th>-->
                                            <!--                                            <th class="coEmployment">Co-Applicant's employment type</th>-->
                                            <!--                                            <th class="coAnnual">Co-Applicant's Annual Income</th>-->
                                            <!--                                            <th class="coApplicantWidth">2nd Co-Applicant</th>-->
                                            <!--                                            <th class="coName">2nd Co-Applicant's Name</th>-->
                                            <!--                                            <th class="coEmployment">2nd Co-Applicant's employment type</th>-->
                                            <!--                                            <th class="coAnnual">2nd Co-Applicant's Annual Income</th>-->
                                            <!--                                            <th class="coApplicantWidth">3rd Co-Applicant</th>-->
                                            <!--                                            <th class="coName">3rd Co-Applicant's Name</th>-->
                                            <!--                                            <th class="coEmployment">3rd Co-Applicant's employment type</th>-->
                                            <!--                                            <th class="coAnnual">3rd Co-Applicant's Annual Income</th>-->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (!empty($loans)) {
                                            $dropDowns = [
                                                0 => 'New Lead',
                                                1 => 'Accepted',
//                                                2 => 'Pre Verification',
                                                3 => 'Under Process',
                                                4 => 'Sanctioned',
//                                                5 => 'Disbursed',
                                                10 => 'Reject',
                                            ];
                                            foreach ($loans as $loan) {
                                                ?>
                                                <tr>
                                                    <td><?= date('d M Y', strtotime($loan['apply_date'])) ?></td>
                                                    <td class="actionColoum">

                                                        <span class="currentState"><?= $loan['loan_status'] ?></span>
                                                        <button class="viewStatus"
                                                                style="display: <?= ($loan['loan_status'] == 'Disbursed') ? 'block' : 'none' ?>"
                                                                onclick="viewStatus()">View Status
                                                        </button>
                                                        <button class="reconsider"
                                                                data-key="<?= $loan['loan_app_enc_id'] ?>"
                                                                style="display: <?= ($loan['loan_status'] == 'Reject') ? 'block' : 'none' ?>"
                                                                onclick="reconsider(this)">Reconsider
                                                        </button>
                                                    </td>
                                                    <td><?= $loan['applicant_name'] ?></td>
                                                    <td><?= $loan['amount'] ?></td>
                                                    <td><?= $loan['assignedLoanProviders'][0]['providerEnc']['name'] ?></td>
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['amount_received'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['amount_due'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['scholarship'] ?><!--</td>-->
                                                    <td><?= $loan['degree'] ?></td>
                                                    <td><?= $loan['course_name'] ?></td>
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['org_name'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['semesters'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['years'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['phone'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['email'] ?><!--</td>-->
                                                    <td><?= $loan['city'] ?></td>
                                                    <td><?= $loan['gender'] ?></td>
                                                    <!--                                                    <td>-->
                                                    <?//= date('d F Y', strtotime($loan['dob'])) ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['loanCoApplicants'][0]['relation'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['loanCoApplicants'][0]['name'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['loanCoApplicants'][0]['employment_type'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['loanCoApplicants'][0]['annual_income'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['loanCoApplicants'][1]['relation'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['loanCoApplicants'][1]['name'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['loanCoApplicants'][1]['employment_type'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['loanCoApplicants'][1]['annual_income'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['loanCoApplicants'][2]['relation'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['loanCoApplicants'][2]['name'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['loanCoApplicants'][2]['employment_type'] ?><!--</td>-->
                                                    <!--                                                    <td>-->
                                                    <?//= $loan['loanCoApplicants'][2]['annual_income'] ?><!--</td>-->
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php Pjax::end(); ?>
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
                <?php
                $form = ActiveForm::begin([
                    'id' => 'sanctioned-form',
                    'options' => ['enctype' => 'multipart/form-data'],
                    'fieldConfig' => [
                        'template' => '<div class="form-group"><label for="number" class="input-group-text">{label}</label>{input}</div>',
                    ],
                ]);
                ?>
                <div class="col-md-9 col-sm-12 noPadd">
                    <div id="loanModalScroll">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6 col-sm-6 padd-20">
                                    <?= $form->field($model, 'file_number')->textInput(['autocomplete' => 'off', 'autofocus' => true]); ?>
                                    <?= $form->field($model, 'loan_app_id', ['template' => '{input}'])->hiddenInput(['id' => 'loan_app_id', 'value' => ""])->label(false); ?>
                                </div>
                                <div class="col-md-6 col-sm-6 padd-20">
                                    <?= $form->field($model, 'loan_amount')->textInput(['autocomplete' => 'off', 'type' => 'number']); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4 col-sm-4 padd-20">
                                    <?= $form->field($model, 'processing_fee')->textInput(['autocomplete' => 'off', 'type' => 'number']); ?>
                                </div>
                                <div class="col-md-4 col-sm-4 padd-20">
                                    <?= $form->field($model, 'total_installments')->textInput(['autocomplete' => 'off', 'type' => 'number']); ?>
                                </div>
                                <div class="col-md-4 col-sm-4 padd-20">
                                    <?= $form->field($model, 'discounting')->textInput(['autocomplete' => 'off', 'type' => 'number', 'placeholder' => 'in %']); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6 col-sm-6 padd-20">
                                    <?= $form->field($model, 'approved_by')->textInput(['autocomplete' => 'off']); ?>
                                </div>
                                <div class="col-md-6 col-sm-6 padd-20">
                                    <?= $form->field($model, 'fldg')->textInput(['autocomplete' => 'off', 'type' => 'number', 'placeholder' => 'in %'])->label('FLDG'); ?>
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
                                        <?php
                                        if ($documents) {
                                            foreach ($documents as $doc) {
                                                $name = str_replace(" ", "_", strtolower($doc->name));
                                                ?>
                                                <tr>
                                                    <td><?= $doc->name ?></td>
                                                    <td><input type="radio"
                                                               name="documents[<?= $doc->document_enc_id ?>]" value="1">
                                                    </td>
                                                    <td><input type="radio"
                                                               name="documents[<?= $doc->document_enc_id ?>]" value="0">
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <?= Html::submitButton('Update', ['class' => 'btn btn-info updateBtn', 'id' => 'updateBtn']); ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>
<?php
$this->registerCss('
.mt-5{
    margin-top: 2.5rem;
}
.tr-height{
    min-height: 194px;
}
.iti{
    width: 100%;
}
#dsaLink{
    pointer-events: none;
    border-radius: 5px;
    padding: 6px;
    height: 39.98px;
    margin: 4px 0;
}
.line-clamp {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;  
    overflow: hidden;
}
.dsa-box {
    background: black;
    padding: 0 15px;
    text-align: center;
    border-radius: 10px;
    max-height: 196px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}
.dsa-box h4 {
    color: #fff;
    font-size: 22px;
    font-weight: 800;
    margin: 0;
}
.dsa-box a.create-btn {
    background: #ff7803;
    color: #fff;
    padding: 8px 20px;
    display: inline-block;
    margin-top: 15px;
    border-radius: 5px;
}
.dsa-box p.link{
    height: 28px;
    overflow: hidden;
    background: #fff;
    border-radius: 4px;
    padding: 0 6px;
    line-height: 25px;
}
.tooltip-text{
    cursor:pointer;
}
.effect {
  width: 100%;
}
.effect .buttons {
  display: block;
  padding: 10px 0px;
}
.effect a {
  text-decoration: none !important;
  width: 35px;
  height: 35px;
  display: inline-block;
  border-radius: 50%;
  margin: 0 3px;
  font-size: 17px;
  overflow: hidden;
  position: relative;
  color: #fff;
  border: 2px solid #fff;
}
.effect a i {
  position: relative;
  z-index: 3;
}
.effect a i {    
    display: flex !important;
    align-items: center;
    justify-content: center;
    height: 100%;
    line-height: 0;
}
.effect a.facebook-f:hover{
    background:#3b5998;
    border-color:#3b5998;
} 
.effect a.twitter-t:hover{
    background:#6699FF;
    border-color:#6699FF;
} 
.effect a.linked-l:hover{
    background:#0e76a8;
    border-color:#0e76a8;
}
.effect a.whatsapp-w:hover{
    background:#25D366;
    border-color:#25D366;
}
.effect a.enve-e:hover{
    background:#00a0e3;
    border-color:#00a0e3;
}

.effect.thurio {
    background-color: #000;
    text-align: center;
    padding: 1px 10px;
    border-radius:10px;
}
.size-set {
    font-size: 18px;
    font-weight: bold;
}

.text-white {
    color: #ffffff;
}
.wts-ap {
    position: relative;
}
.wts-ap h3 {
    margin: 0;
    font-size: 14px;
    color: #fff;
    margin-bottom: 8px !important;
    font-family: roboto;
}
.send {
    position: absolute;
    top: 2px;
    right: 10px;
    font-size: 22px;
    cursor: pointer;
}
.wts-ap input {
    font-family: roboto;
    width: 100%;
    margin: auto;
    height: 40px;
    border-radius: 6px;
    padding: 5px 10px;
}
.form-group.field-whatsappshareform-phone, .field-whatsappshareform-phone > .form-group {
    margin-bottom: 0;
}
.pf-field {
    float: left;
    width: 100%;
    position: relative;
}
.pf-field > input {
    height: 56px;
    float: left;
    width: 100%;
    border: 2px solid #e8ecec;
    margin-bottom: 10px;
    margin-top: 10px;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    padding: 14px 45px 14px 15px;
    background: #ffffff !important;
    font-family: Open Sans;
    font-size: 13px;
    font-weight: 400;
    color: #101010;
    line-height: 24px;
    cursor: pointer;
}
.pf-field > i {
    position: absolute;
    right: 20px;
    top: 10px;
    font-size: 20px;
    color: #848484;
    line-height: 56px;
    cursor: pointer;
}
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
.loanAction, .loanPurpos{
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
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    height: 90px;
    border-radius: 10px;
}
.mt{margin-bottom:15px;}
.box-des img{
   position: absolute;
   max-width: 34px;
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
    height: 65vh;
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
.p0{
    padding-left: 0px !important;
    padding-right: 0px !important; 
}
.intl-tel-input{
    width: 100% !important;
}
@media (min-width: 1200px) and (max-width: 1317px){
    .inc-height .box-des{
        height: 199px;
    }
}
@media only screen and (min-width: 1318px){
    .inc-height .box-des{
        height: 157px;
    }
}
// @media (min-width: 768px) and (max-width: 991px){
//     .widget-row{
//         height: 220px;
//     }
// }

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
    
    .dsa-box {
        margin-top: 10px;
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
var filterList = $jsonFilterList;
$(document).on('change', '.status_filters', function(e) {
    var ths = $(this);
    var thsValue = ths.val();
    var obj = $('#status_filters').find('.status_filters');
    var len = obj.length;
    
    // var parent = ths.parent();
    // var childrens = parent.find('li > input');
    var list = "";
    $.each(filterList, function (k, v) {
        var data = $('#list_' + k);
        if(thsValue == 'all'){
            data.prop('checked', false);
            $('#list_all').prop('checked', true);
        } else {
            $('#list_all').prop('checked', false);
        }
        if(data.is(":checked")){
            if(list == ""){
                list = k;
            } else {
                list = list +','+ k;
            }
        }
    });
    var cur_params = '/account/education-loans/leads';
    if(list){
        history.pushState('data', 'title', cur_params + '?filter=' + list);
    } else {
        history.pushState('data', 'title', cur_params);
        $('#list_all').prop('checked', true);
    }
    $.pjax.reload({container: '#list-container', async: false});
});

$(document).on('keypress','.wts-txt',function(e) {
    if(e.which == 13) {
        var val = $(this).val();
        var location = "$link";
        if(val.length < 8){
            alert('Enter Valid Number')
        }
        else {
             window.open('https://api.whatsapp.com/send?phone='+val+'&text=' + location);
        }
        $(this).val('');
    } else {
        var iKeyCode = (e.which) ? e.which : e.keyCode;
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57) && iKeyCode != 43){
            return false;
        }
        // return true;
    }
});
$(document).on('submit','#whatsapp-form',function(e) {
  e.preventDefault();
  return false;
});
$('.send').click(function () {        
    var val = $('.wts-txt').val();
    var location = "$link";
       if(val.length < 10){
            alert('Enter Valid Number')
        }
        else {
             window.open('https://api.whatsapp.com/send?phone='+val+'&text=' + location);
        }
        $('.wts-txt').val('');
});
JS;
$this->registerJS($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
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

    function reconsider(e) {
        var status = 0;
        var id = e.getAttribute('data-key');
        let parElement = e.closest('.actionColoum');
        let currentState = parElement.querySelector('.currentState');
        currentState.innerText = 'New Lead';
        parElement.querySelector('.reconsider').style.display = "none";
        parElement.querySelector('.nextState').style.display = "block";
        // parElement.querySelector('.dropdown').style.display = "block";
        changeStatus(id, status, 1);
        setTimeout(function () {
            $.pjax.reload({container: '#list-container', async: false});
        }, 500);
    }

    function nextRound(e) {
        let currentRoundName = e.value;
        let parElement = e.closest('.actionColoum');
        let currentState = parElement.querySelector('.currentState');
        currentState.innerText = currentRoundName;
        var status = e.getAttribute('data-value');
        var id = e.getAttribute('data-key');
        changeStatus(id, status, 0);
        if (currentRoundName == 'Sanctioned') {
            sanctionModal.style.display = "block"
        }
        if (currentRoundName == 'Disbursed') {
            parElement.querySelector('.nextState').style.display = "none";
            parElement.querySelector('.dropdown').style.display = "none";
        }

        if (currentRoundName == 'Reject') {
            parElement.querySelector('.nextState').style.display = "none";
            parElement.querySelector('.dropdown').style.display = "none";
            parElement.querySelector('.reconsider').style.display = "block";
        }
    }

    function changeStatus(id, status, reconsider) {
        $.ajax({
            url: '/account/education-loans/change-status',
            method: "POST",
            data: {id: id, status: status, reconsider: reconsider},
            beforeSend: function () {
                $('#loan_app_id').val(id);
            },
            success: function (res) {
                if (res.status == 200) {
                    toastr.success(res.title, res.message);
                } else if (res.status == 203) {
                    toastr.warning(res.title, res.message);
                } else {
                    toastr.error(res.title, res.message);
                }
            },
            complete: function () {
                $.pjax.reload({container: '#stat-container', async: false});
            }
        });
    }

    function nextPhase(e) {
        let parElement = event.currentTarget.parentElement;
        let curElement = parElement.getElementsByClassName('currentState');
        let curPhase = curElement[0].innerHTML;
        let phases = parElement.getElementsByClassName('actionBtn');
        let pVal = [];
        for (let i = 0; i < phases.length; i++) {
            pVal.push(phases[i].value);
            let nextIndex = pVal.indexOf(curPhase) + 1;
            var nextElem = pVal[nextIndex];
            curElement[0].innerHTML = nextElem;

            if (nextElem == 'Sanctioned') {
                sanctionModal.style.display = "block"
            }

            if (nextElem == 'Disbursed') {
                parElement.querySelector('.nextState').style.display = "none";
                parElement.querySelector('.dropdown').style.display = "none";
            }

        }
        var status = nextElem;
        var id = e.getAttribute('data-key');
        switch (status) {
            case 'New Lead' :
                status = 0;
                break;
            case 'Accepted' :
                status = 1;
                break;
            case 'Pre Verification' :
                status = 2;
                break;
            case 'Under Process' :
                status = 3;
                break;
            case 'Sanctioned' :
                status = 4;
                break;
            case 'Disbursed' :
                status = 5;
                break;
            case 'Reject' :
                status = 10;
                break;
            default :
                return false;
        }
        changeStatus(id, status, 0);
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

    function copyToClipboard() {
        $('#share_manually').removeClass('hidden');
        var copyText = document.getElementById("share_manually");
        copyText.select();
        document.execCommand("copy");
        toastr.success("", "Copied");
        $('#share_manually').addClass('hidden');
    }

    function copyToDsaLink(){
        var copyLink = document.getElementById("dsaLink");
        copyLink.select();
        document.execCommand("copy");
        toastr.success("", "Copied");
    }
</script>
