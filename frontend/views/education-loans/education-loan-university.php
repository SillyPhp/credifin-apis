<?php

use yii\helpers\Url;

?>
    <section class="study-in-usa-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>Pay School / College fees MONTHLY at ZERO cost*</h1>
                    <p>Don't pay in advance for Education</p>
                    <div class="apply-btn">
                        <a href="/education-loans/apply">Apply Now</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="loan-side-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/education-loan-university.png') ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="education-overview">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="education-wrap"><h1>Why pay fees in Advance? Just pay MONTHLY at ZERO cost*</h1>
                            <ul>
                                <li>100% full fee financing</li>
                                <li>Easy monthly installments</li>
                                <li>Hassle-free disbursal of loan</li>
                                <li>Fulfill your dreams with our funds and seize your success</li>
                                <li>Repay up to one year of course completion/long and flexible tenure of repayment</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <section class="loan-process">
        <div class="container">
            <div class="row">
                <h3 class="heading-s">Loan Process</h3>
            </div>
            <div class="row flex-process">
                <div class="col-md-2 col-md-offset-1 col-sm-4 col-xs-12">
                    <div class="loan-steps loan-line1">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/step1.png') ?>" alt="">
                        <p>Apply Online</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="loan-steps marg-top loan-line2">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/step2.png') ?>" alt="">
                        <p>Upload Document</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="loan-steps loan-line1">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/step3.png') ?>" alt="">
                        <p>Pre Sanction Verification</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="loan-steps marg-top loan-line2">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/step4.png') ?>" alt="">
                        <p>Sanction Of Loan</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="loan-steps">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/step5.png') ?>" alt="">
                        <p>Loan Disbursed</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="benefit-bg">
        <div class="container">
            <div class="row">
                <h3 class="heading-s">Benefits</h3>
            </div>
            <div class="row">
                <div class="col-md-2 col-md-offset-1 col-sm-3 col-xs-6">
                    <div class="bene-img">
                        <i class="fa fa-file-signature"></i>
                        <p>Minimal Paper Work</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <div class="bene-img">
                        <i class="fa fa-book-open"></i>
                        <p>0% Interest Loan</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <div class="bene-img">
                        <i class="fas fa-clock"></i>
                        <p>Approval In Minutes</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <div class="bene-img">
                        <i class="fa fa-hand-holding-usd"></i>
                        <p>No Prepayment Charges</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-12">
                    <div class="bene-img">
                        <i class="fas fa-rupee-sign"></i>
                        <p>Repay In Easy Monthly Installments</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="table-view">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="table-head">Pay education fees MONTHLY, <br>not lumpsum across any college. Over life
                    </h3>
                </div>
            </div>
            <div class="row flex-w">
                <div class="col-md-6">
                    <div class="table-view">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/fee-graph3.png') ?>" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="table-view">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/fee-graph4.png') ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="ey-branding">
        <div class="study-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="branding-logo">
                    <img src="<?= Url::to('/assets/common/logos/logo.svg') ?>" alt="">
                </div>
                <div class="col-md-8 col-md-offset-3 col-sm-8 col-sm-offset-4">
                    <div class="brand-data">
                        <h3>EmpowerYouth.com</h3>
                        <p>Empoweryouth is The World's First Integrated Career Platform.Here is The Easiest Way to Build
                            Your Career</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $this->render('/widgets/loan-form-detail', [
    'model' => $model
]); ?>

