<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use borales\extensions\phoneInput\PhoneInput;
?>

<section class="refinance-header">
    <div class="bg-overlay"></div>
    <div class="bg-circle circle1"></div>
    <div class="bg-circle circle2"></div>
    <img class="bg-icons rupee-icon" src="<?= Url::to('@eyAssets/images/pages/education-loans/rupee-sign.png')?>" alt="Rupee Icon">
    <img class="bg-icons percent-icon" src="<?= Url::to('@eyAssets/images/pages/education-loans/percent-sign.png')?>" alt="Percent Icon">
    <svg class="waves" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" ><path  d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill" fill="#FFFFFF" fill-opacity="1"></path></svg>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Refinancing Education Loan</h1>
                <p>So you’ve taken a loan. What if we have cool options to slash your outstanding?</p>
                <ul>
                    <li><a href="#contact" class="apply-now btn-orange">Enquire Now</a></li>
                    <!--                    <li><a href="/education-loans/apply" class="apply-now">Apply Now</a></li>-->
                </ul>
            </div>
            <div class="col-md-6">
                <img class="refinance-img" src="<?= Url::to('@eyAssets/images/pages/education-loans/refinance-edu-img.png')?>" alt="Refinace Education Loan">
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-5 tac">
                <div class="whystudy">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/loan-application-form.png')?>" alt="">
                </div>
            </div>
            <div class="col-md-7">
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
<?= $this->render('/widgets/refinance-process-ease') ?>
<section class="bg-blue">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="heading-style">When To Refinance Your Education Loan?</h2>
            </div>
        </div>
        <div class="row mt10">
            <div class="when-points">
                <div class="col-md-3">
                    <div class="when-main-box">
                        <i class="fas fa-percentage"></i>
                        <p>If a lender is offering an attractive rate of interest.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="when-main-box">
                        <i class="fas fa-coins"></i>
                        <p>If there is a significant rise in your income.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="when-main-box">
                        <i class="fas fa-credit-card"></i>
                        <p>If your credit score has been improved</p>
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

<section class="padd-50">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="heading-style">Benefits Of Refinancing</h2>
            </div>
        </div>
        <div class="row rowFlex">
            <div class="col-md-5">
                <ul class="conList">
                    <li class="clickedItem ciActive" data-id="Lower Rate of Interest"
                        data-value="One of the main benefits of refinancing your student loan is to get lower interest
                            rates on your education loan. If you are eligible by having a good credit score and stable
                            income, you can definitely get a student loan with lower interest rates.">Lower Rate of Interest</li>
                    <li class="clickedItem" data-id="Lower Monthly Installments"
                        data-value="Refinancing your student loan from a private lender will help you to pay back your
                             loan in lower monthly installments. This will also reduce the burden of paying the large
                             monthly installments.">Lower Monthly Installments</li>
                    <li class="clickedItem" data-id="Shorter Payoff Term"
                        data-value="In Refinancing, you can adjust your loan repayment as per your needs and
                            requirements. You can go for shorter payoff time with less rate of interest or
                            viceversa.">Shorter Payoff Term</li>
                    <li class="clickedItem" data-id="Add or Remove a Cosigner"
                        data-value="With Refinancing your education loan, you have the authority to add or remove
                            a cosigner. It can proved to be useful if you do not need a cosigner or wanted to add a new
                            cosigner in order to increase your chances to qualify to refinance.">Add or Remove a Cosigner</li>
                </ul>
            </div>
            <div class="col-md-7">
                <div class="conRelative">
                    <div class="conListContent">
                        <h4>Lower Rate of Interest</h4>
                        <p>One of the main benefits of refinancing your student loan is to get lower interest
                            rates on your education loan. If you are eligible by having a good credit score and stable
                            income, you can definitely get a student loan with lower interest rates.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->render('/widgets/Our-lending-partners');?>
