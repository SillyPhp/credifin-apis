<?php
use yii\helpers\Url;
?>
<section class="study-in-usa-bg">
    <div class="headerOverlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>
                    <span class="typewrite" data-period="2000"
                          data-type='["School Fee Finance."]'>
                        <span class="wrap"></span>
                    </span>
                </h1>
                <p>A good education is foundation for a better future<br>
                Lay your child's career path right from school.</p>
                <ul>
                    <li><a href="#contact" class="apply-now btn-orange">Enquire Now</a></li>
                    <!--                    <li><a href="/education-loans/apply" class="apply-now">Apply Now</a></li>-->
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="pt30">
    <div class="container">
        <div class="row">
            <div class="col-md-5 tac">
                <div class="whystudy">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/sf-icon.png')?>" alt="">
                </div>
            </div>
            <div class="col-md-7">
                <h3 class="heading-style">School Fee Finance</h3>
                <p class="why-des">With increasing inflation, gone are the days when school fees was affordable without financial planning. To make your child study in top schools has become a task. Schools' fees are high and most schools need to be paid in annual modes. Today, school fees can have a major impact on a family’s financial plans and require a financial solution as well.
                    To make it easier and less worrisome for the parents, EmpowerYouth has introduced school fee financing which is beneficial for both parents and
                    schools. We believe everyone has a right to a great education and we can help turn aspirations into reality.
            </div>
        </div>
    </div>
</section>

<?= $this->render('/widgets/loan-products')?>
<?= $this->render('/widgets/benefits-for-parents')?>
<?= $this->render('/widgets/education-loan-internship')?>
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
<section class="bg-blue">
    <?= $this->render('/widgets/choose-education-loan') ?>
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
.pt30{
    padding-top: 30px
}
.why-des{
    font-size: 16px;
    line-height: 26px;
    color: #000;
    font-family: roboto;
    text-align: justify;
}
.whystudy img {
    height: 100%;
    max-height: 300px;
    border-radius: 8px;
    box-shadow: 0 1px 3px 0px #797979;
}
.displayFlex{
    display: flex; 
    flex-wrap: wrap;
    justify-content: center;
}
.edu-loan-products{
    text-align: center;
    box-shadow: -19px 19px 0px -11px #eee;
    min-height: 200px;
    margin-bottom: 30px;
    display: flex;
    border: 1px solid #eee;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 15px 10px;
    padding: 15px;
    width: 200px;
    letter-spacing: .5px;
    font-family: roboto;
}
.edu-loan-products:hover{
    box-shadow: -19px 19px 0px -11px #00a0e3;
    transition: .3s ease;
    cursor: pointer
}
.edu-loan-products a{
    color: #00a0e3;
    font-size: 15px;
    font-weight: 500;
}
.edu-loan-products a:hover{
    color: #ff7803;
    transition: .3s ease;
}
.edu-loan-products img{
    max-height: 50px;
}
.edu-loan-products p{
    margin-top: 15px;
    font-size: 15px;
    text-transform: capitalise;
    line-height: 20px;

}
.study-in-usa-bg {
	background: url(' . Url::to('@eyAssets/images/pages/education-loans/schoolfee.png') . ');
	min-height: 500px;
	background-repeat: no-repeat;
	background-size: cover;
	display: flex;
	align-items: center;
	justify-content: center; 
	position: relative;
	max-height: 700px;
	background-position:center;
}
.headerOverlay{
    background: rgba(0,0,0, .8);
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
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
	padding: 0 0 5px;
	line-height: 30px;
	max-width: 500px;
	text-transform: capitalize;
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
/**/
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
.padd30, .pb3{
    padding-bottom: 30px;
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