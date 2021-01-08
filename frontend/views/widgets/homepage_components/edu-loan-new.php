<?php

use yii\helpers\Url;

?>

    <section class="row">
        <div class="container">
            <div class="col-md-12 bg-loans-set">
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
                    <div class="col-md-8 row col-sm-8" style="padding: 0;">
                        <div class="image-topics">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/edu-loan-icons.png') ?>"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.bg-loans-set{
    background:url(' . Url::to('@eyAssets/images/pages/education-loans/edu-loan-bg.png') . ');
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    margin:10px 0 30px;
}
.heading-data-set {
	padding: 20px 0;
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
	color: #212d4b;
	font-size: 16px;
	font-family: roboto;
	border: 2px solid #212d4b;
	padding: 4px 15px;
	border-radius: 4px;
	display: inline-block;
	transition:ease-in-out .2s;
}
.loan-btn a:hover{
    color:#fff;
    background-color:#212d4b;
}
.image-topics img {
    width: 80%;
}
@media only screen and (max-width: 992px) {
.heading-data-set h3 {
    font-size: 30px;
    }
.heading-data-set p, .heading-data-set h4 {
    font-size: 16px;
}
}
@media only screen and (max-width: 992px) {
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
');