<?= $this->render('/widgets/education-loan-faqs');?>
<?php
if($blogs['blogs']){
    echo $this->render('/widgets/education-loan/blogs',[
        'blogs' => $blogs,
        'param' => 'Refinance'
    ]);
};
?>
<?= $this->render('/widgets/loan-form-detail',[
    'model' => $model,
    'param' => 'Refinance'
]); ?>
<?= $this->render('/widgets/press-releasee',[
    'data' => $data,
    'viewBtn' => true,
]) ?>
<?= $this->render('/widgets/loan-strip') ?>
<?php
$this->registerCss('
.pb3{
    padding-bottom: 30px;
}
.lp-box {
    box-shadow: 0 0 5px rgba(0,0,0,.3);
    text-align: center;
    margin-bottom: 15px;
    border-radius: 5px;
    padding: 10px;
    background: #fff;
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
.mt10{
    margin-top: 15px;
}
.cl-icon ul{
    text-align: center;
}
.cl-icon ul li{
    display: inline-block;
    margin: 15px; 
}
.lender-icon{
    width: 130px;
    max-height: 125px;
    
}
.lender-icon img{
    max-width: 110px;
    max-height: 110px;
}
.padd-50{
    padding-bottom: 50px;
}
.padd30{
    padding-bottom: 30px;
}
.footer{
    margin-top: 0px !important;
}
.whystudy {
    text-align: center;
}
.whystudy img {
    height: 100%;
    max-height: 370px;
    border-radius: 8px;
    object-fit: cover;
    box-shadow: 0 1px 3px 0px #797979;
}
.rowFlex{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    margin-top: 25px;
}
.clickedItem{
    cursor: pointer;
}
.bg-blue{
    background: #f7fbfb;
    padding: 0 0 30px 0;
}
.conListContent h4{
    font-size: 25px;
    font-family: Roboto;
    color: #000;
}
.conListContent p{
    font-size: 18px;
    font-family: Roboto;
    color: #333;
    line-height: 25px;
}
.conListContent{
    background: #fff;
    box-shadow: 0 4px 10px rgb(149 139 139 / 50%);
    padding: 20px 30px;
    min-height: 230px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    max-width: 570px;
}
.conRelative{
    position: relative;
    background: url('. Url::to('@eyAssets/images/pages/education-loans/fin-img.png') .');
    padding: 50px 40px 50px 0;
    background-repeat: no-repeat;
    background-position: right;
    background-size: 580px; 
}
.conList li{
    font-size: 18px;
    padding: 0px 10px;
    margin: 15px 0;
    border-left: 5px solid #00a0e3;
    color: #000;
}
.conIcon{
}
.refinance-header {
	min-height: 550px;
	position: relative;
	display: flex; 
	align-items: center;
	overflow: hidden;
}
.refinance-header .bg-overlay{
    width: 100%;
    height: 100%;
    position: absolute;
    background: linear-gradient(279.71deg, rgba(61, 132, 255, 0.51) -4.16%, rgba(142, 182, 255, 0.51) 121.19%);
    backdrop-filter: blur(5px);
    z-index: 0;
}
.refinance-header .container .row{
    display: flex;
    align-items: center;
}
.refinance-header .container .row > div{
    flex-basis: 50%
}
.bg-icons{
    position: absolute;
    width: 70px;
    z-index: -1;
}
.rupee-icon{
    top: 0;
    left: 30%;
}
.percent-icon{
    bottom: 1%;
    left: 2%;
}
.bg-circle{
    position: absolute;
    width: 300px;
    height: 300px;
    background: rgba(0, 160, 227, 0.36);
    filter: blur(100px);
    border-radius: 50%;
    z-index: -1;
}
.circle1{
    left: -1%;
    bottom: 0;
}
.circle2{
    right: -1%;
    top: 0;
}
.waves{
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%; 
    height: 35px;
    transform: rotate(180deg);    
}
.refinance-header h1 {
	font-size: 35px;
	margin-bottom: 10px;
	color: #000;
	font-weight: bold;
	font-family: lora;
}
.refinance-header p {
	font-size: 20px;
	font-family: roboto;
	color: #505050;
	padding: 0 0 18px;
	line-height: 30px;
	max-width: 500px;
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
	transition: .3s ease;
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
	text-align: left;
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
	background-color: #f7fbfb;
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
    box-shadow: 0 0px 5px rgba(149, 139, 139, .3);
	font-family: roboto;
	color: #000;
	transition: ease-in-out .3s;
	cursor: pointer;
}
.types-ref:hover {
	transform: translatey(-4px);
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
	background: #fff;
}
.when-main-box i {
	font-size: 45px;
	color: #ff7803;
	margin-bottom: 15px;
}
.when-main-box p {
	margin: 0;
	font-family: roboto;
	font-size: 17px;
	line-height: 23px;
	color: #333;
}
.types-text{
    text-transform: capitalize;
    font-size: 17px;
    font-family: roboto;
}
.ciActive{
    color: #00a0e3 !important;
}
.le-img img {
    border-radius: 15px;
}


@media (min-width: 768px) and (max-width: 992px){
    .refinance-header h1{
        font-size: 30px;
    }
    .refinance-header p{
        font-size: 19px;
    }
}

@media only screen and (max-width: 767px){
    .refinance-header .container .row{
        flex-direction: column-reverse;
        text-align: center;
    }
    .refinance-img{
        width: 50%;
    }
    .refinance-header h1{
        font-size: 28px;
    }
    .refinance-header p{
        font-size: 18px;
    }
}

');
?>
<script>
    let clickedItem = document.getElementsByClassName('clickedItem');
    console.log(clickedItem);
    for(var i = 0; i < clickedItem.length; i++){
        clickedItem[i].addEventListener('click', function (e){
            let ciActive = document.getElementsByClassName('ciActive');
            if(ciActive.length > 0){
                ciActive[0].classList.remove('ciActive')
            }
            let clickedElem = e.currentTarget;
            clickedElem.classList.add('ciActive');
            let clickedContent = clickedElem.getAttribute('data-value')
            let clickedTitle = clickedElem.getAttribute('data-id')
            let detailDiv = document.querySelector('.conListContent');
            detailDiv.querySelector('p').innerHTML = clickedContent;
            detailDiv.querySelector('h4').innerHTML = clickedTitle;

        })
    }
</script>
