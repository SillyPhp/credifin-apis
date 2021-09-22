<?php

use yii\helpers\Url;

?>
<section class="header-bg">
    <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="job-app-lender-vector">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/undraw-envelope.png') ?>" alt="">
                    </div>
                </div>
                <div class="col-md-8 col-sm-8">
                    <div class="job-app-lender-heading">
                        <h2>We have received your Loan Application.</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="application-sent-heading">
                        <h2>Your Application has been sent to</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="lender-card">
                        <div class="lender-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png') ?>" alt="Agile Finserv">
                        </div>
                        <div class="lender-text">
                            <p>Agile Finserv</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="lender-card">
                        <div class="lender-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png') ?>"
                                 alt="Avanse Financial Services">
                        </div>
                        <div class="lender-text">
                            <p>Avanse Financial Services</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="lender-card">
                        <div class="lender-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png') ?>"
                                 alt="Exclusive Leasing & Finance">
                        </div>
                        <div class="lender-text">
                            <p>Exclusive Leasing & Finance</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="lender-card">
                        <div class="lender-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/incred_logo.png') ?>"
                                 alt="InCred">
                        </div>
                        <div class="lender-text">
                            <p>InCred</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="lender-card">
                        <div class="lender-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/ezcapital.png') ?>" alt="EZ Capital">
                        </div>
                        <div class="lender-text">
                            <p>EZ Capital</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="lender-card">
                        <div class="lender-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/phf-leasing.png') ?>" alt="PHF Leasing">
                        </div>
                        <div class="lender-text">
                            <p>PHF Leasing</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php
$this->registercss('
.header-bg {
    background: linear-gradient(154.01deg, #FF4B1A -3.84%, #E2C952 111.2%);
    border-radius: 8px;
}
.job-app-lender-vector {
    text-align: center;
}
.job-app-lender-vector img {
    width: 100%;
    max-width: 200px;
}
.job-app-lender-heading h2, .application-sent-heading h2 {
    font-family: lora;
    font-size: 28px;
    color: #fff;
    font-weight: 500;
}
.lender-card {
    text-align: center;
    padding: 20px 0;
    margin-bottom: 30px;
    box-shadow: inset 0 0 10px rgb(0 0 0 / 10%);
    background-color: #fff;
    border-radius: 4px;
    overflow: hidden;
}
.lender-logo{
    width: 100%;
    height: 100%;
    margin: auto;
    line-height: 65px;
}
.lender-logo img {
    height: 70px;
    width: 100px;
    object-fit: contain;
}
.lender-text p {
    font-family: roboto;
    color: #000;
    font-size: 18px;
    font-weight: 500;
    margin-top: 20px;
    overflow: hidden;
}
');
