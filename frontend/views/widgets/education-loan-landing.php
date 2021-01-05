<?php

use yii\helpers\Url;
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="loan-heading">Discover the Benefits of Education Loan</h1>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="loan-box">
                    <div class="loan-logo"><img alt="Education Loan, education loan with low interest rates, low interest rates for education loan, student loan interest rates, apply for Education loan, education loan interest rate" src="<?= Url::to('@eyAssets/images/pages/educational-loans/interest-free-loan.png') ?>"></div>
                    <h2>Low Rate of Interest</h2>
                    <p>Apply for loans at lower interest rates and avail of better borrowing terms thus decreasing the financial burden off you.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="loan-box">
                    <div class="loan-logo"><img alt="Education Loan, education loan with low interest rates, low interest rates for education loan, student loan interest rates, apply for Education loan, education loan interest rate" src="<?= Url::to('@eyAssets/images/pages/educational-loans/coll.png') ?>"></div>
                    <h2>Online Application</h2>
                    <p>Apply from the comfort of your home with quick, simple and easy documentation process and get fast approval of your application.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="loan-box">
                    <div class="loan-logo"><img alt="Education Loan, education loan with low interest rates, low interest rates for education loan, student loan interest rates, apply for Education loan, education loan interest rate" src="<?= Url::to('@eyAssets/images/pages/educational-loans/quick.png') ?>"></div>
                    <h2>Quick Disbursement</h2>
                    <p>with the state of the art system, we strive to complete the disbursement of loan as soon as possible.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="loan-req">
                    <div class="loan-data">
                        <h2 class="loan-txtt">Get your application approved quickly with EmpowerYouth.com<br> Launch your loan request today.</h2>
                        <div class="loan-btn">
                            <a href="/education-loans">Apply Now!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.loan-heading {
	font-size: 25pt;
	font-family: lobster;
	text-align: center;
}
.loan-box {
	box-shadow: 0 1px 24px rgba(0, 0, 0, 0.2);
	padding: 15px;
	margin: 20px 0;
	border-radius: 8px;
}
.loan-logo img {
	width: 50px;
}
.loan-box h2 {
	font-size: 20px;
	font-family: lora;
	font-weight: 600;
	margin:8px 0 2px;
}
.loan-box p {
	font-size: 15px;
	font-family: roboto;
	min-height: 75px;
    line-height: 25px;
}
.loan-req{
    background:url(' . Url::to('@eyAssets/images/pages/education-loans/skyblue-strip.png') . ');  
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    border-radius: 8px;
    margin: 10px 0px;
}
.loan-data {
	display: flex;
	align-items: center;
	justify-content: space-evenly;
	padding: 30px 20px;
}
.loan-txtt {
	font-size: 20px;
	color: #fff;
	font-family: lora;
	margin:0;
}
.loan-btn a {
	color: #fff;
	background-color: #ff7803;
	padding: 10px 20px;
	border-radius: 27px;
	font-size: 18px;
	font-family: roboto;
	font-weight: 500;
	transition: ease-out .3s;
}
.loan-btn:hover a{
    box-shadow:0 0 5px #fff;
}
@media only screen and (max-width: 991px) {
    .loan-txtt {
	    flex-basis:70%;
    }
    .loan-btn{
        flex-basis:30%;
    }
    .loan-box p{
        min-height: 125px;
    }
}
@media only screen and (max-width: 768px)
{
    .loan-data{
        display:block;
    }
    .loan-txtt{
        margin-bottom:20px;
    }
    .loan-box p{
        min-height: auto;
    }
}
@media only screen and (max-width: 550px){
    .loan-heading {
        font-size: 25px;
    }
    .loan-box h3 {
        font-size: 20px;
    }
    .loan-txtt {
        font-size: 17px;
    }
    .loan-btn a{
        font-size:16px;
    }
}
');
