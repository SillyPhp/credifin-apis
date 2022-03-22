<?php
use yii\helpers\Url;
?>

<section class="annual-fee-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-text">
                    <h1>
                    <span class="typewrite" data-period="2000"
                          data-type='["Annual Fee Financing.", "Easy Monthly Installment.", "Easy Repayment." ]'>
                        <span class="wrap"></span>
                    </span>
                    </h1>
                    <p>Our annual fee financing solution provides loan to parents and students on annual basis with easy monthly installments designed in a way to make it easier for the borrowers to repay.</p>
                    <div class="header-btn">
                        <a href="/education-loans/apply" class="apply-now btn-orange">Apply Now</a>
                        <a href="#contact" class="enq-now">Enquire Now</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="header-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/annual-fee-header-img.png')?>">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="annual-fee-benefits">
    <div class="container">
        <div class="row benefit-heading">
            <h1 class="heading-style">Benefits Of Annual Fee Financing</h1>
        </div>
        <div class="row benefits">
            <div class="col-md-3 col-sm-6">
                <div class="benefit">
                    <div class="bg-circle"></div>
                    <div class="benefit-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/disbursement-icon.png')?>">
                    </div>
                    <h3>Quick Disbursement</h3>
                    <p>With our state of the art system we strive to complete the disbursement of loan in less than 10 days</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="benefit">
                    <div class="bg-circle"></div>
                    <div class="benefit-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/document-icon.png')?>">
                    </div>
                    <h3>Easy Documentation</h3>
                    <p>The documentation process is fairly simple and basic documents are needed for sanction of loan</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="benefit">
                    <div class="bg-circle"></div>
                    <div class="benefit-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/online-icon.png')?>">
                    </div>
                    <h3>Online Application</h3>
                    <p>The Candidates can apply for loan online using the tools provided by our technology partners.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="benefit">
                    <div class="bg-circle"></div>
                    <div class="benefit-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/track-icon.png')?>">
                    </div>
                    <h3>Live Track</h3>
                    <p>The college gets a live tracking on status of the loan application for all candidates.</p>
                </div>
            </div>
            </div>
    </div>
</section>

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

<section class="bgeEd partner-college">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h5 class="heading-style"><?= Yii::t('frontend', 'Partner Colleges'); ?></h5>
            </div>
        </div>
        <div class="row">
          <?php
          foreach ($loan_colleges as $l) {
            ?>
              <div class="col-md-3 col-sm-4 col-xs-12">
                  <a href="<?= Url::to('/education-loans/apply-loan/' . $l['organization_enc_id'], true) ?>"
                     target="_blank">
                      <div class="college-card-partner">
                          <div class="college-img-partner">
                              <img src="<?= $l['org_logo'] ?>" alt="org-logo">
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

<?= $this->render('/widgets/Our-lending-partners');?>

<?= $this->render('/widgets/education-loan-faqs');?>

<?php
if($blogs['blogs']){
    echo $this->render('/widgets/education-loan/blogs',[
        'blogs' => $blogs,
        'param' => 'annual-fee-finance'
    ]);
};
?>

<?= $this->render('/widgets/loan-form-detail',[
    'model' => $model,
    'param' => 'Annual Fee Finance'
]); ?>

<?= $this->render('/widgets/press-releasee',[
    'data' => $data,
    'viewBtn' => true
]) ?>

<?= $this->render('/widgets/loan-strip') ?>

<?php
$this->registerCss('
html{
    scroll-behavior: smooth;
}
.header-benefit{
}
.annual-fee-header{
    min-height: 500px;
    position: relative;
    background: url(' . Url::to('@eyAssets/images/pages/education-loans/annual-fee-header-bg.png') . ');
    background-repeat: no-repeat;
    background-size: 100% 100%;
}
.annual-fee-header .container{
    min-height: 500px;
}
.annual-fee-header .row{
    min-height: 500px;
    display: flex;
    align-items: center;
}
.header-text h1{
    font-size: 45px;
    color: #00a0e3;
    font-family: Roboto;
    min-height: 64px;
}
.header-text p{
    font-size: 18px;
    line-height: 21px;
    color: #2e2e2e;
    font-family: Roboto;
    font-weight: 400;
    word-spacing: 2px;
}
.bgeEd{
    background-color: #edf4fc
}
.header-img{
    position: relative;
    z-index: 2;
    text-align: center;
    margin-top: 100px;    
}
.header-img img{
    width: 90%;
}
.benefit{
    box-shadow: 0px 2px 8px rgb(0 0 0 / 45%);
    border-radius: 3px;
    padding: 15px;
    margin-bottom: 25px;
    overflow: hidden;
    transition: ease-in all 300ms;
    min-height: 232px;
    position: relative;
    z-index: 1;
}
.benefit h3{
    font-size: 20px;
    color: #00A0E3;
    font-weight: 600;
    margin: 10px 0;
    height: 46px;
}
.benefit p{
    font-weight: 700;
    font-size: 12px;
    line-height: 14px;
    letter-spacing: 0.03em;
}
.benefits{
    margin: 20px 0;
}
.benefit-img{
    position: relative;
}
.benefit-img img{
    margin: 10px 0 0 10px;
}
.bg-circle{
    width: 45px;
    height: 45px;
    background: #E1F6FF;
    position: absolute;
    border-radius: 50%;
    z-index: -1;
    left: 30px;
    top: 40px;
    transform: translate(-50%, -50%);
    transition: 300ms ease-out all;
}
.benefit:hover .bg-circle{
    width: 250%;
    height: 250%;
    transition: 300ms ease-in all;
}
.benefit:hover{
    transform: scale(1.05);
    transition: ease-in all 300ms;
}
.benefit-heading h1{
    font-size: 28pt;
    font-family: Roboto;
    font-weight: 500;
    color: #000;
    font-family: Lobster;
}
.footer{
    margin-top: 0px !important;
}
.padd30{
    padding-bottom: 30px;
}
.pb10{
    padding-bottom: 15px;
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
    text-align: left;
    color: #000;
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
.header-btn{
    margin-top: 30px;
}
.enq-now, .apply-now{
    padding: 8px 20px;
	background: #00A0E3;
	color: #fff;
	border: 1px solid #00A0E3;
	box-shadow: 0 5px 10px rgba(0,0,0,.3);
	font-size: 16px;
	font-family: roboto;
	border-radius: 4px;
	display: inline-block;
}
.btn-orange{
    background: #ff7803 !important;
    border: 1px solid #ff7803 !important;
    margin-right: 10px;
    transition: .3s ease;
}
.enq-now:hover{
    background: #fff; 
    color: #00a0e3;
    border: 1px solid #fff;
    transition: .3s ease;
    font-weight: 700;
    
}
.btn-orange:hover{
    background: #fff !important;
    border: 1px solid #fff !important;
    color: #ff7803;
    font-weight: 700;
    transition: .3s ease;
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

@media only screen and (max-width: 768px){
    .header-img{
    display: none;
    }
}
@media only screen and (max-width: 550px){
    .header-text h1{
        font-size: 35px;
        min-height: 50px;
    }
    .header-text p{
        font-size: 14px;
    }
}
');
$script = <<<JS
$("a[href^='#']").click(function(e) {
        e.preventDefault();

        var position = $($(this).attr("href")).offset().top;
        $("body, html").animate({
            scrollTop: position
        }, 1500 );
    });
JS;
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJS($script);
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
