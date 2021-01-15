<?php

use yii\helpers\Url;

?>

    <section class="bg-loans-set">
        <div class="row m0">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="loanSchemesFlex">
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-md-11 col-md-offset-1 col-sm-12">
                                <div class="heading-data-set">
                                    <h3>DON'T WORRY ABOUT PAYING YOUR <br> COLLEGE FEES ALL AT ONCE.</h3>
                                    <h4>Choose our easy loan schemes with low interest rate.</h4>
                                    <p>Apply in colleges across India & Abroad</p>
                                    <div class="loan-btn">
                                        <a href="/education-loans">Apply Now!</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
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
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="student-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/edu-loan-cibil.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.image-topics{
    background:url(' . Url::to('@eyAssets/images/pages/education-loans/orangeshape.png') . ');
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
.loanSchemesFlex{
    display: flex;
    align-items: flex-end;
    flex-wrap: wrap;
    margin: 0 -15px;
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
    background-color: #fff;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
.heading-data-set {
	padding: 25px 0 35px;
}
.m0{
    margin-left: 0px;
    margin-right: 0px; 
}
.heading-data-set h3 {
	font-size: 38px;
    color: #ED6D1E;
    font-family: roboto;
    font-weight: 600;
    line-height: 46px;
}
.heading-data-set h4 {
	font-size: 20px;
    font-family: lora;
    color: #000;
    font-weight: 600;
    margin: 0;
}
.heading-data-set p {
    font-size: 18px;
    font-family: roboto;
}
.loan-btn a {
	color: #fff;
	background-color:#ED6D1E;
	font-size: 16px;
	font-family: roboto;
	border: 2px solid #ED6D1E;
	padding: 4px 15px;
	border-radius: 4px;
	display: inline-block;
	transition:ease-in-out .2s;
}
.loan-btn a:hover{
    color:#ED6D1E;
    background-color:#fff;
}
.student-icon{
    display: flex;
    align-items: baseline;
    justify-content: center;
    max-height: 450px;
}
.student-icon img{
    padding: 35px 50px 0 0;   
}
@media only screen and (max-width: 992px) {
    .heading-data-set h3 {
        font-size: 30px;
    }
    .heading-data-set p, .heading-data-set h4 {
        font-size: 16px;
    }
    .student-icon img{
        padding-left: 0px; 
    }
    .student-icon img{
        max-width: 300px;
    }
}
@media only screen and (max-width: 768px) {
    .bg-loans-set{
        background-position:left;
    }
    .heading-data-set h3 {
        font-size: 25px;
    }
    .image-topics{
        background: #ed6d1e;
        width: 100%;
        max-width: unset;
    }
    .image-topics img {
        width: 90%;
    }
}
@media only screen and (max-width: 550px) {
.image-topics{text-align:center;width:100%;}
.icon-loan{margin-bottom:15px;}
.student-icon img{
    max-width: 300px;
}

}
');
