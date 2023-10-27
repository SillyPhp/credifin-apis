<?php

use yii\helpers\Url;
?>

    <section class="interest-free-header">
        <img class="percent" src="<?= Url::to('@eyAssets/images/pages/education-loans/percent.png') ?>" alt="">

        <img class="shape-divider" src="<?= Url::to('@eyAssets/images/pages/education-loans/Vector.png') ?>" alt="">

        <img class="coins" src="<?= Url::to('@eyAssets/images/pages/education-loans/coins.png') ?>" alt="">
        <div class="container pbm0">
            <div class="row">
                <div class="col-md-7 col-sm-7">
                    <div class="header-text">
                        <h1>INTEREST FREE EDUCATION LOANS</h1>
                        <p>With our Interest Free Education Loan, we will make it simple and easier for you to fulfil your dream of studying in your desired College/University.</p>
                        <div class="header-btn">
                            <a href="/education-loans/apply" class="apply-btn">Apply Now</a>
                            <a href="#contact" class="enquire-btn">Enquire Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-5 header-img-holder">
                    <div class="header-img">
                        <img class="main-img" src="<?= Url::to('@eyAssets/images/pages/education-loans/interest-free-img.png') ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
    <section class="studyus-head">
        <div class="container">
            <div class="row">
                <div class="col-md-5 tac">
                    <div class="whystudy">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/interest-free-lon.png') ?>" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <h3 class="heading-style">Why Interest Free Education Loan?</h3>
                    <p class="why-des">Going for an Education Loan lowers down the burden on your family savings.
                        On the same hand, think of an education loan that is <span class="org">INTEREST FREE</span>.
                        At EmpowerYouth, we have come up with Interest Free Education Loan to meet all your financial
                        needs
                        and help you get your dream education.</p>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="opportunity">
                                <div class="opp-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/quick-loan.png') ?>"
                                         alt="quick-loan">
                                </div>
                                <div class="opp-txt"> Quick & Simple Loan Process</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="opportunity">
                                <div class="opp-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/less-paperwork.png') ?>"
                                         alt="less-paperwork">
                                </div>
                                <div class="opp-txt">Minimal Amount Of Paperwork</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="opportunity">
                                <div class="opp-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/tracking.png') ?>"
                                         alt="tracking">
                                </div>
                                <div class="opp-txt"> Live Tracking of Loan Application</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="opportunity">
                                <div class="opp-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/interest-free.png') ?>"
                                         alt="interest-free">
                                </div>
                                <div class="opp-txt"> Any Semester Interest Free Loan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    


<?= $this->render('/widgets/interest-free-loan-process') ?>
<?= $this->render('/widgets/benefits-parents') ?>

<!--    <section class="benefit-bg">-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class="col-md-12">-->
<!--                    <div class="heading-style bene-head">Benefits For Parents</div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <div class="col-md-3 col-sm-3 col-xs-12">-->
<!--                    <div class="bene-img">-->
<!--                        <span class="img-fs"><i class="fa fa-file-signature"></i></span>-->
<!--                    </div>-->
<!--                    <div class="bene-img-text">-->
<!--                        <p>Minimal Paper Work</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-3 col-sm-3 col-xs-12">-->
<!--                    <div class="bene-img">-->
<!--                        <span class="img-fs"><i class="fas fa-thumbs-up"></i></span>-->
<!--                    </div>-->
<!--                    <div class="bene-img-text">-->
<!--                        <p>Approval In Minutes</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-3 col-sm-3 col-xs-12">-->
<!--                    <div class="bene-img">-->
<!--                        <span class="img-fs"><i class="fa fa-hand-holding-usd"></i></span>-->
<!--                    </div>-->
<!--                    <div class="bene-img-text">-->
<!--                        <p>No Prepayment Charges</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-3 col-sm-3 col-xs-12">-->
<!--                    <div class="bene-img">-->
<!--                        <span class="img-fs">EMI</span>-->
<!--                    </div>-->
<!--                    <div class="bene-img-text">-->
<!--                        <p>Repay In Easy Monthly Installments</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->

