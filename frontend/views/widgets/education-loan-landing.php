<?php

use yii\helpers\Url;
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="loan-heading">Discover the Benefits of Education Loan</div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="loan-box">
                    <div class="loan-logo"><img src="<?= Url::to('@eyAssets/images/pages/educational-loans/interest.png') ?>"></div>
                    <h3>Interest- Free Loans</h3>
                    <p>We are providing loans at 0% interest rate to the students without any hassle.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="loan-box">
                    <div class="loan-logo"><img src="<?= Url::to('@eyAssets/images/pages/educational-loans/coll.png') ?>"></div>
                    <h3>Collateral Free Loans</h3>
                    <p>The applicant does not need to provide any security or asset to the company for the generation of loans.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="loan-box">
                    <div class="loan-logo"><img src="<?= Url::to('@eyAssets/images/pages/educational-loans/quick.png') ?>"></div>
                    <h3>Quick disbursement</h3>
                    <p>We are making great efforts to complete the disbursement of loans in less than 10 days.</p>
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
                        <div class="loan-txtt">Accelerate the lending process with EmpowerYouth.com <br> Launch your loan request today.</div>
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
.loan-box h3 {
	font-size: 22px;
	font-family: lora;
	font-weight: 600;
}
.loan-box p {
	font-size: 16px;
	font-family: roboto;
	min-height:82px;
}
.loan-req{
    background:url(' . Url::to('@eyAssets/images/pages/educational-loans/blue-strip.png') . ');  
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
}
.loan-btn a {
	color: #fff;
	background-color: #10b66a;
	padding: 10px 20px;
	border-radius: 27px;
	font-size: 18px;
	font-family: roboto;
	font-weight: 500;
}
@media only screen and (max-width: 991px) {
    .loan-txtt {
	    flex-basis:70%;
    }
    .loan-btn{
        flex-basis:30%;
    }
    .loan-box p{
        min-height: 136px;
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
