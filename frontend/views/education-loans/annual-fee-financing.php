<?php
use yii\helpers\Url;
?>
<section class="study-in-usa-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>
                    <span class="typewrite" data-period="2000"
                          data-type='["Annual Fee Financing.", "Easy Monthly Installment.", "Easy Repayment." ]'>
                        <span class="wrap"></span>
                    </span>
                </h1>
                <p>Our annual fee financing solution  provides loan to parents and students on annual
                    basis with easy monthly installments designed in a way to make it easier
                    for the borrowers to repay.</p>
                <ul>
                    <li><a href="#contact" class="apply-now btn-orange">Enquire Now</a></li>
                    <!--                    <li><a href="/education-loans/apply" class="apply-now">Apply Now</a></li>-->
                </ul>
            </div>
        </div>
    </div>
</section>
<?= $this->render('/widgets/annual-fee-finance-benefits') ?>
<section class="benefit-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading-style bene-head">Benefits For Parents</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-1 col-sm-3 col-xs-12">
                <div class="bene-img">
                    <span class="img-fs"><i class="fa fa-file-signature"></i></span>
                </div>
                <div class="bene-img-text">
                    <p>Minimal Paper Work</p>
                </div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12">
                <div class="bene-img">
                    <span class="img-fs"><i class="fa fa-book-open"></i></span>
                </div>
                <div class="bene-img-text">
                    <p>0% Interest Loans</p>
                </div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12">
                <div class="bene-img">
                    <span class="img-fs"><i class="fas fa-thumbs-up"></i></span>
                </div>
                <div class="bene-img-text">
                    <p>Approval In Minutes</p>
                </div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12">
                <div class="bene-img">
                    <span class="img-fs"><i class="fa fa-hand-holding-usd"></i></span>
                </div>
                <div class="bene-img-text">
                    <p>No Prepayment Charges</p>
                </div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12">
                <div class="bene-img">
                    <span class="img-fs">EMI</span>
                </div>
                <div class="bene-img-text">
                    <p>Repay In Easy Monthly Installments</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg-blue pb10">
    <?= $this->render('/widgets/choose-education-loan') ?>
</section>
<section class="pb3 press-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h5 class="heading-style"><?= Yii::t('frontend', 'Our Lending Partners'); ?></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-sm-3">
                <div class="lp-box">
                    <div class="loan-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/icici_bank_logo.png') ?>"
                             alt="ICICI Bank">
                    </div>
                    <div class="lp-name">ICICI Bank</div>
                </div>
            </div>
            <div class="col-md-2 col-sm-3">
                <div class="lp-box">
                    <div class="loan-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png') ?>"
                             alt="Avanse Financial Services">
                    </div>
                    <div class="lp-name">Avanse Financial Services</div>
                </div>
            </div>
            <div class="col-md-2 col-sm-3">
                <div class="lp-box">
                    <div class="loan-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/incred_logo.png') ?>"
                             alt="InCred">
                    </div>
                    <div class="lp-name">InCred</div>
                </div>
            </div>
            <div class="col-md-2 col-sm-3">
                <div class="lp-box">
                    <div class="loan-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png') ?>"
                             alt="Exclusive Leasing & Finance">
                    </div>
                    <div class="lp-name">Exclusive Leasing & Finance</div>
                </div>
            </div>
            <div class="col-md-2 col-sm-3">
                <div class="lp-box">
                    <div class="loan-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png') ?>" alt="Agile Finserv">
                    </div>
                    <div class="lp-name">Agile Finserv</div>
                </div>
            </div>
            <div class="col-md-2 col-sm-3">
                <div class="lp-box">
                    <div class="loan-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/ezcapital.png') ?>" alt="EZ Capital">
                    </div>
                    <div class="lp-name">EZ Capital</div>
                </div>
            </div>
            <div class="col-md-2 col-sm-3">
                <div class="lp-box">
                    <div class="loan-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/phf-leasing.png') ?>" alt="PHF Leasing">
                    </div>
                    <div class="lp-name">PHF Leasing</div>
                </div>
            </div>
            <div class="col-md-2 col-sm-3">
                <div class="lp-box">
                    <div class="loan-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/wepay.png') ?>" alt="Amrit Malwa Private Limtied">
                    </div>
                    <div class="lp-name">We Pay India</div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->render('/widgets/education-loan-faqs');?>
<?= $this->render('/widgets/loan-form-detail',[
    'model' => $model
]); ?>
<?= $this->render('/widgets/press-releasee') ?>
<?= $this->render('/widgets/loan-strip') ?>
<?php
$this->registerCss('
.footer{
    margin-top: 0px !important;
}
.padd30{
    padding-bottom: 30px;
}
.pb10{
    padding-bottom: 15px;
}
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
	color: #ff7803;
	font-weight: bold;
	font-family: lora;
}
.study-in-usa-bg p {
	font-size: 18px;
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
.benefit-bg {
    background-color: #edf4fc;
    padding: 20px 0px 30px;
}
.bene-head {
    margin: 20px 20px 60px;
    text-align: center;
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
')
?>
<script>
    var TxtType = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtType.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
            this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
            this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

        var that = this;
        var delta = 200 - Math.random() * 100;

        if (this.isDeleting) { delta /= 2; }

        if (!this.isDeleting && this.txt === fullTxt) {
            delta = this.period;
            this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
            this.isDeleting = false;
            this.loopNum++;
            delta = 500;
        }

        setTimeout(function() {
            that.tick();
        }, delta);
    };

    window.onload = function() {
        var elements = document.getElementsByClassName('typewrite');
        for (var i=0; i<elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
                new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        // INJECT CSS
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
        document.body.appendChild(css);
    };
</script>