<?= $this->render('/widgets/interest-free-upto-10lakhs') ?>

    <section class="head-bg">
        <div class="container">
            <div class="row partner-bg">
                <div class="col-md-6 col-sm-6">
                    <div class="partner-text">
                        <h2>Partner With Us</h2>
                        <p>Help your students achieve their dreams by partnering with
                            us in providing interest free education loan to all your students.</p>
                        <a href="#call" class="fin-btn">Call Us</a>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="partner-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/partner-loan-icon.png') ?>"
                             alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pdbtm">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style"><?= Yii::t('frontend', 'Our Lending Partners'); ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <div class="college-card">
                        <div class="college-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png') ?>" alt="Agile Finserv">
                        </div>
                        <div class="partner-name">
                            <div class="text-effect"></div>
                            <p>Agile Finserv</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="college-card">
                        <div class="college-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/wepay.png') ?>"
                                 alt="we pay">
                        </div>
                        <div class="partner-name">
                            <div class="text-effect"></div>
                            <p>We Pay India</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="college-card">
                        <div class="college-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/global-logo.png') ?>"
                                 alt="global financial services">
                        </div>
                        <div class="partner-name">
                            <div class="text-effect"></div>
                            <p>Global Financial Services</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="college-card">
                        <div class="college-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/ezcapital.png') ?>" alt="EZ Capital">
                        </div>
                        <div class="partner-name">
                            <div class="text-effect"></div>
                            <p>EZ Capital</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $this->render('/widgets/testimonials-interestfree') ?>
