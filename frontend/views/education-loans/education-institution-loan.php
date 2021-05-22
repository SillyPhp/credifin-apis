<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <section class="study-in-usa-bg">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Education Institution Loan</h1>
                    <p>To Support Your Vision of A Better Tomorrow.</p>
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
                    <div class="heading-style edu-ins">Education Institution Loan</div>
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
    <?= $this->render('/widgets/loan-why-empower-youth')?>
    <section class="works-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style edu-ins">How It Works</div>
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

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style"><?= Yii::t('frontend', 'Our Lending Partners'); ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png') ?>" alt="Agile Finserv">
                        </div>
                        <div class="lp-name">Agile Finserv</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png') ?>"
                                 alt="Avanse Financial Services">
                        </div>
                        <div class="lp-name">Avanse Financial Services</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/incred_logo.png') ?>"
                                 alt="InCred">
                        </div>
                        <div class="lp-name">InCred</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/ezcapital.png') ?>" alt="EZ Capital">
                        </div>
                        <div class="lp-name">EZ Capital</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?= $this->render('/widgets/education-loan-faqs'); ?>
<?= $this->render('/widgets/loan-form-detail',[
        'model' =>$model
]); ?>
<?= $this->render('/widgets/press-releasee') ?>
<?= $this->render('/widgets/loan-strip') ?>

<?php
$this->registerCss('
.footer {
    margin-top: 0px !important;
}
.edu-ins {
    text-align: center;
}
.study-in-usa-bg {
	background: url(' . Url::to('@eyAssets/images/pages/education-loans/edu-in.png') . ');
	min-height: 550px;
	background-repeat: no-repeat;
	background-size: cover;
	display: flex;
	align-items: center;
	position: relative;
	text-align: center;
	max-height: 700px;
	background-position:left bottom;
}
.bg-overlay{
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    right: 0;
    background: rgb(16 15 15 / 40%);
}
.study-in-usa-bg h1 {
	font-size: 40px;
	color: #ff7803;
	letter-spacing: .5px;
	font-weight: bold;
	font-family: roboto;
	line-height: 30px;
}
.study-in-usa-bg p {
	font-size: 22px;
	font-family: roboto;
	color: #fff;
	padding: 0 0 18px;
	line-height: 30px;
	max-width: 500px;
	margin: 10px auto 20px;
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
.lp-box {
    box-shadow: 0 0 5px rgba(0,0,0,.3);
    text-align: center;
    margin-bottom: 15px;
    border-radius: 5px;
    padding: 20px 10px 10px;
}
.loan-logo img {
    max-width: 80px;
    max-height: 80px;
    height: 65px;
    object-fit: contain;
}
.lp-name {
    text-transform: capitalize;
    font-weight: 500;
    font-family: roboto;
    padding: 5px 0 0 0;
    color: #333;
    line-height: 20px;
    min-height: 45px;
    max-height: 45px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
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
	padding: 2px 35px 35px;
}
.why-back h1 {
	font-size: 45px;
	color: #fff;
	font-family: lora;
}
.why-points {
	margin-top: 100px;
	background-color: #fff;
	margin-left: -100px;
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