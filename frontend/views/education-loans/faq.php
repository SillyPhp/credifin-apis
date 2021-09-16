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
                         alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="ques-box">
                    <div class="number">01</div>
                    <div class="ques">
                        <p><span class="boldfont">Why is there a need for student financing program?</span></p>
                        <p class="ans">Student financing program is needed to provide much-needed financial support to
                            enable any deserving student to pursue their education and enhance his/her career
                            prospects.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="ques-box">
                    <div class="number">02</div>
                    <div class="ques">
                        <p><span class="boldfont">What are the eligibility criteria to avail student financing program?</span></p>
                         <p class="ans"> Any Indian national between the ages of 18-45, wishing to pursue their educational
                            program is eligible to apply for a loan in partnership with EmpowerYouth.com.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="ques-box">
                    <div class="number">03</div>
                    <div class="ques">
                        <p><span class="boldfont">What is the schedule of repayment for loan availed under Student
                              Financing program?</span></p>
                       <p class="ans">The repayment schedule will commence immediately from the date of disbursal with the
                            candidate paying the first instalment on that date itself.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="ques-box">
                    <div class="number">04</div>
                    <div class="ques">
                        <p><span class="boldfont">Will there be any moratorium which will be provided?</span></p>
                        <p class="ans">There will be no moratorium which will be provided. The repayment starts
                            immediately from the next month of disbursement.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="ques-box">
                    <div class="number">05</div>
                    <div class="ques">
                        <p><span class="boldfont">Do the student have to pay the seat booking amount to book their seat
                          or can it be adjusted with the total loan amount?</span></p>
                        <p class="ans">The student doesn’t have to pay for booking amount as it can be adjusted in the loan amount.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="ques-box">
                    <div class="number">06</div>
                    <div class="ques">
                        <p><span class="boldfont">Can students avail loans for 15, 24 or 36 months?</span></p>
                        <p class="ans">No, the student gets only 2 options which are 5 or 10 months to repay the loan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="ques-box">
                    <div class="number">07</div>
                    <div class="ques">
                        <p><span class="boldfont">What will happen in case the parents are not working?</span></p>
                        <p class="ans"> If the student’s parents are not working, then any of the guardian of the student
                            can become a co-applicant.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="ques-box">
                    <div class="number">08</div>
                    <div class="ques">
                        <p><span class="boldfont">What will be the role of the guardian of the student in the entire process?</span></p>
                        <p class="ans">The parent(s) or guardian of the applicant would be treated as a Co-Applicant of this Education Loan
                            if the applicant is not working. His or her role would be, necessarily, like the Primary Debtor.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="ques-box">
                    <div class="number">09</div>
                    <div class="ques">
                        <p><span class="boldfont">What are the documents required to apply for the loan?</span></p>
                         <p class="ans">As mentioned above in the document.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="ques-box">
                    <div class="number">10</div>
                    <div class="ques">
                        <p><span class="boldfont">What will happen if the student asks for a refund?</span></p>
                        <p class="ans">If a student asks for a refund before the commencement of the classes, the institution
                            will refund the amount under their guidelines to the lending institute and the
                            remaining amount is to be repaid by the student to complete the loan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="ques-box">
                    <div class="number">11</div>
                    <div class="ques">
                        <p><span class="boldfont">What does eNACH mean?</span></p>
                       <p class="ans"> eNACH is the electronic process of helping the banks and
                        other financial & government bodies to provide automated payment services. When user signs
                        the eNACH form, he gives permission to the concerned authority to debit the said
                        amount from his bank every month.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="ques-box">
                    <div class="number">12</div>
                    <div class="ques">
                        <p><span class="boldfont">What will happen if the eNACH option is not possible?</span></p>
                        <p class="ans">If the eNACH option is not possible/allowed, then the physical NACH process needs to be followed.</p>
                    </div>
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
	background-size: cover;
	min-height: 350px;
	max-height: 350px;
}
.boldfont {
    font-weight: bold;
    font-size: 16px;
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
.footer {
    margin-top: 0px !important;
}
.ans {
    line-height: 22px;
    font-size: 14px;
}
.ques-box {
    width: 100%;
    height: 230px;
    display: inline-block;
    background-color: #fbfbfb;
    padding: 20px;
    box-shadow: 5px 5px 10px rgb(138 131 131 / 18%);
    border-radius: 4px;
    margin: 20px 0 30px;
}
.number {
    font-size: 30px;
    font-family: roboto;
    font-weight: 600;
    color: #00a0e3;
    padding-right: 15px;
}
.ques p {
    color: #000;
    font-family: roboto;
    letter-spacing: 0.3px;
}
@media screen and (max-width: 998px) and (min-width: 768px){
.ques-box {
 height: 280px;
}
}
@media screen and (max-width: 768px) and (min-width: 568px){
.faq-text {
    text-align: center;
}
.faq-vector {
    display: none;
}
.ques-box {
 height: 260px;
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
.ques-box {
 height: 260px;
}
}
');