<?php
    if($loan_colleges){
?>
    <section class="bgeEd pdbtm">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style"><?= Yii::t('frontend', 'Partner Colleges'); ?></div>
                </div>
            </div>
            <div class="row">
                <?php
                    foreach ($loan_colleges as $l) {
                ?>
                <div class="col-md-3 col-sm-4">
                    <a href="<?= Url::to('/education-loans/apply-loan/' . $l['organization_enc_id'], true) ?>" target="_blank">
                        <div class="college-card-partner">
                            <div class="college-img-partner">
                                <img src="<?= $l['org_logo'] ?>" alt="">
                            </div>
                            <div class="img-back-partner"></div>
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
        <?php
    }
        ?>
<?php
if ($blogs['blogs']) {
    echo $this->render('/widgets/education-loan/blogs', [
        'blogs' => $blogs,
        'param' => 'interest-free'
    ]);
};
?>
<?= $this->render('/widgets/loan-form-detail', [
    'model' => $model
]); ?>

<?= $this->render('/widgets/press-releasee', [
    'data' => $data,
    'viewBtn' => true,
]) ?>

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
                                    alt=""/> Chat With Us
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

<?= $this->render('/widgets/loan-strip') ?>
<?php
$this->registerCss('
.pbm0 {
    padding-top: 0px !important;
}

.interest-free-header{
  background: #FF7803;
  font-family: roboto;
  display: flex;
  align-items: center;
  position: relative;
  min-height: 550px;
}
.interest-free-header .container{
    min-height: inherit;
}
.interest-free-header .row{
    min-height: inherit;
    display: flex;
    align-items: center;
}
.header-text{
  flex-basis: 50%;
  position: relative;
  z-index: 2;
}
.header-text h1 {
    font-size: 50px;
    font-family: roboto;
    font-weight: 600;
    color: #fff;
    line-height: 53px;
    letter-spacing: 0.5px;
    max-width: 490px;
}
.header-text p {
    color: #0e0e0e;
    font-size: 18px;
    line-height: 26px;
    font-family: roboto;
    font-weight: 500;
    letter-spacing: 0.3px;
}

.header-img{
  margin-top: 65px;
  position: relative;
  text-align center;
  flex-basis: 50%;
  z-index: 1;
}
.header-img-holder{
    align-self: flex-end;
}
.header-img img{
  max-width: 400px;
}

.header-btn{
  margin-top: 20px;
  font-weight: 700;
}

.header-btn a{
  text-decoration: none;
  padding: 10px 20px;
  border-radius: 5px;
  display: inline-block;
}

.apply-btn{
  background-color: #00A0E3;
  color: #fff;
  transition: 0.2s ease-in; 
  margin-right: 10px;
}

.apply-btn:hover {
    background-color: #fff;
    color: #00a0e3;
}

.enquire-btn{
  background-color: #E4E4E4;
  color: #3A3A3A; 
  margin-left: 10px;
  transition: 0.2s ease-in;
}

.enquire-btn:hover {
    color: #ff7803;
}

.shape-divider{
  position: absolute;
  width: 100%;
  left: 0;
  bottom: -1px;
  z-index: 2;
}

.percent{
  position: absolute;
  top: 0;
  left: 50%;
  width: 80px;
}

.coins{
  position: absolute;
  bottom: 40px;
  left: 10px;
  width: 100px;
  z-index: 1;
}

.college-card-partner {
    position: relative;
    box-shadow: 0 0 10px rgb(0 0 0 / 10%);
    text-align: center;
    padding: 1rem;
    overflow: hidden;
    transition: 300ms all linear;
    margin-bottom: 30px;
    background-color:#fff;
}
.college-img-partner {
    position: relative;
    width: 100px;
    height: 100px;
    margin: auto;
    border-radius: 50%;
    overflow: hidden;
    padding: 3px 6px;
    background-color: #fff;
    z-index: 2;
}
.college-card-partner img {
    position: relative;
    width: 100px;
    height: 100px;
    object-fit: contain;
}
.img-back-partner{
  position: absolute;
  width: 450px;
  height: 450px;
  border:0px solid #91c8ff;
  top:22%;
  left:50%;
  border-radius: 50%;
  transform: translate(-50%, -38%);
  z-index: 1;
  transition: 300ms all linear;
}


//.college-card-partner:hover{
//  transform: scale(0.9);  
//}

.college-card-partner:hover > .img-back-partner{
 border-width: 500px; 
}

.college-card-partner p{
    position: relative;
    z-index: 3;
    transition: 500ms all linear;
    font-weight: 700;
    line-height: 18px;
    margin-top: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 36px;
}

.college-card-partner:hover > p{
  color: #fff;
}
.college-card {
    text-align: center;
    padding: 20px 0;
    margin-bottom: 30px;
    box-shadow: 0 0 10px rgb(0 0 0 / 10%);
    transition: 300ms all linear;
    background-color: #fff;
    border-radius:4px;
    overflow:hidden;
}
.college-img{
    width: 100%;
    height: 100%;
    margin: auto;
    line-height: 65px;
    transition: 300ms all linear;
    overflow:hidden;
}
.college-img img {
    height: 70px;
    width: 100px;
    object-fit: contain;
}
.partner-name{
  width: fit-content;
  position: relative;
}

.partner-name .text-effect, .text-effect-content{
  position: absolute;
  top: 0;
  left: 0;
  width: 5px;
  height: 100%;
  background-color: #FB7D0D;
  transition: 200ms all linear;
  z-index: 1;
}

.college-card p {
    text-align: left;
    margin: 10px 0 0 0;
    padding: 2px 15px 2px 8px;
    position: relative;
    z-index: 2;
    transition: 300ms all linear;
    font-size: 15px;
    font-family: roboto;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.college-card:hover{
  transform: scale(0.95);
}

.college-card:hover > .partner-name > .text-effect{
  width: 100%;
  transform: skewX(-17deg);
  margin-left: -8px;
}

.college-card:hover > .partner-name > p{
  color: #fff;
}
.bold-font{
    font-weight: bold;
}
.apply-btn {
    text-align: left;
}
.heading-style {
    color: #000;
}
.pdbtm {
    padding-bottom: 20px;
}
.footer{
    margin-top: 0px !important;
}
html {
  scroll-behavior: smooth;
}
.bgeEd {
    background-color: #edf4fc;
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
.l-help-block1{
    box-shadow: 0 0 10px rgb(0,0,0,.2);
    padding: 22px 15px;
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
    padding: 20px 20px 0 30px;
    font-family: roboto;
}
.callNumber{
    color: #666;
    font-size: 18px;
    margin-top: 10px;
    font-family: roboto;
    text-align: center;
}
.callNumber i{
    color: #1b4145;
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
    display: inline-block;
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
    display: inline-block;
}
.tele-btn a:hover {
    color: #00405d;
    background-color: #fff;
    text-decoration: none;
    transition: .3s ease-in-out;
}
.chat {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}
.partner-bg{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
}
.fin-btn {
    color: #fff;
    background-color: #2b478b;
    font-size: 16px;
    font-family: roboto;
    border: 2px solid #2b478b;
    padding: 4px 16px;
    border-radius: 4px;
    display: inline-block;
    cursor: pointer;
    transition: ease-in-out .2s;
}
.fin-btn:hover{
    color:#2b478b;
    background-color:#fff;
}
.row{
    margin-left: 0px;
    margin-right: 0px;
}
.head-bg{
    background-color: #d1e3fa;
    position: relative;
    min-height: 350px;
}
.img-top-left{
    position: absolute;
    top: 0;
    left: 0;
}
.img-top-left img{
    width: 100%;
    max-width: 250px;
}
.img-top-right{
    position: absolute;
    top: 0;
    right: 0;
}
.img-top-right img{
    width: 100%;
    max-width: 250px;
}
.img-bottom-left{
    position: absolute;
    bottom: 0;
    left: 0;
}
.img-bottom-left img{
    width: 100%;
    max-width: 300px;;
}
.partner-icon{
    margin-top: 50px;
}
.partner-text {
    padding-top: 30px;
}
.partner-text h2 {
    font-family: Lobster;
    color: #2b478b;
    text-align: justify;
    font-size: 40px;
}
.partner-text p {
    font-size: 20px;
    color: #000;
    font-family: lora;
    font-weight: 600;
    line-height: 26px;
}
.org{
    font-weight: 600;
}
.studyus-head {
    padding: 30px 0;
}
.whystudy {
    text-align: center;
}
.whystudy img {
    height: 100%;
    max-height: 370px;
    border-radius: 8px;
    box-shadow: 0 2px 5px 0px rgba(0,0,0,.3);
}
.why-des{
    font-size: 16px;
    line-height: 26px;
    color: #000;
    font-family: roboto;
    text-align: justify;
}
.opp-img img {
    height: 100%;
    max-width: 80px;
    max-height: 60px;
    margin: 20px;
}
.opp-img {
    text-align: center;
}
.opp-txt {
    text-align: center;
    font-size: 14px;
    font-family: roboto;
    line-height: 20px;
    color: #000;
    font-weight: 600;
}
.lp-box {
    box-shadow: 0 0 5px rgba(0,0,0,.3);
    text-align: center;
    margin-bottom: 15px;
    border-radius: 5px;
    padding: 20px 10px 20px;
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
.study-overlay{
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    right: 0;
    background: rgb(16 15 15 / 50%);
}
.study-in-usa-bg {
	background: url(' . Url::to('@eyAssets/images/pages/education-loans/itr-free-eduloan.png') . ');
    min-height: 500px;
	background-repeat: no-repeat;
	background-size: cover;
	background-position: top right;
	display: flex;
	align-items: center;
	position: relative;
	text-align: center;
	height: 100vh;
	max-height: 700px;
}
.study-in-usa-bg h1 {
	font-size: 35px;
    margin-bottom: 10px;
    color: #ff7803;
    font-family: roboto;
    text-align: left;
    font-weight: bold;
}
.study-in-usa-bg p {
    text-align: left;
    font-size: 18px;
    font-family: roboto;
    color: #fff;
    padding: 0 0 18px;
    line-height: 24px;
    letter-spacing: 0.5px;
}
.study-in-usa-bg ul li{
    display: inline;
    margin-right: 10px;
}
.apply-now{
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
	text-align: center;
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
.qualified-txt h2 {
    font-family: \'Lobster\';
    color: #000;
    text-align: center;
    font-size: 42px;
}
.qualified-txt p {
    font-size: 24px;
    font-family: lora;
    text-align: center;
    color: #000;
}
.benefit-bg {
    background-color: #edf4fc;
    padding: 20px 0px 20px;
}
.bene-head {
    margin: 0px 20px 60px;
}
.bene-head h2 {
    font-size: 28pt;
    font-family: lobster;
    color: #2b478b;
}
.bene-img-text {
    text-align: center;
    margin: 20px 0px;
}
.bene-img-text p {
    font-size: 15px;
    color: #2b478b;
    font-family: roboto;
    font-weight: 500;
    line-height: 20px;
}
.bene-img {
    text-align: center;
    border-radius: 50%;
    background-color: #00a0e3;
    padding: 10px;
    box-shadow: 0 0 11px 6px rgb(0 0 0 / 20%);
    max-width: 90px;
    margin: 0 auto;
}
.img-fs {
    font-size: 40px;
    font-weight: 600;
    color: #fff;
}
@media only screen and (max-width: 1024px) and (min-width: 985px){
    .img-top-left img {
         max-width: 178px;
         }
    .img-top-right img {
        max-width: 245px;
    }
    .partner-text h2 {
        font-size: 32px;
    }
    .partner-text p {
        font-size: 20px;
    }
    .fin-btn{
        margin-bottom: 10px;
        font-size: 15px;
    }
    .agent-btn {
        margin-bottom: 10px;
        font-size: 14px;
    }
    .partner-icon {
        margin-top: 150px;
    }
    .partner=icon img{
        width: 100%;
        max-width: 430px;
    }
}
@media only screen and (max-width: 980px) and (min-width: 760px){
    .img-top-left img {
         max-width: 178px;
         }
    .img-top-right img {
        max-width: 245px;
    }
    .img-bottom-left img {
        display: none;
     }
    .partner-txt{
        padding: 0px;
    }
    .partner-text h2 {
        font-size: 30px;
    }
    .partner-text p {
        font-size: 18px;
    }
    .fin-btn {
        margin-bottom: 10px;
        font-size: 15px;
    }
    .agent-btn {
        margin-bottom: 10px;
        font-size: 14px;
    }
    .partner-icon {
        margin-top: 150px;
    }
    .partner=icon img{
        width: 100%;
        max-width: 430px;
    }
}
@media only screen and (max-width: 758px) and (min-width: 320px){
    .img-top-left img {
        max-width: 85px;
        }
    .img-top-right img {
        max-width: 100px;
     }
     .img-bottom-left img {
        display: none;
     }
     .partner-text {
        padding: 0px;
    }
    .partner-text h2 {
        font-size: 29px;
    }
    .partner-text p{
        font-size: 19px;
    }
    .partner-icon img{
        width: 100%;
        max-width: 418px;
    }
    .partner-icon {
        margin-top: 50px;
        text-align: center;
    }
    .fin-btn {
        margin-bottom: 8px;
    }
    .partner-icon {
        margin-top: 0px;
    }
}
@media only screen and (max-width: 680px) and (min-width: 320px) {
    .whystudy img {
        max-height: 250px;
    } 
    .apply-now {
        margin-bottom: 10px;
    }
    .study-in-usa-bg h1 {
        text-align: left;
    }
}

@media only screen and (max-width: 992px) and (min-width: 768px){
   .interest-free-header{
        min-height: 500px;
   }
   .header-text h1 {
        line-height: 40px;
        font-size: 30px;
    }
    .header-img {
        margin-top: 80px;
    }
    .header-img img {
        max-width: 300px;
    }
}
@media only screen and (max-width: 767px){
   .header-text h1 {
        line-height: 40px;
        font-size: 30px;
    }
    .header-img-holder {
        display: none;
    }
}

@media only screen and (max-width: 575px) and (min-width: 425px){
    .header-text h1 {
        font-size: 36px;
        line-height: 50px;
    }
  .interest-free-header{
    padding: 10px 20px; 
  }
  .header-img {
    display: none;
  }
  .percent{
    top: 10px;
    left: 95%;
    transform: translatex(-100%);
    width: 35px;
  }
  .coins{
    width: 50px;
  }
}

@media only screen and (max-width: 420px) and (min-width: 320px){
     .header-img{
        display: none;
    }
     .header-text h1 {
        font-size: 24px;
        line-height: 36px;
    }
    .header-text {
        text-align: center;
    }
    .header-text p {
        font-size: 15px;
        line-height: 20px;
    }
    .apply-btn {
        margin-bottom: 15px;
    }
    .enquire-btn {
        margin-left: 0px;
    }
    .tele-btn a {
        padding: 10px 10px;
    }
    .whats-btn a {
        padding: 10px 10px;
    }
    .chat{
        padding: 30px 0;
    }
}
');
