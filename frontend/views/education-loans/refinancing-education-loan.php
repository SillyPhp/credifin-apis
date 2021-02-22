<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <section class="study-in-usa-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Refinancing Education Loan</h1>
                    <p>So you’ve taken a loan. What if we have cool options to slash your outstanding?</p>
                    <ul>
                        <li><a href="#contact" class="apply-now btn-orange">Enquire Now</a></li>
                        <!--                    <li><a href="/education-loans/apply" class="apply-now">Apply Now</a></li>-->
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="loan-data-entry">
                        <h3>IT'S TIME TO SAVE ON YOUR STUDENT LOANS</h3>
                        <p>Are you tired of making interest rate payments that are sky high? Do you want to reduce your
                            monthly payments on your existing education loan? Or are you looking to shift into an
                            income-based repayment program?</p>
                        <p>If you have answered yes to any of these questions, a refinancing loan is the best option for
                            you.</p>
                        <p>When you choose to refinance your loan, you get good credit for the changes in your financial
                            profile due to advances in career and income. So, take the first step towards refinancing
                            your student loans with EmpowerYouth. We offer student loan refinancing at better rates, tailored
                            options and repayment plans that fit your life.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="types-head">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="type-heading">Types Of Refinancing</h2>
                </div>
                <div class="col-md-3">
                    <div class="types-ref">
                        <div class="types-text">Rate and Term Refinancing</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="types-ref">
                        <div class="types-text">Cash-out refinancing</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="types-ref">
                        <div class="types-text">Cash-in refinancing</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="types-ref">
                        <div class="types-text">Streamline refinancing</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="when-head">When To Refinance Your <span>Education Loan?</span></h2>
                </div>
                <div class="when-points">
                    <div class="col-md-3">
                        <div class="when-main-box">
                            <i class="fas fa-percentage"></i>
                            <p>A lender is offering an attractive Rate of Interest.</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="when-main-box">
                            <i class="fas fa-coins"></i>
                            <p>A significant rise in your income.</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="when-main-box">
                            <i class="fas fa-credit-card"></i>
                            <p>Improved credit score</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="when-main-box">
                            <i class="fas fa-receipt"></i>
                            <p>If you want to extend your loan repayment tenure.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $this->render('/widgets/loan-table') ?>
<?= $this->render('/widgets/education-loan-faqs');?>
<?php
$this->registerCss('
.study-in-usa-bg {
	background: url(' . Url::to('@eyAssets/images/pages/education-loans/finance.png') . ');
	min-height: 500px;
	background-repeat: no-repeat;
	background-size: cover;
	display: flex;
	align-items: center;
	position: relative;
//	text-align: center;
	max-height: 700px;
	background-position:left bottom;
}
.study-in-usa-bg h1 {
	font-size: 35px;
	margin-bottom: 10px;
	color: #fff;
	font-weight: bold;
	font-family: lora;
}
.study-in-usa-bg p {
	font-size: 20px;
	font-family: roboto;
	color: #fff;
	padding: 0 0 18px;
	line-height: 30px;
	max-width: 500px;
}
.study-in-usa-bg ul li{
    display: inline;
    margin-right: 10px;
}
.apply-now {
	padding: 10px 15px;
	background: #00A0E3;
	color: #fff;
	border: 1px solid #00A0E3;
	box-shadow: 0 5px 10px rgba(0,0,0,.3);
	font-size: 16px;
	font-family: roboto;
	border-radius: 4px;
	display: inline-block;
	width: 150px;
	text-align:center;
}
.btn-orange{
    background: #ff7803 !important;
    border: 1px solid #ff7803 !important;
}
.apply-now:hover{
    background: #ff7803; 
    color: #fff;
    border: 1px solid #ff7803;
    transition: .3s ease;
}
.btn-orange:hover{
    background: #00a0e3 !important;
    border: 1px solid #00a0e3 !important;
}
.loan-data-entry {
	text-align: center;
}
.loan-data-entry h3 {
	font-weight: bold;
	font-family: lora;
	font-size: 28px;
	margin-bottom: 20px;
}
.loan-data-entry p {
	font-size: 16px;
	font-family: roboto;
	line-height: 26px;
	margin-bottom: 15px;
}
.types-head {
	background-color: #00a0e3;
	text-align: center;
	margin: 40px 0 10px;
	padding: 20px 0 40px 0;
}
.type-heading {
	margin: 0 0 25px;
	color: #fff;
	font-family: lora;
	font-weight: bold;
	font-size: 30px;
}
.types-ref {
	background-color: #fff;
	border-radius: 2px;
	padding: 15px;
	margin-bottom: 20px;
	box-shadow: 0px 0px 9px 1px rgba(0,0,0,0.3);
	font-family: roboto;
	color: #000;
	transition: ease-in-out .3s;
	cursor: pointer;
}
.types-ref:hover {
	transform: translatey(-4px);
}
.when-head {
	text-align: center;
	font-weight: bold;
	font-family: lora;
	margin-bottom: 30px;
	font-size: 30px;
}
.when-head span {
	color: #ff7803;
}
.when-main-box {
	box-shadow: 0 0 15px -4px rgba(0,0,0,0.2);
	border-radius: 0 30px 0 30px;
	padding: 20px;
	min-height: 154px;
	margin-bottom:20px;
}
.when-main-box i {
	font-size: 45px;
	color: #ff7803;
	margin-bottom: 15px;
}
.when-main-box p {
	margin: 0;
	font-family: roboto;
	font-size: 16px;
}
');
