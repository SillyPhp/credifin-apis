<?php

//$this->title = Yii::t('frontend', 'Education Loans');

use yii\helpers\Url;

?>
    <!--<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">-->
    <!--<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet"/>-->
    <section class="backgrounds">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="loan-text">
                        <h1>Education Loan</h1>
                        <h3 class="mb1">We Work With You To Turn Your Dreams Into Reality</h3>
                        <a href="<?= Url::to('/education-loans/apply') ?>"
                           class="hvr-sweep-to-bottom-2">
                            Apply Now
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="loan-image">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/loan-header-image.png') ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="clearfix"></div>
          <section class="edu-loans">
               <div class="container">
                   <div class="rupee-main">
                      <div class="edu-loans-txt">Interest Free Loans For </br> All Your Educational Needs!!</div>
                       <div class="rupe-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/rupee.png'); ?>"/>
                       </div>
                   </div>
               </div>
          </section>

    <section class="edu-with-us">
        <div class="container">
            <div class="row mt-20">
                <div class="col-md-12">
                    <h2 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'Why Empower Youth'); ?></h2>
                </div>
            </div>
            <div class="row-mt10">
                <div class= "col-md-3 col-sm-4 col-xs-12">
                    <div class="finance">
                        <div class="finance-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/up-to-100-financing.png'); ?>"/>
                        </div>
                        <div class="finance-text">100% Financing</div>
                        <div class="overlay">
                            <div class="overlay-txt">Loans covering all the student expenses like tution fees, hostel fees, transportation expenses etc.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class= "col-md-3 col-sm-4 col-xs-12">
                <div class="finance">
                    <div class="finance-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/customized-loan.png'); ?>"/>
                    </div>
                    <div class="finance-text">Customized Loans</div>
                    <div class="overlay">
                        <div class="overlay-txt">Personalized loans as per the students needs and requirements.
                        </div>
                    </div>
                </div>
            </div>
            <div class= "col-md-3 col-sm-4 col-xs-12">
                <div class="finance">
                    <div class="finance-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/quick-sanction.png'); ?>"/>
                    </div>
                    <div class="finance-text">Quick Sanctions</div>
                    <div class="overlay">
                        <div class="overlay-txt">Easy and fast loan approvals for your dream education.
                        </div>
                    </div>
                </div>
            </div>
            <div class= "col-md-3 col-sm-4 col-xs-12">
                <div class="finance">
                    <div class="finance-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/minimal-documentation.png'); ?>"/>
                    </div>
                    <div class="finance-text">Minimal Documentation</div>
                    <div class="overlay">
                        <div class="overlay-txt">Hazzle free loan application process with less or minimal paperwork.
                        </div>
                    </div>
                </div>
            </div>
            <div class= "col-md-3 col-sm-4 col-xs-12">
                <div class="finance">
                    <div class="finance-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/flexible-repayment-option.png'); ?>"/>
                    </div>
                    <div class="finance-text">Flexible Repayment Options</div>
                    <div class="overlay">
                        <div class="overlay-txt">Student can select a repayment option that best suits his/her needs.
                        </div>
                    </div>
                </div>
            </div>
            <div class= "col-md-3 col-sm-4 col-xs-12">
                <div class="finance">
                    <div class="finance-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/get-loan-to-study-abroad.png'); ?>"/>
                    </div>
                    <div class="finance-text">Get Loan To Study Abroad</div>
                    <div class="overlay">
                        <div class="overlay-txt">Providing easy and interest free education loan for abroad studies.
                        </div>
                    </div>
                </div>
            </div>
            <div class= "col-md-3 col-sm-4 col-xs-12">
                <div class="finance">
                    <div class="finance-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/pre-admission-loan.png'); ?>"/>
                    </div>
                    <div class="finance-text">Pre-Admission Loan</div>
                    <div class="overlay">
                        <div class="overlay-txt">Get your loan approved before your admission in college or university.
                        </div>
                    </div>
                </div>
            </div>
            <div class= "col-md-3 col-sm-4 col-xs-12">
                <div class="finance">
                    <div class="finance-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/pre-visa-loan.png'); ?>"/>
                    </div>
                    <div class="finance-text">Pre-Visa Loan</div>
                    <div class="overlay">
                        <div class="overlay-txt">Now you can get your loan sanctioned before your visa gets approved.
                        </div>
                    </div>
                </div>
            </div>
    </section>


