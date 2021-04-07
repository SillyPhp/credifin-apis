<?php

use yii\helpers\Url;

?>
    <section class="study-in-usa-bg">
        <div class="opacity-div"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>
                    <span class="typewrite" data-period="2000"
                          data-type='["Know from top news platforms about our Education Loan scheme."]'>
                        <span class="wrap"></span>
                    </span>
                    </h1>
                </div>
            </div>
        </div>
    </section>
<div class="pdtop"></div>

<?= $this->render('/widgets/press-releasee', [
    'data' => $data
]) ?>

<?php
$this->registerCss('
.pdtop {
    padding-top: 25px;
    background-color: #ecf3fb;
}
.footer {
    margin-top: 0px !important;
}
.study-in-usa-bg h1 {
    font-size: 38px;
    color: #fff;
    font-weight: 700;
    font-family: roboto;
    text-align: center;
}
.study-in-usa-bg {
    background: url(' . Url::to('@eyAssets/images/pages/education-loans/as-seen-in-news.png') . ');
	min-height: 500px;
	background-repeat: no-repeat;
	background-size: cover;
	display: flex;
	align-items: center;
	position: relative;
	max-height: 700px;
	background-position: right top;
}
.opacity-div{
    position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,.5);
}
.seen-txt h1 {
    font-size: 30px;
    font-family: roboto;
    color: #fff;
    font-weight: 600;
}
');
JS;
$this->registerJS($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

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
