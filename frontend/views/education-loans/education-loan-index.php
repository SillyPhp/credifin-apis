<?php

use yii\helpers\Url;
?>

<?= $this->render('/widgets/homepage_components/edu-loan-new') ?>
    <div class="clearfix"></div>
    <?= $this->render('/widgets/loan-products') ?>
    
    <?= $this->render('/widgets/covid-offer-banner', ['availUrl' => '/education-loans/apply']) ?>

    <?= $this->render('/widgets/loan-why-empower-youth') ?>
    <?= $this->render('/widgets/testimonials') ?>
    <?= $this->render('/widgets/education-loan-internship') ?>
    



    <section class="edu-with-sec">
        <div class="container">
            <div class="row mt-20">
                <div class="col-md-12">
                    <h2 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'How It Works'); ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="loansWorks col-md-3 col-xs-6">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/apply-loan.png') ?>">
                    <h4 class="font-georgia"><?= Yii::t('frontend', 'Apply Online'); ?></h4>
                </div>
                <div class="loansWorks col-md-3 col-xs-6">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/suggest-loan.png') ?>">
                    <h4 class="font-georgia"><?= Yii::t('frontend', 'We Will Suggest The Best Suitable Loan'); ?></h4>
                </div>
                <div class="loansWorks col-md-3 col-xs-6">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/share-docs.png') ?>" alt="share-docs">
                    <h4 class="font-georgia"><?= Yii::t('frontend', 'Share Relevant Documents'); ?></h4>
                </div>
                <div class="loansWorks col-md-3 col-xs-6">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/sanctioned-loan.png') ?>"
                         alt="sanctioned-loan">
                    <h4 class="font-georgia"><?= Yii::t('frontend', 'Loan Sanctioned'); ?></h4>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="ptb50 bgEd">
            <div class="container">
                <div class="edu-flex">
                    <div class="edu-hw-block">
                        <div class="edu-hw-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/study-abroad.png') ?>"
                                 alt="apply-for-education-loan"/>
                        </div>
                    </div>
                    <div class="edu-des">
                        <div class="edu-hw-title">Study Abroad Education Loan</div>
                        <p class="edu-hw-description">
                            The desires of human beings are unlimited then why they should have limited opportunities.
                            There
                            are abundance of study opportunities that are available across the globe. Empoweryouth has
                            vast
                            personalized solutions that will help you to achieve your dreams of studying abroad.
                        </p>
                        <div class="abroad-btn">
                            <a href="/education-loans/apply">Apply Now </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ptb50">
            <div class="container">
                <div class="edu-flex">
                    <div class="edu-hw-block order2">
                        <div class="edu-hw-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/study-india-1.png') ?>"
                                 alt="online-study-loan-in-India"/>
                        </div>
                    </div>
                    <div class="edu-des order1">
                        <div class="edu-hw-title">Study in India Education Loan</div>
                        <p class="edu-hw-description">
                            The growth of educaton industry in India is immensely increasing. The colleges and
                            universities
                            are offering a variety of study programs and courses in almost every niche - You Name It And
                            You
                            Have It. Here, Empoweryouth with their <a href="/education-loans">online education loan in
                                India</a> will help you to pursue your
                            desired education without getting worried about the money.
                        </p>
                        <div class="india-btn">
                            <a href="/education-loans/apply">Apply Now </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ptb50 bgEd">
            <div class="container">
                <div class="edu-flex">
                    <div class="edu-hw-block">
                        <div class="edu-hw-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/edu-ins-loan.png') ?>"
                                 alt="interest-free-education-loan"/>
                        </div>
                    </div>
                    <div class="edu-des">
                        <div class="edu-hw-title">Education Institution Loans</div>
                        <p class="edu-hw-description">
                            We all know the importance of education and educational institutes in our lives as they
                            provide
                            a variety of learning environments and spaces. Empoweryouth with its educational institute
                            loans
                            provides financial help to the educational insitutes for their growth.
                        </p>
                        <div class="institution-btn">
                            <a href="/educational-institution-loan"> Apply Now </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?= $this->render('/widgets/Our-lending-partners') ?>

    <section class="bg-blue pb10">
        <?= $this->render('/widgets/choose-education-loan') ?>
    </section>

    <section class="faq-s">
        <div class="faq-s-bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-sm-12">
                    <div class="faq-main">
                        <h2>Frequently Asked Questions</h2>
                        <ul class="questions-faq">
                            <li>
                                <a class="faqs" data-toggle="collapse" data-target="#documents">1. What all documents
                                    are required for the approval of loan via EmpowerYouth?
                                    <div class="collaspe-trigger">
                                        <span class="collaspe-icon"></span>
                                    </div>
                                </a>
                                <div id="documents" class="collapse using-pd">
                                    The following documents will be required to submit for loan approval.<br>
                                    - AADHAR CARD<br>
                                    - PAN CARD (mandatory in certain Banks/NBFC's)<br>
                                    - PHOTO<br>
                                    - PASSPORT<br>
                                    - 10TH to Last Qualification<br>
                                    - COLLEGE ADMISSION LETTER<br>
                                    - ENTRANCE EXAM SCORE CARD (if any)<br>
                                    - IELTS SCORE CARD<br>
                                    - OFFER LETTER (mandatory in certain Banks/NBFC's)<br>
                                    - MOBILE NUMBER<br>
                                    - EMAIL ID<br>
                                </div>
                            </li>
                            <li>
                                <a class="faqs" data-toggle="collapse" data-target="#abroad">2. Is the loan available
                                    for abroad studies too?
                                    <div class="collaspe-trigger">
                                        <span class="collaspe-icon"></span>
                                    </div>
                                </a>
                                <div id="abroad" class="collapse using-pd">
                                    Yes. The loan is available for both India and abroad.
                                </div>
                            </li>
                            <li>
                                <a class="faqs" data-toggle="collapse" data-target="#repay">3. When do we have to start
                                    to repay the loan?
                                    <div class="collaspe-trigger">
                                        <span class="collaspe-icon"></span>
                                    </div>
                                </a>
                                <div id="repay" class="collapse using-pd">
                                    Direct EMI starts next month from the date of sanctioning of loan <br>
                                    or Moratorium period (simple interest is charged on the amount disbursed)
                                </div>
                            </li>
                            <li>
                                <a class="faqs" data-toggle="collapse" data-target="#expenses">4. What all expenses will
                                    be covered in the loan?
                                    <div class="collaspe-trigger">
                                        <span class="collaspe-icon"></span>
                                    </div>
                                </a>
                                <div id="expenses" class="collapse using-pd">
                                    The following expenses will be covered depending upon the terms of Banks/NBFC:- <br>
                                    Fee payable at college/ school/ hostel <br>
                                    Examination/ library/ laboratory fee <br>
                                    Travel expenses/ passage money for studies overseas <br>
                                    Insurance premium for student borrower<br>
                                    Caution deposit, building fund/ refundable deposit supported by institution bills/
                                    receipts<br>
                                    Purchase of books/ equipment/ uniforms/ instruments<br>
                                    Purchase of computer at reasonable cost if required for completion of the course<br>
                                    Any other expense required to complete the course like study tour, project work,
                                    thesis.
                                </div>
                            </li>
                            <li>
                                <a class="faqs" data-toggle="collapse" data-target="#collateral">5. Is there any
                                    collateral required to secure the loan?
                                    <div class="collaspe-trigger">
                                        <span class="collaspe-icon"></span>
                                    </div>
                                </a>
                                <div id="collateral" class="collapse using-pd">
                                    The collateral for security will depend from case to case. We will study your case
                                    and inform accordingly.
                                </div>
                            </li>
                        </ul
                    </div>
                    <!--                    <div class="faq-btn">-->
                    <!--                        <a href="#"> View More </a>-->
                    <!--                    </div>-->
                </div>
            </div>
        </div>
    </section>
<?php
if ($blogs['blogs']) {
    echo $this->render('/widgets/education-loan/blogs', [
        'blogs' => $blogs,
        'param' => 'education-loan'
    ]);
};
?>
    <section class="">
        <div class="container">
            <div class="heading-style ">Need More Help</div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="l-help-block1">
                        <div class="l-help-title"><img
                                    src="<?= Url::to('@eyAssets/images/pages/educational-loans//charity.png') ?>"
                                    alt="Live Help"/>
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
                                    alt="Contact Us"/> Contact Us
                        </div>
                        <div class="callNumber"><i class="fas fa-phone-square-alt"></i> +91 8727985888</div>
                        <div class="l-help-txt-btn"><a href="tel:+918727985888">Call Us</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="l-help-block1">
                        <div class="l-help-title"><img
                                    src="<?= Url::to('@eyAssets/images/pages/educational-loans/chat-with-us.png') ?>"
                                    alt=""> Chat With Us
                        </div>
                        <div class="chat">
                            <div class="whats-btn"><a href="https://api.whatsapp.com/send?phone=+918727985888"
                                                      target="_blank"><i class="fab fa-whatsapp"></i> Whatsapp</a></div>
                            <div class="tele-btn"><a href="https://t.me/feefinancing" target="_blank"><i
                                            class="fab fa-telegram-plane"></i> Telegram</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?= $this->render('/widgets/institutional-loan') ?>
<?= $this->render('/widgets/press-releasee', [
    'data' => $data,
    'viewBtn' => true
]) ?>
<?= $this->render('/widgets/loan-strip') ?>


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
$('.faqs').click(function () {
    arrow= $(this).find('.collaspe-trigger')
  if(!arrow.hasClass('close')) {
    arrow.addClass('close');
  } else {
    arrow.removeClass('close');
  }
});
var num = '+918727985888';
$(document).on("keypress",'#whatsAppText', function(e) {
     if (e.keyCode == 13) {
         if ($(this).val()!=''){
             window.open('https://api.whatsapp.com/send?phone='+num+'&text=' + $(this).val(), '_blank', 'width=800,height=400,left=200,top=100');
            return false; // prevent the button click from happening   
         }else{
             alert('Enter Text');
         }
        }
});
$(document).on("keypress",'#telegramText', function(e) {
     if (e.keyCode == 13) {
         if ($(this).val()!=''){
             window.open('https://t.me/feefinancing', '_blank', 'width=800,height=400,left=200,top=100');
            return false; // prevent the button click from happening   
         }else{
             alert('Enter Text');
         }
        }
});
JS;
$this->registerJs($script);

$this->registerCss('
.heading-style {
    color: #000;
}
.abroad-btn a, .india-btn a, .institution-btn a {
	color: #fff;
	background-color:#00a0e3;
	font-size: 14px;
	font-family: roboto;
	border: 2px solid #00a0e3;
	padding: 4px 15px;
	border-radius: 4px;
	display: inline-block;
	transition:ease-in-out .2s;
}
.abroad-btn a:hover{
    color:#00a0e3;
    background-color:#fff;
}
.india-btn a:hover{
    color:#00a0e3;
    background-color:#fff;
}
.institution-btn a:hover{
    color:#00a0e3;
    background-color:#fff;
}
.edu-hw-description a {
    color: #000;
    text-decoration: none;
    font-weight: 600;
}
.whats-btn {
    padding: 10px 0px 8px 0px;
    text-align: center;
    margin-right: 10px;
}
.tele-btn {
    padding: 10px 0px 8px 0px;
    text-align: center;
}
.whats-btn a{
    border-radius: 4px;
    border: 1px solid #43d854;
    padding: 10px 20px;
    color: #fff;
    background: #43d854;
}
.whats-btn a:hover{
    color: #43d854;
    background-color: #fff;
    text-decoration: none;
    transition: .3s ease-in-out;
}
.tele-btn a {
    border-radius: 4px;
    border: 1px solid #00405d;
    padding: 10px 22px;
    color: #fff;
    background: #00405d;
}
.tele-btn a:hover {
    color: #00405d;
    background-color: #fff;
    text-decoration: none;
    transition: .3s ease-in-out;
}
.chat {
    padding: 30px;
    display: -webkit-inline-box;
}
.bgeEd {
    background-color: #edf4fc;
}
.faq-btn{
    text-align: center;
    margin-top: 15px;
}
.collapse using-pd li{
    padding-top: 3px;
}
.faq-btn a {
	color: #539ffe;
	background-color:#fff;
	font-size: 12px;
	font-family: roboto;
	border: 2px solid #539ffe;
	padding: 4px 15px;
	border-radius: 4px;
	display: inline-block;
	transition:ease-in-out .2s;
}
.faq-btn a:hover{
    color:#fff;
    background-color:#539ffe;
}
.size{
    font-size: 21px;
    }
.whatsapp {
    color: #666;
    font-size: 18px;
    margin: 10px 5px;
    font-family: roboto;
    }
.footer{
    margin-top: 0px !important;
}
.using-pd{padding:0 0 0 16px;}
.faq-s {
    background-color: #EEF2FE;
    margin:20px 0;
    position: relative;
    overflow-x: hidden;
}
.faq-s-bg{
    position: absolute;
    background-image: url(' . Url::to('@eyAssets/images/pages/education-loans/qna-iccn.png') . ');
    background-repeat: no-repeat;
    background-position: right bottom;
    background-size: contain;
    width: 100%;
    height: 100%;
    right: 0px;
    max-width: 650px;
}
.faq-main {
    padding: 30px 0 50px;
}
.faq-main h2 {
    color: #539ffe;
    font-family: lora;
    font-size: 34px;
    font-weight: bold;
    margin: 0 0 15px;
}
.questions-faq li {
    background-color: #fff;
    margin-bottom: 7px;
    padding: 8px 27px;
    font-family: roboto;
    border-radius: 4px;
    cursor: pointer;
}
.questions-faq li a {
    color: #333;
    display: block;
    font-size: 15px;
    position:relative;
    font-weight:500;
}
.questions-faq li .collapse {
    cursor: auto;
}
.collaspe-trigger {
    position: absolute;
    top: 18px;
    right: -2px;
    cursor: pointer;
}
.collaspe-icon {
    position: absolute;
    left: 50%;
    top: 50%;
    bottom: auto;
    right: auto;
    -webkit-transform: translateX(-50%) translateY(-50%);
    transform: translateX(-50%) translateY(-50%);
    display: inline-block;
    width: 14px;
    height: 2px;
}
.collaspe-icon::before, .collaspe-icon:after {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background-color: #bfbdbd;
    -webkit-transition: -webkit-transform .3s;
    transition: transform .3s;
    content: "";
}
.collaspe-icon::before {
    -webkit-transform: translateY(-5px) rotate(-130deg);
    transform: translateY(-5px) rotate(-130deg);
    content: "";
}
.collaspe-icon::after {
    -webkit-transform: translateY(-5px) translateX(8px) rotate(-50deg);
    transform: translateY(-5px) translateX(8px) rotate(-50deg);
    content: "";
}

/* when drawer close */
.collaspe-trigger.close .collaspe-icon::before {
    -webkit-transform: translateY(-5px) translateX(0px) rotate(-50deg);
    transform: translateY(-5px) translateX(0px) rotate(-50deg);
    content: "";
}
.collaspe-trigger.close .collaspe-icon::after {
    -webkit-transform: translateY(-5px) translateX(8px) rotate(-130deg);
    transform: translateY(-5px) translateX(8px) rotate(-130deg);
    content: "";
}
.blue1{
    color: #EF9819;
}
.moving img {
    position: relative;
    animation: mymove 5s infinite;
}
@keyframes mymove {
    0%  {left:0px; top:0px;}
    25%  {left:5px; top:0px;}
    50%  {left:5px; top:0px;}
    75%  {left:0px; top:0px;}
    100% {left:0px; top:0px;}
}
.moving1 img {
    position: relative;
    animation: mymove 5s infinite;
}
@keyframes mymove {
    0%  {left:0px; top:0px;}
    25%  {left:10px; top:0px;}
    50%  {left:10px; top:0px;}
    75%  {left:0px; top:0px;}
    100% {left:0px; top:0px;}
}
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
    background-color: #ed6d1e;
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
.rupe-img img{
    width:300px;
}
.edu-flex{
    display: flex;
    align-items: center;
    justify-content: space-even;
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
    background-color: #edf4fc;
}
.bgEd{
    background: #fff;
}
.loan-college {
    text-align: center;
    box-shadow: 3px 5px 10px rgba(0,0,0,.1);
    margin-bottom: 25px;
    background-color: #fff;
    padding: 20px 10px;
}
.loan-college:hover{
    box-shadow: 3px 5px 10px rgba(0,0,0,.2);
    transition:.3s ease;
}

.loan-college:hover p{
    color: #00a0e3;
}

.loan-college p {
    font-size: 15px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 50px;
    font-family: roboto;
    margin: 5px 0 0 0;
}

.loan-college-img img {
    max-width: 100px;
    max-height: 100px;
    padding: 5px 10px;
    height: 100px;
    object-fit: contain;
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
.clouds{
    position: relative;
}
.cloud img {
    width: 100%;
}
.cloud{
    position: absolute;
    top: 60px;
    left: 70px;
    width: 90px;
    height: 100px;
    z-index: 2;
}
.cloud1{
    position: absolute;
    top: 10px;
    left: 200px;
    z-index: 0;
}
.cloud2 img{
    width: 100%
}
.cloud2{
    position: absolute;
    top: 80px;
    right: 60px;
    width: 100px;
    height: 20px;
    z-index: 2
}
.cloud3 img{
    width: 100%
}
.cloud3{
    position: absolute;
    top: 150px;
    right: 0px;
    width: 100px;
    height: 80px;
    z-index: 2;
}
.loan-image{
    text-align: center;
    position: relative;
    z-index: 1;
}
.loan-image img{
    width: 1000px;
    max-height: 900px;
    margin-top: 50px;
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
    color: #EF9819;
    font-weight: 600;
    font-size: 34px;
    font-family: lobster;
    margin-bottom: 20px;
}
.loan-text h2{
    font-weight: 600;
    font-size: 20px;
    font-family: lora;
    margin-bottom: 20px;
    display:inline-block;
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
.lp-box {
    box-shadow: 0 0 5px rgba(0,0,0,.1);
    text-align: center;
    margin-bottom: 30px;
    border-radius: 5px;
    padding: 10px;
}
.loan-logo img {
    max-width: 80px;
    max-height: 80px;
    height: 65px;
    object-fit: contain;
}
.backgrounds{
    background-size: 100% 625px;
//    background-image: url(' . Url::to('@eyAssets/images/pages/education-loans/loan-hedr.png') . ');
    background-position: right top;
    background-repeat: no-repeat;
    padding-top: 100px;
    padding-bottom: 35px;
    background-color: #bae6f8;
}
.mt0{
    margin-top: 0px !important;
    margin-bottom: 0px !important; 
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
    .loansWorks img{
        width: 100px;
        heigth: 100px;
    }
    .loansWorks{
        margin-bottom: 25px;
    }
}
@media (max-width:415px){
    .backgrounds{
        background-size: cover;
        min-height: 380px;
        background-position: left;
    }
}
.set-heading h1{
    font-family: lobster;
}
.set-heading h4{
    font-family: "Didact Gothic";
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
/* owl Slider css ends */
/*custom css */
.edu-hw-block{
    text-align: center;
    margin-bottom:35px;
//    min-height: 250px;
//    height: 350px;
}
.edu-hw-title{
    font-size: 20px;
    color: #000;
    font-family: Roboto;
    text-transform: uppercase;
    font-weight: bold;
    text-align: justify;
}
.mt20{
    margin-top: 20px;
}
.edu-hw-description{
    color: #000;
    text-align: justify;
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
    background-color: #edf4fc;
}
.edu-loan-btn a:hover{
    text-decoration: none;
}
.hvr-sweep-to-bottom, .hvr-sweep-to-bottom-2,.hvr-sweep-to-bottom-3  {
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
.hvr-sweep-to-bottom-3{
    background: #ff7803;
    color:#ffffff;
}
.hvr-sweep-to-bottom:before,
.hvr-sweep-to-bottom-2:before,
.hvr-sweep-to-bottom-3:before{
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
.hvr-sweep-to-bottom-2:hover, .hvr-sweep-to-bottom-2:focus, .hvr-sweep-to-bottom-2:active,
.hvr-sweep-to-bottom-3:hover, .hvr-sweep-to-bottom-3:focus, .hvr-sweep-to-bottom-3:active{
    color: #fff;
    text-decoration: none;
}
.hvr-sweep-to-bottom:hover:before, .hvr-sweep-to-bottom:focus:before, .hvr-sweep-to-bottom:active:before,
.hvr-sweep-to-bottom-2:hover:before, .hvr-sweep-to-bottom-2:focus:before, .hvr-sweep-to-bottom-2:active:before,
.hvr-sweep-to-bottom-3:hover:before, .hvr-sweep-to-bottom-3:focus:before, .hvr-sweep-to-bottom-3:active:before {
    -webkit-transform: scaleY(1);
    transform: scaleY(1);
}

.l-help-block1{
    box-shadow: 0 0 10px rgb(0,0,0,.2);
    padding: 22px 20px;
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
@media screen and (max-width: 986px) and (min-width:770px) {
   .temp-btn
     .loan-txt{
         margin-left: 3%;
         font-size: 23px;
         line-height: 30px;
     }
}
@media only screen and (max-width: 375px) {
   .whats-btn a{
    padding: 10px 7px;
   }
   .tele-btn a{
    padding: 10px 7px;
   }
}
@media screen and (max-width: 590px) and (min-width:320px) {
    
}
@media screen and (max-width:990px) and (min-width:760px){
    .loan-image img {
        margin-top: 100px;
    }
}
@media only screen and (max-width:768px){
    .edu-flex{
        display: block;
    }    
    .edu-hw-icon img{
        width: 60%;
    }
}
@media screen and (max-width:998px) and (min-width:774px){
    .moving1 img,.moving img{
        animation: none;
    }
}
@media screen and (max-width:770px) {
    .moving1,.moving {
        display: none;
    }
    .loan-text h1 {
        font-size: 30px;
    }
    .loan-image img{
        max-width: 250px;
    }
}
@media screen and (max-width:990px) {
    .faq-s-bg{
     display: none;
    }
    }
');
$this->registerCssFile('@eyAssets/css/blog.css');