<!--    <section class="edu-with-sec">-->
<!--        <div class="container">-->
<!--            <div class="row mt-20">-->
<!--                <div class="col-md-12">-->
<!--                    <h2 class="mb-20 pb-10 heading-style">--><?//= Yii::t('frontend', 'Why Empower Youth'); ?><!--</h2>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <div class="loan-ey-flex">-->
<!--                    <div class="categories">-->
<!--                        <img class="grids-image"-->
<!--                             src="--><?//= Url::to('@eyAssets/images/pages/education-loans/up-to-100-financing.png'); ?><!--"/>-->
<!--                        <h4 class="font-georgia">--><?//= Yii::t('frontend', 'Up to 100% Financing'); ?><!--</h4>-->
<!--                    </div>-->
<!--                    <div class="categories">-->
<!--                        <img class="grids-image"-->
<!--                             src="--><?//= Url::to('@eyAssets/images/pages/education-loans/customized-loan.png'); ?><!--"/>-->
<!--                        <h4 class="font-georgia">--><?//= Yii::t('frontend', 'Customized Loans'); ?><!--</h4>-->
<!--                    </div>-->
<!--                    <div class="categories">-->
<!--                        <img class="grids-image"-->
<!--                             src="--><?//= Url::to('@eyAssets/images/pages/education-loans/quick-sanction.png'); ?><!--">-->
<!--                        <h4 class="font-georgia">--><?//= Yii::t('frontend', 'Quick Sanctions'); ?><!--</h4>-->
<!--                    </div>-->
<!--                    <div class="categories">-->
<!--                        <img class="grids-image"-->
<!--                             src="--><?//= Url::to('@eyAssets/images/pages/education-loans/minimal-documentation.png'); ?><!--">-->
<!--                        <h4 class="font-georgia">--><?//= Yii::t('frontend', 'Minimal Documentation'); ?><!--</h4>-->
<!--                    </div>-->
<!--                    <div class="categories">-->
<!--                        <img class="grids-image"-->
<!--                             src="--><?//= Url::to('@eyAssets/images/pages/education-loans/flexible-repayment-option.png'); ?><!--">-->
<!--                        <h4 class="font-georgia">--><?//= Yii::t('frontend', 'Flexible Repayment Options'); ?><!--</h4>-->
<!--                    </div>-->
<!--                    <div class="categories">-->
<!--                        <img class="grids-image"-->
<!--                             src="--><?//= Url::to('@eyAssets/images/pages/education-loans/get-loan-to-study-abroad.png'); ?><!--">-->
<!--                        <h4 class="font-georgia">--><?//= Yii::t('frontend', 'Get loan to study abroad'); ?><!--</h4>-->
<!--                    </div>-->
<!--                    <div class="categories">-->
<!--                        <img class="grids-image"-->
<!--                             src="--><?//= Url::to('@eyAssets/images/pages/education-loans/pre-admission-loan.png'); ?><!--">-->
<!--                        <h4 class="font-georgia">--><?//= Yii::t('frontend', 'Pre Admission Loan'); ?><!--</h4>-->
<!--                    </div>-->
<!--                    <div class="categories">-->
<!--                        <img class="grids-image"-->
<!--                             src="--><?//= Url::to('@eyAssets/images/pages/education-loans/pre-visa-loan.png'); ?><!--">-->
<!--                        <h4 class="font-georgia">--><?//= Yii::t('frontend', 'Pre Visa Loan'); ?><!--</h4>-->
<!--                    </div>-->
<!--                    <div class="categories">-->
<!--                        <img class="grids-image"-->
<!--                             src="--><?//= Url::to('@eyAssets/images/pages/education-loans/bridge-loan.png'); ?><!--">-->
<!--                        <h4 class="font-georgia">--><?//= Yii::t('frontend', 'Bridge Loan'); ?><!--</h4>-->
<!--                    </div>-->
<!--                    <div class="categories">-->
<!--                        <img class="grids-image"-->
<!--                             src="--><?//= Url::to('@eyAssets/images/pages/education-loans/fast-track-loan.png'); ?><!--">-->
<!--                        <h4 class="font-georgia">--><?//= Yii::t('frontend', 'Fast Track Loan'); ?><!--</h4>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
    <section>
        <div class="ptb50 bgEd">
            <div class="container">
                <div class="edu-flex">
                    <div class="edu-hw-block">
                        <div class="edu-hw-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/study-abroad.png') ?>" alt=""/>
                        </div>
                    </div>
                    <div class="edu-des">
                        <div class="edu-hw-title">Study Abroad Education Loan</div>
                        <p class="edu-hw-description">
                            The desires of human beings are unlimited then why they should have limited opportunities. There
                            are abundance of study opportunities that are available across the globe. Empoweryouth has vast
                            personalized solutions that will help you to achieve your dreams of studying abroad.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="ptb50">
            <div class="container">
                <div class="edu-flex">
                    <div class="edu-hw-block order2">
                        <div class="edu-hw-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/study-india-1.png') ?>" alt=""/>
                        </div>
                    </div>
                    <div class="edu-des order1">
                        <div class="edu-hw-title">Study in India Education Loan</div>
                        <p class="edu-hw-description">
                            The growth of educaton industry in India is immensely increasing. The colleges and universities
                            are offering a variety of study programs and courses in almost every niche - You Name It And You
                            Have It. Here, Empoweryouth with their student education loan will help you to pursue your
                            desired education without getting worried about the money.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="ptb50 bgEd">
            <div class="container">
                <div class="edu-flex">
                    <div class="edu-hw-block">
                        <div class="edu-hw-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/edu-ins-loan.png') ?>" alt=""/>
                        </div>
                    </div>
                    <div class="edu-des">
                        <div class="edu-hw-title">Education Institution Loans</div>
                        <p class="edu-hw-description">
                            We all know the importance of education and educational institutes in our lives as they provide
                            a variety of learning environments and spaces. Empoweryouth with its education institute loans
                            provides financial help to the education insitutes for their growth.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="edu-with-sec">
        <div class="container">
            <div class="row mt-20">
                <div class="col-md-12">
                    <h2 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'How It Works'); ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="loansWorks col-md-3 col-sm-6">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/apply-loan.png') ?>">
                    <h4 class="font-georgia"><?= Yii::t('frontend', 'Apply Online'); ?></h4>
                </div>
                <div class="loansWorks col-md-3 col-sm-6">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/suggest-loan.png') ?>">
                    <h4 class="font-georgia"><?= Yii::t('frontend', 'We Will Suggest The Best Suitable Loan'); ?></h4>
                </div>
                <div class="loansWorks col-md-3 col-sm-6">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/share-docs.png') ?>">
                    <h4 class="font-georgia"><?= Yii::t('frontend', 'Share Relevant Documents'); ?></h4>
                </div>
                <div class="loansWorks col-md-3 col-sm-6">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/sanctioned-loan.png') ?>">
                    <h4 class="font-georgia"><?= Yii::t('frontend', 'Loan Sanctioned'); ?></h4>
                </div>
            </div>
        </div>
    </section>


    <div class="clearfix"></div>
    <section class="edu-loan">
        <div class="container">
            <div class="us-flex">
                <div class="edu-loan-txt">
                    Collateral Free Loans
                </div>
                <div class="">
                    <a href="<?= Url::to('/education-loans/apply') ?>"
                       class="hvr-sweep-to-bottom">
                        Apply Now
                    </a>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>


    <!--    <section class="emicalcmain">-->
    <!--        <div class="container">-->
    <!--            <div class="heading-style ">EMI Calculator</div>-->
    <!--        </div>-->
    <!--        <div id="ecww-widget-iframeinner"></div>-->
    <!--    </section>-->
    <div class="clearfix"></div>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style"><?= Yii::t('frontend', 'Partner Colleges'); ?></div>
                </div>
            </div>
            <div class="row">
                <?php
                foreach ($loan_org as $l) {
                    ?>
                    <div class="col-md-3 col-sm-4">
                        <a href="<?= Url::to('/education-loans/apply-loan/' . $l['organization_enc_id'], true)?>" target="_blank">
                            <div class="loan-college">
                                <div class="loan-college-img">
                                    <img src="<?= $l['org_logo'] ?>">
                                </div>
                                <p><?= $l['name'] ?></p>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style"><?= Yii::t('frontend', 'Our Loaning Partners'); ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png') ?>" alt="">
                        </div>
                        <div class="lp-name">Agile Finserv</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/amrit-malwa.png') ?>" alt="">
                        </div>
                        <div class="lp-name">Amrit Malwa Private Limtied</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/phf-leasing.png') ?>" alt="">
                        </div>
                        <div class="lp-name">PHF Leasing</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/ezcapital.png') ?>" alt="">
                        </div>
                        <div class="lp-name">EZ Capital</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png') ?>"
                                 alt="">
                        </div>
                        <div class="lp-name">Exclusive Leasing & Finance</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="">
        <div class="container">
            <div class="heading-style ">Need More Help</div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="l-help-block1">
                        <div class="l-help-title"><img
                                    src="<?= Url::to('@eyAssets/images/pages/educational-loans//charity.png') ?>" alt=""/>
                            Live Help
                        </div>

                        <div class="l-help-txt">Get an answer on the spot. We're online 8am - 7pm Mon to Fri and
                            9am - 3pm on Sat and Sun.
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="l-help-block1">
                        <div class="l-help-title"><img
                                    src="<?= Url::to('@eyAssets/images/pages/educational-loans/phone-receiver.png') ?>"
                                    alt=""/> Contact Us
                        </div>
                        <div class="callNumber"><i class="fas fa-phone-square-alt"></i> +8727985888</div>
                        <div class="l-help-txt-btn"><a href="tel:+8727985888">Call Us</a>
                        </div>
                    </div>
                </div>
                <!--            <div class="col-md-4">-->
                <!--                <div class="l-help-block1">-->
                <!--                    <div class="l-help-title"><img-->
                <!--                                src="--><?//= Url::to('@eyAssets/images/pages/educational-loans/question.png') ?><!--" alt=""/>-->
                <!--                        See our FAQs-->
                <!--                    </div>-->
                <!--                    <div class="l-help-txt">See answers to questions on how to use our services</div>-->
                <!--                </div>-->
                <!--            </div>-->
            </div>
        </div>
    </section>
<?php
$script = <<<JS
$('#company-slider').owlCarousel({
loop: true,
nav: true,
dots: false,
pauseControls: true,
margin: 20,
responsiveClass: true,
navText: [
'<i class="fa fa-angle-left set_icon"></i>',
'<i class="fa fa-angle-right set_icon"></i>'
],
responsive: {
0: {
items: 1
},
568: {
items: 2
},
600: {
items: 3
},
1000: {
items: 6
},
1400: {
items: 7
}
}
});

JS;
$this->registerJs($script);

$this->registerCss('
.edu-with-us{
    margin-bottom: 15px;
}
.row-mt10{
    margin-top: 15px;
}
.finance:hover .overlay{
	height: 100%;
}
.overlay{
   	position: absolute;
	bottom: 0;
	left: 0;
	right: 0;
	background-color: #00A0E3;
	overflow: hidden;
	width: 100%;
	height: 0;
	transition: .5s ease;
}
.overlay-txt{
    color: #fff;
    width:90%;
	font-size: 15px;
	position: absolute;
	top: 50%;
	left: 50%;
	-webkit-transform: translate(-50%, -50%);
	-ms-transform: translate(-50%, -50%);
	transform: translate(-50%, -50%);
	text-align: center;
	font-family: roboto;
    font-weight: 500;
    line-height: 20px;
}
.finance-text{
	font-size: 15px;
	font-family: roboto;
	font-weight: 700;
	text-align: center;
	color:#333;
}
.finance-icon{
    text-align: center;
    width: 100%;
    display: inline-block;
    margin: 0 0 20px;
    margin-top: 40px;
}
.finance{
    width: 100%;
    height: 200px;
    box-shadow: 0 0 11px -4px #999;
	margin-bottom: 20px;
	background-color: #fff;
	transition: all .2s;
	position:relative;
}
.rupee-main {
    display: flex;
    justify-content: center;
    align-items: center;
}
.rupe-img{
    flex-basis: 50%;
    text-align:right;
}
.rupe-img img{
    width:300px;
}
.callNumber{
    color: #666;
    font-size: 18px;
    margin-top: 10px;
    font-family: roboto;
    text-align: center;
}
.callNumber i{
    color: #1b4145
}
.edu-flex{
    display: flex;
    align-items: center;
    justify-content: space-even
}
.edu-hw-block, .edu-des{
    flex-basis: 50%;
}
.edu-des{
    padding: 10px 20px 10px 0;
}
.order2{
    order: 2;
}
.order1{
    order: 1;
}
.ptb50{
    padding-top: 25px;
    padding-bottom: 25px; 
}
.bgEd{
    background: #EDF4FC
}
.loan-college{
    text-align: center;  
    box-shadow: 3px 5px 10px rgba(0,0,0,.1);
    margin-bottom: 30px;
    background: #fff;
}
.loan-college:hover{
    box-shadow: 3px 5px 10px rgba(0,0,0,.2);
    transition:.3s ease; 
}

.loan-college:hover p{
    color: #00a0e3;
}

.loan-college p{
    font-size: 17px;
    line-height: 25px;
    padding: 5px 10px;
//    border-top: 1px solid #eee;
    position: relative;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 60px;
    font-family: roboto;
}
.loan-college-img{
    width: 100%;
    height: 100px;
    margin: 0 auto;
    display: flex;
    align-items: center;
//    background: #f7f7f7;
    
}
.loan-college-img img{
    max-width: 150px;
    max-height: 100%;
    margin: 0 auto;
    padding: 5px 10px
}
.loan-ey-flex{
    display: flex;
    flex-wrap: wrap;
    max-width: 1600px;
    margin: 0 auto;
    justify-content: center;
}
.loan-ey-flex .categories{
    width: 200px;
    margin: 0 15px 10px;
    text-transform: capitalize;
}
.loan-ey-flex .categories h4{
    font-family: roboto;
    font-size: 16px;
}
.loan-image{
    text-align: center;
}
.loan-image img{
    max-width: 400px;
    margin: 40px auto 0;
}
.loansWorks{
     text-align: center;
     }
.mb1{
    margin-bottom: 10px
}
.loan-text {
    padding-top: 140px;
}
.loan-text h1 {
    font-weight: 500;
    font-size: 50px;
    font-family: lobster;
    margin-bottom: 0px;
}
.loan-text h3{
    margin: 10px 0 20px;
    font-family: lora;
    max-width: 500px;
    line-height: 26px;
}
}
.loansWorks{
    text-align: center
}
.loansWorks img{
    max-width:150px 
}
.loansWorks h4{
    font-size: 16px;
    max-width: 200px;
    margin: 10px auto;
    line-height: 25px;
}
.lp-name {
    text-transform: capitalize;
    font-weight: 500;
    font-family: roboto;
    padding: 10px 5px;
    color: #333;
    line-height: 20px;
    min-height: 54px;
    max-height: 54px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.lp-box {
    box-shadow: 0 0 5px rgba(0,0,0,.3);
    text-align: center;
    margin-bottom: 15px;
    border-radius: 5px;
    padding: 10px 10px 5px;
}
.loan-logo {
    width: 65px;
    height: 65px;
    line-height: 61px;
    margin: auto;
}
.backgrounds{
    background-size: 100% 250px;
    background-image: url(' . Url::to('@eyAssets/images/pages/education-loans/header-top-loan.png') . ');
    background-position: right top;
    background-repeat: no-repeat;
    padding-top: 50px;
}
@media screen and (max-width:768px){
    .loan-text {
        padding-top: 70px;
    }
    .backgrounds{
        background-size: 100% 380px;
        min-height:380px;
    }
       .loan-image img{
        max-width: 300px;
    }
    .us-flex{
        flex-direction: column;
    }
    .edu-loan-txt{
        padding-right: 0px;
        padding-bottom: 20px;
    }
}
@media (max-width:415px){
.backgrounds{
    background-size: cover;
    min-height: 380px;
    background-position: left;
}
}
.bg2{
    background-size: 95% 450px;
    background-image: url(' . Url::to('@eyAssets/images/backgrounds/w1.png') . ');
    background-position: right top;
    background-repeat: no-repeat;
    min-height: 400px;
    padding-top: 100px;
}
.set-heading h1{
    font-family: lobster;
}
.set-heading h4{
    font-family: "Didact Gothic";
}
.input-srch{
    background-color:#fff;
    border-radius:20px;
    height:46px;
    width: 290px !important;
    border-right: 0px;
}
.srch{
    border-radius:20px;
    height:46px;
    width:50px;
    background-color: #583de0;
    border-color: #593de0;
    color: #Fff;
}
/* First section with background css ends */
/* Categories section css starts */
.categories{
    text-align: center;
    min-height: 150px;
    margin-bottom: 20px;
}
.grids {
    display: block;
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto 24px;
    border-radius: 50%;
    padding-top: 32px;
    -webkit-transition: all .2s ease-out;
    transition: all .2s ease-out;
}
.grids-image {
    width: 72px;
    height: 72px;
    margin-top: 5px;
}
.grids::after {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 148px;
    height: 148px;
    border: 2px solid #afafaf;
    border-radius: 50%;
    content: "";
    -webkit-transition: all .1s ease-out;
    transition: all .1s ease-out;
}
.categories:hover .grids::after {
    top: -1px;
    left: -1px;
    border: 2px solid #f08440;
    -webkit-transform: scale(.9);
    transform: scale(.9);
}
/* Categories section css ends */
.list-items ol {
    list-style-type: none;
    padding-left: 38px;
    counter-reset: li-counter;
    border-left: 1px solid #f07706;
    position: relative;
}
.list-items ol > li {
    position: relative;
    margin-bottom:28px;
    clear: both;
    font-family: "Didact Gothic";
    font-weight: 400;
    font-size: 18px;
    line-height: 25px;
    color: #0e1318;
}
.list-items ol > li:before {
    position: absolute;
    top: 12px;
    font-family: "Open Sans", sans-serif;
    font-weight: 600;
    font-size: 16px;
    left: -59px;
    width: 40px;
    height: 40px;
    line-height: 37px;
    text-align: center;
    z-index: 9;
    color: #f07706;
    border: 2px solid #f07706;
    border-radius: 50%;
    content: counter(li-counter);
    background-color: #fff;
    counter-increment: li-counter;
}
.background-mirror {
    background: linear-gradient(180deg, #2b2d32 55%, #fff 55%);
}
/* owl Slider css starts */
#company-slider .owl-stage-outer .owl-stage .owl-item .item{
    display: block;
    padding: 30px 0px;
    margin: 5px;
    color: #FFF;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    text-align: center;
}
#company-slider .owl-controls .nav div {
    padding: 5px 9px;
}
.owl-nav i{
    margin-top: 2px;
}
#company-slider .owl-controls .owl-nav div {
    position: absolute;
}
#company-slider .owl-controls .owl-nav .owl-prev{
    left: -60px;
    top: 50px;
}
#company-slider .owl-controls .owl-nav .owl-prev i, #company-slider .owl-controls .owl-nav .owl-next i{
    font-size:64px !important;
}
#company-slider .owl-controls .owl-nav .owl-prev, #company-slider .owl-controls .owl-nav .owl-next{
    background: transparent !important;
}
#company-slider .owl-controls .owl-nav .owl-next{
    right: -60px;
    top: 50px;
}
.owl-item{
    min-height:150px !important;
}
.partners-flex-box .logo-box:hover {
    -webkit-box-shadow: 0 17px 27px -9px #757575;
    box-shadow: 0 17px 27px -9px #757575;
    -webkit-transition: -webkit-box-shadow .7s !important;
    transition: -webkit-box-shadow .7s !important;
    transition: box-shadow .7s !important;
    transition: box-shadow .7s, -webkit-box-shadow .7s !important;
}
.partners-flex .partners-flex-box {
    width: 20%;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.partners-flex .partners-flex-box .logo-box {
    height: 65px;
    width: 65px;
    background-color: #fff;
}
.partners-flex .partners-flex-box {
    width: 20%;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.partners-flex .partners-flex-box .logo-box {
    height: 90px;
    width: 90px;
    background-color: #fff;
}
.partners-flex .partners-flex-box {
    width: 130px;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.partners-flex .partners-flex-box .logo-box {
    height: 120px;
    width: 120px;
    background-color: #fff;
}
.partners-flex .partners-flex-box .image-partners {
    height: 114px;
    margin: 2px;
    cursor: pointer;
    padding: 6px;
    width: 116px;
}
.partners-flex {
    width: 90%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -ms-flex-direction: row;
    flex-direction: row;
    -ms-flex-wrap: nowrap;
    flex-wrap: nowrap;
    margin: 1.5% auto;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}
/* owl Slider css ends */
/*custom css */
.bg-cl{
    background: linear-gradient( to right, #00a0e3,#00a0e3ad);
}
//.hw-block1{
//    background: linear-gradient( to left, #00a0e3,#00a0e370);
//}
//.hw-block2{
//    background-color: #00a0e3;
//}
//.hw-block3{
//    background: linear-gradient( to right, #00a0e3,#00a0e354);
//}
.edu-hw-block{
    text-align: center;
    margin-bottom:35px;
//    min-height: 250px; 
//    height: 350px;
}
.edu-hw-title{
    font-size: 20px; 
    color:#000; 
    font-family: Roboto; 
    text-transform: uppercase; 
    font-weight: bold;
    text-align: center;
}
.mt20{
    margin-top: 20px;
}
.edu-hw-description{
    color: #000;
    text-align: center;
    font-family: roboto;
    font-size: 15px;
}
.edu-hw-icon{ 
    padding: 20px; 
}
.edu-hw-icon img{
    max-width: 400px;
    width: 100%;
}
.edu-hw-text{
    font-size: 16px; 
    line-height: 20px; 
    color:#fff; 
    padding: 10px 30px; 
    font-family: roboto; 
}
.heading-style{
   font-family: lobster;
   font-size: 28pt;
   text-align: left;
   margin: 15px 5px;
}
.heading-style:before{
   content: "";
   position: absolute;
   width: 0;
   height: 0;
   border-style: solid;
   border-width: 0 0 5px 52px;
   border-color: #f07706;
}
.edu-with-sec{
    padding:0px 0px 20px 0;
}

.edu-loans{
 background: url(' . Url::to('@eyAssets/images/pages/education-loans/loan-bg1.png') . '); 
    background-repeat:no-repeat;
    padding: 0px 0 15px 0; 
    text-align: center; 
    background-size: cover;  
    margin-top: 20px; 
 }
 .us-flex1{
  display: flex;
    justify-content: right;
    align-items: right;
}
.edu-loans-txt{
   color: #fff; 
    font-size: 50px;
    flex-basis: 50%;
    font-family: lobster;
    text-align: center;
}
.edu-loan{ 
    background: url(' . Url::to('@eyAssets/images/pages/education-loans/loan-apply.png') . '); 
    background-repeat:no-repeat;
    padding: 50px 0 50px 0; 
    text-align: center; 
    background-size: cover;
}
.us-flex {
    display: flex;
    justify-content: center;
    align-items: center;
}
.edu-loan-txt{ 
    color: #fff; 
    font-size: 38px;
    font-family: lobster;
    padding-right: 20px; 
}
.edu-loan-btn{ 
    text-align: center; 
    padding: 0px;
}
.edu-loan-btn a:hover{
    text-decoration: none;
}
.hvr-sweep-to-bottom, .hvr-sweep-to-bottom-2 {
    display: inline-block;
    vertical-align: middle;
    -webkit-transform: perspective(1px) translateZ(0);
    transform: perspective(1px) translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
    position: relative;
    background: #ffffff;
    padding:8px 25px;
    color:#53bbeb; 
    font-size: 20px;
    text-transform: uppercase; 
    font-family: roboto;
    -webkit-transition-property: color;
    transition-property: color;
    -webkit-transition-duration: 0.3s;
    transition-duration: 0.3s;
    border-radius: 5px;
}
.hvr-sweep-to-bottom-2{
    background: #53bbeb;
    color:#ffffff; 
}
.hvr-sweep-to-bottom:before,
.hvr-sweep-to-bottom-2:before {
    content: "";
    position: absolute;
    z-index: -1;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgb(0,0,0,.1);
    border-radius: 5px;
    -webkit-transform: scaleY(0);
    transform: scaleY(0);
    -webkit-transform-origin: 50% 0;
    transform-origin: 50% 0;
    -webkit-transition-property: transform;
    transition-property: transform;
    -webkit-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -webkit-transition-timing-function: ease-out;
    transition-timing-function: ease-out;
}
.hvr-sweep-to-bottom:hover, .hvr-sweep-to-bottom:focus, .hvr-sweep-to-bottom:active{
  color: #00a0e3;
  text-decoration: none;
}
.hvr-sweep-to-bottom-2:hover, .hvr-sweep-to-bottom-2:focus, .hvr-sweep-to-bottom-2:active{
     color: #fff;
  text-decoration: none;
}
.hvr-sweep-to-bottom:hover:before, .hvr-sweep-to-bottom:focus:before, .hvr-sweep-to-bottom:active:before,
.hvr-sweep-to-bottom-2:hover:before, .hvr-sweep-to-bottom-2:focus:before, .hvr-sweep-to-bottom-2:active:before {
  -webkit-transform: scaleY(1);
  transform: scaleY(1);
}
.l-help{
    padding:15px 0px 30px;
    text-align: center; 
    background:#eee;
}
.l-help-block1{
    box-shadow: 0 0 10px rgb(0,0,0,.2); 
    padding: 25px 20px; 
    margin-bottom:20px; 
    background:#fff; 
    min-height: 180px;
 }
.l-help-title{
    font-size: 20px !important; 
}
.l-help-txt-btn{
    margin-top: 20px;
    text-align: center;
}
.l-help-txt-btn a{
    border: 1px solid #00a0e3; 
    padding: 10px 20px; 
    color: #fff; 
    background: #00a0e3;
}
.l-help-txt-btn a:hover{
    border: 2px solid #00a0e3; 
    padding: 10px 20px; 
    color: #00a0e3; 
    background: #fff; 
    text-decoration: none;
    transition: .3s ease-in-out;
}
.l-help-txt{
    font-size: 15px; 
    padding: 20px 30px 0 30px;
    font-family: roboto;
}
/*Emi Calculator*/
#ecww-formwrapper{
    background:#EEE; 
    margin-bottom:0px;
}
#ecww-formwrapper,#ecww-summary,#ecww-piechart{
    height:300px;
    overflow:hidden; 
}
#ecww-form{
    background:#EEE;
    padding:10px 30px 10px 70px;
}
#ecww-summary,#ecww-piechart{
    background:#eee;
    border:1px solid #EEE;
    border-top:0 none;
}
#ecww-piechart{
    border-bottom:0 none!important;
}
.no-pad{
    padding-left:0; 
    padding-right:0;
}
@media (min-width:768px){
    #ecww-summary,#ecww-piechart{
        border-left:0 none;
        border-bottom:0 none; 
        border-top:1px solid #EEE;
    }
}
#ecww-header{
    background:#333 url(../img/emicalculator.png) 50% 50% no-repeat;
    margin:-1px 0 0 -1px; 
    height:40px; 
    text-indent:-9999px; 
    padding:0; 
    border:0 none;
}
.ecww-inline-input-group{
    overflow:hidden;
}
.ecww-tenure-choice{
    float:right; 
    margin-left:10px;
}
.ecww-percent-sign{
    font-weight:700; 
    font-size:16px;
}
.glyphicon-rupee::before{
    content:\'\20B9\';
    font-weight:700;
    font-size:16px;
}
.glyphicon-percent::before{
    content:\'%\';
    font-weight:700;
    font-size:16px;
}
#ecww-monthlypayment,#ecww-totalinterest,#ecww-totalamount{
    padding:18px 0;
    text-align:center;
    border-bottom:1px dotted #DBDAD7;
}
#ecww-totalamount{
    border-bottom:0 none;
}
#ecww-summary h4{
    color:#888;
    font-size:14px; 
    line-height:20px; 
    margin:0 auto; 
    padding:0;
}
#ecww-summary p{
    font-size:18px; 
    line-height:27px; 
    font-weight:700; 
    margin:0 auto; 
    padding:0;
}
#ecww-monthlypayment p{
    font-size:24px; 
    line-height:36px; 
    font-weight:700;
}
.glyphicon{
    width:1.28571429em;
    text-align:center;
}
.emicalcmain{
    margin-bottom:0px !important; 
    background: #eee;
} 
@media screen and (max-width: 992px){
    .edu-flex{
        flex-direction: column;
    }
    .order2{
        order: 1;
    }
    .order1{
        order: 2;
    }
}
@media screen and (max-width: 500px){
    .edu-loan-txt{
        line-height: 60px;
        margin-bottom:20px;
    }
    .us-flex{
        flex-direction: column;
    }
    .loan-image img{
        max-width: 250px;
    }
}
@media screen and (max-width:992px) and (min-width:769px){
.edu-loans-txt{
    font-size: 40px;
    }
    }
@media screen and (max-width:768px) and (min-width:200px){
.rupee-main {
    display: block;
}
.rupe-img{
    display: none;
}
.edu-loans-txt{
    font-size: 35px;
     text-align: center;
}

');
$this->registerCssFile('@eyAssets/css/blog.css');
$this->registerJsFile('@eyAssets/js/emi-calculator/emicalc-lib.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/emi-calculator/emicals.js', ['depends' => [\yii\web\JqueryAsset::className()]]);