<?= $this->render('/widgets/college-fee-apply-now') ?>
<!--    <section class="other-loan">-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <h3 class="loan-head">Other Loan Options</h3>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <div class="col-md-4">-->
<!--                    <div class="loan-types">-->
<!--                        <p>study in India loan</p>-->
<!--                        <div class="desc">India is land of diverse cultures, traditions and languages. Its unique and-->
<!--                            well recognized-->
<!--                            education system makes it a must choice for many students. There are many places for-->
<!--                            students to explore while studying which makes it a great experience for them. It has a wide-->
<!--                            variety of courses in many fields like Computer, Philosophy and Politics. India's higher-->
<!--                            education system has 575 university-level institutions for students to select from.-->
<!--                        </div>-->
<!--                        <a href="" class="app-btn">Apply Now</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-4">-->
<!--                    <div class="loan-types">-->
<!--                        <p>study in Abroad loan</p>-->
<!--                        <div class="desc">No doubt that U.S.A is the most famous worldwide study destination for Indian-->
<!--                            students. It is just because of the large pool of opportunities that it provides like-->
<!--                            Endless Degree Options in Business, Engineering, Medicine, Liberal Arts, Education, Law and-->
<!--                            many more. USA is famous for its latest technology and cultural diversity. Studying in such-->
<!--                            an environment will surely proved to stand you out of the crowd.-->
<!--                        </div>-->
<!--                        <a href="" class="app-btn">Apply Now</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-4">-->
<!--                    <div class="loan-types">-->
<!--                        <p>Teacher loan</p>-->
<!--                        <div class="desc">-->
<!--                            Get considerable loan amount with our loan for teachers, you can get a loan upto 50% of your-->
<!--                            salary amount to help you meet your urgent financial needs.-->
<!--                        </div>-->
<!--                        <a href="" class="app-btn">Apply Now</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-4">-->
<!--                    <div class="loan-types">-->
<!--                        <p>School Fee Finance</p>-->
<!--                        <div class="desc">With increasing inflation, gone are the days when school fees was affordable-->
<!--                            without financial planning. To make your child study in top schools has become a task.-->
<!--                            Schools' fees are high and most schools need to be paid in annual modes. Today, school fees-->
<!--                            can have a major impact on a family’s financial plans and require a financial solution as-->
<!--                            well. To make it easier and less worrisome for the parents, EmpowerYouth has introduced-->
<!--                            school fee financing which is beneficial for both parents and schools. We believe everyone-->
<!--                            has a right to a great education and we can help turn aspirations into reality.-->
<!--                        </div>-->
<!--                        <a href="" class="app-btn">Apply Now</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-4">-->
<!--                    <div class="loan-types">-->
<!--                        <p>Refinance</p>-->
<!--                        <div class="desc">Are you tired of making interest rate payments that are sky high? Do you want-->
<!--                            to reduce your monthly payments on your existing education loan? Or are you looking to shift-->
<!--                            into an income-based repayment program?-->
<!--                        </div>-->
<!--                        <a href="" class="app-btn">Apply Now</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-4">-->
<!--                    <div class="loan-types">-->
<!--                        <p>Annual fee Finance</p>-->
<!--                        <div class="desc">Our annual fee financing solution provides loan to parents and students on-->
<!--                            annual basis with easy monthly installments designed in a way to make it easier for the-->
<!--                            borrowers to repay.-->
<!--                        </div>-->
<!--                        <a href="" class="app-btn">Apply Now</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->

