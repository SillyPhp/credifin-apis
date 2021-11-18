<?php
use yii\helpers\Url;
?>
<section class="school-fee-finance">
    <section class="school-fee-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="header-text">
                        <h1>
                            School Fee Finance
                        </h1>
                        <p>A Good Education Is Foundation For A Better Future Lay Your Child's Career Path Right From School.</p>
                        <div class="header-btn">
                            <a href="/education-loans/school-fee-finance/apply" class="apply-now btn-orange">Apply Now</a>
                            <a href="#contact" class="enq-now">Enquire Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="header-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/school-fee-header.png')?>">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="school-fee-info">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="school-fee-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/school-fee-info.png')?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="school-fee-text">
                        <h2>School Fee Finance</h2>
                        <p>With increasing inflation, gone are the days when school fees was affordable without financial planning. To make your child study in top schools has become a task. Schools' fees are high and most schools need to be paid in annual modes. Today, school fees can have a major impact on a family’s financial plans and require a financial solution as well. To make it easier and less worrisome for the parents, EmpowerYouth has introduced school fee financing which is beneficial for both parents and schools. We believe everyone has a right to a great education and we can help turn aspirations into reality.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

<?= $this->render('/widgets/benefits-for-parents')?>
<?= $this->render('/widgets/Our-lending-partners');?>
<section class="bg-blue">
    <?= $this->render('/widgets/choose-education-loan') ?>
</section>
<?= $this->render('/widgets/education-loan-faqs');?>
<?php
if($blogs['blogs']){
    echo $this->render('/widgets/education-loan/blogs',[
        'blogs' => $blogs,
        'param' => 'refinance'
    ]);
};
?>
<?= $this->render('/widgets/loan-form-detail',[
    'model' => $model,
    'param' => 'School Fee Finance'
]); ?>
<?= $this->render('/widgets/press-releasee',[
    'data'=>$data,
    'viewBtn' => true,
]) ?>
<?= $this->render('/widgets/loan-strip') ?>
<?php
$this->registerCss('
.footer{
    margin-top: 0 !important;
}
.school-fee-finance{
    margin-bottom: 25px;
}
.school-fee-header{
    background: url(' . Url::to('@eyAssets/images/pages/education-loans/school-fee-header-bg.png') . ');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: bottom center;
}
.school-fee-header{
    min-height: 550px;
}
.school-fee-header .container{
    min-height: inherit;
}
.school-fee-header .row{
    min-height: inherit;
    display: flex;
    align-items: center;
}
.header-text h1{
    font-size: 45px;
    font-family: Roboto;
    font-weight: 500;
    color: #ffff;
    margin-bottom: 0;
}
.header-text p{
    max-width: 530px;
    color: #dddddd;
    font-size: 18px;
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

.school-fee-header .buttons{
    margin-top: 40px;
    display: flex;
    align-items: center;
}
.header-img img{
    width: 70%;
}
.header-img{
    text-align: center;
    margin-top: 70px;
}
.school-fee-info .row{
    display: flex;
    align-items: center;
}
.school-fee-text h2{
    color: #323232;
    font-size: 28pt;
    font-weight: 700;
    font-family: Roboto;
}
.school-fee-text p{
    color: #535353;
    line-height: 23px;
}
@media only screen and (max-width: 767px){
    .header-img img{
        display: none;
    }
    .header-text h1{
        font-size: 25px;
    }
    .header-text p, .enq-now, .apply-now{
        font-size: 14px;
    }
    .school-fee-text h2{
        font-size: 21pt;
    }
    .school-fee-img{
        display: none;
    }
}
@media only screen and (max-width: 992px){
    .school-fee-img img{
        max-width: 275px;
    }
    
    .header-img{
        margin-top: 0;
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