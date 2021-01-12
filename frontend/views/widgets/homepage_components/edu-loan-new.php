<?php

use yii\helpers\Url;

?>

    <section class="bg-loans-set row">
        <div class="col-md-12 row">
            <div class="col-md-10 row">
                <div class="col-md-10 col-md-offset-1 col-sm-10">
                    <div class="heading-data-set">
                        <h3>Don't worry about paying your <br> college fees all at once.</h3>
                        <h4>Choose our easy loan schemes with low interest rate.</h4>
                        <p>Apply in colleges across India & Abroad</p>
                        <div class="loan-btn">
                            <a href="/education-loans">Apply Now!</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 row col-sm-10">
                    <div class="image-topics">
                        <div class="icon-loan">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/low-interest-rate.png') ?>" alt="">
                            <p>Low Rate Of Interest</p>
                        </div>
                        <div class="icon-loan">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/quick-disbursment.png') ?>" alt="">
                            <p>Quick Disbursement</p>
                        </div>
                        <div class="icon-loan">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/online-application.png') ?>" alt="">
                            <p>Online Application</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.image-topics{
    background:url(' . Url::to('@eyAssets/images/pages/education-loans/blue-shape.png') . ');
    background-size: cover;
    width: 90%;
    max-width: 600px;
    padding: 20px;
}
.icon-loan {
    display: inline-block;
    margin: 0 15px;
    text-align: center;
}
.icon-loan img {
    width: 90px;
    height: 90px;
    object-fit: contain;
}
.icon-loan p {
    margin: 10px 0 0;
    color: #fff;
    font-family: Roboto;
}
.bg-loans-set{
    background:url(' . Url::to('@eyAssets/images/pages/education-loans/edu-loan-widget-bg.png') . ');
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
.heading-data-set {
	padding: 25px 0 35px;
}
.heading-data-set h3 {
	font-size: 38px;
	color: #212d4b;
	font-family: lora;
	font-weight: 700;
	line-height: 46px;
}
.heading-data-set h4 {
	font-size: 18px;
	font-family: roboto;
	margin: 0;
}
.heading-data-set p {
    font-size: 18px;
    font-family: roboto;
}
.loan-btn a {
	color: #fff;
	background-color:#212d4b;
	font-size: 16px;
	font-family: roboto;
	border: 2px solid #212d4b;
	padding: 4px 15px;
	border-radius: 4px;
	display: inline-block;
	transition:ease-in-out .2s;
}
.loan-btn a:hover{
    color:#212d4b;
    background-color:#fff;
}
@media only screen and (max-width: 992px) {
.heading-data-set h3 {
    font-size: 30px;
    }
.heading-data-set p, .heading-data-set h4 {
    font-size: 16px;
}
}
@media only screen and (max-width: 768px) {
.bg-loans-set{
    background-position:left;
}
.heading-data-set h3 {
    font-size: 25px;
}
.image-topics img {
    width: 90%;
}
}
@media only screen and (max-width: 550px) {
.image-topics{text-align:center;width:100%;}
.icon-loan{margin-bottom:15px;}
}
');