<?php
$this->registerCss('
.form-control {
    border-radius: 0;
    box-shadow: none;
    height: 45px;
}
.loan-process, .table-view {
    margin: 40px 0;
}
.marg-top{margin-top:50px;}
.study-in-usa-bg {
	display: flex;
	align-items: center;
	position: relative;
	text-align: center;
    min-height: 550px;
}
.study-in-usa-bg h1 {
	font-size: 32px;
    margin-bottom: 10px;
    margin-top: 70px;
    color: #3ab4ec;
    font-family: roboto;
    text-align: left;
    font-weight: 700;
    line-height: 50px;
}
.study-in-usa-bg p {
    text-align: left;
    font-size: 16px;
    font-family: roboto;
    color: #333;
    padding: 0 0 18px;
    line-height: 24px;
    letter-spacing: 0.5px;
}
.apply-btn {
    text-align: left;
}
.apply-btn a {
    background: #00a0e3;
    padding: 16px 40px;
    border-radius: 4px;
    font-size: 18px;
    color: #ffffff;
    border: none;
    outline: none;
    display:inline-block;
}
.loan-side-img img {
    width: 100%;
    margin:20px 0;
}
.study-in-usa-bg ul li{
    display: inline;
    margin-right: 10px;
}
.study-overlay{
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    right: 0;
    background: rgb(16 15 15 / 50%);
}
.loan-steps p {
    font-size: 14px;
    font-family: roboto;
    font-weight: 500;
    margin-bottom:30px;
}
.loan-steps img {
    width: 90px;
    margin-bottom: 15px;
    position:relative;
    z-index:999;
}
.loan-steps {
    text-align: center;
    position:relative;
}
.loan-line1::before {
    content: "";
    display: block;
    width: 140px;
    height: 2px;
    background: #dbdbdb;
    left: 66%;
    top: 48%;
    position: absolute;
    transform: rotate(41deg);
}

.loan-line2::before {
    content: "";
    display: block;
    width: 140px;
    height: 2px;
    background: #dbdbdb;
    left: 67%;
    top: 16%;
    position: absolute;
    transform: rotate(-40deg);
}
.benefit-bg {
    background-color: #edf4fc;
    padding:30px 0;
}
.bene-img {
    margin-bottom: 20px;
    text-align: center;
}
.bene-img i {
    font-size: 34px;
    margin-bottom: 8px;
    width: 90px;
    height: 90px;
    color: #00a0e3;
    border: 6px solid #00a0e3;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin: 0 auto;
    position:relative;
    box-shadow: inset 2px 2px 8px 0px #696969;
}
.bene-img i:after{
    content: "";
    left: 32px;
    bottom: -22px;
    position: absolute;
    border-top: 10px solid transparent;
    border-right: 15px solid #00A0E3;
    border-bottom: 10px solid transparent;
    transform: rotate(-90deg);
}
.bene-img p {
    font-size: 14px;
    font-family: roboto;
    font-weight: 500;
    margin: 25px 0 0;
}
//.other-loan {
//    padding: 20px 0 50px;
//}
.loan-head, .heading-s {
    text-align: center;
    margin: 0 0 30px;
    font-family: lobster;
    font-size: 34px;
}
//.loan-types {
//    margin-bottom: 20px;
//    padding: 40px;
//    box-shadow: 0px 0px 10px 0px rgb(0 0 0 / 15%);
//    border-radius: 4px;
//    background-color: #fff;
//}
//.loan-types p {
//    font-size: 16px;
//    font-family: roboto;
//    text-transform: uppercase;
//    font-weight: 500;
//    color:#00a0e3
//}
//.desc {
//    font-size: 14px;
//    text-align: left;
//    display: -webkit-box;
//    -webkit-line-clamp: 3;
//    -webkit-box-orient: vertical;
//    overflow: hidden;
//    margin-bottom: 10px;
//}
.text-center{text-align:center;}
.table-head {
    text-align: center;
    font-family: lobster;
    font-size: 34px;
    line-height: 38px;
    color: #00a0e3;
}
.table-view {
    text-align: center;
    margin-bottom: 30px;
}
.table-view img{width:100%;}
.ey-branding {
    background: url(' . Url::to('@eyAssets/images/pages/index2/com-intern-bg.png') . ');
    position: relative;
    min-height: 400px;
    display: flex;
    background-position: center;
    align-items: center;
    background-size: cover;
    background-repeat: no-repeat;
}
.branding-logo {
    position: absolute;
    left: 0;
    background-color: #fff;
    padding: 40px 30px;
    border-radius: 0 4px 4px 0;
}
.branding-logo img {
    width: 200px;
}
.brand-data h3 {
    font-size: 35px;
    font-family: lora;
    color:#fff;
}
.brand-data p {
    font-size: 16px;
    font-family: Roboto;
    color:#fff;
}
.education-overview{
    padding: 80px 0 ;
    background: #0082ca url(' . Url::to('@eyAssets/images/pages/education-loans/scback.png') . ');
//    background-size: 58%;
    -ms-transform: skewY(-3deg);
    transform: skewY(-3deg);
    background-repeat: no-repeat;
    background-position: right top;
}
.education-wrap {
    -ms-transform: skewY(3deg);
    transform: skewY(3deg);
}
.education-wrap h1 {
    color: #ffffff;
    font-family: lora;
    font-weight: bold;
    line-height: 54px;
}
.education-wrap ul {
    list-style: none;
    margin-top: 32px;
    padding:0;
}
.education-wrap ul li {
    color: #ffffff;
//    padding-left: 40px;
    margin-bottom: 15px;
    font-size: 1.25em;
    line-height: 26px;
}
.flex-w {
    display: flex;
    align-items: flex-end;
    justify-content: center;
    flex-wrap: wrap;
}
@media screen and (max-width: 992px){
.loan-line1::before, .loan-line2::before{display:none;}
.marg-top{margin:0;}
.flex-process {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}
}
@media screen and (max-width: 515px) and (min-width: 300px) {
.branding-logo{
    position:relative;
    }
.marg-top {
    margin-top: 0px;
    }
.education-overview{
    background-position: top left;
    }
.education-wrap h1, .table-head{
    font-size:24px;
    }
}
');
