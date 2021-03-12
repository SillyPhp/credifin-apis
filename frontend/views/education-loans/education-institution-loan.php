<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <section class="study-in-usa-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Education Institution Loan</h1>
                    <p>To Lead the Way to A Brighter Future.</p>
                    <ul>
                        <li><a href="#contact" class="apply-now btn-orange">Enquire Now</a></li>
                        <!--                    <li><a href="/education-loans/apply" class="apply-now">Apply Now</a></li>-->
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="edu-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="how-works-heading">Education Institution Loan</div>
                </div>
                <div class="loan-data-set">
                    <p>A vision to change the education system is what you need to have in order to collaborate with us!
                        We are here to help you in raising the education sector with unprecedented quality.</p>
                    <p>We are offering a wide range of loans for different educational institutes. With competitive
                        pricing and flexible payment structures, we believe in rapid development.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="why-edu-loan">
        <div class="container">
            <div class="row">
                <div class="why-loan">
                    <div class="col-md-4">
                        <div class="why-back">
                            <h1>Why Education Institution Loan?</h1>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="why-points row">
                            <div class="col-md-6 why-p">
                                <i class="fas fa-graduation-cap"></i>
                                <p>To finance the working capital of the Education Institutes.</p>
                            </div>
                            <div class="col-md-6 why-p">
                                <i class="fas fa-percent"></i>
                                <p>To provide consolidation of liabilities to land enhancements.</p>
                            </div>
                            <div class="col-md-6 why-p">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <p>To improve teaching methodology and goodwill.</p>
                            </div>
                            <div class="col-md-6 why-p">
                                <i class="fas fa-cogs"></i>
                                <p>To upgrade an education institution to exceed the set standards.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="works-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="how-works-heading">How It Works</div>
                </div>
                <div class="works-set">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="works-main set-first">
                            <div class="works-logo set-one">
                                01
                            </div>
                            <div class="works-text">Submit your login details and initial processing documents.</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="works-main set-second">
                            <div class="works-logo set-two">
                                02
                            </div>
                            <div class="works-text">Eligibility criteria will be accessed and verified.</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="works-main set-third">
                            <div class="works-logo set-three">
                                03
                            </div>
                            <div class="works-text">Submission of Balance documents by the customer.</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="works-main set-fourth">
                            <div class="works-logo set-four">
                                04
                            </div>
                            <div class="works-text">Completion of Technical, Legal and Financial Due Diligence.</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="works-main set-fifth">
                            <div class="works-logo set-five">
                                05
                            </div>
                            <div class="works-text">Finalization and Execution of Loan.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?= $this->render('/widgets/loan-table') ?>
<?= $this->render('/widgets/education-loan-faqs'); ?>
<?= $this->render('/widgets/loan-form-detail',[
        'model' =>$model
]); ?>

<?php
$this->registerCss('
.study-in-usa-bg {
	background: url(' . Url::to('@eyAssets/images/pages/education-loans/edu-in.png') . ');
	min-height: 550px;
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
.loan-data-set {
	text-align: center;
	font-size: 16px;
	font-family: roboto;
	margin-bottom: 40px;
}
.works-sec, .edu-sec{
    margin:30px 0;
}
.how-works-heading {
	text-align: center;
	margin: 0 0 20px;
	font-size: 28pt;
	font-family: lobster;
}
.works-set {
	display: flex;
	justify-content: center;
	align-items: center;
	width: 100%;
	flex-wrap: wrap;
}
.works-main {
	display: flex;
	justify-content: space-between;
	align-items: center;
	flex-wrap: wrap;
	box-shadow: 0px 15px 10px -15px #111;
	padding: 20px;
	border-radius: 70px;
	color: #fff;
	margin-bottom:30px;
}
.set-first{
    background-image: linear-gradient(to bottom right, #000046 0%, #1CB5E0 85%);
}
.set-one{
	color: #19a5d2;
	box-shadow: inset 0 0 4px #19a5d2;
}
.set-second {
	background-image: linear-gradient(to bottom right, #F2994A 0%, #F2C94C 85%);
}
.set-two {
	color: #F2C94C;
	box-shadow: inset 0 0 4px #F2C94C;
}
.set-third {
	background-image: linear-gradient(to bottom right, #44A08D 0%, #093637 85%);
}
.set-three {
	color: #093637;
	box-shadow: inset 0 0 4px #093637;
}
.set-fourth {
	background-image: linear-gradient(to bottom right, #4ecdc4 0%, #556270 110%);
}
.set-four {
	color: #4ecdc4;
	box-shadow: inset 0 0 4px #4ecdc4;
}
.set-fifth {
	background-image: linear-gradient(to bottom right, #A770EF 0%, #FDB99B 85%);
}
.set-five {
	color: #FDB99B;
	box-shadow: inset 0 0 4px #FDB99B;
}
.works-logo {
	flex-basis: 15%;
	text-align: center;
	background-color: #fff;
	padding: 5px;
	border-radius: 70px;
	font-size: 20px;
	font-family: roboto;
	font-weight: 700;
}
.works-text {
	flex-basis: 80%;
	font-size: 14px;
	font-family: roboto;
	font-weight: 500;
}
.why-edu-loan {
	background-color: #f7f7f7;
	padding: 40px 0;
}
.why-back {
	background-color: #00a0e3;
	padding: 35px;
}
.why-back h1 {
	font-size: 45px;
	color: #fff;
	font-family: lora;
}
.why-points {
	margin-top: 70px;
	background-color: #fff;
	margin-left: -70px;
}
.why-p {
	border: 1px solid #eee;
	padding: 30px 40px;
	font-size: 16px;
    font-family: roboto;
}
.why-p i {
	font-size: 40px;
	margin-bottom: 20px;
	color: #ff7803;
}
.why-p p {
	margin: 0;
}
@media only screen and (max-width: 991px) {
.why-points {
	margin: -30 px 20px;
}
.why-back h1{
    text-align:center;
}
}
@media only screen and (max-width: 768px) {
.why-back h1 {
	font-size: 34px;
}
}
');