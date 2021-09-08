<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<section class="faq-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <div class="faq-text">
                    <h1>Frequently Asked Questions</h1>
                    <p>
                        We're here to answer your questions, and we've put together some of the most frequently
                        asked questions regarding student financing program
                    </p>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 f-flex">
                <div class="faq-vector">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/girl-with-question.png') ?>"
                         alt=""/>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="question">
                    <ul>
                        <li>
                            <span class="boldfont">Q) Why is there a need for student financing program?</span><br>
                            A) Student financing program is needed to provide much-needed financial
                            support to enable any deserving student to pursue their education and enhance
                            his/her career prospects.
                        </li>
                        <li>
                            <span class="boldfont">Q) What are the eligibility criteria to avail student financing program?</span><br>
                            A) Any Indian national between the ages of 18-45, wishing to pursue their educational
                            program is eligible to apply for a loan in partnership with EmpowerYouth.com.
                        </li>
                        <li>
                            <span class="boldfont">Q) What is the schedule of repayment for loan availed under Student Financing program?</span><br>
                            A) The repayment schedule will commence immediately from the date of disbursal with
                            the candidate paying the first instalment on that date itself.
                        </li>
                        <li>
                            <span class="boldfont"> Q) Will there be any moratorium which will be provided?</span><br>
                            A) There will be no moratorium which will be provided.
                            The repayment starts immediately from the next month of disbursement.
                        </li>
                        <li>
                            <span class="boldfont">Q) Do the student have to pay the seat booking amount to book their seat or can it be
                                adjusted with the total loan amount?</span><br>
                            A) The student doesn’t have to pay for booking amount as it can be adjusted in the loan
                            amount.
                        </li>
                        <li>
                            <span class="boldfont">Q) Can students avail loans for 15, 24 or 36 months?</span><br>
                            A) No, the student gets only 2 options which are 5 or 10 months to repay the loan.
                        </li>
                        <li>
                            <span class="boldfont">Q) What will happen in case the parents are not working?</span><br>
                            A) If the student’s parents are not working, then any of the guardian
                            of the student can become a co-applicant.
                        </li>
                        <li>
                            <span class="boldfont">Q) What will be the role of the guardian of the student in the entire process?</span><br>
                            A) The parent(s) or guardian of the applicant would be treated as a Co-Applicant
                            of this Education Loan if the applicant is not working. His or her role would be,
                            necessarily, like the Primary Debtor.
                        </li>
                        <li>
                            <span class="boldfont">Q) What are the documents required to apply for the loan?</span><br>
                            A) As mentioned above in the document.
                        </li>
                        <li>
                            <span class="boldfont"> Q) What will happen if the student asks for a refund?</span><br>
                            A) If a student asks for a refund before the commencement of the classes, the
                            institution will refund the amount under their guidelines to the lending institute
                            and the remaining amount is to be repaid by the student to complete the loan.
                        </li>
                        <li>
                            <span class="boldfont">Q) What does eNACH mean?</span><br>
                            A) eNACH is the electronic process of helping the banks, financial institutions and
                            other government bodies to provide automated payment services. Once the user signs
                            the eNACH or electronic NACH form, he gives permission to the concerned authority to
                            debit the said amount from his bank every fixed day of the month.
                        </li>
                        <li>
                            <span class="boldfont">Q) What will happen if the eNACH option is not possible?</span><br>
                            A) If the eNACH option is not possible/allowed, then the physical NACH process needs
                            to be followed.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.faq-bg {
    background: url(' . Url::to('@eyAssets/images/pages/education-loans/bluebgg.png') . ');
	background-repeat: no-repeat;
	min-height: 350px;
	max-height: 350px;
}
.boldfont {
font-weight: bold;
}
.f-flex {
    display: flex;
    justify-content: flex-start;
    align-items: flex-end;
    min-height: 330px;
    padding-left: 80px;
}
.faq-text {
    margin-top: 100px;
}
.faq-text p {
    color: #fff;
    font-size: 18px;
    font-family: roboto;
    letter-spacing: 0.3px;
}
.faq-text h1 {
    font-size: 40px;
    color: #f2f2f5;
    font-family: lobster;
    letter-spacing: 0.3px;
}
.faq-vector img {
    width: 100%;
    max-width: 250px;
}
.question li {
    margin-bottom: 20px;
    font-family: roboto;
    font-size: 16px;
    letter-spacing: 0.3px;
    color: #000;
}
.footer {
    margin-top: 0px !important;
}
@media screen and (max-width: 768px) and (min-width: 568px){
.faq-text {
    text-align: center;
}
.faq-vector {
    display: none;
}
}
@media screen and (max-width: 567px) and (min-width: 320px){
.faq-text {
    text-align: center;
}
.faq-text h1 {
    font-size: 32px;
}
.faq-text p {
    font-size: 16px;
}
.faq-vector {
    display: none;
}
}
');
